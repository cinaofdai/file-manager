<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/24
 * Time: 13:55
 */

namespace app\controllers;

use yii;
use yii\helpers\Url;
use app\common\core\BaseController;

class EditController extends BaseController
{
    public function actionIndex(){
        if( Yii::$app->session['workspace']){
            return $this->redirect(Yii::$app->request->hostInfo.'/ace/editor.php');
        }else{
            return $this->redirect(Url::to('/site/index'));
        }

    }
}