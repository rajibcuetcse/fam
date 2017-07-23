<?php
echo $this->Html->script('jquery-1.11.2.js');
$menu_modules = unserialize($this->request->session()->read('modules'));
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">


                    <div class="col-md-6">
                        <h3 class="box-title no-margin"><span class="glyphicon glyphicon-file"></span><?php echo __('VIEW_TEAM'); ?></h3>
                    </div>

                    <div class="col-md-6">



                        <div class="row">

                            <div class="col-md-12 text-right">
                                <?php
                                if (array_key_exists("add", $module_pages)):
                                    $page_id = $module_pages["index"];
                                    foreach ($user_permission as $permission):
                                        if ($permission['page_id'] == $page_id):
                                            ?>

                                            <a href="<?php echo $this->Url->build('/teams/index/'); ?>"  class="btn btn-success btn-flat btn-grid">
                                                <i class="fa fa-list"></i>
            <?php echo __('LIST'); ?>
                                            </a>

                                            <?php
                                            break;
                                        endif;
                                    endforeach;
                                endif;
                                ?>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary"><?php echo __('TEAM_MANAGEMENT'); ?></button>
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <?php
                                        $access_submodule = array();
                                        foreach ($user_permission as $row) {
                                            if (!in_array($row['submodule_id'], $access_submodule))
                                                $access_submodule[] = $row['submodule_id'];
                                        }
                                        $current_module = array_values($current_module);
                                        $current_sub_module = $this->request->params['controller'];
                                        foreach ($menu_modules as $module) {
                                            if ($module["id"] == $current_module[0]) {
                                                foreach ($module['sub_modules'] as $submodule) {
                                                    if (in_array($submodule['id'], $access_submodule)) {
                                                        if (strtolower($submodule['controller_name']) != strtolower($current_sub_module)) {
                                                            $sub_icon = '<i class="fa fa-circle-o"></i>';
                                                            if ($submodule['icon'] != "") {
                                                                $sub_icon = $submodule['icon'];
                                                            }
                                                            ?>
                                                            <li>
                                                                <a href="<?php echo $this->Url->build(["controller" => $submodule['controller_name'], "action" => "index"]); ?>"><?php echo $sub_icon . $submodule['name'] ?></a>
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

<div class="box box-primary">
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
<?= $this->Form->create($team, ['id' => 'team_form']); ?>            
                <div class="nav-tabs-custom">

                    <div id="basic_info_div">
                        <div class="form-group">
                            <label><strong><?= __('TEAM_NAME') ?>:</strong></label>
                            <p><?= h($team->name) ?></p>
                        </div>   
                        <div class="form-group">
                            <label><strong><?= __('AGE_CATEGORY') ?>:</strong></label>
                            <p><?= h(json_decode(TEAM_AGE_CATEGORY)[$team->age_category]) ?></p>
                        </div>  
                        <div class="form-group">
                            <label><strong><?= __('TEAM_TYPE') ?>:</strong></label>
                            <p><?= h(json_decode(TEAM_TYPES)[$team->type]) ?></p>
                        </div>  
                        <div class="form-group">
                            <label><strong><?= __('GENDER') ?>:</strong></label>
                            <p><?= h(json_decode(GENDER)[$team->gender]) ?></p>
                        </div> 
                        <div class="form-group">
                            <label><strong><?= __('ADMINISTRATOR') ?>:</strong></label>
                            <p><?= h($team->cms_user->username) ?></p>
                        </div> 
                        <div class="form-group">
                            <label><strong><?= __('ADMIN_DESIGNATION') ?>:</strong></label>
                            <p><?= h($team->administrator_designation) ?></p>
                        </div> 
                        <div class="form-group">
                            <label><strong><?= __('FIRST_COLOR') ?>:</strong></label>
                            <p><?= h($team->first_color) ?></p>
                        </div> 
                        <div class="form-group">
                            <label><strong><?= __('SECOND_COLOR') ?>:</strong></label>
                            <p><?= h($team->second_color) ?></p>
                        </div> 
                        <div class="form-group">
                            <label><strong><?= __('THIRD_COLOR') ?>:</strong></label>
                            <p><?= h($team->thrid_color) ?></p>
                        </div> 
                        <div class="form-group">
                            <label><strong><?= __('NO_OF_PLAYERS_SQUAD') ?>:</strong></label>
                            <p><?= h($team->no_of_players_in_squad) ?></p>
                        </div> 
                        <div class="form-group">
                            <label><strong><?= __('NO_OF_OFFICIAL_SQUAD') ?>:</strong></label>
                            <p><?= h($team->no_of_officials_in_squad) ?></p>
                        </div> 
                        <div class="form-group">
                            <label><strong><?= __('HEAD_COACH_NAME') ?>:</strong></label>
                            <p><?= h($team->head_coach_name) ?></p>
                        </div> 
                        <div class="form-group">
                            <label><strong><?= __('HEAD_COACH_NATIONALITY') ?>:</strong></label>
                            <p><?= h($team->head_coach_nationality) ?></p>
                        </div> 
                        <div class="form-group">
                            <label><strong><?= __('TEAM_MANAGER') ?>:</strong></label>
                            <p><?= h($team->team_manager_name) ?></p>
                        </div> 
                        <div class="form-group">
                            <label><strong><?= __('TEAM_MANAGER_NATIONALITY') ?>:</strong></label>
                            <p><?= h($team->team_manager_nationality) ?></p>
                        </div>                       
                </div>

            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.box-body -->
<?= $this->Form->end() ?>
</div>
</div>