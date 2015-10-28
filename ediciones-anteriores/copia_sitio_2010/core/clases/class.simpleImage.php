<?php
/**
* @package Punk Framework
* @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
* @version 0.2
* @author Lucas M. Sastre
* @link http://www.oniricosistemas.com
* @name class.simpleImage.php
*/

 
class SimpleImage {
   
   private  $image;
   private  $image_type;
   private  $instance;

   /**
	* Creo el patron Singleton
	*
	* @return instance
	*/
	public static function singleton()
	{
	    if( self::$instance == null ) {
	        self::$instance = new self();
	    }

	    return self::$instance;
	}
 
   public function load($filename) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
   }
   
   public function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image,$filename);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$filename);
      }   
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }
   
   public function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);
      }   
   }

   private function getWidth() {
      return imagesx($this->image);
   }
   
   private function getHeight() {
      return imagesy($this->image);
   }
   
   public function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
   
   public function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
   
   public function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100; 
      $this->resize($width,$height);
   }
   
   public function noResize(){
   		$new_image = imagecreatetruecolor($this->getWidth(), $this->getHeight());
      
      //creo la transprencia para los png y gif
      if(($this->image_type == IMAGETYPE_GIF) OR ($this->image_type == IMAGETYPE_PNG)){
      	imagealphablending($this->image, false);
      	imagesavealpha($this->image,true);
      	$transparent = imagecolorallocate($new_image, 255, 255, 255);//imagecolorallocatealpha($new_image, 255, 255, 255, 127);
      	//imagefilledrectangle($new_image, 0, 0, $width, $height, $transparent);
      	imagefill($new_image, 0, 0, $transparent);
      }

      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $this->getWidth(), $this->getHeight(), $this->getWidth(), $this->getHeight());
      $this->image = $new_image; 
   }
   
   public function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      
      //creo la transprencia para los png y gif
      if(($this->image_type == IMAGETYPE_GIF) OR ($this->image_type == IMAGETYPE_PNG)){
      	imagealphablending($this->image, false);
      	imagesavealpha($this->image,true);
      	$transparent = imagecolorallocate($new_image, 255, 255, 255);//imagecolorallocatealpha($new_image, 255, 255, 255, 127);
      	//imagefilledrectangle($new_image, 0, 0, $width, $height, $transparent);
      	imagefill($new_image, 0, 0, $transparent);
      }

      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;   
   }      
}
?>

