<?php
    require("config.php");

    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    $conn = connDB();
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT * FROM auta WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        echo mysqli_error($conn);
    } else {
        mysqli_stmt_bind_param($stmt, "i", $user_id);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $auto = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            echo mysqli_stmt_error($stmt);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styly/default.css">
    <link rel="stylesheet" href="styly/navbar.css">
    <link rel="stylesheet" href="styly/moje-inzeraty.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <title>Moje inzeráty</title>
</head>
<body>
<nav class="navbar">
    <div class="main__header">
        <a href="index.php"><img src="styly/bazos_logo.png" alt="" class="logo"></a>
        <div class="search__header">
            <form action="">
                <label for="vyhledavat"></label>
                <input type="search" id="vyhledavat" name="vyhledavat" placeholder="Zadejte název, příklad: Škoda Fabia benzín kombi klima 2010 ..." autocomplete="off">
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
<main class="flexMain">
    <div class="menuleft">
        <div class="nadpismenu__container">
            <h1 class="nadpismenu">Osobní auta</h1>
        </div>
        <div class="kat__container">
            <div class="znacky-aut__container">
                <a href="/alfa/" >Alfa Romeo</a>
                <a href="/audi/" >Audi</a>
                <a href="/bmw/" >BMW</a>
                <a href="/citroen/" >Citroën</a>
                <a href="/dacia/" >Dacia</a>
                <a href="/fiat/" >Fiat</a>
                <a href="/ford/" >Ford</a>
                <a href="/honda/" >Honda</a>
                <a href="/hyundai/" >Hyundai</a>
                <a href="/chevrolet/" >Chevrolet</a>
                <a href="/kia/" >Kia</a>
                <a href="/mazda/" >Mazda</a>
                <a href="/mercedes/" >Mercedes-Benz</a>
                <a href="/mitsubishi/" >Mitsubishi</a>
                <a href="/nissan/" >Nissan</a>
                <a href="/opel/" >Opel</a>
                <a href="/peugeot/" >Peugeot</a>
                <a href="/renault/" >Renault</a>
                <a href="/seat/" >Seat</a>
                <a href="/suzuki/" >Suzuki</a>
                <a href="/skoda/" >Škoda</a>
                <a href="/toyota/" >Toyota</a>
                <a href="/volkswagen/" >Volkswagen</a>
                <a href="/volvo/" >Volvo</a>
                <a href="/ostatni/" >Ostatní značky</a>
            </div>
        </div>
    </div>
    <section class="moje-auta">
        <div class="moje-auta__container">
                <?php if (empty($auto)): ?>
                    <p>Nemáš žádné inzeráty</p>
                <?php else: ?>
            <div class="inzeraty">
                    <ul class="seznam-aut">
                        <?php foreach ($auto as $one_auto): ?>
                            <a href="inzerat.php?id=<?php echo $one_auto['id']?>">
                                <li class="seznam-item">
                                    <?php if (!empty($one_auto["obrazek"])): ?>
                                        <img src="<?= htmlspecialchars($one_auto["obrazek"]) ?>" alt="Obrázek inzerátu">
                                    <?php endif; ?>
                                    <div class="popis">
                                        <h1><?= htmlspecialchars($one_auto["znacka"])?></h1>
                                        <h2><?= htmlspecialchars($one_auto["model"])?></h2>
                                    </div>

                                    <div class="tools">
                                        <a href="deleteAuto.php?id=<?= $one_auto['id'] ?>">Odstranit</a>
                                        <a href="upravitAuto.php?id=<?= $one_auto['id'] ?>">Upravit</a>
                                    </div>
                                </li>
                            </a>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
</body>
</html>