<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('compress-image/Compress.php');

class CompressImage extends Compress
{
	public function __construct()
	{
		parent::__construct();
	}

	public function __destruct() {
		parent::__destruct();
    }
}
?>