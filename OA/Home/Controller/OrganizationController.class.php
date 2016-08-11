<?php  

	namespace Home\Controller;
		header("content-type:text/html;charset=utf-8");  
		class OrganizationController extends CommonController{
			
			public function index(){
				
				$pid = $_GET['pid']?$_GET['pid']:0;
				//页面显示
				$model = D('Organization');

				//第一个页面只显示顶级页面
				$org = $model ->where('pid='.$pid)->select();
				//var_dump($org);

				//用来做返回上一层------------------------------------------------------
				foreach ($org as $ke=>$va) {
					//利用子类的PID=父类的id 查询父类的pid (当前页面的pid = 上层的id 得到上层的pid ) 传给上面$pid = $_GET['pid']?$_GET['pid']:0; 用于显示页面的内容
					$or = $model ->field('pid')->where('id='.$org[$ke]['pid'])->select();
				}
				//---------------------------------------------------------------------
				// var_dump($org);
				// var_dump($or[0]);
				$this ->assign('or',$or[0]);
				$this ->assign('org',$org);
				$this->display();
			}

			//部门添加页面
			public function add(){

				$model = D('Organization');
				$Organization = $model->setAll();

				//用于自分类缩进
				foreach ($Organization as $key => $value) {
					//把每个分类的path 切割成数组，计算个数 区分多少级分类
					$num = count(explode(',', rtrim($value['path'],',')))-1;
					//重复使用空格 把父级分类和子级分类分开
					//顶级分类使用空格0次，二级分类使用一次.....
					$Organization[$key]['name'] = str_repeat('&nbsp;&nbsp',$num).$value['name'];
				}
				 $this->assign('Organization',$Organization);
				$this->display();

			}
			
			public function adds(){
			 
				//配置文件Conf 已经配置了模型定义Oa_
			 	$model = D('Organization');

			 	//开启事务处理
			 	$model->startTrans();
			 	//自动验证，自动得到添加时间
			 	$data=$model->create();
				
			 	// var_dump($data);
			 	// var_dump($_POST);
			 	if (!$data) {
			 		$this->error($model->getError(),U('Organization/add'),1);
			 	}else{

			 		//判断是顶级部门还是下级部门 如果为真则是下级部门
			 		if ($_POST['org']) {
			 			
			 			// 得到pid 子类的pid是父类的id
			 			$data['pid']=$_POST['org'];
			 			 //var_dump($data['pid']);
			 			//查询得到父级path 用父级的ID查询
			 			$path = $model ->getAll($data['pid']);
			 			
			 			//var_dump($path);
			 			$data['path'] = $path[0]['path'].$data['pid'].',';
			 			//var_dump($data['path']);
			 			//插入数据库
			 			$resd=$model->add($data);
			 			if ($resd) {
			 				$model ->commit();
			 				$this->success('添加顶级部门成功');
			 			}else{
			 				$model->rollback();
			 				$this->success('添加失败');
			 			}
			 			//var_dump($resd);
			 		}else{
			 			//最开始得先添加顶级分类
			 			$data['pid'] = 0;
			 			$data['path'] = '0,';
			 			$res=$model->data($data)->add();
			 			if ($res) {
			 				$model ->commit();
							$this->success('添加顶级部门成功');
			 			}else{
			 				$model->rollback();
			 				$this->success('添加失败');
			 			}
			 			
			 		}

			 	}
			 	
			 }

			 //删除
			public function dele(){

				$id = $_GET['id'];
				$model = M('Organization');
				//先查询一下该分类下是否有子分类
				$pid=$model->where('pid='.$id)->select();
				
				if ($pid) {
					$this->error('请先删除分类');
				}else{

					$res = $model->where('id='.$id)->delete();

					if ($res) {
					$this->success('删除成功');
				 	}else{
			 				$this->success('删除失败');
				 	}
				}
				
			

			}



		}

?>