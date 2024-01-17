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
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap');

        body {
            font-family: "DM Sans", sans-serif;
        }

        table {
            width: 100%;
            border-radius: .5rem;
        }

        thead tr {
            background-color: #DDD6FE;
            color: #8B5CF6;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        tbody tr {
            background: #fff;
        }

        tr td,
        tr th {
            padding: .5rem;

            text-align: left;
        }
    </style>
</head>

<body>

    <nav class="navbar bg-white shadow-md sticky top-0 left-0 z-[50]">
        <div class="container mx-auto flex justify-between">
            <div class="flex flex-wrap items-center font-bold">
                <a href="#">VINZAM BUKU</a>
            </div>

            <ul class="list-none p-0 m-0 flex gap-4 flex-row">
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