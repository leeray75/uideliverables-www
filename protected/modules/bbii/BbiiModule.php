<?php

class BbiiModule extends CWebModule {
	public $defaultController = 'forum';
	public $adminId = false;				// must be overridden to assign admin rights to user id
	public $avatarStorage = '/www/avatar'; 		// directory in the webroot must exist and allow read/write access
	public $forumTitle = 'UI Deliverables Forum';
	public $userClass = 'User';
	public $userIdColumn = 'id';
	public $userNameColumn = 'username';
	public $userMailColumn = false;
//	public $userActiveScope = 'active';
	
	private $_assetsUrl;
	
	public function init() {
		$this->registerAssets();
		
		Yii::app()->setComponents(
			array(
				'messages' => array(
					'class'=>'CPhpMessageSource',
					'basePath'=>'protected/modules/bbii/messages',
				),
				'errorHandler'=>array(
					'errorAction'=>'forum/forum/error',
				),
			)
		);
		
		// import the module-level models and components
		$this->setImport(array(
			'forum.models.*',
			'forum.components.*',
		));
	}
	
    /**
     * @return string base URL that contains all published asset files of this module.
     */
    public function getAssetsUrl() {
		if($this->_assetsUrl == null) {
            $this->_assetsUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('forum.assets')
				// Comment the line below out in production.
				,false,-1,true
			);
		}
        return $this->_assetsUrl;
    }
	
	/**
	 * Register the CSS and JS files for the module
	 */
	public function registerAssets() {
		Yii::app()->clientScript->registerCssFile($this->getAssetsUrl() . '/css/bbii.css');
		//Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
		Yii::app()->clientScript->registerScriptFile($this->getAssetsUrl() . '/js/bbii.js', CClientScript::POS_HEAD);
	}
	
	/**
	 * Retrieve url of image in the assets
	 * @param string filename of the image
	 * @return string source URL of image
	 */
	public function getRegisteredImage($filename) {
		return $this->getAssetsUrl() .'/images/'. $filename;
    }

	
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action)) {
			// this method is called before any module controller action is performed
			// you may place customized code here
			
			// register last visit by member
			if(Yii::app()->user->id) {
				$model = BbiiMember::model()->findByPk(Yii::app()->user->id);
				if($model !== null) {
					$model->last_visit 	= date('Y-m-d H:i:s');
					$model->save();
				} else {
					$criteria = new CDbCriteria;
					$criteria->condition = $this->userIdColumn . '=:id';
					$criteria->params = array(':id'=>Yii::app()->user->id);
					$class = new $this->userClass;
					$user = $class::model()->find($criteria);
					$username = $user->getAttribute($this->userNameColumn);
					$model = new BbiiMember;
					$model->id 			= Yii::app()->user->id;
					$model->member_name = $username;
					$model->first_visit = date('Y-m-d H:i:s');
					$model->last_visit 	= date('Y-m-d H:i:s');
					$model->save();
				}
			}
			// register visit by guest
			$model = BbiiSession::model()->findByPk(session_id());
			if($model === null) {
				$model = new BbiiSession;
				$model->id = session_id();
			}
			$model->save();
			// delete older session entries
			$criteria = new CDbCriteria;
			$criteria->condition = 'last_visit < "' . date('Y-m-d H:i:s', (time() - 24*3600)). '"';
			BbiiSession::model()->deleteAll($criteria);
			return true;
		}
		else
			return false;
	}
}
