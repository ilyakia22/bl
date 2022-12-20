<div class="card mb-3">
	<div class="card-header">
		#<b><?= $model->id ?></b>, <?= \app\lib\CommonLib::showDate($model->datetime_create) ?>, <?= long2ip($model->ip) ?>,
		&nbsp;&nbsp;&nbsp;&nbsp;
		postId: <b><?= $model->internal_id ?></b>,
		<a href="<?= url('forum/comment', ['forum_id' => $model->id]) ?>">LastComment</a>:
		<? if ($model->datetime_comment == 0) : ?>
			-
		<? else : ?>
			<?= \app\lib\CommonLib::showDate($model->datetime_comment) ?>
		<? endif; ?>
		,
		AmountComment: <?= $model->amount_comment ?>
		<? if ($model->amount_comment > 1500) : ?>
			[<a href="<?= url('forum/removePartComments', ['forum_id' => $model->id]) ?>">удалить чать комментов</a>]
		<? endif; ?>
		,
		<?
		//$model->secret 
		?>
		<? if (!empty($model->note)) : ?>
			<span class="red"><?= $model->note ?></span>

		<? endif; ?>
		<br />

	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-sm-10">
				<b><?= $model->title ?></b>
				<?= $model->getFormattedText() ?>
			</div>
			<div class="col-sm-2">
				Статус: <b class="status<?= $model->status ?>"><?= $model->statusTitle ?></b><br />
				<? foreach (\app\models\Forum::$statusTitles as $statusIdx => $titleStatus) : ?>
					<? if ($model->status != $statusIdx) : ?>
						<?= yii\helpers\Html::a($titleStatus, ["forum/set-status", 'id' => $model->id, 'goStatus' => $status, 'status' => $statusIdx], ['class' => 'status' . $statusIdx]) ?> &nbsp;
					<? endif; ?>
				<? endforeach; ?>
				<hr />
				<b>Meta title</b><br />
				<?= $model->meta_title ?><br />
				<b>Meta keywords</b><br />
				<?= $model->meta_keyword ?><br />
				<b>Meta description</b><br />
				<?= $model->meta_description ?>
			</div>
		</div>
	</div>