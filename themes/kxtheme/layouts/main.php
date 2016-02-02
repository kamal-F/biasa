<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\models\Validasi;
use app\assets\MyAsset;

MyAsset::register($this);
?>

<?php $this->beginPage(); ?>

<!doctype html>
<html>
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
	<div class="content">
		<div class="top_block judul">
			<div class="content">
			<div class="tulisan"> di sini, Anda letakan logo </div>
			<div class="tulisan"> <h1>Biasa.bom!</h1> </div>			
			</div>
		</div>
		
		<div class="isinya" >
		<div class="container">
		        <div class="isirender">
		        <?= Breadcrumbs::widget([
		            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		        ]) ?>
		        <?= $content ?>
		        </div>
		    </div>
		 </div>   
		    
		<div class="background menu">
		<div class="tulisan"> di sini, Anda letakan menu </div>
		
		<ul>
			<li><a href="/site/index" class="btn btn-primary">beranda</a></li>
			<?php 
			if(Validasi::cekRole('Admin')){
			?>
			<li><a href="/kantor/index" class="btn btn-danger">kantor</a></li>
			<?php 
			}
			?>
			<?php 
			if(Validasi::cekRole('Admin') || Validasi::cekRole('Customer service')){
			?>
			<li><a href="#" class="btn btn-danger">Barang</a>
				<ul>
					<li><a href="/barang/index" class="btn btn-warning">kelola</a></li>
					<li><a href="/barang/lihat" class="btn btn-warning">lihat</a></li>
					<li><a href="/barang/chart" class="btn btn-warning">grafik</a></li>
					<li><a href="/barang/export" class="btn btn-warning">export laporan</a></li>
				</ul>
			</li>
			<?php 
			}
			?>
			
			<li><a href="/site/about" class="btn btn-primary">tentang</a></li>
			<li><a href="/site/contact" class="btn btn-primary">kontak</a></li>
			<?php 
			if(Yii::$app->user->isGuest){
			?>
			<li><a href="/site/signup" class="btn btn-primary">daftar</a></li>
			<li><a href="/site/login" class="btn btn-primary">login</a></li>
			<?php 
			} else {
			?>
			<li><a href="/site/logout" data-method="post" class="btn btn-success">keluar</a></li>			
			<?php 
			}
			?>			
		</ul>
		</div>
		<div class="right_block menu">
			<div class="content">			
			</div>
		</div>
		<div class="bottom_block footer">
			<div class="content">
			<div class="tulisan">di sini, bawah</div>			
			</div>
		</div>
	</div>
<!-- 
 * Layout generated with http://layzilla.com
 * Layout generator is free of use.
 * We appreciate if you leave this comment block in commercial use of generator.
 * All comment and ideas can be submitted to us using contacts below.
 *
 *    site: www.jmholding.com
 *   email: info@jmholding.ru
 *  twitter: @jmholding
 -->
<?php $this->endBody() ?>
</body>
</html>

<?php $this->endPage(); ?>
