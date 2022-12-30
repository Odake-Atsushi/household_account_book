<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>データ追加</title>
</head>

<body>
    <h1>データ追加</h1>
    <?php
    $yyyy = sprintf("%04d", intval(date("Y")));
    $mm = sprintf("%02d", intval(date("n")));
    $dd = sprintf("%02d", intval(date("j")));
    $yyyymmdd = $yyyy . "-" . $mm . "-" . $dd;
    ?>
    <form action="add_db.php" method="post">
        <p>日付
            <input type="date" name="date" id="today" required="required" value=<?= $yyyymmdd ?>>
        </p>

        <p>
            <input type="radio" name="type" value=-1 required="required"> 支出
            <input type="radio" name="type" value=1 required="required"> 収入
        </p>

        <p>金額
            <input type="number" name="money" min="1" required="required">
        </p>

        <p>用途
            <input type="text" name="title">
        </p>

        <p>メモ
            <!-- <input type="text" name="memo"> -->
            <textarea id="memo" name="memo"></textarea>
        </p>

        <input type="submit" value="追加" />
    </form>
</body>

</html>