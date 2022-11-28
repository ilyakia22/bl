<?

use yii\helpers\Url;
?>
<h2>Организации?</h2>
<div class="content-white">
    <? foreach ($organizations as $organization) : ?>
        <div class="org-preview">
            <a href="<?= $organization->getUrl() ?>"><?= $organization->inn ?></a> <?= $organization->fullname ?>
        </div>
    <? endforeach; ?>
</div>

<?
echo \yii\widgets\LinkPager::widget([
    'pagination' => $pages,
]);
?>