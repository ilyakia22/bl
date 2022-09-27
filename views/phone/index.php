<?

use yii\helpers\Url;
?>
<h2>Кто звонил?</h2>
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

<?
echo \yii\widgets\LinkPager::widget([
    'pagination' => $pages,
]);
?>