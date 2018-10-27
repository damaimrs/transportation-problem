<html>
<head>
    <title>Vogel Approximation Algorithm</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body style="margin: 20px 20px 20px 20px;">
    <div class="container fluid">
        <div class="col-sm-8" id="main-page">
            <div class="jumbotron">
               <h1 class="display-4">Hello!</h1>
               <p class="lead">Melalui website ini anda dapat menghitung cost dengan menggunakan Vogel Approximation Algorithm.</p>
               <form action="input.php" method="post">
                    <table class="table">
                        <tr>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Supply :</label>
                                <input type="text" class="form-control" placeholder="Masukkan Jumlah Supply" name="supply">
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Demand :</label>
                                <input type="text" class="form-control" placeholder="Masukkan Jumlah Demand" name="demand">
                            </div>
                        </tr>
                   </table>
                   <button class="btn btn-info btn-md" type="submit" >Submit</button>
               </form>               
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>