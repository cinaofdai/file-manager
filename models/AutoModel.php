<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/24
 * Time: 16:21
 */

namespace app\models;

use app\common\util\ChinesePinyin;
use app\common\util\FileUtil;
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
        if(!is_dir(iconv('utf-8','gbk',$this->$attribute))){
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
            $ldy = $this->list_dir($this->ldyPath,false);
            return $this->doFileAction($ldy);
        }
        return false;
    }


    /**
     * 做页面自动化操作并将要编辑的页面返回出去
     * @param $array
     * @return array|bool
     */
    private function doFileAction($array){
        if(!is_array($array)){
            return false;
        }
        $editHtml = array();
        $tempHtml = array();
        $pingyin = new ChinesePinyin();
        foreach($array as $key => $value){
            $name = explode('-',$value['name']);
            $game =  strtolower($pingyin->TransformUcwords($name[0]));
            $filename = $game.'-'.$name[1];
            $this->scanSwf($value['alias']);
            $old = $value['alias'];
            $new  =$this->ldyMuDi.DIRECTORY_SEPARATOR.$filename;
            $this->recurse_copy($old,$new);
            //复制完成添加index页面
            $indexHtml = $this->ldyMuDi.DIRECTORY_SEPARATOR.$game.'-g1'.DIRECTORY_SEPARATOR.'index.html';
            $newHtml = $new.DIRECTORY_SEPARATOR.'index.html';
            copy($indexHtml,$newHtml);
            $editHtml[$filename]= $newHtml;
            $tempHtml[$filename]= $new;
        }
        $cache = Yii::$app->cache;
        $cache->set('tempHtml',$tempHtml);
        return $editHtml;
    }

    /**
     * 获取游戏目录地址
     * @param $path
     * @return array
     */
    private function list_dir($path,$type=true){
        $lst = array();
        $base = !is_dir(iconv('utf-8','gbk',$path)) ? dirname($path) : $path;
        $tmp = $this->scanMyDir($base);
        $i=0;
        foreach ( $tmp as $k=>$v ) {
            //过滤掉上级目录,本级目录和程序自身文件名
            $filegame = explode('-',$v);
            if($type&&count($filegame)>1){
                continue;
            }
            if ( !in_array($v, array('.', '..')) ) {
                $file = $full_path = rtrim($base, '/').DIRECTORY_SEPARATOR.$v;
                if ( $full_path == __FILE__ ) {
                    continue; //屏蔽自身文件不在列表出现
                }
                $file = str_replace(dirname(__FILE__), '', $file);
                //$file = str_replace("\\", '/', $file); //过滤win下的路径
                $file = str_replace('//', '/', $file); //过滤双斜杠
                if ( is_dir(iconv('utf-8','gbk',$full_path)) ) {
                    $lst[$i]['name'] = $v;
                    $lst[$i]['alias'] = $file;
                    $lst[$i]['children'] = array(array('点啥子呢'));
                }
                $i++;
            }
        }

        return $lst;
    }

    /**
     * 模拟scandir()兼容中文
     * @param $path
     * @return array]
     */
    function scanMyDir($path){
        // 打开目录
        $dh = opendir(iconv('utf-8','gbk',$path));
        $tmp = array();
        // 循环读取目录
        while(($file = readdir($dh)) !== false){
            // 先要过滤掉当前目录'.'和上一级目录'..'
            if($file == '.' || $file == '..') continue;
            // 为了能够显示中文目录/文件，需要进行转码
            $tmp[] = iconv('gbk','utf-8',$file);
        }
        return $tmp;
    }

    /**
     * 扫码每个落地页里面的Swf文件放到flash目录里面
     * @param $path
     * @return array]
     */
    function scanSwf($path){
        // 打开目录
        $dh = opendir(iconv('utf-8','gbk',$path));
        $tmp = array();
        // 循环读取目录
        while(($file = readdir($dh)) !== false){
            // 先要过滤掉当前目录'.'和上一级目录'..'
            if($file == '.' || $file == '..') continue;
            // 为了能够显示中文目录/文件，需要进行转码
            $fielinfo =  pathinfo(iconv('gbk','utf-8',$file));
            //存在swf文件复制到flash里面
            if(isset($fielinfo['extension'])&&$fielinfo['extension']=='swf'){
                $old = iconv('utf-8','gbk',$path.DIRECTORY_SEPARATOR.$file);
                $new = iconv('utf-8','gbk',$path.DIRECTORY_SEPARATOR.'flash'.DIRECTORY_SEPARATOR.$file);
                rename($old, $new);
            }

            $tmp[] = iconv('gbk','utf-8',$file);
        }
        return $tmp;
    }

    /**
     * @param $src 原目录
     * @param $des 目标目录
     */
    function recurse_copy($src,$des) {
        $dir = opendir(iconv('utf-8','gbk',$src));
        $fileUtil = new FileUtil();
        $fileUtil->createDir($des);

        while(($file = readdir($dir)) !== false) {
            if (( $file != '.' ) && ( $file != '..' )) {
                $path = $src. DIRECTORY_SEPARATOR . $file;
                if ( is_dir(iconv('utf-8','gbk',$path))) {
                    self::recurse_copy($path,$des.DIRECTORY_SEPARATOR.$file);
                }  else  {
                    $pathinfo = pathinfo($path);
                    if($pathinfo['filename']=='index') continue;
                    copy(iconv('utf-8','gbk',$path),$des.DIRECTORY_SEPARATOR.$file);
                }
            }
        }
        closedir($dir);
    }

}