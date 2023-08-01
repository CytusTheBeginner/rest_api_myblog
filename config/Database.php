<?php
class Database {
    //DB Params
    //private memiliki arti bahwa properti yang ada hanya dapat diakses dari dalam class itu sendiri
    private $host = 'localhost'; //properti alamat host dari database MySQL
    private $db_name = 'myblog'; //Properti nama database yang digunakan
    private $username = 'root'; //Properti nama pengguna untuk koneksi ke database
    private $password = ''; //Properti kata sandi untuk koneksi ke database (dikosongkan bila tidak diset password)
    private $conn; //connection (variabel untuk menyimpan objek koneksi database)

    //DB Connect
    //public memiliki arti bahwa properti yang ada dapat diakses dari dalam class,dari luar class bahkan dari subclass.
    public function connect() {
        $this->conn = null; //reset connection dengan mengosongkan variabel conn
        try {
            //membuat objek koneksi menggunakan PHP Data Objects dengan parameter host, nama database, username, dan password
            $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name,$this->username,$this->password); //create connection

            //mengatur attribut untuk koneksi yang baru dibuat dengan setAttribute
            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE, //set attribute (konstanta yang menentukan bagaimana PDO melaporkan kesalahan)
                PDO::ERRMODE_EXCEPTION //set error mode (melemparkan eksepsi jika terjadi kesalahan)
            );
        } catch(PDOException $e) {
            //menangkap (catch) eksepsi yang terjadi jika ada kesalahan dalam koneksi (PDOException) lalu menampilkan error message
            echo 'connection error: ' . $e->getMessage(); //output error message

        }
        return $this->conn;//return connection (Mengembalikan objek koneksi, sehingga bisa digunakan untuk berinteraksi dengan database)
    }
}
?>