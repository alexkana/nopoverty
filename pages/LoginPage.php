<?php
session_start();

if (isset($_POST['login1'])) {
    global $conn;
    include("../phpFiles/dbconnect.php5");
    $username = $_POST['login1'];
    $email = $_POST['login2'];
    $password = $_POST['password1'];
    if ($email == null or $username == null)
        exit();
    $sql_query = "INSERT INTO users (name,password,email) VALUES ('$username','$password','$email');";
    if ($conn->query($sql_query) == false) {
        $_SESSION['sign_up_error'] = '<p style="color:red;" >A user with this name or email already exists!</p>';
    } else {
        $_SESSION['sign_up_error'] = '<p>Account created &#9989;</p>';

        unset($_SESSION['login_error']);

        $conn->close();
        session_write_close();
        header("Location: ../pages/mainpage.html");
        exit;
    }
    $conn->close();
    session_write_close();
    header("Location: ../pages/LoginPage.php");
    exit;
}
if(isset($_POST['login3'])){
    global $conn;
    include("../phpFiles/dbconnect.php5");
    $username = $_POST['login3'];
    $password = $_POST['password3'];
    $sql_query = "SELECT name,password,email,about FROM users WHERE name = '$username' AND password = '$password'";
    $res = $conn->query($sql_query);
    $conn->close();
    if(!empty($res) && $res->num_rows > 0) {
        unset($_SESSION['login_error']);
        $record = $res->fetch_assoc();
        $_SESSION['username'] = $record['name'];
        $_SESSION['password'] = $record['password'];
        $_SESSION['email'] = $record['email'];
        $_SESSION['about'] = $record['about'];
        if($_SESSION['username'] == 'admin'){
            header("Location: ../pages/Admin.php");
        }else{
            header("Location: ../pages/mainpage.html");
        }

        exit;
    }else{
        $_SESSION['login_error'] = '<p style="color:red;" >Invalid username or password</p>';
    }
    header("Location: ../pages/LoginPage.php");
    exit;
}

?>
<!DOCTYPE html>
<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--Font-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--<link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="//fonts.googleapis.com/css2?family=Varela&display=swap" rel="stylesheet" type="text/css"> -->
    <script src="../scripts/LoginPage.js"></script>
    <!-- Bootstrap CSS -->
    <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
    <link rel="icon" href="../images/logo.png">
    <!--Javascript File-->
    <script type="text/javascript" src="../scripts/script.js"></script>

    <!-- CSS file -->
    <link rel="stylesheet" type="text/css" href="../styles/style.css">

    <title>A Helping Hand</title>
</head>
<body>

<section id="nav">
    <div id="navigation">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img src="../images/logo.png" heigth="90px" width="90px"
                                                      class="d-inline-block align-top"
                                                      onclick="window.location = 'mainpage.html'" alt=""></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown"
                        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a id="item1" class="nav-link" aria-current="page" href="mainpage.html">Αρχική
                                Σελίδα</a>
                        </li>
                        <li class="nav-item">
                            <a id="item2" class="nav-link" href="AboutUs.html">Σχετικά με εμάς</a>
                        </li>
                        <li class="nav-item">
                            <a id="item3" class="nav-link" href="Organization.php">Οργανώσεις</a>
                        </li>
                        <li class="nav-item">
                            <a id="item4" class="nav-link" href="contact.html">Επικοινωνία</a>
                        </li>
                        <li class="nav-item">
                            <a id="item5" class="nav-link" href="LoginPage.php">Εγγραφή/Σύνδεση</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="lang_selector" class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a onclick="sessionStorage.setItem('language','el');checkLanguageText(); trans_navbar()"
                                   href="#"
                                   class="dropdown-item">
                                    <img class="flag_icon" src="../images/flag-icons/greece.png" alt="">&nbsp Ελληνικά
                                </a>
                                <a onclick="sessionStorage.setItem('language','en');checkLanguageText(); trans_navbar()"
                                   href="#"
                                   class="dropdown-item">
                                    <img class="flag_icon" src="../images/flag-icons/united-states.png" alt="">&nbsp
                                    English
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <script>
        document.getElementById("item5").className = "nav-link active";
    </script>
</section>

