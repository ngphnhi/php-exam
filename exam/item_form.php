<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Form</title>
    
<body>
<?php
require "connection.php";  
require "item.php";  

$id = $_REQUEST["id"] ?? 0;
$item = getItemById($id, $pdo); // Ensure getItemById fetches data properly

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error = array();
    $itemCode = trim($_POST["item_code"]);
    $itemName = trim($_POST["item_name"]);
    $quantity = trim($_POST["quantity"]);
    $expiredDate = trim($_POST["expired_date"]);
    $note = trim($_POST["note"]);

    if (empty($itemCode)) {
        $error["errItemCode"] = "Item code is required.";
    }
    if (empty($itemName)) {
        $error["errItemName"] = "Item name is required.";
    }
    if (empty($quantity) || !is_numeric($quantity) || $quantity < 0) {
        $error["errQuantity"] = "Valid quantity is required.";
    }
    if (empty($expiredDate)) {
        $error["errExpiredDate"] = "Expired date is required.";
    }

    if (empty($error)) {
        if ($id > 0) {
            editItem($itemCode, $itemName, $quantity, $expiredDate, $note, $pdo, $id);
        } else {
            saveItem($itemCode, $itemName, $quantity, $expiredDate, $note, $pdo);
        }
        header("Location: item.php");
        exit();
    }
}

function saveItem($itemCode, $itemName, $quantity, $expiredDate, $note, $pdo) {
    try {
        $sql = "INSERT INTO items (item_code, item_name, quantity, expired_date, note) 
                VALUES (:item_code, :item_name, :quantity, :expired_date, :note)";
        $sttm = $pdo->prepare($sql);
        $sttm->bindParam("item_code", $itemCode, PDO::PARAM_STR);
        $sttm->bindParam("item_name", $itemName, PDO::PARAM_STR);
        $sttm->bindParam("quantity", $quantity, PDO::PARAM_INT);
        $sttm->bindParam("expired_date", $expiredDate, PDO::PARAM_STR);
        $sttm->bindParam("note", $note, PDO::PARAM_STR);
        $sttm->execute();
    } catch(PDOException $ex) {
        echo $ex->getMessage();
    }
}

function getItemById($id, $pdo) {
    if ($id > 0) {
        $sql = "SELECT * FROM items WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ); 
    }
    return null;
}
function editItem($itemCode, $itemName, $quantity, $expiredDate, $note, $pdo, $id) {
    try {
        $sql = "UPDATE items SET item_code = :item_code, item_name = :item_name, quantity = :quantity, expired_date = :expired_date, note = :note WHERE id = :id";
        $sttm = $pdo->prepare($sql);
        $sttm->bindParam("item_code", $itemCode, PDO::PARAM_STR);
        $sttm->bindParam("item_name", $itemName, PDO::PARAM_STR);
        $sttm->bindParam("quantity", $quantity, PDO::PARAM_INT);
        $sttm->bindParam("expired_date", $expiredDate, PDO::PARAM_STR);
        $sttm->bindParam("note", $note, PDO::PARAM_STR);
        $sttm->bindParam("id", $id, PDO::PARAM_INT);
        $sttm->execute();
    } catch(PDOException $ex) {
        echo $ex->getMessage();
    }
}

function deleteItem($id, $pdo) {
    try {
        $sql = "DELETE FROM items WHERE id = :id";
        $sttm = $pdo->prepare($sql);
        $sttm->bindParam("id", $id, PDO::PARAM_INT);
        $sttm->execute(); // Corrected typo
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}
?>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo !empty($item) ? $item->id : 0 ?>">
        <input type="text" name="item_code" placeholder="Enter item code" value="<?php echo !empty($item) ? $item-> item_code : "" ?>"></br>
        <?php echo empty($error["errItemCode"]) ? "" : $error["errItemCode"] . "</br>" ?>

        <input type="text" name="item_name" placeholder="Enter item name" value="<?php echo !empty($item) ? $item->item_name : "" ?>"></br>
        <?php echo empty($error["errItemName"]) ? "" : $error["errItemName"] . "</br>" ?>

        <input type="number" name="quantity" placeholder="Enter item quantity" value="<?php echo !empty($item) ? $item ->quantity: "" ?>"></br>
        <?php echo empty($error["errQuantity"]) ? "" : $error["errQuantity"] . "</br>" ?>

        <input type="date" name="expired_date" placeholder="Enter expired date" value="<?php echo !empty($item) ? $item->expired_date: "" ?>"></br>
        <?php echo empty($error["errExpiredDate"]) ? "" : $error["errQuantity"] . "</br>" ?>

        <input type="text" name="note" placeholder="Enter notes" value="<?php echo htmlspecialchars($item->note ?? '') ?>">

        <input type="submit" value="Submit">
    </form>
</body>

</html>
