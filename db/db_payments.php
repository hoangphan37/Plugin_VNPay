<?php
function update_status_payments($id, $status){
global $wpdb;
$table_name = $wpdb->prefix . 'qr_payments';
$wpdb->update(
$table_name,
[
'status' => $status,
],
[
'id' => $id,
],
['%d'],
['%d']
);
}