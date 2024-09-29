
<?php
    require "connection.php";
    require "item.php";
    try {
        $sql = "select * from item_sale order by id desc";
        $sttm = $conn->prepare($sql);
        $sttm->execute();
        $sttm->setFetchMode(PDO::FETCH_CLASS, "Item");
        $items = $sttm->fetchAll();
    } catch(PDOException $ex) {
        echo $ex->getMessage();
    }
?>
<button><a href="form.php">Add new</a></button>
<table style="width:1000px" border="1">
    <tr>
        <th>ID</th>
        <th>Item code</th>
        <th>Item Name</th>
        <th>Quantity</th>
        <th>Expired date</th>
        <th>Note</th>
        <th>Action</th>
    </tr>
    <?php foreach($items as $item) : ?>
    <tr>
        <th><?=$item->id ?></th>
        <th><?=$item->item_code ?></th>
        <th><?=$item->item_name ?></th>
        <th><?=$item->quantity ?></th>
        <th><?=$item->expired_date ?></th>
        <th><?=$item->note ?></th>
        <th><a href="form.php?id=<?=$item->id ?>">Edit</a> || Delete</th>
    </tr>   
    <?php endforeach ?>
</table>