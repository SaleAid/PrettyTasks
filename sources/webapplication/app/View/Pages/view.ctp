<?php $this->start ( 'toHead' );?>
    <?php echo $this->Html->css('pages.'.Configure::read('App.version')); ?>
<?php $this->end ();?>
<div id="page">
    <?php echo $content; ?>
</div>
