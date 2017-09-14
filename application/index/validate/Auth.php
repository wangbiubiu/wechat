<?php
namespace app\index\validate;

use think\Validate;

class Auth extends Validate{
    protected $rule = [
        'name|姓名'  =>  'require|min:2',
        'uid|身份证' =>  'require|member',
    ];
//    protected $scene = [
//        'add'   =>  ['username'],
//        'edit'  =>  ['username','password'],
//    ];
}