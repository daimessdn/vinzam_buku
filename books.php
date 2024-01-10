<?php require_once "config.php"; ?>

<?php require_once "includes/header.php"; ?>

<main>
    <div class="container mx-auto py-5 flex flex-row">
        <?php require_once "includes/components/sidebar.php"; ?>


        <section class="main__dashboard w-full">
            <h1 class="text-xl font-bold mb-3">Books</h1>

            <h1>Hello,
                <?php echo $_SESSION["email"]; ?>
            </h1>
        </section>
    </div>
</main>