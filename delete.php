<?php
$dsn = 'sqlite:db/habdb.sqlite3'; //a+w(ディレクトリ)
// create table hab(id integer primary key, date_y integer, date_m integer, date_d integer, money integer, title text, memo text);
$db = new PDO($dsn);

// プレースホルダを使用
$query = 'delete from hab where id = :id';

try {
    // プレースホルダ付のSQLクエリの処理を準備
    $stmt = $db->prepare($query);
    // プレースホルダに値をセットして、クエリの処理を実行
    $stmt->execute(array(
        'id' => intval($_POST['id'])
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