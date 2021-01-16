<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

$sql =
    'SELECT
        sales.year,
        sales.month,
        staffs.name as staff_name,
        branches.name as branch_name,
        sales.sale
    FROM 
        sales
    INNER JOIN staffs
        ON sales.staff_id = staffs.id
    INNER JOIN branches
        ON staffs.branch_id = branches.id';

$stmt = $dbh->prepare($sql);
$stmt->execute();
$sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql ='SELECT * FROM staffs';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$staffs = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql ='SELECT * FROM branches';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$branches = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sum = 0;
foreach ($sales as $sale){
$sum += $sale['sale'];
}

$year = $_GET['year'];
$branch = $_GET['branch'];
$staff = $_GET['staff'];


if (isset($year)){
    $sql = 
        'SELECT
            sales.year,
            sales.month,
            staffs.name as staff_name,
            branches.name as branch_name,
            sales.sale
        FROM
            sales
        INNER JOIN staffs
            ON sales.staff_id = staffs.id
        INNER JOIN branches
            ON staffs.branch_id = branches.id
        WHERE sales.year = :year';
    
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':year', $year , PDO::PARAM_INT);
    $stmt->execute();
    $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $sum = 0;
    foreach ($sales as $sale){
        $sum += $sale['sale'];
    }
    
}else if(isset($branch)){
    $sql = 
        'SELECT
            sales.year,
            sales.month,
            staffs.name as staff_name,
            branches.name as branch_name,
            sales.sale
        FROM
            sales
        INNER JOIN staffs
            ON sales.staff_id = staffs.id
        INNER JOIN branches
            ON staffs.branch_id = branches.id
        WHERE branches.id = :branch_id';
    
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':branch_id', $branch , PDO::PARAM_INT);
    $stmt->execute();
    $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $sum = 0;
    foreach ($sales as $sale){
        $sum += $sale['sale'];
    }

}else if(isset($staff)){
    $sql = 
        'SELECT
            sales.year,
            sales.month,
            staffs.name as staff_name,
            branches.name as branch_name,
            sales.sale
        FROM
            sales
        INNER JOIN staffs
            ON sales.staff_id = staffs.id
        INNER JOIN branches
            ON staffs.branch_id = branches.id
        WHERE staffs.id = :staff_id';
    
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':staff_id', $staff, PDO::PARAM_INT);
    $stmt->execute();
    $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $sum = 0;
    foreach ($sales as $sale){
        $sum += $sale['sale'];
    }

}else if ((isset($year))&&(isset($branch))){
    $sql = 
        'SELECT
            sales.year,
            sales.month,
            staffs.name as staff_name,
            branches.name as branch_name,
            sales.sale
        FROM
            sales
        INNER JOIN staffs
            ON sales.staff_id = staffs.id
        INNER JOIN branches
            ON staffs.branch_id = branches.id
        WHERE sales.year = :year
        AND staffs.id = :staff_id';
    
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    $stmt->bindParam(':branch_id', $branch, PDO::PARAM_INT); 
    $stmt->execute();
    $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $sum = 0;
    foreach ($sales as $sale){
        $sum += $sale['sale'];
    }

}else if ((isset($year))&&(isset($staff))){
    $sql = 
        'SELECT
            sales.year,
            sales.month,
            staffs.name as staff_name,
            branches.name as branch_name,
            sales.sale
        FROM
            sales
        INNER JOIN staffs
            ON sales.staff_id = staffs.id
        INNER JOIN branches
            ON staffs.branch_id = branches.id
        WHERE sales.year = :year
        AND staffs.id = :staff_id';
    
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    $stmt->bindParam(':staff_id', $staff, PDO::PARAM_INT);
    $stmt->execute();
    $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $sum = 0;
    foreach ($sales as $sale){
        $sum += $sale['sale'];
    }

}else if ((isset($branch))&&(isset($staff))){
    $sql = 
        'SELECT
            sales.year,
            sales.month,
            staffs.name as staff_name,
            branches.name as branch_name,
            sales.sale
        FROM
            sales
        INNER JOIN staffs
            ON sales.staff_id = staffs.id
        INNER JOIN branches
            ON staffs.branch_id = branches.id
        WHERE sales.year = :year
        AND staffs.id = :staff_id';
    
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':branch_id', $branch, PDO::PARAM_INT); 
    $stmt->bindParam(':staff_id', $staff, PDO::PARAM_INT);
    $stmt->execute();
    $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $sum = 0;
    foreach ($sales as $sale){
        $sum += $sale['sale'];
    }
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
            <input type = "number" name = "year" value="<?php if (isset($_GET['year'])){echo $_GET['year'];} ?>"> 
        </div>

        <div class="branch">
            <lablel>支店</lablel>
            <select name = "branch">
                <option value="0"> </option>
                <?foreach ($branches as $branch):?>
                <option value = "<?= h($branch['id']) ?>"
                    <?php if ($_GET['branch'] == $branch['id']){echo "selected";}?>><?= h($branch['name']) ?>
                </option>
                <?endforeach;?>
            </select>
        </div>

        <div class="staff">
            <lablel>従業員</lablel>
            <select name = "staff"> 
                <option value="0"> </option>
                <?foreach ($staffs as $staff):?>
                <option value ="<?= h($staff['id']) ?>"
                    <?php if ($_GET['staff'] == $staff['id']){echo "selected";}?>><?= h($staff['name']) ?>
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