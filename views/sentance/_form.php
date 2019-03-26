<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Sentance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sentance-form">
    <?php $form = ActiveForm::begin(['enableAjaxValidation'=>false]); ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $model->isNewRecord ? "" : $form->field($model, 'enable')->dropDownList([1=>'Актив',0=>'Удалить']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Генерировать задание' : 'Обновить задание', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
