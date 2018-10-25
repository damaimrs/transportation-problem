<html>
<head>
    <title>North West Corner Algorithm</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body style="margin: 20px 20px 20px 20px;">
    <div class="container fluid">
        <?php
        if ($_POST != NULL) {
            $total = 0;
            $count = 0;
            $total_supply = 0;
            $total_demand = 0;
            $total_demand_supply = 0;
            $selisih = 0;
            $dummy_supply = 0;
            $dummy_demand = 0;
            $supply = $_POST['supply'];
            $demand = $_POST['demand'];
            $x_supply = $_POST['supply'];
            $x_demand = $_POST['demand'];
            $s_supply = $_POST['s_supply'];
            $s_demand = $_POST['s_demand'];
            $cost = $_POST['cost'];
            $arr = array();
            $i = 1;
            $j = 1;

        /**
         * Dummy diperlukan apabila data demand dan supply tidak sama
         */

        /**
         * Menghitung total Demand untuk menentukan apakah perlu dummy
         */
            for ($var = 1; $var <= $s_demand; $var++) {
                $total_demand = $total_demand + $x_demand[$var];
            }

        /**
         * Menghitung total Supply untuk menentukan apakah perlu dummy
         */
            for ($var = 1; $var <= $s_supply; $var++) {
                $total_supply = $total_supply + $x_supply[$var];
            }

        /**
         * Mengecek dummy data
         */
            if ($total_supply > $total_demand) {
                $total_demand_supply = $total_supply;
                $selisih = $total_supply - $total_demand;
                $s_demand = $s_demand + 1;
                $x_demand[$s_demand] = $selisih;
                $demand[$s_demand] = $selisih;
                //status dummy
                $dummy_demand = 1;
                for ($f = 1; $f <= $s_supply; $f++) {
                    //set value dummy
                    $cost[$f][$s_demand] = 0;
                }
            } else if ($total_supply < $total_demand) {
                $total_demand_supply = $total_demand;
                $selisih = $total_demand - $total_supply;
                $s_supply = $s_supply + 1;
                $x_supply[$s_supply] = $selisih;
                $supply[$s_supply] = $selisih;
                //status dummy
                $dummy_supply = 1;
                for ($f = 1; $f <= $s_demand; $f++) {
                    //set value dummy
                    $cost[$s_supply][$f] = 0;
                }
            } else {
                $total_demand_supply = $total_demand;
            }


            for ($var = 1; $var <= $s_supply; $var++) {
                for ($varr = 1; $varr <= $s_demand; $varr++) {
                    $arr[$var][$varr] = 0;   
                }
            }

        //melakukan iterasi untuk menentukan cost
            do {
                if ($supply[$i] < $demand[$j]) {
                    /**
                     * Jika supply kurang dari demand maka demand dikurangi oleh supply dan
                     * di array diser isi supply
                     */
                    $arr[$i][$j] = $supply[$i];
                    $demand[$j] = $demand[$j] - $supply[$i];
                    $supply[$i] = 0;
                    $i++;
                    $count++;
                } else if ($supply[$i] > $demand[$j]) {
                    /**
                     * Jika supply lebih besar daripada demand, maka supply dikurangi demand dan
                     * di array diset isi demand
                     */
                    $arr[$i][$j] = $demand[$j];
                    $supply[$i] = $supply[$i] - $demand[$j];
                    $demand[$j] = 0;
                    $j++;
                    $count++;
                } else {
                    /**
                     * Jika demand dan supply pada kolom tersebut sama, maka diset 0 untuk demand dan supplynya dan
                     * di array diset isi dari supply
                     */
                    $arr[$i][$j] = $supply[$i];
                    $supply[$i] = 0;
                    $demand[$j] = 0;
                    $i++;
                    $j++;
                    $count++;
                }
            } while ($count <= $s_supply + $s_demand - 2);

            echo "<table class='table'>";
            echo "<h2 align='center'>Tabel Optimalisasi dengan Metode NWC</h2>";
            echo "<table  class='table' align='center'>";
            echo" <tr><td>S / D</td>";
            for ($w = 1; $w <= $s_demand; $w++) {
                if ($w == $s_demand && $dummy_demand == 1) {
                    echo"<td>Dummy</td>";
                } else {
                    echo"<td>D$w</td>";
                }
            }
            echo"<td>Total Supply</td>";
            echo"</tr>";
            for ($i = 1; $i <= $s_supply; $i++) {
                echo"<tr>";
                if ($i == $s_supply && $dummy_supply == 1) {
                    echo"<td>dummy</td>";
                } else {
                    echo"<td>S$i</td>";
                }
                for ($j = 1; $j <= $s_demand; $j++) {

                    if ($arr[$i][$j] > 0) {
                        echo"<td><table ><tr ><td  rowspan='1' width='50'>" . $arr[$i][$j] . '</td><td style="border-left:1px solid;border-bottom:1px solid;" >' . $cost[$i][$j] . "</td></tr><tr><td>&nbsp;</td></tr></table></td>";
                    } else {
                        echo"<td><table ><tr ><td  rowspan='1' width='50'>0</td><td style='border-left:1px solid;border-bottom:1px solid;width:auto;'>" . $cost[$i][$j] . "</td></tr><tr><td>&nbsp;</td></tr></table></td>";
                    }
                    if ($j == $s_demand) {
                        echo"<td>" . $x_supply[$i] . "</td>";
                    }
                }

                echo"</tr>";
            }

            echo"<tr><td>Total Demand</td>";

            for ($l = 1; $l <= $s_demand; $l++) {
                echo"<td>" . $x_demand[$l] . "</td>";
            }

            echo"<td>$total_demand_supply</td>";
            echo"</tr>";
            echo "</table>";
            echo "</table";
            echo"<table>";
            echo "<legend align='center'>Hasil Optimalisasi</legend>";
            echo"<div align='center'>";
            for ($i = 1; $i <= $s_supply; $i++) {

                for ($j = 1; $j <= $s_demand; $j++) {
                    
                    if ($arr[$i][$j] > 0 && $cost[$i][$j] > 0) {
                        echo"Supply $i x Demand $j =&nbsp;" . $cost[$i][$j] . "&nbsp;x&nbsp;" . $arr[$i][$j] . "&nbsp;=&nbsp;" . $cost[$i][$j] * $arr[$i][$j] . "&nbsp;";
                        echo "<br />";
                    } else {
                        continue;
                    }
                }
                
            }
            
            /**
             * Menghitung cost yang diperlukan
             */

            for ($i = 1; $i <= $s_supply; $i++) {
                for ($j = 1; $j <= $s_demand; $j++) {
                    $total = $total + ($cost[$i][$j] * $arr[$i][$j]);
                }  
            }

            echo "Total Cost :&nbsp;Rp" . number_format($total);
            echo"<br /><a href='index.php'>Ulangi</a>";
            echo"</div>";
            echo"</table>";
        } else {
            header("location:index.php");
        }
        ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>