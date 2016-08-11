<?php
	namespace Home\Controller;
	use Think\Controller;

	class LoginController extends Controller{
	public function index(){
			$this->display();
		}
		public function login(){
			$data['name'] = htmlspecialchars(trim($_POST['name']));
		    $data['pwd']  = md5(trim($_POST['pwd']));
		    $model =D('Member');
		    $res=$model->getFind($data);
		    if($res){
		    		$_SESSION['home']=$res;
		    		if($res['status']==2)
                    $this->error('此用户已经被禁用'); 
                    $this->success('登录成功',U('Index/index'),2);
		    	}else{
		    		$this->error('登录错误',U('Login/index'));
		    }
    	}

    public function loginout(){
		    unset($_SESSION['home']);
		    $this->success('退出成功',U('Index'),2);
    }
}