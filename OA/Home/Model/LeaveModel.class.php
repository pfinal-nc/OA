<?php 
	namespace Home\Model;
	use Think\Model;

class LeaveModel extends Model{
		public function getAll($name,$limit)
		{
			$list=$this->field('
					 l.id        lid,
					 l.uid      luid,
					 l.p_uid    lp,
					 l.content    lc,
					 l.status   ls,
					 l.addtime     la,
					 m.name     mname,
					 m.Order     mo
					 ')
					->table('oa_leave     l,
							oa_member   m
							')
					->where("
						l.uid=m.id and l.content like'%$name%'
						")
					->limit($limit)
					->select();
				return $list;
				//var_dump($list);exit;
		}


		public function setAdd($data)
		{
			//var_dump($data);exit;
			$id=$this->add($data);
			return $id;
		}

		public function getAllx($limit){
			$list=$this->field('
				     l.id        lid,
					 l.uid      luid,
					 l.p_uid    lp,
					 l.content    lc,
					 l.status   ls,
					 l.addtime     la,
					 m.name     mname,
					 m.Order     mo,
					 m.id        mid,
					 o.id        oid,
					 o.name     oname'
					 
					 )
					->table('oa_leave     l,
							 oa_member   m,
							 oa_organization o
							')
					->where('l.uid=m.id and m.Organization_id=o.id')
					->limit($limit)
					->select();
				    return $list;

		}
             public function setAddx($id)
		{
			$list=$this->field('
					 o.id        oid,
					 o.name     oname
					 ')
					->table('oa_leave     l,
							 oa_member   m,
							 oa_organization o
							')
					->where("
						l.uid=m.id and m.Organization_id=o.id 
						")
					->select();
					foreach ($list as $ke => $valu) {
						  if (in_array($id, $valu)) {
						  	  $str.=6;
						  }
					}
				 return strlen($str);
			}

	}


 ?>