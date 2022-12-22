<!DOCTYPE html>
<html>
<head> 
<?php
  $orderID = $_GET["orderID"];
  $productName = $_GET["productName"];
  $price = $_GET["price"];
  $orderDate = $_GET["orderDate"];
  $status = $_GET["status"];
  $type = $_GET["type"];
  $name = $_GET["name"];
  $start = $_GET["start"];
  $size = $_GET["size"];
try {

  $pdo = new PDO(
    "mysql:host=localhost;dbname=php;charset=utf8;",
    "root",
    "",
    [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
  );

  //SQL
  $query = "update php_order_table set 
  productName = :productName, 
  price = :price, 
  orderDate = :orderDate, 
  orderstatus = :status, 
  typeID = :type 
  where orderID = :orderID";

  $stmt = $pdo->prepare($query);
  $stmt->bindValue(":productName", $productName);
  $stmt->bindValue(":price", $price);
  $stmt->bindValue(":orderDate", $orderDate);
  $stmt->bindValue(":status", $status);
  $stmt->bindValue(":type", $type);
  $stmt->bindValue(":orderID", $orderID);

  $stmt->execute();

  
  $query2 = "select * from php_order_table as `order` join php_user_table as user on `order`.orderUser = user.userID left join php_status_table as `status` on `order`.`orderStatus` = `status`.`statusID`  left join php_type_table as type on `order`.typeID = type.typeID where Name = :name order by orderID limit :begin, :size";

  $stmt2 = $pdo->prepare($query2);
  $stmt2->bindParam(":begin", $start, PDO::PARAM_INT);
  $stmt2->bindParam(":size", $size, PDO::PARAM_INT);
  $stmt2->bindParam(":name", $name);
  $stmt2->execute();
  $result2 = $stmt2->fetchAll();

  $query3 = "select * from php_order_table as `order`
  join php_user_table as `user` on `order`.orderUser = user.userID 
  where Name = :name ";

  $stmt3 = $pdo->prepare($query3);
  $stmt3->bindParam(":name", $name);
  $stmt3->execute();

  $len = $stmt3->rowCount();



  require_once "viewSelect_tpl.php";
}
   catch (PDOException $e) {
 // 例外処理
   require_once "exception_tpl.php";
   echo $e->getMessage();
   exit();
 }


?>
</head>
</html>