<?php

namespace Core;

use Thread;
use Imagick;
use ImagickPixel;

class CreateImage extends Thread{
    
    private $ImageFile = null;
    private $OverlayHeight = null;
    private $OverlayWidth = null;
    private $Angle = null;
    private $Opacity = null;
    
    private $Height = null;
    private $Width = null;
    
    private $x_axis = null;
    private $y_axis = null;
    private $DestinationImage = null;
    
    function setOverlayDetails($Details , $DestinationImage) {
        
        $this->OverlayHeight = round($Details["Height"]);
        $this->OverlayWidth = round($Details["Width"]);
        
        $this->x_axis = round($Details["x_axis"]);
        $this->y_axis = round($Details["y_axis"]);
        
        $this->Angle = round($Details["Angle"]);
        $this->Opacity = (round($Details["Opacity"]) / 100);
        
        $this->DestinationImage = $DestinationImage;
    }

    function __construct($ImageFile, $Height, $Width) {
        
        $this->ImageFile = $ImageFile;
        $this->Height = $Height;
        $this->Width = $Width;
    }

    public function run() {
        
        $ImageOverlay = new Imagick(); 
        $ImageOverlay->readImage($this->ImageFile); 
        $ImageOverlay->scaleImage($this->OverlayWidth, $this->OverlayHeight);
        $ImageOverlay->rotateimage(new ImagickPixel('transparent'), $this->Angle);
        $ImageOverlay->setBackgroundColor(new ImagickPixel('transparent'));            
        $ImageOverlay->evaluateImage(Imagick::EVALUATE_MULTIPLY, $this->Opacity, Imagick::CHANNEL_ALPHA);

        $Image = new Imagick();
        $Image->newimage($this->Height, $this->Width, new ImagickPixel('transparent'));
        $Image->setImageFormat('bmp');
        
        $Image->compositeImage($ImageOverlay, Imagick::COMPOSITE_DEFAULT, $this->x_axis, $this->y_axis);

        $Image->writeImage($this->DestinationImage);

        $ImageOverlay->destroy();
        $Image->destroy();
    }
}
