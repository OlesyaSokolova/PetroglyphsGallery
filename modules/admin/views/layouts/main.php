<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;
use app\assets\AppAsset;
//todo: отдельный модуль для админа не нужен, ему требуется только crud для таблицы с пользователями
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?> | Администрирование</title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <style>
        @media (min-width: 1200px) {
            .container {
                max-width: 1500px;
            }
        }
        .wrap {
            /* min-height: 100%;
            height: auto;*/
            margin: 0 auto 20px;
            padding: 0 0 65px;
        }

        .wrap > .container {
            padding: 30px 15px 30px
        }
        .footer {
            position: relative;
        }
    </style>

    <header>
        <?php
        NavBar::begin([
            'brandLabel' => 'Администрирование',
            'brandUrl' => Url::to(['/admin/default/index']),
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                //['label' => 'Пользователи', 'url' => ['/../views/user/index']],
                //todo: переименовать везде publications->posts
                ['label' => 'Публикации', 'url' => ['/admin/publications/index']],
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ml-auto'],
            'items' => [
                //['label' => 'Вернуться в галерею', 'url' => ['/admin/auth/logout']],
            ],
        ]);
        NavBar::end();
        ?>
    </header>

    <div class="container">
        <?= $content; ?>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">footer, <?= date('Y') ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
