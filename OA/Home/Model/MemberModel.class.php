<?php
    namespace Home\Model;
    class MemberModel extends  \Think\Model{
      public function getSonuser($data){
            return $this->where($data)->select();
        }

        //这里是写入新加成员的信息的
        public function regUser($data){
            return $this->add($data);
        }

        //这里是查询一个大部门的所有员工
        public function getAlluser($organid){
            return $this->where('Organization_id='.$organid)->select();
        }

        //这里是模糊查询出来的分类 id 去查询子类员工
        public function sonUser($sonorgan){
           
        }

        public function getAll($limit){
            $list=$this->field('ome.addtime omeadd,ome.Order omeor,ome.Organization_id omeo,ome.id omeid,ooa.name ooaname,ome.name omename,ome.status omes')->table('oa_organization ooa,oa_member ome')->where(' ome.Organization_id=ooa.id and ome.status=1')->limit($limit)->select();
                return $list;
        }


        public function getFind($data){
            return $this->where($data)->find();
        }

    }
