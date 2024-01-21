<?php require_once "config.php"; ?>

<?php require_once "utils/validation.php"; ?>

<?php
if (isset($_POST["add_member"])) {

    $members_count = $conn->prepare("SELECT COUNT(*) AS count FROM anggota;");
    $members_count->execute();

    $member_code = $members_count->fetch(PDO::FETCH_ASSOC);

    echo $member_code["count"];

    if ($member_code["count"] == 0) {
        echo "bekum ada datanya";

        $member_code = str_pad($member_code["count"] + 1, 16, "0", STR_PAD_LEFT);
    } else {
        echo "masuk lebih dari 1";

        $last_member = $conn->prepare("SELECT * FROM anggota ORDER BY id DESC LIMIT 1;");
        $last_member->execute();

        $last_member_id = $last_member->fetch(PDO::FETCH_ASSOC)["id"];

        $member_code = str_pad($last_member_id + 1, 16, "0", STR_PAD_LEFT);
    }

    echo $member_code;

    echo "tambah anggota";
    $members_add = $conn->prepare(
        "INSERT INTO anggota (nomor_anggota, nama) VALUES (:nomor_anggota, :nama);"
    );

    $members_add->execute([
        ":nomor_anggota" => $member_code,
        ":nama" => $_POST["name"],
    ]);

    header("location:members.php");
}
?>