<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Validasi;

//google maps
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;


$coord = new LatLng(['lat' => $model->mlat, 'lng' => $model->mlong]);

$map = new Map([
		'center' => $coord,
		'zoom' => 14,
]);


// Lets add a marker now
$marker = new Marker([
		'position' => $coord,
		'title' => $model->kode,
]);

// Provide a shared InfoWindow to the marker
$marker->attachInfoWindow(
		new InfoWindow([
				'content' => $model->deskripsi
		])
		);

// Add marker to the map
$map->addOverlay($marker);


// Display the map -finally :)
//echo $map->display();

/* @var $this yii\web\View */
/* @var $model app\models\Barang */

$this->title = $model->kode;
$this->params['breadcrumbs'][] = ['label' => 'Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$isAdm = !Yii::$app->user->isGuest? (Validasi::cekRole('Admin')?true:false) : false;
 
$isCreator = false;
 
if($model->created_by!=null){
	$isCreator = (Yii::$app->user->id == $model->created_by)? true: false;
}
?>
<div class="barang-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?php 
    
    if ($isCreator || $isAdm){
    	echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
    	echo Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]);
    	echo Html::a('Cetak Pdf zxzxzxzx', ['cetakpdf', 'id' => $model->id], ['class' => 'btn btn-primary']);
    }    
    ?>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'kode',
            //'gambar',
       		[
        		'attribute'=>'gambar',
        		'value'=> Yii::$app->homeUrl. $model->gambar,
        		'format' => ['image',['width'=>'100','height'=>'100']],
       		],
            'nama',
            //'deskripsi:ntext',
       		[ 'attribute' => 'deskripsi','format' => 'html'],
            //'mlat',
            //'mlong',
        	[
        		'attribute'=>'Peta',
        		'value'=>$model->mlat==''?'':$map->display(),
        		'format' => 'raw',
        	],
            'jumlah',
        	'kantor.nama',	
            'created_at',            
        	'creator.username',	
            'updated_at',            
       		'updator.username',
        ],
    ]) ?>
   
</div>
