<?php
namespace app\index\controller;


class Index extends Common
{
    public function index()
    {
        $res=db('categories')->select();

        return $this->return_msg(200,$res,'正确');
    }

  
}
