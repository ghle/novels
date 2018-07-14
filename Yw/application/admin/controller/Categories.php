<?php

namespace app\admin\controller;


use app\admin\model\CategoriesModel;

class Categories extends Base
{

   

    public function index()
    {
            
     if(request()->isAjax()){

                $param = input('param.');

                $limit = $param['pageSize'];
                $offset = ($param['pageNumber'] - 1) * $limit;
              

                $where = [];
               

                $categories = new CategoriesModel();
                $selectResult = $categories->getCategoriesByWhere($where, $offset, $limit);
                
                foreach($selectResult as $key=>$vo){
                    $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['cid']));
                }

                $return['total'] = $categories->getAllCategories($where);  // 总数据
                $return['rows'] = $selectResult;

             return json($return);
            }
        return $this->fetch();
   
    }


    // 添加导航
    public function categoriesAdd()
    {
        if(request()->isPost()){
            $param = input('post.');

            
            $param['createtime'] = date('Y-m-d H:i:s');
           
            $categories = new CategoriesModel();


            $flag = $categories->addCategories($param);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        return $this->fetch();
    }


    public function categoriesEdit()
    {
        $categories = new categoriesModel();
        if(request()->isPost()){

            $param = input('post.');
            
            $flag = $categories->editcategories($param);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        $id = input('param.cid');
        $this->assign([
            'categories' => $categories->getOnecategories($id)
        ]);
        return $this->fetch();
    }

    public function categoriesDel()
    {
        $id = input('param.cid');

        $categories = new categoriesModel();
        $flag = $categories->delcategories($id);
        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }





      /**
     * 拼装操作按钮
     * @param $id
     * @return array
     */
    private function makeButton($id)
    {
        return [
            '编辑' => [
                'auth' => 'categories/categoriesedit',
                'href' => url('categories/categoriesedit', ['cid' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'categories/categoriesdel',
                'href' => "javascript:categoriesDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }


}