<?php

namespace app\controllers;

use Yii;
use app\models\Barang;
use app\models\BarangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\Pagination;
use app\models\Validasi;
use kartik\mpdf\Pdf;

/**
 * BarangController implements the CRUD actions for Barang model.
 */
class BarangController extends Controller
{
    public function behaviors()
    {
        return [
        	//level kontrol
        	'access' => [
        				'class' => \yii\filters\AccessControl::className(),
        				//'only' => ['index', 'view','create', 'update', 'delete'],
        				'rules' => [
        						[
        								'actions' => ['index', 'view',],
        								'allow' => true,
        								'roles' => ['?'],
        						],
        		
        						[
        								'actions' => ['index', 'view','chart',
        										'lihat','cetakpdf','export'],
        								'allow' => true,
        								'roles' => ['@'],
        						],
        						[
        								'actions' => ['create'],
        								'allow' => true,
        								'roles' => ['@'],
        								'matchCallback' => function ($rule, $action) {
        										//return true;
        										return Validasi::cekRole('Admin') || Validasi::cekRole('Customer service');
        								}
        						],
        						[
        								'actions' => ['update', 'delete'],
        								'allow' => true,
        								'roles' => ['@'],
        								'matchCallback' => function ($rule, $action) {
        								//return true;
        								return Validasi::cekRole('Admin');
        									}
        						],
        						
        						//hanya yg buat boleh update/delete
        						[
        								'actions' => ['update','delete'],
        								'class' => 'app\filters\BarangRule',
        						],
        		
        					],
        				],
        		      	//	
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Barang models.
     * @return mixed
     */
    public function actionIndex()
    {	
        $searchModel = new BarangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    //kustom
    public function actionLihat(){
    	$query = Barang::find();
    	
    	$countQuery = clone $query;
    	 
    	$pages = new Pagination(['totalCount' => $countQuery->count()]);
    	$pages->pageSize =2;
    	
    	$models = $query
    	->offset($pages->offset)
    	->limit($pages->limit) 
    	->where(['kode' => 'x5',])
    	->all();
    	
    	return $this->render('lihat', [    			
    			'dataProvider' => $models,
    			'pages' => $pages,
    	]);
    }
    
    public function actionChart(){
    	$query = Barang::find();
    	  
    	$models = $query->andFilterWhere(['>=', 'jumlah', 0])->all();
    	
    	return $this->render('chart',['dataProvider' => $models]);
    }

    /**
     * Displays a single Barang model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    //kustom
    public function actionCetakpdf($id){
    	// get your HTML raw content without any layouts or scripts
    	//$content = $this->renderPartial('_reportView');
    	$content = $this->renderPartial('cetak',[
            'model' => $this->findModel($id),
        ]);
    	
    	// setup kartik\mpdf\Pdf component
    	$pdf = new Pdf([
    			// set to use core fonts only
    			'mode' => Pdf::MODE_CORE,
    			// A4 paper format
    			'format' => Pdf::FORMAT_A4,
    			// portrait orientation
    			'orientation' => Pdf::ORIENT_PORTRAIT,
    			// stream to browser inline
    			'destination' => Pdf::DEST_BROWSER,
    			// your html content input
    			'content' => $content,
    			// format content from your own css file if needed or use the
    			// enhanced bootstrap css built by Krajee for mPDF formatting
    			'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
    			// any css to be embedded if required
    			'cssInline' => '.kv-heading-1{font-size:18px}',
    			// set mPDF properties on the fly
    			'options' => ['title' => $this->findModel($id)->kode],
    			// call mPDF methods on the fly
    			'methods' => [
    					'SetHeader'=>[$this->findModel($id)->kode],
    					'SetFooter'=>['{PAGENO}'],
    			]
    	]);
    	
    	// return the pdf output as per the destination setting
    	return $pdf->render();
    }
    
    public function actionExport(){
    	$searchModel = new BarangSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	
    	return $this->render('export', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
    }

    /**
     * Creates a new Barang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {	
        $model = new Barang();

        if ($model->load(Yii::$app->request->post())) {
        	        	
        	$model->gambar = UploadedFile::getInstance($model, 'gambar');
        	 
        	if(!$model->gambar==NULL){
        		//save file
        		$unik = $model->kode;
        		$namafile = $model->gambar->baseName.$unik;
        		$extensi = $model->gambar->extension;
        		
        		$model->gambar->saveAs('uploads/'.$namafile.'.'.$extensi);
        		$model->gambar = 'uploads/'.$namafile.'.'.$extensi;
        	}
        	
        	$model->save();
        	
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    

    /**
     * Updates an existing Barang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $tmpgambar = $model->gambar;

        if ($model->load(Yii::$app->request->post())) {
        	
        	$model->gambar = UploadedFile::getInstance($model, 'gambar');
        	
        	if(!$model->gambar==NULL){
        		//save file
        		$unik = $model->kode;
        		$namafile = $model->gambar->baseName.$unik;
        		$extensi = $model->gambar->extension;
        	
        		$model->gambar->saveAs('uploads/'.$namafile.'.'.$extensi);
        		$model->gambar = 'uploads/'.$namafile.'.'.$extensi;
        	} else {
        		if($tmpgambar!=NULL) $model->gambar = $tmpgambar;
        	}
        	$model->save();
        	
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Barang model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	$tmpfilepath = $this->findModel($id)->gambar;
    	 
    	if($tmpfilepath!=NULL || $tmpfilepath!='')
    		if(is_file($this->findModel($id)->gambar)) unlink($this->findModel($id)->gambar);
    	
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Barang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Barang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Barang::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
