<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Validasi;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/favicon.ico?v=1" type="image/x-icon" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>    
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    
    $menu[] = ['label' => 'Home', 'url' => ['/site/index']];
    
    $subMenuBarang = [    		
    		['label' => 'kelola', 'url' => ['/barang/index']],
    		'<li class="divider"></li>',
    		['label' => 'lihat', 'url' => ['/barang/lihat']],
    		'<li class="divider"></li>',
    		['label' => 'grafik', 'url' =>['/barang/chart']],
    		'<li class="divider"></li>',
    		['label' => 'export laporan', 'url' =>['/barang/export']],
    ];
    
    if(Validasi::cekRole('Admin') || Validasi::cekRole('Customer service')){
    	$menu[] = ['label' => 'barang', 'items' => $subMenuBarang];    	
    }
    
    
    
    if(Validasi::cekRole('Admin')){
    	$menu[] = ['label' => 'kantor', 'url' => ['/kantor/index']];
    }
    
    $menu[] = ['label' => 'About', 'url' => ['/site/about']];
    $menu[] = ['label' => 'Contact', 'url' => ['/site/contact']];
        
    
    if(Yii::$app->user->isGuest){
    	$menu[] = ['label' => 'daftar', 'url' => ['/site/signup']];
    	$menu[] = ['label' => 'login', 'url' => ['/site/login']];
    } else {    	
    	$menu[] = [
    				'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
    				'url' => ['/site/logout'],
    				'linkOptions' => ['data-method' => 'post']
    		];
    }
    
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' =>$menu,
    		
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
