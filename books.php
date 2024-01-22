<?php require_once "config.php"; ?>

<?php require_once "includes/header.php"; ?>
<?php require_once "dashboard_style.php"; ?>

<?php require_once "utils/validation.php"; ?>

<main>
    <div class="container mx-auto py-5 flex flex-row gap-4">
        <?php require_once "includes/components/sidebar.php"; ?>

        <section class="main__right-side p-4 bg-violet-100 rounded-md shadow-md w-full">
            <h1 class="text-2xl font-bold mb-4">Books</h1>

            <!-- <form action="books.php" method="POST"> -->
            <button name="tambah_buku" id="add-book" class="bg-violet-600
                        hover:bg-violet-800
                        text-white py-1 px-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </button>
            <!-- </form> -->

            <form class="flex flex-row gap-2 items-center mt-4">
                <input class="border-violet-600 border-[1px] py-1 px-2 rounded" type="search" name="search" placeholder="Type to search" />
                <button name="search_buku" class="bg-violet-600
                        hover:bg-violet-800
                        text-white py-1 px-2 rounded" type="submit">Cari Buku</button>
            </form>

            <?php
            if (isset($_GET["page"])) {
                $page = $_GET["page"];
            } else {
                $page = 1;
            }

            $books_all = $conn->prepare("SELECT * FROM buku;");
            $books_all->execute();

            $books = $conn->prepare("SELECT * FROM buku LIMIT 10 OFFSET " . strval(($page - 1) * 10) . ";");
            $books->execute();

            if ($books->rowCount() > 0) : ?>
                <table class="table-fixed border-collapse mt-4 mb-0">
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
                                <td>
                                    <a href=<?= "books.detail.php?id=" . $book["id"]; ?>>
                                        <?= $book["judul"]; ?>
                                    </a>
                                </td>

                                <td><?= $kategori_result["kategori"]; ?></td>
                                <td><?= $book["tahun_terbit"]; ?></td>
                                <td><?= $book["penerbit"]; ?></td>
                                <td class="select-none">
                                    <button class="bg-violet-600
                                            hover:bg-violet-800
                                            text-white font-bold py-1 px-2 rounded" id="<?= "update-" . $book['id']; ?>" onclick='updateBook(<?= $book['id']; ?>, <?= json_encode($book, JSON_HEX_APOS); ?>)'>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>

                                    <button class="bg-violet-600
                                            hover:bg-violet-800
                                            text-white font-bold py-1 px-2 rounded" id="<?= "delete-" . $book['id']; ?>" onclick="deleteBook(<?= $book['id']; ?>)">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- bagian pagination -->
                <div class="container mt-6 flex justify-end">
                    <ul class="flex flex-row list-none gap-2 self-center">
                        <!-- prev pagination -->
                        <?php if ($page > 1) : ?>
                            <li>
                                <a href="
                                    <?= "books.php?page=" . ($page - 1); ?>
                                " class="bg-violet-600
                                            hover:bg-violet-800
                                            text-white font-bold py-1 px-2 rounded">Prev</a>
                            </li>
                        <?php endif; ?>
                        <!--end prev pagination -->

                        <li>
                            <ul class="rounded flex flex-row list-none items-strect">
                                <?php
                                $page_amount = $books_all->rowCount() % 10 == 0 ? intdiv($books_all->rowCount(), 10) : ceil($books_all->rowCount() / 10);
                                for ($i = 1; $i <= $page_amount; $i++) :
                                ?>
                                    <li>
                                        <a href="<?= "books.php?page=" . $i; ?>" class="bg-violet-600
                                                hover:bg-violet-800
                                                text-white font-bold py-1 px-2">
                                            <?= $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </li>

                        <!-- next pagination -->
                        <?php if ($page < $page_amount) : ?>
                            <li>
                                <a href="
                                    <?= "books.php?page=" . ($page <= 1 ? 2 : $page + 1); ?>
                                " class="bg-violet-600
                                            hover:bg-violet-800
                                            text-white font-bold py-1 px-2 rounded">Next</a>
                            </li>
                        <?php endif; ?>
                        <!-- enc next pagination -->
                    </ul>
                </div>
                <!-- end bagian pagination -->
            <?php endif; ?>
        </section>
    </div>
