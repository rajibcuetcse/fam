<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $setting['title'];?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <?php echo $setting['meta_tag'];?>
<?php
    if(!empty($setting['favicon_path'])){
    	$favicon_path = $setting['favicon_path'];
    } else{
    $favicon_path = 'images/favicon/favicon.ico';
	}
?>
  <link rel="icon" href="<?php echo $this->request->webroot.'webroot/'.$favicon_path;?>" type="image/icon">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/plugins/daterangepicker/daterangepicker-bs3.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!--  cms_style.css   custom style -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>css/cms_style.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/js/html5shiv.min.js"></script>
  <script src="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/js/respond.min.js"></script>
  <![endif]-->
  
</head>
<body class="hold-transition skin-blue sidebar-mini">
<?php $username = $this->request->session()->read('Auth.User.username'); 
$img_path = $this->request->session()->read('Auth.User.img_path');
$profile_picture = (empty($img_path)) ? $this->request->webroot."media/companies/default.jpg" : $this->request->webroot.$img_path;
?>
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo $this->Url->build('/dashboard'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><?php echo $this->Html->image('../images/zeerow_logo.png', array('alt' => 'logo')); ?></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?php echo $this->Html->image('../images/zeerow_logo.png', array('alt' => 'logo')); ?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <link href="<?php echo $this->request->webroot; ?>/dist/css/flags.css" rel="stylesheet">
          <li class="dropdown">
          <?php echo $this->Form->create("Cmsusers", array('id'=> 'languageSelectionForm','url' => array('controller' => 'Cmsusers', 'action' => 'changeLanguage')));?>
          <?php 
           		$country_value_array = array(
			    	"en_US"=> "US",
			    	"ja_JP"=> "JP",
			    	"ko_KP"=> "KP",
			    	"zh_CN"=> "CN"
			    	); 	
			    $current_language = $country_value_array[$current_lang];	
		   ?>    
           <div id="options"
                 data-input-name="global_selected_language"
                 data-selected-country=<?php echo $current_language;?>>
           </div>
          <?php echo $this->Form->input('global_current_url', array('type' => 'hidden','id'=>'global_current_url','value' => $this->Url->build(null, true)));?>     
          <?php echo $this->Form->end();?>
          </li>
          <script src="<?php echo $this->request->webroot; ?>admin_lte/plugins/jQuery/jQuery-2.2.0.min.js"></script>
		  <script src="<?php echo $this->request->webroot; ?>/dist/js/jquery.flagstrap.js"></script>
<script>
    $('#options').flagStrap({
        countries: {
            "US": "English",
            "JP": "Japan",
            "KP": "Korean",
            "CN": "China"
        },
        buttonSize: "btn-lg",
        buttonType: "btn-primary btn-flat btn-primary-custom",
        labelMargin: "10px",
        scrollable: false,
        scrollableHeight: "350px",
        onSelect: function (value, element) {
        document.forms["languageSelectionForm"].submit();
            
        }
    });
</script>
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo $profile_picture;?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $username; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="<?php echo $profile_picture;?>" class="img-circle" alt="User Image">
                <p>
                  <?php echo $username; ?> - Admin
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo $this->Url->build(["controller" => "users","action" => "edit-profile"]); ?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo $this->Url->build(["controller" => "users","action" => "logout"]);?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

<!--Start of Main Navigation--> 
<?= $this->element('main_nav') ?>
<!--End of Main Navigation-->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<?php echo  current(array_keys($current_module));?>
	<small><?php echo  current(array_keys($sub_modules));?></small>
  </h1>
</section>

<!-- Main content -->
<section class="content">
   <?= $this->Flash->render() ?>
	<?= $this->fetch('content') ?>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
	$(document).ready(function(){
		$('.content-wrapper').attr('style','min-height:555px;height:auto;');
	});
</script>
<footer class="main-footer">
<strong>Copyright &copy; 2016 <a href="#">CHTL</a>.</strong> All rights
reserved.
</footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<script src="<?php echo $this->request->webroot; ?>js/jquery-1.11.2.js"></script>
<!-- jQuery 2.2.0 -->
<script src="<?php echo $this->request->webroot; ?>admin_lte/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/js/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?php echo $this->request->webroot; ?>admin_lte/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $this->request->webroot; ?>admin_lte/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo $this->request->webroot; ?>admin_lte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo $this->request->webroot; ?>admin_lte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo $this->request->webroot; ?>admin_lte/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/js/moment.min.js"></script>
<script src="<?php echo $this->request->webroot; ?>admin_lte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo $this->request->webroot; ?>admin_lte/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo $this->request->webroot; ?>admin_lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo $this->request->webroot; ?>admin_lte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $this->request->webroot; ?>admin_lte/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $this->request->webroot; ?>admin_lte/dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo $this->request->webroot; ?>admin_lte/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $this->request->webroot; ?>admin_lte/dist/js/demo.js"></script>

<!-- InnerTablist1 Select Option Value -->
<?php echo $this->Html->script('selectbox1/jcf.js'); ?>
<?php echo $this->Html->script('selectbox1/jcf.select.js'); ?>
<?php echo $this->Html->script('selectbox1/jcf.scrollable.js'); ?>

<!-- SmartMenus jQuery plugin -->
<?php echo $this->Html->script('smartmenus.js'); ?>

<!-- SmartMenus jQuery Bootstrap Addon -->
<?php echo $this->Html->script('jquery.smartmenus.bootstrap.js'); ?>


<!-- bootstrap date picker -->
<?php echo $this->Html->script('bootstrap-datepicker.js'); ?>
<?php echo $this->Html->script('timepick.js') ?>
<?php echo $this->Html->script('jquery.countdown.js') ?>

<!-- important custom js -->
<?php echo $this->Html->script('custom.js'); ?>

</body>
</html>