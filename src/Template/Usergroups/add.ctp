<?= $this->element('user_management_nav', array('title' => __('Add User Group'), 'permissions' => $user_permission,
    'showNavigationButtons' => true)); ?>
<?php echo $this->Html->css('multi-select.css') ?>
<div class="box box-primary">
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
             <?= $this->Form->create($user_group) ?>
              <div class="form-group">
            	<?php echo $this->Form->input('group_name', array('class' => 'form-control required', 'placeholder' => __('Group Name'), 'error' => false));?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label for="my-select"><?= __('Select Users') ?></label>
              </div>
              <!-- /.form-group -->
              </div>
              </div>
              <!-- /.row -->
                    <select multiple="multiple" id="my-select" name="cmsusers[]">
                        <?php
                        foreach ($users as $user) {
                            echo "<option value='" . $user->id . "'>" . $user->username . "</option>";
                        }
                        ?>
                    </select>
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

    .custom-header {
        text-align: center;
        padding: 3px;
        background: #3c8dce;
        color: #fff;
    }

</style>
<script src="<?php echo $this->request->webroot; ?>js/jquery-1.11.2.js"></script>
 <?php echo $this->Html->script('jquery.multi-select.js'); ?>
         <!-- InnerTablist1 Select Option Value -->
<?php echo $this->Html->script('selectbox1/jcf.js'); ?>
<?php echo $this->Html->script('selectbox1/jcf.select.js'); ?>
<?php echo $this->Html->script('selectbox1/jcf.scrollable.js'); ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
    $(window).load(function () {
        jcf.destroyAll();
        $('#my-select').multiSelect({
            selectableHeader: "<div class='custom-header'><?=__('Available users')?></div>",
            selectionHeader: "<div class='custom-header'><?=__('Selected users')?></div>",
        });
    });
    });
</script>

