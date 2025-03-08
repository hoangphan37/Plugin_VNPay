<?php 

function get_data_bank() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'qr_bank';
    $query = "SELECT * FROM $table_name";
    $results = $wpdb->get_results($query);

    if (!empty($results)) {
        return $results;
    } else {
        return null;
    }
   
}
function check_status_bank($name){
    global $wpdb;

    $table_name = $wpdb->prefix . 'qr_bank';
    $query = "SELECT * FROM $table_name where name = '$name' and status = 1";
    $results = $wpdb->get_results($query);
    if (!empty($results)) {
        return true;
    } else {
        return false;
    }
}
function update_status_bank($id, $status)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'qr_bank';
    $wpdb->update(
        $table_name,
        [
            'status' => $status,
        ],
        [
            'id' =>$id,
        ],
        ['%d'],
        ['%d']
    );
}