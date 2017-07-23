<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $teamAvailablity->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $teamAvailablity->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Team Availablity'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Teams'), ['controller' => 'Teams', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Team'), ['controller' => 'Teams', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="teamAvailablity form large-9 medium-8 columns content">
    <?= $this->Form->create($teamAvailablity) ?>
    <fieldset>
        <legend><?= __('Edit Team Availablity') ?></legend>
        <?php
            echo $this->Form->input('team_id', ['options' => $teams]);
            echo $this->Form->input('match_type');
            echo $this->Form->input('locations');
            echo $this->Form->input('date_range');
            echo $this->Form->input('venue');
            echo $this->Form->input('venue_capacity');
            echo $this->Form->input('venue_surface');
            echo $this->Form->input('cost');
            echo $this->Form->input('refree_level');
            echo $this->Form->input('refree_from');
            echo $this->Form->input('brodcast');
            echo $this->Form->input('marketing_rights');
            echo $this->Form->input('gate_receipts');
            echo $this->Form->input('created_on');
            echo $this->Form->input('updated_on');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
