<?php

class ForumController extends BbiiController {
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
				'actions'=>array('createTopic', 'quote', 'reply', 'update', 'markAllRead'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('error', 'index', 'forum', 'topic'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionIndex() {
		$model = array();
		$categories = BbiiForum::model()->category()->sorted()->findAll();
		foreach($categories as $category) {
			if(Yii::app()->user->isGuest) {
				$forums = BbiiForum::model()->forum()->public()->sorted()->findAll("cat_id = $category->id");
			} else {
				$forums = BbiiForum::model()->forum()->sorted()->findAll("cat_id = $category->id");
			}
			if(count($forums)) {
				$model[] = $category;
				foreach($forums as $forum) {
					$model[] = $forum;
				}
			}
		}
		$dataProvider=new CArrayDataProvider($model, array(
			'id'=>'forum',
			'pagination'=>false,
		));
		$this->render('index', array('dataProvider'=>$dataProvider));
	}
	
	public function actionMarkAllRead() {
		$topics = BbiiTopic::model()->findAll();
		foreach($topics as $topic) {
			$topicLog = BbiiLogTopic::model()->findByPk(array('member_id'=>Yii::app()->user->id, 'topic_id'=>$topic->id));
			if($topicLog === null) {
				$topicLog = new BbiiLogTopic;
				$topicLog->member_id = Yii::app()->user->id;
				$topicLog->topic_id = $topic->id;
				$topicLog->forum_id = $topic->forum_id;
			}
			$topicLog->last_post_id = $topic->last_post_id;
			$topicLog->save();
		}
		$this->redirect(array('index'));
	}
	
	public function actionForum($id) {
		$forum = BbiiForum::model()->findByPk($id);
		if($forum === null) {
			throw new CHttpException(404, Yii::t('bbii', 'The requested forum does not exist.'));
		}
		$dataProvider=new CActiveDataProvider('BbiiTopic', array(
			'criteria'=>array(
				'condition'=>'approved = 1 and (forum_id=' . $forum->id . ' or global = 1)',
				'order'=>'global DESC, sticky DESC, last_post_id DESC',
				'with'=>array('starter'),
			),
			'pagination'=>array(
				'pageSize'=>20,
			),
		));
		$this->render('forum', array(
			'forum' => $forum,
			'dataProvider' => $dataProvider
		));
	}
	
	public function actionTopic($id, $nav = null) {
		$topic = BbiiTopic::model()->findByPk($id);
		if($topic === null) {
			throw new CHttpException(404, Yii::t('bbii', 'The requested topic does not exist.'));
		}
		$topic->saveCounters(array('num_views'=>1));					// method since Yii 1.1.8
		$forum = BbiiForum::model()->findByPk($topic->forum_id);
		$dataProvider=new CActiveDataProvider('BbiiPost', array(
			'criteria'=>array(
				'condition'=>'approved = 1 and topic_id=' . $topic->id,
				'order'=>'t.id',
				'with'=>array('poster'),
			),
			'pagination'=>array(
				'pageSize'=>20,
			),
		));
		if(isset($nav)) {
			$postIdArray = $dataProvider->getKeys();
			$cPage = $dataProvider->getPagination();
			if(is_numeric($nav)) {
				$index = array_search($nav, $postIdArray);
				if($index === false) {
					$index = 1;
				} else {
					$index++;
				}
				$cPage->setCurrentPage(ceil($index/$cPage->pageSize) - 1);
			} else {
				$cPage->setCurrentPage(ceil($dataProvider->totalItemCount/$cPage->pageSize) - 1);
				$nav = end($postIdArray);
			}
			$dataProvider->setPagination($cPage);
		}
		if(!Yii::app()->user->isGuest) {
			$topicLog = BbiiLogTopic::model()->findByPk(array('member_id'=>Yii::app()->user->id, 'topic_id'=>$topic->id));
			if($topicLog === null) {
				$topicLog = new BbiiLogTopic;
				$topicLog->member_id = Yii::app()->user->id;
				$topicLog->topic_id = $topic->id;
				$topicLog->forum_id = $topic->forum_id;
			}
			$topicLog->last_post_id = $topic->last_post_id;
			$topicLog->save();
		}
		$this->render('topic', array(
			'forum' => $forum,
			'topic' => $topic,
			'dataProvider' => $dataProvider,
			'postId' => $nav
		));
	}
	
	/**
	 * Quote the original post in the reply (reply to a post)
	 * @param $id integer post_id
	 */
	public function actionQuote($id) {
		$quoted = BbiiPost::model()->findByPk($id);
		if($quoted === null) {
			throw new CHttpException(404, Yii::t('bbii', 'The requested post does not exist.'));
		}
		$forum = BbiiForum::model()->findByPk($quoted->forum_id);
		$topic = BbiiTopic::model()->findByPk($quoted->topic_id);
		if(isset($_POST['BbiiPost'])) {
			$post = new BbiiPost;
			$post->attributes = $_POST['BbiiPost'];
			$post->user_id = Yii::app()->user->id;
			if($forum->moderated) {
				$post->approved = 0;
			} else {
				$post->approved = 1;
			}
			if($post->save()) {
				if($post->approved) {
					$forum->saveCounters(array('num_posts'=>1));					// method since Yii 1.1.8
					$topic->saveCounters(array('num_replies'=>1));					// method since Yii 1.1.8
					$topic->saveAttributes(array('last_post_id'=>$post->id));
					$forum->saveAttributes(array('last_post_id'=>$post->id));
					$post->poster->saveCounters(array('posts'=>1));					// method since Yii 1.1.8
					$this->assignMembergroup(Yii::app()->user->id);
				} else {
					Yii::app()->user->setFlash('moderation',Yii::t('bbii', 'Your post has been saved. It has been placed in a queue and is now waiting for approval by a moderator before it will appear on the forum. Thank you for your contribution to the forum.'));
				}
				$this->redirect(array('topic', 'id'=>$post->topic_id, 'nav'=>'last'));
			}
		} else {
			$post = new BbiiPost;
			$quote = $quoted->poster->member_name .' '. Yii::t('bbii', 'wrote') .' '. Yii::t('bbii', 'on') .' '. DateTimeCalculation::longDate($quoted->create_time);
			$post->content = '<blockquote cite="'. $quote .'"><p><strong>'. $quote .'</strong></p>' . $quoted->content . '</blockquote><p></p>';
			$post->subject  = $quoted->subject;
			$post->forum_id = $quoted->forum_id;
			$post->topic_id = $quoted->topic_id;
		}
		$this->render('reply', array(
			'forum' => $forum,
			'topic' => $topic,
			'post' => $post
		));
	}
	
	/**
	 * Reply to a topic
	 * @param $id integer topic_id
	 */
	public function actionReply($id) {
		$topic = BbiiTopic::model()->findByPk($id);
		if($topic === null) {
			throw new CHttpException(404, Yii::t('bbii', 'The requested topic does not exist.'));
		}
		$forum = BbiiForum::model()->findByPk($topic->forum_id);
		$post = new BbiiPost;
		if(isset($_POST['BbiiPost'])) {
			$post->attributes = $_POST['BbiiPost'];
			$post->user_id = Yii::app()->user->id;
			if($forum->moderated) {
				$post->approved = 0;
			} else {
				$post->approved = 1;
			}
			if($post->save()) {
				if($post->approved) {
					$forum->saveCounters(array('num_posts'=>1));					// method since Yii 1.1.8
					$topic->saveCounters(array('num_replies'=>1));					// method since Yii 1.1.8
					$topic->saveAttributes(array('last_post_id'=>$post->id));
					$forum->saveAttributes(array('last_post_id'=>$post->id));
					$post->poster->saveCounters(array('posts'=>1));					// method since Yii 1.1.8
					$this->assignMembergroup(Yii::app()->user->id);
				} else {
					Yii::app()->user->setFlash('moderation',Yii::t('bbii', 'Your post has been saved. It has been placed in a queue and is now waiting for approval by a moderator before it will appear on the forum. Thank you for your contribution to the forum.'));
				}
				$this->redirect(array('topic', 'id'=>$post->topic_id, 'nav'=>'last'));
			}
		} else {
			$post->subject = $topic->title;
			$post->forum_id = $forum->id;
			$post->topic_id = $topic->id;
		}
		$this->render('reply', array(
			'forum' => $forum,
			'topic' => $topic,
			'post' => $post
		));
	}
	
	public function actionCreateTopic() {
		$post = new BbiiPost;
		if(isset($_POST['BbiiForum'])) {
			$post->forum_id = $_POST['BbiiForum']['id'];
			$forum = BbiiForum::model()->findByPk($post->forum_id);
		}
		if(isset($_POST['BbiiPost'])) {
			$post->attributes = $_POST['BbiiPost'];
			$forum = BbiiForum::model()->findByPk($post->forum_id);
			if($forum->moderated) {
				$post->approved = 0;
			} else {
				$post->approved = 1;
			}
			if($post->save()) {
				$topic = new BbiiTopic;
				$topic->forum_id 		= $forum->id;
				$topic->title 			= $post->subject;
				$topic->first_post_id 	= $post->id;
				$topic->last_post_id 	= $post->id;
				$topic->approved 		= $post->approved;
				if(isset($_POST['sticky'])) { $topic->sticky = 1; }
				if(isset($_POST['global'])) { $topic->global = 1; }
				if(isset($_POST['locked'])) { $topic->locked = 1; }
				if($topic->save()) {
					$post->topic_id 	= $topic->id;
					$post->update();
					if(!$forum->moderated) {
						$forum->saveCounters(array('num_posts'=>1,'num_topics'=>1));	// method since Yii 1.1.8
						$post->poster->saveCounters(array('posts'=>1));					// method since Yii 1.1.8
						$forum->last_post_id = $post->id;
						$forum->update();
						$this->assignMembergroup(Yii::app()->user->id);
					} else {
						Yii::app()->user->setFlash('moderation',Yii::t('bbii', 'Your post has been saved. It has been placed in a queue and is now waiting for approval by a moderator before it will appear on the forum. Thank you for your contribution to the forum.'));
					}
					$this->redirect(array('topic', 'id'=>$topic->id));
				} else {
					$post->delete();
				}
			}
		}
		$this->render('create', array(
			'forum' => $forum,
			'post' => $post
		));
	}
	
	public function actionUpdate($id) {
		$post = BbiiPost::model()->findByPk($id);
		if($post === null) {
			throw new CHttpException(404, Yii::t('bbii', 'The requested post does not exist.'));
		}
		$forum = BbiiForum::model()->findByPk($post->forum_id);
		$topic = BbiiTopic::model()->findByPk($post->topic_id);
		if(isset($_POST['BbiiPost'])) {
			$post->attributes = $_POST['BbiiPost'];
			$post->change_id = Yii::app()->user->id;
			if($forum->moderated) {
				$post->approved = 0;
			} else {
				$post->approved = 1;
			}
			if($post->save()) {
				if(!$post->approved) {
					$forum->saveCounters(array('num_posts'=>-1));					// method since Yii 1.1.8
					if($topic->num_replies > 0) {
						$topic->saveCounters(array('num_replies'=>-1));				// method since Yii 1.1.8
					} else {
						$topic->approved = 0;
						$topic->update();
						$forum->saveCounters(array('num_topics'=>-1));				// method since Yii 1.1.8
					}
					$post->poster->saveCounters(array('posts'=>-1));				// method since Yii 1.1.8
				}
				$this->redirect(array('topic', 'id'=>$post->topic_id));
			}
		}
		$this->render('update', array(
			'forum' => $forum,
			'topic' => $topic,
			'post' => $post
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
	/**
	 * Determine whether a forum is completely read by a user
	 * @param integer forum id
	 * @return boolean
	 */
	public function forumIsRead($forum_id) {
		if(Yii::app()->user->isGuest) {
			return false;
		} else {
			$criteria = new CDbCriteria;
			$criteria->condition = "forum_id = $forum_id";
			$criteria->order = 'last_post_id DESC';
			$criteria->limit = 100;
			$models = BbiiTopic::model()->findAll($criteria);
			$result = true;
			foreach($models as $topic) {
				$topicLog = BbiiLogTopic::model()->findByPk(array('member_id'=>Yii::app()->user->id, 'topic_id'=>$topic->id));
				if($topicLog === null) {
					$result = false;
					break;
				} else {
					if($topic->last_post_id > $topicLog->last_post_id) {
						$result = false;
						break;
					}
				}
			}
			return $result;
		}
	}
	
	/**
	 * Determine whether a topic is completely read by a user
	 * @param integer forum id
	 * @return boolean
	 */
	public function topicIsRead($topic_id) {
		if(Yii::app()->user->isGuest) {
			return false;
		} else {
			$topicLog = BbiiLogTopic::model()->findByPk(array('member_id'=>Yii::app()->user->id, 'topic_id'=>$topic_id));
			if($topicLog === null) {
				return false;
			} else {
				$lastPost = BbiiTopic::model()->cache(300)->findByPk($topic_id)->last_post_id;
				if($lastPost > $topicLog->last_post_id) {
					return false;
				} else {
					return true;
				}
			}
		}
	}
	
	private function assignMembergroup($id) {
		$member = BbiiMember::model()->findByPk($id);
		if(BbiiMembergroup::model()->exists('min_posts = ' . $member->posts)) {
			$member->group_id = BbiiMembergroup::model()->find('min_posts = ' . $member->posts)->id;
			$member->save();
		}
	}
}