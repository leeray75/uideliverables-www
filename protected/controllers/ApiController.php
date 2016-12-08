<?php 
class ApiController extends Controller
{
    // Members
    /**
     * Key which has to be in HTTP USERNAME and PASSWORD headers 
     */
    Const APPLICATION_ID = 'ASCCPE';
 
    /**
     * Default response format
     * either 'json' or 'xml'
     */
    private $format = 'json';
    /**
     * @return array action filters
     */
    public function filters()
    {
            return array();
    }
	protected function beforeSave()
	{

		// author_id may have been posted via API POST
		/*
		if(is_null($this->author_id) or $this->author_id=='')
			$this->author_id=Yii::app()->user->id;
		*/
	}
	/**
	 * Return data to browser as JSON
	 * @param array $data
	 */
	protected function renderJSON($data)
	{
		header('Content-type: application/json');
		echo CJSON::encode($data);
	
		foreach (Yii::app()->log->routes as $route) {
			if($route instanceof CWebLogRoute) {
				$route->enabled = false; // disable any weblogroutes
			}
		}
		Yii::app()->end();
	}	
    // Actions
	public function actionList()
	{
		include 'ApiLogic/GetAllVerb.php';
	}
	public function actionView()
	{
		include 'ApiLogic/GetIdVerb.php';
	}
	public function actionCreate()
	{
		include 'ApiLogic/PostVerb.php';
	}
	public function actionUpdate()
	{
		include 'ApiLogic/PutVerb.php';
	}
	public function actionDelete()
	{
		include 'ApiLogic/DeleteVerb.php';
	}
	
	
	private function _sendResponse($status = 200, $body = '', $content_type = 'application/json')
	{
		// set the status
		$status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
		header($status_header);
		// and the content type
		header('Content-type: ' . $content_type);
		header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
		header('Pragma: no-cache'); // HTTP 1.0.
		header('Expires: 0'); // Proxies.
	 
		// pages with body are easy
		if($status==200 and $body != '')
		{
			// send the body
	 		if(isset($_GET["callback"])){
				$callback = $_GET["callback"]; 
				echo $callback."(".$body.")";
			}
			else{			
				echo $body;
			}
		}
		else if($body!='')
		{
			$message = $body;	
			
			$errorObj = array(
				"errorMessage" => $message,
				"errorCode" => $status
												
			);
			$body = json_encode($errorObj);
	 		if(isset($_GET["callback"])){
				$callback = $_GET["callback"]; 
				echo $callback."(".$body.")";
			}
			else{			
				echo $body;
			}
		}
		// we need to create the body if none is passed
		else
		{
			// create some body messages
			$message = '';
	 
			// this is purely optional, but makes the pages a little nicer to read
			// for your users.  Since you won't likely send a lot of different status codes,
			// this also shouldn't be too ponderous to maintain
			switch($status)
			{
				case 401:
					$message = 'You must be authorized to view this page.';
					break;
				case 404:
					$message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
					break;
				case 500:
					$message = 'The server encountered an error processing your request.';
					break;
				case 501:
					$message = sprintf('Mode <b>list</b> is not implemented for model <b>%s</b>',
							$_GET['model']
							);
					break;
			}
	 
			// servers don't always have a signature turned on 
			// (this is an apache directive "ServerSignature On")
			$signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];
	 
			// this should be templated in a real-world solution
			$errorObj = array(
				"errorMessage" => $message,
				"errorCode" => $status								
			);
			$body = json_encode($errorObj);

				echo $body;
		}
		Yii::app()->end();
	}
	
	private function _getStatusCodeMessage($status)
	{
		// these could be stored in a .ini file and loaded
		// via parse_ini_file()... however, this will suffice
		// for an example
		$codes = Array(
			200 => 'OK',
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
		);
		return (isset($codes[$status])) ? $codes[$status] : '';
	}	
	
	private function _checkAuth()
	{
		
		/*
		// Check if we have the USERNAME and PASSWORD HTTP headers set?
		if(!(isset($_SERVER['HTTP_X_USERNAME']) and isset($_SERVER['HTTP_X_PASSWORD']))) {
			
			// Error: Unauthorized
			//$this->_sendResponse(401);
			
			$error = "Unauthorized";
			$errArray = array(
				"errorMessage" => $error,
			);			
			$this->_sendResponse(401, 
					$this->renderJSON($errArray));			
			
		}
		$username = $_SERVER['HTTP_X_USERNAME'];
		$password = $_SERVER['HTTP_X_PASSWORD'];
		// Find the user
		$user=User::model()->find('LOWER(username)=?',array(strtolower($username)));
		if($user===null) {
			// Error: Unauthorized
			$this->_sendResponse(401, 'Error: User Name is invalid');
		} else if(!$user->validatePassword($password)) {
			// Error: Unauthorized
			$this->_sendResponse(401, 'Error: User Password is invalid');
		}
		*/
	}	
}
?>