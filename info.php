<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>家計簿</title>
</head>

<body>
    <h1>家計簿　詳細</h1>
    <?php
    $dsn = 'sqlite:db/habdb.sqlite3'; //a+w(ディレクトリ)
    // create table hab(id integer primary key, date_y integer, date_m integer, date_d integer, money integer, title text, memo text);
    $db = new PDO($dsn);

    // プレースホルダを使用
    // $query = 'insert into hab(date_y, date_m, date_d, money, title, memo) values(:y, :m, :d, :money, :title, :memo)';
    $query_info = 'select id,date_y,date_m,date_d,money,title,memo from hab where id = :id;';

    try {
        // プレースホルダ付のSQLクエリの処理を準備
        $stmt = $db->prepare($query_info);
        // プレースホルダに値をセットして、クエリの処理を実行
        $stmt->execute(array(
            'id' => intval($_GET['id'])
        ));
    } catch (PDOException $e) {
        echo "エラー!: " . $e->getMessage() . "<br/>";
    }
    // 詳細表示
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<h3>日付</h3>";
        echo "<p>", $row['date_y'], "/", $row['date_m'], "/", $row['date_d'], "</p>";
        echo "<h3>用途</h3>";
        echo "<p>", $row['title'], "</p>";
        echo "<h3>金額</h3>";
        if (intval($row['money']) > 0) {
            echo "<p>収入\t", abs(intval($row['money'])), "円</p>";
        } else {
            echo "<p>支出\t", abs(intval($row['money'])), "円</p>";
        }
        echo "<h3>メモ</h3>";
        echo "<p>", $row['memo'], "</p>";

        echo "<form action=\"config.php\" method=\"post\">";
        echo "\t<button type=\"submit\" name=\"id\" value=", $row['id'], ">変更</button>";
        echo "</form>";
    }

    //接続を閉じる
    $db = null;
    ?>

    <a href="home.php">HOMEへ戻る</a>
</body>

</html>