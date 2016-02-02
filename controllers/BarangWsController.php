<?php
/*
token diberikan jika admin, rule saya sendiri

Pass custom header, no user name: pass/ token
//all xml
curl -i -H "Accept:application/xml" "http://localhost/biasa/web/barang-ws"
//all json
curl -i -H "Accept:application/json" "http://localhost/biasa/web/barang-ws"
//show id = 24
curl -i -H "Accept:application/xml" -XGET "http://localhost/biasa/web/barang-ws/24"
//create baru
curl -i -H "Accept:application/json" -H "Content-Type:application/json" -XPOST "http://localhost/biasa/web/barang-ws" -d '{"kode": "x2", "nama": "termos","deskripsi":"barang bagus","id_kantor":"10"}'
//delete id = 26
curl -i -H "Accept:application/xml" -XDELETE "http://localhost/biasa/web/barang-ws/26"
//update id = 27
curl -i -H "Accept:application/json" -H "Content-Type:application/json" -XPUT "http://localhost/biasa/web/barang-ws/27" -d '{"nama": "termos ubahan","deskripsi":"barang bagus"}'
--------------------------
use Token
curl -u bb: "http://localhost/biasa/web/barang-ws"
curl -u bb: "Accept:application/json" "http://localhost/biasa/web/barang-ws"
curl -u bb: "Accept:application/xml" -XGET "http://localhost/biasa/web/barang-ws/24"
curl -u bb: "Accept:application/json" -H "Content-Type:application/json" -XPOST "http://localhost/biasa/web/barang-ws" -d '{"kode": "B25", "nama": "reskuker","deskripsi":"Penanak nasi bagus","id_kantor":"10"}'
curl -u bb: "Accept:application/xml" -XDELETE "http://localhost/biasa/web/barang-ws/26"
curl -u bb: "Accept:application/json" -H "Content-Type:application/json" -XPUT "http://localhost/biasa/web/barang-ws/27" -d '{"nama": "termos ubahan","deskripsi":"barang bagus dan awet"}'
curl -u bb: "http://localhost/biasa/web/barang-ws/lihat?nama=ter"

no need token
curl "http://localhost/biasa/web/barang-ws/lihat?nama=ter"
//throw message need token
curl "http://localhost/biasa/web/barang-ws"
 */
namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use app\models\Barang;

class BarangWsController extends ActiveController
{
	public $modelClass = 'app\models\Barang';
	
	public function init()
	{
		parent::init();
		\Yii::$app->user->enableSession = false;
	}
	
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = [
				'class' => HttpBasicAuth::className(),
				'only' => ['index', 'view','create', 'update', 'delete'],
		];
		
		return $behaviors;
	}
	
	/*
    public function actionIndex()
    {
        return $this->render('index');
    }*/

    //kustom, untuk semua tanpa token
    //http://localhost/biasa/web/barang-ws/lihat?nama=ter
    public function actionLihat($nama)
    {
    	$result = Barang::find()
    	->where(['like', 'nama', $nama])
    	->all();
    
    	return $result;
    }
}
