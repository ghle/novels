<?php
namespace app\index\controller;


class Index extends Common
{
    public function index()
    {
        $res=db('categories')->select();

        return $this->return_msg(200,'返回成功',$res);
       
    }

    public function bookslist()
    {
    	 $res=db('books')->select();

        return $this->return_msg(200,'返回成功',$res);
    }

  
}
