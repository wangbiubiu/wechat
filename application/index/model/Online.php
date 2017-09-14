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

namespace app\index\model;

use think\Model as ThinkModel;

/**
 * 广告模型
 * @package app\cms\model
 */
class Online extends ThinkModel
{
    public $name='cms_online';
    public function getStatusAttr($value)
    {
        $status = [0=>"等待审核",
                   1=>"维修完成",
                   2=>'未通过',
                   3=>'审核通过处理中'
        ];
        return $status[$value];
    }




}