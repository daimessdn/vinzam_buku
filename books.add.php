<?php require_once "config.php"; ?>

<?php require_once "utils/validation.php"; ?>

<?php
if (isset($_POST["add_book"])) {
    echo "tambah buku";
    $books_add = $conn->prepare(
        "INSERT INTO buku (judul, cover, pengarang, kategori_id, tahun_terbit, penerbit) VALUES (:judul, NULL, :pengarang, :category_id, :tahun_terbit, :penerbit);"
    );

    $books_add->execute([
        ":judul" => $_POST['title'],
        ":category_id" => $_POST["category"],
        ":pengarang" => $_POST["author"],
        ":tahun_terbit" => $_POST['year'],
        ":penerbit" => $_POST['publisher'],
    ]);

    header("location:books.php");
}
?>