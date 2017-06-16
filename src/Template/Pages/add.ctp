<?php 
	$menu_modules = unserialize($this->request->session()->read('modules'));
?>
<div class="row">
<div class="col-md-12">
<div class="box box-solid">
<div class="box-body">
<div class="row">


		<div class="col-md-6">
			<h3 class="box-title no-margin"><span class="glyphicon glyphicon-file"></span>Add Page</h3>
		</div>

	<div class="col-md-6">



 <div class="row">

<div class="col-md-12  text-right">
<?php
                    if (array_key_exists("add", $module_pages)):
                        $page_id = $module_pages["index"];
                        foreach ($user_permission as $permission):
                            if ($permission['page_id'] == $page_id):?>
                             
                                    <a href="<?php echo $this->Url->build('/pages/index/'); ?>"  class="btn btn-success btn-flat btn-grid">
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
                  <button type="button" class="btn btn-primary"><?php echo __('PAGES_MANAGEMENT'); ?></button>
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
             <?= $this->Form->create($page) ?>
              <div class="form-group">
            	<?php echo $this->Form->input('id', ['label' => __('Page Id'), 'class' => 'form-control', 'required' => true, 'error' => false,'type' => 'text']);?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('module_id', ['empty' => __('Select a module'), 'id' => 'module_id', 'options' => $modules, 'label' => __('Module Name'), 'class' => 'form-control', 'required' => true]);?>
              </div>
              <span>
                    <img src="<?php echo $this->Url->build('/images/ajax-loader.gif'); ?>"
                         class="loading_icon"
                         style="display:none;float: right"/>
              </span>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('sub_module_id', ['empty' => __('Select a Submodule'), 'id' => 'sub_module_id', 'label' => __('Sub Module Name'), 'class' => 'form-control', 'required' => true]);?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('name', ['label' => __('Page Name'), 'class' => 'form-control']);?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('method_name', ['label' => __('Method Name'), 'class' => 'form-control']);?>
              </div>
              <!-- /.form-group -->
              <div class="checkbox">
              	<label>
                    <input type="checkbox" id="available-to-company" name="available_to_company">
                    <?= __('Available To Companies') ?>
                 </label>
                </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
      </div>

<script src="<?php echo $this->request->webroot; ?>js/jquery-1.11.2.js"></script>
<script>
    $(document).ready(function () {

        refreshPage();

        function refreshPage() {
            var selectedValue = $("#module_id").val();
            loadSubModules(selectedValue);
        }

        $(document).on('change', '#module_id', function () {
            var selectedValue = $(this).val();
            loadSubModules(selectedValue);
        });

        function loadSubModules(selectedValue) {
            if (selectedValue) {
                $('.loading_icon').show();
                $('.error-message').remove();
                $.ajax({
                    type: "GET",
                    url: '<?=$this->Url->build('/Pages/getSubModulesByModule/');?>' + selectedValue,
                    dataType: "json",
                    success: function (response) {
                        $('.loading_icon').hide();
                        processSubModules(response);
                    },
                    error: function (xhr, status, error) {
                        $('.loading_icon').hide();
                        $('#sub_module_id').after('<label class="error-message" style="color:#ff0000">An error occurred. Please try again</label>');
                    }
                });
            }
        }

        function processSubModules(subModules) {
            var subModuleDropDown = $('#sub_module_id');
//            subModuleDropDown.find('option').remove();
            subModuleDropDown.empty();

            var firstValue = null;
            $.each(subModules.filtered_sub_modules, function (index, value) {
                if (firstValue == null) {
                    firstValue = index;
                    subModuleDropDown.append('<option value="' + index + '" selected="true">' + value + '</option>' + ' ');
                } else {
                    subModuleDropDown.append('<option value="' + index + '">' + value + '</option>');

                }
            });
            subModuleDropDown.click();
        }

    });
</script>
