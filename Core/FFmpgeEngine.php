<?php

namespace Core;

class FFmpgeEngine {
    private $Prams = "-i";
    private $SecondPrams = null;
    
    private $InputFile = null;
    private $OutputFile = null;
    
    private $CommndString = null;  
    
    private $FFmpgeFile = "C:/Tools/ffmpeg/bin/ffmpeg";

    function setPrams($Prams) {
        $this->Prams = $Prams;
    }

    function setSecondPrams($SecondPrams) {
        $this->SecondPrams = $SecondPrams;
    }

    function setInputFile($InputFile) {
        $this->InputFile = $InputFile;
    }

    function setOutputFile($OutputFile) {
        $this->OutputFile = $OutputFile;
    }
    function getCommndString() {
        return $this->CommndString;
    }
    
    private function Command() {
        
        $Command = $this->FFmpgeFile;
        
        $Command .= " " . $this->Prams;
        $Command .= " " . $this->InputFile;
        $Command .= " " . $this->SecondPrams;
        $Command .= " " . $this->OutputFile;
        
        $this->CommndString = $Command;
        
        return $Command;
    }
    
    public function _Exec() {	
	
        $Command = $this->Command();
        
        $this->execInBackground($Command);
    }
        
    private  function execInBackground($Command) { 
        
        if (substr(php_uname(), 0, 7) == "Windows"){ 
            pclose(popen("start /B ". $Command, "r"));  
        } 
        else { 
            exec($Command . " > /dev/null &");   
        } 
    }
}
