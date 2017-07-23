<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Team Availablity'), ['action' => 'edit', $teamAvailablity->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Team Availablity'), ['action' => 'delete', $teamAvailablity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $teamAvailablity->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Team Availablity'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Team Availablity'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Teams'), ['controller' => 'Teams', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Team'), ['controller' => 'Teams', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="teamAvailablity view large-9 medium-8 columns content">
    <h3><?= h($teamAvailablity->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Team') ?></th>
            <td><?= $teamAvailablity->has('team') ? $this->Html->link($teamAvailablity->team->name, ['controller' => 'Teams', 'action' => 'view', $teamAvailablity->team->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Date Range') ?></th>
            <td><?= h($teamAvailablity->date_range) ?></td>
        </tr>
        <tr>
            <th><?= __('Venue') ?></th>
            <td><?= h($teamAvailablity->venue) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($teamAvailablity->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Match Type') ?></th>
            <td><?= $this->Number->format($teamAvailablity->match_type) ?></td>
        </tr>
        <tr>
            <th><?= __('Locations') ?></th>
            <td><?= $this->Number->format($teamAvailablity->locations) ?></td>
        </tr>
        <tr>
            <th><?= __('Venue Capacity') ?></th>
            <td><?= $this->Number->format($teamAvailablity->venue_capacity) ?></td>
        </tr>
        <tr>
            <th><?= __('Venue Surface') ?></th>
            <td><?= $this->Number->format($teamAvailablity->venue_surface) ?></td>
        </tr>
        <tr>
            <th><?= __('Cost') ?></th>
            <td><?= $this->Number->format($teamAvailablity->cost) ?></td>
        </tr>
        <tr>
            <th><?= __('Refree Level') ?></th>
            <td><?= $this->Number->format($teamAvailablity->refree_level) ?></td>
        </tr>
        <tr>
            <th><?= __('Refree From') ?></th>
            <td><?= $this->Number->format($teamAvailablity->refree_from) ?></td>
        </tr>
        <tr>
            <th><?= __('Brodcast') ?></th>
            <td><?= $this->Number->format($teamAvailablity->brodcast) ?></td>
        </tr>
        <tr>
            <th><?= __('Marketing Rights') ?></th>
            <td><?= $this->Number->format($teamAvailablity->marketing_rights) ?></td>
        </tr>
        <tr>
            <th><?= __('Gate Receipts') ?></th>
            <td><?= $this->Number->format($teamAvailablity->gate_receipts) ?></td>
        </tr>
        <tr>
            <th><?= __('Created On') ?></th>
            <td><?= h($teamAvailablity->created_on) ?></td>
        </tr>
        <tr>
            <th><?= __('Updated On') ?></th>
            <td><?= h($teamAvailablity->updated_on) ?></td>
        </tr>
    </table>
</div>
