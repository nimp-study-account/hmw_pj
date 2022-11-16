<?php

try {
    $dbh = new PDO("mysql:host=db_mysql;dbname=hmw_db", "nimp", "nimp3636");

    $allUsers = $dbh->query("SELECT * FROM tb_users;")->fetchAll(PDO::FETCH_ASSOC);


//   $dbh->prepare("DELETE FROM tb_users WHERE name = ?;")
//              ->execute(['Hmw User']);

//    $pwd = md5('123qwe');
//    $dbh->prepare("INSERT INTO tb_users (name, password) VALUES (?, ?)")
//        ->execute(['Hmw User', $pwd]);

    $allUsersWhere = $dbh->query("
                    SELECT name , IF(banned, 'true', 'false') banned , create_at, updated_at   
                    FROM hmw_db.tb_users 
                    where status in (1,0);
                ")->fetchAll(PDO::FETCH_OBJ);

    print_r($allUsersWhere);


} catch (\PDOException $e) {
    echo $e->getCode() .': ' . $e->getMessage() . ' ('.$e->getLine().')' . PHP_EOL;
}