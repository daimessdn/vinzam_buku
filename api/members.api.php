<?php require_once "../config.php"; ?>

<?php require_once "../utils/validation.php"; ?>


<?php
$get_member = $conn->prepare("SELECT * FROM anggota");
$get_member->execute();

$member_json = json_encode([
    "success" => true,
    "msg" => "berhasil menampilkan data anggota",
    "data" => $get_member->fetch(PDO::FETCH_ASSOC)
]);

echo $member_json;
?>