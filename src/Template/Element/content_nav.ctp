<section class="TabContentTitle1" id="HeaderPor101">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 bottom-gap-15px">
                <div class="common-title-block-1">
                    <div class="common-title-block-1-inner">
                        <!--                        <img src="images/dashbord_icon/access_controll.png" alt="image">-->


                        <?php
                        $icon = 'access_control.png';
                        switch ($submodule) {
                            case SubModuleConstants::USER_MANAGEMENT:
                                $icon = 'user.png';
                                break;
                            case SubModuleConstants::ROLE_MANAGEMENT:
                                $icon = 'role.png';
                                break;
                            case SubModuleConstants::USER_GROUP_MANAGEMENT:
                                $icon = 'user-group.png';
                                break;
                            case SubModuleConstants::USER_GROUP_AND_ROLE_ASSOCIATION:
                                $icon = 'user-group.png';
                                break;
                            case SubModuleConstants::ROLE_AND_PAGE_ASSOCIATION:
                                $icon = 'user.png';
                                break;
                        }

                        echo $this->Html->image('../images/dashbord_icon/' . $icon, array('alt' => 'image')); ?>
                        <h1><?= $title ?></h1>
                    </div>
                    <!-- / common-title-block-1-inner -->
                </div>
                <!-- / common-title-block-1 -->
            </div>
            <!-- / col-md-6 -->

            <div class="col-md-6 col-sm-6 text-right">
                <ul class="list-inline list-inline-custom1 bottom-gap-15px">
                    <?php
                    $added = [];
                    
//                    echo "<pre>";
//                    print_r($permissions);
//                    echo "<pre>";
//                    exit();
                    
                    foreach ($permissions as $permission) {
                        if ($permission['page_id'] == PagesConstants::UPLOAD_NEW_CONTENT && !in_array(PagesConstants::UPLOAD_NEW_CONTENT, $added) && $showNavigationButtons) {
                            array_push($added, PagesConstants::UPLOAD_NEW_CONTENT); ?>
                            <li>
                                <a href="<?php echo $this->Url->build(["action" => "add"]); ?>">
                                    <i class="fa fa-plus-circle"></i>
                                    <?= __('Add') ?>
                                </a>
                            </li>

                            <?php
                        } elseif ($permission['page_id'] == PagesConstants::VIEW_CONTENT && !in_array(PagesConstants::VIEW_CONTENT, $added) && $showNavigationButtons) {
                            array_push($added, PagesConstants::VIEW_CONTENT); ?>
                            <li>
                                <a href="<?php echo $this->Url->build(["action" => "index"]); ?>">
                                    <i class="fa fa-list"></i>
                                    <?= __('List') ?>
                                </a>
                            </li>
                            <?php
                        }                       
                    }
                    ?>
                </ul>

                <div class="btn-group custom-button1">
                    <a aria-expanded="false" data-toggle="dropdown" class="btn btn-link dropdown-toggle" href="#">
                        <?= __('Content Management'); ?>
                        <span class="caret"></span>
                    </a>
                    <ul role="menu" class="dropdown-menu">
                        <?php
                        $added = [];
                        foreach ($permissions as $permission) {
                        if ($permission['submodule_id'] == SubModuleConstants::CONTENT_MANAGEMENT && !in_array(SubModuleConstants::CONTENT_MANAGEMENT, $added)) {
                            array_push($added, SubModuleConstants::CONTENT_MANAGEMENT); ?>
                            <li>
                                <?= $this->Html->link(__('Content Management'), '/Contents') ?>
                            </li>


                    </ul>
                    <?php
                    }
                    } ?>
                </div>
            </div>
            <!-- / col-md-6 -->
        </div>
        <!-- / row -->
    </div>
    <!-- / container -->
</section><!-- / section -->


