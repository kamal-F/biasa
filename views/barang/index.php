<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Validasi;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Barangs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Barang', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'kode',
            //'gambar',
            'nama',
            //'deskripsi:ntext',
            // 'mlat',
            // 'mlong',
            'jumlah',        		
            // 'id_kantor',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            [
            		'class' => 'yii\grid\ActionColumn',
            		'template' => '{view} {update} {delete}',
            		'buttons' => [
            				'update' => function ($url, $model) {
	            				$isAdm = !Yii::$app->user->isGuest? (Validasi::cekRole('Admin')?true:false) : false;
	            				
	            				$isCreator = false;
	            				
	            				if($model->created_by!=null){	            					
	            					$isCreator = (Yii::$app->user->id == $model->created_by)? true: false;
            				}
            				 
            				if($isAdm || $isCreator)
            					return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $model['id']], [
            							'title' => Yii::t('yii', 'Update'),
            							'data-pjax' => '0',
            					]);
            				}
            				,
            				//delete
            				'delete' => function ($url, $model) {
	            				$isAdm = !Yii::$app->user->isGuest? (Validasi::cekRole('Admin')?true:false) : false;
	        
	            				$isCreator = false;
	        
	            				if($model->created_by!=null){
	            					$isCreator = (Yii::$app->user->id == $model->created_by)? true: false;
            				}
         
            				if($isAdm || $isCreator)
            					return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model['id']], [
            							'title' => Yii::t('yii', 'Delete'),
            							'data-pjax' => '0',
            					]);
            				}
            		]
        	],
        ],
    ]); ?>

</div>
