<div class="card mb-3">
	<div class="card-header">
		#<b><?= $model->id ?></b>, <?= \app\lib\CommonLib::showDate($model->datetime) ?>, <?= long2ip($model->ip) ?>,
		&nbsp;&nbsp;&nbsp;&nbsp;
		globalId: <b><?= $model->global_id ?></b>,
		secret:<b><?= $model->secret ?></b>
		<a href="/7<?= $model->phone_number ?>"><b><?= $model->phone ?></b></a>
		StatusPhone:
		<?

		use app\models\PhoneInfo;

		if ($model->phoneInfo == null) : ?>
			<span>noPhoneInfo</span>
		<? else : ?>
			<span class="phoneInfoStatus<?= $model->phoneInfo->status ?>" id="phoneInfoStatus<?= $model->phone_number ?>"><?= $model->phoneInfo->statusTitle ?></span>
		<? endif; ?>
		[
		<a style="cursor:pointer" data-phone="<?= $model->phone_number ?>" data-status="<?= PhoneInfo::STATUS_OK ?>" class="setPhoneInfo phoneInfoStatus<?= PhoneInfo::STATUS_OK ?>"><?= PhoneInfo::statusTitle(PhoneInfo::STATUS_OK) ?></a> |
		<a style="cursor:pointer" data-phone="<?= $model->phone_number ?>" data-status="<?= PhoneInfo::STATUS_PD ?>" class="setPhoneInfo phoneInfoStatus<?= PhoneInfo::STATUS_PD ?>"><?= PhoneInfo::statusTitle(PhoneInfo::STATUS_PD) ?></a>
		]
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