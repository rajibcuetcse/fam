<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Usergroup'), ['action' => 'edit', $usergroup->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Usergroup'), ['action' => 'delete', $usergroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usergroup->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Usergroups'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Usergroup'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Companies'), ['controller' => 'Companies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Company'), ['controller' => 'Companies', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Usergroup Roles'), ['controller' => 'UsergroupRoles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Usergroup Role'), ['controller' => 'UsergroupRoles', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="usergroups view large-9 medium-8 columns content">
    <h3><?= h($usergroup->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Group Name') ?></th>
            <td><?= h($usergroup->group_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Company') ?></th>
            <td><?= $usergroup->has('company') ? $this->Html->link($usergroup->company->name, ['controller' => 'Companies', 'action' => 'view', $usergroup->company->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($usergroup->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created On') ?></th>
            <td><?= h($usergroup->created_on) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified On') ?></th>
            <td><?= h($usergroup->modified_on) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $usergroup->status ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Usergroup Roles') ?></h4>
        <?php if (!empty($usergroup->usergroup_roles)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Role Id') ?></th>
                <th><?= __('Usergroup Id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($usergroup->usergroup_roles as $usergroupRoles): ?>
            <tr>
                <td><?= h($usergroupRoles->id) ?></td>
                <td><?= h($usergroupRoles->role_id) ?></td>
                <td><?= h($usergroupRoles->usergroup_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'UsergroupRoles', 'action' => 'view', $usergroupRoles->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'UsergroupRoles', 'action' => 'edit', $usergroupRoles->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'UsergroupRoles', 'action' => 'delete', $usergroupRoles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usergroupRoles->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
