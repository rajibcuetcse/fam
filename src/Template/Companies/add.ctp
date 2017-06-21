 <?php 
	 echo $this->Html->script('jquery-1.11.2.js');
	 $menu_modules = unserialize($this->request->session()->read('modules'));
 ?>
<div class="row">
<div class="col-md-12">
<div class="box box-primary">
<div class="box-body">
<div class="row">


		<div class="col-md-6">
			<h3 class="box-title no-margin"><span class="glyphicon glyphicon-file"></span><?php echo __('ADD_COMPANY'); ?></h3>
		</div>

	<div class="col-md-6">



 <div class="row">

  <div class="col-md-12 text-right">
                    <?php
                    if (array_key_exists("add", $module_pages)):
                        $page_id = $module_pages["index"];
                        foreach ($user_permission as $permission):
                            if ($permission['page_id'] == $page_id):?>
                             
                                    <a href="<?php echo $this->Url->build('/companies/index/'); ?>"  class="btn btn-success btn-flat btn-grid">
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
                  <button type="button" class="btn btn-primary"><?php echo __('COMPANY_MANAGEMENT'); ?></button>
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
											if(strtolower($submodule['controller_name']) != strtolower($current_sub_module)){
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

 <!-- Modal -->
    <div class="modal fade" id="myModal-3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Image</h4>
                </div>
                <?php
                echo $this->Form->create('Post', array('type' => 'file', 'class' => 'upload_file'));
                ?>
                <div class="modal-body">
                            <span class="btn btn-info btn-block btn-file select_file" style="overflow:hidden;">
                                Browse
                                <?php
                                echo $this->Form->input('doc_file', array('type' => 'file', 'label' => false,
                                    'class' => 'required'));
                                ?>
                            </span>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <?php
                    echo $this->Form->button('Add', array('class' => 'btn btn-primary sub_btn'));
                    ?>
                    <img src="<?php echo $this->Url->build('/images/loadingicon.gif'); ?>" class="loading_icon"
                         style="display:none;"/>
                </div>
                <?php
                echo $this->Form->end();
                ?>
            </div>
            <!-- / modal-content -->
        </div>
        <!-- / modal-dialog -->
    </div>
 <!-- Modal -->

        <div class="box box-primary">
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
             <?= $this->Form->create($company, ['id' => 'company_form']); ?>            
             <div class="nav-tabs-custom">

             <ul class="nav nav-tabs">
	              <li class="active"><a href="#" id="basic_info"><?php echo __('COMPANY_INFO'); ?></a></li>
	              <li><a href="#" id="super_admin"><?php echo __('SUPER_ADMIN'); ?></a></li>
            </ul>

              <div id="basic_info_div">
              <div class="form-group">
            	<?php echo $this->Form->input('company.name', ['label' => __('COMPANY_NAME'), 'class' => 'form-control', 'required' => true, 'error' => ['Please fill out this field.' => __('ENTER_COMPANY_NAME')]]); ?>
              </div>   
              <!-- /.form-group -->
              <div class="form-group">
            	<?php echo $this->Form->input('company.cname', ['label' => __('CONTACT_NAME'), 'class' => 'form-control required', 'error' => ['Please fill out this field.' => __('ENTER_CONATACT_NAME')]]); ?>
              </div>   
              <!-- /.form-group -->
              <div class="form-group">
            	<?php echo $this->Form->input('company.cemail', ['label' => __('CONTACT_EMAIL'), 'class' => 'form-control required', 'error' => ['Please fill out this field.' => __('ENTER_CONATACT_EMAIL')]]); ?>
              </div>  
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('company.address1', ['label' => __('ADDRESS_ONE'), 'class' => 'form-control required', 'error' => __('ENTER_ADDRESS')]); ?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('company.address2', ['label' => __('ADDRESS_TWO'), 'required' => false, 'class' => 'form-control']); ?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('company.city', ['label' => __('CITY'), 'class' => 'form-control required']); ?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('company.state', ['label' => __('STATE'), 'class' => 'form-control required']); ?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('company.country', ['empty' => __('SELECT_COUNTRY'), 'options' => $countries, 'class' => 'form-control required']); ?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('company.confederation', ['empty' => __('SELECT_FA_CONFEDERATION'), 'options' => json_decode(FA_CONFEDERATION), 'class' => 'form-control required']); ?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('company.postcode', ['label' => __('POSTCODE'), 'class' => 'form-control required']); ?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('company.general_secretary', ['label' => __('FA_GENERAL_SECRETARY'), 'class' => 'form-control required']); ?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('company.phone', ['label' => __('PHONE'), 'type' => 'tel', 'class' => 'form-control required']); ?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('company.registration_no', ['type' => 'number', 'label' => __('Tax/Registration Number'), 'class' => 'form-control', 'min' => 0]); ?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('company.ranking_w', ['type' => 'number', 'label' => __('RANK_W'), 'class' => 'form-control', 'min' => 0]); ?>
              </div>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('company.ranking_m', ['type' => 'number', 'label' => __('RANK_M'), 'class' => 'form-control', 'min' => 0]); ?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('company.timezone',['empty' => __('Select Time Zone'),'options'=>$timezones,'label' => __('Time Zone'),'class'=>'form-control','required' => true]); ?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('company.logo', ['type' => 'file', 'label' => __('Corporate Logo'), 'data-toggle' => 'modal', 'data-target' => '#myModal-3', 'required' => true]); ?>
              </div>
              <!-- /.form-group -->
              <ul class="list-unstyled uploaded_files">
              <div class="form-group">
              <?= $this->Form->button(__('NEXT'), ['type' => 'button', 'class' => 'btn btn-primary tab1Next']); ?>
              </div><br/>
              <!-- /.form-group -->
            </div>
            
            <div id="super_admin_div" class="hide">
             <div class="form-group">
                <?php echo $this->Form->input('cmsuser.language', ['label' => __('LANGUAGE'), 'options' => $languages, 'class' => 'form-control required', 'required' => true]); ?>
              </div>
              <!-- /.form-group -->
               <div class="form-group">
                <?php echo $this->Form->input('cmsuser.username', ['label' => __('USERNAME'), 'class' => 'form-control required', 'required' => true]); ?>
              </div>
              <!-- /.form-group -->
               <div class="form-group">
                <?php echo $this->Form->input('cmsuser.password', ['label' => __('PASSWORD'), 'class' => 'form-control required', 'required' => true]); ?>
              </div>
              <!-- /.form-group -->
               <div class="form-group">
                <?php echo $this->Form->input('cmsuser.retype_password', ['type' => 'password', 'label' => __('RE_TYPE_PASSWORD'), 'required' => true, 'oninput' => 'checkRetypePassword(this)', 'id' => 'retype_password', 'placeholder' => __('RE_TYPE_PASSWORD'), 'class' => 'form-control required']); ?>
              </div>
              <!-- /.form-group -->
               <div class="form-group">
                <?php echo $this->Form->input('cmsuser.email', ['type' => 'email', 'label' => __('EMAIL'), 'required' => true, 'pattern' => '^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$', 'class' => 'form-control required']); ?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary tab3Save']) ?>
              </div><br/>
              <!-- /.form-group -->
            </div>
            
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <?= $this->Form->end() ?>
      </div>


<script>
    function checkRetypePassword(input) {
        //alert($(input).val());
        //alert($('#cmsuser-password').val());
        if ($(input).val() != $('#cmsuser-password').val()) {
            input.setCustomValidity('The two passwords must match.');
        } else {
            // input is valid -- reset the error message
            input.setCustomValidity('');
        }
    }
    function checkPassword(input) {

        alert($(input).val());
        alert($('#retype_password').val());

        if ($(input).val() != $('#retype_password').val()) {
            input.setCustomValidity('The two passwords must match.');
        } else {
            // input is valid -- reset the error message
            input.setCustomValidity('');
        }
    }

    $(document).ready(function () {


        function showTab1() {
            if (validateTab1()) {
                $("#basic_info_div").removeClass("hide");
                $("#super_admin_div").addClass("hide");
                $('#basic_info').parent().addClass("active");
                $('#super_admin').parent().removeClass("active");                
            }
        }

        function showTab2() {
                
            if (validateTab1()) {
                $("#basic_info_div").addClass("hide");
                $("#super_admin_div").removeClass("hide");
                $('#basic_info').parent().removeClass("active");
                $('#super_admin').parent().addClass("active");
                
            }
        }

       

        $(document).on('click', '#basic_info', function (e) {
            showTab1();
        });

        $(document).on('click', '#super_admin', function (e) {
            showTab2();
        });
  
        
        $(document).on('click', '.tab1Next', function (e) {
            //alert("gg");
            showTab2();
        });
        
        function validateTab1() {
                
            if (!$('#company-name')[0].checkValidity()
                || !$('#company-address1')[0].checkValidity()
                || !$('#company-address2')[0].checkValidity()
                || !$('#company-postcode')[0].checkValidity()
                || !$('#company-phone')[0].checkValidity()
                || !$('#company-city')[0].checkValidity()
                || !$('#company-state')[0].checkValidity()
                || !$('#company-country')[0].checkValidity()
                || !$('#company-timezone')[0].checkValidity()
                || !$('#company-logo')[0].checkValidity()
            ) {
                
                $('#company_form').find('.tab3Save').click();
                return false;
            }
            return true;
        }

       
        $('.upload_file').submit(function (e) {
            var form_tag = $(this);
            var image = e.target['doc_file'];

            if (image.files.length > 0) {

                if (image.files[0].type.match('image/*')) {

                    var form_id = form_tag.attr('id');
                    form_tag.find('.sub_btn').hide();
                    form_tag.find('.loading_icon').show();
                    form_tag.find('.loading_icon').next().text('Uploading File');

                    $.ajax({
                        url: '<?php echo $this->Url->build('/companies/uploadPicture'); ?>/',
                        type: 'POST',
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            //alert(response);
                            //e.preventDefault();
                            if (response != 'error' && response != 'not_allowed') {
                                var res = JSON.parse(response);
                                $('input[name="uploaded_file"]').remove();
                                $('#company-logo').removeAttr('required');
                                $('.uploaded_files').append('<li class="img">' + image.files[0].name + '<input type="hidden" class="uploaded_file" name="uploaded_file" value="' + res.file_name + '" /> &nbsp; <img src="<?php echo $this->Url->build('/images/Page 1/text_editor_0009_active_button-close.png'); ?>" class="delete_media" /></li>');
                                form_tag.find('.loading_icon').next().text('');
                                form_tag.trigger('reset');
                                form_tag.find('.sub_btn').show();
                                form_tag.find('.loading_icon').hide();
                                $('.close').trigger('click');
                                $('.select_file').removeClass('active');
                                $('.add_content_media').hide();

                            }
                            else {
                                if (response == 'not_allowed') {
                                    form_tag.find('.loading_icon').next().text('Choosen file type is not allowed to upload.');
                                    form_tag.trigger('reset');

                                    form_tag.find('.sub_btn').show();
                                    form_tag.find('.loading_icon').hide();
                                }
                                else if (response == 'error') {
                                    form_tag.find('.loading_icon').next().text('Error: Could not upload file. Please try again.');
                                    form_tag.trigger('reset');
                                    form_tag.find('.sub_btn').show();
                                    form_tag.find('.loading_icon').hide();
                                }
                            }
                        },
                        error: function (data) {
                            form_tag.find('.loading_icon').next().text('An unknown error occured. Please try again');
                            form_tag.trigger('reset');
                            form_tag.find('.sub_btn').show();
                            form_tag.find('.loading_icon').hide();
                        }
                    });
                } else {
                    form_tag.find('.loading_icon').next().text('Please select a valid file type');
                    form_tag.trigger('reset');
                    form_tag.find('.sub_btn').show();
                    form_tag.find('.loading_icon').hide();
                }
            } else {
                form_tag.find('.loading_icon').next().text('Please select a picure to upload');
                form_tag.trigger('reset');
                form_tag.find('.sub_btn').show();
                form_tag.find('.loading_icon').hide();
            }

            e.preventDefault();
        });

        $(document).on('click', '#company-logo', function (e) {
            e.preventDefault();
        });

        $(document).on('click', '.delete_media', function (e) {
            var f_name = $(this).prev().val();
            var f_type = '4';
            var tag = $(this).parent();
            $.ajax({
                url: '<?php echo $this->Url->build('/companies/removeMedia'); ?>',
                type: 'POST',
                data: {f_type: f_type, f_name: f_name},
                success: function (response) {
                    //alert(response);
                    $('#company-logo')[0].required = true;
                    tag.remove();
                    $('.add_content_media').show();
                },
                error: function (data) {
                    //alert(data.toSource());
                }
            });
        });

    });

</script>
