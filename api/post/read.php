<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    
    include_once '../../config/Database.php'; //database connection
    include_once '../../models/Post.php'; //post model

    //instantiate DB & connect
    $database = new Database(); //create database object
    $db = $database->connect(); //call connect method

    //instantiate blog post object
    $post = new Post($db); //create post object

    //blog post query
    $result = $post->read(); //call read method

    //get row count 
    $num = $result->rowCount(); //get row count

    //check if any post
    if ($num > 0) {
        //post array
        $posts_arr = array();
        $posts_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){ //fetch assosiative array
            extract($row); // extract row

            $post_item = array( //create post item
                'id' => $id,
                'title' => $title,
                'body' => html_entity_decode($body), //decode html entities
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name
            );

            //push to "data
            array_push($posts_arr['data'],$post_item);
        }
        // turn to json & output
        echo json_encode($posts_arr);
    } else {
        //no post
        echo json_encode (
            array('message' => 'no post found')
        );
    }



?>