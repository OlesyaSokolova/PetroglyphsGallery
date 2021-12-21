<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?php //$form->field($model, 'auth_key') ?>

    <?php //$form->field($model, 'password_hash') ?>

    <?php //$form->field($model, 'password_reset_token') ?>

    <?php $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-outline-primary btn-rounded']) ?>
        <?= Html::resetButton('Сброс', ['class' => 'btn btn-outline-primary btn-rounded']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
