<?php

namespace Core;

use Thread;

class FFmpgeEnginents{
    private $Prams = "-i";
    private $SecondPrams = null;
    
    private $InputFile = null;
    private $OutputFile = null;
    
    private $CommndString = null;  
    
    private $FFmpgeFile = "C:/Tools/ffmpeg/bin/ffmpeg";
    
    private $Threads = 128;
    
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
        
        $Command = $this->FFmpgeFile . " -threads " . $this->Threads;
        
        $Command .= " " . $this->Prams;
        $Command .= " " . $this->InputFile;
        $Command .= " " . $this->SecondPrams;
        $Command .= " " . $this->OutputFile;
        
        $this->CommndString = $Command;
        
        return $Command;
    }
    
    public function run() {	
	
        $Command = $this->Command();
        
        exec($Command); 
    }
}

class FFmpgeEngine extends Thread{
    private $Prams = "-i";
    private $SecondPrams = null;
    
    private $InputFile = null;
    private $OutputFile = null;
    
    private $CommndString = null;  
    
    private $FFmpgeFile = "C:/Tools/ffmpeg/bin/ffmpeg";
    
    private $Threads = 128;
    
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
        
        $Command = $this->FFmpgeFile . " -threads " . $this->Threads;
        
        $Command .= " " . $this->Prams;
        $Command .= " " . $this->InputFile;
        $Command .= " " . $this->SecondPrams;
        $Command .= " " . $this->OutputFile;
        
        $this->CommndString = $Command;
        
        return $Command;
    }
    
    public function run() {	
	
        $Command = $this->Command();
        
        exec($Command); 
    }
}
