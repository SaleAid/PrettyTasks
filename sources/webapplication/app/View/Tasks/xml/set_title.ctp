<?php
$xmlArray = array('Result' => $data);
$xmlObject = Xml::fromArray($xmlArray);
echo $xmlString = $xmlObject->asXML();

