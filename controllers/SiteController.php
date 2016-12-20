<?php

namespace app\controllers;

use app\models\SiteAction;
use Yii;
use yii\web\Controller;


class SiteController extends Controller
{


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(){
        $model = new SiteAction();

        if($model->load(Yii::$app->request->post())&&$model->site()){
            Yii::$app->getSession()->setFlash('success', Yii::t('common', 'siteMsg'));
        }

        $model->getSite();
        return $this->render('index',[
            'model' => $model,
        ]);
    }


    public function actionNow(){
        return $this->render('now');
    }


}
