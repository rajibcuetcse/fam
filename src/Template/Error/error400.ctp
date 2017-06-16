
<?php
use Cake\Core\Configure;

if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.ctp');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?= Debugger::dump($error->params) ?>
<?php endif; ?>
<?= $this->element('auto_table_warning') ?>
<?php
    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;
?>

<div class="error-page">
        <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>

        <div class="error-content">
			<h1>Oops!</h1>
			<h3>This is awkward.</h3>
			
			<h4>We encountered a 404 Not Found error.</h4>
			
			<h4>You are looking for something that doesn't exist or may have moved. Check out one of the links on this page or head back to <a href="<?php echo $this->Url->build('/dashboard'); ?>">Home.</a></h4>
        </div>
    </div>
