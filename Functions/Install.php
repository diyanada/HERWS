<?php

require_once ( dirname(__FILE__) . '/../Components/StructDerectory.php');
require_once ( dirname(__FILE__) . '/../Core/JsonManipulatorS3.php');

use Core\JsonManipulatorS3;
use Components\StructDerectory;

try {
    
    $JsonManipulator = new JsonManipulatorS3(StructDerectory::ChildFrameSets);    
    $JsonManipulator->SaveGuideFile(array());
    
    $JsonManipulator->setStructDerectory(StructDerectory::FrameSets);
    $JsonManipulator->SaveGuideFile(array());
    
    $JsonManipulator->setStructDerectory(StructDerectory::RawMaterials);
    $JsonManipulator->SaveGuideFile(array());
    
    die(json_encode(array("Status" => "Complite") , JSON_PRETTY_PRINT)); 
    
} catch (Exception $Ex) {
    
    $Error->Code = $Ex->getCode();
    $Error->Message = $Ex->getMessage();
    $ErrorDetails = array("Error Details" => $Error);
    
    die(json_encode($ErrorDetails, JSON_PRETTY_PRINT));  
}
