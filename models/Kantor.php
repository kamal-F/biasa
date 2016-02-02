<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kantor".
 *
 * @property integer $id
 * @property string $nama
 * @property string $alamat
 *
 * @property Kantorcabang[] $kantorcabangs
 */
class Kantor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kantor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama'], 'string', 'max' => 20],
            [['alamat'], 'string', 'max' => 60]
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKantorcabangs()
    {
        return $this->hasMany(Kantorcabang::className(), ['id_kantor' => 'id']);
    }
}
