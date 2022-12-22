<!DOCTYPE html>
<html>
<head> 
<?php
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
  $query = "select * from php_user_table where Name = :name";

  $stmt = $pdo->prepare($query);

  $stmt->bindValue(":name", $name);

  //SQL実行
  $stmt->execute();

  $result = $stmt->FETCHALL();
    foreach ($result as $row) {
        $orderuserID = $row["userID"];
    }
  //SQL
  $query2 = "insert into php_order_table 
  (orderDate, orderStatus, orderUser, typeID, productName, price) 
  values (:orderDate,:status,:orderuserID,:type,:productName,:price )";
  
  $stmt2 = $pdo->prepare($query2);
  $stmt2->bindValue(":orderDate", $orderDate);
  $stmt2->bindValue(":status", $status);
  $stmt2->bindValue(":orderuserID", $orderuserID);
  $stmt2->bindValue(":type", $type);
  $stmt2->bindValue(":productName", $productName);
  $stmt2->bindValue(":price", $price);
  $stmt2->execute();

  
  $query3 = "select * from php_order_table as `order` 
  join php_user_table as user on `order`.orderUser = user.userID 
  left join php_status_table as `status` on `order`.`orderStatus` = `status`.`statusID`  
  left join php_type_table as type on `order`.typeID = type.typeID 
  where Name = :name 
  order by orderID 
  limit :begin, :size";

  $stmt3 = $pdo->prepare($query3);
  $stmt3->bindParam(":begin", $start, PDO::PARAM_INT);
  $stmt3->bindParam(":size", $size, PDO::PARAM_INT);
  $stmt3->bindParam(":name", $name);
  $stmt3->execute();
  $result2 = $stmt3->fetchAll();

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