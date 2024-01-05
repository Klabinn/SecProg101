<?php
    session_start();

    if($_SERVER ['REQUEST_METHOD'] === "POST"){
        
        require_once 'dbconnect.php';
        require_once 'sessionhandler.php';

        destroyCookies();
        $current_time = time();
        $sql = "DELETE FROM usession WHERE expdate < $current_time";
        $conn->query($sql);

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); 
        $password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');

        $ver = "SELECT * FROM users WHERE username=?;";
        $stmt = $conn->prepare($ver);
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->num_rows === 1){

            $row = $result->fetch_assoc();

            $hashverif = $row['password'];
            // verifnya pake password_verify
            if(password_verify($password, $hashverif)) {
                $_SESSION['is_login'] = true;
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];

                session_regenerate_id();
                // sessionCreate($userid);
                $SID = "SID_" . uniqid();
                $cookie = generateCookie(40);
                $expTime = time() + 1800;

                $query = "INSERT INTO usession (SID, userID, sessionID, expdate) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('sssi', $SID, $userid, $cookie, $expTime);
                $stmt->execute();
                $stmt->close();

                setcookie('user', $cookie, $expTime, '/');

                header("Location: ../dashboard.php");
            }
            else{
                $_SESSION['error101'] = "Incorrect Login Credentials";
                header("Location: ../login.php?error=1"); 
            }
        }
        else{
            $_SESSION['error101'] = "Incorrect Login Credentials";
            header("Location: ../login.php?error=1");    
        }

    }
?>