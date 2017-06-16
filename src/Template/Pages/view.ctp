<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Page'), ['action' => 'edit', $page->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Page'), ['action' => 'delete', $page->id], ['confirm' => __('Are you sure you want to delete # {0}?', $page->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Pages'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Page'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sub Modules'), ['controller' => 'SubModules', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sub Module'), ['controller' => 'SubModules', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="pages view large-9 medium-8 columns content">
    <h3><?= h($page->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Sub Module') ?></th>
            <td><?= $page->has('sub_module') ? $this->Html->link($page->sub_module->name, ['controller' => 'SubModules', 'action' => 'view', $page->sub_module->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($page->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($page->id) ?></td>
        </tr>
    </table>
</div>
