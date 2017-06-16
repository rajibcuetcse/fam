<?= $this->element('user_management_nav', array('title' => __('Add Role'), 'permissions' => $user_permission,
    'showNavigationButtons' => true)); ?>
<div class="box box-primary">
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
             <?= $this->Form->create($role) ?>
              <div class="form-group">
            	<?php echo $this->Form->input('title', array('label' => 'Role Name', 'class' => 'form-control required', 'placeholder' => __('Role Name'), 'error' => false));?>
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

        $('.custom-btn1').click(function (e) {
            var roleName = $("#role-name");
            return !roleName.checkValidity();

        });

    });

</script>
