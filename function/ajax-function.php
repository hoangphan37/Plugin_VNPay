<?php
function checkbox_bank()
{

    require_once plugin_dir_path(__FILE__) . '../db/db-bank.php';
    $isChecked = isset($_POST['checkboxStatus']) ? intval($_POST['checkboxStatus']) : 0;
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    update_status_bank($id,$isChecked);
    wp_die(); 
}
function checkbox_detal()
{
    require_once plugin_dir_path(__FILE__) . '../db/db-detal-bank.php';
    $isChecked = isset($_POST['checkboxStatus']) ? intval($_POST['checkboxStatus']) : 0;
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    update_status_detal($id, $isChecked);
    wp_die();
}

