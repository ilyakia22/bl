<?php

use app\models\Forum;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Forums';
$this->params['breadcrumbs'][] = $this->title;
?>
Статус:
<? foreach (\app\models\Forum::$statusTitles as $statusIdx => $titleStatus) : ?>
    <? if ($statusIdx == $status) : ?>
        <?= yii\helpers\Html::a($titleStatus, ["forum/index", 'status' => $statusIdx], ['class' => 'fw-bold status' . $statusIdx]) ?> &nbsp;
    <? else : ?>
        <?= yii\helpers\Html::a($titleStatus, ["forum/index", 'status' => $statusIdx], ['class' => 'status' . $statusIdx]) ?> &nbsp;
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