<?php

class Database
{
    public $conn;
    private $hostname = 'localhost';
    private $db_name = 'cpl_laravel';
    private $username = 'root';
    private $password = '';

    public function dbConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->hostname . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}

class Admin
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }

    public function cekNIP($nip)
    {
        $query = "SELECT * FROM dosen_admins WHERE nip='$nip'";
        return $this->conn->query($query);
    }

    public function cekUser($user)
    {
        $query = "SELECT * FROM users WHERE username='$user'";
        return $this->conn->query($query);
    }

    public function cekmhs($user)
    {
        $query = "SELECT * FROM mahasiswas WHERE nim='$user'";
        return $this->conn->query($query);
    }

    public function cekmk($user)
    {
        $query = "SELECT * FROM mata_kuliahs WHERE kode='$user'";
        return $this->conn->query($query);
    }

    public function cekcpl($user)
    {
        $query = "SELECT * FROM cpls WHERE kode_cpl='$user'";
        return $this->conn->query($query);
    }

    public function cekcpmk($id_cpmk, $id_mk)
    {
        $query = "SELECT * FROM cpmks WHERE kode_cpmk='$id_cpmk' AND mata_kuliah_id='$id_mk'";
        return $this->conn->query($query);
    }
}

$admin = new Admin();

if (!empty($_POST["nip"])) {
    $nip = $_POST["nip"];
    $admin->cekNIP($nip);
    $user_count1 = $admin->cekNIP($nip);
    if ($user_count1->rowCount() > 0) {
        echo "<span id='status-1' class='status-not-available' style='color: darkred'> NIP Sudah Terpakai.</span>";
    } else {
        echo "<span id='status-1' class='status-available' style='color: darkgreen'> NIP Dapat Dipakai.</span>";
    }
}

if (!empty($_POST["username"])) {
    $username = $_POST["username"];
    $admin->cekUser($username);
    $user_count2 = $admin->cekUser($username);
    if ($user_count2->rowCount() > 0) {
        echo "<span id='status-2' class='status-not-available' style='color: darkred'> Username Sudah Terpakai.</span>";
    } else {
        echo "<span id='status-2' class='status-available' style='color: darkgreen'> Username Dapat Dipakai.</span>";
    }
}

if (!empty($_POST["nim"])) {
    $nim = $_POST["nim"];
    $admin->cekmhs($nim);
    $user_count3 = $admin->cekmhs($nim);
    if ($user_count3->rowCount() > 0) {
        echo "<span id='status-3' class='status-not-available' style='color: darkred'> NIM Sudah Terpakai.</span>";
    } else {
        echo "<span id='status-3' class='status-available' style='color: darkgreen'> NIM Dapat Dipakai.</span>";
    }
}

if (!empty($_POST["kode"])) {
    $kode = $_POST["kode"];
    $admin->cekmk($kode);
    $user_count4 = $admin->cekmk($kode);
    if ($user_count4->rowCount() > 0) {
        echo "<span id='status-4' class='status-not-available' style='color: darkred'> Kode Mata Kuliah Sudah Terpakai.</span>";
    } else {
        echo "<span id='status-4' class='status-available' style='color: darkgreen'> Kode Mata Kuliah Dapat Dipakai.</span>";
    }
}

if (!empty($_POST["kode_cpl"])) {
    $kode = $_POST["kode_cpl"];
    $admin->cekcpl($kode);
    $user_count4 = $admin->cekcpl($kode);
    if ($user_count4->rowCount() > 0) {
        echo "<span id='status-4' class='status-not-available' style='color: darkred'> Kode CPL Sudah Terpakai.</span>";
    } else {
        echo "<span id='status-4' class='status-available' style='color: darkgreen'> Kode CPL Dapat Dipakai.</span>";
    }
}

if (!empty($_POST["kode_cpmk"])) {
    $kode = $_POST["kode_cpmk"];
    $id = $_POST["mata_kuliah"];
    $admin->cekcpmk($kode, $id);
    $user_count4 = $admin->cekcpmk($kode, $id);
    if ($user_count4->rowCount() > 0) {
        echo "<span id='status-4' class='status-not-available' style='color: darkred'> Kode CPMK Sudah Terpakai.</span>";
    } else {
        echo "<span id='status-4' class='status-available' style='color: darkgreen'> Kode CPMK Dapat Dipakai.</span>";
    }
}
