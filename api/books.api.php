<?php require_once "../config.php"; ?>

<?php require_once "../utils/validation.php"; ?>


<?php
if (isset($_GET["q"])) {
    $q = $_GET["q"];
    $books_query = "SELECT * FROM buku WHERE LOWER(judul) LIKE '%" . $q . "%';";
} else {
    $books_query = "SELECT * FROM buku;";
}

$get_books = $conn->prepare($books_query);
$get_books->execute();

$books_json = json_encode([
    "success" => true,
    "msg" => "berhasil menampilkan data buku",
    "data" => $get_books->fetchAll(PDO::FETCH_ASSOC)
]);

echo $books_json;
?>