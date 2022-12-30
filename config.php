<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>データ追加</title>

    <script type="text/javascript">
        function check_c() {
            if (window.confirm('変更してもよろしいですか？')) { // 確認ダイアログを表示
                return true; // 「OK」時は送信を実行
            } else { // 「キャンセル」時の処理
                window.alert('キャンセルされました'); // 警告ダイアログを表示
                return false; // 送信を中止
            }
        }
    </script>
    <script type="text/javascript">
        function check_d() {
            if (window.confirm('削除してもよろしいですか？')) { // 確認ダイアログを表示
                return true; // 「OK」時は送信を実行
            } else { // 「キャンセル」時の処理
                window.alert('キャンセルされました'); // 警告ダイアログを表示
                return false; // 送信を中止
            }
        }
    </script>
</head>

<body>
    <h1>データ変更</h1>
    <?php
    $dsn = 'sqlite:/home/atsushi/household_account_book/db/habdb.sqlite3'; //a+w(ディレクトリ)
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
            'id' => intval($_POST['id'])
        ));
    } catch (PDOException $e) {
        echo "エラー!: " . $e->getMessage() . "<br/>";
    }
    // 詳細表示
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $yyyy = sprintf('%04d', intval($row['date_y']));
        $mm = sprintf('%02d', intval($row['date_m']));
        $dd = sprintf('%02d', intval($row['date_d']));
        $money = $row['money'];
        $title = $row['title'];
        $memo = $row['memo'];
        $id = $row['id'];
    }
    $yyyymmdd = $yyyy . "-" . $mm . "-" . $dd;

    //接続を閉じる
    $db = null;
    ?>

    <form action="change.php" method="post" onSubmit="return check_c()">
        <p>日付
            <input type="date" name="date" required="required" value=<?= $yyyymmdd ?>>
        </p>

        <p>
            <?php
            if ($money > 0) {
                echo "<input type=\"radio\" name=\"type\" value=-1 required=\"required\"> 支出";
                echo "<input type=\"radio\" name=\"type\" value=1 required=\"required\" checked> 収入";
            } else {
                echo "<input type=\"radio\" name=\"type\" value=-1 required=\"required\" checked> 支出";
                echo "<input type=\"radio\" name=\"type\" value=1 required=\"required\"> 収入";
            }
            ?>
        </p>

        <p>金額
            <input type="number" name="money" min="1" required="required" value=<?= abs($money) ?>>
        </p>

        <p>用途
            <input type="text" name="title" value=<?= $title ?>>
        </p>

        <p>メモ
            <!-- <input type="text" name="memo"> -->
            <textarea id="memo" name="memo" value=<?= $memo ?>></textarea>
        </p>

        <button type="submit" name="id" value=<?= $id ?>>変更の実行</button>
    </form>

    <form action="delete.php" method="post" onSubmit="return check_d()">
        <button type="submit" name="id" value=<?= $id ?>>削除</button>
    </form>

    <a href="home.php">HOMEへ戻る</a>
</body>

</html>