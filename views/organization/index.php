<?

use yii\helpers\Url;
?>
<div class="d-flex flex-wrap">
    <? foreach ($organizations as $organization) : ?>
        <div class="org-preview m-3">
            <div class="org-preview__header">
                <?= $organization->fullname ?>
            </div>
            <div class="org-preview__body">
                <?= $organization->ogrnTitle ?>: <a href="<?= $organization->getUrl() ?>"><?= $organization->ogrn ?></a><br />
                ИНН: <?= $organization->inn ?><br />
            </div>
        </div>
    <? endforeach; ?>
</div>

<?
echo \app\components\BootstrapLinkPager::widget([
    'pagination' => $pages,

]);
?>