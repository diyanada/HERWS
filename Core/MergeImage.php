<?php

namespace Core;

use Thread;
use Imagick;

class MergeImage extends Thread{
    
    private $BaseImage = null;
    private $ChildImage= null;
    private $Image = null;
    
    function __construct($BaseImage, $ChildImage, $Image) {
        
        $this->BaseImage = $BaseImage;
        $this->ChildImage = $ChildImage;
        $this->Image = $Image;
    }
    
    public function run() {
        
        $BaseImage = new Imagick();
        $BaseImage->readImage($this->BaseImage); 
        
        if($this->ChildImage != null){
            
            $ChildImage = new Imagick();
            $ChildImage->readImage($this->ChildImage); 
            $BaseImage->compositeImage($ChildImage, Imagick::COMPOSITE_DEFAULT, 0, 0);
            
            $ChildImage->destroy();
        }
        
        $BaseImage->writeImage($this->Image);
        $BaseImage->destroy();
    }
}
