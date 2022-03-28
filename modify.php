<?php

session_start();
require "functions.php";

?>


<?php include "template/header.php"; ?>

<div class="container">
    <h1>Modify user</h1>

    <?php
    if (isConnected()) :
    ?>

        <?php

        if (!isset($_GET['userId'])) {
            echo "give user id";

            die();
        }

        $userId = $_GET['userId'];

        $pdo = connectDB();


        $queryPrepared = $pdo->prepare("SELECT * FROM iw_user WHERE id=:id");
        $queryPrepared->execute(["id" => $userId]);

        $userData = $queryPrepared->fetch();

        if (!$userData) {
            echo "no user found";

            die();
        }
        ?>

        <div class="row mt-4">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php
                if (!empty($_SESSION['errors'])) {
                    echo '<div class="alert alert-danger" role="alert">';

                    $errors = $_SESSION['errors'];
                    foreach ($errors as $error) {
                        echo $error . "<br>";
                    }

                    echo "</div>";
                    unset($_SESSION['errors']);
                    //session_destroy();
                }
                ?>

                <form method="POST" action="modifyUser.php?userId=<?php echo $userData["id"] ?>">

                    <input type="email" class="form-control" name="email" value="<?php echo $userData["email"] ?>" placeholder="email" required="required"><br>

                    <input type="text" class="form-control" name="firstname" value="<?php echo $userData["firstname"] ?>" placeholder="prénom"><br>
                    <input type="text" class="form-control" name="lastname" value="<?php echo $userData["lastname"] ?>" placeholder="nom"><br>
                    <input type="text" class="form-control" name="pseudo" value="<?php echo $userData["pseudo"] ?>" placeholder="pseudo"><br>

                    <input type="password" class="form-control" name="oldPassword" placeholder="ancien mot de passe"><br>

                    <input type="password" class="form-control" name="newPassword" placeholder="nouveau mot de passe"><br>
                    <input type="password" class="form-control" name="passwordConfirm" placeholder="confirmation nouveau mot de passe" <br>


                    <input type="submit" class="btn btn-primary" value="Modifier">

                </form>
            </div>

        <?php endif; ?>
        </div>


        <?php include "template/footer.php"; ?>
