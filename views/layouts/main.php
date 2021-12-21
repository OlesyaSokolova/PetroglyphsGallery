<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
AppAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
<?php $this->beginBody(); ?>
<style>
    @media (min-width: 1200px) {
        .container {
            max-width: 1500px;
        }
    }
    .wrap {
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
 <div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);

    $menuItems = [];
    $menuItems[] = ['label' => 'О проекте', 'url' => ['/site/about']];

    $userRoles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());

    if (isset($userRoles['author']) || isset($userRoles['admin'])) {
        $menuItems[] = ['label' => 'Мои публикации', 'url' => ['/site/publications']];
    }
    if (isset($userRoles['admin'])) {
        //TODO: закрыть доступ к этой ссылке остальным пользователям
        $menuItems[] = ['label' => 'Администрирование', 'url' => ['/user/index']];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems
    ]);

    $authenticationItems = [];

    if (Yii::$app->user->isGuest) {
        $authenticationItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
        $authenticationItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
    } else {
        //$authenticationItems[] = ['label' => 'Мои публикации', 'url' => ['/gallery/publications']];
        $authenticationItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Выход (' . Yii::$app->user->identity->email . ')',
                //'Выход',
                ['class' => 'btn btn-light logout']
            )
            . Html::endForm()
            . '</li>';
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ml-auto'],
        'items' => $authenticationItems,
    ]);
    NavBar::end();
    ?>

 </div>


<main role="main" class="flex-shrink-0">
    <div class="container" style="margin-top: 50px">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<!--<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-left">&copy; My Company <?/*= date('Y') */?></p>
        <p class="float-right"><?/*= Yii::powered() */?></p>
    </div>
</footer>-->
<footer class="footer">
    <div class="container">
        <p class="pull-left">footer, <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
