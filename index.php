<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

$sql = 'SELECT
        sales.year,
        sales.month,
        branches.name as branch_name,
        staffs.name as staff_name,
        sales.sale
        FROM 
        sales
        inner JOIN staffs
        ON sales.staff_id = staffs.id
        inner JOIN branches
        ON staffs.branch_id = branches.id';

$stmt = $dbh->prepare($sql);
$stmt->execute();
$sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sum = 0;
foreach ($sales as $sale){
$sum += $sale['sale'];
}

if (isset($_GET['year'])&&($_GET['branch'])&&($_GET['staff'])){
    $sql = 'SELECT
        sales.year,
        sales.month,
        branches.name as branch_name,
        staffs.name as staff_name,
        sales.sale
        FROM 
        sales
        inner JOIN staffs
        ON sales.staff_id = staffs.id
        inner JOIN branches
        ON staffs.branch_id = branches.id 
        WHERE year = 1 AND branch_name = 2 AND staff_name =3';
    
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
}


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
                <?foreach ($sales as $sale):?>
                <option value = 1 
                <?php echo array_key_exists('year', $_GET) 
                && $_GET['year'] == '1'?'selected':'';?>>
                <?= h($sale['year']) ?>
                </option>
                <?endforeach;?>
            </select>
        </div>

        <div class="branch">
            <lablel>支店</lablel>
            <select name="branch"> 
                <?foreach ($sales as $sale):?>
                <option value = 2
                <?php echo array_key_exists('branch', $_GET) 
                && $_GET['branch'] == '2'?'selected':'';?>>
                <?= h($sale['branch_name']) ?>
                </option>
                <?endforeach;?>
            </select>
        </div>

        <div class="staff">
            <lablel>従業員</lablel>
            <select name="staff"> 
                <?foreach ($sales as $sale):?>
                <option value = 3
                <?php echo array_key_exists('staff', $_GET) 
                && $_GET['staff'] == '3'?'selected':'';?>>
                <?= h($sale['staff_name']) ?>
            </option>
                <?endforeach;?>

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
    <?foreach ($sales as $sale):?>
    <tr>
        <td width="300"><?= h($sale['year']) ?></td>
        <td width="300"><?= h($sale['month']) ?></td>
        <td width="300"><?= h($sale['branch_name']) ?></td>
        <td width="300"><?= h($sale['staff_name']) ?></td>
        <td width="300"><?= h($sale['sale']) ?></td>
    </tr>
    <?endforeach;?>
    
</table>

<h1 class="cal">合計:<?= $sum ?></h1>

</body>
</html>