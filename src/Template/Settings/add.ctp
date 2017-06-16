<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Settings'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="settings form large-9 medium-8 columns content">
    <?= $this->Form->create($setting) ?>
    <fieldset>
        <legend><?= __('Add Setting') ?></legend>
        <?php
            echo $this->Form->input('device_type');
            echo $this->Form->input('latest_version');
            echo $this->Form->input('terms_of_use_url');
            echo $this->Form->input('yg_youtube_url');
            echo $this->Form->input('yg_facebook_url');
            echo $this->Form->input('yg_twitter_url');
            echo $this->Form->input('released_date');
            echo $this->Form->input('modified_on');
            echo $this->Form->input('faq_latest_version');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
