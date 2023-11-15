<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Traffic Light</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('Image/background.jpg') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
    <script>
        setTimeout(function () {
            location.reload();
        }, 5000); // Refresh setiap 5 detik (5000 milidetik)
    </script>
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
        $sql = "SELECT * FROM sensor ORDER BY id ASC";
        if ($result = $conn->query($sql)) {
        while ($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $row_sensor1 = $row["sensor1"];
        $row_sensor2 = $row["sensor2"];
        $row_status = $row["status"];
        }
        ?>
        <?php
        $result->free();
        }
        ?>

        <!-- <table cellspacing="5" cellpadding="5">
            <tr>
                <td>ID</td>
                <td>sensor1</td>
                <td>Sensor2</td>
                <td>status</td>
            </tr>
            <tr>
                <td><?php //echo $id ?></td>
                <td><?php //echo $row_sensor1 ?></td>
                <td><?php //echo $row_sensor2 ?></td>
                <td><?php //echo $row_status ?></td>
            </tr>
        </table> -->

        <section>
            <!-- judul -->
            <div class="judul">
                <h1 class="text-white text-center text-6xl font-bold mt-16">MONITORING TRAFFIC LIGHT</h1>
            </div>

            <!-- container terbaru-->
            <div class="rounded-2xl border-4 border-gray-600 w-2/5 mx-auto mt-10 bg-slate-100 p-5 ">
                <!-- content -->
                <div>
                    <h1 class="text-center text-3xl font-bold mb-7">TERBARU</h1>
                    <table class="table-auto border-2 border-black w-full text-center">
                        <thead class="font-bold border-2 border-black">
                            <th>ID</th>
                            <th>SENSOR 1</th>
                            <th>SENSOR 2</th>
                            <th>STATUS</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $id ?></td>
                                <td><?php echo $row_sensor1 ?></td>
                                <td><?php echo $row_sensor2 ?></td>
                                <td><?php echo $row_status ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- container overall -->
            <div class="rounded-2xl border-4 border-gray-600 w-2/5 h-72 mx-auto mt-14 bg-slate-100 p-5 ">
                <!-- content -->
                <?php 
                $sql2 = "SELECT * FROM sensor ORDER BY id DESC";
                ?>
                <div>
                    <h1 class="text-center text-3xl font-bold mb-7">OVERALL</h1>
                    <!-- judul tabel (sticky)-->
                    <div class="flex font-bold border-2 border-black">
                        <h1 class="ml-14">ID</h1>
                        <h1 class="ml-24">SENSOR 1</h1>
                        <h1 class="ml-16">SENSOR 2</h1>
                        <h1 class="ml-16">STATUS</h1>
                    </div>
                    <!-- container tabel -->
                    <div class="border-2 border-black border-t-transparent h-36 overflow-y-auto">
                        <table class="table-fixed w-full text-center">
                            <?php 
                            if ($result = $conn->query($sql2)) {
                                while ($row = $result->fetch_assoc()) {
                                $id = $row["id"];
                                $row_sensor1 = $row["sensor1"];
                                $row_sensor2 = $row["sensor2"];
                                $row_status = $row["status"];
                            ?>

                            <tr>
                                <td><?php echo $id ?></td>
                                <td><?php echo $row_sensor1 ?></td>
                                <td><?php echo $row_sensor2 ?></td>
                                <td><?php echo $row_status ?></td>
                            </tr>

                            <?php
                            }
                            $result->free();
                            }
                            $conn->close();
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </body>

    </html>
</body>

</html>