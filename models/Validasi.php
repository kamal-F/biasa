<?php
namespace app\models;

use Yii;
use app\models\User;

class Validasi{	
	
	public static function cekRole($role_name){		
		if (!isset(Yii::$app->user->identity->role_id)) return false;
		
		if(User::getTipeRole()[Yii::$app->user->identity->role_id] == $role_name){
			return true;
		} else {
			return false;
		}
		
	}
}