<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Biasa!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">


        <div class="row">
            <div class="col-lg-4">
                <h2>setup biasa.bom</h2>
                <p>/opt/lampp/etc/extra/httpd-vhosts.conf</p>
				<p>
				<code>
				<?php 
				echo Html::encode('
						<VirtualHost *:80>
				    ServerAdmin biasa.bom
				    DocumentRoot "/opt/lampp/htdocs/biasa/web"
				    ServerName  biasa.bom
					<Directory "/opt/lampp/htdocs/biasa/web">
					   Options Indexes MultiViews FollowSymLinks
					   AllowOverride All
					   Require all granted	   	   
					</Directory>   	
				</VirtualHost>
						');
				?>
				</code>
				</p>
				
                
				<p>/etc/hosts
				127.0.0.1	biasa.bom
				</p>
				<p>
				<code>
				127.0.0.1	biasa.bom
				</code>
				</p>
				<p>restart apache</p>
				
                <p><a class="btn btn-default" href="#">Beranda &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Web Service Restful</h2>

                <p>Fitur Proyek 2 Restful web service</p>

                <p><a class="btn btn-default" href="<?= Yii::$app->urlManager->createUrl(['site/about']) ?>">about Ws &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Daftar</h2>

                <p>Pada basic ditambahkan fitur sign up mengadopsi dari advance template.</p>

                <p><a class="btn btn-default" href="<?= Yii::$app->urlManager->createUrl(['site/signup']) ?>">Basic Sign Up&raquo;</a></p>
            </div>
        </div>

    </div>
</div>
