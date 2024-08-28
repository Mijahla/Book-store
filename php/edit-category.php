<?php
session_start();

#If the admin is logged in
if (isset($_SESSION['user_id'])&&
    isset($_SESSION['user_email'])){

    #Database Connection File
    include "../db_conn.php";

    #Check if category name is submitted
    if (isset($_POST['category_name']) && isset($_POST['category_id'])){

        # Get data from POST request and store it in var
        $name = $_POST['category_name'];
        $id = $_POST['category_id'];


        #simple form validation
        if (empty($name)){
            $em = "The category name is required!!";
            header("Location: ../edit-category.php?error=$em&id=$id");
            exit;
        }
        
    else{
        #UPDATE the database
        $sql = "UPDATE categories SET name=?
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $res = $stmt->execute([$name, $id]);

        #If there is no error while updating the data
        if ($res){
            #success Message
            $sm = "Successfully updated!!";
            header("Location: ../edit-category.php?success=$sm&id=$id");
            exit;
        } else{
            #Error Message
            $em = "Unknown error occured!!";
            header("Location: ../edit-category.php?error=$em&id=$id");
            exit;
        }
    }
    }
else{
   header("Location: ../login.php");
   exit;
}}
?>