<?php
    class Post 
    //nama class Post untuk mengelola objek 
    {
        //DB Stuff
        private $conn; //connection (menyimpan objek koneksi database)
        private $table = 'posts'; //table name (menyimpan/mengambil nama tabel dalam database yang akan digunakan)

        //post properties
        public $id; //properti untuk menyimpan data id
        public $category_id; //properti untuk menyimpan data category id
        public $category_name; //properti untuk menyimpan data category name
        public $title; //properti untuk menyimpan data title
        public $body; //properti untuk menyimpan data body
        public $author; //properti untuk menyimpan data author
        public $created_at; //properti untuk menyimpan data tanggal dibuat (created at)

        //constructor with database
        public function __construct($db)
        // __construct merupakan metode khusus yang akan dijalankan secara otomatis saat objek "post" dibuat. yang digunakan untuk menginisialisasi objek koneksi database yang diterima sebagai argumen
        {
            //contruct menerima satu parameter db untuk objek koneksi ke database
            $this->conn = $db;
        }

        //get posts
        public function read()
        // read digunakan untuk mengambil semua data dari database
        {
            //create query
            $query = 'SELECT 
            c.name as category_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.created_at
            FROM 
            '. $this->table . ' p 
            LEFT JOIN 
            categories c ON p.category_id = c.id
            ORDER BY
            p.created_at DESC'; 
            //buat query untuk mengambil data post dan informasi kategori terkait menggunakan JOIN, Left join 
            // LEFT JOIN adalah salah satu jenis operasi JOIN dalam SQL yang digunakan untuk menggabungkan dua tabel berdasarkan kolom tertentu, dan mengambil semua data dari tabel kiri dan data yang cocok dari tabel kanan. Jika tidak ada cocokan di tabel kanan, nilai NULL akan diisi untuk kolom dari tabel kanan tersebut.

            //prepare statement
            $stmt = $this->conn->prepare($query); //menyiapkan data dari SQl menggunakan objek koneksi database

            //execute query
            $stmt->execute(); // eksekusi data yang sudah dipersiapkan

            return $stmt; //mengembalikan hasil dari eksekusi query
        }

        //get single post
        public function read_single()
        {
            //create query
            $query = 'SELECT 
            c.name as category_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.created_at
            FROM 
            '. $this->table . ' p 
            LEFT JOIN 
            categories c ON p.category_id = c.id
            WHERE
            p.id = ?
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
            $this->title = $row['title']; // set the title property
            $this->body = $row['body']; // set the body property
            $this->author = $row['author']; //set the author property
            $this->category_id = $row['category_id']; //set the category id property
            $this->category_name = $row['category_name']; //set the category name property
        }
    }
?>