<?php

namespace Core;

require_once ( dirname(__FILE__) . '/../Components/StructDerectory.php');
require_once ( dirname(__FILE__) . '/Manipulator.php');

use Components\StructDerectory;
use Components\Temp;
use Exception;

class JsonManipulator extends Manipulator {
    
    function __construct($StructDerectory) {
        
        parent::__construct($StructDerectory);
    }    
    //---------------------Private Functions
    
    protected function ReadFile($FileName, $Derectory){
        
        $FileLocation = $this->DataDirectory . "/" . $Derectory . "/" .$FileName;
        
        if (!file_exists($FileLocation)) {

            throw new Exception("The file does not exist. Unable to read file.", "2010");
        }

        $File = file_get_contents($FileLocation);
        return json_decode($File, true);  
    }
    
    protected function SaveFile($Json, $FileName, $Derectory) {
        
        $FileLocation = $this->DataDirectory . "/" . $Derectory . "/" .$FileName;
        
        $dirname = dirname($FileLocation);
        if (!is_dir($dirname))
        {
            mkdir($dirname, 0755, true);
        }
        
        if (!$File = fopen($FileLocation, "w")){

            throw new \Exception("Unable to create file.", "2011");
        }
        fwrite($File, json_encode($Json));
        fclose($File);
    }
    
    private function SortHand() {
        
        if ($this->StructDerectory == StructDerectory::ChildFrameSets) {
            
            return "HRECFS";
        }
        else if ($this->StructDerectory == StructDerectory::FrameSets) {
            
            return "HREFS";
        }
        else if ($this->StructDerectory == StructDerectory::RawMaterials) {
            
            return "HRERM";
        }
        else if ($this->StructDerectory == StructDerectory::FinalOutputs) {
            
            return "HREFO";
        }
    }
    
    //---------------------Public Functions

    public function ReadGuideFile() {
        
        return $this->ReadFile($this->StructDerectory . ".json", $this->StructDerectory);
    }
    
    public function SaveGuideFile($Json) {
        
        return $this->SaveFile($Json, $this->StructDerectory . ".json", $this->StructDerectory);
    }
    
    public function NewGuideID() {
        
        $GuideJson = $this->ReadGuideFile();       
        
        $ID = $this->SortHand() . (count($GuideJson) + 1);
        
        if($GuideJson == ""){
            $GuideJson = array();
        }
        
        array_push($GuideJson, $ID);
        
        $this->SaveGuideFile($GuideJson);
        
        return $ID;
    }
    
    public function RemoveID($ID) {
        
        $GuideJson = $this->ReadGuideFile();       
        
        if (in_array($ID, $GuideJson)) 
        {
            unset($GuideJson[array_search($ID,$GuideJson)]);
        }
        
        $this->SaveGuideFile($GuideJson);
        
        return $ID;
    }
    
    public function ReadJsonFile($ID) {
        
        return $this->ReadFile($ID . ".json", $this->StructDerectory . "/" . $ID);
    }
    
    public function ReadOtherJsonFile($ID, $StructDerectory) {
        
        return $this->ReadFile($ID . ".json", $StructDerectory . "/" . $ID);
    }
    
    public function ReadTempJsonFile($ID) {
        
        return $this->ReadFile($ID , StructDerectory::Temp . "/" . Temp::Json);
    }
    
    public function SaveJsonFile($Json) {       
        
        return $this->SaveFile($Json, $Json->ID . ".json", $this->StructDerectory . "/" . $Json->ID);
        
    }

    

}