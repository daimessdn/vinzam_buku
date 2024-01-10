<?php

    session_start();

    $host = "localhost";
    $dbname = "vinzam_buku";

    $username = "root";
    $password = "";

    // init mysql connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname;",
        $username,
        $password
    );

    // connection success
    if ($conn == true) {
        $createUserTable = $conn->prepare("CREATE TABLE IF NOT EXISTS `users` (`id` INT NULL AUTO_INCREMENT ,`email` VARCHAR(100) NOT NULL ,`password` VARCHAR(100) NOT NULL ,PRIMARY KEY (`id`));");
        $createUserTable->execute();

        // echo "connection db success";
    } else {                        // if connection failed
        // echo "there is error";
    }
