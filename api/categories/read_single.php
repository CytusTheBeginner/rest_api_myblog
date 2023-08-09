<?php 
    //memberikan request izin akses dari domain manapun
    header('Access-Control-Allow-Origin: *');
    //mengubah tipe konten menjadi tipe json
    header('Content-Type: application/json');
    
    //untuk mewajibkan file yang diperlukan untuk koneksi database dan model post
    include_once '../../config/Database.php'; //database connection
    include_once '../../models/Categories.php'; //post model

    //instantiate DB & connect
    $database = new Database(); //create database object
    $db = $database->connect(); //call connect method

    //instantiate blog post object
    $categories = new Categories($db); //create post object

    //get id from url
    //if id set, then use it, otherwise die()
    $categories->id =isset($_GET['id']) ? $_GET['id'] : die();

    //get post
    $categories->read_single();

    //create array
    $categories_arr = array(
        'id' => $categories->id, 
        'name' => $categories->name
    );

    //make json 
    print_r(json_encode($categories_arr));
?>