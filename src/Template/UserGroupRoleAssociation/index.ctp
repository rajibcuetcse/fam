<?= $this->element('user_management_nav', array(
    'title' => __('User Group Role Association'),
    'permissions' => $user_permission,
    'showNavigationButtons' => false

)); ?>
<?php echo $this->Html->css('multi-select.css') ?>
<div class="box box-primary">
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
             <?= $this->Form->create() ?>
              <div class="form-group">
            	<?php echo $this->Form->input('user_groups', array('options' => $user_groups,
                      'empty' => __('Select a user group'), 'style' => 'float:left;', 'class' => 'form-control'));
                  ?>
                   <img src="<?php echo $this->Url->build('/images/ajax-loader.gif'); ?>"
                                     class="loading_icon"
                                     style="display:none;float: right"/>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                    <label for="role-select"><?= __('Select Roles') ?></label>
                    <br>
                    <a href='#' id='select-all'>select all</a> /
                    <a href='#' id='deselect-all'>deselect all</a>
              </div>
              </div>
          </div>
          <!-- /.row -->
           
              <!-- /.form-group -->     
                    <select multiple="multiple" id="role-select" name="roles[]">
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

        $('#role-select').multiSelect({
            selectableHeader: "<div class='custom-header'><?=__('Available roles')?></div>",
            selectionHeader: "<div class='custom-header'><?=__('Selected roles')?></div>",
        });

        refreshPage();

        function refreshPage() {
            var selectedValue = $("#user-groups").val();
            loadRoles(selectedValue);
        }


        $(document).on('change', '#user-groups', function () {
            var selectedValue = $(this).val();
            loadRoles(selectedValue);
        });

        function loadRoles(selectedValue) {
            var multiSelect = $('#role-select');
            if (selectedValue) {
                $('.loading_icon').show();
                $('.error-message').remove();
                $.ajax({
                    type: "GET",
                    url: '<?=$this->Url->build('/UserGroupRoleAssociation/getRoles/');?>' + selectedValue,
                    dataType: "json",
                    success: function (response) {
                        $('.loading_icon').hide();
                        processRoles(response);
                    },
                    error: function (xhr, status, error) {
                        $('.loading_icon').hide();
                        multiSelect.find('option').remove();
                        multiSelect.after('<label class="error-message" style="color:#ff0000">An error occurred. Please try again</label>');
                    }
                });
            } else {
                multiSelect.find('option').remove();
            }
            multiSelect.multiSelect('refresh');
        }

        function processRoles(roles) {
            var multiSelect = $('#role-select');
            multiSelect.find('option').remove();

            $.each(roles.selected_roles, function (index, value) {
                $('#role-select').append('<option value=' + value.id + ' selected>' + value.title + '</option>');
            });

            $.each(roles.available_roles, function (index, value) {
                $('#role-select').append('<option value=' + value.id + '>' + value.title + '</option>');
            });

            multiSelect.multiSelect('refresh');
        }

        $('#select-all').click(function () {
            $('#role-select').multiSelect('select_all');
            return false;
        });
        $('#deselect-all').click(function () {
            $('#role-select').multiSelect('deselect_all');
            return false;
        });

        $('.btn-default').click(function (e) {
//            var roles_selector = $("#role-select");
//            if (roles_selector.val() == null) {
//                roles_selector.after('<div class="error-message">You should select atleast one role.</div>');
//                return false;
//            } else {
//                $('.error-message').hide();
//            }
            return true;
        });
    });
    });
</script>

