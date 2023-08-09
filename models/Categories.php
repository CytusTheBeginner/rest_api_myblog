<?php
    class Categories 
    //nama class categories untuk mengelola objek 
    {
        //DB Stuff
        private $conn; //connection (menyimpan objek koneksi database)
        private $table = 'categories'; //table name (menyimpan/mengambil nama tabel dalam database yang akan digunakan)

        //post properties
        public $id;
        public $name; 
        public $created_at; 

        //constructor with database
        public function __construct($db)
        // __construct merupakan metode khusus yang akan dijalankan secara otomatis saat objek "post" dibuat. yang digunakan untuk menginisialisasi objek koneksi database yang diterima sebagai argumen
        {
            $this->conn = $db;
        }

        //get posts
        public function read()
        {
            //create query
            $query = 'SELECT 
            id,
            name,
            created_at
            FROM 
            '. $this->table . '
            ORDER BY
            id ASC'; 

            //prepare statement
            $stmt = $this->conn->prepare($query); 
            //execute query
            $stmt->execute(); 

            return $stmt;
        }

        public function read_single()
        {
            //create query
            $query = 'SELECT 
            id,
            name,
            created_at
            FROM 
            '. $this->table . ' 
            WHERE 
            id = ?
            LIMIT 0,1'; 

            //prepare statement 
            $stmt = $this->conn->prepare($query);

            //Bind ID
            $stmt->bindParam(1,$this->id);

            //execute query
            $stmt->execute();

            //fetch
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //set properties
            $this->id = $row['id']; // set the id property
            $this->name = $row['name']; // set the name property
        }

        //create post
        public function create() 
        {
            //query
            $query = 'INSERT INTO ' . $this->table . '
            SET 
            name = :name';

            //prepare statement 
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->name = htmlspecialchars(strip_tags($this->name)); 

            //bind data
            $stmt->bindParam(':name',$this->name);

            //execute
            if ($stmt->execute()) {
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }

        //update post 
        public function update()
        {
            //query
            $query = 'UPDATE ' . $this->table . '
            SET 
                name = :name
            WHERE
            id= :id';

            //prepare statement 
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind data
            $stmt->bindParam(':name',$this->name);
            $stmt->bindParam(':id',$this->id);

            //execute
            if ($stmt->execute()) {
                return true;
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }

        public function delete() {
            //query
           $query = 'DELETE FROM ' . $this->table . '
           WHERE
           id= :id';

           //prepare statement 
           $stmt = $this->conn->prepare($query);

           //clean data
           $this->id = htmlspecialchars(strip_tags($this->id));

           //bind data
           $stmt->bindParam(':id',$this->id);

           //execute
           if ($stmt->execute()) {
               return true;
           }

           //print error if something goes wrong
           printf("Error: %s.\n", $stmt->error);
           return false;
       }
    }
?>

