<?php
namespace app\index\controller;


class Index extends Common
{
    /**
     * @function [首页分类导航]
     * @Author   lucky
     * @DateTime 2018-07-15
     * @version  [version]
     * @return   [type]        [description]
     */
    public function index()
    {
        $res=db('categories')->select();

        return $this->return_msg(200,'返回成功',$res);
       
    }
 /**
  * @function [图书列表 list]
  * @Author   lucky
  * @DateTime 2018-07-15
  * @version  [version]
  * @return   [type]        [description]
  */
    public function bookslist()
    {
    	$param=$this->params;

        $res=db('books')->where('bpid',$param['bpid'])->select();

        return $this->return_msg(200,'返回成功',$res);
    }
/**
 * @function [图书详情 detail]
 * @Author   lucky
 * @DateTime 2018-07-15
 * @version  [version]
 * @param    [type]        $id [description]
 * @return   [type]            [description]
 */
    public function booksdetail()
    {
        $param= $this->params;

        $where['bid']=$param['id'];

        $data=db('books')->where($where)->find();


        $wheres['apid']=$where['bid'];

        $datas=db('articles')->where($wheres)->field('title,keywords,add_time,id')->select();


        $data['num']=count($datas);


        $return['booksinfo']=$data;

        $return['contents']=$datas;

        return $this->return_msg(200,'返回成功',$return);


       
  
    }

    /**
     * @function [文章详情]
     * @Author   lucky
     * @DateTime 2018-07-15
     * @version  [version]
     * @return   [type]        [description]
     */
    public function articlesdetail()
    {
         $param= $this->params;

         $res=db('articles')->where('keywords',$param['keywords'])->find();

        if ($res) {

            return $this->return_msg(200,'返回成功',$res);

        }else{

            return $this->return_msg(400,'返回数据为空','');
        }

       
  


        
    }
    /**
     * @function [小说推荐]
     * @Author   lucky
     * @DateTime 2018-07-20
     * @version  [version]
     * @return   [type]        [description]
     */
    public function indexrecommend()
    {

          $data=db('books')->field('bname,bicon,bid')->select();
          if ( $data) {
               return $this->return_msg(200,'返回成功',$data);
          }else{

            return $this->return_msg(400,'返回数据为空','');
         }

        
    }

    /**
     * @function [搜索接口]
     * @Author   lucky
     * @DateTime 2018-07-20
     * @version  [version]
     * @return   [type]        [description]
     */
    public function search()
    {
        $param=$this->params;

        if(empty($param['bname'])){
            return $this->return_msg(400,'返回数据为空','');die;
        }
       
        $map['bname'] = ['like',"%".$param["bname"]."%"];

        $res=db('books')->where($map)->select();

        if ($res) {

            return $this->return_msg(200,'返回成功',$res);

        }else{

            return $this->return_msg(400,'返回数据为空','');
        }

    }
    /**
     * @function [信息反馈]
     * @Author   lucky
     * @DateTime 2018-07-20
     * @version  [version]
     * @return   [type]        [description]
     */
    public function feedback()
    {
        $param=$this->params;

        $param['feedtime']=date("Y-m-d H:i:s");

    
        $res=db('feedback')->insert($param);

        if ($res) {

            return $this->return_msg(200,'返回成功',$res);

        }else{

            return $this->return_msg(400,'返回数据为空','');
        }
    }

  
}
