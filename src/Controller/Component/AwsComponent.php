<?php
namespace App\Controller\Component;
use Cake\Controller\Component;
/**
 * Amazon S3 services Comonent.
 */
  
require 'aws/aws-autoloader.php';
use Aws\Common\Exception\RuntimeException;
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\Model\MultipartUpload\UploadBuilder;
use Aws\S3\S3Client;
use \DateTime;
use Aws\CloudFront\CloudFrontClient;
use Aws\ElasticTranscoder\ElasticTranscoderClient;

class AwsComponent  extends Component {

/**
 * @var : name of bucket in which we are going to operate
 */ 	
	public $bucket = 'suruchi';

/**
 * @var : Amazon S3Client object
 */ 	
	private $s3 = null;
	
	
	public function __construct(){
		
		$this->s3 = S3Client::factory(array(
			'key' => AWS_KEY,
			'secret' => AWS_SECRET,
			'region' => AWS_REGION,
		));
                
                $this->cloudFront = CloudFrontClient::factory(array(
			'private_key' => AWS_PRIVATE_KEY,
			'key_pair_id' => AWS_KEY_PAIR_ID,
			 
		));
		
		
		$this->transcoder = ElasticTranscoderClient::factory(array(
				'key' => AWS_KEY,
				'secret' => AWS_SECRET,
				'region' => AWS_REGION, 
				'default_caching_config' => '/tmp'
				
		));
		
	}
        
        
	public function createHLSJob($pipeline_id, $input_key, $output_key, $output_key_prefix, $hls_presets, $segment_duration){
		# Setup the job input using the provided input key.
		$input = array('Key' => $input_key);
		
		#Setup the job outputs using the HLS presets.
		//$output_key = hash('sha256', utf8_encode($input_key));
		
		# Specify the outputs based on the hls presets array spefified.
		$outputs = array();
		$outputs_preview = array();
		foreach ($hls_presets as $prefix => $preset_id) {
			if($preset_id == "1351620000001-100200"){ //for gif preview
				array_push($outputs_preview, array('Key' => "$output_key", 'PresetId' => $preset_id));
		
			} else {
				array_push($outputs, array('Key' => "$output_key", 'PresetId' => $preset_id, 'SegmentDuration' => $segment_duration));
			}
		}
		
		# Setup master playlist which can be used to play using adaptive bitrate.
		$playlist = array(
                    'Name' => 'hls_' . $output_key,
                    'Format' => 'HLSv3',
                    'OutputKeys' => array_map(function($x) { return $x['Key']; }, $outputs)
		);
                    
		# Create the job.
		$create_job_request =  array(
                    'PipelineId' => $pipeline_id,
                    'Input' => $input,
                    'Outputs' => $outputs,
                    'OutputKeyPrefix' => $output_key_prefix,
                    //'Playlists' => array($playlist)
		);
		$create_job_result = $this->transcoder->createJob($create_job_request)->toArray();
		return $job = $create_job_result['Job'];
	}
	
	
	
	public function getSingedURL($object){
		//var_dump($this->cloudFront);
		$dateTime = new DateTime("+10000 min");
	//	$expiry = date('Y-m-d H:i:s', strtotime("+10 min"));
		return $this->cloudFront->getSignedUrl([
				'url'=>$this->cloudeFrontURL."/".$object,
				'expires'=>$dateTime->getTimestamp()
				
		]);
	}
	
	
	public function getSignedCookie($object){
		//var_dump($this->cloudFront);
		$dateTime = new DateTime("+10000 min");
		//	$expiry = date('Y-m-d H:i:s', strtotime("+10 min"));
		return $this->cloudFront->getSignedCookie([
				'url'=>$this->cloudeFrontURL."/".$object,
				'expires'=>$dateTime->getTimestamp()
	
		]);
	}
	
	
/**
 * @desc : to upload file on bucket with specified path
 * @param : keyname > path of file which need to be uploaded
 * @return : uploaded file object 
 * @created on : 14.03.2014
 */	

	public function upload($keyname=null, $filename=null, $file_permission=NULL){
	
		try {
			$uploader = UploadBuilder::newInstance()
						->setClient($this->s3)
						->setSource($keyname)
						->setBucket($this->bucket)
						->setKey($filename)
						->setOption('ACL', $file_permission)
						->build();
						
						
			return  $uploader->upload();
			 
		} catch (MultipartUploadException $e) {
			if(Configure::read('debug')) echo 'S3 Exception :'.$e->getMessage() ;
			$uploader->abort();
		} catch (Exception $e) {
			if(Configure::read('debug')) echo 'Exception :'.$e->getMessage() ;
		}
		
		return false; 	
	}
	
	
/**
 * @desc : to delete multiple objects from bucket
 * @param : array(
				array('Key' => $keyname1),
				array('Key' => $keyname2),
				array('Key' => $keyname3),
			)
 * @return : boolean
 * @created on : 14.03.2014   
 */
	public function delete($objects=array()){
		try{
			return $this->s3->deleteObjects(array(
				'Bucket' => $this->bucket,
				'Objects' => $objects
			));
		} catch (RuntimeException $e) {
			if(Configure::read('debug')) echo 'RuntimeException Exception :'.$e->getMessage() ;
		} catch (Exception $e) {
			if(Configure::read('debug')) echo 'Exception :'.$e->getMessage() ;			
		}
		return false ;
	}
	
	
 /**
 * @desc : to empty specified folder
 * @param : folder to which you want to empty
 * @return : deleted file count
 * @created on :14.03.2014
 */    
   public function emptyFolder($folder=null,$regexp='/\.[0-9a-z]+$/'){
		try{
			return $this->s3->deleteMatchingObjects($this->bucket, $folder, $regexp);
			
		} catch (RuntimeException $e) {
			if(Configure::read('debug')) echo 'RuntimeException Exception :'.$e->getMessage() ;	
		} catch (Exception $e) {
			if(Configure::read('debug')) echo 'Exception :'.$e->getMessage() ;			
		}
		return false ;
	}
	
	
/**
* Check if file already exist in bucket
*/	
	public function check_file_existence($bucket, $file)
	{
		try{
			return $this->s3->doesObjectExist($bucket, $file);
			
		} catch (RuntimeException $e) {
			if(Configure::read('debug')) echo 'RuntimeException Exception :'.$e->getMessage() ;	
		} catch (Exception $e) {
			if(Configure::read('debug')) echo 'Exception :'.$e->getMessage() ;			
		}
		return false ;
	}
			
}
