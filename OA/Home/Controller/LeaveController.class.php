<?php 
	namespace Home\Controller;
	use Think\Controller;

	class LeaveController extends Controller{
		public function index(){
			$model=D('leave');
			//模糊查询传值
			$name=$_GET['content'];
			//总条数
			$total=$model->where("content like'%$name%'")->count();
			//总页数
			$page=new \Think\Page($total,5);
			$page->setConfig('header','总页数');
			$page->setConfig('prev','上一页');
			$page->setConfig('next','下一页');
			
			$page_str=$page->show();
			$limit=$page->firstRow.','.$page->listRows;
			$list=$model->getAll($name,$limit);

			//发送数据
			$this->assign('page',$page_str);
			$this->assign('list',$list);
			//加载模板
			$this->display();
		}

		public function add()
		{
			if (empty($_POST)) {
				$this->display();
				return false;
			}

			
			if (empty($_POST['content'])) {
				$this->error('请假缘由不能为空');
				return false;
			}
				
			//var_dump($_POST);exit();
			if ($_POST['sname']==2) {
				$data['p_uid']=2;
			}
			if ($_POST['sname']==1) {
				$data['p_uid']=1;
			}
			if ($_POST['sname']==0) {
				$data['p_uid']=0;
			}

			$_SESSION['home']['id']=1;
			$data['uid']=$_SESSION['home']['id'];
			//$data['status']=0;
			$data['content']=$_POST['content'];
			$data['addtime']=$_POST['addtime'];
			$data['sname']=$_POST['sname'];
			$data['mo']=$_POST['mo'];
			
			$model=D('leave');

			$info=$model->setAdd($data);
			if ($info) {
				$this->success('提交成功',U('Leave/index'));
				return false;
			}else
			{
				$this->error('提交失败');
			}

			foreach ($list as $key => $value) {
				$list[$key]['la']=date('Y/m/d H:i:s',$value['la']);
			}



		}

		public function delete()
		{
			$id=$_GET['id'];
			$model=M('leave');
			$res=$model->delete($id);
			if ($res) {
				$this->success('数据删除成功',U('Leave/index'),2);
			}			
			
		}

		public function tong()
		{
			//var_dump($_GET['id']);exit();
			$where['id']=$_GET['id'];
			$model=M('Leave');
			$status=$model->where($where)->select();
			//var_dump($status);exit();
			$data['status']=$status[0]['status']==0?1:0;
			$res=$model->where($where)->save($data);
			//var_dump($res);exit();
			if ($res) 
			{
				$this->redirect('Leave/index');
			}
		}




	}







 ?>