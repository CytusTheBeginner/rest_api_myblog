<?php
    //header
    header('Access-Control-Allow-Origin: *');
    header('Control-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Header:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    //instantiate DB & connect
    //inisialisasi objek database dan melakukan koneksi ke MySQL
    $database = new Database(); //create database object
    $db = $database->connect(); //call connect method

    //instantiate blog post object
    $post = new Post($db); //create post object

    //get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    //get id to update
    $post->id = $data->id;

    //set update
    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    $post->category_id = $data->category_id;

    //update post
    if($post->update()) {
        echo json_encode(
            array('message' => 'Post Updated')
        );
    }
    else {
        echo json_encode(
            array('message' => 'Post Not Updated')
        );
    }
?>