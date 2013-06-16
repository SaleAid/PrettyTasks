<script type="text/javascript">

    var GLOBAL_CONFIG = {
        dp_regional: '<?php if (Configure::read('Config.langURL') == 'ru') {echo Configure::read('Config.langURL');} ?>',
        date: '<?php echo date("Y-m-d");?>',
        intervalCheckStatus: 60000*5,
        intervalCheckStatusError: 30000,
        timezone: '<?php echo $timezoneOffset; ?>', 
        lang: '<?php echo Configure::read('Config.langURL'); ?>',
        onbeforeunloadMessage: '<?php echo __d('messages', 'В данный момент сайт сохраняет данные на сервере, уход со страницы прервет этот процесс, что приведет к потере данных. Подождите несколько секунд, после чего вы можете спокойно закрыть страницу.'); ?>',
        moveForbiddenMessage: '<?php echo __d('tasks', 'Перемещение запрещено') ;?>',
        moveCompletedForbiddenMessage: '<?php echo __d('tasks', 'Перемещение выполненых задач запрещено') ;?>',
        deleteAll: '<?php echo  __d('tasks', 'Are you sure you want to delete all tasks?') ;?>',
        yesterday: '<?php echo __d('tasks', 'Yesterday'); ?>',
        planned: '<?php echo __d('tasks', 'Планируемые'); ?>'
    };
    
</script>