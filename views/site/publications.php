<?php

/* @var $this yii\web\View */

use app\models\Petroglyph;
use yii\bootstrap4\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Публикации';


?>

<h1>Мои публикации</h1>
<div id="w0" class="list-view">
    <?php if (!empty($petroglyphs)):
        //var_dump($petroglyphs); ?>
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

