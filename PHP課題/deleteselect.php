<!DOCTYPE html>
<html>
<head> 
    <?php
  $name = $_GET["name"];
  $start = intval($_GET["start"]);
  $size = intval($_GET["size"]);
?>
    <div class = menu>
    <p>ようこそ <?php echo $name ?> さん</p> 
    </div>
    <style>
    div {border: solid 2px #000;
        width: 280px;
        height: 12%;
        }
    .select {margin: 1px;
          text-align: center;
          background-color: beige;
          position: relative;
          top: -82px;
          left: 300px;
        }
    .menu{margin: 2px;
          text-align: center;
          background-color: rgb(213, 226, 247);
          position: relative;
          top: 10px;
          left: 0px;
        }
  </style>
    <meta charset = "utf-8">

    <title></title>
</head>
<body>
<?php
try {

    $pdo = new PDO(
        "mysql:host=localhost;dbname=php;charset=utf8;",
        "root",
        "",
        [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
    $query = "select * from php_order_table as `order` join php_user_table as user on `order`.orderUser = user.userID left join php_status_table as `status` on `order`.`orderStatus` = `status`.`statusID` left join php_type_table as type on `order`.typeID = type.typeID where Name = :name order by orderID limit :begin, :size";

    $stmt = $pdo->prepare($query);


    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":begin", $start, PDO::PARAM_INT);
    $stmt->bindParam(":size", $size, PDO::PARAM_INT);


    //SQL実行
    $stmt->execute();

    $result = $stmt->FETCHALL();
    if (empty($result)) {
        require_once("login.html");
    } else {
        $query2 = "select * from php_order_table as `order` join php_user_table as user on `order`.orderUser = user.userID left join php_status_table as `status` on `order`.`orderStatus` = `status`.`statusID`  left join php_type_table as type on `order`.typeID = type.typeID where Name = :name order by orderID limit :begin, :size";

        $stmt2 = $pdo->prepare($query2);
        $stmt2->bindParam(":begin", $start, PDO::PARAM_INT);
        $stmt2->bindParam(":size", $size, PDO::PARAM_INT);
        $stmt2->bindParam(":name", $name);
        $stmt2->execute();
        $result2 = $stmt2->fetchAll();

        //ホスト名取得
        $h = $_SERVER['HTTP_HOST'];
        echo "<div class = 'menu'>";

        // リファラ値があれば、かつ外部サイトでなければaタグで戻るリンクを表示

        if (!empty($_SERVER['HTTP_REFERER']) && (strpos($_SERVER['HTTP_REFERER'], $h) !== false)) {
            echo '<a href="' . $_SERVER['HTTP_REFERER'] . '">戻る</a>';
        }
        echo "</div>";

        // 出力
        $cnt = $start;
        foreach ($result as $row): ?>  
<?php
            echo "<div class = 'select'>";
            echo "<p>";
            $cnt += 1;
            echo ($cnt . ", ");
            echo $row["productName"] . "<br>";
            echo $row["price"] . ("円") . "<br>";
            echo $row["orderDate"] . "<br>";
            echo $row["status"] . "<br>";
            echo $row["typeName"] . "<br>";
            echo "</p>";
?>
<form action = "delete.php" method = "get">
    <input type = "hidden" name = "orderID" value = "<?php echo $row["orderID"]; ?>">
    <input type = "hidden" name = "name" value = "<?php echo $name; ?>">
    <input type = "hidden" name = "start" value = "<?php echo $start; ?>">
    <input type = "hidden" name = "size" value = "<?php echo $size; ?>">
    <input type = "submit" name = "submitBtn" value = "削除">
    </div>
</form>


<?php endforeach;
    }
} catch (PDOException $e) {
 // 例外処理
   require_once "exception_tpl.php";
   echo $e->getMessage();
   exit();
 }
 ?>

</body>
</html>

    