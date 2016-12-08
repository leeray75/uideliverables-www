<?php
/*
http://www.yiiframework.com/wiki/544/multiple-database-connection-select-database-based-on-login-user-id-dynamic/
*/
class RActiveRecord extends CActiveRecord {
 
    private static $dbadvert = null;
 
    protected static function getAdvertDbConnection($db_host,$db_name,$db_password)
    {
 
        if (self::$dbadvert !== null)
            return self::$dbadvert;
        else
        {
             $User=User::model()->findByPk(Yii::app()->user->id);
             //$db_name = $user->db_name;
 				//$db_name = "devImdbMovies";
 
             self::$dbadvert = Yii::createComponent(array(
             'class' => 'CDbConnection',
            // other config properties...
             'connectionString'=>"mysql:host=".$db_host.";dbname=".$db_name, //dynamic database name here
              'enableProfiling' => true,
              'enableParamLogging' => true,
              'username'=>$db_name,
              'password'=> $db_password, //password here
              'charset'=>'utf8',
              'emulatePrepare' => true,
              'enableParamLogging'=>true,
              'enableProfiling' => true,
             ));
            Yii::app()->setComponent('dbadvert', self::$dbadvert);
 
            if (self::$dbadvert instanceof CDbConnection)
            {  
                Yii::app()->db->setActive(false);
                Yii::app()->dbadvert->setActive(true);
                return self::$dbadvert;
            }
            else{
                throw new CDbException(Yii::t('yii','Active Record requires a "db" CDbConnection application component.'));
            }
 
        }
    }
}
?>