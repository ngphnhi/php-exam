<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
</head>
<body>
    <?php
        require "connection.php";
        require "item.php";
        $id = $_REQUEST["id"] ?? 0;
        $item = getItemById($id, $conn);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $error = array();
            $item_code = trim($_POST["item_code"]);
            $item_name = trim($_POST["item_name"]);
            $quantity = trim($_POST["quantity"]);
            $expired_date = trim($_POST["expired_date"]);
            $note = trim($_POST["note"]);
            if (empty($item_code)) {
                $error["errCode"] = "Thông tin code item không được để trống";
            }
            if (empty($item_name)) {
                $error["errName"] = "Thông tin tên item không được để trống";
            }
            if (empty($quantity)) {
                $error["errQuantity"] = "Thông tin số lượng không được để trống";
            }

            if (empty($error)) {
                // echo "vào đây";\
                if ($id > 0) {
                    editItem ($item_code, $item_name, $quantity, $expired_date, $conn, $id, $note);
                } else {
                    saveItem($item_code, $item_name, $quantity, $expired_date, $conn, $note);
                    // echo "Đã thêm";
                }
                header("Location: index.php");
            }
        }

        function saveItem ($item_code, $item_name, $quantity, $expired_date, $conn, $note) {
            try {
                $sql = "INSERT INTO item_sale (`item_code`, `item_name`, `quantity`, `expired_date`, `note`) 
                    VALUES (:item_code, :item_name, :quantity, date(:expired_date), :note)";
                $sttm = $conn->prepare($sql);
                
                $sttm->bindParam("item_code", $item_code, PDO::PARAM_STR);
                $sttm->bindParam("item_name", $item_name, PDO::PARAM_STR);
                $sttm->bindParam("quantity", $quantity, PDO::PARAM_INT);
                $sttm->bindParam("expired_date", $expired_date, PDO::PARAM_STR);
                $sttm->bindParam("note", $note, PDO::PARAM_STR);
                $sttm->execute();
            } catch(PDOException $ex) {
                echo $ex->getMessage();
            }
        }

        function editItem ($item_code, $item_name, $quantity, $expired_date, $conn, $id, $note) {
            try {
                $sql = "UPDATE item_sale 
                        SET item_code = :item_code, item_name = :item_name, quantity = :quantity, expired_date = DATE(:expired_date), note = :note 
                        where id  = :id";
                $sttm = $conn->prepare($sql);
                $sttm->bindParam("id", $id, PDO::PARAM_INT);
                $sttm->bindParam("item_code", $item_code, PDO::PARAM_STR);
                $sttm->bindParam("item_name", $item_name, PDO::PARAM_STR);
                $sttm->bindParam("quantity", $quantity, PDO::PARAM_INT);
                $sttm->bindParam("expired_date", $expired_date, PDO::PARAM_STR);
                $sttm->bindParam("note", $note, PDO::PARAM_STR);
                $sttm->execute();
            } catch(PDOException $ex) {
                echo $ex->getMessage();
            }
        }

        function getItemById($id, $conn) {
            try {
                $sql = "select * from item_sale where id = :id";
                $sttm = $conn->prepare($sql);
                $sttm->execute(["id"=>$id]);
                $sttm->setFetchMode(PDO::FETCH_CLASS, "item");
                $item = $sttm->fetch();
                return $item;
            } catch(PDOException $ex) {
                echo $ex->getMessage();
            }
        }
    ?>

    <form method="POST">
        <input type="hidden" name="id" value="<?php echo !empty($item) ? $item->id : 0 ?>">
        <input type="text" name="item_code" placeholder="Code item" value="<?php echo !empty($item) ? $item->item_code : "" ?>"></br>
        <?php echo empty($error["errCode"]) ? "" : $error["errCode"] . "</br>" ?>
        <input type="text" name="item_name" placeholder="Tên item" value="<?php echo !empty($item) ? $item->item_name : "" ?>"></br>
        <?php echo empty($error["errName"]) ? "" : $error["errName"] . "</br>" ?>
        <input type="text" name="quantity" placeholder="Số lượng Item" value="<?php echo !empty($item) ? $item->quantity : "" ?>"></br>
        <?php echo empty($error["errQuantity"]) ? "" : $error["errQuantity"] . "</br>" ?>
        <input type="date" name="expired_date" placeholder="Nhập thông tin hạn dùng" value="<?php echo !empty($item) ? $item->expired_date : "" ?>"></br>
        <input type="text" name="note" placeholder="Nhập ghi chú" value="<?php echo !empty($item) ? $item->note : "" ?>"></br>
        <input type="submit" value="submit">
    </form>
</body>
</html>