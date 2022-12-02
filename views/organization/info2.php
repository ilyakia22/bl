<?

use app\models\Organization;
use yii\helpers\Url;
?>

<div class="content-white">

    <?= $organization->typeTitle; ?><br />
    <? if (!empty($organization->fullname) && !empty($organization->shortname)) : ?>
        <b>Полное название</b></br>
        <?= $organization->fullname ?><br />
        <b>Короткое название</b></br>
        <?= $organization->shortname ?><br />
    <? else : ?>
        <b>Название</b></br>
        <?= $organization->fullname ?><br />
    <? endif; ?>
    <b>Инн</b></br>
    <?= $organization->inn ?><br />
    <? if (!empty($organization->ogrn)) : ?>
        <b><?= $organization->ogrnTitle ?></b></br>
        <?= $organization->ogrn ?><br />
    <? endif; ?>

    <? foreach ($organization->info as $key => $value) : ?>
        <? if (isset(Organization::$infoTitles[$key])) : ?>
            <b><?= Organization::$infoTitles[$key] ?></b><br />
            <?= $organization->getInfoByKey($key) ?><br />
        <? endif; ?>
    <? endforeach; ?>
    <hr />

</div>