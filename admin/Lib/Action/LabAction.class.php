<?php
/**
     * @类		IndexAction
     * @功能	后台首页控制器
*/
class LabAction extends Action {	
	/**
     * @函数	index
     * @功能	显示后台管理主页面（包含登录判断）
     */
    public function index(){ 	
        header("Content-Type:text/html; charset=utf-8");
   
		if(session('?username')){
			$this->assign('username',session('username'));
			//实例化文章模型
			$m=M('Admin');	
            $name['username']=session('username');
			$arr=$m->where($name)->select();
			$this->assign('lab_list',$arr);
			$this->display();
			
		}
		
		else
		{
			$this->error('您好，请先登录！！！',U('/Login/index/'));
		}	
    }
    
    /**
     * @函数	quit
     * @功能	登出账户，跳转至登录页面。并清除Session
     */
    function quit(){
    	session(null);//清空所有session信息
		redirect(U('/Login/index'),0, '重新登录');
    }
    
  /**
     * @函数	article
     * @功能	编辑新的文章
     */
    // function article(){
    // 	//跳转到Article控制器的index方法
    // 	redirect(U('/Article/index'),0, '写新文章');
    // } 
    // /**
     // * @函数	delete
     // * @功能	删除文章
     // */
    // function delete(){
    	
    // 	//跳转至Article控制器来实现
    // 	if($_GET['id']){
    // 		redirect(U('/Article/delete/id/'.$_GET['id']),0, '删除文章');
    // 	}
    // 	else{
    // 		$this->error('参数错误！');
    // 	}
    // }
    
    /**
     * @函数	edit
     * @功能	编辑文章
     */

    private  $article_item;

    function edit(){
    	header("Content-Type:text/html; charset=utf-8");
		$this->assign('title','哈哈');
        if(session('?username')){
            $this->assign('username',session('username'));
    		if($id=(int)$_GET['id']){
    			$article=M('Admin');
    			$article_item=$article->where("id=$id")->find();		
    			$this->assign('article_item',$article_item);	
    			$this->assign('btn_ok_text','完成修改');
    			$this->assign('btn_ok_act','update');
    		}else{
    			$this->assign('btn_ok_act','add');
    			$this->assign('btn_ok_text','添加文章');
    		}
    		$this->display();
        } 
        else
        {
            $this->error('您好，请先登录！！！',U('/Login/index/'));
        }
    }

    public function update(){
		
		header("Content-Type:text/html; charset=utf-8");	
		$article=M('Admin');		
	
		$data = array('labname'=>$_POST['subject'],'xinxi'=>$_POST['editorValue']);		
		$id=$_POST['id'];

		$article->where('id='.$id)->setField($data); // 根据条件保存修改的数据
		$this->success('修改文章成功，返回上级页面',U('Lab/index'));
	}

     /**
     * @函数  lab
     * @功能  编辑新的文章
     */

    //  function labinfo(){
    //     //跳转到Article控制器的index方法
    //     redirect(U('/Lab/index'),0, '实验室简介');
    // } 
    
/*--------------------------------------------------内部方法-------------------------------------------------------------------*/    
     /**
     * @函数	filter
     * @功能	对数据库中的信息进行裁剪和过滤
     */ 
    private function filter($list){
    		
    	foreach($list as $key=>$value){			
   			//设置显示的创建时间
			$list[$key]['createtime']=date("Y-m-d H:i:s",$value['createtime']);
				
			//设置显示的最后修改时间
			if(!$value['lastmodifytime']){
				$list[$key]['lastmodifytime']="无";
			}else{
				$list[$key]['lastmodifytime']=date("Y-m-d H:i:s",$value['lastmodifytime']);
			}		
			
			//文章标题过长时裁剪
			if(strlen($list[$key]['subject'])>80){
					$list[$key]['subject']=$this->cutString($list[$key]['subject'],0,20).'...';				
			}
		}
    }
    
     /**
     * @函数	cutString
     * @功能	字符串裁剪(仅适用于UTF-8)
     */	
	private function cutString($str, $from, $len)
	{
   		return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
                       '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
                       '$1',$str);
	}
}