<div class="container">
    <style>
        h1 {
            text-align: center;
        }

        p {
            text-align: center;
        }

        div {
            text-align: center;
        }
    </style>
    <div class="row">
        <div class="col-md-6 col-lg-6">

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method=post
                  oninput='password2.setCustomValidity(password2.value !== password1.value ? "Passwords do not match." : "")'>
                <!-- Checks if the password is the same as confirm password-->
                <p id="text1"></p>
                <p><input type="text" id="login1" class="fadeIn second" required name="login1"
                          placeholder="Ονομα χρήστη"></p>
                <p><input type=email id="login2" class="fadeIn second" required name="login2" placeholder="Email"></p>

                <p><input type=password id="password1" class="fadeIn third" required name="password1"
                          placeholder="Κωδικός πρόσβασης"></p>
                <p><input type=password id="password2" class="fadeIn third" required name="password2"
                          placeholder="Επαλήθευση Κωδικού"></p>
                <p>
                    <button type=submit class="btn btn-success" id="text2">Εγγραφή</button>
                </p>
            </form>
            <?php
            if (isset($_SESSION['sign_up_error'])) {
                echo $_SESSION['sign_up_error'];
            }
            unset($_SESSION['sign_up_error']);
            ?>
        </div>
        <div class="col-md-6 col-lg-6">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method=post>
                <p id="text3">Συμπλήρωσε τα παρακάτω στοιχεία για να συνδεθείς στον λογαριασμό σου!</p>
                <p><input type="text" id="login3" class="fadeIn second" required name="login3"
                          placeholder="Email ή όνομα χρήστη"></p>
                <p><input type="password" id="password3" class="fadeIn third" required name="password3"
                          placeholder="Κωδικός πρόσβασης"></p>
                <div id="formFooter1">
                    <a class="underlineHover" href="#" id="text5" name="text5">Ξέχασες τον Κωδικό σου?</a>
                </div>
                <p>
                    <button type=submit class="btn btn-success" id="text4" name="text4">Σύνδεση</button>
                </p>
            </form>
            <?php
                if(isset($_SESSION['login_error'])) {
                    echo $_SESSION['login_error'];
                }
                unset($_SESSION['login_error']);
            ?>
        </div>
    </div>

</div>

<!-- Footer -->
<footer class="bg-dark text-center text-lg-start">
    <!-- Grid container -->
    <div class="container p-4">
        <!--Grid row-->
        <div class="row">
            <!--Grid column-->
            <div class="col-lg-6 col-md-4 mb-4 mb-md-0">
                <p id="footer_msg" style="color: whitesmoke"></p>
                <p class="fa fa-phone d-inline"> (+30) 6947483***</p>
            </div>
            <!--Grid column-->
            <!--Grid column-->
            <div class="col-lg-3 col-md-4 mb-4 mb-md-0">
                <center>
                    <ul class="list-unstyled">
                        <li class="footerlinks">
                            <p id="list_title" style="color:whitesmoke">Πλοήγηση</p>
                        </li>
                        <li class="footerlinks">
                            <a id="footer1" style="color:whitesmoke" href="mainpage.html">Αρχική Σελίδα</a>
                        </li>
                        <li class="footerlinks">
                            <a id="footer2" style="color:whitesmoke" href="AboutUs.html">Σχετικά με εμάς</a>
                        </li>

                        <li class="footerlinks">
                            <a id="footer3" style="color:whitesmoke" href="Organization.php">Οργανισμοί</a>
                        </li>
                        <li class="footerlinks">
                            <a id="footer4" style="color:whitesmoke" href="contact.html">Επικοινωνία</a>
                        </li>
                        <li class="footerlinks">
                            <a id="footer5" class="footerlinks" style="color:whitesmoke" href="LoginPage.php">Εγγραφή/Σύνδεση</a>
                        </li>
                    </ul>
                </center>
            </div>

            <!--Grid column-->
            <div class="col-lg-3 col-md-4 mb-4 mb-md-0">
                <center>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <p id="social" style="color: whitesmoke">Κοινωνικά Δίκτυα</p>
                        </li>
                        <li>
                            <a href="https://www.facebook.com/Helping-Hand-110377947861394" target="_blank"
                               class="fa fa-facebook"></a>
                        </li>
                        <li>
                            <a href="https://twitter.com/Helping86441471" target="_blank" class="fa fa-twitter"></a>
                        </li>
                        <li>
                            <a href="https://gr.pinterest.com/helpinghandauth/_saved/" target="_blank"
                               class="fa fa-pinterest"></a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com/helping_hand.auth/" target="_blank"
                               class="fa fa-instagram"></a>
                        </li>

                    </ul>
                </center>
            </div>
            <!--Grid column-->
            <!--Grid column-->
        </div>
        <!--Grid row-->
    </div>
    <!-- Grid container -->


    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2); color: whitesmoke">
        © 2021 Copyright:
        <a class="text-white" href="">helpingHand.com</a>
    </div>
    <!-- Copyright -->
</footer>


<!-- Optional JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous"></script>

<script>
    checkLanguageText();
    trans_navbar();</script>

</body>
</html>