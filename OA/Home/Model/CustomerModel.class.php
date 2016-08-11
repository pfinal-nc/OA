<?php
	namespace Home\Model;
	use Think\Model;

	class CustomerModel extends Model{
		public function getAll($limit){
			$list=$this->field('ome.id omeid,ooa.name ooaname,ome.name omename,ocu.addtime ocuadd,ocu.tel otel,ocu.status ocus')->table('oa_organization ooa,oa_member ome,oa_customer ocu')->where('ocu.uid=ome.id and ome.Organization_id=ooa.id and ome.Order=0 and ome.status=1')->limit($limit)->select();
				return $list;
		}
		public function input($data){
			$resu=$this->data($data)->add();
			return $resu;
		} 
		public function getalla($limit){
			$list=$this->limit($limit)->select();
			return $list;
		}
	}