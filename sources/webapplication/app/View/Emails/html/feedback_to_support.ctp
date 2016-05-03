<p>
Привет всем! У нас есть новый feedback.
</p>
<p>
От пользователя <?php echo $userAuth['full_name']; ?>, коротый зашел через <strong><?php echo $userAuth['provider']; ?></strong> 
</p>
[id] == <?php echo $userAuth['id']; ?><br />

=======================================<br />

Category: <?php echo $feedback['category']; ?> <br/>
Subject: <?php echo $feedback['subject']; ?> <br/>   
Message: <br /> <?php echo $feedback['message']; ?> <br/>

=======================================<br />
User accounts:<br />
<table border="1">
<tr>
<th>Provider</th>
<th>uid</th>
<th>full_name</th>
<th>email</th>
<th>master</th>
</tr>

<?php foreach($userInfo[0]['Account'] as $acc): ?>
<tr>
    <td><?php echo $acc['provider']; ?></td>
    <td><?php echo $acc['uid']; ?></td>
    <td><?php echo $acc['full_name']; ?></td>
    <td><?php echo $acc['email']; ?></td>
    <td><?php echo $acc['master']; ?></td>
</tr>
<?php endforeach; ?>
</table>

<p>
С уважением, команда <?php echo Configure::read('Site.name'); ?>
</p>