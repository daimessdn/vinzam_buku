<?php require_once "config.php"; ?>

<?php require_once "includes/header.php"; ?>

<main>
    <div class="container mx-auto py-5 flex flex-row">
        <?php require_once "includes/components/sidebar.php"; ?>

        <section class="main__dashboard w-full">
            <div class="flex flex-row gap-4 mb-2 w-full">
                <div class="p-3 rounded-lg bg-cyan-700 text-white w-1/3">
                    <h2>Borrow Books</h2>
    
                    <p>Here are lists of books being borrowed.</p>
                </div>

                <div class="p-3 rounded-lg bg-orange-700 text-white w-1/3">
                    <h2>Manage Members</h2>
    
                    <p>Add or delete members.</p>
                </div>

                <div class="p-3 rounded-lg bg-orange-700 text-white w-1/3">
                    <h2>Books List</h2>
    
                    <p>Manage books collection.</p>
                </div>
            </div>

            <h1>Hello,
                <?php echo $_SESSION["email"]; ?>
            </h1>
        </section>
    </div>
</main>