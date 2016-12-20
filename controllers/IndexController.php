<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/19
 * Time: 15:00
 */

namespace app\controllers;


use app\common\core\BaseController;

class IndexController extends BaseController
{
    public function actionIndex(){


        return $this->render('index');
    }
}