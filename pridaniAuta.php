<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    require("config.php");

    $znacka = $model = $karoserie = $cena = $rok = $palivo = $prevodovka = $informace = $picture = null;

    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        $znacka = $_POST["znacka"];
        $model = $_POST["model"];
        $karoserie = $_POST["karoserie"];
        $cena = $_POST["cena"];
        $rok = $_POST["rok"];
        $palivo = $_POST["palivo"];
        $prevodovka = $_POST["prevodovka"];
        $informace = $_POST["informace"];

        if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
            $pictureTmpName = $_FILES['picture']['tmp_name'];
            $pictureName = $_FILES['picture']['name'];
            $pictureDestination = "./uploads/" . $pictureName;
            move_uploaded_file($pictureTmpName, $pictureDestination);
        }

        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            $sql = "INSERT INTO auta(znacka, model, karoserie, cena, rok, palivo, prevodovka, informace, user_id, obrazek)
                    VALUES(?,?,?,?,?,?,?,?,?,?)";

            $conn = connDB();
            $statement = mysqli_prepare($conn, $sql);

            if ($statement === false){
                echo mysqli_error($conn);
            } else {
                mysqli_stmt_bind_param($statement, "sssiisssis", $znacka, $model, $karoserie, $cena, $rok, $palivo, $prevodovka, $informace, $user_id, $pictureDestination);

                if (mysqli_stmt_execute($statement)){
                    $id = mysqli_insert_id($conn);
                    header("location: inzerat.php?id=$id");
                } else {
                    echo mysqli_stmt_error($statement);
                }
            }
        } else {
            echo "Uživatel není přihlášen.";
        }
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
    <link rel="stylesheet" href="styly/pridaniAuta.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Přidání inzerátu</title>
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

<main>
    <section class="pridani">
        <form action="pridaniAuta.php" method="post" enctype="multipart/form-data">
            <div class="pridani__container">
                <h2>Přidej svoje vozidlo</h2>
                <input type="text"
                       name="znacka"
                       placeholder="Značka"
                       value="<?= $znacka ?>"
                       autocomplete="off"
                       required>
                <input type="text"
                       name="model"
                       placeholder="Model"
                       value="<?=$model ?>"
                       autocomplete="off"
                       required>
                <input type="text"
                       name="karoserie"
                       placeholder="Karoserie"
                       value="<?=$karoserie ?>"
                       autocomplete="off"
                       required>
                <input type="number"
                       name="cena"
                       placeholder="Cena"
                       value="<?=$cena ?>"
                       autocomplete="off"
                       required>
                <input type="number"
                       name="rok"
                       placeholder="Rok výroby"
                       value="<?=$rok?>"
                       autocomplete="off"
                       required>
                <input type="text"
                       name="palivo"
                       placeholder="Palivo"
                       value="<?=$palivo ?>"
                       autocomplete="off"
                       required>
                <input type="text"
                       name="prevodovka"
                       placeholder="Převodovka"
                       value="<?=$prevodovka?>"
                       autocomplete="off"
                       required>
                <textarea name="informace"
                       placeholder="Informace o vozu"
                       autocomplete="off"
                       required><?=$informace ?></textarea>
                <input type="file" name="picture" accept="image/*" multiple>
                <input type="submit" value="Přidat vozidlo">
            </div>
        </form>
    </section>
</main>
<footer></footer>
</body>
</html>