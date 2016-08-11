<?php
    namespace Home\Controller;
    use Home\Controller\CommonController;

    class MemberController extends CommonController{
        public function index(){
            //查看顶级部门
            $data['path']='0,';
            $organ = D('Organization');
            $list = $organ -> getAllm($data);
            $this->assign('list',$list);
            $this->display();
        }

        //查看子部门
        public function sonorgan(){
            $fid = $_GET['orid'];
            $path = $_GET['orpath'];
            $data['path']=$path.$fid.',';
            $sonor = D('Organization');
            $list = $sonor->getAll($data);
            if(empty($list)){
                $this->error('没有子部门');
                return false;
            }
            $this->assign('list',$list);
            $this->display();
        }

        //查看子部门的成员
        public function sonuser(){
            $order =$_SESSION['home']['order'];
            $data['Organization_id'] = $_GET['organid'];
            $sonuser = D('Member');
            $sonulist = $sonuser->getSonuser($data);

            $this->assign('order',$order);
            $this->assign('sonulist',$sonulist);
            $this->display();
        }


        //这里是加载添加工作人员模版的
        public function adduser(){
            $order = D('Organization');
            $list = $order->getOrder();
            $this->assign('list',$list);
            $this->display();
        }

        //填好添加用户表单开始写入
        public function reguser(){
            if(empty($_POST['name'])){
                $this->error('员工姓名不能为空');
                return flase;
            }
            if(empty($_POST['pwd'])){
                $this->error('员工密码不能为空');
                return flase;
            }

            $data['name']= $_POST['name'];
            $data['pwd'] = $_POST['pwd'];
            $data['Organization_id'] = $_POST['organ'];
            $data['Order'] = $_POST['order'];
            $data['addtime']=time();

            $reg = D('Member');
            //如果添加的是经理  先查询这个部门是否存在经理
            if($data['Order']==0){
                //如果是经理先去查询这个顶部门有没有这个0字段的
                $organid =$data['Organization_id'];
                $jieguo = M('Member');
                $exist =$jieguo->query("select * from oa_member where `Organization_id`=$organid and `order`=0");
            }
            if(!empty($exist)){
                $this->error('该部门已经存在经理职位');
                return false;
            }
            $info = $reg ->regUser($data);
            if($info){
                $this->success('新成员添加成功',U('Member/index'));
                return false;
            }else{
                $this->error('新员工添加失败');
                return false;
            }
        }

        //这是修改用户帐号的状态的
        public function upstatus(){
            if($_SESSION['home']['order']>0){
                $this->error('无权操作');
                return false;
            }
            $id =$_GET['uid'];
            $data['status']=$_GET['status'];
            if($data['status']==0){
                $data['status']=1;
            }else{
                $data['status']=0;
            }
            $up = D('Member');
            $info = $up -> status($id,$data);
            if($info){
                $this->success('用户状态修改成功',U('Member/index'));
                return false;
            }else{
                $this->error('用户状态修改失败');
                return false;
            }
        }

        //这里是删除用户的
        public function deluser(){
            $data['id']=$_GET['uid'];
            $del = D('Member');
            //这里是删除之前先查询出这个人在哪个部门的
            $organid = $del->getFind($data);
            //开始删除
            $info = $del -> userDel($data);
            if($info){
                $this->success('删除成功',U('Member/sonuser',['organid'=>$organid['organization_id']]));
                return false;
            }else{
                $this->error('删除失败');
                return false;
            }
        }


        //这里是查询一个大部门的所有员工
        public function Alluser(){
            $organid = $_GET['orid'];
            $orpath = $_GET['orpath'];
            $All = D('Member');
            $list = $All -> getAlluser($organid);
            //开始模糊查询所有的子分类拿到ID
            $like = $orpath.$organid.',%';
            $organtable = D('Organization');
            $sonorgan = $organtable ->Mohu($like);
            //把拿到的子分类ID 去查询用户；
            if(!empty($sonorgan)){
                $list2= $All -> sonUser($sonorgan);
            }
            if(!empty($list2)){
                $list = array_merge($list,$list2);
            }
            $this->assign('list',$list);
            $this->display();

        }

    }

