<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Setting'), ['action' => 'edit', $setting->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Setting'), ['action' => 'delete', $setting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $setting->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Settings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Setting'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="settings view large-9 medium-8 columns content">
    <h3><?= h($setting->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Latest Version') ?></th>
            <td><?= h($setting->latest_version) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($setting->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Device Type') ?></th>
            <td><?= $this->Number->format($setting->device_type) ?></td>
        </tr>
        <tr>
            <th><?= __('Faq Latest Version') ?></th>
            <td><?= $this->Number->format($setting->faq_latest_version) ?></td>
        </tr>
        <tr>
            <th><?= __('Released Date') ?></th>
            <td><?= h($setting->released_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified On') ?></th>
            <td><?= h($setting->modified_on) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Terms Of Use Url') ?></h4>
        <?= $this->Text->autoParagraph(h($setting->terms_of_use_url)); ?>
    </div>
    <div class="row">
        <h4><?= __('Yg Youtube Url') ?></h4>
        <?= $this->Text->autoParagraph(h($setting->yg_youtube_url)); ?>
    </div>
    <div class="row">
        <h4><?= __('Yg Facebook Url') ?></h4>
        <?= $this->Text->autoParagraph(h($setting->yg_facebook_url)); ?>
    </div>
    <div class="row">
        <h4><?= __('Yg Twitter Url') ?></h4>
        <?= $this->Text->autoParagraph(h($setting->yg_twitter_url)); ?>
    </div>
</div>
