<?php require_once "config.php"; ?>

<?php require_once "utils/validation.php"; ?>

<?php
    if (isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        echo $id;
        $books_delete = $conn->prepare(
            "DELETE FROM buku WHERE id = " . $id . ";"
        );

        $books_delete->execute();

        header("location:books.php?action=delete&success=true");
    } else {
        echo "action failed: book not declared";
    }
?>