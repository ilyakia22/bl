<div class="content-white">
	<? foreach ($commentPhones as $commentPhone) : ?>
		<div class="who-call">
			<div class="who-call__info">
				<a href="<?= $commentPhone->getUrl() ?>"><?= $commentPhone->getPhone() ?></a> <b><?= $commentPhone->name ?></b>
				<small><?= $commentPhone->getDate() ?></small>
			</div>
			<div class="who-call__comment">
				<?= $commentPhone->comment ?>
				<? if ($commentPhone->getTypeTitle()) : ?>
					<div class="who-call__comment-note">
						<?= $commentPhone->getTypeTitle() ?>
					</div>
				<? endif; ?>
			</div>
		</div>
	<? endforeach; ?>
</div>