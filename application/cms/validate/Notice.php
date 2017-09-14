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

namespace app\cms\validate;

use think\Validate;

/**
 * 行为验证器
 * @package app\cms\validate
 * @author 蔡伟明 <314013107@qq.com>
 */
class Notice extends Validate
{
    //定义验证规则
    protected $rule = [
        'title|标题' => 'require|max:5',
        'start_time|开始时间'   => 'require',
        'status|状态'   => 'require',
        'end_time|结束时间'  => 'require',
        'content|内容' => 'require'
    ];
}
