<?php
require_once plugin_dir_path(__FILE__) . '../function/function.php';


?>
<style>
    td {
        text-align: center;
    }
</style>
<div class="main-setup" style="  border: 1px solid #ccc;">
    <h2>Lịch sử Thanh Toán</h2>
    <?php
    echo '<h2>Danh sách thanh toán</h2>';
    $data = get_plugin_payments_data();
    ?>
    <label for="combobox">Trạng thái GD:</label>
    <select id="combobox" name="combobox">
        <option value="-1">Tất Cả</option>
        <option value="0">Chưa Hoàn Thành</option>
        <option value="1">Hoàn Thành</option>
        <option value="2">Hoàn Tiền</option>
    </select>
    <label for="combobox-method">Hình Thức:</label>
    <select id="combobox-method" name="combobox-method">
        <option value="ALL">Tất Cả</option>
        <option value="VNPAY">VNPAY</option>
        <option value="MOMO">MOMO</option>
        <option value="PAYPAL">PAYPAL</option>
    </select>
    <div style="float: right; margin-right: 100px;">
        <input type="text" id="customerID" placeholder="ID Khách Hàng">
        <input type="text" id="transactionDate" placeholder="Thời Gian yyyy-mm-dd">
        <button id="searchButton">Kiểm Tra</button>
        <button id="resetButton">Reset</button>
    </div>
    <div style="height: 30px;"></div>
    <table class="" style="border: 1px solid #000; width: 100%;height: 80%; overflow:auto">
        <tr>
            <th>ID</th>
            <th>ID Khách Hàng</th>
            <th>Số Tiền</th>
            <th>Hình Thức</th>
            <th>Thời Gian</th>
            <th>Trạng Thái</th>
            <th>Thao Tác</th>
        </tr>
        <?php foreach ($data as $row) { ?>
            <tr class="transaction-row" data-status="<?php echo $row->status; ?>" data-id="<?php echo $row->iduser; ?>"
                data-date="<?php echo $row->created_at; ?>"
                data-method="<?php echo $row->payment_method; ?>">
                <td> <?php echo $row->id ?> </td>
                <td> <?php echo $row->iduser ?> </td>
                <td> <?php echo $row->amount ?> </td>
                <td> <?php echo $row->payment_method ?> </td>
                <td> <?php echo $row->created_at ?> </td>
                <td> <?php if ($row->status == 0) {
                            echo (" chưa hoàn thành");
                        };
                        if ($row->status == 1) {
                            echo (" Hoàn thành");
                        };
                        if ($row->status == 2) {
                            echo ("Hoàn tiền");
                        };  ?> </td>
                <td>
                    <form action="<?php echo (home_url("/wp-admin/admin.php?page=qr-pay3")); ?>" method="GET">
                        <input type="text" value="<?php echo $row->id ?>" name="TxnRef" hidden>
                        <input type="text" value="<?php echo $row->amount ?>" name="amount" hidden>
                        <input type="text" value="qr-pay3" name="page" hidden>
                        <input type="text" value="<?php echo $row->created_at ?>" name="TransactionDate" hidden>
                        <?php if ($row->status == 1) {
                            echo ("<button type='submit'>hoàn tiền</button>");
                        } ?>
                    </form>
                </td>
            </tr>

        <?php } ?>
    </table>
</div>
<script>
    document.getElementById('combobox').addEventListener('change', filterRows);
    document.getElementById('combobox-method').addEventListener('change', filterRows);

    function filterRows() {
        const selectedStatus = document.getElementById('combobox').value; 
        const selectedMethod = document.getElementById('combobox-method').value; 
        const rows = document.querySelectorAll('.transaction-row'); 

        rows.forEach(row => {
            const rowStatus = row.getAttribute('data-status'); 
            const rowMethod = row.getAttribute('data-method'); 

            
            const matchStatus = (selectedStatus === '-1' || rowStatus === selectedStatus);
            const matchMethod = (selectedMethod === 'ALL' || rowMethod === selectedMethod);

            if (matchStatus && matchMethod) {
                row.style.display = ''; 
            } else {
                row.style.display = 'none'; 
            }
        });
    }
</script>
<script>
    document.getElementById('searchButton').addEventListener('click', function() {
        const customerID = document.getElementById('customerID').value.trim(); 
        const transactionDate = document.getElementById('transactionDate').value.trim(); 
        const rows = document.querySelectorAll('.transaction-row'); 

        rows.forEach(row => {
            const rowID = row.getAttribute('data-id'); 
            const rowDate = row.getAttribute('data-date'); 

            
            const matchID = customerID === '' || rowID.includes(customerID);
            const matchDate = transactionDate === '' || rowDate.startsWith(transactionDate);

            if (matchID && matchDate) {
                row.style.display = ''; 
            } else {
                row.style.display = 'none'; 
            }
        });
    });
</script>
<script>
    document.getElementById('resetButton').addEventListener('click', function() {
        document.getElementById('customerID').value = '';
        document.getElementById('transactionDate').value = '';
        document.getElementById('combobox').value = '-1'; 
        const rows = document.querySelectorAll('.transaction-row');
        rows.forEach(row => {
            row.style.display = '';
        });
    });
</script>