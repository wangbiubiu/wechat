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

namespace app\cms\model;

use think\Model as ThinkModel;

/**
 * 广告模型
 * @package app\cms\model
 */
class Online extends ThinkModel
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__CMS_ONLINE__';

    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    // 定义修改器
    public function setStartTimeAttr($value)
    {
        return $value != '' ? strtotime($value) : 0;
    }
    public function setEndTimeAttr($value)
    {
        return $value != '' ? strtotime($value) : 0;
    }
    public function getCreateTimeAttr($value)
    {
        return $value != 0 ? date('Y-m-d', $value) : '';
    }
    public function getEndTimeAttr($value)
    {
        return $value != 0 ? date('Y-m-d', $value) : '';
    }
//    public function getStatusAttr($value)
//    {
//        return $value != 1 ? '是' : '否';
//    }
//    public function getStatusAttr($value)
//    {
//        $status = [0=>'禁用',1=>'正常'];
//        return $status[$value];
//    }
    public function getStatusNameAttr($value,$data)
    {
        $yes=url('cms/online/yes')."?id=".$data['id'];
        $no=url('cms/online/no'."?id=".$data['id']);
        $ok=url('cms/online/ok'."?id=".$data['id']);
        $status = [0=>"等待审核&nbsp;<a class='btn btn-info' href=$yes>同意</a>&nbsp;<a class='btn btn-danger' href=$no>婉拒</a>",
                   1=>"处理中&nbsp;<a class='btn btn-info' href=$ok>维修完成</a>",
                   2=>'已拒绝',
                   3=>'已完成'
        ];
        return $status[$data['status']];
    }

    public function getTypeNameAttr($value,$data)
    {
        $status = [0=>'出租',1=>'售卖'];
        return $status[$data['type']];
    }


}