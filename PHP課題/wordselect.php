<?php
  $word = $_GET["word"];
  $name = $_GET["name"];
  $start = intval($_GET["start"]);
  $size = intval($_GET["size"]);

  try {

      $pdo = new PDO(
        "mysql:host=localhost;dbname=php;charset=utf8;",
        "root",
        "",
        [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
      );
      
  //SQL
  $query = "select * 
  from php_order_table as `order` 
  join php_user_table as user on `order`.orderUser = user.userID 
  left join php_status_table as `status` on `order`.`orderStatus` = `status`.`statusID` 
  left join php_type_table as type on `order`.typeID = type.typeID 
  where Name = :name 
  and productName like '%".$_GET["word"]."%'
  order by orderID limit :begin, :size";

  $stmt = $pdo->prepare($query);


  $stmt->bindParam(":name", $name);
  $stmt->bindParam(":begin", $start, PDO::PARAM_INT);
  $stmt->bindParam(":size", $size, PDO::PARAM_INT);

  //SQL実行
  $stmt->execute();

  $result = $stmt->FETCHALL();
  if(empty($result)) {
    echo "条件に一致する商品がありませんでした";
    echo "<br>";
    
        //ホスト名取得
        $h = $_SERVER['HTTP_HOST'];
        // リファラ値があれば、かつ外部サイトでなければaタグで戻るリンクを表示

        if (!empty($_SERVER['HTTP_REFERER']) && (strpos($_SERVER['HTTP_REFERER'], $h) !== false)) {
            echo '<a href="' . $_SERVER['HTTP_REFERER'] . '">戻る</a>';
        }
  }
  else {
    $query2 = "select * 
    from php_order_table as `order` 
    join php_user_table as user on `order`.orderUser = user.userID 
    left join php_status_table as `status` on `order`.`orderStatus` = `status`.`statusID`  
    left join php_type_table as type on `order`.typeID = type.typeID
    where Name = :name 
    and productName like '%".$_GET["word"]."%'
    order by orderID limit :begin, :size";
  
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
  
    $query4 = "select * from php_order_table as `order`
    join php_user_table as `user` on `order`.orderUser = user.userID 
    where Name = :name 
    and productName like '%".$_GET["word"]."%'";

    $stmt4 = $pdo->prepare($query4);
    $stmt4->bindParam(":name", $name);
    $stmt4->execute();
  
    $len2 = $stmt4->rowCount();
  

  


    require_once "viewwordselect_tpl.php";
  }

  } catch (PDOException $e) {
  // 例外処理
    require_once "exception_tpl.php";
    echo $e->getMessage();
    exit();
  }

?>