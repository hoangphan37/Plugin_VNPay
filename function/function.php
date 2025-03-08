<?php

function get_plugin_payments_data()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'qr_payments';
    $results = $wpdb->get_results("SELECT * FROM $table_name");
    if ($results) {
        return $results;
    } else {
        echo 'Không có dữ liệu thanh toán.';
    }
}
function plugin_handle_payment_form()
{
    include plugin_dir_path(__FILE__) . '../vnpay/function.php';
    include plugin_dir_path(__FILE__) . '../db/db-bank.php';
    if (isset($_POST['submit_payment'])) {
        $amount = isset($_POST['amount']) ? sanitize_text_field($_POST['amount']) : '';
        $bankCode = isset($_POST['bankCode']) ? sanitize_text_field($_POST['bankCode']) : '';
        $idUser = isset($_POST['idUser']) ? sanitize_text_field($_POST['idUser']) : 0;
        if (!check_status_bank($bankCode)){
            echo "<script>alert('Phương thức thanh toán hiện đang bảo trì. Vui lòng chọn phương thức thanh toán khác.');</script>";
            return;
            exit;
        }

        $vnp_Amount = $amount; 
        $vnp_Locale = 'vn'; 
        $vnp_BankCode = ""; 
        global $wpdb;
        $table_name = $wpdb->prefix . 'qr_payments';
        $wpdb->insert(
            $table_name,
            array(
                'amount' => $amount,
                'payment_method' => $bankCode,
                'iduser' =>$idUser,
                'status' => 0,
                'created_at' => current_time('mysql'),
            )
        );
        $inserted_id = $wpdb->insert_id;
        if ($bankCode == "VNPAY") {
            $vnp_Amount = $amount;
            $vnp_Locale = 'vn';
            $vnp_BankCode = "";
            vnpay_create_payment(
                $inserted_id,
                $vnp_Amount,                
                $vnp_Locale,                    
                $vnp_BankCode             
            );
        }
        exit;
        
    }
}
