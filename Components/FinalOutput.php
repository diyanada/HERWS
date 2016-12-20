<?php

namespace Components;

require_once ( dirname(__FILE__) . '/HREBase.php');
require_once ( dirname(__FILE__) . '/StructDerectory.php');

class FinalOutput extends HREBase  {
    
    public $FrameSet = array();    
    public $Height = null;
    public $Width = null;
    public $Duration = null;  
            
    function __construct() {
        
        parent::__construct(StructDerectory::FinalOutputs);
    }       
}