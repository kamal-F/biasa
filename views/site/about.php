<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>

<p><h2>cara pakai web service, di terminal console, curl</h2></p>
<br>
token diberikan jika admin, rule saya sendiri
<br>
Pass custom header, no user name: pass/ token
<br>
<p>
//all xml
<br>
<code>curl -i -H "Accept:application/xml" "http://localhost/biasa/web/barang-ws"</code>
<br>
//all json
<br>
<code>curl -i -H "Accept:application/json" "http://localhost/biasa/web/barang-ws"</code>
<br>
//show id = 24
<br>
<code>curl -i -H "Accept:application/xml" -XGET "http://localhost/biasa/web/barang-ws/24"</code>
<br>
//create baru
<br>
<code>curl -i -H "Accept:application/json" -H "Content-Type:application/json" -XPOST "http://localhost/biasa/web/barang-ws" -d '{"kode": "x2", "nama": "termos","deskripsi":"barang bagus","id_kantor":"10"}'</code>
<br>
//delete id = 26
<br>
<code>curl -i -H "Accept:application/xml" -XDELETE "http://localhost/biasa/web/barang-ws/26"</code>
<br>
//update id = 27
<br>
<code>curl -i -H "Accept:application/json" -H "Content-Type:application/json" -XPUT "http://localhost/biasa/web/barang-ws/27" -d '{"nama": "termos ubahan","deskripsi":"barang bagus"}'</code>
<br>
</p>
--------------------------
<br>
<p>
use Token
<br>
<code>
curl -u bb: "http://localhost/biasa/web/barang-ws"
<br>
curl -u bb: "Accept:application/json" "http://localhost/biasa/web/barang-ws"
<br>
curl -u bb: "Accept:application/xml" -XGET "http://localhost/biasa/web/barang-ws/24"
<br>
curl -u bb: "Accept:application/json" -H "Content-Type:application/json" -XPOST "http://localhost/biasa/web/barang-ws" -d '{"kode": "B25", "nama": "reskuker","deskripsi":"Penanak nasi bagus","id_kantor":"10"}'
<br>
curl -u bb: "Accept:application/xml" -XDELETE "http://localhost/biasa/web/barang-ws/26"
<br>
curl -u bb: "Accept:application/json" -H "Content-Type:application/json" -XPUT "http://localhost/biasa/web/barang-ws/27" -d '{"nama": "termos ubahan","deskripsi":"barang bagus dan awet"}'
<br>
curl -u bb: "http://localhost/biasa/web/barang-ws/lihat?nama=ter"
</code>
</p>
<br>
<p>
no need token
<br>
<code>curl "http://localhost/biasa/web/barang-ws/lihat?nama=ter"</code>
<br>
//throw message need token
<br>
<code>curl "http://localhost/biasa/web/barang-ws"</code>
</p>
<br>
<br>
<br>
    <code><?= __FILE__ ?></code>
</div>
