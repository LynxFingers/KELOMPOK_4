<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table {
            border-collapse: collapse;
            width: 60%;
            margin: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
    </style>
    <title>Round Robin Simulation (PHP)</title>
</head>

<body>
    <h2>
        Studi Literatur Penjaddwalan Proses
    </h2>
    <p>
        Kelompok 6 
    </p>



    <?php
    // Data proses
    $processes = array(
        array("P1", 0, 10, 3),
        array("P2", 2, 5, 1),
        array("P3", 3, 9, 2),
        array("P4", 3, 8, 1),
        array("P5", 5, 3, 2)
    );
    ?>

    <table>
        <thead>
            <tr>
                <th>Proses</th>
                <th>Kedatangan</th>
                <th>Burst Time</th>
                <th>Prioritas</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Menampilkan data proses
            foreach ($processes as $process) {
                echo "<tr>";
                foreach ($process as $data) {
                    echo "<td>$data</td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <p2>
        Menjalankan proses menggunakan 2 versi yaitu.
        versi 1 hanya menggunakan Teknik Round Robin dan versi 2 Menggabungkan Teknik Round Robin Dengan Priority Scheduling jika Quantum = 3
    </p2>

    <p>

    </p>
    <h1>

    </h1>


    <h3>
        Versi 1
    </h3>
    <h4>
        1.Teknik Round Robin
    </h4>

    <!-- Table for Burst Time, Sisa Burst Time, Waiting Time, and Quantum -->
    <table>
        <tr>
            <th>Proses</th>
            <th>Kedatangan</th>
            <th>Burst Time</th>
            <th>Sisa Burst Time</th>
            <th>Waiting Time</th>
            <th>Quantum</th>
        </tr>

        <?php
        // Data proses
        $processes = [
            ['name' => 'P1', 'arrivalTime' => 0, 'burstTime' => 10, 'priority' => 3],
            ['name' => 'P2', 'arrivalTime' => 2, 'burstTime' => 5, 'priority' => 1],
            ['name' => 'P3', 'arrivalTime' => 3, 'burstTime' => 9, 'priority' => 2],
            ['name' => 'P4', 'arrivalTime' => 3, 'burstTime' => 8, 'priority' => 1],
            ['name' => 'P5', 'arrivalTime' => 5, 'burstTime' => 3, 'priority' => 2],
        ];

        // Quantum
        $quantum = 3;

        // Inisialisasi variabel waktu
        $currentTime = 0;

        // Inisialisasi variabel Total TAT
        $totalTAT = 0;

        // Eksekusi proses
        while (true) {
            $allProcessesCompleted = true;

            foreach ($processes as &$process) {
                if ($process['burstTime'] > 0) {
                    $allProcessesCompleted = false;

                    $executeTime = min($quantum, $process['burstTime']);
                    $process['burstTime'] -= $executeTime;

                    // Hitung Turnaround Time (TAT) dan Waiting Time
                    $tat = $currentTime + $executeTime - $process['arrivalTime'];
                    $waitingTime = $tat - $executeTime;

                    // Tambahkan ke Total TAT
                    $totalTAT += $tat;

                    // Tampilkan hasil pada tabel
                    echo "<tr>";
                    echo "<td>{$process['name']}</td>";
                    echo "<td>{$process['arrivalTime']}</td>";
                    echo "<td>{$executeTime}</td>";
                    echo "<td>{$process['burstTime']}</td>";
                    echo "<td>{$waitingTime}</td>";
                    echo "<td>{$quantum}</td>";
                    echo "</tr>";

                    $currentTime += $executeTime;
                }
            }

            if ($allProcessesCompleted) {
                break;
            }
        }
        ?>
    </table>

    <!-- Table for Turnaround Time (TAT) -->
    <table style="margin-top: 20px;">
        <tr>
            <th>Proses</th>
            <th>Turnaround Time (TAT)</th>
        </tr>

        <?php
        // Hitung dan tampilkan TAT pada tabel terpisah
        foreach ($processes as $process) {
            $tat = $currentTime - $process['arrivalTime'];
            echo "<tr>";
            echo "<td>{$process['name']}</td>";
            echo "<td>{$tat}</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <!-- Table for Average Turnaround Time (TAT) -->
    <table style="margin-top: 20px;">
        <tr>
            <th>Rata-rata TAT</th>
        </tr>
        <tr>
            <td><?php echo $totalTAT / count($processes); ?></td>
        </tr>
    </table>

    <!-- Table for Burst Time, Sisa Burst Time, Waiting Time, Priority, and Quantum -->

    <h3>
        Versi 2
    </h3>

    <h4>
        2.Menggabungkan Teknik Round Robin dan Priority Scheduling
    </h4>
    <table>
        <tr>
            <th>Proses</th>
            <th>Kedatangan</th>
            <th>Burst Time</th>
            <th>Sisa Burst Time</th>
            <th>Waiting Time</th>
            <th>Priority</th>
            <th>Quantum</th>
        </tr>

        <?php
        // Data proses
        $processes = [
            ['name' => 'P1', 'arrivalTime' => 0, 'burstTime' => 10, 'priority' => 3],
            ['name' => 'P2', 'arrivalTime' => 2, 'burstTime' => 5, 'priority' => 1],
            ['name' => 'P3', 'arrivalTime' => 3, 'burstTime' => 9, 'priority' => 2],
            ['name' => 'P4', 'arrivalTime' => 3, 'burstTime' => 8, 'priority' => 1],
            ['name' => 'P5', 'arrivalTime' => 5, 'burstTime' => 3, 'priority' => 2],
        ];

        // Quantum
        $quantum = 3;

        // Inisialisasi variabel waktu
        $currentTime = 0;

        // Eksekusi proses
        while (true) {
            $allProcessesCompleted = true;

            // Urutkan proses berdasarkan prioritas dan waktu kedatangan
            usort($processes, function ($a, $b) use ($currentTime) {
                if ($a['priority'] == $b['priority']) {
                    return $a['arrivalTime'] - $b['arrivalTime'];
                }
                return $a['priority'] - $b['priority'];
            });

            foreach ($processes as &$process) {
                if ($process['burstTime'] > 0 && $process['arrivalTime'] <= $currentTime) {
                    $allProcessesCompleted = false;

                    // Tentukan quantum untuk proses dengan prioritas tertinggi
                    $executeTime = min($quantum, $process['burstTime']);

                    // Kurangi burst time
                    $process['burstTime'] -= $executeTime;

                    // Hitung Waiting Time
                    $waitingTime = max(0, $currentTime - $process['arrivalTime']);

                    // Tampilkan hasil pada tabel
                    echo "<tr>";
                    echo "<td>{$process['name']}</td>";
                    echo "<td>{$process['arrivalTime']}</td>";
                    echo "<td>{$executeTime}</td>";
                    echo "<td>{$process['burstTime']}</td>";
                    echo "<td>{$waitingTime}</td>";
                    echo "<td>{$process['priority']}</td>";
                    echo "<td>{$quantum}</td>";
                    echo "</tr>";

                    $currentTime += $executeTime;
                }
            }

            if ($allProcessesCompleted) {
                break;
            }
        }
        ?>
    </table>

    <!-- Table for Turnaround Time (TAT) -->
    <table style="margin-top: 20px;">
        <tr>
            <th>Proses</th>
            <th>Turnaround Time (TAT)</th>
        </tr>

        <?php
        // Inisialisasi variabel Total TAT
        $totalTAT = 0;

        // Tampilkan TAT pada tabel terpisah
        foreach ($processes as $process) {
            $tat = $currentTime - $process['arrivalTime'];
            $totalTAT += $tat;
            echo "<tr>";
            echo "<td>{$process['name']}</td>";
            echo "<td>{$tat}</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <!-- Table for Average Turnaround Time (TAT) -->
    <table style="margin-top: 20px;">
        <tr>
            <th>Rata-rata TAT</th>
        </tr>
        <tr>
            <td><?php echo $totalTAT / count($processes); ?></td>
        </tr>
    </table>

    <p>
        Dalam implementasi ini, proses diurutkan berdasarkan prioritas, dan jika terdapat beberapa proses dengan prioritas yang sama, prioritasnya dibandingkan berdasarkan waktu kedatangan. Semua proses yang memiliki prioritas sama akan dieksekusi sesuai dengan aturan Round Robin dengan menggunakan quantum yang ditentukan.
    </p>
<h4>
1.Prioritas Dievaluasi Terlebih Dahulu:
</h4>
    <p>
        Proses diurutkan berdasarkan prioritas. Jika ada beberapa proses dengan prioritas yang sama, prioritas dievaluasi berdasarkan waktu kedatangan.
    </p>

    <h4>
    2.Round Robin pada Proses dengan Prioritas yang Sama:
    </h4>

    <p>
    Jika ada beberapa proses dengan prioritas yang sama, proses-proses ini dieksekusi sesuai dengan aturan Round Robin dengan menggunakan quantum yang ditentukan.
    </p>

</body>

</html>