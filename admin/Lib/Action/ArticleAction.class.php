 <?php


 class ArticleAction extends Action{
  public function index(){ 	
        header("Content-Type:text/html; charset=utf-8");
   
          
		if(session('?username')){
			$this->assign('username',session('username'));

		
			//实例化文章模型
			$article=M('Article');	
			$count=$article->count();
		
			//分页显示文章列表，每页8篇文章
			import('ORG.Util.Page');
			$page=new Page($count,4);//后台管理页面默认一页显示8条文章记录
	
            $page->setConfig('prev', "&laquo; Previous");//上一页
            $page->setConfig('next', 'Next &raquo;');//下一页
            $page->setConfig('first', '&laquo; First');//第一页
            $page->setConfig('last', 'Last &raquo;');//最后一页	
			$page->setConfig('theme',' %first% %upPage%  %linkPage%  %downPage% %end%');
            //设置分页回调方法
			$show=$page->show();
	
			$article_list=$article->field(array('id','title','author','createtime','labname','abstract','sum'))->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
			
			//对原始信息过滤
			//$this->data($article_list)->filter();
			
			$this->assign('article_count',$count);
			$this->assign('title','后台管理系统');
			$this->assign('article_list',$article_list);
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
			$article=M('Article');	

			$nam=session('username');

			$data['tutor']=array('like',$nam); 

			$count=$article->where($data)->count();

			// $nam=$article->where($data)->select();
			// var_dump($nam)



		
			//分页显示文章列表，每页8篇文章
			import('ORG.Util.Page');
			$page=new Page($count,4);//后台管理页面默认一页显示8条文章记录
	
            $page->setConfig('prev', "&laquo; Previous");//上一页
            $page->setConfig('next', 'Next &raquo;');//下一页
            $page->setConfig('first', '&laquo; First');//第一页
            $page->setConfig('last', 'Last &raquo;');//最后一页	
			$page->setConfig('theme',' %first% %upPage%  %linkPage%  %downPage% %end%');
            //设置分页回调方法
			$show=$page->show();
	
			$article_list=$article->where($data)->field(array('id','title','author','createtime','labname','abstract','sum'))->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
			$authors = array_column($article_list, 'author'); 


			// $authors=$article->field(array('author'))->order('id desc')->select();

			
			$result = array_unique($authors);
			var_dump($result);
			//对原始信息过滤
			//$this->data($article_list)->filter();
			
			$this->assign('article_count',$count);
			$this->assign('title','后台管理系统');

			$this->assign('result)',$result);
			$this->assign('article_list',$article_list);
			
			$this->assign('page_method',$show);
						
			$this->display();
			
		}
		
		else
		{
			$this->error('您好，请先登录！！！',U('/Login/index/'));
		}	
    }


    public function look(){
		header("Content-Type:text/html; charset=utf-8");
		if(session('?username')){
			$this->assign('username',session('username'));
			$this->assign('title','哈哈');
			// $getid=(int)$_GET['id']
			if($id=(int)$_GET['id'] && $title=$_GET['title']){
				//获取文章
				$article=M('Article');
				$article_item=$article->where("id=$id")->find();
				// var_dump($article_item);
				$this->assign('article_item',$article_item);
          		//获取评论
				$review=M('Review');
				$data['articlename']=array('like',$title); 
				$review_item=$review->where($data)->select();
				// var_dump($review_item);
				$this->assign('review_item',$review_item);
			}

			// if($title=$_GET['title']){
			// 	$review=M('Review');
			// 	$gettitle=$_GET['title'];
			// 	$data['articlename']=array('like',$gettitle); 
			// 	$review_item=$review->where($data)->select();
			// 	var_dump($review_item);
			// 	$this->assign('review_item',$review_item);
			// }

			$name1=session('username');
			$name2=$_GET['author'];
			if($name1!=$name2){
				$m=M('Article');
				$id=(int)$_GET['id'];
				$m->where('id='.$id)->setInc('sum'); 
			}

			

			$this->display();
	     }
	    
	}


	 /**
     * @函数	delete
     * @功能	删除文章
     */
	function delete(){	

	    $m=D('User');
		// $nam=session('username');
  //       $id=$_GET['id']);
		// $nickname = $User->where('id=$id')->getField('nickname');

		// $data['username']=array('like',$nam); 
		$aut=$_GET['author'];
		$data['username']=array('like',$aut); 
		$m->where($data)->setDec('sum');	

    	$article=M('Article');
		if($article->delete($_GET['id'])){
			$this->success('文章删除成功');
		}else{
			$this->error($article->getLastSql());
		}
	}
	
	/**
     * @函数	edit
     * @功能	删除文章
     */
	// function edit(){
	// header("Content-Type:text/html; charset=utf-8");
	// if($_GET['id']){
	// 		redirect(U('/Article/index/id/'.$_GET['id']),0, '编辑文章');
	// }
	//  }

	 	function edit(){
		header("Content-Type:text/html; charset=utf-8");
		if(session('?username')){
			$this->assign('username',session('username'));
			$this->assign('title','哈哈');
			if($id=(int)$_GET['id']){
				$article=M('Article');
				$article_item=$article->where("id=$id")->find();		
				$this->assign('article_item',$article_item);	
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
     * @函数	update
     * @功能	更新修改后的文章到数据库
     */
	public function update(){
		
		header("Content-Type:text/html; charset=utf-8");	
		$article=M('Article');		
	
		$data = array('title'=>$_POST['title'],'abstract'=>$_POST['abstract'],'content'=>$_POST['editorValue'],'lastmodifytime'=>date('Y-m-d H:i:s',time()));		
		$id=$_POST['id'];

		$article->where('id='.$id)->setField($data); // 根据条件保存修改的数据
		$this->success('修改文章成功，返回上级页面',U('/Article/index'));
	}
}


  ?>