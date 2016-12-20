<?php

date_default_timezone_set('Europe/London');

require_once ( dirname(__FILE__) . '/../Components/FrameSet.php');
require_once ( dirname(__FILE__) . '/../Components/StructDerectory.php');
require_once ( dirname(__FILE__) . '/../Core/Variable.php');
require_once ( dirname(__FILE__) . '/../Core/CreateImage.php');

use Components\ChildFrameSet;
use Components\StructDerectory;
use Components\Temp;
use Core\Variable;
use Core\CreateImage;

try {
           
    $Variable = new Variable(); 
    
    $Image = $Variable->ReadMandatory("Image"); 
    $Json = $Variable->ReadMandatory("Json"); 
    $BaseFrameSet = $Variable->ReadMandatory("BaseFrameSet");
    
    $ChildFrameSet = new ChildFrameSet();
    
    $FSJson = $ChildFrameSet->getJsonManipulator()->ReadOtherJsonFile($BaseFrameSet, StructDerectory::FrameSets);
    $JsonFile = $ChildFrameSet->getJsonManipulator()->ReadTempJsonFile($Json);
    $ImageFile = $ChildFrameSet->getFileManipulator()->ReadFile($Image, StructDerectory::Temp, Temp::Image);
    
    $ChildFrameSet->Height = $FSJson["Height"];
    $ChildFrameSet->Width = $FSJson["Width"];
    $ChildFrameSet->FrameCount = $FSJson["FrameCount"];
    $ChildFrameSet->BaseFrameSet = $FSJson["ID"];
    
    $Directory = $ChildFrameSet->getFileManipulator()->SetFile($ChildFrameSet->ID);
    $ChildFrameSet->getFileManipulator()->CreateDirectory($Directory);    
    
    $FrameNumber = 1;
    
    while ($ChildFrameSet->FramePossible($FrameNumber)) {
        
        if(!isset($JsonFile[($FrameNumber - 1)])){
            
            throw new Exception("Invalid Json!.", "2005");
        }
        
        $FrameJson = $JsonFile[($FrameNumber - 1)];
        
        $Height = round($FrameJson["Height"]);
        $Width = round($FrameJson["Width"]);
        $Opacity = round($FrameJson["Opacity"]);
        
        if(!($Height == 0 || $Width == 0 || $Opacity == 0)){
            
            
            $Frame = $ChildFrameSet->CreateFrame($FrameNumber);
            $DestinationImage = $ChildFrameSet->getFileManipulator()->SetFile($Frame->ID . ".bmp", null, $ChildFrameSet->ID);
            
            $CreateImage = new CreateImage($ImageFile, $ChildFrameSet->Height, $ChildFrameSet->Width);
            $CreateImage->setOverlayDetails($FrameJson, $DestinationImage);
            $CreateImage->start();
        }
        
        $FrameNumber++;
    }
    
    $ChildFrameSet->getJsonManipulator()->SaveJsonFile($ChildFrameSet);
    
    echo json_encode($ChildFrameSet, JSON_PRETTY_PRINT);
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