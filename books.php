<?php require_once "config.php"; ?>

<?php require_once "includes/header.php"; ?>
<?php require_once "dashboard_style.php"; ?>

<?php require_once "utils/validation.php"; ?>

<main>
    <div class="container mx-auto py-5 flex flex-row gap-4">
        <?php require_once "includes/components/sidebar.php"; ?>

        <section class="main__right-side p-4 bg-violet-100 rounded-md shadow-md w-full">
            <h1 class="text-2xl font-bold mb-3">Books</h1>

            <h1 class="mb-4">Hello,
                <?php echo $_SESSION["email"]; ?>
            </h1>

            <form action="books.php" method="POST">
                <button name="tambah_buku" class="bg-violet-600
                        hover:bg-violet-800
                        text-white font-bold py-2 p-3 rounded" type="submit">Tambah Buku</button>
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
                <table class="table-auto border-collapse mt-4 mb-0">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tahun Terbit</th>
                            <th>Penerbit</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $books_result = $books->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($books_result as $book) :
                        ?>
                            <?php
                            $kategori = $conn->prepare("SELECT kategori from kategori WHERE id = " . $book["kategori_id"]);
                            $kategori->execute();

                            $kategori_result = $kategori->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <tr>
                                <td><?php echo $book["judul"]; ?></td>
                                <td><?php echo $kategori_result["kategori"]; ?></td>
                                <td><?php echo $book["tahun_terbit"]; ?></td>
                                <td><?php echo $book["penerbit"]; ?></td>
                                <td class="select-none">
                                    <button class="bg-violet-600
                                        hover:bg-violet-800
                                        text-white font-bold py-2 p-3 rounded" onclick="alert('edit');">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>

                                    <button class="bg-violet-600
                                        hover:bg-violet-800
                                        text-white font-bold py-2 p-3 rounded" id=<?php echo 'delete-popup-' . $book['id']; ?>>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>
    </div>
</main>

<section id="popup-1" class="popup">
    <div class="popup-content p-4">
        <div class="text-xl font-bold mb-2 block">Hapus Buku</div>
        <div class="block">Apakah Anda yakin ingin menghapus buku?</div>

        <div class="flex flex-row gap-2 justify-end mt-4">
            <button class="bg-violet-600
                hover:bg-violet-800
                text-white font-bold py-2 p-3 rounded">
                Ya
            </button>

            <button class="bg-violet-100
                hover:bg-violet-300
                border-[1px] border-violet-600
                text-violet-600 hover:text-violet-800
                font-bold py-2 p-3 rounded
                
                popup-abort">
                Tidak
            </button>
        </div>
    </div>
</section>

<script src="./src/js/popup.js"></script>
<script>
    togglePopup("#delete-popup-1", "#popup-1");
</script>