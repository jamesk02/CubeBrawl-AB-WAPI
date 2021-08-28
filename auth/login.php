<?php
    include_once("header.php");
    include_once("util/post_only.php");
    require_once("util/check_creds.php");

    // acquire password hash to compare against input
    $sql = 'SELECT passwordHash FROM Credentials WHERE username = ?';

    if ($stmt = mysqli_prepare($link, $sql)) {
        $stmt->bind_param("s", $username);

        $username = $_POST['username'];
        $pwd_input = $_POST['password'];

        if ($stmt->execute()) {
            // successful execution
            $pwd_hash = '';
            $stmt->bind_result($pwd_hash);
            $stmt->fetch();

            // successfully grabbed password hash

            // hash and compare input pwd to stored password hash : if equivalent login else wrong password
            if (password_verify($pwd_input, $pwd_hash)) {
                // Login success

                $_SESSION['username'] = $username;
                $_SESSION['isLoggedIn'] = true;

                exit('Login success');
            } else {
                /* Wrong password
                 * say wrong credentials instead of wrong password so we don't give any clues
                 * to a potential attacker
                 */
                http_response_code(400);
                exit('Invalid credentials');
            }
        } else {
            http_response_code(500);
            exit('Exception executing get password hash statement');
        }
    } else {
        http_response_code(500);
        exit('Exception preparing statement');
    }
?>