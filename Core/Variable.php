<?php

namespace Core;

use Exception;

class Variable {
    
    private $InputType = INPUT_GET;
    
    public function Read($Name){
        
        return filter_input($this->InputType, $Name);
    }
    
    private function Mandatory($Value, $Name){
        
        if($Value == null){

            throw new Exception("The required parameter was not provided. Parameter name - " . $Name . ".", "2404");
        }
        
        return $Value;
    }
    
    public function ReadMandatory($Name){
        
        $Value = $this->Read($Name);
        return $this->Mandatory($Value, $Name);
    }
}
