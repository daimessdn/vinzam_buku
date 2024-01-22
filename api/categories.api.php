<?php require_once "../config.php"; ?>

<?php require_once "../utils/validation.php"; ?>


<?php
if (isset($_GET["q"])) {
    $q = $_GET["q"];
    $category_query = "SELECT * FROM kategori WHERE LOWER(kategori) LIKE '%" . $q . "%';";
} else {
    $category_query = "SELECT * FROM kategori;";
}

$get_category = $conn->prepare($category_query);
$get_category->execute();

$category_json = json_encode([
    "success" => true,
    "msg" => "berhasil menampilkan data kategori",
    "data" => $get_category->fetchAll(PDO::FETCH_ASSOC)
]);

echo $category_json;
?>