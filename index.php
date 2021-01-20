<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

$year = $_GET['year'];
$branch = $_GET['branch'];
$staff = $_GET['staff'];

$sql = <<< EOM
    SELECT
        s.year,
        s.month,
        st.name as staff_name,
        b.name as branch_name,
        s.sale
    FROM
        sales s
    INNER JOIN staffs st
        ON s.staff_id = st.id
    INNER JOIN branches b
        ON st.branch_id = b.id
EOM;

$where_sql = '';

if ($year) {
    $where_sql .= 's.year = :year';
}

if ($branch) {
    if ($where_sql) {
        $where_sql .= ' AND ';
    }
    $where_sql .= 'b.id = :branch_id';
}

if ($staff) {
    if ($where_sql) {
        $where_sql .= ' AND ';
    }
    $where_sql .= 'st.id = :staff_id';
}

if ($where_sql) {
    $where_sql = 'WHERE ' . $where_sql;
}

$sql .= ' ' . $where_sql;

$sql .= <<< EOM
        ORDER BY 
            s.year ASC,
            s.month ASC,
            b.name ASC,
            st.name ASC
EOM;

$stmt = $dbh->prepare($sql);
if ($year) {
    $stmt->bindParam(':year', $year , PDO::PARAM_INT);
}
if ($branch) {
    $stmt->bindParam(':branch_id', $branch , PDO::PARAM_INT);
}
if ($staff) {
    $stmt->bindParam(':staff_id', $staff , PDO::PARAM_INT);
}
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
foreach ($sales as $sale) {
$sum += $sale['sale'];
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
            <input type = "number" name = "year" value="<?php if ($year){echo $year;} ?>"> 
        </div>

        <div class="branch">
            <lablel>支店</lablel>
            <select name = "branch">
                <option value=""></option>
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
                <option value=""></option>
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

    <?$sum = 0;?>
    <?foreach ($sales as $sale):?>
    <tr>
        <td width="300"><?= h($sale['year']) ?></td>
        <td width="300"><?= h($sale['month']) ?></td>
        <td width="300"><?= h($sale['branch_name']) ?></td>
        <td width="300"><?= h($sale['staff_name']) ?></td>
        <td width="300"><?= h($sale['sale']) ?></td>
    </tr>
    <?$sum += $sale['sale']?>
    <?endforeach;?>
</table>

<h1 class="cal">合計:<?= number_format($sum) ?>万円</h1>

</body>
</html>