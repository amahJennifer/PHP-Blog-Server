<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Comment.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $comment = new Comment($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $comment->comment_post_id = $data->comment_post_id;
  $comment->comment_text = $data->comment_text;


  // Create Comment
  if($comment->create()) {
    echo json_encode(
      array('message' => 'Comment Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Comment Not Created')
    );
  }
