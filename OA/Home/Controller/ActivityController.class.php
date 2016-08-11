<?php 
	namespace Home\Controller;
	use Think\Controller;

	class ActivityController extends CommonController{
		public function index()
		{
			//查询数据
			$model=D('activity');

			//做模糊查询传值
			$content=$_GET['content'];
			
			//总条数
			$total=$model->where("content like'%$content%'")->count();
			//总页数
			$page=new \Think\Page($total,1);
			$page->setConfig('header','总页数');
			$page->setConfig('prev','上一页');
			$page->setConfig('next','下一页');
			//exit;
			$page_str=$page->show();
			$limit=$page->firstRow.','.$page->listRows;

			$list=$model->getAll($content,$limit);
			foreach ($list as $key => $value) {
				$list[$key]['atime']=date('Y年m月d日',$value['atime']);
			}
			//var_dump($list);exit;
			//发送数据
			$this->assign('page',$page_str);

			$this->assign('list',$list);
			//加载模板
			$this->display();
		}

		public function add()
		{
			if (empty($_POST))
			{
				//展示出页面分类下拉列表
				$orgModel=M('organization');
				//手动批量添加数据
				/*$dataList[] = array('name'=>'制造中心','pid'=>'0','path'=>'0,');
				$dataList[] = array('name'=>'生产部','pid'=>'1','path'=>'0,1,');
				$dataList[] = array('name'=>'设备部','pid'=>'1','path'=>'0,1,');
				$data=$orgModel->addAll($dataList);*/
				//var_dump($data);exit;


				$sql="select `id`,`name`,`pid`,`path`,concat(path,id) bpath from `oa_organization` order by bpath";
				$list=$orgModel->query($sql);
				//var_dump($list);exit;
				foreach ($list as $key => &$value) 
				{
					//第几级
					$num=count(explode(',', rtrim($value['path'],',')))-1;
					$list[$key]['name']=str_repeat('&nbsp;&nbsp;', $num).$value['name'];

					//var_dump($list);exit;
				}
				$this->assign('list',$list);
				$this->display();
				return false;		
				}
			$model=D('activity');
			//根据表单提交的POST数据创建数据对象
			//var_dump($_POST);exit;
			$data=$model->create();
			if (!$data) {
			// 如果创建失败表示验证没有通过 输出错误提示信息
				$this->error($model->getError());
			}else{
				//手动添加用户
				$_SESSION['home']['id']='1';
				//var_dump($_SESSION);exit();
				$data['uid']=$_SESSION['home']['id'];
				$res=$model->setAdd($data);
				if ($res) {
					//添加成功
					$this->success('添加活动成功',U('Activity/index'),2);
					return false;
				}else{
					$this->error('添加失败');
				}
			}
		}
	}
?>