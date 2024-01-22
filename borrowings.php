<?php require_once "config.php"; ?>

<?php require_once "includes/header.php"; ?>
<?php require_once "dashboard_style.php"; ?>

<?php require_once "utils/validation.php"; ?>

<main>
    <div class="container mx-auto py-5 flex flex-row gap-4">
        <?php require_once "includes/components/sidebar.php"; ?>

        <section class="main__right-side p-4 bg-violet-100 rounded-md shadow-md w-full">
            <h1 class="text-2xl font-bold mb-4">Borrow Books</h1>

            <form class="flex flex-row gap-2 items-center mt-4">
                <input class="border-violet-600 border-[1px] py-2 px-3 rounded" type="search" name="search" placeholder="Type to search" />
                <button name="search_buku" class="bg-violet-600
                        hover:bg-violet-800
                        text-white py-2 px-3 rounded" type="submit">Cari Peminjaman</button>
            </form>

            <?php
            if (isset($_GET["page"])) {
                $page = $_GET["page"];
            } else {
                $page = 1;
            }

            $borrowings_all = $conn->prepare("SELECT * FROM peminjaman;");
            $borrowings_all->execute();

            $borrowings = $conn->prepare("SELECT * FROM peminjaman LIMIT 10 OFFSET " . strval(($page - 1) * 10) . ";");
            $borrowings->execute();

            if ($borrowings->rowCount() > 0) : ?>
                <table class="table-fixed border-collapse mt-4 mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Nama Anggota</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $borrowings_result = $borrowings->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($borrowings_result as $borrowing) :
                        ?>
                            <?php
                            $book = $conn->query("SELECT * FROM buku WHERE id = " . $borrowing["buku_id"] . ";");
                            $book_title = $book->fetch(PDO::FETCH_ASSOC)["judul"];

                            $member = $conn->query("SELECT * FROM anggota WHERE id = " . $borrowing["anggota_id"] . ";");
                            $member_name = $member->fetch(PDO::FETCH_ASSOC)["nama"];
                            ?>
                            <tr>
                                <td>
                                    <?= $member_name; ?>
                                </td>

                                <td><?= $book_title; ?></td>
                                <td><?= $borrowing["tanggal_peminjaman"]; ?></td>
                                <td><?= $borrowing["status"]; ?></td>
                                <td class="select-none">
                                    <button class="bg-violet-600
                                            hover:bg-violet-800
                                            text-white font-bold py-2 px-3 rounded" id="<?= "update-" . $borrowing['id']; ?>">
                                        Proses Pengembalian
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
                                    <?= "borrowings.php?page=" . ($page - 1); ?>
                                " class="bg-violet-600
                                            hover:bg-violet-800
                                            text-white font-bold py-2 px-3 rounded">Prev</a>
                            </li>
                        <?php endif; ?>
                        <!--end prev pagination -->

                        <li>
                            <ul class="rounded flex flex-row list-none items-strect">
                                <?php
                                $page_amount = $borrowings_all->rowCount() % 10 == 0 ? intdiv($borrowings_all->rowCount(), 10) : ceil($borrowings_all->rowCount() / 10);
                                for ($i = 1; $i <= $page_amount; $i++) :
                                ?>
                                    <li>
                                        <a href="<?= "borrowings.php?page=" . $i; ?>" class="bg-violet-600
                                                hover:bg-violet-800
                                                text-white font-bold py-2 px-3">
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
                                    <?= "borrowings.php?page=" . ($page <= 1 ? 2 : $page + 1); ?>
                                " class="bg-violet-600
                                            hover:bg-violet-800
                                            text-white font-bold py-2 px-3 rounded">Next</a>
                            </li>
                        <?php endif; ?>
                        <!-- enc next pagination -->
                    </ul>
                </div>
                <!-- end bagian pagination -->
            <?php endif; ?>

            <section class="mt-4 w-fit">
                <div class="text-xl font-bold mb-2 block">Tambah Peminjaman</div>
                <form action="borrowings.add.php" method="POST" class="block" autocomplete="off">
                    <div class="flex flex-col mb-4">
                        <label for="name" class="mb-2">Nama Anggota</label>
                        <input list="members" oninput="updateMemberList(this.value)" type="text" name="name" class="border-[1px] p-2 rounded-md shadow-lg border-violet-600 w-[28rem]" id="name" required="required" placeholder="Input name">

                        <datalist id="members"></datalist>
                    </div>

                    <div class="flex flex-col mb-4">
                        <label for="title" class="mb-2">Judul</label>
                        <input list="borrowings" oninput="updateBookList(this.value)" type="text" name="title" class="border-[1px] p-2 rounded-md shadow-lg border-violet-600 w-[28rem]" id="title" required="required" placeholder="Input title">

                        <datalist id="borrowings"></datalist>
                    </div>

                    <div class="flex flex-col mb-4">
                        <label for="return_date" class="mb-2">Tanggal Pengembalian</label>
                        <input type="date" name="return_date" min=<?= date("Y-m-d"); ?> class="border-[1px] p-2 rounded-md shadow-lg border-violet-600 w-[28rem]" id="return_date" required="required" placeholder="Input returning date">
                    </div>

                    <div class="flex flex-row gap-2 justify-end mt-4">
                        <button class="bg-violet-600
                            hover:bg-violet-800
                            text-white font-bold py-2 px-3 rounded" type="submit" name="borrow_book">
                            Proses Peminjaman
                        </button>

                        <button class="bg-violet-100
                            hover:bg-violet-300
                            border-[1px] border-violet-600
                            text-violet-600 hover:text-violet-800
                            font-bold py-2 px-3 rounded" type="reset">
                            Ulangi
                        </button>
                    </div>
                </form>
            </section>
        </section>
    </div>
