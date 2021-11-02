<?php

/* @var $this yii\web\View */

use app\models\Gallery;
use yii\helpers\Html;

$this->title = 'Petroglyphs Gallery';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Hello, world!</h1>
    </div>
</div>
<?php
    $gallery = new Gallery();
    $test_values = $gallery->getTestValues();

    if(!empty($test_values)):

?>
    <div class="test_values row">
        <?php foreach ($test_values as $test_value): ?>
            <div class="col-xs-12 col-sm-3">
                <a href="<?= $test_value['text_value']//Url::to(['archsite/view', 'id' => $archsite->id]) ?>" class="gallery-item">
                    <div class="row">

<!--                        <img class="attachment-shop_single size-shop_single wp-post-image" src="data:image/jpeg;base64,'.$test_value['image'].'" width="274">
-->                 <?=
                       //$data = $test_value['image'];
                        //var_dump($test_value);
                       /* $data = 'iVBORw0KGgoAAAANSUhEUgAAABwAAAASCAMAAAB/2U7WAAAABl'
                            . 'BMVEUAAAD///+l2Z/dAAAASUlEQVR4XqWQUQoAIAxC2/0vXZDr'
                            . 'EX4IJTRkb7lobNUStXsB0jIXIAMSsQnWlsV+wULF4Avk9fLq2r'
                            . '8a5HSE35Q3eO2XP1A1wQkZSgETvDtKdQAAAABJRU5ErkJggg==';*/
                       // $data = base64_decode($data);

                        //$im = imagecreatefromstring($data);
                        //$im = imagecreatefromstring(base64_decode($data));
                        //$oImg = imagecreatefromstring(base64_decode($data));
                        //header( 'Content-Type: image/png' );
                        //imagepng( $oImg );
                        /*$data = 'iVBORw0KGgoAAAANSUhEUgAAABwAAAASCAMAAAB/2U7WAAAABl'
                            . 'BMVEUAAAD///+l2Z/dAAAASUlEQVR4XqWQUQoAIAxC2/0vXZDr'
                            . 'EX4IJTRkb7lobNUStXsB0jIXIAMSsQnWlsV+wULF4Avk9fLq2r'
                            . '8a5HSE35Q3eO2XP1A1wQkZSgETvDtKdQAAAABJRU5ErkJggg==';
                        $data = base64_decode($data);
                        //phpinfo();
                        $im = imagecreatefromstring($data);
                        if ($im !== false) {
                            //error_reporting(E_ALL);
                            header('Content-Type: image/png');
                            imagepng($im);
                            imagedestroy($im);
                        }
                        else {
                            echo 'An error occurred.';
                        }*/
                        $im = imagecreatefrompng("/var/www/html/petroglyphs/storage/test_png.png");

                        header('Content-Type: image/png');

                        imagepng($im);
                        imagedestroy($im);
                       /* $imgdata = base64_decode($data0);
                        $im      = imagecreatefromstring($imgdata);
                        if ($im !== false) {
                            header('Content-Type: image/png');
                            imagepng($im);
                            imagedestroy($im);
                        }*/
                       // Html::img(Gallery::SRC_IMAGE .$test_value['image'], ['class' => 'img-responsive'])
                        ?>
                    </div>
                    <h3>
                        <?= $test_value['text_value']//$archsite->name ?>
                    </h3>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
