<?php
$username = "root";
$password = "";
$hostname = "localhost"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
 or die("Unable to connect to MySQL");
if(!$dbhandle)
echo "not Connected to MySQL<br>";
$selected = mysql_select_db("brandwatch",$dbhandle) 
  or die("Could not select brandwatch");
 if(!$selected) echo "not Connected to database brandwatch<br>";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta name="Sample_Code" content="Code written for AppDetex">
    <meta name="Amulya" content="">
  
    <title>AppDetex</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="bootstrap-3.3.6/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="bootstrap-3.3.6/docs/examples/theme/theme.css" rel="stylesheet">
    <script src="bootstrap-3.3.6/docs/assets/js/ie-emulation-modes-warning.js"></script>
  </head>

  <body role="document">
 <div class="container theme-showcase" role="main">
 <div class="page-header">
        <h1>Brands</h1>
      </div>
   <div class="col-md-6">
     
      <p>
          <?php
     $result3 = mysql_query("SELECT * from user_brand_alert 
join (select brand_id, title from user_brand) as ub on user_brand_alert.brand_id = ub.brand_id");
$result1 = mysql_query("SELECT ub.brand_id as brand_id, title, alert_id
from user_brand_alert 
join (select brand_id, title from user_brand) as ub on user_brand_alert.brand_id = ub.brand_id
group by user_brand_alert.brand_id
ORDER BY run_date DESC");
if(!$result1)
die("database query failed:  " . mysql_error());
//fetch tha data from the database 
if (mysql_num_rows($result1) > 0) {
    // Printing results in HTML
    echo "<table class='table table-condensed'>\n";
   echo" <thead>
    <tr>
        <th>BrandID</th>
        <th>Brand Name</th>
        <th>AlertID</th>
        
    </tr>
    </thead>";
    
    while ($line1 = mysql_fetch_array($result1, MYSQL_ASSOC)) {
        echo "\t<tr>\n";
      
          echo "\t\t<td><button href='#myModal' id='".$line1['brand_id']."'data-toggle='modal' 
          class='btn btn-default' onClick='clicked(this.id)'>".$line1['brand_id']."</button></td>\n";
            echo "\t\t<td>".$line1['title']."</td>\n";
            echo "\t\t<td>".$line1['alert_id']."</td>\n";
            
        echo "\t</tr>\n";
    }
    echo "</table>\n";
}
?>

<script type="text/javascript">

function clicked(clicked_id)
{
   phpString = clicked_id;
   $.ajax({
    type: 'post',
    url:'first.php',
    data: {phpString:phpString},
    success: function(data) {
       console.log(data);
    }
});
//alert(clicked_id);

}
</script>


<div class="modal fade" id="myModal">
<div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 class="modal-title">Alerts</h3>
        </div>
        <div class="modal-body">
          <table class="table table-striped" id="tblGrid">
            <thead id="tblHead">
              <tr>
                <th>Alert Id</th>
                <th>No. of apps added</th>
                <th>No. of apps removed</th>
                <th>total no. of apps</th>
                <th>run_date</th>
                <th>reviewed</th>
              </tr>
              </thead>
              <tbody>
              <?php  
              
        // AJAX request
        if(isset($_POST['phpString']))
        {
            $brandid = $_POST['phpString'];
        }  // ...
        echo $brandid;
    
      if($brandid==0) {
    echo $brandid;
}
              $result2 = mysql_query("SELECT alert_id, apps_added_num,
              apps_removed_num, total_apps,
              run_date, reviewed from user_brand_alert 
join (select brand_id, title from user_brand) as ub on user_brand_alert.brand_id = ub.brand_id
where ub.brand_id='".$brandid."'");
              while ($line2 = mysql_fetch_array($result2, MYSQL_ASSOC)) {
        echo "\t<tr>\n";
           echo "\t\t<td>".$line2['alert_id']."</td>\n";
            echo "\t\t<td>".$line2['apps_added_num']."</td>\n";
             echo "\t\t<td>".$line2['apps_removed_num']."</td>\n";
            echo "\t\t<td>".$line2['total_apps']."</td>\n";
             echo "\t\t<td>".$line2['run_date']."</td>\n";
            echo "\t\t<td>".$line2['reviewed']."</td>\n";
        
        echo "\t</tr>\n";
    }
    ?>
    
          
            
            </tbody>
          </table>
          
		</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>

        </div>
				
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->   


  
      </p>     
</div>

<?php
mysql_close($dbhandle);
?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   <script>window.jQuery || document.write('<script src="bootstrap-3.3.6/docs/assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="bootstrap-3.3.6/dist/js/bootstrap.min.js"></script>
    <script src="bootstrap-3.3.6/docs/assets/js/docs.min.js"></script>
    <script src="bootstrap-3.3.6/docs/assets/js/ie10-viewport-bug-workaround.js"></script>
  
  </body>
</html>
