<?php
if(array_key_exists('bad_request', $errors))
{
	echo '<p class="message unsuccess">'.$errors['bad_request'].'</p>';
}
else
{
?>
    <?php
        echo $this->Form->create('reset_password');
    ?>
        <div class="form-group has-feedback">
            <?php
                echo $this->Form->input('password', array('required' => 'required', 'class' => 'form-control FormControl1', 'label' => false, 'placeholder' => __('New Password')));
            ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <?php
                if(array_key_exists('password', $errors)){
                    echo '<p class="unsuccess">';
                    if(array_key_exists('_empty', $errors['password']))
                    {
                            echo $errors['password']['_empty'];
                    }
                    if(array_key_exists('length', $errors['password']))
                    {
                            echo $errors['password']['length'];
                    }
                    echo '</p>';
                }
            ?>
        </div>

        <div class="form-group has-feedback">
            <?php
                echo $this->Form->input('confirm_password', array('type' => 'password', 'required' => 'required', 'class' => 'form-control FormControl1', 'label' => false, 'placeholder' => __('Confirm Password')));
            ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <?php
                if(array_key_exists('confirm_password', $errors)){
                    echo '<p class="unsuccess">';
                    if(array_key_exists('_empty', $errors['confirm_password']))
                    {
                        echo $errors['confirm_password']['_empty'];
                    }
                    if(array_key_exists('match', $errors['confirm_password']))
                    {
                        echo $errors['confirm_password']['match'];
                    }
                    echo '</p>';
                }
            ?>
        </div>

        <div class="form-group">
            <button class="btn btn-lg btn-block btn-primary" type="submit"><?php echo __('Reset Password'); ?></button>
        </div><!-- / form-group -->

        <div class="col-md-12 col-sm-12 col_0 FormText1">
            <a href="<?php echo $this->Url->build('/'); ?>"><?php echo __('Login'); ?></a>
        </div><!-- / col-md-12 -->
    <?php
        echo $this->Form->end();
    ?>
<?php
}
?>
