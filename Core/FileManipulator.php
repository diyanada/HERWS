<?php

namespace Core;

require_once ( dirname(__FILE__) . '/../Components/StructDerectory.php');
require_once ( dirname(__FILE__) . '/Manipulator.php');

use Exception;
use Components\StructDerectory;

class FileManipulator extends Manipulator {
    
    function __construct($StructDerectory) {
        
        parent::__construct($StructDerectory);
    }

    public function ReadFile($Name, $StructDerectory = null, $Type = null) { 
        
        if($StructDerectory == null){
            $StructDerectory = $this->StructDerectory;
        }
        
        if($Type == NULL){
            
            $File = $this->DataDirectory . $StructDerectory . "/" . $Name;
        }
        else{
            
            $File = $this->DataDirectory . $StructDerectory . "/" . $Type . "/" . $Name;
        }
        
        if (!file_exists($File)) {

            throw new Exception("The file does not exist.", "2010");
        }
        
        return $File;
    } 
    
    public function ReadCildImage($Name, $CFSID) { 
        
        
        $File = $this->DataDirectory . StructDerectory::ChildFrameSets . "/" . $CFSID . "/" . $Name;
        
        
        if (!file_exists($File)) {
            return null;
        }        
        else{
            return $File;        
        }
    } 
    
    public function SetFile($Name, $StructDerectory = null, $Type = null) { 
        
        if($StructDerectory == null){
            $StructDerectory = $this->StructDerectory;
        } 
        
        if($Type == NULL){
            $File = $this->DataDirectory . $StructDerectory . "/" . $Name;
        }
        else{
            $File = $this->DataDirectory . $StructDerectory . "/" . $Type . "/" . $Name;
        }
        
        return $File;
    }
    
    public function CreateDirectory($Path) {
        
        if (!file_exists($Path)) {
            mkdir($Path, 0777, true);
        }
    }
    
    public function CopyFile($Sourse, $Destination) {
        
        $Status = copy($Sourse, $Destination);
        
        if ($Status == false) {

            throw new Exception("Failed to copy file.", "2001");
        }
        
    }
}