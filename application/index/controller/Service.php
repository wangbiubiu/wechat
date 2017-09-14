<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 * Time: 10:42
 */

namespace app\index\controller;


use think\Db;

class Service extends Home{
    public function fuwu(){
        return $this->fetch('fuwu');
    }
    public function diaochawenjuan(){
        

    }
    public function index(){
        $cms_wjdcs=Db::name("cms_wjdc")->select();
        return $this->fetch('index',['cms_wjdcs'=>$cms_wjdcs]);
    }
    public function faxian(){
        return $this->fetch('faxian');
    }


}