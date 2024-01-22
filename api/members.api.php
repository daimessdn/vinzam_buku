<?php require_once "../config.php"; ?>

<?php require_once "../utils/validation.php"; ?>


<?php
if (isset($_GET["q"])) {
    $q = $_GET["q"];
    $member_query = "SELECT * FROM anggota WHERE LOWER(nama) LIKE '%" . $q . "%';";
} else {
    $member_query = "SELECT * FROM anggota;";
}

$get_member = $conn->prepare($member_query);
$get_member->execute();

$member_json = json_encode([
    "success" => true,
    "msg" => "berhasil menampilkan data anggota",
    "data" => $get_member->fetchAll(PDO::FETCH_ASSOC)
]);

echo $member_json;
?>