</main>

<section id="popup-delete" class="popup">
    <div class="popup-content p-4">
        <div class="text-xl font-bold mb-2 block">Hapus Peminjaman</div>
        <div class="block">Apakah Anda yakin ingin menghapus peminjaman?</div>

        <div class="flex flex-row gap-2 justify-end mt-4">
            <button class="bg-violet-600
                hover:bg-violet-800
                text-white font-bold py-2 px-3 rounded
                
                button-delete-confirm">
                Ya
            </button>

            <button class="bg-violet-100
                hover:bg-violet-300
                border-[1px] border-violet-600
                text-violet-600 hover:text-violet-800
                font-bold py-2 px-3 rounded
                
                popup-abort">
                Tidak
            </button>
        </div>
    </div>
</section>

<section id="popup-borrow-book" class="popup">
    <div class="popup-content p-4">
        <div class="text-xl font-bold mb-2 block">Tambah Peminjaman</div>
        <form action="borrowings.add.php" method="POST" class="block">
            <div class="flex flex-col mb-4">
                <label for="title" class="mb-2">Judul</label>
                <input type="text" name="title" class="border-[1px] p-2 rounded-md shadow-lg border-violet-600 w-[28rem]" id="title" required="required" placeholder="Input title">
            </div>

            <div class="flex flex-col mb-4">
                <label for="category" class="mb-2">Kategori</label>
                <select name="category" class="border-[1px] p-2 rounded-md shadow-lg border-violet-600 w-[28rem] bg-white" id="category" required="required" placeholder="Input category">
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
                <label for="return_date" class="mb-2">Tahun Terbit</label>
                <input type="nnmber" name="return_date" max=<?= date("Y"); ?> class="border-[1px] p-2 rounded-md shadow-lg border-violet-600 w-[28rem]" id="return_date" required="required" placeholder="Input published return_date">
            </div>

            <div class="flex flex-col mb-4">
                <label for="publisher" class="mb-2">Penerbit</label>
                <input type="text" name="publisher" class="border-[1px] p-2 rounded-md shadow-lg border-violet-600 w-[28rem]" id="publisher" required="required" placeholder="Input publisher">
            </div>

            <div class="flex flex-row gap-2 justify-end mt-4">
                <button class="bg-violet-600
                    hover:bg-violet-800
                    text-white font-bold py-2 px-3 rounded" type="submit" name="add_book">
                    Simpan
                </button>

                <button class="bg-violet-100
                    hover:bg-violet-300
                    border-[1px] border-violet-600
                    text-violet-600 hover:text-violet-800
                    font-bold py-2 px-3 rounded
                    popup-abort">
                    Batal
                </button>
            </div>
        </form>
    </div>
