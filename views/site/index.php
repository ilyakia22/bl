<?

use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['action' => ['site/search'], 'id' => 'formSearch']); ?>
<div class=" justify-content-md-center">

    <div class="container text-center">

        <div class="row">
            <div class="col">
            </div>
            <div class="mb-3 col-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Телефон, ОГРН, ОГРНИП, ИНН" name="s" value="" id="s">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Искать</button>
                </div>
            </div>
            <div class="col">
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="alert alert-info visually-hidden" id="alertSearch">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Происходит процесс поиска, ожидайте или нажмите кнопку <b>Искать</b>.
    </div>


    <h2>Последние добавленные организации</h2>
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
</div>
<div class="text-center">
    <a href="<?= Url::toRoute('organization/index'); ?>" class="btn btn-primary">Посмотреть все организации</a>
</div>

<h2>Последние комментарии</h2>
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
<a href="<?= Url::toRoute('phone/'); ?>" class="button primary">Еще</a>

<h2>Форум</h2>
<? foreach ($forums as $k => $forum) : ?>
    <article class="preview">
        <div class="preview__usr">
            <? if ($forum->user != null) : ?>
                <img class="usr__avatar lazy" src="/images/smile.png" data-src="<?= $forum->user->getSrc() ?>" alt="<?= htmlspecialchars($forum->user->name) ?>" />
            <? else : ?>
                <img src="/images/smile.png" data-src="<?= app\lib\CommonLib::getAvatarLetter($forum->user_name, $forum->id) ?>" class="usr__avatar lazy" alt="<?= htmlspecialchars($forum->user_name) ?>">
            <? endif; ?>
            <div>
                <b><? if ($forum->user_id == -1) : ?><?= $forum->user->name ?><? elseif ($forum->user != null) : ?><?= $forum->user->name ?><? else : ?><?= $forum->user_name ?><? endif; ?></b>
                <br />
                <?= app\lib\CommonLib::showDate($forum->datetime_create) ?>
            </div>
        </div>

        <h2><a href="<?= $forum->getLink() ?>"><?= $forum->title ?></a></h2>

        <section class="preview__text">
            <?= str_replace('<img', '<img alt="' . htmlspecialchars($forum->title) . '"', $forum->getFormattedText()) ?>
        </section>
    </article>

<? endforeach; ?>
<?

$this->registerJs(
    "$('#s').val(window.location.hash.substring(1));
        if (window.location.hash.length>2){
            $('#alertSearch').removeClass('visually-hidden');
             window.setTimeout(function() { $('#formSearch').submit(); }, 5000);
        }
        "
);
?>