<!DOCTYPE html>
<html>
<head> 
<?php
  $name = $_GET["name"];
  $start = $_GET["start"];
  $size = $_GET["size"];
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
    <form action="insert.php" method = "get">
      <div class = "change">
      <input type="text" name="productName" size="20" minlengh = "1" maxlengh="20" required>
      <input type="number" name="price" size="20" maxlengh="20" required>
      <input type="date" name="orderDate" size="20" maxlengh="20" required>
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
      <input type = "hidden" name = "name" value = "<?php echo $name; ?>">
      
      <input type="hidden" name="start" value="<?php echo $start; ?>">
      <input type="hidden" name="size" value="<?php echo $size; ?>">
      <br>
      <input type="submit" name="submitBtn" value="追加">
    </div>
  </form>

</body>
</html>

