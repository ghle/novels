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
namespace app\admin\validate;

use think\Validate;

class BooksValidate extends Validate
{
    protected $rule = [
        ['bname', 'require', '图书名称不能为空'],
        ['bauthor', 'require', '图书作者不能为空'],
        ['bintroduction','require', '图书描述不能为空']
        
    ];

}