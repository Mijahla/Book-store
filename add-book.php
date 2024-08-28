<?php
session_start();

#If the admin is logged in
if (isset($_SESSION['user_id'])&&
    isset($_SESSION['user_email'])){


    #Database Connection File
    include "db_conn.php";

    #Category helper function
    include "php/func-category.php";
    $categories = get_all_categories($conn);

    #Author helper function
    include "php/func-author.php";
    $authors = get_all_author($conn);

    if (isset($_GET['title'])) {
    	$title = $_GET['title'];
    }else $title = '';

    if (isset($_GET['desc'])) {
    	$desc = $_GET['desc'];
    }else $desc = '';

    if (isset($_GET['category_id'])) {
    	$category_id = $_GET['category_id'];
    }else $category_id = 0;

    if (isset($_GET['author_id'])) {
    	$author_id = $_GET['author_id'];
    }else $author_id = 0;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" 
        content="width=device-width, 
        initial-scale=1.0">
        <title>Add Book</title>

        <!-- Bootstrap 5 CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Bootstrap 5 Js bundle CDN -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="admin.php">Admin</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                        <a class="nav-link" href="#">Books</a>
                        </li> 
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">Authors</a>
                        </li>  
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" href="add-book.php">Add Book</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="add-category.php">Add Category</a>
                        </li>  
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="add-author.php">Add Author</a>
                        </li>  
                        <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                        </li> 
                    </ul>
                    </div>
                </div>
            </nav>
        <form action="php/add-book.php" class="shadow p-4 rounded mt-5 class-for-add-book" method="post" enctype="multipart/form-data">
            <h1 class="text-center pb-5 display-4 fs-3">
                Add New Book
            </h1>

            <?php if(isset($_GET['error'])) {?>
                <div class="alert alert-danger" role="alert">
                    <?=htmlspecialchars($_GET['error']);?>
                </div>
                <?php }?>

                <?php if(isset($_GET['success'])) {?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlspecialchars($_GET['success']);?>
                </div>
                <?php }?>
            <div class="mb-3">
                    <label class="form-label">Book Title</label>
                    <input type="text" class="form-control" value="<?=$title?>" name="book_title">              
            </div>
            <div class="mb-3">
                    <label class="form-label">Book Description</label>
                    <input type="text" class="form-control" value="<?=$desc?>"name="book_description">              
            </div>
            <div class="mb-3">
                    <label class="form-label">Book Author</label>
                    <select name="book_author" class="form-control">
                        <option value="0">
                            Select Author
                        </option>
                        <?php
                        if ($authors == 0){
                            #Do nothing
                        } else{
                        foreach ($authors as $author){
                            if ($author_id == $author['id']){

                            ?>
                            <option selected value="<?=$author['id']?>">
                            <?=$author['name']?>
                            </option>
                        <?php } else{ ?>
                            <option value="<?=$author['id']?>">
                            <?=$author['name']?>
                            </option>
                        <?php }} }?>
                    </select>              
            </div>
            
            <div class="mb-3">
                    <label class="form-label">Book Category</label>
                    <select name="book_category" class="form-control">
                        <option value="0">
                            Select category
                        </option>
                        <?php
                        if ($categories == 0){
                            #Do nothing
                        } else{
                        foreach ($categories as $category){
                            
                            if ($category_id == $category['id']){

                            ?>
                            <option selected value="<?=$category['id']?>">
                            <?=$category['name']?>
                            </option>
                            <?php } else{ ?>
                            <option value="<?=$category['id']?>">
                            <?=$category['name']?>
                            </option>
                            <?php }} }?>
                    </select>              
            </div>
            <div class="mb-3">
                    <label class="form-label">Book cover</label>
                    <input type="file" class="form-control" name="book_cover">              
            </div>
            <div class="mb-3">
                    <label class="form-label">Book File</label>
                    <input type="file" class="form-control" name="file">              
            </div>
            <button type="submit" class="btn btn-primary">Add Book</button>

            </div>
            </div>
            
        </form>

        </div>
    </body>
</html>
<?php
}
 else{
    header("Location: login.php");
   }
?>