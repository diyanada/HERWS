<?php

require_once ( dirname(__FILE__) . '/../Core/FFMpegEngine.php');

use Core\FFMpegEngine;

$ffmpeg = new FFMpegEngine();

$ffmpeg->ExtractFrames();

echo $ffmpeg->logger;