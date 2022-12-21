<?

use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['action' => ['site/search'], 'id' => 'formSearch']); ?>
<div class="row justify-content-md-center">
    <div class="col-auto col-lg-5">
        <input class="form-control form-control-lg" type="text" placeholder="Телефон, ОГРН, ОГРНИП, ИНН" name="s" value="" id="s">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary btn-lg mb-3">Искать</button>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="alert alert-info visually-hidden" id="alertSearch">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Происходит процесс поиска, ожидайте или нажмите кнопку <b>Искать</b>.
    </div>


    <h2>Организации</h2>
    <div class="content-white">
        <? foreach ($organizations as $organization) : ?>
            <div class="org-preview">
                <a href="<?= $organization->getUrl() ?>"><?= $organization->ogrn ?></a> <?= $organization->fullname ?>
            </div>
        <? endforeach; ?>
    </div>
    <a href="<?= Url::toRoute('organization/index'); ?>" class="button primary">Еще</a>

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