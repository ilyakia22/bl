<?php

use app\models\Forum;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Phone comments';
$this->params['breadcrumbs'][] = $this->title;
?>
Статус:
<? foreach (\app\models\CommentPhone::$statusList as $statusIdx => $titleStatus) : ?>
    <? if ($statusIdx == $status) : ?>
        <?= yii\helpers\Html::a($titleStatus, ["phone/comments", 'status' => $statusIdx], ['class' => 'fw-bold status' . $statusIdx]) ?> &nbsp;
    <? else : ?>
        <?= yii\helpers\Html::a($titleStatus, ["phone/comments", 'status' => $statusIdx], ['class' => 'status' . $statusIdx]) ?> &nbsp;
    <? endif; ?>
<? endforeach; ?>
<div class="meta-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
        'viewParams' => ['status' => $status]
    ]);
    ?>


</div>