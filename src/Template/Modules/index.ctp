<script src="<?php echo $this->request->webroot; ?>js/jquery-1.11.2.js"></script>
<?php
	echo $this->Html->script('bulk_select.js');
	$menu_modules = unserialize($this->request->session()->read('modules'));
?>

<div class="row">
<div class="col-md-12">
<div class="box box-solid">
<div class="box-body">
<div class="row">


		<div class="col-md-6">
			<h3 class="box-title no-margin"><span class="glyphicon glyphicon-file"></span>Modules</h3>
		</div>

	<div class="col-md-6">



 <div class="row">

<div class="col-md-12  text-right">

 <?php
                    if (array_key_exists("add", $module_pages)):
                        $page_id = $module_pages["add"];
                        foreach ($user_permission as $permission):
                            if ($permission['page_id'] == $page_id):?>
                             
                                    <a href="<?php echo $this->Url->build('/modules/add/'); ?>"  class="btn btn-success btn-flat btn-grid">
                                        <i class="fa fa-plus-square"></i>
                                        <?php echo __('ADD_MODULE'); ?>
                                    </a>
                               
                                <?php
                                break;
                            endif;
                        endforeach;
                    endif;
                    ?>

<div class="btn-group">
                  <button type="button" class="btn btn-primary"><?php echo __('MODULE_MANAGEMENT'); ?></button>
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                   <?php 
						      $access_submodule=array();
						      foreach($user_permission as $row){
						      if(!in_array($row['submodule_id'],$access_submodule))
						      $access_submodule[]=$row['submodule_id'];
						      }
								$current_module = array_values($current_module);
								$current_sub_module = $this->request->params['controller'];
								foreach($menu_modules as $module){
									if($module["id"] == $current_module[0]){
										foreach($module['sub_modules'] as $submodule ){ 
										if(in_array($submodule['id'],$access_submodule)){
											if($submodule['controller_name'] != $current_sub_module){
											 $sub_icon='<i class="fa fa-circle-o"></i>';
          									 if($submodule['icon']!=""){
           										$sub_icon=$submodule['icon'];
          									 }
										?>
										<li>
											<a href="<?php  echo $this->Url->build(["controller" =>$submodule['controller_name'] ,"action" => "index"]); ?>"><?php echo $sub_icon. $submodule['name'] ?></a>
			                        	</li>
							<?php
										}
									}
								}
							}
						}
						?>
                    </ul>
                  </ul>
                </div>
              </div>
                </div>
                   
              
                </div>
           
                </div>
               </div>
               </div> 
   </div>             
