<?

use app\models\Organization;

use app\lib\PhoneTool;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$arr = ['kpp', 'date_reg', 'address', 'phone', 'email'];
?>

<div class="content-white">
    <div class="container">
        <div class="row">
            <div class="col-6">
                <div class="org-info mb-3">
                    <? if (!empty($organization->ogrn)) : ?>
                        <b><?= $organization->ogrnTitle ?></b>
                        <span><?= $organization->ogrn ?></span>
                    <? endif; ?>
                </div>
                <div class="org-info mb-3">
                    <b>ИНН</b>
                    <span><?= $organization->inn ?></span>
                </div>
                <div class="org-info">
                    <? if (count($organization->organizationPhones) > 0) : ?>
                        <b>Телефонные номера</b><br />
                        <? foreach ($organization->organizationPhones as $organizationPhone) : ?>
                            <a href="<?= Url::toRoute(['phone/info', 'number' => PhoneTool::forUrl($organizationPhone->number)]) ?>"><?= PhoneTool::formated($organizationPhone->number) ?></a>
                        <? endforeach; ?>
                        <br />
                    <? endif; ?>
                </div>
                <? foreach ($organization->info as $key => $value) : ?>
                    <? if (isset(Organization::$infoTitles[$key]) && in_array($key, $arr)) : ?>
                        <div class="org-info mb-3">
                            <b><?= Organization::$infoTitles[$key] ?></b>
                            <span><?= $organization->getInfoByKey($key) ?></span>
                        </div>
                    <? endif; ?>
                <? endforeach; ?>
                <? if (count($organization->codys) > 0) : ?>
                    <b>Коды ОКВЭД</b><br />
                    <? foreach ($organization->codys as $cody) : ?>
                        <?= $cody->value ?>,
                    <? endforeach; ?>
                    <br />
                <? endif; ?>

            </div>
            <div class="col-6">
                <? foreach ($organization->info as $key => $value) : ?>
                    <? if (isset(Organization::$infoTitles[$key]) && !in_array($key, $arr)) : ?>
                        <div class="org-info mb-3">
                            <b><?= Organization::$infoTitles[$key] ?></b>
                            <span><?= $organization->getInfoByKey($key) ?></span>
                        </div>
                    <? endif; ?>
                <? endforeach; ?>
            </div>
        </div>
    </div>

</div>


<? if ($model->id == 0) : ?>
    <h3>Оставьте ваш комментарий, возможно кому-то это будет полезно.</h3>
    <?php
    $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
    ]) ?>
    <?= $form->field($model, 'name', ['options' => ['class' => 'mt-3']]) ?>
    <?= $form->field($model, 'type', ['options' => ['class' => 'mt-3']])->dropdownList(app\models\CommentPhone::getTypeList()) ?>
    <?= $form->field($model, 'comment', ['options' => ['class' => 'mt-3']])->textarea() ?>

    <div class="form-group mt-3">
        <div class="col">
            <?= yii\helpers\Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>

<? endif; ?>