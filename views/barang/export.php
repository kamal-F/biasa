<?php 
use kartik\export\ExportMenu;

echo 'dsdsdsdsdsdssssssssssss';

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'id',
    'kode',
    'nama',
    'jumlah',
    //['class' => 'yii\grid\ActionColumn'],
];

// Renders a export dropdown menu
echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
	'export'=>'skip-export-pdf'
	
]);

// You can choose to render your own GridView separately

echo \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => $gridColumns,
]);