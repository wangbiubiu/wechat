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

namespace app\cms\admin;

use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use app\cms\model\Wjdc as WjdcModel;
use app\cms\model\AdvertType as AdvertTypeModel;
use think\Validate;

/**
 * 广告控制器
 * @package app\cms\admin
 */
class Wjdc extends Admin
{
    /**
     * 广告列表
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 排序
        $order = $this->getOrder('create_time desc');
        // 数据列表
        $data_list = WjdcModel::where($map)->order($order)->paginate();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['name' => '标题']) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                           ['name', '问卷标题','text.edit'],
                ['content', '描述', 'text'],
                           ['url', '链接', 'text'],
                           ['status', '是否前台显示', 'switch'],
                ['start_time', '开始时间', 'text'],
                ['end_time', '结束时间', 'text'],
//                           ['status_name', '是否前台显示', 'text'],
                ['right_button', '操作', 'btn'],
            ])
            ->addTopButtons('add,enable,disable,delete') // 批量添加顶部按钮
             // 添加顶部按钮
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']]) // 批量添加右侧按钮
            ->setRowList($data_list) // 设置表格数据
            ->addValidate('Wjdc', 'name')
            ->fetch(); // 渲染模板
    }

    /**
     * 新增
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function add()
    {

        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            // 验证
            $result = $this->validate($data, 'Wjdc');
            if (true !== $result) $this->error($result);
//            if ($data['ad_type'] != 0) {
//                $data['link'] == '' && $this->error('链接不能为空');
//                Validate::is($data['link'], 'url') === false && $this->error('链接不是有效的url地址'); // true
//            }
            if ($Wjdc = WjdcModel::create($data)) {
                // 记录行为
                action_log('Wjdc_add', 'cms_Wjdc', $Wjdc['id'], UID, $data['title']);
                $this->success('新增成功', 'index');
            } else {
                $this->error('新增失败');
            }
        }


        // 显示添加页面
        return ZBuilder::make('form')
//            ->setPageTips('如果出现无法添加的情况，可能由于浏览器将本页面当成了广告，请尝试关闭浏览器的广告过滤功能再试。', 'warning')
            ->addFormItems([
               ['text', 'name', '标题'],
               ['text', 'content', '详情'],
               ['text', 'url', '链接'],
               ['date', 'start_time', '开始时间'],
               ['date', 'end_time', '结束时间'],
            ])->addRadio('status', '状态', '', ['0' => '关闭', '1' => '开启'],'0')
            ->fetch();
    }

    /**
     * 编辑
     * @param null $id 广告id
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function edit($id = null)
    {
        if ($id === null) $this->error('缺少参数');

        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();

            // 验证
            $result = $this->validate($data, 'Wjdc');
            if (true !== $result) $this->error($result);


            if (WjdcModel::update($data)) {
                // 记录行为

                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }



        $info = WjdcModel::get($id);


        // 显示编辑页面
        return ZBuilder::make('form')
            ->addFormItems([
                ['hidden','id','ID'],
                ['text', 'name', '标题'],
                ['text', 'content', '详情'],
                ['text', 'url', '链接'],
                ['date', 'start_time', '开始时间'],
                ['date', 'end_time', '结束时间'],
                           ])->addRadio('status', '状态', '', ['0' => '关闭', '1' => '开启'],'0')
                       ->setFormData($info)
                       ->fetch();
    }
    /**
     * 删除广告
     * @param array $record 行为日志
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function delete($record = [])
    {
        return $this->setStatus('delete');
    }

    /**
     * 启用广告
     * @param array $record 行为日志
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function enable($record = [])
    {
        return $this->setStatus('enable');
    }

    /**
     * 禁用广告
     * @param array $record 行为日志
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function disable($record = [])
    {
        return $this->setStatus('disable');
    }

    /**
     * 设置广告状态：删除、禁用、启用
     * @param string $type 类型：delete/enable/disable
     * @param array $record
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function setStatus($type = '', $record = [])
    {
        $ids         = $this->request->isPost() ? input('post.ids/a') : input('param.ids');
        $advert_name = WjdcModel::where('id', 'in', $ids)->column('title');
        return parent::setStatus($type, ['advert_'.$type, 'cms_advert', 0, UID, implode('、', $advert_name)]);
    }

    /**
     * 快速编辑
     * @param array $record 行为日志
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function quickEdit($record = [])
    {
        $id      = input('post.pk', '');
        $field   = input('post.name', '');
        $value   = input('post.value', '');
        $advert  = WjdcModel::where('id', $id)->value($field);
        $details = '字段(' . $field . ')，原值(' . $advert . ')，新值：(' . $value . ')';
        return parent::quickEdit(['Wjdc_edit', 'cms_Wjdc', $id, UID, $details]);
    }
}