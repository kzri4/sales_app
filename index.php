<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

$sql='SELECT * FROM sales';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql='SELECT * FROM branch';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$branches = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql='SELECT * FROM staffs';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$staffs = $stmt->fetchAll(PDO::FETCH_ASSOC);

$arr = array(
    foreach ($sales as $sale){
        $sum = ($sale['sale']);
    }
);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charaset="UTF-8">
    <title>売上一覧</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<h1>売上一覧</h1>

<form action="" method="get">
    <div class="form">
        <div class="year">
            <lablel>年</lablel> 
            <select name="year"> 
                <option value="2018">2018</option>
                <option value="2019" selected>2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
            </select>
        </div>

        <div class="branch">
            <lablel>支店</lablel>
            <select name="branch"> 
                <option value="青森">青森</option>
                <option value="岩手" selected>岩手</option>
                <option value="アメリカ">アメリカ</option>
                <option value="パプアニューギニア">パプアニューギニア</option>
            </select>
        </div>

        <div class="staff">
            <lablel>従業員</lablel>
            <select name="staff"> 
                <option value="カカロット">カカロット</option>
                <option value="ベジータ" selected>ベジータ</option>
                <option value="ブロリー">ブロリー</option>
                <option value="フリーザ">フリーザ</option>
                <option value="魔神ブウ">魔神ブウ</option>
        </select><br>
        </div>
    </div>

    <div class="sub1">
        <input type="submit" name="sub1" value="検索">
    </div>
</form>

<table border="1">
    <tr>
        <th>年</th>
        <th>月</th>
        <th>支店</th>
        <th>従業員</th>
        <th>売上</th>
    </tr>
        <?php foreach ($sales as $sale):?>
        <?php foreach ($branches as $branch):?>
        <?php foreach ($staffs as $staff):?>
    <tr>
        <td width="300"><?= h($sale['year']) ?></td>
        <td width="300"><?= h($sale['month']) ?></td>
        <td width="300"><?= h($branch['name']) ?></td>
        <td width="300"><?= h($staff['name']) ?></td>
        <td width="300"><?= h($sale['sale']) ?></td>
    </tr>
        <?php endforeach; ?>
        <?php endforeach; ?>
        <?php endforeach; ?>
</table>







<h1 class="cal">合計:<?= $sum ?></h1>

</body>

</html>
