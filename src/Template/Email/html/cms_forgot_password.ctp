<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reset Password</title>
</head>
 <body>

Dear <?php echo $username;?>,<br/><br/>
 
Please click <a href="<?php echo $this->Url->build('admin/reset_password/'.$pin.'/'.$token, true); ?>">here</a> to reset your password or copy paste below link in browser URL bar:
<br/>
<?php echo $this->Url->build('admin/reset_password/'.$pin.'/'.$token, true); ?>
<br/><br/>

Regards,<br/>
FA Team<br/>
 
</body>
</html> 