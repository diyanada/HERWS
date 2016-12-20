<?php

date_default_timezone_set('Europe/London');

require_once ( dirname(__FILE__) . '/../Components/FinalOutput.php');
require_once ( dirname(__FILE__) . '/../Core/Variable.php');
require_once ( dirname(__FILE__) . '/../Core/FFmpgeEngine.php');

use Components\FinalOutput;
use Components\StructDerectory;
use Core\Variable;
use Core\FFmpgeEngine;

try {
           
    $Variable = new Variable(); 
    
    $FrameSetID = $Variable->ReadMandatory("FrameSet"); 
    
    $FinalOutput = new FinalOutput();
    
    $BFSJson = $FinalOutput->getJsonManipulator()->ReadOtherJsonFile($FrameSetID, StructDerectory::FrameSets);
    
    $SourceImages = $FinalOutput->getFileManipulator()->SetFile("HREF%d.bmp", StructDerectory::FrameSets, $BFSJson["ID"]); 
    $SourceMp3 = $FinalOutput->getFileManipulator()->ReadFile($BFSJson["AudioFile"] , StructDerectory::FrameSets, $BFSJson["ID"]); 
    $Destination = $FinalOutput->getFileManipulator()->SetFile($FinalOutput->ID . ".mp4", StructDerectory::FinalOutputs, $FinalOutput->ID); 
    
    $Directory = $FinalOutput->getFileManipulator()->SetFile($FinalOutput->ID);
    $FinalOutput->getFileManipulator()->CreateDirectory($Directory);
    
    $FFmpgeEngine = new FFmpgeEngine();
    $FFmpgeEngine->setInputFile($SourceMp3 . " -r 25 -i " . $SourceImages);
    $FFmpgeEngine->setSecondPrams("-c:a aac -c:v libx264");
    $FFmpgeEngine->setOutputFile($Destination);
    $FFmpgeEngine->start();
    
    echo $FFmpgeEngine->getCommndString();
    
    $FinalOutput->FrameSet = $BFSJson["ID"];
    $FinalOutput->Height = $BFSJson["Height"];
    $FinalOutput->Width = $BFSJson["Width"];
    $FinalOutput->Duration = $BFSJson["FrameCount"] * $FinalOutput->getFPSGap();
    
    $FinalOutput->getJsonManipulator()->SaveJsonFile($FinalOutput);
    
    echo json_encode($FinalOutput, JSON_PRETTY_PRINT);
} 
catch (Exception $Ex) {
    
    if(isset($ChildFrameSet)){
        
        $ChildFrameSet->RemoveID();
    }
    
    $Error = array("Code" => $Ex->getCode(), "Message" => $Ex->getMessage());
    
    $ErrorDetails = array("Error Details" => $Error);
    
    die(json_encode($ErrorDetails, JSON_PRETTY_PRINT)); 
}
finally {
    unset($Variable);
    unset($ChildFrameSet);
    
    exit();
}