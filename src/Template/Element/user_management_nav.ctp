<?php  
	$menu_modules = unserialize($this->request->session()->read('modules'));
	$current_action = $this->request->params['action'];
	$current_sub_module = $this->request->params['controller'];
?>

  <?php
                        //$this->log($current_sub_module);
                        switch ($current_sub_module) {
                            case "Cmsusers":
                                $icon = '<span class="glyphicon glyphicon-user"></span>';
                                break;
                            case "Roles":
                                $icon = '<span class="glyphicon glyphicon-file"></span>';
                                break;
                            case "Usergroups":
                                 $icon = '<span class="glyphicon glyphicon-file"></span>';
                                break;
                            case "UserGroupRoleAssociation":
                                 $icon = '<span class="glyphicon glyphicon-file"></span>';
                                break;
                            case "RolePagesAssociation":
                                 $icon = '<span class="glyphicon glyphicon-file"></span>';
                                break;
                            case "default":
                                $icon = '<span class="glyphicon glyphicon-file"></span>';
                                break;    
                         }
 ?>                        
<div class="row">
<div class="col-md-12">
<div class="box box-solid">
<div class="box-body">
<div class="row">
		<div class="col-md-4">
			<h3 class="box-title no-margin"><?php echo $icon ?><?= $title ?></h3>
		</div>
    
	<div class="col-md-8">



 <div class="row">

  <div class="col-md-12 text-right">
  
			
                   <?php             
                    foreach ($permissions as $permission) {                   
                    foreach($nav_arr as $nav){
                    	if ($permission['page_id'] == $nav['page_id']){
                    ?>
                    	
                            <a href="<?php echo $this->Url->build(["action" => $nav['action']]); ?>" class="btn btn-success btn-flat btn-grid">
                               <?php echo $nav['icon']; ?>
                                <?php echo __($nav['label']) ?>
                            </a>
                        
                    <?php    
                    }
                    }
                      }  
                    ?>
          



<div class="btn-group">
                  <button type="button" class="btn btn-primary">
                  <?php
                        foreach($menu_modules as $module){
                        	foreach($module['sub_modules'] as $submodule ){
                        		if($submodule['controller_name'] == $current_sub_module){
                       	?>
                       		 <?php echo __($submodule['name']) ?>
                       		
                       	<?php
                        		}
                        	}
                        }
                        ?>
                  </button>
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                   <?php 
						      $access_submodule=array();
						      foreach($user_permission as $row){
						      if(!in_array($row['submodule_id'],$access_submodule))
						      $access_submodule[]=$row['submodule_id'];
						      }
								$current_module = array_values($current_module);
								$current_sub_module = $this->request->params['controller'];
								foreach($menu_modules as $module){
									if($module["id"] == $current_module[0]){
										foreach($module['sub_modules'] as $submodule ){ 
										if(in_array($submodule['id'],$access_submodule)){
											if($submodule['controller_name'] != $current_sub_module){
											 $sub_icon='<i class="fa fa-circle-o"></i>';
          									 if($submodule['icon']!=""){
           										$sub_icon=$submodule['icon'];
          									 }
										?>
										<li>
											<a href="<?php  echo $this->Url->build(["controller" =>$submodule['controller_name'] ,"action" => "index"]); ?>"><?php echo $sub_icon. $submodule['name'] ?></a>
			                        	</li>
							<?php
										}
									}
								}
							}
						}
						?>
                    </ul>
                  </ul>
                </div>
              </div>
            
                   
                </div>
           
                </div>
                </div>
               </div>
               </div> 
   </div>             
</div>