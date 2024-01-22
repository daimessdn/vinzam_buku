<?php require_once "config.php"; ?>

<?php require_once "includes/header.php"; ?>

<?php
if (!isset($_SESSION["email"])) {
    if (isset($_POST["submit"])) {

        // validation email and password
        if (!isset($_POST["email"]) or !isset($_POST["password"])) {
            echo "Login failed";
        } else {
            $email = $_POST["email"];

            $_SESSION["email"] = $email;

            header("location: dashboard.php");
        }
    }
} else {

    // auto redirected after signed-in
    header("location: dashboard.php");
}
?>

<main class="my-5 min-h-svh">
    <div class="container mx-auto">
        <form action="login.php" method="post">
            <div class="flex flex-col mb-4">
                <label for="email" class="mb-2">Email address</label>
                <input type="email" name="email" class="border-[1px] p-2 rounded-md shadow-lg border-violet-600 w-[20rem]" id="email" required="required" placeholder="Input email">
            </div>

            <div class="flex flex-col mb-4">
                <label for="password" class="mb-2">Password</label>
                <input type="password" name="password" class="border-[1px] p-2 rounded-md shadow-lg border-violet-600 w-[20rem]" id="password" required="required" placeholder="Input password">
            </div>

            <button class="btn text-white bg-blue-500 px-3 py-2 rounded-md shadow-lg" type="submit" name="submit" value="Login">Login</button>
        </form>
    </div>
</main>

<?php require_once "includes/footer.php"; ?>