<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
<!--TODO: добавить возможность присваивать пользователям роли (администратора?) и менять пароли
-->    <?= $form->field($model, 'id')->textInput() ?>
    <?= $form->field($model, 'status')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-outline-primary btn-rounded']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
