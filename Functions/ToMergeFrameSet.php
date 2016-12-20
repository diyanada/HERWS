<?php

date_default_timezone_set('Europe/London');

require_once ( dirname(__FILE__) . '/../Components/FrameSet.php');
require_once ( dirname(__FILE__) . '/../Components/StructDerectory.php');
require_once ( dirname(__FILE__) . '/../Core/Variable.php');
require_once ( dirname(__FILE__) . '/../Core/MergeImage.php');


use Components\FrameSet;
use Components\StructDerectory;
use Core\Variable;
use Core\MergeImage;

try {
           
    $Variable = new Variable(); 
    
    $ChildFrameSet = $Variable->ReadMandatory("ChildFrameSet"); 
    $BaseFrameSet = $Variable->Read("BaseFrameSet"); 
    
    $FrameSet = new FrameSet(StructDerectory::FrameSets);
    
    $CFSJson = $FrameSet->getJsonManipulator()->ReadOtherJsonFile($ChildFrameSet, StructDerectory::ChildFrameSets);
    
    if($BaseFrameSet == null){
        
        $BaseFrameSet = $CFSJson["BaseFrameSet"];
    }
    
    $BFSJson = $FrameSet->getJsonManipulator()->ReadJsonFile($BaseFrameSet);
    
    $FrameSet->Height = $BFSJson["Height"];
    $FrameSet->Width = $BFSJson["Width"];
    $FrameSet->FrameCount = $BFSJson["FrameCount"];
    $FrameSet->AudioFile = $BFSJson["AudioFile"];
    
    $Directory = $FrameSet->getFileManipulator()->SetFile($FrameSet->ID);
    $FrameSet->getFileManipulator()->CreateDirectory($Directory);
    
    while ($FrameSet->FramePossible()) {
        
        $Frame = $FrameSet->CreateFrame();
        
        $BaseImage = $FrameSet->getFileManipulator()->ReadFile($Frame->ID . ".bmp", null, $BFSJson["ID"]);
        $ChildImage = $FrameSet->getFileManipulator()->ReadCildImage($Frame->ID . ".bmp", $CFSJson["ID"]);
        $Image = $FrameSet->getFileManipulator()->SetFile($Frame->ID . ".bmp", null, $FrameSet->ID); 
        
        $MergeImage = new MergeImage($BaseImage, $ChildImage, $Image);
        $MergeImage->start();
    }
    
    $Sourse = $FrameSet->getFileManipulator()->ReadFile($FrameSet->AudioFile, null, $BFSJson["ID"]);
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
    unset($ChildFrameSet);
    
    exit();
}