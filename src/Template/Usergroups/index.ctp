<?= $this->element('user_management_nav', array('title' => __('User Group Management'), 'permissions' => $user_permission,
    'showNavigationButtons' => true)); ?>

<?php echo $this->Html->script('bulk_select.js'); ?>

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
                                         <?= $this->Form->create(null, ['url' => ['controller' => 'Usergroups', 'action' => 'bulkAction']]); ?>
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
                                    <?=$this->Form->submit ( __ ( 'User Group Search' ), [ 'class' => 'btn btn-success btn-flat' ] );?>
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
                                    <th>
                                        <?= $this->Paginator->sort('group_name') ?>
                                    </th>

                                    <th>
                                        <?= $this->Paginator->sort('created_on') ?>
                                    </th>
                                   
                                    <th class="text-right"><?=  __('Action') ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($usergroups as $usergroup): ?>
                                    <tr>
                                        <td>
                                            <div> <!-- <div class="checkbox"> -->
                                                <input type="checkbox" 
                                                         id="content_<?= $usergroup->id ?>">
                                                <label class="image-checkbox-label"
                                                       for="content_<?= $usergroup->id ?>"></label>
                                            </div>
                                        </td>

                                        <td><?= h($usergroup->group_name) ?></td>
                                        <td> <?= h($usergroup->created_on) ?></td>

                                    
                                        <td class="text-right">
                                          
                                          <div class="btn-group">
              
                  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-list"></i> <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                  
                  <?php
                                                    $added = [];
                                                    foreach ($user_permission as $permission) {

                                                        if ($permission['page_id'] == $page_list['edit'] && !in_array($page_list['edit'], $added)) {
                                                            array_push($added, $page_list['edit']); ?>
                                                            <li>
                                                                
                                                                <?= $this->Html->link('<i class="fa fa-pencil"></i>'.__('Edit'), '/usergroups/edit/' . $usergroup->id,array('escape'=>false)) ?>
                                                            </li>
                                                            <?php
                                                        } elseif ($permission['page_id'] == $page_list['delete'] && !in_array($page_list['delete'], $added)) {
                                                            array_push($added, $page_list['delete']); ?>
                                                           <li>
                                                          
                                                                <?= $this->Form->postLink(' <i class="fa fa-trash-o"></i>'.__('Delete'), ['action' => 'delete', $usergroup->id], ['confirm' => __('Are you sure you want to delete {0}?', $usergroup->group_name),'escape'=>false]) ?>
                                                            </li>
                                                            <?php
                                                        }
                                                    } ?>
                
                                            
               
                  </ul>
                </div>
                                             
                                         
                                        </td>
                                    </tr>

                                    <?php
                             
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
    });
</script>