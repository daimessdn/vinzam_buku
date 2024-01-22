<?php require_once "config.php"; ?>

<?php require_once "includes/header.php"; ?>
<?php require_once "dashboard_style.php"; ?>

<?php require_once "utils/validation.php"; ?>

<?php require_once "functions/members.functions.php"; ?>

<main>
    <div class="container mx-auto py-5 flex flex-row gap-4">
        <?php require_once "includes/components/sidebar.php"; ?>

        <section class="main__right-side p-4 bg-violet-100 rounded-md shadow-md w-full">
            <div class="flex flex-row gap-4 flex-wrap mb-2 w-full">
                <div class="p-3 rounded-lg bg-violet-700 text-white w-2/3 overflow-hidden overflow-x-auto">
                    <h2 class="text-xl font-bold">Manage Members</h2>

                    <p>Add or delete members.</p>
                    <div class="flex flex-row gap-4 overflow-x-auto">
                        <?php foreach (showLastFiveMembers($conn) as $member) : ?>
                            <div class="flex flex-col items-center w-[25%]">
                                <img alt="user" src="./src/img/user-white.svg" class="w-20 h-20 block" />

                                <p class="text-center line-clamp-1 block mt-1 p-2 bg-violet-300 text-violet-700 rounded w-full"><?= $member["nama"]; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="p-3 rounded-lg bg-violet-700 text-white w-1/3">
                    <h2 class="font-bold text-xl">Books List</h2>

                    <p>Manage books collection.</p>
                </div>
            </div>

            <!-- <h1>Hello,
                <?= $_SESSION["email"]; ?>
            </h1> -->
        </section>
    </div>
</main>