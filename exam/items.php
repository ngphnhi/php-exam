<?php
require "connection.php";

$query = "SELECT * FROM item_sale";
$stmt = $pdo->prepare($query);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<button><a href="item_form.php"> Add New</a></button>
<table style="width:1000px" border="1">
    <tr>
        <th>ID</th>
        <th>Item Code</th>
        <th>Item Name</th>
        <th>Quantity</th>
        <th>Expired date</th>
        <th>Note</th>
        <th>Action</th>
    </tr>
    <?php foreach($items as $item) : ?>
    <tr>
        <th><?= $item['id'] ?></th>
        <th><?= $item['item_code'] ?></th>
        <th><?= $item['item_name'] ?></th>
        <th><?= $item['quantity'] ?></th>
        <th><?= $item['expired_date'] ?></th>
        <th><?= $item['note'] ?></th>
        <th><a href="item_form.php?id=<?= $item['id'] ?>">Edit</a> || Delete</th>
    </tr>   
    <?php endforeach ?>
</table>
</body>
</html>
