<?php
$dsn = 'sqlite:/home/atsushi/household_account_book/db/habdb.sqlite3'; //a+w(ディレクトリ)
// create table hab(id integer primary key, date_y integer, date_m integer, date_d integer, money integer, title text, memo text);
$db = new PDO($dsn);

// プレースホルダを使用
$query = "update hab set date_y=:y,date_m=:m,date_d=:d,money=:money,title=:title,memo=:memo where id=:id";

try {
    $yyyymmdd = explode("-", $_POST['date']);
    // プレースホルダ付のSQLクエリの処理を準備
    $stmt = $db->prepare($query);
    // プレースホルダに値をセットして、クエリの処理を実行
    $stmt->execute(array(
        'id' => intval($_POST['id']),
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
    window.location.href = "info.php?id=<?= intval($_POST['id']) ?>";
</script>