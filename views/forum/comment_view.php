<a name="comment<?= $comment->id ?>"></a>
<div class="comment<? if (!$isRoot) : ?> comment__child<? endif ?>">
    <? if ($comment->user != null) : ?>
        <img src="<?= $comment->user->getSrc() ?>" class="usr__avatar<? if (!$isRoot) : ?>-child<? endif ?>">
    <? else : ?>
        <img src="<?= \app\lib\commonLib::getAvatarLetter($comment->name, $comment->id) ?>" class="usr__avatar<? if (!$isRoot) : ?>-child<? endif ?>">
    <? endif; ?>
    <div>
        <div class="comment__info">
            <b><? if ($comment->user != null) : ?>
                    <?= $comment->user->name ?>
                <? else : ?>
                    <?= $comment->name ?>
                <? endif; ?></b>
            <? if ($parent != null) : ?>
                <? if ($parent->user != null) : ?>
                    <span class="comment__info-response-name"> <?= $parent->user->name ?></span>
                <? else : ?>
                    <span class="comment__info-response-name"> <?= $parent->name ?></span>
                <? endif; ?>
            <? endif; ?>
            <span><?= \app\lib\commonLib::showDate($comment->datetime_create) ?></span>
        </div>
        <? if ($parent != null) : ?>
            <? if ($parent->user != null) : ?>
                <b><?= $parent->user->name ?></b>,
            <? else : ?>
                <b><?= $parent->name ?></b>,
            <? endif; ?>
        <? endif; ?>
        <?= $comment->getFormattedText(); ?>

        <div class="comment__response">
            <a class="btnResponse" id="a_cf<?= $comment->id ?>" data-comment-id="<?= $comment->id ?>">Ответить</a>
            <div class="hidden" id="div_cf<?= $comment->id ?>"></div>
        </div>
    </div>
</div>