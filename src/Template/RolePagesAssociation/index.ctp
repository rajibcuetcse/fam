<?= $this->element('user_management_nav', array(
    'title' => __('Role Pages Association'),
    'permissions' => $user_permission,
    'showNavigationButtons' => false
)); ?>


  <div class="row">
        <div class="col-md-12">
        <?= $this->Form->create(); ?>
         <?= $this->Form->hidden('selected_pages'); ?>
          <div class="box box-primary">
            <div class="box-header">

			  <div class="row">
				 <div class="col-md-6">
				     
                 <div class="form-group">
                        <label for="role">Role Name</label>
                   

                
                            <span id="ANCSb1">
                                <?php
                                echo $this->Form->input('role', array('label' => false, 'options' => $roles,
                                    'empty' => __('Select a role'), 'class' => 'form-control'));
                                ?>
                                <img src="<?php echo $this->Url->build('/images/ajax-loader.gif'); ?>"
                                     class="loading_icon"
                                     style="display:none;float: right"/>
                            </span>
                    
            </div>
           
				 </div>
			  </div>
			</div><!-- box-header end -->
	  <div class="box-body table-responsive ">
	    <div class="table-responsive">
                            <table class="table table-bordered">

                                <thead>
                                <tr>
                                    <th>
                                        Id
                                    </th>

                                    <th>
                                        Module
                                    </th>

                                    <th >
                                        Sub Module
                                    </th>

                                    <th>
                                        Pages
                                    </th>

                                    <th>
                                        Action
                                    </th>

                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                foreach ($modules as $module) { ?>

                                    <tr>
                                        <td>
                                            <?= $module->id; ?>
                                        </td>

                                        <td>
                                            <?= $module->name; ?>
                                        </td>

                                        <td colspan="3">
                                            <table class="table"  style="width:100%;">
                                                <tbody>
                                                <?php
                                                foreach ($module->sub_modules as $submodule) {
                                                    if(!$submodule->pages){
                                                        continue;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td style="width:50%;"><?= $submodule->name; ?></td>
                                                        <td style="width:50%;">
                                                            <table  class="table table-hover"  style="width:100%">
                                                                <tbody>
                                                                <?php
                                                                $pages = array();
                                                                foreach ($submodule->pages as $page) {
                                                                    array_push($pages, $page);
                                                                    ?>

                                                                    <tr>
                                                                    <td style="width:80%;" >
                                                                        <?= $page->name; ?>
                                                                    </td style="width:20%;">

                                                                    <td style="align-content: right;">
                                                                        <a id="page_<?= $page->id ?>" href="#page_<?= $page->id ?>"
                                                                           role="button">
                                                                            <i class="fa fa-remove"></i>
                                                                        </a>
                                                                    </td>
                                                                    </tr>

                                                                    <?php
                                                                }
                                                                ?>
                                                                <tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                } ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>

                                    <?php
                                } ?>

                                </tbody>
                            </table>
                        </div>
                        <!-- / table-responsive -->
	  </div><!-- box-body end -->
	  <div class="box-footer">
	   <div class="col-md-12 text-right mb-15">
                
                        <?= $this->Form->button(__('Save'), ['class' => 'btn btn-primary']) ?>
                   

              
                        <?= $this->Form->button(__('Cancel'), ['class' => 'cancel btn btn-primary']) ?>
                
                
            </div>
	  </div>
	</div><!-- box box-primary end -->
	 <?= $this->Form->end(); ?>
	</div> <!-- col-md-12 end-->
	</div>  <!-- row end -->
		
		   
<style type="text/css">
    .error-message {
        color: #ff0000;
    }

    .table tbody tr td:last-child {
           text-align: left !important;
         /*padding-right: 8px;*/
        padding: 8px !important;
     }




</style>
<!-- Core JavaScript Files -->
<?php echo $this->Html->script('jquery-1.11.2.js'); ?>
<?php echo $this->Html->script('jquery.multi-select.js'); ?>
<script type="text/javascript">
    $(window).load(function () {
        refreshIcons();

        function refreshIcons() {
            var selected_pages_element = $("input[name='selected_pages']");
            var selected_pages = selected_pages_element.val();
            var array = selected_pages.split(',');

            $("a[id^='page_']").each(function () {
                var page = $(this).prop('id');
                if ($.inArray(page, array) != -1) {
                    $(this).find("i").removeClass('fa-remove', 500);
                    $(this).find("i").addClass('fa-check', 500);
                    $(this).addClass('color-fa2', 500);
                } else {
                    $(this).find("i").removeClass('fa-check', 500);
                    $(this).find("i").addClass('fa-remove', 500);
                    $(this).removeClass('color-fa2', 500);
                }
            });
        }

        $(document).on('change', '#role', function () {
            var selectedValue = $(this).val();
            var selected_pages_element = $("input[name='selected_pages']");
            //alert(selectedValue);
            
            if (selectedValue) {
                $('.loading_icon').show();
                $('.error-message').remove();
                $.ajax({
                    type: "GET",
                    url: '<?=$this->Url->build('/RolePagesAssociation/getAssociatedPages/');?>' + selectedValue,
                    dataType: "json",
                    success: function (response) {
                        $('.loading_icon').hide();
                        processPages(response);
                    },
                    error: function (xhr, status, error) {
                        $('.loading_icon').hide();
                        selected_pages_element.val('');
                        refreshIcons();
                    }
                });
            } else {
                selected_pages_element.val('');
                refreshIcons();
            }

        });

        function processPages(roles) {
            var selected_pages_element = $("input[name='selected_pages']");
            selected_pages_element.val(roles.selected_pages.join(','));
            refreshIcons();
        }

        $(".cancel").click(function (e) {
            window.location.href = "<?= $this->Url->build('/RolePagesAssociation/')?>";
            return false;

        });

        $("a[id^='page_']").click(function (e) {
            var selected_pages_element = $("input[name='selected_pages']");
            var selected_pages = selected_pages_element.val();
            var clickedValue = $(this).prop('id');

            var array = selected_pages.split(',');
            if ($.inArray(clickedValue, array) != -1) {
                array = $.grep(array, function (value) {
                    return value != clickedValue;
                });
                selected_pages_element.val(array.join(','));
            } else {
                var value = selected_pages_element.val();
                if (value != '') {
                    selected_pages_element.val(value + ',' + clickedValue);
                } else {
                    selected_pages_element.val(clickedValue);
                }
            }
            refreshIcons();
            e.preventDefault();
        });
    });
</script>

