<?php
    
    //Normal User config
    
    Configure::write('User.Normal.MaxCountTasks', 10000);
    Configure::write('User.Normal.MaxPerDay', 10);
    Configure::write('User.Normal.MaxNotes', 100);
    Configure::write('User.Normal.MaxTags', 20);
    Configure::write('User.Normal.MaxDays', 10);
    Configure::write('User.Normal.MaxTagsInEntity', 5);
    Configure::write('User.Normal.AllowHTTPS', false);
    Configure::write('User.Normal.AllowHTTPSLogin', true);
    Configure::write('User.Normal.AllowNotes', true);
    Configure::write('User.Normal.AllowTasks', true);
    Configure::write('User.Normal.AllowJournal', true);
    Configure::write('User.Normal.AllowCalendar', false);
    Configure::write('User.Normal.MaxAccounts', 5);
    Configure::write('User.Normal.AllowSync', true);
    Configure::write('User.Normal.AllowAPI', true);
    Configure::write('User.Normal.SyncPeriod', '1 Day');
    Configure::write('User.Normal.MaxClients', 2);    

?>