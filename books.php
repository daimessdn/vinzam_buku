<?php require_once "config.php"; ?>

<?php require_once "includes/header.php"; ?>

<?php require_once "utils/validation.php"; ?>

<main>
    <div class="container mx-auto py-5 flex flex-row gap-4">
        <?php require_once "includes/components/sidebar.php"; ?>

        <section class="main__dashboard w-full">
            <h1 class="text-xl font-bold mb-3">Books</h1>

            <h1 class="mb-4">Hello,
                <?php echo $_SESSION["email"]; ?>
            </h1>

            <form action="books.php" method="POST">
                <button name="tambah_buku" class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Tambah Buku</button>
            </form>

            <?php
            if (isset($_POST["tambah_buku"])) {
                echo "tambah buku";
                // $books_collection_insert = $conn->prepare("INSERT INTO buku (judul, cover, kategori_id, tahun_terbit, penerbit) VALUES (\"Dilan (1990)\", NULL, 3, 2014, \"Pastel Books\");");
                $books_collection_insert = $conn->prepare("INSERT INTO buku (judul, cover, kategori_id, tahun_terbit, penerbit) VALUES (\"Dilan (1991)\", NULL, 3, 2015, \"Pastel Books\");");
                $books_collection_insert->execute();
            }
            ?>

            <?php
            $books = $conn->prepare("SELECT * FROM buku");
            $books->execute();

            if ($books->rowCount() > 0) : ?>
                <table class="table-auto border-collapse mt-4">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tahun Terbit</th>
                            <th>Penerbit</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $books_result = $books->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($books_result as $book) :
                        ?>
                            <?php
                            $kategori = $conn->prepare("SELECT kategori from kategori WHERE id = " . strval($book["kategori_id"]));
                            $kategori->execute();

                            $kategori_result = $kategori->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <tr>
                                <td><?php echo $book["judul"]; ?></td>
                                <td><?php echo $kategori_result["kategori"]; ?></td>
                                <td><?php echo $book["tahun_terbit"]; ?></td>
                                <td><?php echo $book["penerbit"]; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>
    </div>
</main>

<script>

</script>