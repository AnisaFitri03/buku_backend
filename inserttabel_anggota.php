<?php
// Include file koneksi.php untuk mendapatkan koneksi ke database
include 'connection.php';
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$conn = getConnection();

// Mendapatkan data yang dikirim melalui metode POST
$nomor = isset($_POST['nomor']) ? $_POST['nomor'] : '';
$nama = isset($_POST['nama']) ? $_POST['nama'] : '';
$jenisKelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : '';
$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
$noHp = isset($_POST['no_hp']) ? $_POST['no_hp'] : '';
$tanggalTerdaftar = isset($_POST['tanggal_terdaftar']) ? $_POST['tanggal_terdaftar'] : '';

try {
    // Query SQL untuk insert data anggota
    $query = "INSERT INTO anggota (nomor, nama, jenis_kelamin, alamat, no_hp, tanggal_terdaftar) 
              VALUES (:nomor, :nama, :jenisKelamin, :alamat, :noHp, :tanggalTerdaftar)";

    // Mempersiapkan statement PDO untuk eksekusi query
    $statement = $conn->prepare($query);

    // Mengikat parameter dengan nilai yang sesuai
    $statement->bindParam(':nomor', $nomor);
    $statement->bindParam(':nama', $nama);
    $statement->bindParam(':jenisKelamin', $jenisKelamin);
    $statement->bindParam(':alamat', $alamat);
    $statement->bindParam(':noHp', $noHp);
    $statement->bindParam(':tanggalTerdaftar', $tanggalTerdaftar);

    // Eksekusi statement
    $statement->execute();

    // Mengembalikan response sukses
    $response = [
        'status' => 'success',
        'message' => 'Data anggota berhasil ditambahkan'
    ];
} catch(PDOException $e) {
    // Jika terjadi error, tampilkan pesan error
    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan saat menambahkan data anggota: ' . $e->getMessage()
    ];
}

// Mengirimkan response JSON
header('Content-Type: application/json');
echo json_encode($response);

// Menutup koneksi
$conn = null;
?>
