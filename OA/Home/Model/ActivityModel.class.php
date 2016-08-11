<?php 
	namespace Home\Model;
	use Think\Model;
	class ActivityModel extends Model{
		//造一个受保护属性
			protected $_validate=array(
				array('starttime','require','开始时间不能为空'),
				array('Organization_id','require','部门ID不能为空'),
				array('content','require','活动内容不能为空')
				);
			protected $_auto=array(
				//1是新增数据的时候处理
				array('addtime','time',1,'function')
				);
		public function getAll($content,$limit){
			$list=$this->field('
				a.id 		aid,
				a.content   acontent,
				a.starttime   astarttime,
				m.name    mname,
				o.name    oname,
				a.addtime atime')
			->table('oa_activity 	  a,
					oa_organization   o,
					oa_member 	m')
			->where("o.id=a.Organization_id
					and
					m.id=a.uid
					and 
					a.content like'%$content%'	
					")
			->limit($limit)
			->select();
			//var_dump($list);exit;
			return $list;

		}

		public function setAdd($data){
			$id=$this->add($data);
			return $id;
		}
	}

?>