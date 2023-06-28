<?php
// Include file koneksi.php untuk mendapatkan koneksi ke database
include 'connection.php';
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$conn = getConnection();

// Mendapatkan data yang dikirim melalui metode GET
$nomor = isset($_GET['nomor']) ? $_GET['nomor'] : '';

try {
    // Query SQL untuk mendapatkan data anggota berdasarkan nomor
    $query = "SELECT * FROM anggota WHERE nomor = :nomor";

    // Mempersiapkan statement PDO untuk eksekusi query
    $statement = $conn->prepare($query);

    // Mengikat parameter dengan nilai yang sesuai
    $statement->bindParam(':nomor', $nomor);

    // Eksekusi statement
    $statement->execute();

    // Mendapatkan hasil query dalam bentuk array asosiatif
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    // Mengirimkan response sukses beserta data anggota
    $response = [
        'status' => 'success',
        'data' => $result
    ];
} catch(PDOException $e) {
    // Jika terjadi error, tampilkan pesan error
    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan saat mengambil data anggota: ' . $e->getMessage()
    ];
}

// Mengirimkan response JSON
header('Content-Type: application/json');
echo json_encode($response);

// Menutup koneksi
$conn = null;
?>
