<div class="row">
<div class="col-md-12">
<div class="box box-primary">
<div class="box-body">
<div class="row">
	<div class="col-md-6">
		<h3 class="box-title no-margin"><span class="glyphicon glyphicon-user"></span>Edit Profile</h3>
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
             <?= $this->Form->create($cmsuser,array('enctype'=>'multipart/form-data')) ?>
              <div class="form-group">
            	<?php 
            		echo $this->Form->input('previous_img_path', array('type' => 'hidden','value'=>$cmsuser['img_path']));
                    echo $this->Form->input('language', array('options' => $languages,'class'=>'form-control'));
                ?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('username', array('class' => 'form-control required', 'placeholder' => __('Username')));?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('password', array('class' => 'form-control required','id' => 'password1', 'placeholder' => __('Password')));?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->password('retype_password', array('id' => 'password2', 'class' => 'form-control required', 'placeholder' => __('Retype Password'), 'value' => $cmsuser->password));?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('email', array('class' => 'form-control required', 'placeholder' => __('Email')));?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php 
                	echo $this->Form->input('img_path', array('type' => 'file', 'label' => __('Profile Picture')));
                ?><br/>
                <?php
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
          <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary','id' => 'btnSubmit']) ?>
        </div>
        <?= $this->Form->end() ?>
      </div>
<script src="<?php echo $this->request->webroot; ?>js/jquery-1.11.2.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#btnSubmit").click(function () {
            var password = $("#password1").val();
            var confirmPassword = $("#password2").val();
            if (password != confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
        });
    });
</script>