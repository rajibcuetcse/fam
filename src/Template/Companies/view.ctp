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
			<h3 class="box-title no-margin"><span class="glyphicon glyphicon-file"></span>View Company</h3>
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
             <div class="nav-tabs-custom">

             <ul class="nav nav-tabs">
	              <li class="active"><a href="#" data-toggle="tab" id="basic_info"><?php echo __('Company info'); ?></a></li>
	              <li><a href="#" data-toggle="tab" id="super_admin"><?php echo __('SUPER_ADMIN'); ?></a></li>
            </ul>

              <div id="basic_info_div">
              <div class="form-group">
            	<label><strong><?= __('Company Name:') ?></strong></label>
                <p><?= h($company->name) ?></p>
              </div>
              <div class="form-group">
            	<label><strong><?= __('CONTACT_NAME') ?>:</strong></label>
                <p><?= h($company->cname) ?></p>
              </div>
              <div class="form-group">
            	<label><strong><?= __('CONTACT_EMAIL') ?>:</strong></label>
                <p><?= h($company->cemail) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('Address One:') ?></strong></label>
                <p><?= h($company->address1) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('Address Two:') ?></strong></label>
                <p><?= h($company->address2) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('City:') ?></strong></label>
                <p><?= h($company->city) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('State:') ?></strong></label>
                <p><?= h($company->state) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('Country:') ?></strong></label>
                <p><?= h($company->country) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('CONFEDERATION') ?>:</strong></label>
                <p><?= h($company->confederation) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('Post Code:') ?></strong></label>
                <p><?= h($company->postcode) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('FA_GENERAL_SECRETARY') ?>:</strong></label>
                <p><?= h($company->general_secretary) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('Phone:') ?></strong></label>
                <p><?= h($company->phone) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('Tax/Registration Number') ?></strong></label>
                <p><?= h($company->registration_no) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('RANK_W') ?>:</strong></label>
                <p><?= h($company->ranking_w) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('RANK_M') ?></strong></label>
                <p><?= h($company->ranking_m) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('Time Zone') ?></strong></label>
                <p><?= h($timezone_offset) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('Logo:') ?></strong></label>
                <p style="width:100px;"><?php echo $this->Html->image('/media/companies/' . $company->logo) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
              <?= $this->Form->button(__('NEXT'), ['type' => 'button', 'class' => 'btn btn-primary nexttab1']); ?>
              </div><br/>
              <!-- /.form-group -->
            </div>
            
            <div id="super_admin_div" class="hide">
             <div class="form-group">
                <label><strong><?= __('Language:') ?></strong></label>
        		<p><?= h($company->cmsusers[0]->language) ?></p>
              </div>
              <!-- /.form-group -->
               <div class="form-group">
                <label><strong><?= __('Username:') ?></strong></label>
        		<p><?= h($company->cmsusers[0]->username) ?></p>
              </div>
              <!-- /.form-group -->
             <div class="form-group">
                <label><strong><?= __('Email:') ?></strong></label>
        		<p><?= h($company->cmsusers[0]->email) ?></p>
              </div>
              <!-- /.form-group -->
              
              <div class="form-group">
                <?= $this->Form->button(__('Previous'), ['class' => 'btn btn-primary prevtab2 previous']) ?>
              </div><br/>
              <!-- /.form-group -->
            </div>
            
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
      </div>
 
<style>
    img {
        max-width: 100%;
        max-height: 100%;
    }
</style>
<script>
    $(document).ready(function () {
        $(document).on('click', '.delete', function (e) {
            var id = $(this).attr('id');
            
            $('<form action="<?= $this->Url->build('/companies/delete/')?>'+ id +'"' + ' method="POST">' +
                '</form>').appendTo("body").submit();
            
        });
    });

    $(window).load(function () {

        function showTab1() {
            $("#basic_info_div").removeClass("hide");
            $("#super_admin_div").addClass("hide");
            $("#business_info_div").addClass("hide");
            $('#basic_info').parent().addClass("active");
            $('#super_admin').parent().removeClass("active");
            $('#business_info').parent().removeClass("active");
        }

        function showTab2() {
            $("#basic_info_div").addClass("hide");
            $("#super_admin_div").removeClass("hide");
            $("#business_info_div").addClass("hide");
            $('#basic_info').parent().removeClass("active");
            $('#super_admin').parent().addClass("active");
            $('#business_info').parent().removeClass("active");
        }

        function showTab3() {

            $("#basic_info_div").addClass("hide");
            $("#super_admin_div").addClass("hide");
            $("#business_info_div").removeClass("hide");
            $('#basic_info').parent().removeClass("active");
            $('#super_admin').parent().removeClass("active");
            $('#business_info').parent().addClass("active");

        }

        $(document).on('click', '#basic_info', function (e) {
            showTab1();
        });

        $(document).on('click', '#super_admin', function (e) {
            showTab2();
        });

        $(document).on('click', '#business_info', function (e) {
            showTab3();
        });

        $(document).on('click', '.nexttab1', function (e) {
            showTab2();
        });

        $(document).on('click', '.nexttab2', function (e) {
            showTab3();
        });


        $(document).on('click', '.prevtab2', function (e) {
            showTab1();
        });

        $(document).on('click', '.prevtab3', function (e) {
            showTab2();
        });

        $('.next').click(function (e) {
//            $('.company-details').hide();
//            $('.company-basic-details').show();
//            $('.header').text('Basic Info');
        });

        $('.previous').click(function (e) {
//            $('.company-details').show();
//            $('.company-basic-details').hide();
//            $('.header').text('Company Details');
        });

    });

</script>