</section>

<section id="popup-update" class="popup">
    <div class="popup-content p-4">
        <div class="text-xl font-bold mb-2 block">Edit Peminjaman</div>

        <form action="borrowings.update.php" method="POST" class="block">
            <div class="flex flex-col mb-4">
                <label for="title" class="mb-2">Judul</label>
                <input type="text" name="title" class="border-[1px] p-2 rounded-md shadow-lg border-violet-600 w-[28rem]" id="title" required="required" placeholder="Input title">
            </div>

            <div class="flex flex-col mb-4">
                <label for="category" class="mb-2">Kategori</label>
                <select name="category" class="border-[1px] p-2 rounded-md shadow-lg border-violet-600 w-[28rem] bg-white" id="category" required="required" placeholder="Input category">
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
                <label for="return_date" class="mb-2">Tahun Terbit</label>
                <input type="nnmber" name="return_date" max=<?= date("Y"); ?> class="border-[1px] p-2 rounded-md shadow-lg border-violet-600 w-[28rem]" id="return_date" required="required" placeholder="Input published return_date">
            </div>

            <div class="flex flex-col mb-4">
                <label for="publisher" class="mb-2">Penerbit</label>
                <input type="text" name="publisher" class="border-[1px] p-2 rounded-md shadow-lg border-violet-600 w-[28rem]" id="publisher" required="required" placeholder="Input publisher">
            </div>

            <div class="flex flex-row gap-2 justify-end mt-4">
                <button class="bg-violet-600
                    hover:bg-violet-800
                    text-white font-bold py-2 px-3 rounded" type="submit" name="update_book">
                    Simpan
                </button>

                <button class="bg-violet-100
                    hover:bg-violet-300
                    border-[1px] border-violet-600
                    text-violet-600 hover:text-violet-800
                    font-bold py-2 px-3 rounded
                    popup-abort">
                    Batal
                </button>
            </div>
        </form>
    </div>
</section>

<!-- <script src="./src/js/popup.js"></script> -->
<script>
    const updateMemberList = async (value) => {
        console.log("query anggota", value);

        await fetch("api/members.api.php?q=" + value)
            .then((res) => res.json())
            .then((res) => {
                console.log(res.data);

                const membersDataList = document.querySelector("#members");
                membersDataList.innerHTML = "";

                res.data.forEach((member) => {
                    membersDataList.innerHTML += `<option value="${member.nama}" />`
                });
            });
    };

    const updateBookList = async (value) => {
        console.log("query buku", value);

        await fetch("api/books.api.php?q=" + value)
            .then((res) => res.json())
            .then((res) => {
                console.log(res.data);

                const booksDataList = document.querySelector("#borrowings");
                booksDataList.innerHTML = "";

                res.data.forEach((member) => {
                    booksDataList.innerHTML += `<option value="${member.judul}" />`
                });
            });
    };

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
            window.location.href = "borrowings.delete.php?id=" + book_id;
        };

        deleteButton.removeEventListener("click", bookEventListener);
        deleteButton.addEventListener("click", bookEventListener);

        togglePopup("#delete-" + book_id, "#popup-delete");
    };

    const updateBook = (book_id, book) => {
        const updateFormElement = document.querySelector(`#popup-update form`);
        updateFormElement.setAttribute("action", `borrowings.update.php?id=${book_id}`);

        console.log(book);

        updateFormElement.title.value = book.judul;
        updateFormElement.category.value = book.kategori_id;
        updateFormElement.return_date.value = book.tahun_terbit;
        updateFormElement.publisher.value = book.penerbit;

        togglePopup("#update-" + book_id, "#popup-update");
    };

    console.log("popup loaded");

    togglePopup("#borrow-book", "#popup-borrow-book");
</script>