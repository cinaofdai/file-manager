<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/19
 * Time: 14:42
 */

namespace app\models;

use app\common\util\FileUtil;
use yii;
use yii\base\Model;

class FileAction extends Model
{
    public $oldpath;             //      被复制对象路径
    public $newpath;             //      复制文件夹名称
    public $oldfile;             //      被复制对象路径
    public $newfile;             //      复制文件夹名称
    public $filename;            //      复制文件名
    public $savename;            //      保存文件名称
    public $num;                 //      复制数量
    public $start;               //      复制开始值

    public function rules()
    {
        return [
            [['filename', 'savename','num','start'], 'required'],
            [['num','start'], 'integer','min'=>1],
            [['oldpath','oldfile'], 'filePath'],
            [['oldpath','newpath','oldfile','newfile'], 'match','pattern'=>'/[A-Za-z]:[^\?\/\*\|<>]+$/','message'=>Yii::t('common', 'isPathError')],
        ];
    }

    //文件夹是否存在
    public function filePath($attribute, $params){
        if(!file_exists($this->$attribute)){
            $this->addError($attribute, Yii::t('common', 'pathError'));
        }
    }


    public function scenarios()
    {
        return [
            'copyDirs' => ['num', 'start','oldpath','newpath'],
            'copyDir' => ['oldpath','newpath'],
            'copyFiles' => ['num', 'start','oldfile','newfile'],
            'copyFile' => ['oldfile','newfile'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'filename' => Yii::t('common', 'filename'),
            'savename' => Yii::t('common', 'savename'),
            'oldpath' => Yii::t('common', 'oldpath'),
            'newpath' => Yii::t('common', 'newpath'),
            'oldfile' => Yii::t('common', 'oldfile'),
            'newfile' => Yii::t('common', 'newfile'),
            'num' => Yii::t('common', 'num'),
            'start' => Yii::t('common', 'start'),
        ];
    }


    /**批量复制文件夹
     * @return bool
     */
    public function copyDirs()
    {
        if ($this->validate()) {

            $file = new FileUtil();
            $num = (int)$this->num;
            $start = (int)$this->start;

           if(is_integer($num)&&is_integer($start)){
                for($i=0;$i<$num;$i++){
                    $file->copyDir($this->oldpath,$this->newpath.($start+$i));
                }
                return true;
            }
            return false;
        }
        return false;
    }

    /**复制单个文件夹
     * @return bool
     */
    public function copyDir()
    {
        if ($this->validate()) {
            $file = new FileUtil();
            $file->copyDir($this->oldpath,$this->newpath);
            return true;

        }
        return false;
    }

    /**批量复制文件
     * @return bool
     */
    public function copyFiles()
    {
        if ($this->validate()) {

            $file = new FileUtil();
            $num = (int)$this->num;
            $start = (int)$this->start;
            $showname = preg_replace('/^.+[\\\\\\/]/', '', $this->newfile);
            $suffix =explode('.',$showname);
            $path = dirname($this->newfile);

            $suffix[0] = iconv('utf-8', 'gbk//IGNORE', $suffix[0]);
            if(is_integer($num)&&is_integer($start)){
                for($i=0;$i<$num;$i++){
                    $savename =  $path.DIRECTORY_SEPARATOR.$suffix[0].($start+$i).'.'.$suffix[1];
                    $file->copyFile($this->oldfile,$savename);
                }
                return true;
            }
            return false;
        }
        return false;
    }

    /**批量复制文件
     * @return bool
     */
    public function copyFile()
    {
        if ($this->validate()) {

            $file = new FileUtil();

            $file->copyFile($this->oldfile,$this->newfile);

            return true;
        }
        return false;
    }
}