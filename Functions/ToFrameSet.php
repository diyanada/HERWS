<?php

date_default_timezone_set('Europe/London');

require_once ( dirname(__FILE__) . '/../Components/FrameSet.php');
require_once ( dirname(__FILE__) . '/../Components/StructDerectory.php');
require_once ( dirname(__FILE__) . '/../Core/Variable.php');
require_once ( dirname(__FILE__) . '/../Core/FFmpgeEngine.php');

use Components\FrameSet;
use Components\StructDerectory;
use Core\Variable;
use Core\FFmpgeEnginents;

try {
           
    $Variable = new Variable(); 
    
    $RMID = $Variable->ReadMandatory("RawMaterialsID");  
    $FrameSet = new FrameSet();
    $RMJson = $FrameSet->getJsonManipulator()->ReadOtherJsonFile($RMID, StructDerectory::RawMaterials);
    
    $SourseVideo = $FrameSet->getFileManipulator()->ReadFile($RMJson["File"], StructDerectory::RawMaterials, $RMJson["ID"]);
    $DestinationFrame = $FrameSet->getFileManipulator()->SetFile("HREF%d.bmp", null, $FrameSet->ID); 
    
    $Directory = $FrameSet->getFileManipulator()->SetFile($FrameSet->ID);
    $FrameSet->getFileManipulator()->CreateDirectory($Directory);
    
    $FFmpgeEngine = new FFmpgeEnginents();
    $FFmpgeEngine->setInputFile($SourseVideo);
    $FFmpgeEngine->setOutputFile($DestinationFrame);
    $FFmpgeEngine->run();
    
    $Files = new FilesystemIterator($Directory, FilesystemIterator::SKIP_DOTS);
    $FileCount = iterator_count($Files);
    
    $FrameSet->Height = $RMJson["Height"];
    $FrameSet->Width = $RMJson["Width"];
    $FrameSet->FrameCount = $FileCount;
    $FrameSet->AudioFile = $RMJson["AudioFile"];
    
    while ($FrameSet->FramePossible()) {
        
        $FrameSet->CreateFrame();
    }
    
    $Sourse = $FrameSet->getFileManipulator()->ReadFile($FrameSet->AudioFile, StructDerectory::RawMaterials, $RMJson["ID"]);
    $Destination = $FrameSet->getFileManipulator()->SetFile($FrameSet->AudioFile, null, $FrameSet->ID);    
    $FrameSet->getFileManipulator()->CopyFile($Sourse, $Destination);        
    
    $FrameSet->getJsonManipulator()->SaveJsonFile($FrameSet);
    
    echo json_encode($FrameSet, JSON_PRETTY_PRINT); 
} 
catch (Exception $Ex) {
    
    if(isset($FrameSet)){
        
        $FrameSet->RemoveID();
    }
    
    $Error = array("Code" => $Ex->getCode(), "Message" => $Ex->getMessage());
    
    $ErrorDetails = array("Error Details" => $Error);
    
    die(json_encode($ErrorDetails, JSON_PRETTY_PRINT));  
}
finally {
    unset($Variable);
    unset($FrameSet);
    
    exit();
}