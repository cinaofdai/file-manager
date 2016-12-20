<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\common\widgets\Alert;
?>
<div class="row">
    <div class="col-lg-3">
        <div id="w0" class="list-group">
            <?= \yii\bootstrap\Collapse::widget([
                'items' => [
                    [
                        'label' => Yii::t('common','sysSet'),
                        'content' => [
                            Html::a(Yii::t('common','workSpace'), Url::to('/site/index')),
                            Html::a(Yii::t('common','workNow'),Url::to('/site/now')),
                        ],
                        'contentOptions' => ['class' => 'in'],
                    ],
                ]
            ]); ?>
        </div>
    </div>
    <div class="col-lg-9">
        <?= Alert::widget() ?>
        <div class="site-login">
            <h1><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-6\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-2 control-label'],
                ],
            ]); ?>



            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::submitButton(Yii::t('common', 'copy'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>