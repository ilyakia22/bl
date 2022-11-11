<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Meta $model */

$this->title = 'Create Meta';
$this->params['breadcrumbs'][] = ['label' => 'Metas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
