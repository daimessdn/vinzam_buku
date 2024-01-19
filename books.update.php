<?php require_once "config.php"; ?>

<?php require_once "utils/validation.php"; ?>

<?php
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        echo $id;
        echo $_POST['title'];
        echo $_POST["category"];
        echo $_POST["publisher"];

        echo "UPDATE buku SET judul = :judul, cover = NULL, kategori_id = :category_id, tahun_terbit = :tahun_terbit, penerbit = :penerbit WHERE id = " . $id . ";";

        if (isset($_POST["update_book"])) {
            echo "update buku";
            $books_update = $conn->prepare(
                "UPDATE buku SET judul = :judul, cover = NULL, kategori_id = :category_id, tahun_terbit = :tahun_terbit, penerbit = :penerbit WHERE id = " . $id . ";"
            );
    
            $books_update->execute([
                ":judul" => $_POST['title'],
                ":category_id" => $_POST["category"],
                ":tahun_terbit" => $_POST['year'],
                ":penerbit" => $_POST['publisher'],
            ]);
    
            header("location:books.php");
        }
    }
?>