<?php

use app\models\Petroglyph;
use yii\helpers\Html;

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


<h1><?= $this->title ?></h1>
<p>
    <?php if (Yii::$app->user->can('updatePost',
        ['petroglyph' => $petroglyph])):?>



    <?php endif; ?>
</p>
<div class="petroglyph-image">
    <?php //

    //Html::img(Petroglyph::SRC_IMAGE.$petroglyph->image, ['class' => 'img-fluid mb-4'])
    /*$image = new Imagick(Petroglyph::SRC_IMAGE."example.tiff");
    $image->setImageFormat('jpg');
    Html::img($image, ['class' => 'img-fluid mb-4']);*/

    //$exec = 'convert /var/www/html/petroglyphs/storage/mptest5.tif /var/www/html/petroglyphs/storage/mptest5.jpg 2>&1';
    //@exec($exec, $exec_output, $exec_retval);?>
    <?= //Html::img("/var/www/html/petroglyphs/storage/example.jpg", ['class' => 'img-fluid mb-4']);
    Html::img(Petroglyph::SRC_IMAGE . 'mptest5-0.jpg', ['class' => 'img-fluid mb-4']);
    $image = new Imagick(Petroglyph::SRC_IMAGE."mptest5.tif");
    echo "page number: ".$image->getNumberImages();



//possible error
//print_r($exec_output)

// echo $image;
//phpinfo();

?>
</div>
<p>
<?php $exec = 'exiftool /var/www/html/petroglyphs/storage/mptest5.tif';
@exec($exec, $exec_output, $exec_retval);
//possible error
print_r($exec_output)?>
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
