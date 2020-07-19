<?php
$dataPoints = array();
//Best practice is to create a separate file for handling connection to database
try{
     // Creating a new connection.
    // Replace your-hostname, your-db, your-username, your-password according to your database
    /*$link = new \PDO('mysql:host=localhost;dbname=lasgrepdb;charset=utf8mb4', //'mysql:host=localhost;dbname=canvasjs_db;charset=utf8mb4',
                        'SYSTEM', //'root',
                        'sss2$', //'',
                        array(
                            \PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            \PDO::ATTR_PERSISTENT => false
                        )
                    );*/

    $link = oci_connect("SYSTEM","sss2$", "localhost/lasgrepdb");

    //$handle = $link->prepare('select x, y from datapoints'); 

    $handle = 'select a.bank_name as bank_name, sum(b.current_balance) as currentbal from tms_bank a, tms_accounts b where a.bank_code = b.bank_code group by a.bank_name'; 
    $handley = oci_parse($link,$handle);
    oci_execute ($handley);
    $result = oci_fetch_object($handley);

    var_dump($result);
		
    foreach($result as $row){
        if(!is_object($row)){
        array_push($dataPoints, array("currentbal"=> $row->x, "currentbal"=> $row->y));
    }
}
	$link = null;
}
catch(PDOException $ex){
    print($ex->getMessage());
}

?>
<!DOCTYPE HTML>
<html>
<head>  
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "PHP Column Chart from Database"
	},
	data: [{
		type: "column", //change type to bar, line, area, pie, etc  
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html> 