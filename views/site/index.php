<?php

/* @var $this yii\web\View */

use app\models\Gallery;
use yii\bootstrap4\BootstrapAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Petroglyphs Gallery';

//echo "<img src='http://localhost/petroglyphs/storage/test_png.png'>";
/*$this->registerCssFile("@web/css/site.css", [
    'depends' => [BootstrapAsset::class],
    'media' => 'print',
], 'css-print-theme');*/
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">All petroglyphs</h1>
    </div>
</div>
<style>
    .petroglyph-item {
        display: block;
        border: solid 2px #e1e1e1;
        padding: 0 15px 15px 15px;
        margin-bottom: 25px;
        color: #000; }
    .petroglyph-item:hover {
        text-decoration: none;
        border: solid 2px #7288e1; }
</style>

<div id="w0" class="list-view">
    <?php
    $gallery = new Gallery();
    $test_values = $gallery->getTestValues();
    if (!empty($test_values)): ?>
        <div class="row petroglyphs" style="position: relative; height: 5462.8px;">
            <?php foreach ($test_values as $test_value): ?>
                <div class="col-xs-12 col-sm-6 col-md-4" style="position: relative; left: 0; top: 0;">
                    <a href="<?= Url::to(['archsite/view', 'id' => $test_value['id']]) ?>" class="petroglyph-item">
                        <div class="row">
                            <?= Html::img(Gallery::SRC_IMAGE.$test_value['image'], ['class' => 'img-responsive']) ?>
                        </div>
                        <h3>
                            <?= $test_value['text_value'] ?>
                        </h3>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>


