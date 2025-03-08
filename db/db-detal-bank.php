<?php

function get_data_detal_bank($id_bank = null)
{
    global $wpdb;
    if ($id_bank) {
        $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}qr_detalbank WHERE id_bank = %d", $id_bank);
    } else {
        $sql = "SELECT * FROM {$wpdb->prefix}qr_detalbank ";
    }
    return $wpdb->get_results($sql);
}
function get_data_max_detal_bank($id_bank = null)
{
    global $wpdb;
    if ($id_bank) {
        $sql = $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}qr_detalbank WHERE id_bank = %d and status = 1 ORDER BY level DESC LIMIT 1",$id_bank);
             
    } else {
        $sql = "SELECT * FROM {$wpdb->prefix}qr_detalbank ";
    }
    return $wpdb->get_results($sql);
}
function insert_detal_bank($id_bank, $tk, $mk, $note = "", $status = 0)
{
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'qr_detalbank';
  $max_level = $wpdb->get_var($wpdb->prepare("SELECT MAX(level) FROM $table_name WHERE id_bank = %d", $id_bank));
 $new_level = $max_level ? $max_level + 1 : 1;
    $wpdb->insert(
        $table_name,
        [
            'id_bank' => $id_bank,
            'tk' => $tk,
            'mk' => $mk,
            'note' => $note,
            'status' => $status,
            'level' => $new_level,
        ],
        ['%d', '%s', '%s', '%s', '%d', '%d']
    );
    header('Location: admin.php?page=qr-pay2');
     die();
    

}
function update_status_detal($id, $isChecked){
    global $wpdb;
    $table_name = $wpdb->prefix . 'qr_detalbank';
    $wpdb->update(
        $table_name,
        [
            'status' => $isChecked,
        ],
        [
            'id' => $id,
        ],
        ['%d'],
        ['%d']
    );
}
function update_level_detal($id,$idbank)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'qr_detalbank';
    $max_level = $wpdb->get_var($wpdb->prepare("SELECT MAX(level) FROM $table_name WHERE id_bank = %d",$idbank));
    $new_level = $max_level ? $max_level + 1 : 1;
    $wpdb->update(
        $table_name,
        [
            'level' => $new_level,
        ],
        [
            'id' => $id,
        ],
        ['%d'],
        ['%d']
    );
    header('Location: admin.php?page=qr-pay2');
}
function delete_detal($id)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'qr_detalbank';
    $wpdb->delete(
        $table_name,
        [
            'id' => $id,
        ],
        ['%d']
    );
    header('Location: admin.php?page=qr-pay2');

}