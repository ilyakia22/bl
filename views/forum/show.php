<?
if ($forum->city != null) {
    $regionLink = $forum->city->link;
    $regionName = $forum->city->name;
} else if ($forum->region != null) {
    $regionLink = $forum->city->link;
    $regionName = $forum->city->name;
} else if ($forum->country != null) {
    $regionLink = $forum->country->link;
    $regionName = $forum->country->name;
}

$this->params['breadcrumbs'][] = array('label' => $regionName, 'url' => '/' . $regionLink);
$this->params['breadcrumbs'][] = array('label' => $forum->title);
?><article class="post">
    <div class="post__usr">
        <? if ($forum->user != null) : ?>
            <img class="usr__avatar lazy" src="/images/smile.png" data-src="<?= $forum->user->getSrc() ?>" alt="<?= htmlspecialchars($forum->user->name) ?>" />
        <? else : ?>
            <img src="/images/smile.png" data-src="<?= \app\lib\commonLib::getAvatarLetter($forum->user_name, $forum->id) ?>" class="usr__avatar lazy" alt="<?= htmlspecialchars($forum->user_name) ?>">
        <? endif; ?>
        <div>
            <b><? if ($forum->user_id == -1) : ?><?= $forum->user->name ?><? elseif ($forum->user != null) : ?><?= $forum->user->name ?><? else : ?><?= $forum->user_name ?><? endif; ?></b>
            <br />
            <span class="text-muted"><?= \app\lib\commonLib::showDate($forum->datetime_create) ?></span>
        </div>
    </div>

    <section class="post__text">
        <?= str_replace('<img', '<img alt="' . htmlspecialchars($forum->title) . '"', $forum->getFormattedText()) ?>
    </section>

    <div class="post__tags">
        <? if (0) : ?>
            <? if ($forum->city != null) : ?>
                <mark class="tag"><a href="<?= getUrlForum($regionLink) ?>"><b><?= $forum->city->name ?></b></a></mark>
            <? elseif ($forum->region != null) : ?>
                <mark class="tag"><a href="<?= getUrlForum($regionLink) ?>"><b><?= $forum->region->name ?></b></a></mark>
            <? elseif ($forum->country != null) : ?>
                <mark class="tag"><a href="<?= getUrlForum($regionLink) ?>"><b><?= $forum->country->name ?></b></a></mark>
            <? endif; ?>
        <? endif; ?>
        <? if ($forum->tags != null && count($forum->tags) > 0) : ?>
            <? foreach ($forum->tags as $tag) : ?>
                <mark class="tag"><a href="<?= $tag->getLink($regionLink) ?>">#<?= $tag->value ?></a></mark>
            <? endforeach; ?>
    </div>

<? endif; ?>
</article>