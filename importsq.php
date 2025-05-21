<?php
// Konfigurasi database
$host = 'localhost';
$user = 'root';
$pass = 'password';
$db   = 'nama_database';

// Lokasi file SQL yang akan dikirim
$sqlFile = __DIR__ . '/upload.sql';

// Hubungkan ke MySQL
$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
    die("Gagal koneksi MySQL: " . $mysqli->connect_error);
}

// Baca isi file SQL
$sql = file_get_contents($sqlFile);
if (!$sql) {
    die("File kosong atau gagal dibaca.");
}

// Eksekusi SQL (multi-query jika banyak statement)
if ($mysqli->multi_query($sql)) {
    do {
        // Flush hasil tiap query
        if ($result = $mysqli->store_result()) {
            $result->free();
        }
    } while ($mysqli->more_results() && $mysqli->next_result());
    echo "Import berhasil!";
} else {
    echo "Import gagal: " . $mysqli->error;
}
