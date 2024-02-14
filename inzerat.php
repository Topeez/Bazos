<!doctype html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styly/default.css">
    <link rel="stylesheet" href="styly/navbar.css">
    <link rel="stylesheet" href="styly/inzerat.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Inzerat</title>
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

    <div class="inzerat__container">
        <?php
        require("config.php");

        $conn = connDB();

        if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
            $id = $_GET["id"];

            $sql = "SELECT * FROM auta WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt === false) {
                echo mysqli_error($conn);
            } else {
                mysqli_stmt_bind_param($stmt, "i", $id);

                if (mysqli_stmt_execute($stmt)) {
                    $result = mysqli_stmt_get_result($stmt);
                    $auto = mysqli_fetch_assoc($result);
                    $autoInformace = nl2br($auto["informace"]);
                    if ($auto === null) {
                        echo "Auto s tímto ID nebylo nalezeno.";
                    } else {
                        if (!empty($auto["obrazek"])) {
                            echo "<div class='obrazek__container'>";
                            echo "<img src='" . htmlspecialchars($auto["obrazek"]) . "' alt='Obrázek vozidla'>";
                            echo "</div>";
                        }
                        echo "<div class='inzerat-info'>";
                        echo "<h2>Značka: <strong>" . htmlspecialchars($auto["znacka"]) . "</strong></h2>";
                        echo "<p class='model'>Model: <strong>" . htmlspecialchars($auto["model"])."</strong></p>";
                        echo "<p class='karoserie'>Karoserie: " . htmlspecialchars($auto["karoserie"]) . "</p>";
                        echo "<p class='rVyroby'>Rok výroby: " . htmlspecialchars($auto["rok"]) . "</p>";
                        echo "<p class='palivo'>Palivo: " . htmlspecialchars($auto["palivo"]) . "</p>";
                        echo "<p class='prevodovka'>Převodovka: " . htmlspecialchars($auto["prevodovka"]) . "</p>";
                        echo "<p class='nadpisInfo'><strong class='strong'>Informace:</strong></p>";
                        echo "<p class='info'>$autoInformace</p>";
                        echo "<p class='cena'>Cena: " . htmlspecialchars($auto["cena"]) . " Kč</p>";
                        echo "</div>";
                    }
                } else {
                    echo mysqli_stmt_error($stmt);
                }
            }
        } else {
            echo "Neplatné ID auta.";
        }

        ?>
    </div>
</main>

<footer>
    <div class="footer__container">
        <div class="footer__container-wrapper">
            <div class="footer__claim">
                <p>&#169;Bazoš kopie | Všechna práva vyhrazena</p>
            </div>
        </div>
    </div>
</footer>
</body>
</html>



