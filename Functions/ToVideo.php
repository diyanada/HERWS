<?php

date_default_timezone_set('Europe/London');

require_once ( dirname(__FILE__) . '/../Components/RawMaterials.php');
require_once ( dirname(__FILE__) . '/../Components/StructDerectory.php');
require_once ( dirname(__FILE__) . '/../Core/Variable.php');
require_once ( dirname(__FILE__) . '/../Core/FFmpgeEngine.php');

use Components\RawMaterials;
use Components\StructDerectory;
use Components\Temp;
use Core\Variable;
use Core\FFmpgeEngine;

try {
    
    $Variable = new Variable();
    
    $FileName = $Variable->ReadMandatory("FileName");
    $Duration = $Variable->ReadMandatory("Duration");
    $Height = $Variable->ReadMandatory("Height");
    $Width = $Variable->ReadMandatory("Width");
    
    $RawMaterials = new RawMaterials();  
    
    $RawMaterials->TempFile = $FileName;
    $RawMaterials->Duration = $Duration;
    $RawMaterials->Height = $Height;
    $RawMaterials->Width = $Width;
    
    $Directory = $RawMaterials->getFileManipulator()->SetFile($RawMaterials->ID);
    $RawMaterials->getFileManipulator()->CreateDirectory($Directory);
    
    $Sourse = $RawMaterials->getFileManipulator()->ReadFile($FileName, StructDerectory::Temp, Temp::Video);
    $Destination = $RawMaterials->getFileManipulator()->SetFile($RawMaterials->File, null, $RawMaterials->ID);    
    $RawMaterials->getFileManipulator()->CopyFile($Sourse, $Destination);
    
    $DestinationMp3 = $RawMaterials->getFileManipulator()->SetFile($RawMaterials->AudioFile, null, $RawMaterials->ID); 
    
    $FFmpgeEngine = new FFmpgeEngine();
    $FFmpgeEngine->setInputFile($Sourse);
    $FFmpgeEngine->setOutputFile($DestinationMp3);
    $FFmpgeEngine->start();
    
    $RawMaterials->getJsonManipulator()->SaveJsonFile($RawMaterials);
    
    echo json_encode($RawMaterials, JSON_PRETTY_PRINT); 
} 
catch (Exception $Ex) {
    
    if(isset($RawMaterials)){
        
        $RawMaterials->RemoveID();
    }
    
    $Error = array("Code" => $Ex->getCode(), "Message" => $Ex->getMessage());
    
    $ErrorDetails = array("Error Details" => $Error);
    
    die(json_encode($ErrorDetails, JSON_PRETTY_PRINT));  
}
 finally {
    unset($Variable);
    unset($RawMaterials);
    
    exit();
}
