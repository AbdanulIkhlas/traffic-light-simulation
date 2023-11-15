<?php
$servername = "localhost";
$dbname = "esp8266";
$username = "root";
$password = "";
$api_key_value = "123456789";
$api_key= $sensor1 = $sensor2 = $status = "";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $api_key = test_input($_GET["api_key"]);
    if($api_key == $api_key_value) {
        $sensor1 = test_input($_GET["sensor1"]);
        $sensor2 = test_input($_GET["sensor2"]);
        $status = test_input($_GET["status"]);

        $status = ($status == "JalananSepi") ? "Jalanan Sepi" : "Jalanan Padat";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Koneksi Gagal: " . $conn->connect_error);
        } 

        $sql = "INSERT INTO sensor (sensor1, sensor2, status) VALUES ('" . $sensor1 . "', '" . $sensor2 . "', '" . $status . "')";

        if ($conn->query($sql) === TRUE) {
            echo "Record baru berhasil dibuat ";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    else {
        echo "Verifikasi API Key gagal.";
    }
}
else {
    echo "Tidak ada data dikirim melalui HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}