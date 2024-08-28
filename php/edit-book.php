<?php
session_start();

#If the admin is logged in
if (isset($_SESSION['user_id'])&&
    isset($_SESSION['user_email'])){

    #Database Connection File
    include "../db_conn.php";

    #Validation helper function
    include "func-validation.php";

    #File upload helper function
    include "func-file-upload.php";

    #Check if all input fields are filled
    if (isset($_POST['book_id'])          && 
        isset($_POST['book_title'])       && 
        isset($_POST['book_description']) && 
        isset($_POST['book_category'])    &&
        isset($_POST['book_author'])      &&
        isset($_FILES['book_cover'])      &&
        isset($_FILES['file'])            &&
        isset($_POST['current_cover'])    &&
        isset($_POST['current_file'])){

        # Get data from POST request and store it in var
        $id          = $_POST['book_id'];
        $title       = $_POST['book_title'];
        $description = $_POST['book_description'];
        $category    = $_POST['book_category'];
        $author      = $_POST['book_author'];

        # Get the current cover & current file from POST request and store them in var
        $current_cover = $_POST['current_cover'];
        $current_file  = $_POST['current_file'];

        #simple form validation
        $text = "Book Title";
        $location = "../edit-book.php";
        $ms = "id=$id&error";
            is_empty($title, $text, $location, $ms, "");
        
        $text = "Book Description";
        $location = "../edit-book.php";
        $ms = "id=$id&error";
            is_empty($description, $text, $location, $ms, "");


        $text = "Book author";
        $location = "../edit-book.php";
        $ms = "id=$id&error";
            is_empty($author, $text, $location, $ms, "");
    
        $text = "Book category";
        $location = "../edit-book.php";
        $ms = "id=$id&error";
            is_empty($category, $text, $location, $ms, "");


        # If the admin tries to update the book cover
        if (!empty($_FILES['book_cover']['name'])){
            # If the admin tries to update both
            if (!empty($_FILES['file']['name'])){
                
                # Update both here

            # book cover uploading
            $allowed_image_exs = array("jpg", "jpeg", "png");
            $path = "cover";
            $book_cover = upload_file($_FILES['book_cover'], 
                            $allowed_image_exs, $path);

            # file  uploading
            $allowed_file_exs = array("pdf", "docx", "pptx");
            $path = "files";
            $file = upload_file($_FILES['file'], 
                                $allowed_file_exs, $path);

            # if error occurred while uploading

            if($book_cover['status'] == "error" 
                OR $file['status'] == "error"){
                $em = $book_cover['data'];

                # Redirect to '../edti-book.php' and passing error_message & the id
                header("Location: ../edit-book.php?error=$em&id=$id");
                exit;
                }else{
                    # current book cover path
                    $c_p_book_cover = "../uploads/cover/$current_cover";

                     # current file path
                     $c_p_file = "../uploads/files/$current_file";

                     # Delete both from the server
                     unlink($c_p_book_cover);
                     unlink($c_p_file);

                    # Get the new file name and the new book cover name
                    $file_URL = $file['data'];
                    $book_cover_URL = $book_cover['data'];

                    # update just the data
                    $sql = "UPDATE books SET title=?, author_id=?,
                            description=?, category_id=?, cover=?,
                            file=? WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $res  = $stmt->execute([$title, $author, $description, 
                                        $category, $book_cover_URL, $file_URL , $id]);

                    #If there is no error while updating the data
                    if ($res){
                    #success Message
                    $sm = "Successfully updated!!";
                    header("Location: ../edit-book.php?success=$sm&id=$id");
                    exit;
                    } else{
                    #Error Message
                    $em = "Unknown error occured!!";
                    header("Location: ../edit-book.php?error=$em&id=$id");
                    exit;
                    }
                }
            }
            else{
                # Update just book cover
                # book cover uploading
            $allowed_image_exs = array("jpg", "jpeg", "png");
            $path = "cover";
            $book_cover = upload_file($_FILES['book_cover'], 
                            $allowed_image_exs, $path);


            # if error occurred while uploading

            if($book_cover['status'] == "error"){
                $em = $book_cover['data'];

                # Redirect to '../edti-book.php' and passing error_message & the id
                header("Location: ../edit-book.php?error=$em&id=$id");
                exit;
                }else{
                    # current book cover path
                    $c_p_book_cover = "../uploads/cover/$current_cover";


                     # Delete book cover from the server
                     unlink($c_p_book_cover);

                    # Get the new book cover name
                    $book_cover_URL = $book_cover['data'];

                    # update the data
                    $sql = "UPDATE books SET title=?, author_id=?,
                            description=?, category_id=?, cover=?
                            WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $res  = $stmt->execute([$title, $author, $description, 
                                        $category, $book_cover_URL, $id]);

                    #If there is no error while updating the data
                    if ($res){
                    #success Message
                    $sm = "Successfully updated!!";
                    header("Location: ../edit-book.php?success=$sm&id=$id");
                    exit;
                    } else{
                    #Error Message
                    $em = "Unknown error occured!!";
                    header("Location: ../edit-book.php?error=$em&id=$id");
                    exit;
                    }
                }
            }
        }
        #If the admin tries to update just the file
        else if(!empty($_FILES['file']['name'])){
                # update just the file
                # file uploading
                $allowed_file_exs = array("pdf", "docx", "pptx");
                $path = "files";
                $file = upload_file($_FILES['file'], 
                                $allowed_file_exs, $path);


                # if error occurred while uploading

                if($file['status'] == "error"){
                    $em = $file['data'];

                    # Redirect to '../edti-book.php' and passing error_message & the id
                    header("Location: ../edit-book.php?error=$em&id=$id");
                    exit;
                    }else{
                        # current file path
                        $c_p_file = "../uploads/files/$current_file";


                        # Delete file from the server
                        unlink($c_p_file);

                        # Get the new file name
                        $file_URL = $file['data'];

                        # update the data
                        $sql = "UPDATE books SET title=?, author_id=?,
                                description=?, category_id=?, file=?
                                WHERE id=?";
                        $stmt = $conn->prepare($sql);
                        $res  = $stmt->execute([$title, $author, $description, 
                                            $category, $file_URL, $id]);

                        #If there is no error while updating the data
                        if ($res){
                        #success Message
                        $sm = "Successfully updated!!";
                        header("Location: ../edit-book.php?success=$sm&id=$id");
                        exit;
                        } else{
                        #Error Message
                        $em = "Unknown error occured!!";
                        header("Location: ../edit-book.php?error=$em&id=$id");
                        exit;
                        }
                    }
                }
            else{
                # update just the data
                $sql = "UPDATE books SET title=?, author_id=?,
                                description=?, category_id=?
                                WHERE id=?";
                $stmt = $conn->prepare($sql);
                $res  = $stmt->execute([$title, $author, $description, 
                                        $category, $id]);

                #If there is no error while updating the data
                if ($res){
                    #success Message
                    $sm = "Successfully updated!!";
                    header("Location: ../edit-book.php?success=$sm&id=$id");
                    exit;
                }
            
            else{
                    #Error Message
                    $em = "Unknown error occured!!";
                    header("Location: ../edit-book.php?error=$em&id=$id");
                    exit;
                }
            }
        }else{
       header("Location: ../admin.php");
       exit;   
    }
 
} else{
   header("Location: ../login.php");
   exit;
}
?>