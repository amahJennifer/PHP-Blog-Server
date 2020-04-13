<?php
  class Comment {
    // DB Stuff
    private $conn;
    private $table = 'comments';

    // Properties
    public $id;
    public $comment_post_id;
    public $comment_text;
    public $created_at;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Comments
    public function read() {
      // Create query
      $query = 'SELECT
        id,
        comment_post_id,
        comment_text,
        created_at
      FROM
        ' . $this->table . '
      ORDER BY
        created_at DESC';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Comment
  public function read_single(){
    // Create query
    $query = 'SELECT
          id,
          comment_post_id,
          comment_text,
          created_at
        FROM
          ' . $this->table . '
      WHERE id = ?
      LIMIT 0,1';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->id = $row['id'];
      $this->comment_post_id = $row['comment_post_id'];
      $this->comment_text = $row['comment_text'];
      $this->created_at = $row['created_at'];

  }

  // Create Comment
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
      comment_post_id = :comment_post_id,comment_text=:comment_text';


  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->comment_post_id = htmlspecialchars(strip_tags($this->comment_post_id));
$this->comment_text = htmlspecialchars(strip_tags($this->comment_text));

  // Bind data
  $stmt-> bindParam(':comment_post_id', $this->comment_post_id);
  $stmt-> bindParam(':comment_text', $this->comment_text);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }

  
  }
