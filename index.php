<?php
session_start(); ?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:wght@300;400;500;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgb(219, 219, 205);
            height: 100vh;
            flex-direction: column;
        }

        * {
            font-family: sans-serif;
        }

        h2 {
            text-align: center;
        }

        form {
            background-color: rgb(245, 243, 243);
            display: flex;
            align-items: center;
            flex-direction: column;
            border: 1px solid rgb(9, 150, 175);
            border-radius: 15px;
            padding: 30px;
            width: 400px;
        }

        input {
            border: 2px solid #ccc;
            width: 95%;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
        }

        label {
            color: rgb(116, 116, 116);
            font-size: 18px;
            padding-left: 10px;
            align-self: self-start;
        }

        button {
            margin-top: 10px;
            padding: 10px;
            width: 200px;
            border: 2px solid rgb(180, 180, 180);
            border-radius: 10px;
            background-color: rgb(51, 51, 51);
            color: whitesmoke;
        }

        button:hover {
            opacity: .7;
        }

        .error {
            background-color: #F2DEDE;
            color: #A94442;
            padding: 10px;
            width: 95%;
            border-radius: 5px;
        }

        h1 {
            text-align: center;
            color: #fff;
        }

        .logo {
            width: 60px;
        }

        .title {
            font-weight: bold;
            font-size: 20px;
        }
        
        .info-login{
            position: absolute;
            top: -15px;
            right: 5px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <p class="info-login">Username : admin<br>Password : 123456</p>
    <p class="title">Manajemen Data Makanan</p>
    <form action="login.php" method="post">
        <img class="logo"
            src="https://e7.pngegg.com/pngimages/710/222/png-clipart-restaurant-computer-icons-food-resturant-miscellaneous-cdr.png">
        <h2>LOGIN</h2>
        <?php if (isset($_SESSION['error'])) { ?>
            <p class="error">
                <?php echo $_SESSION['error']; ?>
            </p>
            <?php unset($_SESSION['error']); ?>
        <?php } ?>
        <label>User Name :</label>
        <input type="text" name="username" placeholder="User Name">

        <label>Password :</label>
        <input type="password" name="password" placeholder="Password">

        <button type="submit">Login</button>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const loginForm = document.querySelector('form');

            loginForm.addEventListener('submit', function (event) {
                event.preventDefault();

                const username = document.getElementsByName("username")[0].value;
                const password = document.getElementsByName("password")[0].value;

                fetch('login.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'username': username,
                        'password': password,
                    }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Set cookie dan redirect
                            document.cookie = "user_id=" + encodeURIComponent(data.user_id) + "; expires=" + new Date(new Date().getTime() + 30 * 24 * 60 * 60 * 1000).toUTCString() + "; path=/";
                            window.location.href = 'makanan.php';
                        } else {
                            // Jika gagal
                            window.location.href = 'index.php';
                        }
                    });
            });
        });
    </script>

</body>

</html>