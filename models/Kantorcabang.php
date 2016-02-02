<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kantorcabang".
 *
 * @property integer $id
 * @property string $nama
 * @property string $alamat
 * @property integer $id_kantor
 *
 * @property Kantor $idKantor
 */
class Kantorcabang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kantorcabang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'alamat'], 'required'],
            [['id_kantor'], 'integer'],
            [['nama', 'alamat'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'id_kantor' => 'Id Kantor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdKantor()    
    {
        return $this->hasOne(Kantor::className(), ['id' => 'id_kantor']);
    }
}
