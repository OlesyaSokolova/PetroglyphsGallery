<?php
use yii\helpers\Html;

/* @var $user app\models\User; */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/signup-confirm', 'token' => $user->email_confirm_token]);
?>
<div class="password-reset">
    <p>Здравствуйте, <?= Html::encode($user->last_name ." ". $user->first_name ." ". $user->patronymic) ?>,</p>

    <p>Для подтверждения регистрации на "<?= Yii::$app->name ?>" подтвердите свой email, перейдя по ссылке:</p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
</div>
