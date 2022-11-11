<?php

use app\models\Meta;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Metas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meta-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Meta', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'is_ok:boolean',
            'is_use_current:boolean',
            'url:url',
            'title',
            //'alt',
            //'description:ntext',
            //'keyword',
            //'h1',
            //'text_top:ntext',
            //'text_bottom:ntext',
            //'google_search:ntext',
            [
                'class' => ActionColumn::class,
                'template' => '{update} '
                // you may configure additional properties here
            ],
        ],
    ]); ?>


</div>