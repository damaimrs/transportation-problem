<html>
<head>
    <title>Vogel Approximation Algorithm</title>
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
            $s_cost = array();
            $d_cost = array();
            $flag_s_cost = array();
            $flag_d_cost = array();
            $arr = array();
            $flag = array();
            $keep_column = 0;
            $keep_row = 0;
            $num = -1;
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
             * Flag untuk menandai cost apakah sudah digunakan atau belum, flag ppengaruh di supply dan demand jika != 0
             */
            for ($var = 1; $var <= $s_supply; $var++) {
                for ($varr = 1; $varr <= $s_demand; $varr++) {
                    $arr[$var][$varr] = 0;
                    $flag[$var][$varr] = 0;   
                }
            }

        $count = 4;
        //melakukan iterasi untuk menentukan cost
        do {

            $cost_max = -1;
            $cost_min = 10000000;            
            for ($var = 1; $var <= $s_demand; $var++) {
                $sort = array();
                for ($varr = 1; $varr <= $s_supply; $varr++) {
                    if ($flag[$varr][$var] == 0 ) {
                        array_push($sort, $cost[$varr][$var]);
                    }
                }

                sort($sort);
                if (count($sort) > 1) {
                    $d_cost[$var] = $sort[1] - $sort[0];
                } else if (count($sort) == 1) {
                    $d_cost[$var] = $sort[0];
                } else {
                    $d_cost[$var] = null;
                }

                if ($cost_max < $d_cost[$var]) {
                    $cost_max = $d_cost[$var];
                    $keep_column = 1;
                    $keep_row = 0;
                    $num = $var;
                }
            }
            
            for ($var = 1; $var <= $s_supply; $var++) {
                $sort = array();
                for ($varr = 1; $varr <= $s_demand; $varr++) {
                    if ($flag[$var][$varr] == 0 ) {
                        array_push($sort, $cost[$var][$varr]);
                    }
                }

                sort($sort);
                if (count($sort) > 1) {
                    $s_cost[$var] = $sort[1] - $sort[0];
                } else if (count($sort) == 1) {
                    $s_cost[$var] = $sort[0];

                } else {
                    $s_cost[$var] = null;
                }               

                if ($cost_max < $s_cost[$var]) {
                    $cost_max = $s_cost[$var];
                    $keep_column = 0;
                    $keep_row = 1;
                    $num = $var;
                } 
                             
            }

            $i_min = 0;
            $j_min = 0;

            if ($keep_row == 1) {
                for ($var = 1; $var <= $s_demand; $var++) {
                    if ($cost_min >= $cost[$num][$var] && $flag[$num][$var] != 1) {
                        $cost_min = $cost[$num][$var];
                        $i_min = $num;
                        $j_min = $var;
                    }
                }
            }

            if ($keep_column == 1) {
                for ($var = 1; $var <= $s_supply; $var++) {
                    if ($cost_min >= $cost[$var][$num] && $flag[$var][$num] != 1 ) {
                        $cost_min = $cost[$var][$num];
                        $i_min = $var;
                        $j_min = $num;
                    }
                }
            }

            if ($supply[$i_min] < $demand[$j_min]) {
                /**
                 * Jika supply kurang dari demand maka demand dikurangi oleh supply dan
                 * di array diser isi supply
                 */
                $arr[$i_min][$j_min] = $supply[$i_min];
                $flag[$i_min][$j_min] = 1;
                $demand[$j_min] = $demand[$j_min] - $arr[$i_min][$j_min];
                $supply[$i_min] = $supply[$i_min] - $arr[$i_min][$j_min];
                $total_demand = $total_demand - $arr[$i_min][$j_min];

                for ($var = 1; $var <= $s_supply; $var++) {
                    $flag[$i_min][$var] = 1;
                }

                // if ($keep_row == 1) {
                //     for ($var = 1; $var <= $s_demand; $var++) {
                //         $flag[$i_min][$var] = 1;
                //     }
                // }

                // if ($keep_column == 1) {
                //     for ($var = 1; $var <= $s_demand; $var++) {
                //         $flag[$var][$j_min] = 1;
                //     }
                // }

            } else if ($supply[$i_min] > $demand[$j_min]) {
                // *
                //  * Jika supply lebih besar daripada demand, maka supply dikurangi demand dan
                //  * di array diset isi demand
                        
                $arr[$i_min][$j_min] = $demand[$j_min];
                $demand[$j_min] = $demand[$j_min] - $arr[$i_min][$j_min];
                $supply[$i_min] = $supply[$i_min] - $arr[$i_min][$j_min];                        
                $total_demand = $total_demand - $arr[$i_min][$j_min];

                for ($var = 1; $var <= $s_demand; $var++) {
                    $flag[$var][$j_min] = 1;
                }
            } 
            else {
                /**
                 * Jika demand dan supply pada kolom tersebut sama, maka diset 0 untuk demand dan supplynya dan
                 * di array diset isi dari supply
                 */
                $arr[$i_min][$j_min] = $supply[$i_min];
                $supply[$i_min] = 0;
                $demand[$j_min] = 0;

                for ($var = 1; $var <= $s_demand; $var++) {
                    $flag[$var][$j_min] = 1;
                }

                for ($var = 1; $var <= $s_supply; $var++) {
                    $flag[$i_min][$var] = 1;
                }

                $total_demand = $total_demand - $arr[$i_min][$j_min];
            }

            $count --;
                
            } while ($total_demand > 0);

            echo "<table class='table'>";
            echo "<h2 align='center'>Tabel Optimalisasi dengan Metode VA</h2>";
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

            echo "Total Cost :&nbsp;" . number_format($total);
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