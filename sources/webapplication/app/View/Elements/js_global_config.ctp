<script type="text/javascript">

    var GLOBAL_CONFIG = {
        dp_regional: '<?php if (Configure::read('Config.langURL') == 'ru') {echo Configure::read('Config.langURL');} ?>',
        date: '<?php echo date("Y-m-d");?>',
        intervalCheckStatus: 60000,
        intervalCheckStatusError: 30000,
        timezone: '<?php echo CakeTime::serverOffset() / 3600; ?>'
    }

</script>