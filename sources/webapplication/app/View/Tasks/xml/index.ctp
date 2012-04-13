<?php
$xmlArray = array('Tasks' => $arrTaskOnDays);
$xmlObject = Xml::fromArray($xmlArray);
echo $xmlString = $xmlObject->asXML();

