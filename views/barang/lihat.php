<?php
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Barangs';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php



$tampungan=0;
//var_dump($dataProvider);
foreach ($dataProvider as $x){
	
	echo	'nama barang adalah '. $x->nama;
	echo	'<img src="' . Yii::$app->homeUrl.$x->gambar.'" alt="gambar belum diupload" width=100 height=100> ';
	echo 	', posisi pada kantor '. $x->kantor['nama'];
	echo 	'ini id kantor aslinya:'.$x->id_kantor;
	echo 	'<br>';
	$tampungan = $tampungan + ($x->jumlah * 1000);
	echo 	'jumlah masing'. $x->jumlah;
}

echo 'totalnya adalah '. $tampungan;

echo LinkPager::widget([
		'pagination' => $pages,
]);

//echo Yii::$app->user->id;
?>

