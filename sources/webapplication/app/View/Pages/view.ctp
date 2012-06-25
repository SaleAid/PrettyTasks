<?php $this->start ( 'toHead' );?>
    <?php echo $this->Html->css('pages.'.Configure::read('App.version')); ?>
<?php $this->end ();?>

<?php echo $page['content']; ?>

