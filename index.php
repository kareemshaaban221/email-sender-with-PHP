<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail Sender</title>

    <style>
        .center {
            text-align: center;
        }
        .color-green {
            color: green;
        }
        .color-red {
            color: red;
        }
    </style>
</head>
<body>
    <div class="center">
        <h1>Email Sender</h1>

        <?php
            session_start();
            if(isset($_SESSION['done'])) {
                if ($_SESSION['done']) {
                    echo '<h5 class="color-green">Email is sent. Check your email, please!</h5>';
                    unset($_SESSION['done']);
                } else {
                    echo '<h5 class="color-red">Failed! Please try again later</h5>';
                    unset($_SESSION['done']);
                }
            }

            if(isset($_SESSION['error'])) {
                echo '<h5 class="color-red">Failed! Complete entering data!</h5>';
                unset($_SESSION['error']);
            }
        ?>
        <form action="mailsender.php" method="POST">
            <!-- <input type="email" name="from" placeholder="From"> -->
            <!-- <br><br> -->
            <input type="email" name="to" placeholder="To">
            <br><br>
            <input type="text" name="subject" placeholder="Subject">
            <br><br>
            <input type="text" name="msg" placeholder="Message">
            <br><br>
            <input type="submit" name="submit" value="<?= ucwords('submit') ?>">
        </form>
    </div>
</body>
</html>