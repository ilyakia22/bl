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
    <? foreach ($forum->tags as $tag) : ?>
        ##<?= $tag->id ?>:<?= $tag->value ?>;
    <? endforeach; ?>
</article>