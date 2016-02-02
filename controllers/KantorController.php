<?php

namespace app\controllers;

use Yii;
use app\models\Kantor;
use app\models\KantorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Validasi;
use app\models\Kantorcabang;
use app\models\Model;
use yii\helpers\ArrayHelper;

/**
 * KantorController implements the CRUD actions for Kantor model.
 */
class KantorController extends Controller
{
    public function behaviors()
    {
        return [
        		//level kontrol
        		'access' => [
        				'class' => \yii\filters\AccessControl::className(),
        				'only' => ['index', 'view','create', 'update', 'delete'],
        				'rules' => [        						
        						[
        								'actions' => ['create','index', 'view'],
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
        					],
        				],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Kantor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KantorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Kantor model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$modelkantor = $this->findModel($id);
    	$modelscabang = Kantorcabang::find()->where(['id_kantor' => $id,])->all();
    	
        return $this->render('view', [
            'model' => $modelkantor,
        	'modelscabang' => $modelscabang	
        ]);
    }

    /**
     * Creates a new Kantor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelkantor = new Kantor();
        $modelscabang = [new Kantorcabang];

        if ($modelkantor->load(Yii::$app->request->post())) {
        	
        	$modelscabang = Model::createMultiple(Kantorcabang::classname());
        	Model::loadMultiple($modelscabang, Yii::$app->request->post());
        	
        	// ajax validation
        	if (Yii::$app->request->isAjax) {
        		Yii::$app->response->format = Response::FORMAT_JSON;
        		return ArrayHelper::merge(
        				ActiveForm::validateMultiple($modelscabang),
        				ActiveForm::validate($modelkantor)
        				);
        	}
        	
        	// validate all models
        	$valid = $modelkantor->validate();
        	$valid = Model::validateMultiple($modelscabang) && $valid;
        	
        	if ($valid) {
        		$transaction = \Yii::$app->db->beginTransaction();
        		try {
        			if ($flag = $modelkantor->save(false)) {
        				foreach ($modelscabang as $modelcabang) {
        					$modelcabang->id_kantor = $modelkantor->id;
        					if (! ($flag = $modelcabang->save(false))) {
        						$transaction->rollBack();
        						break;
        					}
        				}
        			}
        			if ($flag) {
        				$transaction->commit();
        				return $this->redirect(['view', 'id' => $modelkantor->id]);
        			}
        		} catch (Exception $e) {
        			$transaction->rollBack();
        		}
        	}
        	
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'modelkantor' => $modelkantor,
           		'modelscabang' => (empty($modelscabang)) ? [new Kantorcabang] : $modelscabang            		
            ]);
        }
    }

    /**
     * Updates an existing Kantor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelKantor = $this->findModel($id);
        $modelsCabang = $modelKantor->kantorcabangs;
        

        if ($modelKantor->load(Yii::$app->request->post()) ) {
        	
        	$oldIDs = ArrayHelper::map($modelsCabang, 'id', 'id');
        	$modelsCabang = Model::createMultiple(Kantorcabang::classname(), $modelsCabang);
        	Model::loadMultiple($modelsCabang, Yii::$app->request->post());
        	$deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsCabang, 'id', 'id')));
        	
        	// ajax validation
        	if (Yii::$app->request->isAjax) {
        		Yii::$app->response->format = Response::FORMAT_JSON;
        		return ArrayHelper::merge(
        				ActiveForm::validateMultiple($modelsCabang),
        				ActiveForm::validate($modelKantor)
        				);
        	}
        	
        	// validate all models
        	$valid = $modelKantor->validate();
        	$valid = Model::validateMultiple($modelsCabang) && $valid;
        	
        	if ($valid) {
        		$transaction = \Yii::$app->db->beginTransaction();
        		try {
        			if ($flag = $modelKantor->save(false)) {
        				if (! empty($deletedIDs)) {
        					Kantorcabang::deleteAll(['id' => $deletedIDs]);
        				}
        				foreach ($modelsCabang as $modelCabang) {
        					$modelCabang->id_kantor = $modelKantor->id;
        					if (! ($flag = $modelCabang->save(false))) {
        						$transaction->rollBack();
        						break;
        					}
        				}
        			}
        			if ($flag) {
        				$transaction->commit();
        				return $this->redirect(['view', 'id' => $modelKantor->id]);
        			}
        		} catch (Exception $e) {
        			$transaction->rollBack();
        		}
        	}
        	
            //return $this->redirect(['view', 'id' => $modelKantor->id]);
        } else {
            return $this->render('update', [
                'modelKantor' => $modelKantor,
            	'modelsCabang' =>$modelsCabang	
            ]);
        }
    }

    /**
     * Deletes an existing Kantor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Kantor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kantor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kantor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
