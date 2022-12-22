<!DOCTYPE html>
<html>
<head> 
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
          top: -212px;
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
    if ($start >= $size)
    {
    ?>
    <form action="select.php" method = "get">
    <div class = menu>

        <input type = "hidden" name = "name" value = "<?php echo $name; ?>">
        <input type = "hidden" name = "start" value = "<?php echo $start - $size;?>">
        <!-- 前へ -->
        <input type = "hidden" name = "size" value = "<?php echo $size; ?>">
        <input type = "submit" name = "submitBtn" value = "前へ">
        <input type = "hidden" name = "len" value = "<?php echo $len; ?>">
    </div>
    <?php
    }
    else
    {
    ?>
    
    <div class = menu>
    <input type = "submit" name = "submitBtn" value = "前へ" disabled>
    </div>
    <?php
    }
    ?>
</form>

<!-- 次へ -->
    <?php 
    if ($start + $size < $len)
    {
    ?>
<form action = "select.php" method = "get">
    <div class = menu>
    <input type = "hidden" name = "name" value = "<?php echo $name; ?>">
    <input type = "hidden" name = "start" value = "<?php echo $start + $size; ?>">
    <input type = "hidden" name = "size" value = "<?php echo $size; ?>">
    <input type = "hidden" name = "len" value = "<?php echo $len; ?>">
    <input type = "submit" name = "submitBtn" value = "次へ">
    </div>
</form>
    <?php
    }
    else
    {
    ?>
    
    <div class = menu>
    <input type = "submit" name = "submitBtn" value = "次へ" disabled>
    </div>
    <?php
    }
    ?>

<form action = "insertSelect.php" method = "get">
    <div class = menu>
    <input type = "hidden" name = "name" value = "<?php echo $name; ?>">
    <input type = "hidden" name = "start" value = "<?php echo $start; ?>">
    <input type = "hidden" name = "size" value = "<?php echo $size; ?>">
    <input type = "submit" name = "submitBtn" value = "追加">
    </div>
</form>

<form action = "deleteselect.php" method = "get">
    <div class = menu>
    <input type = "hidden" name = "name" value = "<?php echo $name; ?>">
    <input type = "hidden" name = "start" value = "<?php echo $start; ?>">
    <input type = "hidden" name = "size" value = "<?php echo $size; ?>">
    <input type = "submit" name = "submitBtn" value = "削除">
    </div>
</form>

<form action = "wordselect.php" method = "get">
    <div class = menu>
    <input type="text" name="word" >
    <input type = "hidden" name = "name" value = "<?php echo $name; ?>">
    <input type = "hidden" name = "start" value="0">
    <input type = "hidden" name = "size" value="<?php echo $size; ?>">
    <input type = "hidden" name = "len" value = "<?php echo $len; ?>">
    <input type = "submit" name = "submitBtn" value = "検索">
    </div>
</form>

<?php
    // 出力
$cnt = $start;
foreach($result2 as $row) : ?>  
<?php
    echo "<div class = 'select'>";
    echo "<p>";
    $cnt += 1;
    echo ($cnt.", ");
    echo $row["productName"]."<br>";
    echo $row["price"].("円")."<br>";
    echo $row["orderDate"]."<br>";
    echo $row["status"]."<br>";
    echo $row["typeName"]."<br>";
    echo "</p>";
?>
<form action = "changeselect.php" method = "get">
    <input type = "hidden" name = "orderID" value = "<?php echo $row["orderID"]; ?>">
    <input type = "hidden" name = "name" value = "<?php echo $name; ?>">
    <input type = "hidden" name = "len" value = "<?php echo $len; ?>">
    <input type = "submit" name = "submitBtn" value = "変更">
    </div>
</form>


<?php endforeach; ?>


</body>
</html>

    