<?php
use dosamigos\chartjs\ChartJs;


$this->title = 'Barang grafik';
$this->params['breadcrumbs'][] = $this->title;


foreach ($dataProvider as $x){
	$label[] =	$x->kode;
	$data[] =	$x->jumlah;	
}
?>

<?= ChartJs::widget([
    'type' => 'Line',
    'options' => [
        'height' => 400,
        'width' => 400
    ],
    'data' => [
        'labels' => $label,
        'datasets' => [
            [
                'fillColor' => "rgba(220,220,220,0.5)",
                'strokeColor' => "rgba(220,220,220,1)",
                'pointColor' => "rgba(220,220,220,1)",
                'pointStrokeColor' => "#fff",
                'data' => $data
            ],            
        ]
    ]
]);
?>