</main>

<section id="popup-delete" class="popup">
    <div class="popup-content p-4">
        <div class="text-xl font-bold mb-2 block">Hapus Buku</div>
        <div class="block">Apakah Anda yakin ingin menghapus buku?</div>

        <div class="flex flex-row gap-2 justify-end mt-4">
            <button class="bg-violet-600
                hover:bg-violet-800
                text-white font-bold py-1 px-2 rounded
                
                button-delete-confirm">
                Ya
            </button>

            <button class="bg-violet-100
                hover:bg-violet-300
                border-[1px] border-violet-600
                text-violet-600 hover:text-violet-800
                font-bold py-1 px-2 rounded
                
                popup-abort">
                Tidak
            </button>
        </div>
    </div>
</section>

<section id="popup-add-book" class="popup">
    <div class="popup-content p-4">
        <div class="text-xl font-bold mb-2 block">Tambah Buku</div>
        <form action="books.add.php" method="POST" class="block">
            <div class="flex flex-col mb-4">
                <label for="title" class="mb-2">Judul</label>
                <input type="text" name="title" class="border-[1px] px-2 py-1 rounded-md shadow-lg border-violet-600 w-[28rem]" id="title" required="required" placeholder="Input title">
            </div>

            <div class="flex flex-col mb-4">
                <label for="category" class="mb-2">Kategori</label>
                <select name="category" class="border-[1px] px-2 py-1 rounded-md shadow-lg border-violet-600 w-[28rem] bg-white" id="category" required="required" placeholder="Input category">
                    <?php
                    $categories = $conn->prepare("SELECT * from kategori;");
                    $categories->execute();

                    foreach ($categories->fetchAll(PDO::FETCH_ASSOC) as $category) :
                    ?>
                        <option value="<?= $category['id'] ?>"><?= $category["kategori"] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex flex-col mb-4">
                <label for="author" class="mb-2">Pengarang</label>
                <input type="text" name="author" class="border-[1px] px-2 py-1 rounded-md shadow-lg border-violet-600 w-[28rem]" id="author" required="required" placeholder="Input author">
            </div>

            <div class="flex flex-col mb-4">
                <label for="year" class="mb-2">Tahun Terbit</label>
                <input type="nnmber" name="year" max=<?= date("Y"); ?> class="border-[1px] px-2 py-1 rounded-md shadow-lg border-violet-600 w-[28rem]" id="year" required="required" placeholder="Input published year">
            </div>

            <div class="flex flex-col mb-4">
                <label for="publisher" class="mb-2">Penerbit</label>
                <input type="text" name="publisher" class="border-[1px] px-2 py-1 rounded-md shadow-lg border-violet-600 w-[28rem]" id="publisher" required="required" placeholder="Input publisher">
            </div>

            <div class="flex flex-row gap-2 justify-end mt-4">
                <button class="bg-violet-600
                    hover:bg-violet-800
                    text-white font-bold py-1 px-2 rounded" type="submit" name="add_book">
                    Simpan
                </button>

                <button class="bg-violet-100
                    hover:bg-violet-300
                    border-[1px] border-violet-600
                    text-violet-600 hover:text-violet-800
                    font-bold py-1 px-2 rounded
                    popup-abort">
                    Batal
                </button>
            </div>
        </form>
    </div>
</section>

