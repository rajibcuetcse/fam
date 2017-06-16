<style>
.message.error {
	    background: #fe0000 none repeat scroll 0 0;
	    color: #ffffff;
	    line-height: 28px;
		font-size:15px;
		text-align:center;
	    margin-bottom: 25px !important;
	}

	.message.success {
	    background: #337ab7 none repeat scroll 0 0;
	    color: #ffffff;
		font-size:15px;
	    line-height: 28px;
		text-align:center;
	    margin-bottom: 25px !important;
	}
</style>
<div class="login-box">
  <div class="login-logo">
  <?php
	    if(!empty($setting['logo_path'])){
	    	$logo_path = $setting['logo_path'];
	    } else{
	    $logo_path = 'images/logo/default_logo.png';
		}
   ?>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><a href="<?php echo $this->Url->build('/'); ?>"><img alt="Login Logo" src="<?php echo $this->Url->build('/'.$logo_path); ?>" style="width: 215px;height: 60px;"></a></p>
	<?php if ($msg != '') { ?>
	    <p class="unsuccess"><span class="glyphicon glyphicon-remove"></span> <?php echo $msg; ?></p>
	<?php } ?>
	
	<?php
	echo $this->Form->create('Login');
	?>
	  <?= $this->Flash->render() ?>
      <div class="form-group has-feedback">
        <?php echo $this->Form->input('email', array('required' => 'required', 'class' => 'form-control FormControl1', 'id' => 'inputfeedback1', 'placeholder' => __('Email'), 'label' => false));?>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <?php
		    if (array_key_exists('username', $errors)) {
		        echo '<p class="unsuccess">';
		        if (array_key_exists('_empty', $errors['username'])) {
		            echo $errors['username']['_empty'];
		        }
		        echo '</p>';
		    }
		?>
      </div>
      <div class="form-group has-feedback">
        <?php echo $this->Form->input('password', array('type' => 'password', 'required' => 'required', 'label' => false, 'class' => 'form-control FormControl1', 'id' => 'inputfeedback2', 'placeholder' => __('Password')));?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <?php
		    if (array_key_exists('password', $errors)) {
		        echo '<p class="unsuccess">';
		        if (array_key_exists('_empty', $errors['password'])) {
		            echo $errors['password']['_empty'];
		        }
		        echo '</p>';
		    }
    	?>
      </div>
      <div class="row">
        <div class="col-xs-8">
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    <?php echo $this->Form->end();?>

    <a href="<?php echo $this->Url->build('/users/forgot_password'); ?>"><?php echo __('Forgot your password?'); ?></a><br>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->