<?php

/* @var $this yii\web\View */

use app\models\Petroglyph;
use yii\bootstrap4\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Personal publications';


//echo "<img src='http://localhost/petroglyphs/storage/test_png.png'>";
?>
<!--<div class="site-index">
    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">All petroglyphs</h1>
    </div>
</div>-->
<style>
    h1 {
        margin-top: 20px;
        margin-bottom: 30px;
    }
    .petroglyph-item {
        display: block;
        border: solid 2px #e1e1e1;
        padding: 0 15px 15px 15px;
        margin-bottom: 25px;
        color: #000; }
    .petroglyph-item:hover {
        text-decoration: none;
        border: solid 2px #7288e1;
    }
    .row {
        display: flex;
        flex-wrap: wrap;
        padding: 0 4px;
    }
    .column {
        flex: 25%;
        max-width: 25%;
        padding: 0 4px;
    }

    .column img {
        margin-top: 8px;
        vertical-align: middle;
        width: 100%;
    }

    /* Responsive layout - makes a two column-layout instead of four columns */
    @media screen and (max-width: 800px) {
        .column {
            flex: 50%;
            max-width: 50%;
        }
    }

    /* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
    @media screen and (max-width: 600px) {
        .column {
            flex: 100%;
            max-width: 100%;
        }
    }
</style>
<h1>Мои публикации</h1>
<div id="w0" class="list-view">
    <?php if (!empty($petroglyphs)):
        //var_dump($petroglyphs); ?>
        <div class="row petroglyphs" style="position: relative;">
            <?php foreach ($petroglyphs as $petroglyph): ?>
                <div class="column">
                    <!--                    <a href="<?/*= Url::to(Petroglyph::VIEW_URL.'?id='.$petroglyph['id'], true)*/?>" class="petroglyph-item">
-->                        <a href="<?= Url::to(['petroglyph/view', 'id' => $petroglyph->id])?>" class="petroglyph-item">

                        <div class="row">
                            <?= Html::img(Petroglyph::SRC_IMAGE.$petroglyph->image, ['class' => 'img-fluid mb-4']) ?>
                        </div>
                        <h3>
                            <?= $petroglyph->name ?>
                        </h3>
                    </a>
                </div>
            <?php endforeach;
            ?>
        </div>
    <?php endif; ?>
</div>
<?php
if(!empty($pages)):
    echo LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
<?php endif;
?>

