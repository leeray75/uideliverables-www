<?php
// Parse the PUT parameters. This didn't work: parse_str(file_get_contents('php://input'), $put_vars);
		//$json = file_get_contents('php://input'); //$GLOBALS['HTTP_RAW_POST_DATA'] is not preferred: http://www.php.net/manual/en/ini.core.php#ini.always-populate-raw-post-data
		//$put_vars = CJSON::decode($json,true);  //true means use associative array

	 	$put_vars = json_decode(file_get_contents('php://input'), true);
		$checkUser = true;
		switch($_GET['model'])
		{
			// Find respective model
			case 'events':
				$model = Event::model()->findByPk($_GET['id']);        
				break;
			case 'movies':
				//$model = Movie::model()->findByPk($_GET['id']);        
				$model = Movie::model()->findByAttributes(array('id'=>$_GET['id']));
				break;
			case 'vote':
				$model = MoviesVotes::model()->findByAttributes(array('movie_id'=>$_GET['id']));
				$checkUser = false;
				break;			
			default:
				$this->_sendResponse(501, 
					sprintf( 'Error: Mode <b>update</b> is not implemented for model <b>%s</b>',
					$_GET['model']) );
				Yii::app()->end();
		}
		// Did we find the requested model? If not, raise an error
		if($model === null)
			$this->_sendResponse(400, 
					sprintf("Error: Didn't find any model <b>%s</b> with ID <b>%s</b>.",
					$_GET['model'], $_GET['id']) );
	 
	 	
		// Try to assign PUT parameters to attributes
		foreach($put_vars as $var=>$value) {
			// Does model have this attribute? If not, raise an error
			if($model->hasAttribute($var))
				$model->$var = $value;
			else {
				$this->_sendResponse(500, 
					sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>',
					$var, $_GET['model']) );
			}
		}
		// Try to save the model
		if($checkUser && ($model->user_id != Yii::app()->user->id) && !Yii::app()->user->isAdmin())
		{
			$this->_sendResponse(401, "Unauthorized Update!" );
		}
		else if($model->save())
			$this->_sendResponse(200, CJSON::encode($model), 'application/json');
		else
			// prepare the error $msg
			// see actionCreate
			// ...
			$this->_sendResponse(500, $msg );
?>