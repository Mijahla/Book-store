<?php

#Get All Author function
function get_all_author($con){
    $sql = "SELECT * FROM authors";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        $authors = $stmt->fetchAll();
    }
    else{
        $authors = 0;
    }
    return $authors;
}
#Get Author by id function
function get_author($con, $id){
    $sql = "SELECT * FROM authors WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);

    if($stmt->rowCount() > 0){
        $author = $stmt->fetch();
    }
    else{
        $author = 0;
    }
    return $author;
}
?>