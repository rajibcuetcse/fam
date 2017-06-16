<?= $this->element('user_management_nav', array('title' => __('Edit Role'), 'permissions' => $user_permission,
    'showNavigationButtons' => true)); ?>
<div class="box box-primary">
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <?= $this->Form->create($role);?>   
              <?php echo $this->Form->input('id', array('type' => 'hidden','value'=>$role['id']));?>          
              <div class="form-group">
                <?php echo $this->Form->input('title', array('label' => 'Role Name', 'value' => $role->title, 'class' => 'form-control required', 'placeholder' => __('Role Name')));?>
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