<?php

use yii\helpers\Html;
use yii\widgets\DetailView;



/* @var $this yii\web\View */
/* @var $model app\models\Barang */

$this->title = $model->kode;
$this->params['breadcrumbs'][] = ['label' => 'Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="barang-view">

    <h1><?= Html::encode($this->title) ?></h1>   
    LOGO LOGO 1818181818
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'kode',
            //'gambar',
       		[
        		'attribute'=>'gambar',
        		'value'=>$model->gambar,
        		'format' => ['image',['width'=>'100','height'=>'100']],
       		],
            'nama',
            //'deskripsi:ntext',
       		[ 'attribute' => 'deskripsi','format' => 'html'],                  	
            'jumlah',
        	'kantor.nama',	
            'created_at',            
        	'creator.username',	
            'updated_at',            
       		'updator.username',
        ],
    ]) ?>
   hasilnya adalah rp 10000
</div>
