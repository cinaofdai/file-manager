<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/24
 * Time: 16:16
 */

namespace app\controllers;


use app\models\AutoModel;
use yii;
use app\common\core\BaseController;

class AutoController extends BaseController
{
        public function actionIndex(){
            $model = new AutoModel();
            if($model->load(Yii::$app->request->post())){
                $editHtml = $model->autoDo();
                return $this->render('edit',[
                    'edit'=>$editHtml,
                ]);
            }

            $cache = Yii::$app->cache;
            $model->ldyMuDi = $cache->get('nowpath');
            return $this->render('index',[
                'model'=>$model,
                'tree'=> $model->getGoalDir(),
            ]);
        }


        public function actionEdit(){
            $cache = Yii::$app->cache;
            $tempHtml = $cache->get('tempHtml');
            $path = Yii::$app->request->get('path');
            Yii::$app->session['workspace']=$tempHtml[$path];
            echo 200;
        }
}