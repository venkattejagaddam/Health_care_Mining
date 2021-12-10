<!DOCTYPE html>
<html lang="en">

	<head>
	
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="preconnect" href="https://fonts.gstatic.com" />
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
		
		<link
			href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap"
			rel="stylesheet"
		/>
		<title>Healthcare Mining UI</title>
		<link rel="stylesheet" href="css/style4-copy3.css">
		<style>
		
		a {
	color: red;
	font-family: helvetica;
	text-decoration: none;
	text-transform: uppercase;
	text-align: center;
  }
  
  a:hover {
	text-decoration: underline;
  }
  
  a:active {
	color: black;
  }
  
  a:visited {
	color: purple;
  }
  
		</style>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
  		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
		</head>
		
	<body>
	
	<form action="search.php" method="get">
		<div class="app-wrapper">
			<header class="app-header">
				<h2 style="text-align: center;"><a href="http://localhost/old/index.php"><img src="images/home.png" alt="PDF Format" height="45" width="45" /></a>  Semantic Web Mining - Healthcare Mining</h2>
			</header>
			
			
			
	<header>
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    
    <div class="carousel-inner" role="listbox">
		
      <!-- Slide One - Set the background image for this slide in the line below -->
      <div class="carousel-item active" style="background-image: url('intro.jpg')">
        <div class="carousel-caption d-none d-md-block">
        </div>
      </div>
	  
	  
    </div>
    
  </div>
  <nav class="search-wrapper">
				<div class="search-box">
				<div class="wrapper">
				<input type="text" name="query" id="search" placeholder="Search COVID-19 related topics " autocomplete="off" required />
					
					
					<button class="btn submit" id="searchBtn2" formaction="default_search.php">Search</button>
					<button class="btn submit" id="searchBtn">Advanced Search</button>
					
					<div class="results">
						<ul></ul>
					</div>
					
					</div>
				</div>
			</nav>
</header>
 
<a href="http://localhost/Healthcare/symp.php "target='_blank'>Know More about sympgraphs</a>

	<script src="script.js"></script>
	<script src="suggestions.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	  
	
</html>