</div>



 <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">

	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-6">
				<div class="row">
                            <?php
									if (array_key_exists ( "delete", $module_pages )) :
									$page_id = $module_pages ["delete"];
										foreach ( $user_permission as $permission ) :
											if ($permission ['page_id'] == $page_id) :
										?>
                                        <?= $this->Form->create(null, ['url' => ['controller' => 'modules', 'action' => 'bulkAction']]); ?>
                                        <?= $this->Form->hidden('selected_content'); ?>
                                      	<div class="col-md-6">
                                            <?php echo $this->Form->input('bulk_action', array('label' => false, 'options' => $bulk_actions, 'empty' => __('Bulk Action'), 'required' => true, 'class' => 'form-control')); ?>
                                        </div>

							      <div class="col-md-6">
                                            <?= $this->Form->button(__('Apply'), ['id' => 'bulk_action_apply', 'class' => 'btn btn-success btn-flat'])?>
                                        </div>
                                        <?= $this->Form->end(); ?>
                                        <?php
																															break;
																														
																														
                                    endif;
																													endforeach
																													;
																												
																												
                            endif;
																												?>
                        
               </div>
               <div class="clearfix">&nbsp;</div>
                 <div class="row">
                 <div class="col-md-6 ">
                 <div class="row">
                 
               <?= $this->Form->create(null, array('type' => 'get','id'=>'limitForm')); ?>
                 <div class="col-md-2"><strong>Show</strong></div>
                 <div class="col-md-4"><select name="page_limit"  class="form-control input-sm"  onchange="this.form.submit()">
                 <option value="10" <?php echo $page_limit=="10"?'selected="selected"':''  ?>> 10</option>
                 <option value="25" <?php echo $page_limit=="25"?'selected="selected"':''  ?>>25</option>
                 <option value="50" <?php echo $page_limit=="50"?'selected="selected"':''  ?>>50</option>
                 <option value="100" <?php echo $page_limit=="100"?'selected="selected"':''  ?>>100</option>
                 </select>
                 </div>
             <?= $this->Form->end(); ?>
                 </div>
                   </div>                 
                 </div>
				</div>
				<!-- /col-md-6 -->
				<div class="col-md-6">
				
						<div class="row">
                        
                        <div class="col-md-12">
                  
                         	<div class="row">
                        
                        <div class="col-md-8 pull-right">
                        <?= $this->Form->create(null, array('type' => 'get')); ?>

                       <div class="box-tools">
									<div class="input-group input-group-sm">

                            <?=$this->Form->input ( '', [ 'placeholder' => __ ( 'SEARCH' ),'class' => 'form-control','type' => 'text','name' => 'search','value' => $searchText,'id' => 'search' ] );?>

                           <div class="input-group-btn">
                                    <?=$this->Form->submit ( __ ( 'SEARCH_MODULE' ), [ 'class' => 'btn btn-success btn-flat' ] );?>
                                </div>
									</div>
								</div>
                        </div>
                        </div>
                        
                        <?= $this->Form->end(); ?>
                    </div>
							<div class="col-md-12">				
					        &nbsp;
						</div>
						
					<!-- /row -->
				</div>
			</div>
		</div>
	</div>
