	<style>
	#sortable1, #sortable2 { list-style-type: none; margin: 0; padding: 0; zoom: 1; }
	#sortable1 li, #sortable2 li { margin: 0 5px 5px 5px; padding: 3px; width: 90%; }
	</style>
	

<ul id="test-list"> 
    <li id="listItem_1"> 
    <img src="arrows.png" class="handle" alt="move" /> 
      Item 1 with a link to <a href="http://www.google.co.uk/" rel="nofollow">Google</a> 
    </li> 
    <li id="listItem_2"> 
      <img src="arrow.png" class="handle" alt="move" /> 
      Item 2 
    </li> 
    <li id="listItem_3"> 
      <img src="arrow.png" class="handle" alt="move" /> 
      Item 3 
    </li> 
    <li id="listItem_4"> 
      <img src="arrow.png" class="handle" alt="move" /> 
      Item 4 
      <p>Perhaps you want to add a form in here?</p> 
      <p>Text:<br /><input type="text" /></p> 
      <p>And a textarea<br /><textarea></textarea></p> 
    </li> 
</ul> 
<label for="test-log"><strong>Resultant order of list</strong></label> 
<input type="text" size="70" id="test-log" />

<div class="demo">

<h3 class="docs">Specify which items are sortable:</h3>

<ul id="sortable1">
	<li class="ui-state-default">Item 1</li>
	<li class="ui-state-default ui-state-disabled">(I'm not sortable or a drop target)</li>
	<li class="ui-state-default ui-state-disabled">(I'm not sortable or a drop target)</li>
	<li class="ui-state-default">
        <?php echo $this->Form->input('username', array('label' =>false, 'class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block'))));?>
    </li>
</ul>

<h3 class="docs">Cancel sorting (but keep as drop targets):</h3>

<ul id="sortable2">

    <li class="ui-state-default">
        <?php echo $this->Form->input('username', array('label' =>false));?>
    </li>
	<li class="ui-state-default">Item 1</li>
	<li class="ui-state-default ui-state-disabled">(I'm not sortable)</li>
	<li class="ui-state-default ui-state-disabled">(I'm not sortable)</li>
     
	<li class="ui-state-default">Item 4</li>
    <li class="ui-state-default">
        <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
        <input class="ch" name="thename" value="XYZ" />
         
    </li>
</ul>

</div><!-- End demo -->



<div class="demo-description">
<p>
	Specify which items are eligible to sort by passing a jQuery selector into
	the <code>items</code> option. Items excluded from this option are not
	sortable, nor are they valid targets for sortable items.
</p>
<p>
	To only prevent sorting on certain items, pass a jQuery selector into the
	<code>cancel</code> option. Cancelled items remain valid sort targets for
	others.
    http://jquery.page2page.ru/index.php5/%D0%93%D1%80%D1%83%D0%BF%D0%BF%D0%B8%D1%80%D1%83%D0%B5%D0%BC%D1%8B%D0%B5_%D1%8D%D0%BB%D0%B5%D0%BC%D0%B5%D0%BD%D1%82%D1%8B
</p>
</div><!-- End demo-description -->