<section id="popup-update" class="popup">
    <div class="popup-content p-4">
        <div class="text-xl font-bold mb-2 block">Edit Buku</div>

        <form action="books.update.php" method="POST" class="block">
            <div class="flex flex-col mb-4">
                <label for="title" class="mb-2">Judul</label>
                <input type="text" name="title" class="border-[1px] px-2 py-1 rounded-md shadow-lg border-violet-600 w-[28rem]" id="title" required="required" placeholder="Input title">
            </div>

            <div class="flex flex-col mb-4">
                <label for="author" class="mb-2">Pengarang</label>
                <input type="text" name="author" class="border-[1px] px-2 py-1 rounded-md shadow-lg border-violet-600 w-[28rem]" id="author" required="required" placeholder="Input author">
            </div>

            <div class="flex flex-col mb-4">
                <label for="category" class="mb-2">Kategori</label>
                <select name="category" class="border-[1px] px-2 py-1 rounded-md shadow-lg border-violet-600 w-[28rem] bg-white" id="category" required="required" placeholder="Input category">
                    <?php
                    $categories = $conn->prepare("SELECT * from kategori;");
                    $categories->execute();

                    foreach ($categories->fetchAll(PDO::FETCH_ASSOC) as $category) :
                    ?>
                        <option value="<?= $category['id'] ?>"><?= $category["kategori"] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex flex-col mb-4">
                <label for="year" class="mb-2">Tahun Terbit</label>
                <input type="nnmber" name="year" max=<?= date("Y"); ?> class="border-[1px] px-2 py-1 rounded-md shadow-lg border-violet-600 w-[28rem]" id="year" required="required" placeholder="Input published year">
            </div>

            <div class="flex flex-col mb-4">
                <label for="publisher" class="mb-2">Penerbit</label>
                <input type="text" name="publisher" class="border-[1px] px-2 py-1 rounded-md shadow-lg border-violet-600 w-[28rem]" id="publisher" required="required" placeholder="Input publisher">
            </div>

            <div class="flex flex-row gap-2 justify-end mt-4">
                <button class="bg-violet-600
                    hover:bg-violet-800
                    text-white font-bold py-1 px-2 rounded" type="submit" name="update_book">
                    Simpan
                </button>

                <button class="bg-violet-100
                    hover:bg-violet-300
                    border-[1px] border-violet-600
                    text-violet-600 hover:text-violet-800
                    font-bold py-1 px-2 rounded
                    popup-abort">
                    Batal
                </button>
            </div>
        </form>
    </div>
</section>

<!-- <script src="./src/js/popup.js"></script> -->
<script>
    const togglePopup = (target, popup) => {
        const closePopup = (e) => {
            event.preventDefault();
            popupElement.classList.remove("popup-shown");
        };

        const targetElement = document.querySelector(target);

        const popupElement = document.querySelector(popup);
        const popupContent = popupElement.children[0];

        targetElement.addEventListener("click", (e) => {
            popupElement.classList.add("popup-shown");
        });

        const closePopupElement = document.querySelector(`${popup} .popup-abort`);
        closePopupElement.addEventListener("click", closePopup);
    };

    const deleteBook = (book_id) => {
        const deleteButton = document.querySelector(".button-delete-confirm");

        const bookEventListener = () => {
            window.location.href = "books.delete.php?id=" + book_id;
        };

        deleteButton.removeEventListener("click", bookEventListener);
        deleteButton.addEventListener("click", bookEventListener);

        togglePopup("#delete-" + book_id, "#popup-delete");
    };

    const updateBook = (book_id, book) => {
        const updateFormElement = document.querySelector(`#popup-update form`);
        updateFormElement.setAttribute("action", `books.update.php?id=${book_id}`);

        console.log(book);

        updateFormElement.title.value = book.judul;
        updateFormElement.author.value = book.pengarang;
        updateFormElement.category.value = book.kategori_id;
        updateFormElement.year.value = book.tahun_terbit;
        updateFormElement.publisher.value = book.penerbit;

        togglePopup("#update-" + book_id, "#popup-update");
    };

    console.log("popup loaded");

    togglePopup("#add-book", "#popup-add-book");
</script>