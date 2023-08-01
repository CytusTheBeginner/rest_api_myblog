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

    //blog post query
    $result = $post->read(); //call read method

    //get row count to find if there is a post found
    $num = $result->rowCount(); //get row count from query result

    //check if any post
    if ($num > 0) {
        //post array = to save the post data on array
        $posts_arr = array();
        $posts_arr['data'] = array();

        //looping melalui setiap baris hasil query
        while($row = $result->fetch(PDO::FETCH_ASSOC)){ //fetch assosiative array
            extract($row); // extract row menjadi variabel

            // Buat array untuk menyimpan data postingan dalam bentuk asosiatif
            $post_item = array( //create post item
                'id' => $id, 
                'title' => $title,
                'body' => html_entity_decode($body), //decode html entities pada isi postingan (mengubah entitas HTML kembali menjadi karakter normal)
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name
            );

            //push to array "data"
            array_push($posts_arr['data'],$post_item);
        }
        // turn to json & output
        // json_encode untuk mengubah hasil menjadi format json
        echo json_encode($posts_arr);
    } else {
        //no post found, menampilkan pesan "no post found"
        echo json_encode (
            array('message' => 'no post found')
        );
    }
?>