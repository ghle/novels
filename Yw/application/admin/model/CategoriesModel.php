<?php
// +----------------------------------------------------------------------
// | snake
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2022 http://baiyf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: NickBai <1902822973@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Model;

class CategoriesModel extends Model
{
    // 确定链接表名
    protected $table = 'snake_categories';

    /**
     * 查询导航
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getCategoriesByWhere($where, $offset, $limit)
    {
        return $this->where($where)->limit($offset, $limit)->order('cid desc')->select();
    }

    /**
     * 根据搜索条件获取所有的导航数量
     * @param $where
     */
    public function getAllCategories($where)
    {
        return $this->where($where)->count();
    }

    /**
     * 添加导航
     * @param $param
     */
    public function addCategories($param)
    {
        try{
            $result = $this->validate('CategoriesValidate')->save($param);
            if(false === $result){
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            }else{

                return msg(1, url('Categories/index'), '添加导航成功');
            }
        }catch (\Exception $e){
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 编辑导航信息
     * @param $param
     */
    public function editCategories($param)
    {
        try{

            $result = $this->validate('CategoriesValidate')->save($param, ['cid' => $param['cid']]);

            if(false === $result){
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            }else{

                return msg(1, url('Categories/index'), '编辑导航成功');
            }
        }catch(\Exception $e){
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 根据导航的id 获取导航的信息
     * @param $id
     */
    public function getOneCategories($id)
    {
        return $this->where('cid', $id)->find();
    }

    /**
     * 删除导航
     * @param $id
     */
    public function delCategories($id)
    {
        try{

            $this->where('cid', $id)->delete();
            return msg(1, '', '删除导航成功');

        }catch(\Exception $e){
            return msg(-1, '', $e->getMessage());
        }
    }
}