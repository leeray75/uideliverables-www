<?php

class ModeratorController extends BbiiController {
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('admin','approval','approve','banIp','changeTopic','delete','ipAdmin','ipDelete','view','refreshTopics','report','topic'),
				'users'=>array('@'),
				'expression'=>($this->isModerator())?'true':'false',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionApproval() {
		$model=new BbiiPost('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BbiiMessage'])) {
			$model->attributes=$_GET['BbiiPost'];
		}
		// restrict filtering to unapproved posts
		$model->approved = 0;

		$this->render('approval', array(
			'model'=>$model, 
		));
	}
	
	public function actionApprove($id) {
		$post = BbiiPost::model()->findByPk($id);
		if($post === null) {
			throw new CHttpException(404, Yii::t('bbii', 'The requested post does not exist.'));
		}
		$forum = BbiiForum::model()->findByPk($post->forum_id);
		$topic = BbiiTopic::model()->findByPk($post->topic_id);
		if($topic->approved == 0) {
			$topic->approved = 1;
			$topic->update();
			$forum->saveCounters(array('num_topics'=>1));	// method since Yii 1.1.8
		} else {
			$topic->saveCounters(array('num_replies'=>1));				// method since Yii 1.1.8
		}
		$topic->saveAttributes(array('last_post_id'=>$post->id));
		$forum->saveAttributes(array('last_post_id'=>$post->id));
		$post->approved = 1;
		$post->update();
		$forum->saveCounters(array('num_posts'=>1));		// method since Yii 1.1.8
		$post->poster->saveCounters(array('posts'=>1));		// method since Yii 1.1.8
		$this->assignMembergroup($post->user_id);
		
		$this->redirect(array('approval'));
	}
	
	public function actionAdmin() {
		$model=new BbiiPost('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BbiiPost']))
			$model->attributes=$_GET['BbiiPost'];
		// limit posts to approved posts
		$model->approved = 1;
		
		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionIpAdmin()
	{
		$model=new BbiiIpaddress('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BbiiIpaddress']))
			$model->attributes=$_GET['BbiiIpaddress'];

		$this->render('ipadmin',array(
			'model'=>$model,
		));
	}
	
	public function actionIpDelete($id) {
		BbiiIpaddress::model()->findByPk($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('ipadmin'));
	}

	/**
	 * Delete a post
	 */
	public function actionDelete($id) {
		if(isset($_GET['id']))
			$id = $_GET['id'];
		$post = BbiiPost::model()->findByPk($id);
		if($post === null) {
			throw new CHttpException(404, Yii::t('bbii', 'The requested post does not exist.'));
		}
		$forum = BbiiForum::model()->findByPk($post->forum_id);
		$topic = BbiiTopic::model()->findByPk($post->topic_id);
		$post->poster->saveCounters(array('posts'=>-1));					// method since Yii 1.1.8
		$post->delete();
		if($topic->approved == 0) {
			$topic->delete();
		} else {
			$forum->saveCounters(array('num_posts'=>-1));					// method since Yii 1.1.8
			if($topic->num_replies > 0) {
				$topic->saveCounters(array('num_replies'=>-1));				// method since Yii 1.1.8
			} else {
				$topic->delete();
				$forum->saveCounters(array('num_topics'=>-1));				// method since Yii 1.1.8
			}
		}
		$this->resetLastPost($id);
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('approval'));
		return;
	}
	
	/**
	 * Reset the last post of a topic and a forum when post is deleted
	 */
	private function resetLastPost($id) {
		$criteria = new CDbCriteria;
		$criteria->condition = "last_post_id = $id";
		$forum = BbiiForum::model()->find($criteria);
		$topic = BbiiTopic::model()->find($criteria);
		if($forum !== null) {
			$criteria->condition = "forum_id = $forum->id";
			$criteria->order = 'id DESC';
			$criteria->limit = 1;
			$post = BbiiPost::model()->find($criteria);
			if($post === null) {
				$forum->last_post_id = null;
			} else {
				$forum->last_post_id = $post->id;
			}
			$forum->update();
		}
		if($topic !== null) {
			$criteria->condition = "topic_id = $topic->id";
			$criteria->order = 'id DESC';
			$criteria->limit = 1;
			$post = BbiiPost::model()->find($criteria);
			if($post === null) {
				$topic->last_post_id = null;
			} else {
				$topic->last_post_id = $post->id;
			}
			$topic->update();
		}
	}
	
	public function actionReport() {
		$model=new BbiiMessage('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BbiiMessage']))
			$model->attributes=$_GET['BbiiMessage'];
		// limit posts to moderator inbox
		$model->sendto = 0;
		
		$this->render('report',array(
			'model'=>$model,
		));
	}
	
	public function actionView() {
		$json = array();
		if(isset($_POST['id'])) {
			$model = BbiiPost::model()->findByPk($_POST['id']);
			if($model !== null) {
				$json['success'] = 'yes';
				$json['html'] = $this->renderPartial('_view', array('model' => $model), true);
			} else {
				$json['success'] = 'no';
				$json['message'] = Yii::t('bbii', 'Post not found.');
			}
		} else {
			$json['success'] = 'no';
			$json['message'] = Yii::t('bbii', 'Post not found.');
		}
		echo json_encode($json);
		Yii::app()->end();
	}
	
	public function actionTopic() {
		$json = array();
		if(isset($_POST['id'])) {
			$model = BbiiTopic::model()->findByPk($_POST['id']);
			if($model === null) {
				$json['success'] = 'no';
				$json['message'] = Yii::t('bbii', 'Topic not found.');
			} else {
				$json['success'] = 'yes';
				$json['forum_id'] = $model->forum_id;
				$json['title'] = $model->title;
				$json['locked'] = $model->locked;
				$json['sticky'] = $model->sticky;
				$json['global'] = $model->global;
				$json['option'] = '<option value=""></option>';
				foreach(BbiiTopic::model()->findAll("forum_id = $model->forum_id") as $topic) {
					$json['option'] .= '<option value="' . $topic->id. '">' . $topic->title . '</option>';
				}
			}
		} else {
			$json['success'] = 'no';
			$json['message'] = Yii::t('bbii', 'Topic not found.');
		}
	
		echo json_encode($json);
		Yii::app()->end();
	}
	
	/**
	 * Ajax call for retrieving option list of topics of a forum
	 */
	public function actionRefreshTopics() {
		$json = array();
		if(isset($_POST['id'])) {
			$json['success'] = 'yes';
			$json['option'] = '<option value=""></option>';
			foreach(BbiiTopic::model()->findAll('forum_id = ' . $_POST['id']) as $topic) {
				$json['option'] .= '<option value="' . $topic->id. '">' . $topic->title . '</option>';
			}
		} else {
			$json['success'] = 'no';
			$json['message'] = Yii::t('bbii', 'Topic not found.');
		}
	
		echo json_encode($json);
		Yii::app()->end();
	}
	
	/**
	 * Ajax call for change, move or merge topic
	 */
	public function actionChangeTopic() {
		$json = array();
		if(isset($_POST['BbiiTopic'])) {
			$model = BbiiTopic::model()->findByPk($_POST['BbiiTopic']['id']);
			$move = false;
			$merge = false;
			$sourceTopicId = $_POST['BbiiTopic']['id'];
			$sourceForumId = $model->forum_id;
			if($model->forum_id != $_POST['BbiiTopic']['forum_id']) {
				$move = true;
				$targetForumId = $_POST['BbiiTopic']['forum_id'];
			}
			if(!empty($_POST['BbiiTopic']['merge']) && $_POST['BbiiTopic']['id'] != $_POST['BbiiTopic']['merge']) {
				$merge = true;
				$targetTopicId = $_POST['BbiiTopic']['merge'];
			}
			$model->attributes=$_POST['BbiiTopic'];
			if($model->validate()) {
				$json['success'] = 'yes';
				if($merge || $move) {
					if($move) {
						$numberOfPosts = BbiiPost::model()->updateAll(array('forum_id'=>$targetForumId), "forum_id = $sourceForumId");
						$forum = BbiiForum::model()->findByPk($sourceForumId);
						$forum->saveCounters(array('num_topics'=>-1));				// method since Yii 1.1.8
						$forum->saveCounters(array('num_posts'=>-$numberOfPosts));	// method since Yii 1.1.8
						$forum = BbiiForum::model()->findByPk($targetForumId);
						$forum->saveCounters(array('num_topics'=>1));				// method since Yii 1.1.8
						$forum->saveCounters(array('num_posts'=>$numberOfPosts));	// method since Yii 1.1.8
					}
					if($merge) {
						$numberOfPosts = BbiiPost::model()->updateAll(array('topic_id'=>$targetTopicId), "topic_id = $sourceTopicId");
						if($move) {
							$forum = BbiiForum::model()->findByPk($targetForumId);
						} else {
							$forum = BbiiForum::model()->findByPk($sourceForumId);
						}
						$forum->saveCounters(array('num_topics'=>-1));				// method since Yii 1.1.8
						$topic = BbiiTopic::model()->findByPk($targetTopicId);
						$topic->saveCounters(array('num_replies'=>$numberOfPosts));	// method since Yii 1.1.8
						$model->delete();
					} else {
						$model->save();
					}
				} else {	// no move or merge involved
					$model->save();
				}
			} else {
				$json['error'] = json_decode(CActiveForm::validate($model));
			}
		}
		echo json_encode($json);
		Yii::app()->end();
	}
	
	public function actionBanIp($id) {
		$post = BbiiPost::model()->findByPk($id);
		if($post === null) {
			throw new CHttpException(404, Yii::t('bbii', 'The requested post does not exist.'));
		}
		$ip = new BbiiIpaddress;
		$ip->ip = $post->ip;
		$ip->save();
		return;
	}
	
	private function assignMembergroup($id) {
		$member = BbiiMember::model()->findByPk($id);
		if(BbiiMembergroup::model()->exists('min_posts = ' . $member->posts)) {
			$member->group_id = BbiiMembergroup::model()->find('min_posts = ' . $member->posts)->id;
			$member->save();
		}
	}
}