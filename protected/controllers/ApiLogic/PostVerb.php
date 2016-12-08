<?php
		switch($_GET['model'])
		{
			// Get an instance of the respective model
			case 'events':
				$model = new Event;                    
				break;
			case 'movies':
				$model = new Movie;                    
				break;
			default:
				$this->_sendResponse(501, 
					sprintf('Mode <b>create</b> is not implemented for model <b>%s</b>',
					$_GET['model']) );
					Yii::app()->end();
		}
		// Try to assign POST values to attributes
		$_POST = json_decode(file_get_contents('php://input'), true);
		
		foreach($_POST as $var=>$value) {
			// Does the model have this attribute? If not raise an error
			if($model->hasAttribute($var))
				$model->$var = $value;
			else
				$this->_sendResponse(500, 
					sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var,
					$_GET['model']) );
		}
		// Try to save the model
		if($model->save())
		{
							
			$this->_sendResponse(200, CJSON::encode($model));
		}
		else {
			// Errors occurred
			$msg = "<h1>Error</h1>";
			$msg .= sprintf("Couldn't create model <b>%s</b>", $_GET['model']);
			$msg .= "<ul>";
			foreach($model->errors as $attribute=>$attr_errors) {
				$msg .= "<li>Attribute: $attribute</li>";
				$msg .= "<ul>";
				foreach($attr_errors as $attr_error)
					$msg .= "<li>$attr_error</li>";
				$msg .= "</ul>";
			}
			$msg .= "</ul>";
			$this->_sendResponse(500, $msg );
		}
?>