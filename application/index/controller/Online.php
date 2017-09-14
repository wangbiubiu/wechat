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
class Online extends Home
{
    public function _initialize(){
        if(!isset($_SESSION['userinfo']) and (empty(session('userinfo'))))
        {
            $this->error('请登录',url('index/Login/index'));
        }
    }

    public function online(){
        if(request()->isPost()){
            $data=request()->post();
            $data['code']=date('Ymd',time())."_".generate_code(8);
            $data['create_time']=time();
            $data['status']=0;
//            var_dump();exit;
            $data['user_id']=$_SESSION['dolphin_admin_']['userinfo']['id'];
            $res=Db::name("cms_online")->insert($data);
            if($res==1){
            $this->success('添加成功',url('index/index/index'));
            }else{
                $this->error('添加失败',null,null);
            }
        }else{
        return $this->fetch('online');
        }
    }

    public function auth(){
        if(request()->isPost()){
            $data=request()->post();
            $data['create_time']=time();
            $data['status']=0;
            $validate=$this->validate($data,'Auth');
            if($validate!==TRUE){
                $this->error($validate);
            }
            $res=Db::name("cms_auth")->insert($data);
            if($res==1){
                $this->success('认证成功等待审核',url('index/index/index'));
            }else{
                $this->error('失败',null,null);
            }
        }else{
            return $this->fetch('auth');
        }
    }



    public function my(){
        $id=$_SESSION['dolphin_admin_']['userinfo']['id'];
        $model= new \app\index\model\Online;
        $row=$model->where(['user_id'=>$id])->count();
//        var_dump($row);exit;
        return $this->fetch('my',['row'=>$row]);
    }

    public function row(){
        $id=$_SESSION['dolphin_admin_']['userinfo']['id'];
        $model= new \app\index\model\Online;
        $row=$model->where(['user_id'=>$id])->select();
//        var_dump($row);exit;
        return $this->fetch('row',['row'=>$row]);
    }



}
