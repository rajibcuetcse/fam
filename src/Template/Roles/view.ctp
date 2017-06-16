<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Role'), ['action' => 'edit', $role->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Role'), ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete # {0}?', $role->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Role Pages'), ['controller' => 'RolePages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role Page'), ['controller' => 'RolePages', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="roles view large-9 medium-8 columns content">
    <h3><?= h($role->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Title') ?></th>
            <td><?= h($role->title) ?></td>
        </tr>
        <tr>
            <th><?= __('Company') ?></th>
            <td><?= $role->has('company') ? $this->Html->link($role->company->name, ['controller' => 'Companies', 'action' => 'view', $role->company->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($role->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created On') ?></th>
            <td><?= h($role->created_on) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified On') ?></th>
            <td><?= h($role->modified_on) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $role->status ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Role Pages') ?></h4>
        <?php if (!empty($role->role_pages)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Role Id') ?></th>
                <th><?= __('Page Id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($role->role_pages as $rolePages): ?>
            <tr>
                <td><?= h($rolePages->id) ?></td>
                <td><?= h($rolePages->role_id) ?></td>
                <td><?= h($rolePages->page_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'RolePages', 'action' => 'view', $rolePages->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'RolePages', 'action' => 'edit', $rolePages->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'RolePages', 'action' => 'delete', $rolePages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rolePages->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
