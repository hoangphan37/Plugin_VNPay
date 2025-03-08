<?php
require_once plugin_dir_path(__FILE__) . '../function/function.php';
require_once plugin_dir_path(__FILE__) . '../db/db-bank.php';
require_once plugin_dir_path(__FILE__) . '../db/db-detal-bank.php';

$dataBank = get_data_bank();
?>

<div class="main-setup">
    Chọn hình thức thanh toán mà bạn muốn chọn


    <table style="width: 70%; padding-top: 70px;">

        <?php foreach ($dataBank as $row) { ?>

            <tr>

                <th>
                    <?php echo ("$row->name") ?>
                </th>
                <th>
                    <div class='checkbox-wrapper-8'><input name="checkbank<?php echo ($row->id) ?>" class='tgl tgl-skewed' id='checkbank<?php echo ($row->id) ?>' type='checkbox' <?php echo ($row->status == 0 ? "" : "checked") ?> />
                        <label class='tgl-btn' data-tg-off='OFF' data-tg-on='ON' for='checkbank<?php echo ($row->id) ?>'></label>
                    </div>
                </th>
            </tr>
            <tr>
                <td>STT</td>
                <td>Tài Khoản</td>
                <td>Mật Khẩu</td>
                <td>Ưu Tiên</td>
                <td>Trạng Thái</td>
                <td>Chức Năng</td>

            </tr>
            <?php
            $dataDetalBank = get_data_detal_bank($row->id);
            usort($dataDetalBank, function ($a, $b) {
                return $b->level - $a->level;
            });
            foreach ($dataDetalBank as $rowDetal) {
            ?>

                <tr>
                    <td>1</td>
                    <td><?php echo ("$rowDetal->tk") ?></td>
                    <td><?php echo ("$rowDetal->mk") ?></td>

                    <td>
                        <form method="POST">
                            <input type="text" name="id_level_<?php echo ($rowDetal->id); ?>" id="" value="<?php echo ($rowDetal->id); ?>" hidden>
                            <input type="text" name="id_bank_<?php echo ($rowDetal->id); ?>" id="" value="<?php echo ($rowDetal->id_bank); ?>" hidden>
                            <button type="submit" name="submit_level_<?php echo ($rowDetal->id) ?>">↑</button>
                        </form>
                    </td>

                    <td>
                        <div class='checkbox-wrapper-2'>
                            <input type='checkbox' id='checkDetal<?php echo ($rowDetal->id) ?>' class='sc-gJwTLC ikxBAC checkDetalClass' <?php echo ($rowDetal->status == 0 ? "" : "checked") ?>>
                        </div>
                    </td>
                    <td>
                        <form method="POST">
                            <input type="text" name="id_delete_<?php echo ($rowDetal->id); ?>" id="" value="<?php echo ($rowDetal->id); ?>" hidden>
                            <button type="submit" name="submit_delete_<?php echo ($rowDetal->id) ?>">Xóa</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <form method="POST">
                    <td>Thêm</td>
                    <td><input type='text' name='tk<?php echo ($row->id); ?>'></td>
                    <td><input type='text' name='mk<?php echo ($row->id); ?>'><input type='number' name='id<?php echo ($row->id); ?>' value='<?php echo ($row->id) ?>' hidden></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class='checkbox-wrapper-2'>
                            <button type="submit" name="submit_button<?php echo ($row->id); ?>">Them</button>
                        </div>
                    </td>


                </form>
                <?php

                if (isset($_POST['submit_button1'])) {
                    insert_detal_bank($_POST['id1'], $_POST['tk1'], $_POST['mk1']);
                }
                if (isset($_POST['submit_button2'])) {
                    insert_detal_bank($_POST['id2'], $_POST['tk2'], $_POST['mk2']);
                }
                if (isset($_POST['submit_button3'])) {
                    insert_detal_bank($_POST['id3'], $_POST['tk3'], $_POST['mk3']);
                }
                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'submit_level') === 0) {
                        $level = str_replace('submit_level_', '', $key);
                        $id_level = $_POST["id_level_" . $level];
                        $id_bank = $_POST["id_bank_" . $level];
                        update_level_detal($id_level, $id_bank);
                    }
                }
                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'submit_delete') === 0) {
                        $level = str_replace('submit_delete_', '', $key);
                        $id_level = $_POST["id_delete_" . $level];
                        delete_detal($id_level);
                    }
                }
                ?>

            </tr>
            <tr style="height: 70px;">
                <td colspan="2"></td>
            </tr>
        <?php  } ?>
    </table>
</div>

<script>

</script>