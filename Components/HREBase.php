<?php

namespace Components;

ini_set('max_execution_time', 3000);

require_once ( dirname(__FILE__) . '/../Core/JsonManipulator.php');
require_once ( dirname(__FILE__) . '/../Core/FileManipulator.php');

use Core\FileManipulator;
use Core\JsonManipulator;
    
class HREBase{

    public $ID = null;
    private $StructDerectory = null;
    private $JsonManipulator = null;
    private $FileManipulator = null; 
    private $FPS = 25;
            
    function __construct($StructDerectory) {

        $this->StructDerectory = $StructDerectory;

        $this->JsonManipulator = new JsonManipulator($StructDerectory);
        $this->FileManipulator = new FileManipulator($StructDerectory);
        
        $this->ID = $this->JsonManipulator->NewGuideID();
    }    
    
    function getStructDerectory() {
        
        return $this->StructDerectory;
    }
    
    function getJsonManipulator() {
        return $this->JsonManipulator;
    }

    function getFileManipulator() {
        return $this->FileManipulator;
    }
    
    function getFPSGap() {
        return (1 / $this->FPS);
    }

    function getFPS() {
        return $this->FPS;
    }

            
    public function RemoveID() {
        
        $this->JsonManipulator->RemoveID($this->ID);
    }


}

