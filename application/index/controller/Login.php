<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 21:45
 */

namespace app\index\controller;


use app\common\controller\Common;
use app\index\model\User;
use think\Db;

class Login extends Common{

    public function index(){
        return $this->fetch('index');
    }

    public function save(){
        if(request()->isPost()){
            $data=request()->post();
            $userModel=new User();
            $validate=$this->validate($data,'User');
            if($validate!==TRUE){
                $this->error($validate);
            }
            $data['password']=md5($data['password']);
            $res=$userModel->save($data);
            if($res==1){
                $this->success('注册成功',url('index/login/index'));
            }else{
                $this->error('注册失败'.$userModel->getError());
            }
        }else{
            return $this->fetch('save');
        }
    }
    public function check(){
        $data=request()->post();
        $checkCode=$this->validate($data,[
            'captcha|验证码'=>'require|captcha'
        ]);
        if ($checkCode!==true){
            $this->error($checkCode);
        }
        $model=new User();
        $userInfo=$model->where(['user'=>$data['user']])->find();
        if ($userInfo){
            if ($userInfo->password===md5($data['password'])){
                //存session
                session("userinfo",$userInfo);
                $this->success("登录成功",url("index/online/my"));
            }
        }
        $this->error("登录失败");
    }
    public function logout()
    {
        session("userinfo",null);
        $this->success("退出成功",url("index/Index/index"));
    }
    public function info(){
        return $this->fetch();
    }
    public function edit($id){
        if(request()->isPost()){
            $data=request()->post();
            $res=Db::name("cms_user")->where(['id'=>$id])->update($data);
            if($res==1){
                $this->success('修改成功','index/online/my');
            }else{
                $this->error('修改失败',null,null);
            }
        }else{
            $row=Db::name("cms_user")->find(['id'=>$id]);
            return $this->fetch('edit',['row'=>$row]);
        }
    }
}