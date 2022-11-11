<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Meta $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="meta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?
    //$form->field($model, 'id')->textInput() 
    ?>

    <?= $form->field($model, 'is_ok')->checkbox() ?>

    <?= $form->field($model, 'is_use_current')->checkbox() ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'keyword')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'h1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text_top')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'text_bottom')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'google_search')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>