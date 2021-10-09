<?php

/** set your paypal credential **/

// $config['client_id'] = 'AcHrwP4VHD8x4EOB1UlIcof3bMB0oYYYjHfwO8STmh4JtncocJ3HK03lqy3YXYVGC3i6P-XdyqXQ-Aq2';
// $config['secret'] = 'EJwVTBGDKymCNfoKi5PEmOyo-Ipdrl18K3RpetS1UB_hTyYNSZ92a3ysB8Sjo2Dpie7yfesGl3GB8VJW';

/**
 * SDK configuration
 */
/**
 * Available option 'sandbox' or 'live'
 */

$ci = get_instance();

$ci->db->select('*');
$ci->db->from('tbl_settings');
$ci->db->where('id', '1'); 
$row_paypal_settings=$ci->db->get()->result()[0];


$config['settings'] = array(

    'mode' => $row_paypal_settings->paypal_mode,
    /**
     * Specify the max request time in seconds
     */
    'http.ConnectionTimeOut' => 1000,
    /**
     * Whether want to log to a file
     */
    'log.LogEnabled' => true,
    /**
     * Specify the file that want to write on
     */
    'log.FileName' => 'application/logs/paypal.log',
    /**
     * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
     *
     * Logging is most verbose in the 'FINE' level and decreases as you
     * proceed towards ERROR
     */
    'log.LogLevel' => 'FINE'
);