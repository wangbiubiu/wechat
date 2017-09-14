<?php
namespace app\index\validate;

use think\Validate;

class User extends Validate{
    protected $rule = [
        'user|用户名'  =>  'require|min:2|unique:user',
        'password|密码' =>  'require|min:6',
    ];
//    protected $scene = [
//        'add'   =>  ['username'],
//        'edit'  =>  ['username','password'],
//    ];
}