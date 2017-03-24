<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/24
 * Time: 16:21
 */

namespace app\models;

use yii;
use yii\base\Model;

class AutoModel extends Model
{

    public $ldyPath;             //      落地页地址
    public $ldyMuDi;             //      制作地址

    public function rules()
    {
        return [
            [['ldyPath', 'ldyMuDi'], 'required'],
            [['ldyPath','ldyMuDi'], 'filePath'],
            [['ldyMuDi','ldyPath'], 'match','pattern'=>'/[A-Za-z]:[^\?\/\*\|<>]+$/','message'=>Yii::t('common', 'isPathError')],
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
            'ldyPath' => Yii::t('common', 'ldyPath'),
            'ldyMuDi' => Yii::t('common', 'ldyMuDi'),
        ];
    }


    /**
     * 得到目标目录文件夹列表
     */
     public  function getGoalDir(){
         $cache = Yii::$app->cache;
         $path =$cache->get('nowpath');
         return $this->list_dir($path);

      }


    public function autoDo(){
        if ($this->validate()) {
            
            return true;
        }
        return false;
    }

    /**
     * 获取游戏目录地址
     * @param $path
     * @return array
     */
    private function list_dir($path){
        $lst = array();
        $base = !is_dir($path) ? dirname($path) : $path;
        $tmp = scandir($base);
        $i=0;
        foreach ( $tmp as $k=>$v ) {
            //过滤掉上级目录,本级目录和程序自身文件名
            $filegame = explode('-',$v);
            if(count($filegame)>1){
                continue;
            }

            if ( !in_array($v, array('.', '..')) ) {
                $file = $full_path = rtrim($base, '/').DIRECTORY_SEPARATOR.$v;
                if ( $full_path == __FILE__ ) {
                    continue; //屏蔽自身文件不在列表出现
                }
                $file = str_replace(dirname(__FILE__), '', $file);
                $file = str_replace("\\", '/', $file); //过滤win下的路径
                $file = str_replace('//', '/', $file); //过滤双斜杠
                if ( is_dir($full_path) ) {

                    $lst[$i]['name'] = $v;
                    $lst[$i]['alias'] = $file;
                    $lst[$i]['children'] = array(array('点啥子呢'));
                }
                $i++;
            }
        }

        return $lst;
    }
}