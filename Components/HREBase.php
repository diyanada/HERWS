<?php

namespace Components;

require_once ( dirname(__FILE__) . '/../Core/JsonManipulatorS3.php');

use Core\JsonManipulatorS3;
    
class HREBase{

    public $ID = null;
    private $StructDerectory = null;
    protected $FPS_GAP = 0.04;
    
    function __construct($StructDerectory) {

        $this->StructDerectory = $StructDerectory;

        $JsonManipulator = new JsonManipulatorS3($StructDerectory);
        
        $this->ID = $JsonManipulator->NewGuideID();
    }

    function getStructDerectory() {
        
        return $this->StructDerectory;
    }


}

