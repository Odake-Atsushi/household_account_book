ディレクトリとデータベースのパーミッションを変更

db a+w


データベース生成
```
sqlite3 habdb.sqlite3
```

テーブル作成
```
create table hab(id integer primary key, date_y integer, date_m integer, date_d integer, money integer, title text, memo text);
```

sqlite3のターミナルから抜けるには
```
.exit
```