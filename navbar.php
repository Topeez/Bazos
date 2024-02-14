<?php

    function isUserLoggedIn() {
        return isset($_SESSION['first_name']);
    }

    if (!isUserLoggedIn() && basename($_SERVER['PHP_SELF']) !== 'login.php') {
        header("Location: ucet.php");
        exit;
    }
?>

<link rel="stylesheet" href="styly/navbar.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
</nav>