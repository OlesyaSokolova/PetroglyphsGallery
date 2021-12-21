<?php

/* @var $this yii\web\View */

use app\models\Petroglyph;
use yii\bootstrap4\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Петроглифы'; ?>
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

    @media screen and (max-width: 800px) {
        .column {
            flex: 50%;
            max-width: 50%;
        }
    }

    @media screen and (max-width: 600px) {
        .column {
            flex: 100%;
            max-width: 100%;
        }
    }
</style>
<h1>Все петроглифы</h1>
<div id="w0" class="list-view">
    <?php if (!empty($petroglyphs)):?>
        <div class="row petroglyphs" style="position: relative;">
            <?php foreach ($petroglyphs as $petroglyph): ?>
                <div class="column">
                       <a href="<?= Url::to(['petroglyph/view', 'id' => $petroglyph->id])?>" class="petroglyph-item">

                        <div class="row">
                            <?= Html::img(Petroglyph::PATH_STORAGE.Petroglyph::PATH_IMAGES.'/'.$petroglyph->image, ['class' => 'img-fluid mb-4']) ?>
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

