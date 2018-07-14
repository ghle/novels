<?php
namespace app\index\controller;

use think\Controller;

use think\Db;

class Index extends Controller
{
    public function index()
    {
        $res=db('articles')->select();

        return $this->msg(200,$res,'正确');
    }

    public function msg($code='',$data=[],$msg='')
    {
    	$data['code']=$code;
    	$data['data']=$data;
    	$data['msg'] =$msg;
    	echo json_encode($data);die;
    }
}
