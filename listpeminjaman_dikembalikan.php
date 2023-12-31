<?php
// Include file koneksi.php untuk mendapatkan koneksi ke database
include 'connection.php';
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$conn = getConnection();

try {
    // Query SQL untuk mengambil daftar peminjaman dengan status DIKEMBALIKAN
    $query = "SELECT * FROM peminjaman_master WHERE status_peminjaman = 'DIKEMBALIKAN'";

    // Mempersiapkan statement PDO untuk eksekusi query
    $statement = $conn->prepare($query);

    // Eksekusi statement
    $statement->execute();

    // Mengambil semua baris hasil sebagai array
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Mengembalikan response sukses dengan data peminjaman
    $response = [
        'status' => 'success',
        'data' => $result
    ];
} catch (PDOException $e) {
    // Jika terjadi error, tampilkan pesan error
    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan saat mengambil daftar peminjaman: ' . $e->getMessage()
    ];
}

// Mengirimkan response JSON
header('Content-Type: application/json');
echo json_encode($response);

// Menutup koneksi
$conn = null;
?>
