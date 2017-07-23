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
                        <h3 class="box-title no-margin"><span class="glyphicon glyphicon-file"></span><?php echo __('ADD_TEAM'); ?></h3>
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
                            <?php //echo $this->Form->label('company.name',__('COMPANY_NAME'),['class' => 'required']);?>
<?php echo $this->Form->input('team.name', ['label' => ['class' => 'required','text' => __('TEAM_NAME') ], 'class' => 'form-control', 'required' => true, 'error' => ['Please fill out this field.' => __('ENTER_TEAM_NAME')]]); ?>
                        </div>   
                        <!-- /.form-group -->
                        <div class="form-group">
<?php echo $this->Form->input('team.age_category', ['label' => ['class' => 'required','text' => __('AGE_CATEGORY')],'empty' => __('SELECT_AGE_CATEORY'),'options' => json_decode(TEAM_AGE_CATEGORY),'class' => 'form-control required', 'required' => true, 'error' => ['Please fill out this field.' => __('ENTER_TEAM_AGE_CATEGORY')]]); ?>
                        </div>   
                        <!-- /.form-group -->
                        <div class="form-group">
<?php echo $this->Form->input('team.type', ['label' => ['class' => 'required','text' => __('TEAM_TYPE')],'empty' => __('SELECT_TEAM_TYPE'), 'options' => json_decode(TEAM_TYPES), 'class' => 'form-control required', 'required' => true, 'error' => ['Please fill out this field.' => __('ENTER_TEAM_TYPE')]]); ?>
                        </div>  
                        <!-- /.form-group -->
                        <div class="form-group">
<?php echo $this->Form->input('team.gender', ['label' => ['class' => 'required','text' => __('GENDER')],'empty' => __('SELECT_GENDER'),'options' => json_decode(GENDER), 'class' => 'form-control required', 'error' => __('ENTER_GENDER')]); ?>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
<?php echo $this->Form->input('team.cms_user_id', ['label' => ['class' => 'required','text' => __('ADMINISTRATOR')],'empty' => __('SELECT_ADMINITRATOR'), 'options' => $cmsUsers, 'required' => true, 'class' => 'form-control']); ?>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
<?php echo $this->Form->input('team.administrator_designation', ['label' => ['class' => 'required','text' => __('ADMIN_DESIGNATION')], 'class' => 'form-control required']); ?>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
<?php echo $this->Form->input('team.first_color', ['label' => ['class' => 'required','text' => __('FIRST_COLOR')], 'class' => 'form-control required']); ?>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
<?php echo $this->Form->input('team.second_color', ['label' => ['class' => 'required','text' => __('SECOND_COLOR')], 'class' => 'form-control required']); ?>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
<?php echo $this->Form->input('team.thrid_color', ['label' => ['class' => 'required','text' => __('THIRD_COLOR')], 'class' => 'form-control required']); ?>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
<?php echo $this->Form->input('team.no_of_players_in_squad', ['label' => ['class' => 'required','text' => __('NO_OF_PLAYERS_SQUAD')], 'class' => 'form-control required']); ?>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
<?php echo $this->Form->input('team.no_of_officials_in_squad', ['label' => ['class' => 'required','text' => __('NO_OF_OFFICIAL_SQUAD')], 'class' => 'form-control required']); ?>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
<?php echo $this->Form->input('team.head_coach_name', ['label' => ['class' => 'required','text' => __('HEAD_COACH_NAME')], 'class' => 'form-control required']); ?>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
<?php echo $this->Form->input('team.head_coach_nationality', ['label' => ['class' => 'required','text' => __('HEAD_COACH_NATIONALITY')], 'class' => 'form-control required']); ?>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
<?php echo $this->Form->input('team.team_manager_name', ['label' => ['class' => 'required','text' => __('TEAM_MANAGER')], 'class' => 'form-control required']); ?>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
<?php echo $this->Form->input('team.team_manager_nationality', ['label' => ['class' => 'required','text' => __('TEAM_MANAGER_NATIONALITY')], 'class' => 'form-control required']); ?>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <div class="hide"> 
                                <?php
                                echo $this->Form->input('team.created_on');
            echo $this->Form->input('team.modified_on');
            echo $this->Form->input('team.status',['default' => 1]);?>
                            </div>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary tab3Save']) ?>
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