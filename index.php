<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

$sql = 'SELECT
        sales.year,sales.month,branches.name,staffs.name,sales.sale
        FROM 
        sales
        inner JOIN staffs
        ON sales.staff_id = staffs.id
        inner JOIN branches
        ON staffs.branch_id = branches.id' ;

$stmt = $dbh->prepare($sql);
$stmt->execute();
$sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sum = 0;
foreach ($sales as $sale){
$sum += $sale['sale'];

}

/*
if (isset($_GET['year'])){
    $sql = 'SELECT year FROM sales';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_GET['staff'])){
    $sql = 'SELECT staffs.name,branches.name
            FROM staffs
            INNER JOIN branches
            ON staffs.branch_id = branches.id;' ;
    $stmt = $dbh->prepare($sql);
    $staffs = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
*/

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

<form action="" method="GET">
    <div class="form">
        <div class="year">
            <lablel>年</lablel> 
            <select name="year"> 
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020"selected>2020</option>
                <option value="2021">2021</option>
            </select>
        </div>

        <div class="branch">
            <lablel>支店</lablel>
            <select name="branch"> 
                <option value="岩手">岩手</option>
                <option value="東京" selected>東京</option>
                <option value="福岡">福岡</option>
                <option value="徳島">徳島</option>
                <option value="北海道">北海道</option>
            </select>
        </div>

        <div class="staff">
            <lablel>従業員</lablel>
            <select name="staff"> 
                <option value="田中">田中</option>
                <option value="山田" selected>山田</option>
                <option value="渡辺">渡辺</option>
                <option value="松田">松田</option>
                <option value="野中">野中</option>
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
    <tr>
        <td width="300"><?= h($sale['year']) ?></td>
        <td width="300"><?= h($sale['month']) ?></td>
        <td width="300"><?= h($sale['name']) ?></td>
        <td width="300"><?= h($sale['name']) ?></td>
        <td width="300"><?= h($sale['sale']) ?></td>
    </tr>
</table>

<h1 class="cal">合計:<?= $sum ?></h1>

</body>
</html>