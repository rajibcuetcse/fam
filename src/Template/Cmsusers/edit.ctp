<?= $this->element('user_management_nav', array('title' => __('Edit User'), 'permissions' => $user_permission,
    'showNavigationButtons' => true)); ?>
        <div class="box box-primary">
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <?= $this->Form->create($cmsuser,array('enctype'=>'multipart/form-data')) ?>
              <div class="form-group">
            	<?php 
	            	echo $this->Form->input('previous_img_path', array('type' => 'hidden','value'=>$cmsuser['img_path']));
	            	echo $this->Form->input('language', array('options' => $languages, 'class'=>'form-control'));
            	?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('username', array('class' => 'form-control required', 'placeholder' => __('Username')));?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php  echo $this->Form->input('password', array('class' => 'form-control required', 'placeholder' => __('Password')));?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->password('retype_password', array('id' => 'retype_password', 'class' => 'form-control required', 'placeholder' => __('Retype Password'), 'value' => $cmsuser->password));?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('email', array('class' => 'form-control required', 'placeholder' => __('Email')));?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('img_path', array('type' => 'file', 'label' => __('Profile Picture'),'id'=> 'exampleInputFile'));
              		if(!empty($cmsuser['img_path'])){
                    ?>
                    <img src="<?php echo $this->request->webroot.$cmsuser['img_path'];?>" style="width:70px;height:50px;">
                    <?php
                    	} else{
                    ?>
                    <img src="<?php echo $this->request->webroot.'media/companies/default.jpg'?>" style="width:70px;height:50px;">
                    <?php
                    	}
                    ?>
              </div>
              <!-- /.form-group -->
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
      
<style type="text/css">

    .error-message {
        color: #ff0000;
    }


</style>
<script>
    $(window).load(function () {
        $("#retype_password").change(function () {
            if ($(this).val() != $("#password").val()) {
                var nextElement = $(this).next();
                if (!nextElement.hasClass("error-message")) {
                    $(this).after('<div class="error-message">Passwords do not match</div>');
                }
            } else {
                $('.error-message').hide();
            }
        });

    });
</script>
