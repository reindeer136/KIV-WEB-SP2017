<?php

    // pripojeni k DB
    // $db_port = "3306";
    define("DB_SERVER", "localhost");
    define("DB_DATABASE_NAME", "sp");
    define("DB_USER_LOGIN", "root");
    define("DB_USER_PASSWORD", "");
    $db = mysqli_connect(DB_SERVER,DB_USER_LOGIN,DB_USER_PASSWORD,DB_DATABASE_NAME);
