<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>家計簿</title>
</head>

<body>
    <h1>家計簿</h1>

    <?php
    $dsn = 'sqlite:/home/atsushi/household_account_book/db/habdb.sqlite3'; //a+w(ディレクトリ)
    // create table hab(id integer primary key, date_y integer, date_m integer, date_d integer, money integer, title text, memo text);
    $db = new PDO($dsn);

    $yyyy = intval(date("Y"));
    $mm = intval(date("n"));
    $dd = intval(date("j"));
    ?>
    <form action="home.php" method="post">
        <?php
        // プレースホルダを使用
        // $query = 'insert into hab(date_y, date_m, date_d, money, title, memo) values(:y, :m, :d, :money, :title, :memo)';
        $query_y =  'select distinct date_y from hab order by date_y desc;';

        try {
            // プレースホルダ付のSQLクエリの処理を準備
            $stmt = $db->prepare($query_y);
            // プレースホルダに値をセットして、クエリの処理を実行
            $stmt->execute();
        } catch (PDOException $e) {
            echo "エラー!: " . $e->getMessage() . "<br/>";
        }
        // 年
        echo "<select name=\"year\">";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (intval($row['date_y']) == $yyyy) {
                echo "<option value=", $row['date_y'], " selected>", $row['date_y'], "</option>";
            } else {
                echo "<option value=", $row['date_y'], ">", $row['date_y'], "</option>";
            }
        }
        echo "</select>年";
        ?>
        <?php
        // 月
        echo "<select name=\"month\">";
        for ($i = 1; $i <= 12; $i++) {
            if ($i == $mm) {
                echo "<option value=", $i, " selected>", $i, "</option>";
            } else {
                echo "<option value=", $i, ">", $i, "</option>";
            }
        }
        echo "</select>月";
        ?>
        <?php
        // 日
        echo "<select name=\"date\">";
        echo "<option value=0 selected>全て</option>";
        for ($i = 1; $i <= 31; $i++) {
            echo "<option value=", $i, ">", $i, "</option>";
        }
        echo "</select>日";
        ?>
        <button type="submit" id="id">更新</button>
    </form>

    <?php
    // プレースホルダを使用
    // $query = 'insert into hab(date_y, date_m, date_d, money, title, memo) values(:y, :m, :d, :money, :title, :memo)';
    $query =  "select id, date_y, date_m, date_d, money, title from hab where date_y = :y and date_m = :m"; // and date_d = :d;";
    $query_sum = "select sum(money) as ms from hab where date_y = :y and date_m = :m";

    try {
        if (isset($_POST['year']) == false && isset($_POST['month']) == false && isset($_POST['date']) == false) {
            // プレースホルダ付のSQLクエリの処理を準備
            $stmt = $db->prepare($query);
            $stmt_sum = $db->prepare($query_sum);
            // プレースホルダに値をセットして、クエリの処理を実行
            $stmt->execute(array(
                'y' => intval($yyyy),
                'm' => intval($mm)
            ));
            $stmt_sum->execute(array(
                'y' => intval($yyyy),
                'm' => intval($mm)
            ));
        } elseif (intval($_POST['date']) == 0) { //all
            // プレースホルダ付のSQLクエリの処理を準備
            $stmt = $db->prepare($query);
            $stmt_sum = $db->prepare($query_sum);
            // プレースホルダに値をセットして、クエリの処理を実行
            $stmt->execute(array(
                'y' => intval($_POST['year']),
                'm' => intval($_POST['month'])
            ));
            $stmt_sum->execute(array(
                'y' => intval($_POST['year']),
                'm' => intval($_POST['month'])
            ));
        } else {
            $query .= " and date_d = :d;";
            // プレースホルダ付のSQLクエリの処理を準備
            $stmt = $db->prepare($query);
            $stmt_sum = $db->prepare($query_sum);
            // プレースホルダに値をセットして、クエリの処理を実行
            $stmt->execute(array(
                'y' => intval($_POST['year']),
                'm' => intval($_POST['month']),
                'd' => intval($_POST['date'])
            ));
            $stmt_sum->execute(array(
                'y' => intval($_POST['year']),
                'm' => intval($_POST['month']),
                'd' => intval($_POST['date'])
            ));
        }
    } catch (PDOException $e) {
        echo "エラー!: " . $e->getMessage() . "<br/>";
    }
    // 表
    echo "<table border=\"1\">";
    while ($row = $stmt_sum->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<th>日付</th> <th>用途</th> <th>合計：", $row['ms'], "円</th>";
        echo "<th></th>";
        echo "</tr>";
    }
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<th>", $row['date_y'], "/", $row['date_m'], "/", $row['date_d'], "</th> <th>", $row['title'], "</th> <th>", $row['money'], "</th>";
        echo "<th> <form action=\"info.php\" method=\"get\"> <button type=\"submit\" name=\"id\" value=", $row['id'], ">詳細</button> </form> </th>";
        echo "</tr>";
        $data_count += 1;
    }
    echo "</table>";
    ?>

    <?php
    //接続を閉じる
    $db = null;
    ?>

    <a href="add.php">データ追加</a>
</body>

</html>