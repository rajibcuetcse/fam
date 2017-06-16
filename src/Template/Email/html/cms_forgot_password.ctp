<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reset Password</title>
</head>
 <body>

Dear <?php echo $data["username"];?>,<br/><br/>
 
Please click <a href="<?php echo $this->Url->build('/admin/reset_password/'.$data['pin'].'/'.$data['token'], true); ?>">here</a> to reset your password or copy paste below link in browser URL bar:
<br/>
<?php echo $this->Url->build('/admin/reset_password/'.$data['pin'].'/'.$data['token'], true); ?>
<br/><br/>

Regards,<br/>
ZeerowApp Team<br/>
 
</body>
</html> 