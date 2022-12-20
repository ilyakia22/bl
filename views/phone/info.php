<?

use app\models\CommentPhone;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<? if ($model->id > 0) : ?>
	<div class="alert alert-success">
		Спасибо, ваше сообщение принято!
	</div>
<? endif; ?>
<div class="content-white">
	<? foreach ($commentPhones as $commentPhone) : ?>
		<div class="who-call">
			<div class="who-call__info">
				<a href="<?= $commentPhone->getUrl() ?>"><?= $commentPhone->getPhone() ?></a> <b><?= $commentPhone->name ?></b>
				<small><?= $commentPhone->getDate() ?></small>
			</div>
			<div class="who-call__comment">
				<?= $commentPhone->formattedComment() ?>
				<? if ($commentPhone->getTypeTitle()) : ?>
					<div class="who-call__comment-note">
						<?= $commentPhone->getTypeTitle() ?>
					</div>
				<? endif; ?>
			</div>
		</div>
	<? endforeach; ?>
</div>
<div class="alert alert-info">
	В данный момент эта вся информация, которая нашлась в интернете. Но вы не расстраивайте, добавьте данную страницу в закладки и посетите ее позже.
	Для ускорения процесса нажмите кпопку <a href="<?= Url::to(['phone/search', 'number' => $number]) ?>" class="btn btn-success">Ускорить процесс поиска</a>, чтобы повысить приоритет.

</div>
<? if ($model->id == 0) : ?>
	<?php
	$form = ActiveForm::begin([
		'id' => 'login-form',
		'options' => ['class' => 'form-horizontal'],
	]) ?>
	<?= $form->field($model, 'name', ['options' => ['class' => 'mt-3']]) ?>
	<?= $form->field($model, 'type', ['options' => ['class' => 'mt-3']])->dropdownList(CommentPhone::getTypeList()) ?>
	<?= $form->field($model, 'comment', ['options' => ['class' => 'mt-3']])->textarea() ?>

	<div class="form-group mt-3">
		<div class="col">
			<?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
		</div>
	</div>
	<?php ActiveForm::end() ?>

<? endif; ?>