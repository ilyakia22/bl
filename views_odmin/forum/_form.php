<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \stkevich\ckeditor5\EditorClassic;


/** @var yii\web\View $this */
/** @var app\models\Meta $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="meta-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keyword')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'text')->widget(
        EditorClassic::class,
        [
            'toolbar' => ['bold', 'italic', 'link'],
            'uploadUrl' => '/someUpload.php',
        ]
    ); ?>




    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>