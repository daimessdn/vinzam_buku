<?php require_once "config.php"; ?>

<?php require_once "includes/header.php"; ?>

<?php
if (!isset($_SESSION["email"])) {
    if (isset($_POST["submit"])) {

        // validation email and password
        if (!isset($_POST["email"]) or !isset($_POST["password"]) or !isset($_POST["confirm_password"])) {
            echo "Register failed";
        } else {
            if ($_POST["password"] = $_POST["confirm_password"]) {
                $email = $_POST["email"];
                $password = $_POST["password"];

                // insert dan execute query
                $insert = $conn->prepare(
                    "INSERT INTO user (email, password) VALUES(:email, :mypassword)"
                );
                $insert->execute([
                    ":email" => $email,
                    ":mypassword" => password_hash($password, PASSWORD_DEFAULT,),
                ]);


                header("location: login.php");
            }
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

            <div class="flex flex-col mb-4">
                <label for="password" class="mb-2">Confirm password</label>
                <input type="password" name="confirm_password" class="border-[1px] p-2 rounded-md shadow-lg border-violet-600 w-[20rem]" id="confirm_password" required="required" placeholder="Input confirm password">
            </div>

            <button class="btn text-white bg-blue-500 px-3 py-2 rounded-md shadow-lg" type="submit" name="submit" value="Login">Login</button>
        </form>
    </div>
</main>

<?php require_once "includes/footer.php"; ?>