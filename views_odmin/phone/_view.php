<div class="card mb-3">
	<div class="card-header">
		<a href="/7<?= $model->phone_number ?>">#<b><?= $model->id ?></b></a>, <?= \app\lib\CommonLib::showDate($model->datetime) ?>, <?= long2ip($model->ip) ?>,
		&nbsp;&nbsp;&nbsp;&nbsp;
		globalId: <b><?= $model->global_id ?></b>,
		secret:<b><?= $model->secret ?></b>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-sm-10">
				<?= $model->formattedComment() ?>
			</div>
			<div class="col-sm-2">
				Статус: <b class="status<?= $model->status ?>"><?= $model->statusTitle ?></b><br />
				<? foreach (\app\models\CommentPhone::$statusList as $statusIdx => $titleStatus) : ?>
					<? if ($model->status != $statusIdx) : ?>
						<?= yii\helpers\Html::a($titleStatus, ["phone/set-status", 'id' => $model->id, 'goStatus' => $status, 'status' => $statusIdx], ['class' => 'status' . $statusIdx]) ?> &nbsp;
					<? endif; ?>
				<? endforeach; ?>
			</div>
		</div>
	</div>