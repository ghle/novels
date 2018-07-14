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

class BooksModel extends Model
{
    // 确定链接表名
    protected $table = 'snake_books';

    /**
     * 查询图书
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getBooksByWhere($where, $offset, $limit)
    {
        return $this->where($where)->limit($offset, $limit)->order('bid desc')->select();
    }

    /**
     * 根据搜索条件获取所有的图书数量
     * @param $where
     */
    public function getAllBooks($where)
    {
        return $this->where($where)->count();
    }

    /**
     * 添加图书
     * @param $param
     */
    public function addBooks($param)
    {
        try{
            $result = $this->validate('BooksValidate')->save($param);
            if(false === $result){
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            }else{

                return msg(1, url('Books/index'), '添加图书成功');
            }
        }catch (\Exception $e){
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 编辑图书信息
     * @param $param
     */
    public function editBooks($param)
    {
        try{

            $result = $this->validate('BooksValidate')->save($param, ['bid' => $param['bid']]);

            if(false === $result){
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            }else{

                return msg(1, url('Books/index'), '编辑图书成功');
            }
        }catch(\Exception $e){
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 根据图书的id 获取图书的信息
     * @param $id
     */
    public function getOneBooks($id)
    {
        return $this->where('bid', $id)->find();
    }

    /**
     * 删除图书
     * @param $id
     */
    public function delBooks($id)
    {
        try{

            $this->where('bid', $id)->delete();
            return msg(1, '', '删除图书成功');

        }catch(\Exception $e){
            return msg(-1, '', $e->getMessage());
        }
    }
}