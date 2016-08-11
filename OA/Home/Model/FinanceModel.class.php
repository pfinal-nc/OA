<?php
    namespace Home\Model;
    use Think\Model;

    class FinanceModel extends \Think\Model{
        public function getAll($limit){
            $list=$this->field('oof.total total,oof.content content,oof.status status,oof.addtime oofadd,ome.addtime omeadd,ome.Order omeor,ome.Organization_id omeo,ome.id omeid,ooa.name ooaname,ome.name omename,ome.status omes')->table('oa_organization ooa,oa_member ome,oa_finance oof')->where(' ome.Organization_id=ooa.id and ome.status=1 and oof.uid=ome.id')->limit($limit)->select();
                return $list;
        }

    }
?>