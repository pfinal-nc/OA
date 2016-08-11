<?php
namespace Home\Controller;
use Think\Controller;

  class CountController extends Controller{

    public function index(){
        $model=D('member');
        $total=$model->count();
        $page=new \Think\Page($total,4);
        $limit=$page->firstRow.','.$page->listRows;
        $page_str=$page->show();   
         $data=$model->getAll($limit);
         $count=count(M('member')->select());
         $this->assign('data',$data);
         $this->assign('cou',$count);
         $this->assign('page',$page_str);
         $this->display();
      }

  	  public function departments(){
        $model=D('Organization');
        $total=$model->count();
        $page=new \Think\Page($total,4);
        $limit=$page->firstRow.','.$page->listRows;
        $page_str=$page->show();   
        $list=$model->retAll($limit);
        foreach ($list as $key => $value) {
          $model1=M('member')->where('Organization_id='.$value['ooaid'])->select();
           $value['pcount']=count($model1);
           $arr=$model->cetAll($value['ooaid']);
           $value['sum']=$arr;
           $add[$key]=$value;
        }
          $this->assign('page',$page_str);  
          $this->assign('add',$add);
          $this->assign('total',$total);
  	  	  $this->display();
  	  }

  	  public function finance(){
        $model=D('Finance');
        $total=$model->count();
        $page=new \Think\Page($total,4);
        $limit=$page->firstRow.','.$page->listRows;
        $page_str=$page->show();   
        $list=$model->getAll($limit);
        $zhi=M('Finance')->where(['status'=>0])->select();
        $fu=M('Finance')->where(['status'=>1])->select();
        foreach ($fu as $key => $value) {
            $cu+=$value['total'];
        }
        foreach ($zhi as $key => $value) {
            $c+=$value['total'];
        }
        $this->assign('page',$page_str);
        $this->assign('c',$c);
        $this->assign('cu',$cu);
        $this->assign('list',$list);
  	  	$this->display();
  	  }

  	  public function clientele(){
        $model=D('Customer');
        $total=$model->count();
        $page=new \Think\Page($total,4);
        $limit=$page->firstRow.','.$page->listRows;
        $page_str=$page->show();
        $list=$model->getAll($limit);
        foreach ($list as $key => $value) {
          $model6=M('Customer')->where(['uid'=>$value['omeid']])->select();
          $count=count($model6);
          $value['sum']=$count;
          $data[$key]=$value;
        }
        $model1=M('Customer')->where(['status'=>1])->select();
        $model2=M('Customer')->where(['status'=>0])->select();
        $c=count($model1);
        $cu=count($model2);
        $this->assign('c',$c);
        $this->assign('cu',$cu);
         $this->assign('page',$page_str);
        $this->assign('data',$data);
        
  	    $this->display();
  	  }

  	  public function leave(){
        $model=D('Leave');
        $total=$model->count();
        $page=new \Think\Page($total,4);
        $limit=$page->firstRow.','.$page->listRows;
        $page_str=$page->show();
        $list=$model->getAllx($limit);
        //var_dump($list);
        foreach ($list as $key => $value) {
          $model1=M('leave')->where(['uid'=>$value['mid']])->select();
          $model2=M('Member')->where(['id'=>$value['lp']])->select();
          $value['lup']=$model2[0]['name'];
          $value['sum']=count($model1);
          $arr=$model->setAddx($value['oid']);
          $value['sum1']=$arr;
          $data[$key]=$value;
        } 
          $count=count($model->select());
          $this->assign('count',$count);
          $this->assign('data',$data);
          $this->assign('page',$page_str);
  	  	  $this->display();
  	  }
  }



?>