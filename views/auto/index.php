<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\common\widgets\Alert;
use yii\web\View;
$this->registerCssFile('@web/layui/css/layui.css');
$this->registerJsFile('@web/layui/lay/dest/layui.all.js',['position' => View::POS_HEAD]);
$this->title = Yii::t('common','autoDo');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="col-lg-3">
    <ul id="tree"></ul>
</div>
<script type="text/javascript">
    layui.tree({
        elem: '#tree' //传入元素选择器
        ,nodes: <?=json_encode($tree) ?>
        ,click: function(node){
            $('#automodel-ldymudi').val(node.alias);
        }
    });
</script>
<div class="col-lg-9">
    <?= Alert::widget() ?>
    <div class="site-login">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-8\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-2 control-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'ldyPath')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'ldyMuDi')->textInput(['autofocus' => true]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton(Yii::t('common', 'startDo'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>



