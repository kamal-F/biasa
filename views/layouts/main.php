<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\dropdown;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/images/logo-nav.png', ['width'=>'60px','alt'=>"Brand"]),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse black navbar-fixed-top',
        ],

    ]);
 if(Yii::$app->user->can('Admin'))
 {
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'encodeLabels' => false,

    'items' => [      

        ['label' => '<span class="glyphicon glyphicon-home"></span>', 'url' => ['/']],
        ['label' => '<span class="glyphicon glyphicon-user"></span> Anggota', 'url' => ['/anggota/index']],
        ['label' => '<span class="glyphicon glyphicon-user"></span> User', 'url' => ['/user/index']],
        ['label' => '<span class="glyphicon glyphicon-cd"></span> Kaset', 'url' => ['/kaset/index']],
        ['label' => '<span class="glyphicon glyphicon-transfer"></span> Transaksi', 'url' => ['tpinjam/index']],
  

       Yii::$app->user->isGuest ?  

            ['label' => '<span class="glyphicon glyphicon-user"></span> Login',  'url' => ['login/login']] :
            ['label' => '<span class="glyphicon glyphicon-off"></span> Logout (' . Html::encode(Yii::$app->user->identity->username) . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']],
    ],
]);
}else if(Yii::$app->user->can('Pemilik'))
{
            echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'encodeLabels' => false,

            'items' => [      

                ['label' => '<span class="glyphicon glyphicon-home"></span>', 'url' => ['/']],
                ['label' => '<span class="glyphicon glyphicon-th-list"></span> Laporan', 'url' => ['/pemilik/index']],
                ['label' => '<span class="glyphicon glyphicon-user"></span> User', 'url' => ['/user/index']],
               // ['label' => '<span class="glyphicon glyphicon-cd"></span> Kaset', 'url' => ['/kaset/index']],
                //['label' => '<span class="glyphicon glyphicon-transfer"></span> Transaksi', 'url' => ['tpinjam/index']],
                

               Yii::$app->user->isGuest ?  

                    ['label' => '<span class="glyphicon glyphicon-user"></span> Login',  'url' => ['/login/login']] :
                    ['label' => '<span class="glyphicon glyphicon-off"></span> Logout (' . Html::encode(Yii::$app->user->identity->username) . ')',
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post']],
            ],
        ]);
}else{
    echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'encodeLabels' => false,

    'items' => [      

        ['label' => '<span class="glyphicon glyphicon-home"></span>', 'url' => ['/']],
        ['label' => '<span class="glyphicon glyphicon-user"></span> Anggota', 'url' => ['/anggota/index']],
       // ['label' => '<span class="glyphicon glyphicon-user"></span> Pegawai', 'url' => ['/admin/index']],
        ['label' => '<span class="glyphicon glyphicon-cd"></span> Kaset', 'url' => ['/kaset/index']],
        ['label' => '<span class="glyphicon glyphicon-transfer"></span> Transaksi', 'url' => ['tpinjam/index']],
   

       Yii::$app->user->isGuest ?  

            ['label' => '<span class="glyphicon glyphicon-user"></span> Login',  'url' => ['login/login']] :
            ['label' => '<span class="glyphicon glyphicon-off"></span> Logout (' . Html::encode(Yii::$app->user->identity->username) . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']],
    ],
]);
}
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>
      
<footer class="footer black">
    <div class="container white-text">
        <p class="pull-left"><a class="red-text" href="http://localhost:8080/advanced/backend/web/"> &copy; Rental DxD</a> (Tempat Penyewaan VCD/DVD) <?= date('d M Y') ?></p>
       
        <p class="pull-right">Proyek Implementasi <a href="http://www.yiiframework.com"> Framework Yii 2.0.6 </a> </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
