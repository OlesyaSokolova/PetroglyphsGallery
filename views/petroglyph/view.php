<?php

use app\models\Petroglyph;
use yii\helpers\Html;

/*$dataLabels = [];
$labels = $object->labels;
if (!empty($labels)) {
    foreach ($labels as $label) {
        $dataLabels[] = [
            'id' => $label->id,
            'position' => json_decode($label->position),
            'description' => $label->description,
        ];
    }
}*/
/*
$host = Yii::$app->urlManager->createAbsoluteUrl(['/']);
$labelsJson = json_encode($dataLabels);
$script = <<< JS
object = {
    id: $object->id,
    sef: '$object->link',
    option: $object->option,
    setting: $object->setting,
    labels: $labelsJson,
};
host = '$host';

start();

JS;*/


if(!empty($petroglyph)) {
    $this->title = $petroglyph->name;
    //$this->params['breadcrumbs'][] = $this->title;
} ?>
<style>
    h1 {
        margin-top: 30px;
        margin-bottom: 30px;
    }
    .petroglyph-image {
        float:left; /* Выравнивание по левому краю */
        margin: 7px 20px 7px 0; /* Отступы вокруг картинки */
    }
</style>

<!--View3dAsset::register($this);
\dominus77\highlight\Plugin::register($this);
$this->registerJs($script, yii\web\View::POS_READY);-->

<h1><?= $this->title ?></h1>
<p>
    <?php if (Yii::$app->user->can('updatePost',
        ['petroglyph' => $petroglyph])):?>
    <?= Html::button('Редактировать',
        ['class' => 'btn btn-outline-secondary',
            'name' => 'edit-button',
            'href' => '<?= Url::to([\'petroglyph/edit\', \'id\' => $petroglyph->id])?>]) ?>' ]);
 ?>
    <?= Html::button('Удалить',
        ['class' => 'btn btn-outline-secondary',
            'name' => 'delete-button',
            'href' => '<?= Url::to([\'petroglyph/view\', \'id\' => $petroglyph->id])?>]) ?>' ]);
endif; ?>
</p>
<div class="petroglyph-image">
    <?= Html::img(Petroglyph::SRC_IMAGE.$petroglyph->image, ['class' => 'img-fluid mb-4']) ?>
</div>

<p>
    <?= $petroglyph->description ?>
</p>

<?php /*if ($categoryId): */?><!--
    <div class="clearfix">
        <?php /*if ($objectPrev): */?>
            <?php /*= Html::a('<i class="fas fa-backward"></i> ' . $objectPrev->name, ['/object/view', 'categoryId' => $categoryId, 'id' => $objectPrev->link], ['class' => 'pull-left btn btn-default']) */?>
        <?php /*endif; */?>
        <?php /*if ($objectNext): */?>
            <?php /*= Html::a($objectNext->name . ' <i class="fas fa-forward"></i>', ['/object/view', 'categoryId' => $categoryId, 'id' => $objectNext->link], ['class' => 'pull-right btn btn-default']) */?>
        <?php /*endif; */?>
    </div>
--><?php /*endif; */?>
