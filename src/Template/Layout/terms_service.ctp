<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="<?= APP_SERVER_HOST_URL?>favicon.ico" type="image/icon">
<link rel="icon" href="<?= APP_SERVER_HOST_URL?>favicon.ico" type="image/icon">

<title>ZeerowApp</title>

<!-- Bootstrap Core CSS -->
<?php echo $this->Html->css('bootstrap.css') ?>

<!-- Custom CSS -->
<?php echo $this->Html->css('custom_style.css') ?>
<?php echo $this->Html->css('custom.css') ?>

<!-- font-awesome CSS -->
<?php //echo $this->Html->css('../fonts/custom_fonts/font-awesome-4.3.0/css/font-awesome.css') ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<?php echo $this->Html->script('jquery-1.11.2.js'); ?>
</head>

<body>

    <div class="page">
    	<div class="wrapper">
            <div class="container">
                <div class="row">
                    <div>
                        <a href="<?php echo $this->Url->build('/'); ?>"><img class="img-responsive center-block" alt="Login Logo" src="<?php echo $this->Url->build('/images/logo.png'); ?>"></a>
                            <?= $this->Flash->render() ?>
                            <?= $this->fetch('content') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	
<!-- Core JavaScript Files --> 
<?php echo $this->Html->script('bootstrap.js'); ?>

</body>
</html>

<style type="text/css">
    #status-area .flash_message {
        padding: 5px;
        color: red;
    }
    .CredentialsBlk1{
        max-width: auto !important;
        padding: 0px !important;
    }
    
</style>

