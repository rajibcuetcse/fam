      <div class="box box-primary">
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><strong><?= __('Username:') ?></strong></label>
                <p><?= h($cmsuser->username) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('Language:') ?></strong></label>
                <p><?= h($cmsuser->language) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('Email:') ?></strong></label>
                <p><?= h($cmsuser->email) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('Profile Picture:') ?></strong></label>
                <p>
                    <?php
                        if(!empty($cmsuser['img_path'])){
	                ?>
                    <img src="<?php echo $this->request->webroot.$cmsuser['img_path'];?>" style="width:70px;height:50px;">
                    <?php
                    	} else{
                    ?>
                    <img src="<?php echo $this->request->webroot.'media/companies/default.jpg'?>" style="width:70px;height:50px;">
                    <?php
                    	}
                    ?>                                           
                </p>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
              <div class="form-group">
                <label><strong><?= __('Company:') ?></strong></label>
                 <p><?= h($cmsuser->company->name) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('Usergroup:') ?></strong></label>
                <p><?= empty($usergroup) ? __('N/A') : h($usergroup->group_name) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('Created On:') ?></strong></label>
                <p><?= h($cmsuser->created_on) ?></p>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label><strong><?= __('Status:') ?></strong></label>
                <p><?= $cmsuser->status ? __('ACTIVE') : __('INACTIVE'); ?></p>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
