<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Meta $model */

$this->title = 'Update Forum: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Forums', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update ' . $model->id;
?>
<div class="meta-update">

	<h1>Update forum <?= $model->id ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>