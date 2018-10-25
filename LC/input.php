<html>
<head>
    <title>Least Cost Algorithm</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body style="margin: 20px 20px 20px 20px;">
	<div class="container fluid">
		<?php		
		if($_POST != NULL) {

			$supply = $_POST['supply'];
			$demand = $_POST['demand'];

			if ($supply > 6 && $demand > 6) {
				echo '<div class="alert alert-danger">Demand atau Supply tidak boleh lebih dari 6!</div>';
				echo '<a class="btn btn-info btn-md" href="index.php" role="button">Kembali Ke Halaman Utama</a>';
			} else { 
				?>
				<form action="algo.php" method="post">
                    <table class="table">
                    	<tr>
                    		<td>Supply/Demand</td>
                    		<?php
                    			for ($count = 1; $count<=$demand; $count++) {
                    				echo "<td> D $count </td>";
                    			}
                    		?>
                    		<td>Supply Needed</td>
                    	</tr>
                    	<?php
                    		for ($count_a = 1; $count_a<=$supply; $count_a++) {
                    			echo "<tr><td>S $count_a</td>";
                    			for ($count_b = 1; $count_b<=$demand; $count_b++) {
                    				?>
                    				<td>	
	                    				<div class="form-group" style="width: 50px;">
			                                <input type="text" class="form-control" name="cost[<?php echo $count_a?>][<?php echo $count_b?>]">
			                            </div>
	                    			</td>
                    			<?php
                    			}
                    			?>
                    			<td>
            						<div class="form-group" style="width: 50px;">
		                                <input type="text" class="form-control" name="supply[<?php echo $count_a ?>]">
		                            </div>
		                        </td>
                    			<?php
                    			echo '</tr>';
                    		}
                    	?>
                    	<tr>
                    		<td>Demand Requested</td>
                    		<?php
                    			for($count_c = 1; $count_c<=$demand; $count_c++) {
                    				?>
                    					<td>	
		                    				<div class="form-group" style="width: 50px;">
				                                <input type="text" class="form-control" name="demand[<?php echo $count_c ?>]">
				                            </div>
		                    			</td>
                    			<?php
                    			}
                    			?>
                    			<td>	
                    			</td>
                    	</tr>
                    	<div class="form-group" style="width: 50px;" hidden>
                            <input type="text" class="form-control" name="s_demand" value="<?php echo $demand?>">
                        </div>
                        <div class="form-group" style="width: 50px;">
                            <input type="text" class="form-control" name="s_supply" value="<?php echo $supply?>" hidden>
                        </div>	
                   </table>
                   <button class="btn btn-info btn-md" type="submit" style="float: right;">Submit</button>
               </form>
			<?php
			}
		}
	?>
	</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>