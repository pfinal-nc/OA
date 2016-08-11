<?php
	namespace Home\Controller;

	class NewsController extends CommonController{
		public function index(){
			
			$Model = M('News');
			$list = $Model->where(['status'=>1])->select();
			
			foreach($list as $key=>$val)
			{
				$list2=M('Member')->where(['id'=>$val['uid']])->find();
				$list[$key]['name']=$list2['name'];
				$list[$key]['addtime']=date('Y年m月d日',time());
			}
			//var_dump($list);
			$this->assign('list',$list);
			//var_dump($list2);
			
			 $this->display('News/Index');
			
			
		}
		
		public function add()
		{
			$this->display('News/add');
		}
		
		public function doadd(){
			
			$id = $_SESSION['home']['id'];
			//var_dump($_POST);
			$Model = M('News');
			$data['uid']=$id;
			$data['title']=$_POST['title'];
			$data['content']=$_POST['content'];
			$data['addtime']=time();
			
			$res = $Model->add($data);
			
			if($res){
					$this->success('添加成功',U('News/index'),2);
			}
			
		}
		
		public function up()
		{
			$Model = M('News');
			$list = $Model->select();
			
			foreach($list as $key=>$val)
			{
				$list2=M('Member')->where(['id'=>$val['uid']])->find();
				$list[$key]['name']=$list2['name'];
				$list[$key]['addtime']=date('Y年m月d日',time());
			}
			//var_dump($list);
			$this->assign('list',$list);
			//var_dump($list2);
			
			$this->display('News/Up');
		}
		
		public function doup(){
			
			$id = $_GET['id'];
			$where['id']=$id;
			$Model = M('News');
			$list = $Model->where($where)->select();
			//var_dump($list);
			$data['status']=$list[0]['status']==0?1:0;
			$res = $Model->where($where)->save($data);
			if($res)
			{
				$this->redirect('News/up');
			}
			
		}
		
		public function del(){
			
			$id = $_GET['id'];
			$Model = M('News');
			$res = $Model->where('id='.$id)->delete();
			if($res){
				
				$this->redirect('News/up');
			}
		}
		
		
		
	}