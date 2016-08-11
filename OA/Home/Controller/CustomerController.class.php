<?php
	namespace Home\Controller;
	class CustomerController extends CommonController{
	    public function index(){
	    	if(!$_SESSION['home']['pid']==0){
	    		$display='none';
	    	}
	    	$Customermodel=D('Customer');
	    	$status='';
	    	$total='';
	    	$total=$Customermodel->count();
	    	$page=new \Think\Page($total,3);
			$page->setConfig('prev','上一页');
			$page->setConfig('next','下一页');
			$page_str=$page->show();
			$limit=$page->firstRow.','.$page->listRows;
			$list=$Customermodel->getalla($limit);
			$this->assign('uname',$_SESSION['home']['name']);
	    	$this->assign('page',$page_str);
	    	$this->assign('display',$display);
	    	$this->assign('list',$list);
	    	$this->display();	
	    }
	    public function input(){
	    	if(!$_SESSION['home']['pid']==0){
	    		$this->redirect('Customer/index');
	    	}
	    	$_SESSION['home']['id']=1;
	    	$this->assign('uname',$_SESSION['home']['name']);
	    	$this->display();
	    }
	    public function doinput(){

	    	if(empty($_POST['tel'])){
	    		$this->error('客户号码为空');
	    	}
	    	$pattern='/(\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$/' ;
	    	$patter='/^d+$/';
	    	if(!preg_match($pattern,$_POST['tel'])){
	    		$this->error('电话号码错误');
	    	}
	    	$data['uid']=$_SESSION['home']['id'];
	    	$data['status']=$_POST['status'];
	    	$data['tel']=$_POST['tel'];
	    	$data['addtime']=time();
	    	$Customermodel=D('Customer');
	    	$resu=$Customermodel->input($data);	
	    	if($resu){
	    		$this->success('录入成功',U('Customer/index'),2);
	    	}else{
	    		$this->error('录入失败');
	    	}    
	    }
	    public function deleted(){
	    	$id=$_GET['id'];
	    	$Customermodel=M('Customer');
	    	$res=$Customermodel->where('id='.$id)->delete();
	    	if($res){
	    		$this->success('删除成功',U('Customer/index'),2);
	    	}else{
	    		$this->error('删除失败');
	    	}
	    }
	    public function revise(){
	    	if(!$_SESSION['home']['pid']==0){
	    		$this->redirect('Customer/index');
	    	}
	    	$id=$_GET['id'];
	    	$Customermodel=M('Customer');
	    	$list=$Customermodel->where('id='.$id)->find();
	    	$this->assign('list',$list);
	    	$this->assign('uname',$_SESSION['home']['name']);
	    	$this->display();

	    }
	    public function dorevise(){
	    	$Customermodel=M('Customer');
	    	$id=$_GET['id'];
	    	$dat['status']=$_POST['status'];
	    	$dat['tel']=$_POST['tel'];
	    	$dat['addtime']=time();
	    	$list=$Customermodel->where('id='.$id)->find();
	    	$data=array_diff($dat,$list);
	    	// var_dump($data);exit;
	    	$res=$Customermodel->where('id='.$id)->save($data);
	    	if($res){
	    		$this->success('编辑成功',U('Customer/index'),2);
	    	}else{
	    		$this->error('编辑失败');
	    	}
	    }


	}	
