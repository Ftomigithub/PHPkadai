<!DOCTYPE html>
<html>
<head> 
<?php
  $orderID = $_GET["orderID"];
  $name = $_GET["name"];
?>
    <style>
    div {border: solid 2px #000;
        width: 280px;
        height: 12%;
        }
    .menu{margin: 2px;
        text-align: center;
        background-color: rgb(213, 226, 247);
        position: relative;
        top: 10px;
        left: 0px;
        }
    .change{margin: 1px;
          text-align: center;
          background-color: beige;
          position: relative;
          top: -82px;
          left: 300px;
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
//SQL
$query = "select * from php_order_table as `order` join php_user_table as user on `order`.orderUser = user.userID left join php_status_table as `status` on `order`.`orderStatus` = `status`.`statusID` left join php_type_table as type on `order`.typeID = type.typeID where `order`.orderID = :orderID";

$stmt = $pdo->prepare($query);
  $stmt->bindValue(":orderID", $orderID);

  //SQL実行
  $stmt->execute();
  $result = $stmt->FETCHALL();
  foreach ($result as $row) : ?>  

    <div class = menu>
    <p>ようこそ <?php echo $name ?> さん</p> 
    </div>
    <div class = menu>
    <?php
        //ホスト名取得
        $h = $_SERVER['HTTP_HOST'];
        // リファラ値があれば、かつ外部サイトでなければaタグで戻るリンクを表示

        if (!empty($_SERVER['HTTP_REFERER']) && (strpos($_SERVER['HTTP_REFERER'], $h) !== false)) {
            echo '<a href="' . $_SERVER['HTTP_REFERER'] . '">戻る</a>';
        }
    ?>
    </div>
    <form action="update.php" method = "get">
      <div class = "change">
      <input type="text" name="productName" size="20" minlengh = "1" maxlengh="20" value="<?php echo $row["productName"]; ?>" required>
      <input type="number" name="price" min = "0" size="20" maxlengh="20" value="<?php echo $row["price"]; ?>" required>
      <input type="date" name="orderDate" size="20" maxlengh="20" value="<?php echo $row["orderDate"]; ?>" required>
      <br>
      <select name="status" size="1">
        <option value= 1>発注済</option>
        <option value= 2>納品済</option>
        <option value= 3>未発注</option>
      </select>
      <br>
      <select name="type" size="1">
        <option value="1">書籍</option>
        <option value="2">文房具</option>
        <option value="3">CD</option>
      </select>
      <input type = "hidden" name = "orderID" value = "<?php echo $orderID; ?>">
      <input type = "hidden" name = "name" value = "<?php echo $name; ?>">
      
      <input type="hidden" name="start" value="0">
      <input type="hidden" name="size" value="5">
      <br>
      <input type="submit" name="submitBtn" value="変更完了">
    </div>
  </form>

<?php
  endforeach; 
 } catch (PDOException $e) {
  // 例外処理
    require_once "exception_tpl.php";
    echo $e->getMessage();
    exit();
  }





?>
</body>
</html>

