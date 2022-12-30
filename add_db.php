<?php
$dsn = 'sqlite:/home/atsushi/household_account_book/db/habdb.sqlite3'; //a+w(ディレクトリ)
// create table hab(id integer primary key, date_y integer, date_m integer, date_d integer, money integer, title text, memo text);
$db = new PDO($dsn);

// プレースホルダを使用
$query = 'insert into hab(date_y, date_m, date_d, money, title, memo) values(:y, :m, :d, :money, :title, :memo)';

try {
    $yyyymmdd = explode("-", $_POST['date']);
    // プレースホルダ付のSQLクエリの処理を準備
    $stmt = $db->prepare($query);
    // プレースホルダに値をセットして、クエリの処理を実行
    $stmt->execute(array(
        'y' => intval($yyyymmdd[0]),
        'm' => intval($yyyymmdd[1]),
        'd' => intval($yyyymmdd[2]),
        'money' => intval($_POST['money']) * intval($_POST['type']),
        'title' => $_POST['title'],
        'memo' => $_POST['memo']
    ));
} catch (PDOException $e) {
    echo "エラー!: " . $e->getMessage() . "<br/>";
}
//接続を閉じる
$db = null;
?>
<script type="text/javascript">
    window.location.href = "home.php";
</script>