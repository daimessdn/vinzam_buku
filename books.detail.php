<?php require_once "config.php"; ?>

<?php require_once "includes/header.php"; ?>
<?php require_once "dashboard_style.php"; ?>

<?php require_once "utils/validation.php"; ?>

<main>
    <div class="container mx-auto py-5 flex flex-row gap-4">
        <?php require_once "includes/components/sidebar.php"; ?>


        <section class="main__right-side p-4 bg-violet-100 rounded-md shadow-md w-full">
            <?php if (isset($_GET["id"])) : ?>
                <?php
                $id = $_GET["id"];

                $book_detail = $conn->prepare("SELECT * FROM buku WHERE id = " . $id . ";");
                $book_detail->execute();

                $result = $book_detail->fetch(PDO::FETCH_ASSOC);

                // get kategori buku
                $book_category = $conn->prepare("SELECT kategori FROM kategori where id = " . $result["kategori_id"] . ";");
                $book_category->execute();

                $category_result = $book_category->fetch(PDO::FETCH_ASSOC)["kategori"];

                ?>

                <h1 class="font-bold text-2xl"><?php echo $result["judul"]; ?></h1>

                <h2 class="font-bold text-xl mt-4">Kategori</h2>
                <p><?php echo $category_result; ?></p>

                <h2 class="font-bold text-xl mt-4">Penerbit</h2>
                <p><?php echo $result["penerbit"]; ?></p>

                <h2 class="font-bold text-xl mt-4">Tahun Terbit</h2>
                <p><?php echo $result["tahun_terbit"]; ?></p>
            <?php endif; ?>
        </section>
    </div>
</main>