<?php  
    namespace Home\Controller;
    use Think\Controller;
    class PersonalController extends CommonController{
    	public function index(){
    		$model=M('Member');
    		$list=$model->field('name,id,Organization_id,Order,addtime')->select();
    		foreach ($list as &$value)
    		{   
    			$value['face']='/Public/Uploads/'.$this->sub($value['face']).$value['face'];
    			$Umodel=M('MemberInfo');
    			$list1=$Umodel->field('face,id,sex,tel,updatetime')->where("uid=".$value['id'])->select();
    			$list[0]=array_merge($list[0],$list1[0]);
    		}
    		$this->assign('list',$list);
    		$this->display();
    	}
        public function doadd(){
        	$id=$_SESSION['home']['id'];
        	$model=M('memberInfo');
        	$filename=$this->upload();
        	$data['tel']=$_POST['tel'];
        	$data['face']=$filename;
        	$data['updatetime']=time();
        	$res=$model->where("uid=$id")->save($data);
        	if ($res) {
                $this->success('修改成功',U('Index'),1);
                return false;
	        }else{
	            $this->setunlink($filename);
	            $this->error('修改失败');
	            return false;
            }
        }
          
        public function doreset(){
        	$id=$_SESSION['home']['id'];
        	if(!empty($_POST))
            {
                foreach($_POST as $val)
                {
                    if(empty($val))
                    {
                        $this->error('请完善表单');
                        return false;
                    }
                }
            }
        $model = M('Member');
        $pwd=md5($_POST['pwd']);
        $pwd1=md5($_POST['pwd1']);
        $pwd2=md5($_POST['pwd2']);
        $list=$model->select($id)[0];
        if ($list['pwd']!=$pwd) {
            $this->error('旧密码输入错误');
            return false;
        }else{
            if($pwd1!=$pwd2) {
                $this->error('新密码和重复密码不一致');
                return false;
            }
        }
        $data['pwd']=$pwd1;
        $res=$model->where("id=$id")->save($data);
        $this->success('密码修改成功',U('Login/index'),1);
        return false;
        }
         
    	public function upload(){   
        $upload = new \Think\Upload();
        // 实例化上传类    
        $upload->maxSize   =     3145728 ;
        // 设置附件上传大小    
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');
        // 设置附件上传类型    
        $upload->rootPath  =      './Public/'; 
        $upload->savePath  =      './Uploads/'; 
        $upload->saveName  =   date('Ymd',time()).uniqid();
        $upload->autoSub   = true;
        $upload->subName   = date('Y',time()).'/'.date('m',time()).'/'.date('d',time());
        // 设置附件上传目录    
        // 上传文件    
        $info   =   $upload->upload();   
        if(!$info) {
        // 上传错误提示错误信息        
        $this->error($upload->getError());    
        }else{// 上传成功 
             //做图片压缩方法
            $this->zoom($info['pic']['savename']);
            return $info['pic']['savename'];
        }
    }
       private function zoom($filename)
    {
        $image = new \Think\Image();
        $path='./Public/Uploads/'.$this->sub($filename);
        $image->open($path.$filename);
        $image->thumb(250, 250)->save($path.'250_'.$filename);
        $image->thumb(150, 150)->save($path.'150_'.$filename);
        $image->thumb(300, 300)->save($path.'300_'.$filename);
        $image->thumb(80, 80)->save($path.'80_'.$filename);
    }

    private function setunlink($filename){
        $path='./Public/Uploads/';
        unlink($path.$this->sub($filename).'150_'.$filename);
        unlink($path.$this->sub($filename).'250_'.$filename);
        unlink($path.$this->sub($filename).'300_'.$filename);
        unlink($path.$this->sub($filename).'80_'.$filename);
        unlink($path.$this->sub($filename).$filename);
    }
}
?>