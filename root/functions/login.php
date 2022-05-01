<?php
session_start();

if(isset($_POST['email']) && isset($_POST['password'])){
    function formatInput($data){
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

$email = formatInput($_POST['email']);
$email = strtolower($email);
$password = formatInput($_POST['password']);
$validated = false;

if ($email != "" && $password != ""){
    if (($file = fopen("../../data/account.db", "r")) !== FALSE) {
        while (($line = fgets($file)) !== false) {
            $data = explode(",", $line);  
            if($data[0] == $email && $data[1] == $password){
                $validated = true;
                break;
            }
        }
    
        fclose($file);
    }

    if($validated == false){
        header("Location: ../login_page.php?error=not validated email or password");
    } else {
        $_SESSION["logedIn"] = true;
        $_SESSION["userInfo"] = ["username" => $data[2], "realname" => $data[3], "pfp_path" => $data[4]];
        header("Location: ../index.php");
    }
} else{
    header("Location: ../login_page.php");
}