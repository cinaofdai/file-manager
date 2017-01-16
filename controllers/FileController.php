<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/19
 * Time: 11:55
 */

namespace app\controllers;

use yii;
use app\common\core\BaseController;
use app\models\FileAction;

class FileController extends BaseController
{
    public $layout = 'file-layout';

    /**
     * 批量复制文件夹
     * @return string
     */
    public function actionIndex(){

        $model = new FileAction();
        $model->setScenario('copyDirs');

        if($model->load(Yii::$app->request->post())){
             $model->copyDirs();
            Yii::$app->getSession()->setFlash('success', Yii::t('common', 'copySuccess'));
        }
        $cache = Yii::$app->cache;
        $model -> oldpath = $cache->get('nowpath');
        return $this->render('index',[
            'model' => $model,
        ]);
    }

    /**
     * 复制单个文件夹
     * @return string
     */
    public function actionCopyDir(){
        $model = new FileAction();
        $model->setScenario('copyDir');

        if($model->load(Yii::$app->request->post())){
            $model->copyDir();
            Yii::$app->getSession()->setFlash('success', Yii::t('common', 'copyFlies'));
        }

        $cache = Yii::$app->cache;
        $model -> oldpath = $cache->get('nowpath');
        return $this->render('copyDir',[
            'model' => $model,
        ]);
    }

    /**
     * 批量复制文件
     * @return string
     */
    public function actionCopyFiles(){
        $model = new FileAction();
        $model->setScenario('copyFiles');

        if($model->load(Yii::$app->request->post())){
            $model->copyFiles();
            Yii::$app->getSession()->setFlash('success', Yii::t('common', 'copySuccess'));
        }

        $cache = Yii::$app->cache;
        $model -> oldfile = $cache->get('nowpath');
        return $this->render('copyFiles',[
            'model' => $model,
        ]);
    }

    /**
     * 复制单个文件
     * @return string
     */
    public function actionCopyFile(){
        $model = new FileAction();
        $model->setScenario('copyFile');

        if($model->load(Yii::$app->request->post())){
            $model->copyFile();
            Yii::$app->getSession()->setFlash('success', Yii::t('common', 'copyFlies'));
        }

        $cache = Yii::$app->cache;
        $model -> oldfile = $cache->get('nowpath');
        return $this->render('copyFile',[
            'model' => $model,
        ]);
    }
}