<?php require_once "config.php"; ?>

<?php require_once "utils/validation.php"; ?>

<?php
if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    echo $id;
    $member_delete = $conn->prepare(
        "DELETE FROM anggota WHERE id = " . $id . ";"
    );

    $member_delete->execute();

    header("location:members.php?action=delete&success=true");
} else {
    echo "action failed: book not declared";
}
?>