<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Barang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="barang-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'kode')->textInput(['maxlength' => true]) ?>
   
    <?= $form->field($model, 'gambar')->fileInput()->label('Gambar') ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>  
    
	<?= $form->field($model, 'deskripsi')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'custom_v1'
    ]) ?>   
    

    <?= $form->field($model, 'mlat')->textInput(['readonly' => true]) ?>
	<?= $form->field($model, 'mlong')->textInput(['readonly' => true]) ?>
	
	 
	<?= \ibrarturi\latlngfinder\LatLngFinder::widget([
	    'model' => $model,              // model object
		'latAttribute' => 'mlat',        // Latitude attribute
		'lngAttribute' => 'mlong',        // Longitude attribute
		'defaultLat' => -6.938014486859704,        // Default latitude for the map
		'defaultLng' => 107.58636474609375,         // Default Longitude for the map
		'defaultZoom' => 8,             // Default zoom for the map
		'enableZoomField' => false,      // True: for assigning zoom values to the zoom field, False: Do not assign zoom value to the zoom field
	]); ?>

    <?= $form->field($model, 'jumlah')->textInput() ?>    
    
    <?= $form->field($model, 'id_kantor')->dropDownList($model->kantorList,
	[ 'prompt' => 'Pilih' ]);?>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


 




    <?php ActiveForm::end(); ?>

</div>
