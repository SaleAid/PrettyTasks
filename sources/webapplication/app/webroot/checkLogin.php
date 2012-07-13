<?php
error_reporting(0);
ini_set('session.name', 'PrettyTasks');
session_start();
session_name('PrettyTasks');
echo (int)(isset($_SESSION['Auth']['User']['id']) && ($_SESSION['Auth']['User']['id']));