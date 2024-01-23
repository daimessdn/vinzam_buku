<?php

session_start();

$host = "localhost";
$dbname = "vinzam_buku";

$username = "root";
$password = "";

// init mysql connection
$conn = new PDO(
    "mysql:host=$host;dbname=$dbname;",
    $username,
    $password
);

// connection success
if ($conn == true) {
    // buat tabel user
    $createUserTable = $conn->prepare("CREATE TABLE IF NOT EXISTS `users` (`id` INT NULL AUTO_INCREMENT ,`email` VARCHAR(100) NOT NULL ,`password` VARCHAR(100) NOT NULL ,PRIMARY KEY (`id`));");
    $createUserTable->execute();

    // buat tabel kategori
    $createKategoriTable = $conn->prepare("CREATE TABLE IF NOT EXISTS `kategori` (`id` INT NOT NULL AUTO_INCREMENT , `kategori` VARCHAR(50) NOT NULL , PRIMARY KEY (`id`));");
    $createKategoriTable->execute();

    // insert kategori untuk pertama kali
    $checkKategoriExists = $conn->prepare("SELECT * FROM kategori");
    $checkKategoriExists->execute();

    if ($checkKategoriExists->rowCount() <= 0) {
        $tambahKategori = $conn->prepare("INSERT INTO kategori (kategori) VALUES ('Belum ada kategori'), ('Non-fiksi'), ('Novel'), ('Tips'), ('Cerita');");
        $tambahKategori->execute();
    }

    // buat tabel buku
    $createBukuTable = $conn->prepare("CREATE TABLE IF NOT EXISTS `buku` (`id` INT NULL AUTO_INCREMENT , `judul` VARCHAR(200) NOT NULL , `pengarang` VARCHAR(200) NOT NULL, `cover` MEDIUMBLOB NULL DEFAULT NULL , `kategori_id` INT NOT NULL , `tahun_terbit` YEAR NOT NULL , `penerbit` VARCHAR(50) NOT NULL , `status_peminjaman` BOOLEAN NOT NULL DEFAULT false, PRIMARY KEY (`id`));");
    $createBukuTable->execute();

    // buat table anggota
    $createAnggotaTable = $conn->prepare("CREATE TABLE IF NOT EXISTS `anggota` (`id` INT NOT NULL AUTO_INCREMENT , `nama` VARCHAR(100) NOT NULL , `nomor_anggota` VARCHAR(20) NOT NULL, PRIMARY KEY (`id`));");
    $createAnggotaTable->execute();

    // buat table peminjaman
    $createPeminjamanTable = $conn->prepare("CREATE TABLE IF NOT EXISTS `peminjaman` (`id` INT NOT NULL AUTO_INCREMENT , `buku_id` INT NOT NULL , `anggota_id` INT NOT NULL , `tanggal_peminjaman` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP , `tanggal_pengembalian` DATE NOT NULL , `status` ENUM('Dalam Peminjaman','Sudah Mengembalikan') NOT NULL DEFAULT 'Dalam Peminjaman' , PRIMARY KEY (`id`));");
    $createPeminjamanTable->execute();

    // echo "connection db success";
} else {                        // if connection failed
    // echo "there is error";
}
