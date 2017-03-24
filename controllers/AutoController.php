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
            if($model->load(Yii::$app->request->post())&&$model->autoDo()){
               echo 'sdd';die;
            }

            $cache = Yii::$app->cache;
            $model->ldyMuDi = $cache->get('nowpath');
            return $this->render('index',[
                'model'=>$model,
                'tree'=> $model->getGoalDir(),
            ]);
        }
}