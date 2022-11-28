<?

use yii\helpers\Url;
?>

<div class="content-white">
    <? foreach ($organizations as $organization) : ?>
        <?= $organization->typeTitle; ?><br />
        <b>Название</b></br>
        <?= $organization->fullname ?><br />
        <b>Инн</b></br>
        <?= $organization->inn ?><br />
        <? if (!empty($organization->ogrn)) : ?>
            <b><?= $organization->ogrnTitle ?></b></br>
            <?= $organization->ogrn ?><br />
        <? endif; ?>
        <hr />
    <? endforeach; ?>
</div>