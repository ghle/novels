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

class FeedbackModel extends Model
{
    // 确定链接表名
    protected $table = 'snake_feedback';

    /**
     * 查询反馈
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getFeedbacksByWhere($where, $offset, $limit)
    {
        return $this->where($where)->limit($offset, $limit)->order('fid desc')->select();
    }

    /**
     * 根据搜索条件获取所有的反馈数量
     * @param $where
     */
    public function getAllFeedbacks($where)
    {
        return $this->where($where)->count();
    }

   
    /**
     * 根据反馈的id 获取反馈的信息
     * @param $id
     */
    public function getOneFeedback($id)
    {
        return $this->where('id', $id)->find();
    }

    /**
     * 删除反馈
     * @param $id
     */
    public function delFeedback($id)
    {
        try{

            $this->where('fid', $id)->delete();
            return msg(1, '', '删除反馈成功');

        }catch(\Exception $e){
            return msg(-1, '', $e->getMessage());
        }
    }
}