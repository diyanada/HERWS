<?php

namespace Core;

class Manipulator {
    
    protected $DataDirectory = "D:/Project-Data/HRE/";
    protected $StructDerectory = null;
    
    function __construct($StructDerectory) {
        
        $this->StructDerectory = $StructDerectory;
    }
    
    function getDataDirectory() {
        return $this->DataDirectory;
    }

    function getStructDerectory() {
        return $this->StructDerectory;
    }

    function setStructDerectory($StructDerectory) {
        $this->StructDerectory = $StructDerectory;
    }


}
