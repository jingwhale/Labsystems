<?php

class NewsAction extends Action{
	
	private  $news_item;
	/**
     * @函数	index
     * @功能	显示添加文章主页面
     */
	function index(){
		header("Content-Type:text/html; charset=utf-8");
		if(session('?username')){
			$this->assign('username',session('username'));
			$this->assign('title','哈哈');
			if($id=(int)$_GET['id']){
				$news=M('News');
				$news_item=$news->where("id=$id")->find();		
				$this->assign('news_item',$news_item);	
				$this->assign('btn_ok_text','完成修改');
				$this->assign('btn_ok_act','update');
			}else{
				$this->assign('btn_ok_act','add');
				$this->assign('btn_ok_text','添加新闻');
			}
			$this->display();
	     }
	     else
		{
			$this->error('您好，请先登录！！！',U('/Login/index/'));
		}
	}
	/**
     * @函数	add
     * @功能	文章添加完成，写入数据库
     */
	function add(){
		header("Content-Type:text/html; charset=utf-8");
	
		$m=D('Admin');
		$nam=session('username');
		$data['username']=array('like',$nam); 
		$m->where($data)->setInc('sum'); 
		// var_dump($s);
		$news=D('News');
		if($news->create()){
			
			$news->message	=$_POST['editorValue'];
			$news->author =session('username');
			$news->createtime =date('Y-m-d',time());
			$news->lastmodifytime =date('Y-m-d H:i:s',time());

			//将文章写入数据库
			if($news->add()){
				$this->success('文章添加成功，返回上级页面',U('News/self'));
			}else{
				$this->error('文章添加失败，返回上级页面');
			}
			
		}else{
			$this->error($news->getError());
		}	
	}
	
	/**
     * @函数	delete
     * @功能	删除文章
     */
	function delete(){	

	    $m=D('Admin');
		$nam=session('username');
		$data['username']=array('like',$nam); 
		$m->where($data)->setDec('sum');	

    	$news=M('News');
		if($news->delete($_GET['id'])){
			$this->success('文章删除成功');
		}else{
			$this->error($news->getLastSql());
		}
	}
	
	/**
     * @函数	edit
     * @功能	删除文章
     */
	function edit(){
	header("Content-Type:text/html; charset=utf-8");
	if($_GET['id']){
			redirect(U('/News/index/id/'.$_GET['id']),0, '编辑文章');
	}
	 }
	
	/**
     * @函数	update
     * @功能	更新修改后的文章到数据库
     */
	public function update(){
		
		header("Content-Type:text/html; charset=utf-8");	
		$news=M('News');		
	
		$data = array('subject'=>$_POST['subject'],'message'=>$_POST['editorValue'],'lastmodifytime'=>date('Y-m-d H:i:s',time()));		
		$id=$_POST['id'];

		$news->where('id='.$id)->setField($data); // 根据条件保存修改的数据
		$this->success('修改文章成功，返回上级页面',U('News/self'));
	}

	public function look(){
		header("Content-Type:text/html; charset=utf-8");
		if(session('?username')){
			$this->assign('username',session('username'));
			$this->assign('title','哈哈');
			if($id=(int)$_GET['id']){
				$news=M('News');
				$news_item=$news->where("id=$id")->find();
				// var_dump($news_item);
				$this->assign('news_item',$news_item);	
			}

		$name1=session('username');
		$name2=$_GET['author'];
		if($name1!=$name2){
			$m=M('News');
			$id=(int)$_GET['id'];
			$m->where('id='.$id)->setInc('sum'); 
		}

			$this->display();
	     }
	    
	 }

	 public function other(){ 	
        header("Content-Type:text/html; charset=utf-8");
   
          
		if(session('?username')){
			$this->assign('username',session('username'));

		
			//实例化文章模型
			$news=M('news');	
			$count=$news->count();

			$nam=session('username');

			$data['author']=array('notlike',$nam); 

			$count=$news->where($data)->count();
			// $arr=$m->where($data)->select();
		
			//分页显示文章列表，每页8篇文章
			import('ORG.Util.Page');
			$page=new Page($count,8);//后台管理页面默认一页显示8条文章记录
	
            $page->setConfig('prev', "&laquo; Previous");//上一页
            $page->setConfig('next', 'Next &raquo;');//下一页
            $page->setConfig('first', '&laquo; First');//第一页
            $page->setConfig('last', 'Last &raquo;');//最后一页	
			$page->setConfig('theme',' %first% %upPage%  %linkPage%  %downPage% %end%');
            //设置分页回调方法
			$show=$page->show();
	
			$news_list=$news->where($data)->field(array('id','subject','author','createtime','lastmodifytime','sum'))->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
			// var_dump($news_list);
			//对原始信息过滤
			//$this->data($news_list)->filter();
			
			$this->assign('news_count',$count);
			$this->assign('title','后台管理系统');
			$this->assign('news_list',$news_list);
			$this->assign('page_method',$show);
						
			$this->display();
			
		}
		
		else
		{
			$this->error('您好，请先登录！！！',U('/Login/index/'));
		}	
    }



    public function self(){
    	 header("Content-Type:text/html; charset=utf-8");
   
          
		if(session('?username')){
			$this->assign('username',session('username'));

		
			//实例化文章模型
			$news=M('News');	
			$count=$news->count();

			$nam=session('username');

			$data['author']=array('like',$nam); 

			$count=$news->where($data)->count();
			// $arr=$m->where($data)->select();
		
			//分页显示文章列表，每页8篇文章
			import('ORG.Util.Page');
			$page=new Page($count,8);//后台管理页面默认一页显示8条文章记录
	
            $page->setConfig('prev', "&laquo; Previous");//上一页
            $page->setConfig('next', 'Next &raquo;');//下一页
            $page->setConfig('first', '&laquo; First');//第一页
            $page->setConfig('last', 'Last &raquo;');//最后一页	
			$page->setConfig('theme',' %first% %upPage%  %linkPage%  %downPage% %end%');
            //设置分页回调方法
			$show=$page->show();
	
			$news_list=$news->where($data)->field(array('id','subject','author','createtime','lastmodifytime','sum'))->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
			// var_dump($news_list);
			//对原始信息过滤
			//$this->data($news_list)->filter();
			
			$this->assign('news_count',$count);
			$this->assign('title','后台管理系统');
			$this->assign('news_list',$news_list);
			$this->assign('page_method',$show);
						
			$this->display();
			
		}
		
		else
		{
			$this->error('您好，请先登录！！！',U('/Login/index/'));
		}
      }
}


?>