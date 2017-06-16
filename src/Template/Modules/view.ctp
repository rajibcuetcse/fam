<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Module'), ['action' => 'edit', $module->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Module'), ['action' => 'delete', $module->id], ['confirm' => __('Are you sure you want to delete # {0}?', $module->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Modules'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Module'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="modules view large-9 medium-8 columns content">
    <h3><?= h($module->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Module Name') ?></th>
            <td><?= h($module->module_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($module->id) ?></td>
        </tr>
    </table>
</div>
