<?php
// Get the respective model instance
		//header('Content-type: application/json');
		//echo "model: ".$_GET['model'];
		switch($_GET['model'])
		{
			case 'events':
				$all_models = Event::model()->findAll('user_id = 0');		
				$user_models = new stdClass();	// empty object
				if(!Yii::app()->user->isGuest)
				{
					$user_models = Event::model()->findAll('user_id = '.Yii::app()->user->id);	
					$models = array_merge($all_models,$user_models);		
				}
				else
				{
					$models = $all_models;
				}

				break;
			case 'movies':
				$all_models = Movie::model()->findAll();		
				$user_models = new stdClass();	// empty object
				$models = $all_models;				
				break;
			case 'MoviesView':
				$all_models = MoviesView::model()->findAll();		
				$user_models = new stdClass();	// empty object
				$models = $all_models;				
				break;
			default:
				// Model not implemented error
				$this->_sendResponse(501);
				Yii::app()->end();
		}
		// Did we get some results?
		if(empty($models)) {
			// No
			$error = sprintf('No items where found for model <b>%s</b>', $_GET['model']);
			$data = array(
				"errorMessage" => $error,
			);			
			$this->_sendResponse(200, CJSON::encode($data), 'application/json' );
					
					
		} else {
			// Prepare response
			$data = array();
			foreach($models as $model)
				$data[] = $model->attributes;
			// Send the response
			$this->_sendResponse(200, CJSON::encode($data), 'application/json' );
		}

?>