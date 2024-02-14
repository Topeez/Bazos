<?php
    require("config.php");

    $conn = connDB();

    if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST["id"])) {
        $id = $_POST["id"];
        $znacka = $_POST["znacka"];
        $model = $_POST["model"];
        $karoserie = $_POST["karoserie"];
        $cena = $_POST["cena"];
        $rok = $_POST["rok"];
        $palivo = $_POST["palivo"];
        $prevodovka = $_POST["prevodovka"];
        $informace = $_POST["informace"];

        $sql = "UPDATE auta SET znacka=?, model=?, karoserie=?, cena=?, rok=?, palivo=?, prevodovka=?, informace=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt === false) {
            echo mysqli_error($conn);
        } else {
            mysqli_stmt_bind_param($stmt, "sssiisssi", $znacka, $model, $karoserie, $cena, $rok, $palivo, $prevodovka, $informace, $id);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: moje-inzeraty.php");
                exit;
            } else {
                echo mysqli_stmt_error($stmt);
            }
        }
    } elseif ($_SERVER["REQUEST_METHOD"] === 'GET' && isset($_GET["id"]) && is_numeric($_GET["id"])) {
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

                if ($auto === null) {
                    echo "Auto s tímto ID nebylo nalezeno.";
                } else {
                    ?>
                    <!DOCTYPE html>
                    <html lang="cs">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <link rel="stylesheet" href="styly/default.css">
                        <link rel="stylesheet" href="styly/navbar.css">
                        <link rel="stylesheet" href="styly/upravitAuto.css">
                        <link rel="preconnect" href="https://fonts.googleapis.com">
                        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
                        <title>Upravit inzerát</title>
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
                        <section class="upraveni">
                            <form action="upravitAuto.php" method="post">
                                <div class="upraveni__container">
                                    <h2>Upravit inzerát</h2>
                                    <input type="hidden"
                                           name="id"
                                           value="<?= $auto['id'] ?>"
                                           autocomplete="off">
                                    <input type="text"
                                           name="znacka"
                                           id="znacka"
                                           value="<?= htmlspecialchars($auto["znacka"]) ?>"
                                           autocomplete="off"><br>
                                    <input type="text"
                                           name="model"
                                           id="model"
                                           value="<?= htmlspecialchars($auto["model"]) ?>"
                                           autocomplete="off"><br>
                                    <input type="text"
                                           name="karoserie"
                                           id="karoserie"
                                           value="<?= htmlspecialchars($auto["karoserie"]) ?>"
                                           autocomplete="off"><br>
                                    <input type="number"
                                           name="cena"
                                           id="cena"
                                           value="<?= htmlspecialchars($auto["cena"]) ?>"
                                           autocomplete="off"><br>
                                    <input type="number"
                                           name="rok"
                                           id="rok"
                                           value="<?= htmlspecialchars($auto["rok"]) ?>"
                                           autocomplete="off"><br>
                                    <input type="text"
                                           name="palivo"
                                           id="palivo"
                                           value="<?= htmlspecialchars($auto["palivo"]) ?>"
                                           autocomplete="off"><br>
                                    <input type="text"
                                           name="prevodovka"
                                           id="prevodovka"
                                           value="<?= htmlspecialchars($auto["prevodovka"]) ?>"
                                           autocomplete="off"><br>
                                    <textarea name="informace" id="informace" autocomplete="off"><?= htmlspecialchars($auto["informace"]) ?></textarea><br>
                                    <input type="submit" value="Uložit změny">
                                </div>
                            </form>
                        </section>
                    </main>
                    </body>
                    </html>
                    <?php
                }
            } else {
                echo mysqli_stmt_error($stmt);
            }
        }
    } else {
        echo "Neplatný požadavek.";
    }
?>