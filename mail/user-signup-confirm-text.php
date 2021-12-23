<?php

/* @var $user app\models\User; */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/signup-confirm', 'token' => $user->email_confirm_token]);
?>
Hello, <?= $user->last_name ." ". $user->first_name ." ". $user->patronymic ?>,

Follow the link below to confirm your email:

<?= $confirmLink ?>
