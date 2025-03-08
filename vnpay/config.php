<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// $vnp_TmnCode = "9Y069VOF"; //Mã định danh merchant kết nối (Terminal Id)
// $vnp_HashSecret = "6X9CYW8AVKNVAAZUYXRWJ1SA4DV3QE5R"; //Secret key
require_once plugin_dir_path(__FILE__) . '../db/db-detal-bank.php';
$data = get_data_max_detal_bank(1);
usort($data, function ($a, $b) {
    return $b->level - $a->level; 
});
$row = $data[0];
$vnp_HashSecret = $row->mk;
$vnp_TmnCode = $row->tk;
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl= home_url('/index.php?pagename=my-custom-page');
$vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
$apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
//Config input format
//Expire
$startTime = date("YmdHis");
$expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));
