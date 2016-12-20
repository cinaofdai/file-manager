<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/20
 * Time: 14:56
 */

namespace app\models;

use yii;
use yii\base\Model;

class SiteAction extends Model
{

    public $workspace;   //工作空间
    public $nowpath;    //当前路径

    public function rules()
    {
        return [
            [['workspace', 'nowpath'], 'required'],
            [['workspace', 'nowpath'], 'filePath'],
            [['workspace','nowpath'], 'match','pattern'=>'/[A-Za-z]:[^\?\/\*\|<>]+$/','message'=>Yii::t('common', 'isPathError')],
        ];
    }

    //文件夹是否存在
    public function filePath($attribute, $params){
        if(!file_exists($this->$attribute)){
            $this->addError($attribute, Yii::t('common', 'pathError'));
        }
    }

    public function attributeLabels()
    {
        return [
            'workspace' => Yii::t('common', 'workspace'),
            'nowpath' => Yii::t('common', 'nowpath'),
        ];
    }

    /**批量复制文件夹
     * @return bool
     */
    public function site()
    {
        if ($this->validate()) {
            $cache = Yii::$app->cache;
            $cache->add('workspace',$this->workspace);
            $cache->add('nowpath',$this->nowpath);
            return true;
        }
        return false;
    }

    public function getSite(){
        $cache = Yii::$app->cache;
        if($cache->exists('workspace')&&$cache->exists('nowpath')){
            $this->workspace =$cache->get('workspace');
            $this->nowpath = $cache->get('nowpath');
        }
        //$cache->exists('workspace');

    }


}