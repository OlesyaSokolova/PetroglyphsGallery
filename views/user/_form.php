<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput()->label("Email") ?>
    <?= $form->field($model, 'first_name')->textInput()->label("Имя") ?>
    <?= $form->field($model, 'last_name')->textInput()->label("Фамилия") ?>
    <?= $form->field($model, 'patronymic')->textInput()->label("Отчество") ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-outline-primary btn-rounded']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
