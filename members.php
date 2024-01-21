<?php require_once "config.php"; ?>

<?php require_once "includes/header.php"; ?>
<?php require_once "dashboard_style.php"; ?>

<?php require_once "utils/validation.php"; ?>

<main>
    <div class="container mx-auto py-5 flex flex-row gap-4">
        <?php require_once "includes/components/sidebar.php"; ?>

        <section class="main__right-side p-4 bg-violet-100 rounded-md shadow-md w-full">
            <h1 class="text-2xl font-bold mb-4">Members</h1>

            <!-- <form action="members.php" method="POST"> -->
            <button name="tambah_anggota" id="add-member" class="bg-violet-600
                        hover:bg-violet-800
                        text-white py-2 px-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </button>
            <!-- </form> -->

            <form class="flex flex-row gap-2 items-center mt-4">
                <input class="border-violet-600 border-[1px] py-2 px-3 rounded" type="search" name="search" placeholder="Type to search" />
                <button name="search_anggota" class="bg-violet-600
                        hover:bg-violet-800
                        text-white py-2 px-3 rounded" type="submit">Cari Anggota</button>
            </form>

            <?php
            if (isset($_GET["page"])) {
                $page = $_GET["page"];
            } else {
                $page = 1;
            }

            $members_all = $conn->prepare("SELECT * FROM anggota;");
            $members_all->execute();

            $members = $conn->prepare("SELECT * FROM anggota LIMIT 5 OFFSET " . strval(($page - 1) * 5) . ";");
            $members->execute();

            if ($members->rowCount() > 0) : ?>
                <table class="table-fixed border-collapse mt-4 mb-0">
                    <thead>
                        <tr>
                            <th>Kode Anggota</th>
                            <th>Nama Anggota</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $members_result = $members->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($members_result as $member) :
                        ?>
                            <tr>
                                <td>
                                    <a href=<?= "members.detail.php?id=" . $member["id"]; ?>>
                                        <?= $member["nomor_anggota"]; ?>
                                    </a>
                                </td>

                                <td><?= $member["nama"]; ?></td>

                                <td class="select-none">
                                    <button class="bg-violet-600
                                            hover:bg-violet-800
                                            text-white font-bold py-2 px-3 rounded" id="<?= "update-" . $member['id']; ?>" onclick='updateMember(<?= $member['id']; ?>, <?= json_encode($member, JSON_HEX_APOS); ?>)'>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>

                                    <button class="bg-violet-600
                                            hover:bg-violet-800
                                            text-white font-bold py-2 px-3 rounded" id="<?= "delete-" . $member['id']; ?>" onclick="deleteMember(<?= $member['id']; ?>)">
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
                                    <?= "members.php?page=" . ($page - 1); ?>
                                " class="bg-violet-600
                                            hover:bg-violet-800
                                            text-white font-bold py-2 px-3 rounded">Prev</a>
                            </li>
                        <?php endif; ?>
                        <!--end prev pagination -->

                        <li>
                            <ul class="rounded flex flex-row list-none items-strect">
                                <?php
                                $page_amount = $members_all->rowCount() % 5 == 0 ? intdiv($members_all->rowCount(), 5) : ceil($members_all->rowCount() / 5);
                                for ($i = 1; $i <= $page_amount; $i++) :
                                ?>
                                    <li>
                                        <a href="<?= "members.php?page=" . $i; ?>" class="bg-violet-600
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
                                    <?= "members.php?page=" . ($page <= 1 ? 2 : $page + 1); ?>
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
        </section>
    </div>
</main>

<section id="popup-delete" class="popup">
    <div class="popup-content p-4">
        <div class="text-xl font-bold mb-2 block">Hapus Anggota</div>
        <div class="block">Apakah Anda yakin ingin menghapus anggota?</div>

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

<section id="popup-add-member" class="popup">
    <div class="popup-content p-4">
        <div class="text-xl font-bold mb-2 block">Tambah Anggota</div>
        <form action="members.add.php" method="POST" class="block">
            <div class="flex flex-col mb-4">
                <label for="name" class="mb-2">Nama Anggota</label>
                <input type="text" name="name" class="border-2 p-2 rounded-md shadow-lg border-gray-700 w-[28rem]" id="name" required="required" placeholder="Input member name">
            </div>

            <div class="flex flex-row gap-2 justify-end mt-4">
                <button class="bg-violet-600
                    hover:bg-violet-800
                    text-white font-bold py-2 px-3 rounded" type="submit" name="add_member">
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
        <div class="text-xl font-bold mb-2 block">Edit Anggota</div>

        <form action="members.update.php" method="POST" class="block">
            <div class="flex flex-col mb-4">
                <label for="name" class="mb-2">Nama Anggota</label>
                <input type="text" name="name" class="border-2 p-2 rounded-md shadow-lg border-gray-700 w-[28rem]" id="name" required="required" placeholder="Input name">
            </div>

            <div class="flex flex-row gap-2 justify-end mt-4">
                <button class="bg-violet-600
                    hover:bg-violet-800
                    text-white font-bold py-2 px-3 rounded" type="submit" name="update_member">
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

    const deleteMember = (member_id) => {
        const deleteButton = document.querySelector(".button-delete-confirm");

        const memberEventListener = () => {
            window.location.href = "members.delete.php?id=" + member_id;
        };

        deleteButton.removeEventListener("click", memberEventListener);
        deleteButton.addEventListener("click", memberEventListener);

        togglePopup("#delete-" + member_id, "#popup-delete");
    };

    const updateMember = (member_id, member) => {
        const updateFormElement = document.querySelector(`#popup-update form`);
        updateFormElement.setAttribute("action", `members.update.php?id=${member_id}`);

        console.log(member);

        updateFormElement.name.value = member.nama;

        togglePopup("#update-" + member_id, "#popup-update");
    };

    console.log("popup loaded");

    togglePopup("#add-member", "#popup-add-member");
</script>