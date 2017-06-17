<?php
    require_once('connection.php');
    
    // Login Verify

    session_start();
    
    $username = $_POST['register-user'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    
    $sql = 'BEGIN users_tw.register_user(:v_username, :v_firstname, :v_lastname, :v_e_mail, :v_password, :v_output); END;';

    $stmt = oci_parse($conn,$sql);
    oci_bind_by_name($stmt,':v_username',$username,32);
    oci_bind_by_name($stmt,":v_firstname",$firstname,32);
    oci_bind_by_name($stmt,":v_lastname",$lastname,32);
    oci_bind_by_name($stmt,":v_e_mail",$email,32);
    oci_bind_by_name($stmt,":v_password",$password,32);
    oci_bind_by_name($stmt,":v_output",$login_success,32);

    oci_execute($stmt);

    if ($login_success==0)
        header('LOCATION:index.php?msg=success');
    else
        if ($login_success==1)
            header('LOCATION:index.php?msg=failed-username');
        else
            header('LOCATION:index.php?msg=failed-email');

    oci_close($conn);
?>