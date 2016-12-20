<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::t('common','system'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            ['label' => Yii::t('common','Home'), 'url' => ['/site/index']],
            ['label' => Yii::t('common','actionFile'), 'url' => ['/file/index']],
            ['label' => Yii::t('common','sysSet'), 'url' => ['/site/index']],
            ['label' => Yii::t('common','About'), 'url' => ['/site/about']],
            '<li>'.Html::a(Yii::t('common','logout'),Url::to(['site/logout']),[
                'data-method'=>"post"
            ]).'</li>'
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <div class="row">
            <div class="col-lg-3">
                <div id="w0" class="list-group">
                    <?= \yii\bootstrap\Collapse::widget([
                        'items' => [
                            [
                                'label' => Yii::t('common','actionCopy'),
                                'content' => [
                                    Html::a(Yii::t('common','copyDirs'),Url::to('/file/index')),
                                    Html::a(Yii::t('common','copyDir'),Url::to('/file/copy-dir')),
                                    Html::a(Yii::t('common','copyFiles'),Url::to('/file/copy-files')),
                                    Html::a(Yii::t('common','copyFile'),Url::to('/file/copy-file')),
                                ],
                                'contentOptions' => ['class' => 'in'],
                                'footer' =>  Html::a(Yii::t('common','nowDirs'),Url::to()),
                            ],
                            [
                                'label' => Yii::t('common','actionDir'),
                                'content' => [
                                    Html::a(Yii::t('common','addDirs'),Url::to()),
                                    Html::a(Yii::t('common','addDirs'),Url::to()),
                                ],
                            ],
                            [
                                'label' => Yii::t('common','actionFile'),
                                'content' => [
                                    Html::a(Yii::t('common','addFile'),Url::to()),
                                    Html::a(Yii::t('common','addFiles'),Url::to()),
                                ],
                            ],
                        ]
                    ]); ?>
                </div>
            </div>
            <?= $content ?>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?=Yii::t('common','author')?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::t('common','authorInfo') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
