<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Team Availablity'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Teams'), ['controller' => 'Teams', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Team'), ['controller' => 'Teams', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="teamAvailablity index large-9 medium-8 columns content">
    <h3><?= __('Team Availablity') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('team_id') ?></th>
                <th><?= $this->Paginator->sort('match_type') ?></th>
                <th><?= $this->Paginator->sort('locations') ?></th>
                <th><?= $this->Paginator->sort('date_range') ?></th>
                <th><?= $this->Paginator->sort('venue') ?></th>
                <th><?= $this->Paginator->sort('venue_capacity') ?></th>
                <th><?= $this->Paginator->sort('venue_surface') ?></th>
                <th><?= $this->Paginator->sort('cost') ?></th>
                <th><?= $this->Paginator->sort('refree_level') ?></th>
                <th><?= $this->Paginator->sort('refree_from') ?></th>
                <th><?= $this->Paginator->sort('brodcast') ?></th>
                <th><?= $this->Paginator->sort('marketing_rights') ?></th>
                <th><?= $this->Paginator->sort('gate_receipts') ?></th>
                <th><?= $this->Paginator->sort('created_on') ?></th>
                <th><?= $this->Paginator->sort('updated_on') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($teamAvailablity as $teamAvailablity): ?>
            <tr>
                <td><?= $this->Number->format($teamAvailablity->id) ?></td>
                <td><?= $teamAvailablity->has('team') ? $this->Html->link($teamAvailablity->team->name, ['controller' => 'Teams', 'action' => 'view', $teamAvailablity->team->id]) : '' ?></td>
                <td><?= $this->Number->format($teamAvailablity->match_type) ?></td>
                <td><?= $this->Number->format($teamAvailablity->locations) ?></td>
                <td><?= h($teamAvailablity->date_range) ?></td>
                <td><?= h($teamAvailablity->venue) ?></td>
                <td><?= $this->Number->format($teamAvailablity->venue_capacity) ?></td>
                <td><?= $this->Number->format($teamAvailablity->venue_surface) ?></td>
                <td><?= $this->Number->format($teamAvailablity->cost) ?></td>
                <td><?= $this->Number->format($teamAvailablity->refree_level) ?></td>
                <td><?= $this->Number->format($teamAvailablity->refree_from) ?></td>
                <td><?= $this->Number->format($teamAvailablity->brodcast) ?></td>
                <td><?= $this->Number->format($teamAvailablity->marketing_rights) ?></td>
                <td><?= $this->Number->format($teamAvailablity->gate_receipts) ?></td>
                <td><?= h($teamAvailablity->created_on) ?></td>
                <td><?= h($teamAvailablity->updated_on) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $teamAvailablity->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $teamAvailablity->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $teamAvailablity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $teamAvailablity->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
