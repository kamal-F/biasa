<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use app\models\Kantor;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "barang".
 *
 * @property integer $id
 * @property string $kode
 * @property string $gambar
 * @property string $nama
 * @property string $deskripsi
 * @property double $mlat
 * @property double $mlong
 * @property integer $jumlah
 * @property integer $id_kantor
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Barang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'barang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode', 'nama', 'deskripsi','id_kantor'], 'required'],
        	['kode', 'unique', 'targetAttribute' => 'kode'],
            [['deskripsi'], 'string'],
            //[['mlat', 'mlong'], 'number'],
       		[['mlat', 'mlong'], 'string', 'max' => 25],
            [['jumlah', 'id_kantor', 'created_by', 'updated_by'], 'integer'],
       		[['jumlah'],'default','value'=>'0'],
            [['created_at', 'updated_at'], 'safe'],
            [['kode', 'nama'], 'string', 'max' => 20],
            //[['gambar'], 'string', 'max' => 200]
        	['gambar', 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 512000, 'tooBig' => 'batas 500KB'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode' => 'Kode',
            'gambar' => 'Gambar',
            'nama' => 'Nama',
            'deskripsi' => 'Deskripsi',
            'mlat' => 'Mlat',
            'mlong' => 'Mlong',
            'jumlah' => 'Jumlah',
            'id_kantor' => 'Id Kantor',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
    
    //webservice purpose, override
    public function fields(){
    	return ['kode', 'nama', 'id_kantor'];
    }
    
    public function getKantor()
    {
    	return $this->hasOne(Kantor::className(), ['id' => 'id_kantor']);
    }
    
    public function getCreator(){
    	return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
    
    public function getUpdator(){
    	return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
    
    public function behaviors()
    {	
    	
    	return [
    			'timestamp' => [
    					'class' => 'yii\behaviors\TimestampBehavior',
    					'attributes' => [
    							ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
    							ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
    					],
    					'value' => new Expression('NOW()'),
    			],
    			[
	    			'class' => BlameableBehavior::className(),
	    			'createdByAttribute' => 'created_by',
	    			'updatedByAttribute' => 'updated_by',
    			],
    	];
    }
    
    /*
	public function beforeSave() {
		//trik, $this->isNewRecord
		
		var_dump($this->jumlah);
		var_dump(is_int($this->jumlah));
		die();
		if(!is_int($this->jumlah)){$this->jumlah =0; }		
		
		return true;
	}*/
	
	public static function getKantorList()
	{
		$droptions = Kantor::find()->asArray()->all();
		return Arrayhelper::map($droptions, 'id', 'nama');
	}
}
