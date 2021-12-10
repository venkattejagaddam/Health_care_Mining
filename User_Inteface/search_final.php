
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="preconnect" href="https://fonts.gstatic.com" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link
			href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap"
			rel="stylesheet"
		/>
		<title>Healthcare Mining UI</title>
		<link rel="stylesheet" href="css/style4-copy22.css">
		
	</head>
	<body>
	<style>
	body  {
  		background-image: url("6.jpg");
		background-repeat: no-repeat;
  		background-attachment: fixed;
		color:black;
		}
	</style>
	<form action="search.php" method="get">
		<div class="app-wrapper">
			<header class="app-header">
			<h2 style="text-align: center;"><a href="http://localhost/Healthcare/index.php"><img src="images/home.png" alt="PDF Format" height="45" width="45" /></a>  Semantic Web Mining - Healthcare Mining</h2>
				</header>
			<nav class="search-wrapper">
			<div class="search-box">
				<div class="wrapper">
				<input type="text" value="<?php echo htmlspecialchars($_GET['query']); ?>" name="query" id="search" placeholder="Search COVID-19 related topics " autocomplete="off" required />
					
				<button class="btn submit" id="searchBtn2" formaction="default_search.php">Search</button>	
				<button class="btn submit" id="searchBtn">Advanced Search</button>
					<div class="results">
					</div>
					</div>
				</div>
			</nav>
			
		</div>
		<script src="script.js"></script>
	</form>	
	</body>
<?php

if(isset($_GET["page"])){
	$page = (int)$_GET["page"];
}
else {
	$page = 1;
}

$query = urldecode($_GET["query"]);
$query_array2 = explode (",", strtolower($query));
$query = str_replace(" ","%20",$query);
$query_array = explode (",", strtolower($query));


$core_url = "http://localhost:8983/solr/PageRank/select?q=SymptomName:";
$weight_url="http://localhost:8983/solr/SympWeight2/select?q=Source:";
$start=$page*10-10;
$symp_array=[];
$symp_array2=[];
$weight_array=[];
$treatments=array('Physical therapy exercises', 'Exercise', 'quarantine', 'rest','relieve pain');
$treatments_fever=array('Physical therapy exercises', 'Exercise', 'fever', 'rest','relieve pain');
$bodyparts=array('nose','heart','lung','entire neck','entire head');
$contents = file_get_contents($weight_url.implode(",",$query_array).'&sort=Weight%20desc'.'&wt=php&rows=10&start='.$start.'');

eval("\$result = " . $contents . ";");
$count = $result["response"]["numFound"];

$numOfPages = ceil($count/10);

