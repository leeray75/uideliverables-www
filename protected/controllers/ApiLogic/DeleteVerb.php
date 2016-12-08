<?php
	$authorized = false;
		switch($_GET['model'])
		{
			// Load the respective model
			case 'events':
				$model = Event::model()->findByPk($_GET['id']);
				$authorized = (Yii::app()->user->isAdmin() or ($model->user_id!=0 && $model->user_id == Yii::app()->user->id));
				                
				break;
			case 'movies':
				$model = Movie::model()->findByPk($_GET['id']);  
				$authorized = (Yii::app()->user->isAdmin() or $model->user_id == Yii::app()->user->id);                  
				break;
			default:
				$this->_sendResponse(501, 
					sprintf('Error: Mode <b>delete</b> is not implemented for model <b>%s</b>',
					$_GET['model']) );
				Yii::app()->end();
		}
		// Was a model found? If not, raise an error
		if($model === null)
		{
			$this->_sendResponse(400, 
					sprintf("Error: Didn't find any model <b>%s</b> with ID <b>%s</b>.",
					$_GET['model'], $_GET['id']) );
		}
		else if( $authorized ===false) // (!Yii::app()->user->isAdmin() && ($model->user_id==0) or ($model->user_id != Yii::app()->user->id));    
		{
			$this->_sendResponse(401, "Unauthorized Update! test " );
		}		
		else
		{
			// Delete the model
		
			$num = $model->delete();
			if($num>0)
				$this->_sendResponse(200, $num);    //this is the only way to work with backbone
			else
				$this->_sendResponse(500, 
						sprintf("Error: Couldn't delete model <b>%s</b> with ID <b>%s</b>.",
						$_GET['model'], $_GET['id']) );
		}
?>