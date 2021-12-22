<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->last_name . " " . $model->first_name . " " . $model->patronymic;;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить информацию о пользователе', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary btn-rounded']) ?>
        <?= Html::a('Удалить пользователя', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-outline-danger btn-rounded',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этого пользователя?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=> 'id',
                'label' => 'id',
            ],
            [
                'attribute'=> 'email',
                'label' => 'Email',
            ],
            [
                'attribute'=> 'first_name',
                'label' => 'Имя',
            ],
            [
                'attribute'=> 'last_name',
                'label' => 'Фамилия',
            ],
            [
                'attribute'=> 'patronymic',
                'label' => 'Отчество',
            ],
            'auth_key',
            'password_hash',
            'password_reset_token',
            'status',
            'created_at',
            'updated_at',
        ]
    ]) ?>

</div>