if($count==0){
	
}
if($count>1){ 
for($i=0; $i<sizeof($result["response"]["docs"]) ; $i++){
	
	foreach($result["response"]["docs"][$i] as $key=>$value){
		if($key=='Destination' or $key=='Weight')
		{
			
			if($key=='Destination')
			{
				if (in_array(strtolower(implode(" ",$value)), $symp_array))
					continue;
				elseif (in_array(strtolower(implode(" ",$value)), $query_array))
					continue;
				elseif (in_array(strtolower(implode(" ",$value)), $query_array2))
					continue;
				elseif (in_array(strtolower(implode(" ",$value)), $symp_array2))
					continue;
				
				else
				{
					array_push($symp_array,strtolower(implode(" ",$value)));
					//display($key,$value);
					$value=str_replace(" ","%20",$value);
					array_push($symp_array2,strtolower(implode(" ",$value)));
					
				}
			}
			if($key=='Weight')
			{
				if (in_array(strtolower(implode(" ",$value)), $weight_array))
					continue;
				
				else
				{
					array_push($weight_array,strtolower(implode(" ",$value)));
					
				}
			}
		}
	}
	
	
	
}

$i = 0;
		echo "<form action='#' method='post' class='form1'>";
        echo '<div class="app-content-wrapper" id="checkid">';
		echo'<aside class="filter-section-wrapper">';
		echo '<h2 class="filter-title">Filters</h2>';
		echo '<h4 class="filter-title">Related Symptoms</h4>';
		
		if(count($symp_array)>5)
		{
			for($i=0;$i<5;$i++) 
		{
			
			
				echo "<input type='checkbox' id='checkBox' class='showh-more-item' name='result[]' value='$symp_array[$i]'> $symp_array[$i]:<b>$weight_array[$i]</b>";
				echo "</br>";
			
			
			
			
		}
		}
		else {
			while($i < count($symp_array)) 
		{
			while($i < count($weight_array))
			{
				echo "<input type='checkbox' id='checkBox' class='showh-more-item' name='result[]' value='$symp_array[$i]'> $symp_array[$i]:<b>$weight_array[$i]</b>";
				echo "</br>";
			
			$i++;
			}
				
		}

		}
		
		echo "</br>";
		echo '<h4 class="filter-title">Related Treatments:</h4>';
		echo "<input type='checkbox' id='checkBox' class='showh-more-item' name='result[]' value='$treatments[0]'> $treatments[0]";echo "</br>";
		echo "<input type='checkbox' id='checkBox' class='showh-more-item' name='result[]' value='$treatments[1]'> $treatments[1]";echo "</br>";
		echo "<input type='checkbox' id='checkBox' class='showh-more-item' name='result[]' value='$treatments[2]'> $treatments[2]";echo "</br>";
		echo "<input type='checkbox' id='checkBox' class='showh-more-item' name='result[]' value='$treatments[3]'> $treatments[3]";echo "</br>";
		echo "<input type='checkbox' id='checkBox' class='showh-more-item' name='result[]' value='$treatments[4]'> $treatments[4]";echo "</br>";

		echo "</br>";

		echo '<h4 class="filter-title">Related Bodyparts:</h4>';
		echo "<input type='checkbox' id='checkBox' class='showh-more-item' name='result[]' value='$bodyparts[0]'> $bodyparts[0]";echo "</br>";
		echo "<input type='checkbox' id='checkBox' class='showh-more-item' name='result[]' value='$bodyparts[1]'> $bodyparts[1]";echo "</br>";
		echo "<input type='checkbox' id='checkBox' class='showh-more-item' name='result[]' value='$bodyparts[2]'> $bodyparts[2]";echo "</br>";
		echo "<input type='checkbox' id='checkBox' class='showh-more-item' name='result[]' value='$bodyparts[3]'> $bodyparts[3]";echo "</br>";
		echo "<input type='checkbox' id='checkBox' class='showh-more-item' name='result[]' value='$bodyparts[4]'> $bodyparts[4]";echo "</br>";

		echo "</br>";
		echo "<input type='submit' class='btn submit' name='submit2' value='Process' />";
		echo "</aside> ";
		echo '</form>';
		echo "<form action='#' method='post' class='form2'>";
		
		
		


		
		if(isset($_POST['result']))
		{
			foreach($_POST['result'] as $result)
			{
				array_push($query_array2,$result);
				$result=str_replace(" ","%20",$result);
				array_push($query_array,$result);
				//echo '</br>'.$result.'<br>';
			}
		}
		

//SYMPTOM AND LINK APACHE SOLR
	}
$contents2 = file_get_contents($core_url.implode(",",$query_array).'&sort=Total_Weight%20desc'.'&wt=php&rows=1000&start='.$start.'');
eval("\$result2 = " . $contents2 . ";");
$count2 = $result2["response"]["numFound"];

$numOfPages = ceil($count2/10);
if($count2==0){
	echo "No results found";
}

if($count>1){

echo '<main class="result-section">';
echo '<h4><u>Search Results for</u> : ';echo implode(",",$query_array2);echo'</h4>';
for($i=0; $i<sizeof($result2["response"]["docs"]) ; $i++){
	foreach($result2["response"]["docs"][$i] as $key=>$value){
		
		if($key=='Title')
		{
			$temp=implode(" ",$value);
			echo "<br><b style='color: rgb(2 125 188);text-transform: uppercase;font-size: 20px;'>$temp</b>";
			
		}
		if($key=='Author')
		{
			$temp=implode(" ",$value);
			echo "<br><b>Author   :</b> $temp";
			
		}
	}
	foreach($result2["response"]["docs"][$i] as $key=>$value){
		
		
		
		if($key=='BodyParts')
		{

			$trial=explode(",",$temp);
			$temp=implode(" ",$value);
			echo "<br><b>Body Parts Mentioned</b>: $temp"; 
			
			
			
		}
		if($key=='PostLink')
		{
			
			$temp=implode(" ",$value);
			echo "<br><b>PostLink :</b> <a href='$temp' target='_blank'>$temp</a>";
			
		}
		if($key=='Treatment')
		{
			
			$temp=implode(" ",$value);
			echo "<br><b>TreatMents Mentioned      </b>: $temp";
			
		}
	}
	echo "<br/>";
	echo"<hr>";
	
	
}

echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo'</main> </div>';

echo'</form>';




}


?>
<script src="script.js"></script>
<script src="suggestions.js"></script>
</html>