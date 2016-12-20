<?php

require_once ( dirname(__FILE__) . '/../Components/StructDerectory.php');
require_once ( dirname(__FILE__) . '/../Core/JsonManipulator.php');
require_once ( dirname(__FILE__) . '/../Core/FileManipulator.php');

use Core\JsonManipulator;
use Core\FileManipulator;
use Components\StructDerectory;
use Components\Temp;

try {
    
    $FileManipulator = new FileManipulator(StructDerectory::ChildFrameSets);
    
    $Directorys = array();
    
    array_push($Directorys, $FileManipulator->getDataDirectory() . StructDerectory::ChildFrameSets);
    array_push($Directorys, $FileManipulator->getDataDirectory() . StructDerectory::FrameSets);
    array_push($Directorys, $FileManipulator->getDataDirectory() . StructDerectory::RawMaterials);
    array_push($Directorys, $FileManipulator->getDataDirectory() . StructDerectory::FinalOutputs);
    array_push($Directorys, $FileManipulator->getDataDirectory() . StructDerectory::Temp);
    
    array_push($Directorys, $FileManipulator->getDataDirectory() . StructDerectory::Temp . "/" . Temp::Image);
    array_push($Directorys, $FileManipulator->getDataDirectory() . StructDerectory::Temp . "/" . Temp::Json);
    array_push($Directorys, $FileManipulator->getDataDirectory() . StructDerectory::Temp . "/" . Temp::Video);
    
    foreach ($Directorys as $Value) {
        
        $FileManipulator->CreateDirectory($Value);
    }
    
    $JsonManipulator = new JsonManipulator(StructDerectory::ChildFrameSets);  
    $JsonManipulator->SaveGuideFile(array());
    
    $JsonManipulator->setStructDerectory(StructDerectory::FrameSets);
    $JsonManipulator->SaveGuideFile(array());
    
    $JsonManipulator->setStructDerectory(StructDerectory::RawMaterials);
    $JsonManipulator->SaveGuideFile(array());
    
    $JsonManipulator->setStructDerectory(StructDerectory::FinalOutputs);
    $JsonManipulator->SaveGuideFile(array());    
    
    die(json_encode(array("Status" => "Complite") , JSON_PRETTY_PRINT)); 
    
} catch (Exception $Ex) {
    
    $Error = array("Code" => $Ex->getCode(), "Message" => $Ex->getMessage());
    
    $ErrorDetails = array("Error Details" => $Error);
    
    die(json_encode($ErrorDetails, JSON_PRETTY_PRINT));   
}
