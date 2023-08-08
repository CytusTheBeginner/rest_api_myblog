<?php
    //header
    header('Access-Control-Allow-Origin: *');
    header('Control-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
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

    //get id to delete
    $post->id = $data->id;

    //update post
    if($post->delete()) {
        echo json_encode(
            array('message' => 'Post Deleted')
        );
    }
    else {
        echo json_encode(
            array('message' => 'Post Not Deleted')
        );
    }
?>