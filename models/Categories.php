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
            created_at DESC'; 

            //prepare statement
            $stmt = $this->conn->prepare($query); 
            //execute query
            $stmt->execute(); 

            return $stmt;
        }
    }
?>

