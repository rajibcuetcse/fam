<div class="row">
<div class="col-md-12">
<div class="box box-primary">
<div class="box-body">
<div class="row">
	<div class="col-md-6">
		<h3 class="box-title no-margin"><span class="glyphicon glyphicon-wrench"></span>Site Settings</h3>
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
             <?= $this->Form->create($setting,array('enctype'=>'multipart/form-data')) ?>
              <div class="form-group">
            	<?php            		
            		echo $this->Form->input('title', array('class' => 'form-control required', 'placeholder' => __('Title')));
                ?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php echo $this->Form->input('meta_tag', array('class' => 'form-control required', 'placeholder' => __('Meta')));?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <?php 
                	echo $this->Form->input('previous_logo_path', array('type' => 'hidden','value'=>$setting['logo_path']));
                	echo $this->Form->input('logo_path', array('type' => 'file', 'label' => __('LOGO')));
                ?><br/>
                <?php
                    if(!empty($setting['logo_path'])){
                ?>
                    <img src="<?php echo $this->request->webroot.$setting['logo_path'];?>" style="width:70px;height:50px;">
                    <?php
                    	} else{
                    ?>
                    <img src="<?php echo $this->request->webroot.'images/logo/default_logo.png'?>" style="width:70px;height:40px;">
                <?php
                	}
                ?>
              </div>
              <!-- /.form-group -->
             <div class="form-group">
                <?php 
                	echo $this->Form->input('previous_favicon_path', array('type' => 'hidden','value'=>$setting['favicon_path']));
                	echo $this->Form->input('favicon_path', array('type' => 'file', 'label' => __('Favicon Icon')));
                ?><br/>
                <?php
                    if(!empty($setting['favicon_path'])){
                ?>
                    <img src="<?php echo $this->request->webroot.$setting['favicon_path'];?>" style="width:70px;height:50px;">
                    <?php
                    	} else{
                    ?>
                    <img src="<?php echo $this->request->webroot.'images/favicon/favicon.ico'?>" style="width:70px;height:50px;">
                <?php
                	}
                ?>
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
