<?php require_once "config.php"; ?>

<?php require_once "utils/validation.php"; ?>

<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    echo $id;

    echo "UPDATE anggota SET nama = :nama WHERE id = " . $id . ";";

    if (isset($_POST["update_member"])) {
        echo "update anggota";
        $member_update = $conn->prepare(
            "UPDATE anggota SET nama = :nama WHERE id = " . $id . ";"
        );

        $member_update->execute([
            ":nama" => $_POST['name'],
        ]);

        header("location:members.php");
    }
}
?>