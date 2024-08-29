<?php
session_start();

#If the admin is logged in
if (isset($_SESSION['user_id'])&&
    isset($_SESSION['user_email'])){

    #Database Connection File
    include "../db_conn.php";


    #Check if the book id is set
    if (isset($_GET['id'])){

        # Get data from GET request and store it in var
        $id = $_GET['id'];


        #simple form validation
        if (empty($id)){
            $em = "Error occurred";
            header("Location: ../admin.php?error=$em");
            exit;
        }
        
    else{
        # GET book from the database
        $sql2  = "SELECT * FROM books
                WHERE id=?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute([$id]);
        $the_book = $stmt2->fetch();

        if($stmt2->rowCount() > 0){
            #DELETE the book from database
            $sql = "DELETE FROM books
                    WHERE id=?";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$id]);

            #If there is no error while deleting the data
            if ($res){
                # Delete the current book_cover and the file
                $cover = $the_book['cover'];
                $file = $the_book['file'];
                $c_b_c = "../uploads/cover/$cover";
                $c_f = "../uploads/files/$file";

                unlink($c_b_c);
                unlink($c_f);

                    #success Message
                    $sm = "Successfully removed!!";
                    header("Location: ../admin.php?success=$sm");
                exit;
            } else{
                #Error Message
                $ems= "Unknown error occured!!";
                header("Location: ../admin.php?error=$em");
                exit;
            }
        }else{
            $em = "Error occurred";
            header("Location: ../admin.php?error=$em");
            exit;
        }

        
    }
    }
}else{
   header("Location: ../login.php");
   exit;
}
?>