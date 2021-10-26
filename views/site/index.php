<?php

/* @var $this yii\web\View */

$this->title = 'Petroglyphs Gallery';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Hello, world!</h1>
    </div>
</div>
<?php // if (!empty($archsites)): $petroglyphs = []
    $petroglyphs = ["hello1", "hello2", "hello3", "hello4",
        "hello5", "hello6", "hello7", "hello8"]
?>
    <div class="petroglyphs row">
        <?php foreach ($petroglyphs as $petroglyph): ?>
            <div class="col-xs-12 col-sm-3">
                <a href="<?= $petroglyph//Url::to(['archsite/view', 'id' => $archsite->id]) ?>" class="archsite-item">
                    <div class="row">
                        <?= $petroglyph//Html::img(Archsite::SRC_IMAGE . '/' . $archsite->thumbnailImage, ['class' => 'img-responsive']) ?>
                    </div>
                    <h3>
                        <?= $petroglyph//$archsite->name ?>
                    </h3>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php //endif; ?>
