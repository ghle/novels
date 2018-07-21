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
namespace app\admin\controller;

use app\admin\model\FeedbackModel;

class Feedback extends Base
{
    // 文章列表
    public function index()
    {
        if(request()->isAjax()){

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
           
            $Feedback = new FeedbackModel();
            $selectResult = $Feedback->getFeedbacksByWhere($where, $offset, $limit);

            
            foreach($selectResult as $key=>$vo){
            
                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['fid']));
            }

            $return['total'] = $Feedback->getAllFeedbacks($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    public function FeedbackDel()
    {
        $id = input('param.fid');

        $Feedback = new FeedbackModel();
        $flag = $Feedback->delFeedback($id);
        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }

    // 上传缩略图
    public function uploadImg()
    {
        if(request()->isAjax()){

            $file = request()->file('file');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'upload');
            if($info){
                $src =  '/novels/public/upload' . '/' . date('Ymd') . '/' . $info->getFilename();
                return json(msg(0, ['src' => $src], ''));
            }else{
                // 上传失败获取错误信息
                return json(msg(-1, '', $file->getError()));
            }
        }
    }

    /**
     * 拼装操作按钮
     * @param $id
     * @return array
     */
    private function makeButton($fid)
    {
    
         return [
            
            '删除' => [
                'auth' => 'feedback/feedbackdel',
                'href' => "javascript:feedbackDel(" . $fid . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
    
        ];
    }
}
