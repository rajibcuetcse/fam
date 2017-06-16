<?php
	$menu_modules = unserialize($this->request->session()->read('modules'));
?>
<div class="row">
<div class="col-md-12">
<div class="box box-solid">
<div class="box-body">
<div class="row">


		<div class="col-md-6">
			<h3 class="box-title no-margin"><span class="glyphicon glyphicon-file"></span>Edit Module</h3>
		</div>

	<div class="col-md-6">



 <div class="row">


<div class="col-md-12  text-right">
 <?php
                    if (array_key_exists("add", $module_pages)):
                        $page_id = $module_pages["index"];
                        foreach ($user_permission as $permission):
                            if ($permission['page_id'] == $page_id):?>
                             
                                    <a href="<?php echo $this->Url->build('/modules/index/'); ?>"  class="btn btn-success btn-flat btn-grid">
                                        <i class="fa fa-list"></i>
                                        <?php echo __('LIST'); ?>
                                    </a>
                               
                                <?php
                                break;
                            endif;
                        endforeach;
                    endif;
                    ?>

<div class="btn-group">
                  <button type="button" class="btn btn-primary"><?php echo __('MODULE_MANAGEMENT'); ?></button>
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


<div class="box box-primary">
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
             <?= $this->Form->create($newmodule) ?>
              <div class="form-group">
            	<?php echo $this->Form->input('id', ['label' => __('MODULE_ID'), 'class' => 'form-control', 'required' => true, 'error' => false,'type' => 'text']);?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('name', ['label' => __('MODULE_NAME'), 'class' => 'form-control']);?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('icon', ['label' => __('Module Icon'), 'class' => 'form-control', 'required' => true, 'error' => false]);?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('sequence', ['label' => __('Sequence'), 'class' => 'form-control', 'required' => true, 'error' => false,'type' => 'text']);?>
              </div>
              <!-- /.form-group -->
           
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
      </div>
