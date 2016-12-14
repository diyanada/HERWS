<?php

namespace Core;

require_once ( dirname(__FILE__) . '/../Components/StructDerectory.php');
require_once ( dirname(__FILE__) . '/JsonManipulator.php');
require_once ( dirname(__FILE__) . '/../aws/aws-autoloader.php');

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Core\JsonManipulator;

class JsonManipulatorS3 extends JsonManipulator {
    
    private $s3Client;
    private $Bucket = "hrestorage";
            
    function __construct($StructDerectory) {
        
        parent::__construct($StructDerectory);
        
        $credintials = [
            'version' => 'latest',
            'region'  => 'eu-west-1',
            'credentials' => [
                'key'    => 'AKIAIB2PFLXV3K3UIDBA',
                'secret' => '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'
            ]
        ];

        $this->s3Client = S3Client::factory($credintials);
        
    }
    
    //---------------------Private Functions
    
    protected function ReadFile($FileName, $Derectory){
        
        try {
            $params = [
                'Bucket' => $this->Bucket,
                'Key' => $Derectory . "/" . $FileName
            ];


            $result = $this->s3Client->getObject($params);
            
            return json_decode($result->get("Body"), true);

        } catch (S3Exception $Ex) {
            
            throw new \Exception($Ex->getMessage(), $Ex->getCode());
        }
    }
    
    protected function SaveFile($Json, $FileName, $Derectory) {
        
        try {
            
            $params = [
                'Bucket' => $this->Bucket,
                'Key' => $Derectory . "/" . $FileName,
                'ACL' => 'public-read',
                'Body' => json_encode($Json)
            ];
            
            if($Json == null){
                
                $params = [
                    'Bucket' => $this->Bucket,
                    'Key' => $Derectory . "/" . $FileName
                ];
            }

            $this->s3Client->putObject($params);

        } catch (S3Exception $Ex) {
            
            throw new \Exception($Ex->getMessage(), $Ex->getCode());
        }
    }
}