<? foreach ($forums as $k => $forum) : ?>
<?
    echo Yii::$app->controller->renderPartial('_forum_preview', ['forum' => $forum]);
?>
<? endforeach; ?>


<?
echo \yii\widgets\LinkPager::widget([
    'pagination' => $pages,
]);
?>