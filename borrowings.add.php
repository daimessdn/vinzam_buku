<?php require_once "config.php"; ?>

<?php require_once "utils/validation.php"; ?>

<?php
if (isset($_POST["borrow_book"])) {

    $book = $_POST["title"];
    $member = $_POST["name"];

    $book_query = $conn->query("SELECT * FROM buku WHERE LOWER(judul) LIKE '%" . $book . "%';");
    $member_query = $conn->query("SELECT * FROM anggota WHERE LOWER(nama) LIKE '%" . $member . "%';");

    echo $book;
    echo $member;

    $book_result = $book_query->fetch(PDO::FETCH_ASSOC);
    $member_result = $member_query->fetch(PDO::FETCH_ASSOC);

    echo var_dump($book_result);
    echo var_dump($member_result);

    $borrow_query = "INSERT INTO peminjaman (buku_id, anggota_id, tanggal_pengembalian) VALUES (:book_id, :member_id, :return_date);";
    $borrow = $conn->prepare($borrow_query);
    $borrow->execute([
        ":book_id" => $book_result["id"],
        ":member_id" => $member_result["id"],
        ":return_date" => $_POST["return_date"]
    ]);

    header("location:borrowings.php");
}
?>