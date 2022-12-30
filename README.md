# household_account_book
web 家計簿

データベースはsqlite3

db/habdb.sqlite3
```
create table hab(id integer primary key, date_y integer, date_m integer, date_d integer, money integer, title text, memo text);
```

db a+w