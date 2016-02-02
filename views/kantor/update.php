<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kantor */

$this->title = 'Update Kantor: ' . ' ' . $modelKantor->id;
$this->params['breadcrumbs'][] = ['label' => 'Kantors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelKantor->id, 'url' => ['view', 'id' => $modelKantor->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kantor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelkantor' => $modelKantor,
   		'modelscabang' =>$modelsCabang
    ]) ?>

</div>
