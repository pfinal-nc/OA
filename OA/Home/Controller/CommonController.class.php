<?php
	namespace Home\Controller;
	use Think\Controller;

	class CommonController extends Controller{
		public function _initialize(){
			if(is_null(session('admin')))
			{

				$this->error('请登录',U('Login/index'));
				return false;
			}
		}

		//拼接字符串的方法
		static function sub($str)
		{
			return substr($str,0,4).'/'.substr($str,4,2).'/'.substr($str,6,2).'/';
		}
	}