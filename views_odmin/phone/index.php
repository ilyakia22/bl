<?php

use app\models\PhoneSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Phones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meta-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'status',
            'phone_number',
            [
                'attribute' => 'datetime',
                'format' => 'raw',
                'header' => 'datetime',
                'value' => function ($model) {
                    return date('Y-m-d H:i', $model->datetime);
                },
            ],
            [
                'attribute' => 'ip',
                'format' => 'raw',
                'header' => 'Ip',
                'value' => function ($model) {
                    return long2ip($model->ip);
                },
            ],
            'secret',
        ],
    ]); ?>


</div>