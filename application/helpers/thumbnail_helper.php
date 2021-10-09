<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


    function thumb($path, $fullname, $width, $height)
    {
        // Path to image thumbnail in your root
        $dir=$path.'thumbs/';
        // Get the CodeIgniter super object
        $ci = get_instance();
        // get src file's extension and file name
        $extension = pathinfo($fullname, PATHINFO_EXTENSION);
        $filename = pathinfo($fullname, PATHINFO_FILENAME);
        $image_org = $path . $fullname;
        $image_thumb = $dir . $filename . "-" . $height . '_' . $width . "." . $extension;
        $image_returned = $path . $filename . "-" . $height . '_' . $width . "." . $extension;
        
        // LOAD LIBRARY
        $ci->load->library('image_lib');
        // CONFIGURE IMAGE LIBRARY
        $config['source_image'] = $image_org;
        $config['new_image'] = $image_thumb;
        $config['create_thumb'] = TRUE;
        $config['width'] = $width;
        $config['height'] = $height;
        $ci->image_lib->initialize($config);

        if (!$ci->image_lib->resize())
        {
            echo $ci->image_lib->display_errors('<p>', '</p>');
        }

        $ci->image_lib->clear();

        // return $image_thumb;
    }