<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KNOWLIT</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        clifford: '#da373d',
                        night: '#003049'
                    }
                }
            }
        }
    </script>

    <style type="text/tailwindcss">
        @layer utilities {
            .content-auto {
                content-visibility: auto;
            }
        }
    </style>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,400;0,700;1,400;1,700&display=swap');

        body {
            font-family: "Raleway", sans-serif;
        }
    </style>
</head>

<body>

<nav class="navbar shadow-md sticky top-0 left-0 z-50">
    <div class="container mx-auto flex justify-between">
        <div class="flex flex-wrap items-center font-bold">
            <a href="#">VINZAM BUKU</a>
        </div>

        <ul class="list-none p-0 m-0 flex gap-4 flex-row">
            <li class="nav-item">
                <a href="#" class="block nav-link px-3 py-[1.5rem]">Home</a>
            </li>

            <li class="nav-item">
                <a href="#" class="block nav-link px-3 py-[1.5rem]">Books Collection</a>
            </li>

            <li class="nav-item">
                    <?php if (!isset($_SESSION["email"])) : ?>
                        <a href="login.php" class="block nav-link px-3 py-[1.5rem] bg-night text-white">Login</a>
                    <?php else : ?>
                        <a href="logout.php" class="block nav-link px-3 py-[1.5rem]">Logout</a>
                    <?php endif; ?>
                </li>

        </ul>
    </div>
</nav>