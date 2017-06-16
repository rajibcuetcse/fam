<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Sub Module'), ['action' => 'edit', $subModule->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Sub Module'), ['action' => 'delete', $subModule->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subModule->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sub Modules'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sub Module'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Modules'), ['controller' => 'Modules', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Module'), ['controller' => 'Modules', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pages'), ['controller' => 'Pages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Page'), ['controller' => 'Pages', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="subModules view large-9 medium-8 columns content">
    <h3><?= h($subModule->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Module') ?></th>
            <td><?= $subModule->has('module') ? $this->Html->link($subModule->module->id, ['controller' => 'Modules', 'action' => 'view', $subModule->module->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($subModule->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($subModule->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Pages') ?></h4>
        <?php if (!empty($subModule->pages)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Sub Module Id') ?></th>
                <th><?= __('Name') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($subModule->pages as $pages): ?>
            <tr>
                <td><?= h($pages->id) ?></td>
                <td><?= h($pages->sub_module_id) ?></td>
                <td><?= h($pages->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Pages', 'action' => 'view', $pages->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Pages', 'action' => 'edit', $pages->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Pages', 'action' => 'delete', $pages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pages->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
