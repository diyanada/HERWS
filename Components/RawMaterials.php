<?php
namespace Components;

require_once ( dirname(__FILE__) . '/HREBase.php');
require_once ( dirname(__FILE__) . '/StructDerectory.php');

class RawMaterials extends HREBase  {
    
    public $File = null;
    public $AudioFile = null;
    public $Duration = null;
    public $TempFile = null;
    public $Height = null;
    public $Width = null;
            
    function __construct() {
        
        parent::__construct(StructDerectory::RawMaterials);
        
        $this->File = "Video.mp4";
        $this->AudioFile = "Audio.mp3";
    }


}
