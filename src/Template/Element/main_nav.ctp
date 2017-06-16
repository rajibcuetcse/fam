<style>
.admin_userinfo{color: #fff;}
</style>
<?php
	$menu_modules = unserialize($this->request->session()->read('modules'));
	$user_permissions = $this->request->session()->read('user_permissions');
	$username = $this->request->session()->read('Auth.User.username');
	$img_path = $this->request->session()->read('Auth.User.img_path');
	$profile_picture = (empty($img_path)) ? $this->request->webroot."media/companies/default.jpg" : $this->request->webroot.$img_path;
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo $profile_picture;?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p class="admin_userinfo"><?php echo $username; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <?php
      $access_module=array();
      foreach($user_permissions as $row){
      if(!in_array($row['module_id'],$access_module))
      $access_module[]=$row['module_id'];
      }
      $access_submodule=array();
      foreach($user_permissions as $row){
      if(!in_array($row['submodule_id'],$access_submodule))
      $access_submodule[]=$row['submodule_id'];
      }
      $request_controller=strtolower($this->request->params['controller']);
      
      ?>
      <ul class="sidebar-menu">
      <?php foreach($menu_modules as $module){
        if(in_array($module['id'],$access_module)){   
           $icon='<i class="fa fa-codepen" aria-hidden="true"></i>';
           if($module['icon']!=""){
           $icon=$module['icon'];
           }
      ?>
      <?php
       $submodule_controller_arr=array();
        foreach($module['sub_modules'] as $submodule ){
        $submodule_controller_arr[]= strtolower($submodule['controller_name']);
        }
       ?>
     <li class=" treeview <?php echo in_array( $request_controller,$submodule_controller_arr)?'active':'' ?>" >
          <a href="">
         <?php echo  $icon.'<span>'. $module['name'].'</span>' ?><i class="fa fa-angle-left pull-right"></i>
          </a>
                                   
          <ul class="treeview-menu">
           <?php foreach($module['sub_modules'] as $submodule ){ 
         
           if(in_array($submodule['id'],$access_submodule)){
           $sub_icon='<i class="fa fa-circle-o"></i>';
           if($submodule['icon']!=""){
           $sub_icon=$submodule['icon'];
           }
            
           ?>
            <li class="<?php echo strtolower($submodule['controller_name'])==$request_controller?'active':'' ?>"><a href="<?php  echo $this->Url->build(["controller" =>$submodule['controller_name'] ,"action" => "index"]); ?>"><?php echo $sub_icon.$submodule['name'] ?></a> </li> 
             
          <?php }
          } 
          ?>
          </ul>
        </li>
        <?php 
        }
        } ?>
        
      </ul>
    </section>
    <!-- /.sidebar -->
</aside>