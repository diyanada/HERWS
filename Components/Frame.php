<?php

include_once ('StructDerectory.php');

namespace Components;

class Frame {
    
    public $ID = null;
    public $FrameSetID = null;
    
    public $BaseFileID = null;
    public $BaseFileType = null;
    
    public $FrameNumber = 0;
    public $FrameTime = 0;
    
    public $Width = 0;
    public $Height = 0;
}

class ChildFrame extends Frame {
    
    public $x_axis = 0;
    public $y_axis = 0;
    public $Angle = 0;
    public $Opacity = 0;
}


