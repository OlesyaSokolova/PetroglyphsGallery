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

<div class="petroglyph-image">
    <?= Html::img(Petroglyph::SRC_IMAGE.$petroglyph->image, ['class' => 'img-fluid mb-4']) ?>
</div>

<?php /*if (Yii::$app->user->can(\app\models\User::ROLE_ADMINISTRATOR)): */?><!--
    <div class="pull-right">
        <?/*= Html::a(Yii::t('app', 'Edit'), ['admin/edit-object-general', 'id' => $object->id], ['class' => 'btn btn-primary']) */?>
    </div>
--><?php /*endif; */?>
<p>
    <?= $petroglyph->description ?>
</p>
<?php /*if (Yii::$app->user->can(\app\models\User::ROLE_ADMINISTRATOR) and !empty($object->tech_info)): */?><!--
    <div class="tech-info">
        <i><?/*= nl2br($object->tech_info) */?></i>
    </div>
--><?php /*endif; */?>

<?php /*if (Yii::$app->user->can(\app\models\User::ROLE_ADMINISTRATOR)): */?><!--
    <div class="tech-info">
        <?php /*if ($object->author != null and $object->author != ''): */?>
            <p><i><?/*= Yii::t('app','Authors')*/?>: <?/*=nl2br($object->author)*/?></i></p>
        <?php /*endif; */?>
        <?php /*if ($object->copyright != null and $object->copyright != ''): */?>
            <p><i><?/*= Yii::t('app','Copyright')*/?>: <?/*=nl2br($object->copyright)*/?></i></p>
        <?php /*endif; */?>
        <?php /*if ($object->license != null and $object->license != ''): */?>
            <p><i><?/*= Yii::t('app','License')*/?>: <?/*=nl2br($object->license)*/?></i></p>
        <?php /*endif; */?>
    </div>
--><?php /*endif; */?>
<div class="clearfix"></div>

<?php /*if ($categoryId): */?><!--
    <div class="clearfix">
        <?php /*if ($objectPrev): */?>
            <?/*= Html::a('<i class="fas fa-backward"></i> ' . $objectPrev->name, ['/object/view', 'categoryId' => $categoryId, 'id' => $objectPrev->link], ['class' => 'pull-left btn btn-default']) */?>
        <?php /*endif; */?>
        <?php /*if ($objectNext): */?>
            <?/*= Html::a($objectNext->name . ' <i class="fas fa-forward"></i>', ['/object/view', 'categoryId' => $categoryId, 'id' => $objectNext->link], ['class' => 'pull-right btn btn-default']) */?>
        <?php /*endif; */?>
    </div>
--><?php /*endif; */?>
