<?php

require_once ( dirname(__FILE__) . '/../Components/StructDerectory.php');
require_once ( dirname(__FILE__) . '/../Components/RawMaterials.php');
require_once ( dirname(__FILE__) . '/../Core/JsonManipulatorS3.php');

use Core\JsonManipulatorS3;
use Components\StructDerectory;
use Components\RawMaterials;

try {
    
    $FileName = filter_input(INPUT_GET, "FileName");
    $Duration = filter_input(INPUT_GET, "Duration");
           
    if($FileName == null){
    
        throw new Exception("The required parameter was not provided.", "2404");
    }
    
    if (strpos($FileName, ".mp4") === false) {
        throw new Exception("The video must be mp4.", "2004");
    }
    
    if($Duration == null){
    
        throw new Exception("The required parameter was not provided.", "2404");
    }
    
    $RawMaterials = new RawMaterials();
    $RawMaterials->TempFile = $FileName;
    $RawMaterials->Duration = $Duration;
    
    $JsonManipulator = new JsonManipulatorS3(StructDerectory::RawMaterials);   
    
    $JsonManipulator->SaveJsonFile($RawMaterials);
    
    $JsonManipulator->ExeLambda($RawMaterials);
    
    die(json_encode($RawMaterials, JSON_PRETTY_PRINT)); 
} 
catch (Exception $Ex) {
    
    $Error->Code = $Ex->getCode();
    $Error->Message = $Ex->getMessage();
    
    $ErrorDetails = array("Error Details" => $Error);
    
    die(json_encode($ErrorDetails, JSON_PRETTY_PRINT));  
}
