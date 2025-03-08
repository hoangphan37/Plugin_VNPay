<?php
function plugin_test_create_database()
{
    global $wpdb;


    $table_name = $wpdb->prefix . 'qr_plugin_test_table';
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id)
            ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    // Bang lịch sử giao dịch
    $table_name = $wpdb->prefix . 'qr_payments';
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            iduser int NOT NULL,
            amount float NOT NULL,
            payment_method varchar(255) NOT NULL,
            status int ,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id)
            ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }


    // Bang Phuong thuc thanh toan
    $table_name = $wpdb->prefix . 'qr_bank';
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            status BOOLEAN ,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id)
            ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        $default_methods = [
            ['name' => 'VNPAY', 'status' => 0],
            ['name' => 'MOMO', 'status' => 0],
            ['name' => 'PAYPAL', 'status' => 0],
        ];

        foreach ($default_methods as $method) {
            $wpdb->insert(
                $table_name,
                [
                    'name' => $method['name'],
                    'status' => $method['status'],
                ],
                ['%s', '%d'] // Định dạng dữ liệu (string, integer)
            );
        }
    }

    // Bang chi tiet tai khoan thanh toan
    $table_name = $wpdb->prefix . 'qr_detalbank';
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            id_bank int NOT NULL,
            tk varchar(255) NOT NULL,
            mk varchar(255) NOT NULL,
            note varchar(255) NOT NULL,
            status BOOLEAN ,
            level int NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id)
            ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
