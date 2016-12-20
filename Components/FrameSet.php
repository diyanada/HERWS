<?php

namespace Components;

require_once ( dirname(__FILE__) . '/HREBase.php');
require_once ( dirname(__FILE__) . '/StructDerectory.php');
require_once ( dirname(__FILE__) . '/Frame.php');

class FrameSet extends HREBase  {
    
    public $Frames = array();
    public $IsBase = null;
    
    public $Height = null;
    public $Width = null;
    public $FrameCount = null;
    
    public $AudioFile = null;
            
    function __construct() {
        
        parent::__construct(StructDerectory::FrameSets);
        
        $this->IsBase = true;
    }
    
    public function FramePossible() {
        
        $FrameCount = count($this->Frames);
        
        return ($FrameCount  < $this->FrameCount);     
    }
    
    public function CreateFrame() {
        
        $Frame = new Frame();
        
        $FrameCount = count($this->Frames);
        
        $Frame->ID = "HREF" . ($FrameCount + 1);
        $Frame->FrameSetID = $this->ID;
        $Frame->FrameNumber = $FrameCount + 1;        
            
        array_push($this->Frames, array($Frame->ID => $Frame));

        return $Frame;                  
    }
}

class ChildFrameSet extends HREBase{
    
    public $Frames = array();
    public $IsBase = null;
    
    public $Height = null;
    public $Width = null;    
    public $FrameCount = null;
    public $BaseFrameSet = null;
            
    function __construct() {
        
        parent::__construct(StructDerectory::ChildFrameSets);
        
        $this->IsBase = false;
    }
    
    public function FramePossible($FrameNumber) {
        
        return ($FrameNumber  <= $this->FrameCount);     
    }
    
    public function CreateFrame($FrameNumber) {
        
        $Frame = new Frame();
        
        $Frame->ID = "HREF" . $FrameNumber;
        $Frame->FrameSetID = $this->ID;
        $Frame->FrameNumber = $FrameNumber;        
            
        array_push($this->Frames, array($Frame->ID => $Frame));

        return $Frame;      
    }
}
