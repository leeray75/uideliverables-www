<?php
// Check if id was submitted via GET
		if(!isset($_GET['id']))
			$this->_sendResponse(500, 'Error: Parameter <b>id</b> is missing' );
			
		$secure_connection = (isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] == "on") ? true : false;
		$hostname = $_SERVER['SERVER_NAME'];
	 
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
			case 'user':
				/* To use: http://localhost/www/index.php/api/user/0?username=demo&password=demo */
				if(isset($_GET['logout'])){
					Yii::app()->user->logout();	
					$model = Yii::app()->user->userProfile;
				}
				//elseif($secure_connection or $hostname=='localhost'){
				else{
					$user_id = getUserId();	
					$model;
					if($user_id>-1){		
						$model = Yii::app()->user->userProfile;
					}

					else{
						$response["errorMessage"] = "Invalid Username and Password";
						$response["errorCode"] = "200";
						$this->_sendResponse(200, CJSON::encode($response));
					}
				}
				/*
				else{
					$this->_sendResponse(400, 'Secure Connection Failed');
				}
				*/
				break;
			default:
				$this->_sendResponse(501);
				Yii::app()->end();
		}
		
		function getUserId(){
			$username = isset($_GET['username']) ? $_GET['username'] : "";
			$password = isset($_GET['password']) ? $_GET['password'] : "";
			$rememberMe = isset($_GET['rememberMe']) ? true : false;
			
			if(!empty($username) || !empty($pasword)){
				$identity = new UserIdentity($username,$password);
				$identity->authenticate();
			}
			else{
				return Yii::app()->user->id;	
			}

			if($identity->errorCode===UserIdentity::ERROR_NONE)
			{
				$duration=	$rememberMe ? 3600*24*30 : 0; // 30 days
				Yii::app()->user->login($identity,$duration);
				return Yii::app()->user->id;
			}
			else
			{
				return -1;
			}
		}
		// Did we find the requested model? If not, raise an error
		if(is_null($model))
			$this->_sendResponse(404, 'No Item found with id '.$_GET['id']);
		else
			$this->_sendResponse(200, CJSON::encode($model));
?>