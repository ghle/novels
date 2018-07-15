<?php

namespace app\admin\controller;


use app\admin\model\BooksModel;



class Books extends Base
{

	  public function index()
    {
            
     if(request()->isAjax()){

                $param = input('param.');

                $limit = $param['pageSize'];
                $offset = ($param['pageNumber'] - 1) * $limit;
                
                $where = [];
             
                $Books = new BooksModel();

                $res=db('categories')->select();

                $selectResult = $Books->getBooksByWhere($where, $offset, $limit);

                foreach($selectResult as $key=>$vo){

                         foreach($res as $k=>$v){
                            if($selectResult[$key]['bpid']==$res[$k]['cid']){
                               $selectResult[$key]['bpid']=$v['catenames'];
                            }
                         
                         }
                    
                     $selectResult[$key]['bintroduction']= $this->subtext($selectResult[$key]['bintroduction'],30);
                	 $selectResult[$key]['bicon'] = '<img src="' . $vo['bicon'] . '" width="80px" height="100px">';
                     $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['bid'])); 
  
                }

                $return['total'] = $Books->getAllBooks($where);  // 总数据
                $return['rows'] = $selectResult;

             return json($return);
            }
        return $this->fetch();
   
    }


    // 添加导航
    public function booksAdd()
    {

        $list=db('categories')->select();

        if(request()->isPost()){
            $param = input('post.');
         
           
            $books = new booksModel();


            $flag = $books->addbooks($param);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        $this->assign('list',$list);

        return $this->fetch();
    }


    public function booksEdit()
    {
        $list=db('categories')->select();
      
        $books = new booksModel();
        if(request()->isPost()){

            $param = input('post.');
            
            $flag = $books->editbooks($param);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        $id = input('param.bid');
        $this->assign([
            'books' => $books->getOnebooks($id)
        ]);

        $this->assign('list',$list);

        return $this->fetch();
    }

    public function booksDel()
    {
        $id = input('param.bid');

        $books = new booksModel();
        $flag = $books->delbooks($id);
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
                'auth' => 'books/booksedit',
                'href' => url('books/booksedit', ['bid' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'books/booksdel',
                'href' => "javascript:booksDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
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




}