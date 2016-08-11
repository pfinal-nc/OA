<?php 
    namespace Home\Controller;
    use Think\Controller;
    class FinanceController extends CommonController{
    	public function index(){
    		$Financemodel = M('Finance');
    		$list=$Financemodel->select();
        foreach ($list as $key => &$value){
          //图片
          $value['content']='/Public/Uploads/'.$this->sub($value['content']).'80_'.$value['content'];
          //查用户表的ID
          $Membermodel=M('member');
            $data[$key]['uname']=$Membermodel->where('id='.$value['uid'])->find()['name'];

            $list[$key]['uname']=$data[$key]['uname'];
        }
        //传财务表数据
    		$this->assign('list',$list);
        //加载模板
    		$this->display('Finance/index');
    	}

    	public function add(){
        $filename=$this->upload();
        $id=$_POST['id'];
        $data['uid']=$id;
        $data['total']=$_POST['total'];
        $data['content']=$filename;
        $data['status']=$_POST['status'];
        $model=M('member');
        $list=$model->where("id=$id")->select()[0];
        if($list==null) {
            $this->success('没有这个用户',U('Finance/Add_bill'),2);
        }else{
            $Model=M('Finance');
            $result=$Model->add($data);
            $this->success('添加成功',U('Finance/index'),2);
        }
        
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
      //查询用户表中的ID是否存在
        /*$filename=$this->upload();
        $data['uid']=$_POST['id'];
        $data['uname']=$_POST['name'];
        $data['total']=$_POST['total'];
        $data['content']=$filename;
        $data['status']=$_POST['status'];
        $model=M('Member');
        $res=$model->where("id=".$data['uid'])->find();
           if($res){
            $list=M('Finance');
            $result=$list->add($data);
                  $this->success('添加成功',U('Finance/index'),2);
                }else{
                  $this->success('没有这个用户',U('Finance/Add_bill'),2);
                }
            }
     */



 ?>