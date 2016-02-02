<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use yii\behaviors\TimestampBehavior;

class User extends ActiveRecord implements \yii\web\IdentityInterface {
	/*
	public $id;
	public $username;
	public $password;
	public $auth_key;
	public $accessToken;
	*/
	
	//role static, jika tidak perlu database
	const TYPE_TAMU = 0;
	const TYPE_CUSTSERVICE = 10;
	const TYPE_ADMIN = 50;
	
	public $password_new;
	
	public static function tableName() {
		return 'user';
	}
	
	public function behaviors()
	{
		return [
				TimestampBehavior::className(),
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id) {
		$user = self::find ()->where ( [ 
				"id" => $id 
		] )->one ();
		if (! count ( $user )) {
			return null;
		}
		return new static ( $user );
	}
	
	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $userType = null) {
		$user = self::find ()->where ( [ 
				"accessToken" => $token 
		] )->one ();
		if (! count ( $user )) {
			return null;
		}
		return new static ( $user );
	}
	
	/**
	 * Finds user by username
	 *
	 * @param string $username        	
	 * @return static|null
	 */
	public static function findByUsername($username) {
		$user = self::find ()->where ( [ 
				"username" => $username 
		] )->one ();
		if (! count ( $user )) {
			return null;
		}
		return new static ( $user );
	}
	
	/**
	 * @inheritdoc
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @inheritdoc
	 */
	public function getAuthKey() {
		return $this->auth_key;
	}
	
	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey) {
		return $this->auth_key === $authKey;
	}
	
	/**
	 * Validates password
	 *
	 * @param string $password
	 *        	password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password) {
		//return $this->password === $password;
		return Yii::$app->security->validatePassword($password, $this->password_hash);
	}
	
	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password_new = $password;
		$this->password_hash = Yii::$app->security->generatePasswordHash($password);
	}
	
	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey()
	{
		$this->auth_key = Yii::$app->security->generateRandomString();
	}
	
	//kembalian role
	public static function getTipeRole()
	{
		return [
				self::TYPE_TAMU => 'Tamu',
				self::TYPE_CUSTSERVICE => 'Customer service',
				self::TYPE_ADMIN => 'Admin'
		];
	}
	
	
}