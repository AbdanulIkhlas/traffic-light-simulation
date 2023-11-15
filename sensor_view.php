<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chawnima</title>
</head>

<body>
    <!DOCTYPE html>
    <html>

    <body>
        <?php
        $servername = "localhost";
        $dbname = "esp8266";
        $username = "root";
        $password = "";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Koneksi gagal : " . $conn->connect_error);
        } 
        $sql = "SELECT sensor1, sensor2, status FROM sensor";
        echo 
        '<table cellspacing="5" cellpadding="5">
            <tr> 
                <td>sensor1</td> 
                <td>Sensor2</td> 
                <td>status</td>  
            </tr>';
        if ($result = $conn->query($sql)) {
        while ($row = $result->fetch_assoc()) {
        $row_sensor1 = $row["sensor1"];
        $row_sensor2 = $row["sensor2"];
        $row_status = $row["status"];
        
        echo '<tr> 
            <td>' . $row_sensor1 . '</td> 
            <td>' . $row_sensor2 . '</td> 
            <td>' . $row_status . '</td> 
        </tr>';
        }
        $result->free();
        }
        $conn->close();

        ?>
        </table>
    </body>

    </html>
</body>

</html>