<?php

	namespace Home\Model;
		use Think\Model;
		//配置文件Conf 已经配置Oa_
		class OrganizationModel extends Model{
			//自动验证属性
			protected $_validate = array(
				//require 必填 如果为空就触发第3参数
				array('name','require','部门名不能为空'),
				);
			//自动完成时间
			protected $_auto = array(
				//自动完成添加时间，function 验证time是个函数 1是权限新增数据的时候处理（默认）
				array('addtime','time',3,'function'),
				);


			    //这里是查询顶级分类的 和 子部门
		        public function getAllm($data){
		           return $this->where($data)->select();
		        }
		        
			//查询获得父级的path
			public function getAll($list){
				
				//添加子分类的时候  首先得到父级path用来拼接成自己的path
				$path = $this->field('path')->where('id='.$list)->select();

				return $path;
			}

			public function setAll(){
				//无限级 path和id拼接  按照pathid排序 得到子分类在父级分类下面
				$list=$this->field('id,pid,name,path,concat(path,id) pathid')->order('pathid')->select();
				// var_dump($list);
				return $list;
			}
			public function retAll($limit){
				$list=$this->field('ooa.id ooaid,ooa.name ooaname,ome.name omename,ooa.addtime ooaadd')->table('oa_organization ooa,oa_member ome')->where('ome.Organization_id=ooa.id and ome.Order=0 and ome.status=1')->limit($limit)->select();
				return $list;
			}

			public function cetAll($id){
				$result=array();
				$list=$this->select();
				foreach ($list as $key => $value) {
				   $arr=explode(',', $value['path']);
				   $result[$key]=$arr;
				} 

				foreach ($result as $ke => $valu) {
					if (in_array($id, $valu)) {
						  $str.=1;
					}
				}
				    return count($str);
			}


			   //这里是为添加员工获取所有的部门的
	        public function getOrder(){
	            $sql="select id,name,pid,path,concat(path,id) bpath from oa_organization order by bpath";
	            $list = $this->query($sql);
	            foreach($list as $k=>$v){
	                $num = count(explode(',',rtrim($v['path'],',')))-1;
	                $list[$k]['name']=str_repeat('&nbsp;&nbsp;',$num).$v['name'];
	            }
	            return $list;
	        }

	        //这里是模糊查询子分类的
	        public function Mohu($like){
	            $sql ="select `id` from oa_organization where path like '$like'";
	            return $this->query($sql);

	        }

		}


?>