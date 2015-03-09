<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($title); ?></title>


<link rel="stylesheet" href="__PUBLIC__/Css/admin/reset.css" type="text/css" media="screen" />
<link rel="stylesheet" href="__PUBLIC__/Css/admin/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="__PUBLIC__/Css/admin/invalid.css" type="text/css" media="screen" />

<script type="text/javascript" src="__PUBLIC__/Js/admin/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/admin/simpla.jquery.configuration.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/admin/facebox.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/admin/jquery.wysiwyg.js"></script>

</head>

<body>
<div id="body-wrapper">

  <div id="sidebar">
    <div id="sidebar-wrapper">
     
      	<h1 id="sidebar-title"><a href="#">Simpla Admin</a></h1>
      	<img id="logo" src="__PUBLIC__/Images/admin/logo.png" alt="Simpla Admin logo" />

      	<div id="profile-links"> 
      		您好,<a href="#" title="当前用户:<?php echo ($username); ?>"><?php echo ($username); ?></a> |
	 		<a href="__URL__/quit" title="退出">退出</a> 
       	</div>
       	
	    <ul id="main-nav">
     		<!-- 类型为nav-top-itrm current 表示选中时的样式 -->
        <li> <a href="__URL__/article" class="nav-top-item">新闻 News</a>
            <ul>
              <li><a href="__GROUP__/News/index">写新闻</a></li>
              <li><a href="__GROUP__/News/self">管理新闻</a></li>
              <li><a href="__GROUP__/News/other">别人新闻</a></li>
            </ul>
          </li>

     		 <li> <a href="#" class="nav-top-item">实验室  Lab</a>
	          <ul>
	            <li><a href="__GROUP__/Lab/index">实验室简介</a></li>
	            <li><a href="#">实验室组织</a></li>
	            <li><a href="#">实验室成员</a></li>
	          </ul>
	        </li>
	        
	        <li> <a href="#" class="nav-top-item">项目  Projects</a>
	          <ul>
	            <li><a href="#">目前项目</a></li>
	            <li><a href="#">获奖项目</a></li>
	            <li><a href="#">开发课题</a></li>
	          </ul>
	        </li>
	              
	        
	        
	        <li> <a href="#" class="nav-top-item">博客 Article</a>
	          <ul>
	            <li><a href="__GROUP__/Article/index">全部博客</a></li>
	            <li><a href="__GROUP__/Article/self">实验室博客</a></li>
	          </ul>
	        </li>
	     </ul>
         
    </div>
  </div>
  <!-- End #sidebar -->
  
  <div id="main-content">
 
    <noscript>
    <!-- Show a notification if the user has disabled javascript -->
	    <div class="notification error png_bg">
	      	<div> Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
	        Download From
	        </div>
	    </div>
    </noscript>
    
    
    <!-- Page Head -->
    <!-- <h2>后台管理系统</h2> -->
	
    <ul class="shortcut-buttons-set">
      
      <li>
      	<a class="shortcut-button" href="__GROUP__/Index/index/">
      		<span> 
      			<img src="__PUBLIC__/Images/admin/icons/paper_content_pencil_48.png" alt="icon" /><br />
        		首页
        	</span>
        </a>
        </li>

        <li>
        <a class="shortcut-button" href="__GROUP__/News/index">
          <span> 
            <img src="__PUBLIC__/Images/admin/icons/paper_content_pencil_48.png" alt="icon" /><br />
            写新闻
          </span>
        </a>
      </li>
      
    </ul>
    

    <div class="clear"></div>
    
    

    <div class="content-box">
    
      <!-- Start Content Box -->
      <div class="content-box-header">
        <h3></h3>
        <ul class="content-box-tabs">
          <li><a href="#tab1" class="default-tab">新闻列表(共<?php echo ($news_count); ?>篇)</a></li>
          <!-- href must be unique and match the id of target div -->
          <li><a href="#tab2">登录记录</a></li>
        </ul>
        <div class="clear"></div>
      </div>
      
      <div class="content-box-content">
        <div class="tab-content default-tab" id="tab1">
          <!-- This is the target div. id must match the href of this div's tab -->
          <div class="notification attention png_bg"> <a href="#" class="close"><img src="__PUBLIC__/Images/admin/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
            <div>您好，<?php echo ($username); ?>，下面是最近添加的新闻！ </div>
          </div>
          
          <!-- 表头 -->
          <table>
            <thead>
              <tr>
                <th>
                 
                </th>
                <th>新闻标题</th>
                <th>作者</th>
                <th>添加和修改时间</th>
                <th>阅读量</th>	 
               <!--  <th>选项</th> -->
              </tr>
            </thead>
              
            <!-- 表内容部分 -->
            <tbody>
              <?php if(is_array($news_list)): $i = 0; $__LIST__ = $news_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                <td></td>
                <td><a href="__GROUP__/News/look/id/<?php echo ($vo['id']); ?>/author/<?php echo ($vo['author']); ?>"><?php echo ($vo['subject']); ?></a></td>
                <td><?php echo ($vo['author']); ?></td>
                <td><?php echo ($vo['createtime']); ?>/<?php echo ($vo['lastmodifytime']); ?></td>
                <td><?php echo ($vo['sum']); ?></td>
                <!-- <td>
                  
                  <a href="__URL__/edit/id/<?php echo ($vo['id']); ?>" title="编辑"><img src="__PUBLIC__/Images/admin/icons/pencil.png" alt="编辑" /></a> 
                  <a href="__URL__/delete/id/<?php echo ($vo['id']); ?>" title="删除"><img src="__PUBLIC__/Images/admin/icons/cross.png" alt="删除" /></a> 
                </td> -->
              </tr><?php endforeach; endif; else: echo "" ;endif; ?>                        
            </tbody>
            
              <!-- 表尾 -->
            <tfoot>
              <tr>
                <td colspan="6">
                  <div class="pagination">               	  
                  	<?php echo ($page_method); ?>
                  <!--
                  	<a href="#" title="First Page">&laquo; First</a>
                  	<a href="#" title="Previous Page">&laquo; Previous</a> 
                  	<a href="#" class="number" title="1">1</a> 
                  	<a href="#" class="number" title="2">2</a> 
                  	<a href="#" class="number current" title="3">3</a> 
                  	<a href="#" class="number" title="4">4</a> 
                  	<a href="#" title="Next Page">Next &raquo;</a>
                  	<a href="#" title="Last Page">Last &raquo;</a> 
                  -->
                  </div>                 
                  <div class="clear"></div>
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
        
      </div>
     
    </div>
    
    <div class="clear"></div>
   

    <div id="footer"> <small>
      <!-- Remove this notice or replace it with whatever you want -->
      &#169; Copyright 2015 JINGWHALE | Powered by <a href="http://www.cnblogs.com/jingwhale/">jingwhale</a> | <a href="#">Top</a> </small> </div>
    <!-- End #footer -->
  </div>
  <!-- End #main-content -->
</div>
</body>
<!-- Download From www.exet.tk-->
</html>