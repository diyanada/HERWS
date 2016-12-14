<?php

namespace Core;

require_once ( dirname(__FILE__) . '/../Components/StructDerectory.php');

class JsonManipulator {
    
    protected $DataDirectory = "D:/Project-Data/HRE/";

    protected $StructDerectory = null;
    
    function __construct($StructDerectory) {
        
        $this->StructDerectory = $StructDerectory;
    }
    
    function setStructDerectory($StructDerectory) {
        
        $this->StructDerectory = $StructDerectory;
    }
    
    function getDataDirectory() {
        
        return $this->DataDirectory;
    }
    
    //---------------------Private Functions
    
    protected function ReadFile($FileName, $Derectory){
        
        $FileLocation = $this->DataDirectory . "/" . $Derectory . "/" .$FileName;
        
        if (!file_exists($FileLocation)) {

            throw new \Exception("The file does not exist. Unable to save file.", "2010");
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
        
        if ($this->StructDerectory == \Components\StructDerectory::ChildFrameSets) {
            
            return "HRECFS";
        }
        else if ($this->StructDerectory == \Components\StructDerectory::FrameSets) {
            
            return "HREFS";
        }
        else if ($this->StructDerectory == \Components\StructDerectory::RawMaterials) {
            
            return "HRERM";
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
    
    public function ReadJsonFile($ID) {
        
        return $this->ReadFile($ID . ".json", $this->StructDerectory . "/" . $ID);
    }
    
    public function SaveJsonFile($Json) {       
        
        return $this->SaveFile($Json, $Json->ID . ".json", $this->StructDerectory . "/" . $Json->ID);
        
    }
    
    public function ExeLambda($Json, $Directory = null) {
        
        if($Directory == null){
            
            $this->SaveFile($Json, $Json->ID . ".json", $this->StructDerectory . "/ToLambda");
        }
        else{
            
            $this->SaveFile($Json, $Json->ID . ".json", $this->StructDerectory . "/ToLambda/" . $Directory);
        }
    }

    

}