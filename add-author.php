<?php
session_start();

#If the admin is logged in
if (isset($_SESSION['user_id'])&&
    isset($_SESSION['user_email'])){

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" 
        content="width=device-width, 
        initial-scale=1.0">
        <title>Add Author</title>

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
                        <a class="nav-link" href="add-book.php">Add Book</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="add-category.php">Add Category</a>
                        </li>  
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" href="add-author.php">Add Author</a>
                        </li>  
                        <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                        </li> 
                    </ul>
                    </div>
                </div>
            </nav>
        <form action="php/add-author.php" class="shadow p-4 rounded mt-5 class-for-add-author" method="post">
            <h1 class="text-center pb-5 display-4 fs-3">
                Add New Author
            </h1>
            <?php if(isset($_GET['error'])) {?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($_GET['error']);?>
                </div>
                <?php }?>

                <?php if(isset($_GET['success'])) {?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlspecialchars($_GET['success']);?>
                </div>
                <?php }?>
            <div class="mb-3">
                    <label class="form-label">Author name</label>
                    <input type="text" class="form-control" name="author_name">              
            </div>
            <button type="submit" class="btn btn-primary">Add Author</button>

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