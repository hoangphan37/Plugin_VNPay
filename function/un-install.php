<?php
function plugin_test_delete_database()
{
global $wpdb;

$table_name = $wpdb->prefix . 'qr_plugin_test_table';
$wpdb->query("DROP TABLE IF EXISTS $table_name");

$table_name = $wpdb->prefix . 'qr_plugin_payments';
$wpdb->query("DROP TABLE IF EXISTS $table_name");

$table_name = $wpdb->prefix . 'qr_bank';
$wpdb->query("DROP TABLE IF EXISTS $table_name");

$table_name = $wpdb->prefix . 'qr_detalbank';
$wpdb->query("DROP TABLE IF EXISTS $table_name");
}