</div>
          
  </div>
            
            <!-- /.box-header -->
            <div class="box-body table-responsive ">
              <table class="table table-striped table-bordered table-hover">
               
                                <thead>
                                <tr>
                                    <th>
                                         <div> <!-- <div class="checkbox"> -->
                                            <input type="checkbox"  id="ContentSelect">
                                            <label class="image-checkbox-label" for="ContentSelect"></label>
                                        </div>
                                    </th>
                                    <th class="sorting_asc"><?= $this->Paginator->sort('Modules.id', ['value' => __('MODULE_ID')]) ?></th>
                                    <th><?= $this->Paginator->sort('Modules.name', ['value' => __('MODULE_NAME')]) ?></th>
                                    <th><?= $this->Paginator->sort('Modules.created_on', ['value' => __('CREATED_ON')]) ?></th>
                                    <th><?= $this->Paginator->sort('Modules.modified_on', ['value' => __('MODIFIED_ON')]) ?></th>
                                    <th class="text-right"><?=  __('Action') ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $count = 1;
                                foreach ($modules as $module): ?>
                                    <tr>
                                        <td>
                                            <div> <!-- <div class="checkbox"> -->
                                                <input type="checkbox" 
                                                       id="content_<?= $module->id ?>">
                                                <label class="image-checkbox-label"
                                                       for="content_<?= $module->id ?>"></label>
                                            </div>
                                        </td>

                                        <td><?= $module->id ?></td>
                                        <td><?= $module->name ?></td>
                                        <td><?= $module->created_on ?></td>
                                        <td><?= $module->modified_on ?></td>
                                        <td class=" text-right">
                                          
                                          <div class="btn-group">
              
                  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-list"></i> <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li>
                     <?php
                                                    if (array_key_exists("edit", $module_pages)):
                                                        $page_id = $module_pages["edit"];
                                                        foreach ($user_permission as $permission):
                                                            if ($permission['page_id'] == $page_id):?>
                                                                <a href="   <?php echo $this->Url->build(['action' => 'edit', $module->id]) ?>"><i class="fa fa-pencil"></i><?php echo __('EDIT') ?>
                                                                </a>
                                                                <?php
                                                                break;
                                                            endif;
                                                        endforeach;
                                                    endif;
                                                    ?>
                    </li>
     
                    <li>  <?php
                                                    if (array_key_exists("delete", $module_pages)):
                                                        $page_id = $module_pages["delete"];
                                                        foreach ($user_permission as $permission):
                                                            if ($permission['page_id'] == $page_id):?>
                                                                       
                                                                        <?php echo $this->Form->postLink(' <i class="fa fa-trash-o"></i>'.__('DELETE'), ['action' => 'delete', $module->id], ['confirm' => __('Are you sure you want to delete {0}?', $module->name),'escape'=>false]) ?>
                                                                    
                                                                <?php
                                                                break;
                                                            endif;
                                                        endforeach;
                                                    endif;
                                                    ?></li>
                                            
               
                  </ul>
                </div>
                                             
                                         
                                        </td>
                                    </tr>

                                    <?php
                                    $count++;
                                endforeach; ?>
                                </tbody>
                            </table>
                            
                            
            </div>
            <!-- /.box-body -->
            <?php
            //debug($this->Paginator->params());
            if($this->Paginator->params()['nextPage']){
            $start_limit=(($this->Paginator->params()['page']* $this->Paginator->params()['current'])-$this->Paginator->params()['perPage'])+1;
            $end_limit=$this->Paginator->params()['page']* $this->Paginator->params()['current'];
            }
            else{
            if($this->Paginator->params()['count']!=0){
            $start_limit=($this->Paginator->params()['count']-$this->Paginator->params()['current'])+1;
            }
            else{
            $start_limit=0;
            }
            $end_limit=$this->Paginator->params()['count'];
            }
            ?>
              <div class="box-footer clearfix">
               <div class="row">
                            <div class="col-md-6"><p style="padding-top:20px;"><?php echo 'Showing '.  $start_limit .' to '. $end_limit. ' of ' . $this->Paginator->params()['count']. ' entries';?></p></div>
                            <div class="col-md-6">

								<div class="paginator pull-right">
						        <ul class="pagination ">
						            <?= $this->Paginator->prev('< ' . __('previous')) ?>
						            <?= $this->Paginator->numbers() ?>
						            <?= $this->Paginator->next(__('next') . ' >') ?>
						        </ul>
						      
						    </div>
													
					          </div>
					          
					         </div> 
						</div>
            
          </div>
          <!-- /.box -->
          

      </div>
            
          
               
          
        </div>
    </div>


<script>

    $(document).ready(function () {
        $(document).on('click', '.edit', function () {
            var cid = $(this).attr('id');
            window.location = '<?php echo $this->Url->build('/modules/edit/');?>' + cid;
            return false;
        });

        $("#bulk_action_apply").click(function (e) {
            var selectedContent = $("input[name='selected_content']").val();
            if (selectedContent == null || selectedContent == "") {
                e.preventDefault();
                $('#status-area').flash_message({
                    text: 'Select atleast one item in the list!',
                    how: 'append'
                });
            }
        });
        
        (function ($) {
            $.fn.flash_message = function (options) {

                options = $.extend({
                    text: 'Done',
                    time: 2000,
                    how: 'before',
                    class_name: ''
                }, options);

                return $(this).each(function () {
                    if ($(this).parent().find('.flash_message').get(0))
                        return;

                    var message = $('<span />', {
                        'class': 'flash_message ' + options.class_name,
                        text: options.text
                    }).hide().fadeIn('fast');

                    $(this)[options.how](message);

                    message.delay(options.time).fadeOut('normal', function () {
                        $(this).remove();
                    });

                });
            };
        })(jQuery);    
    });
</script>

<style type="text/css">
    #status-area .flash_message {
        padding: 5px;
        color: red;
    }
    .term a{
        color: red !important;
    }
</style>
