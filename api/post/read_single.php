<?php 
    //memberikan request izin akses dari domain manapun
    header('Access-Control-Allow-Origin: *');
    //mengubah tipe konten menjadi tipe json
    header('Content-Type: application/json');
    
    //untuk mewajibkan file yang diperlukan untuk koneksi database dan model post
    include_once '../../config/Database.php'; //database connection
    include_once '../../models/Post.php'; //post model

    //instantiate DB & connect
    //inisialisasi objek database dan melakukan koneksi ke MySQL
    $database = new Database(); //create database object
    $db = $database->connect(); //call connect method

    //instantiate blog post object
    $post = new Post($db); //create post object

    //get id from url
    //if id set, then use it, otherwise die()
    $post->id =isset($_GET['id']) ? $_GET['id'] : die();

    //get post
    $post->read_single();

    //create array
    $post_arr = array(
        'id' => $post->id, 
        'title' => $post->title,
        'body' => $post->body, 
        'author' => $post->author,
        'category_id' => $post->category_id,
        'category_name' => $post->category_name
    );

    //make json 
    print_r(json_encode($post_arr));
?>