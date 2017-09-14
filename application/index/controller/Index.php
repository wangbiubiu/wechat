<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

namespace app\index\controller;

use app\cms\model\Darticle;
use app\cms\model\Notice;
use app\cms\model\Service;
use app\cms\model\Xarticle;
use app\cms\model\Zs;
use think\Db;

/**
 * 前台首页控制器
 * @package app\index\controller
 */
class Index extends Home
{
    /**
     *主页
     */
    public function index()
    {
//        echo 11;exit;
       return $this->fetch("index");
    }

    /**
     *小区通知
     * @param $id
     * @return mixed
     */

    public function notice(){
        $datas=Notice::all();
        return $this->fetch('notice',['datas'=>$datas]);
    }
    public function notices($id){
        $data=Notice::get($id);
        return $this->fetch('notices',['data'=>$data]);
    }



    /**
     *服务
     * @param $id
     * @return mixed
     */
    public function service(){
        $datas=Service::all();
        return $this->fetch('service',['datas'=>$datas]);
    }
    public function services($id){
        $data=Service::get($id);
        return $this->fetch('notices',['data'=>$data]);
    }

    /**
     *小区活动
     * @param $id
     * @return mixed
     */

    public function xarticle(){
        $datas=Xarticle::all();
        return $this->fetch('xarticle',['datas'=>$datas]);
    }
    public function xarticles($id){
        $data=Xarticle::get($id);
        return $this->fetch('xarticles',['data'=>$data]);
    }

    /**
     *商家活动
     * @param $id
     * @return mixed
     */
    public function darticle(){
        $datas=Darticle::all();
        return $this->fetch('darticle',['datas'=>$datas]);
    }
    public function darticles($id){
        $data=Darticle::get($id);
        return $this->fetch('darticles',['data'=>$data]);
    }
    /**
     *租售
     * @param $id
     * @return mixed
     */
    public function zs(){
        $zs=new Zs();
        $zus=$zs->where(['type'=>0])->select();
        $shous=$zs->where(['type'=>1])->select();
//        var_dump($zs);exit;
        return $this->fetch('zs',['zus'=>$zus,'shous'=>$shous]);

    }
    public function zss($id){
        $data=Zs::get($id);
        return $this->fetch('zss',['data'=>$data]);
    }






}
