<?php
    session_start();

    if (!isset($_SESSION['first_name'])) {
        header("Location: login.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST["logout"])) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit;
    }

    require("config.php");
    $conn = connDB();

    $email = $_SESSION['first_name'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $user_name = $row['first_name'] . " " . $row['second_name'];
    } else {
        $user_name = "Neznámý uživatel";
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styly/default.css">
    <link rel="stylesheet" href="styly/navbar.css">
    <link rel="stylesheet" href="styly/ucet.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Účet</title>
</head>
<body>

<nav class="navbar">
    <div class="main__header">
        <a href="index.php"><img src="styly/bazos_logo.png" class="logo"></a>
        <div class="search__header">
            <form action="">
                <input type="search" name="vyhledavat" placeholder="Zadejte název, příklad: Škoda Fabia benzín kombi klima 2010 ..." autocomplete="off">
                <input type="submit" class="search__btn" value="Hledat">
            </form>
        </div>
        <ul class="navbar__menu">
            <li class="navbar__item">
                <a href="pridaniAuta.php" class="navbar__links">Přidat inzerát</a>
            </li>
            <li class="navbar__item">
                <a href="moje-inzeraty.php" class="navbar__links">Moje inzeráty</a>
            </li>
            <li class="navbar__item">
                <a href="ucet.php" class="navbar__links">Můj účet</a>
            </li>
        </ul>
    </div>

<main>
    <div class="muj-ucet__container">
        <h1>Vítejte, <?php echo $user_name; ?>!</h1>
        <ul class="odkazy">
            <li class="odkazy__item">
                <a href="pridaniAuta.php">Přidání automobilu</a>
            </li>
            <li class="odkazy__item">
                <a href="index.php">Hlavni stránka</a>
            </li>
            <li class="odkazy__item">
                <a href="moje-inzeraty.php">Moje inzeraty</a>
            </li>
        </ul>
        <form method="post">
            <button type="submit" class="logout__btn" name="logout">Odhlásit se</button>
        </form>
    </div>
</main>
</body>
</html>