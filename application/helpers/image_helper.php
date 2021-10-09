<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 	
	//-- check logged user
	if (!function_exists('image_thumb')) {
	    function image_thumb( $image_path, $width, $height) {
	        // Get the CodeIgniter super object
		    $CI =get_instance();

		    $file_name=basename($image_path);

		    // Path to image thumbnail
		    $image_thumb = dirname($image_path) . '/thumbs/' . $width . 'x' . $height . '_' . $file_name;

		    if (!file_exists( $image_thumb) ) {
		        // LOAD LIBRARY
		        $CI->load->library('image_lib');
		        // CONFIGURE IMAGE LIBRARY
		        $config['image_library']    = 'gd2';
		        $config['source_image']     = $image_path;
		        $config['new_image']        = $image_thumb;
		        $config['maintain_ratio']   = true;
		        $config['height']           = $height;
		        $config['width']            = $width;
		        $CI->image_lib->initialize( $config );
		        $CI->image_lib->resize();
		        $CI->image_lib->clear();

		        print_r($config);
		    }

		    //return dirname($_SERVER['SCRIPT_NAME'] ) . '/' . $image_thumb;

	    }
	}

  