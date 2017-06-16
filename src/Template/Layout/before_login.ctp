<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php
    if(!empty($setting['favicon_path'])){
    	$favicon_path = $setting['favicon_path'];
    } else{
    $favicon_path = 'images/favicon/favicon.ico';
	}
  ?>
  <link rel="shortcut icon" href="<?php echo $this->request->webroot.'webroot/'.$favicon_path;?>" type="image/icon">
  <title><?php echo $setting['title'];?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin_lte/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/js/html5shiv.min.js"></script>
  <script src="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/js/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
	<?= $this->fetch('content') ?>
<!-- jQuery 2.2.0 -->
<script src="<?php echo $this->request->webroot; ?>admin_lte/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo $this->request->webroot; ?>admin_lte/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo $this->request->webroot; ?>admin_lte/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>