<?php 
namespace  app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Validate;

class Common extends Controller
{
	
	protected $request;
    protected $validater; 
    protected $params; 
    protected $rules=array(

    		'Index'=>array(
                'index'=>array(),

                'bookslist'=>array(
                      'bpid'=>'require',
                ),

                'booksdetail'=>array(
                     'id'=>'require',
                ),
                'articlesdetail'=>array(),
                
                'indexrecommend'=>array(),
                
                'search'   =>array(
                    'bname'=>'require'
                )
    		)
    );
	 protected function _initialize()
    {
        parent::_initialize();
        $this->request = Request::instance();

        $this->params = $this->check_params($this->request->param(true));
    }

    public function check_params($arr)
    {

	        $rule = $this->rules[$this->request->controller()][$this->request->action()];

	        $this->validater = new Validate($rule);

	        if (!$this->validater->check($arr)) {
	            $this->return_msg(400, $this->validater->getError());
	        }
	      
	        return $arr;
    }
	

     public function return_msg($code, $msg = '', $data = [])
    {
        $return_data['code'] = $code;
        $return_data['msg'] = $msg;
        $return_data['data'] = $data;
        echo json_encode($return_data);die;
    }
}

?>