<?php

include_once ('HREBase.php');
include_once ('StructDerectory.php');
include_once ('Frame.php');

namespace Components;

class FrameSets extends HREBase  {
    
    public $Frames = array();
    public $IsBase = null;
    
    public $BaseFileID = null;
    public $BaseFileType = null;
            
    function __construct($BaseFileID) {
        
        parent::__construct(StructDerectory::FrameSets);
        
        $this->BaseFileID = $BaseFileID;
        $this->BaseFileType = FileType::Video;
    }
    
    public function CreateFrame() {
        
        $Frame = new Frame();
        
        $FrameCount = count($this->Frames);
        
        $Frame->ID = "HREF" . $FrameCount;
        $Frame->FrameSetID = $this->ID;
        $Frame->BaseFileID = $this->BaseFileID;
        $Frame->BaseFileType = FileType::Video;
        $Frame->FrameNumber = $FrameCount;
        $Frame->FrameTime = $FrameCount * $this->FPS_GAP;
        
        array_push($this->Frames, $Frame);
        
        return $Frame;        
    }
}

class ChildFrameSets extends HREBase  {
    
    public $Frames = array();
    public $IsBase = null;
    
    public $BaseFileID = null;
    public $BaseFileType = null;
            
    function __construct($BaseFileID) {
        
        parent::__construct(StructDerectory::ChildFrameSets);
        
        $this->BaseFileID = $BaseFileID;
        $this->BaseFileType = FileType::Video;
    }
    
    public function CreateFrame() {
        
        $Frame = new Frame();
        
        $FrameCount = count($this->Frames);
        
        $Frame->ID = "HREF" . $FrameCount;
        $Frame->FrameSetID = $this->ID;
        $Frame->BaseFileID = $this->BaseFileID;
        $Frame->BaseFileType = FileType::Image;
        $Frame->FrameNumber = $FrameCount;
        $Frame->FrameTime = $FrameCount * $this->FPS_GAP;
        
        array_push($this->Frames, $Frame);
        
        return $Frame;        
    }
}
