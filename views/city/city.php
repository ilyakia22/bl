<? foreach ($forums as $k => $forum) : ?>
    <?
    echo Yii::$app->controller->renderPartial('_forum_preview', ['forum' => $forum]);
    ?>
<? endforeach; ?>

<h2>Последние комментарии в <?= $city->name_v ?></h2>
<div class="content-white">
    <? foreach ($commentPhones as $commentPhone) : ?>
        <div class="who-call">
            <div class="who-call__info">
                <a href="<?= $commentPhone->getUrl() ?>"><?= $commentPhone->getPhone() ?></a> <b><?= $commentPhone->name ?></b>
                <small><?= $commentPhone->getDate() ?></small>
            </div>
            <div class="who-call__comment">
                <?= $commentPhone->comment ?>
            </div>
        </div>
    <? endforeach; ?>
</div>