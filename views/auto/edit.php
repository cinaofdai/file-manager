<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\helpers\Url;
use app\common\widgets\Alert;
use yii\web\View;
$this->registerCssFile('@web/layui/css/layui.css');
$this->registerJsFile('@web/layui/lay/dest/layui.all.js',['position' => View::POS_HEAD]);
$this->title = Yii::t('common','autoEdit');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="col-lg-9">
    <?= Alert::widget() ?>
    <div class="site-login">
        <h1><?= Html::encode($this->title) ?></h1>
        <table class="layui-table">
            <colgroup>
                <col width="300">
                <col width="20">
            </colgroup>
            <thead>
            <tr>
                <th>路径</th>
                <th>编辑</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($edit as $key=>$value):?>
            <tr>
                <td><?=$value?></td>
                <td><a class="layui-btn" onclick="goEdit('<?=$key?>')">去编辑</a></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    function goEdit(path){
        var url = "<?=Url::to(['auto/edit'])?>";
        var data = {path:path};
        $.get(url,data,function(data){
            window.open('<?=Yii::$app->request->hostInfo.'/edit/index'?>');
        });
    }
</script>



