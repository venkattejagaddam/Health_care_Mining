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
		<link rel="stylesheet" href="css/style_symp.css">
		<style>

</style>
	</head>
	<body>
    <div class="app-wrapper">
			<header class="app-header">
            <h2 style="text-align: center;"><a href="http://localhost/old/index.php"><img src="images/home.png" alt="PDF Format" height="45" width="45" /></a>  Semantic Web Mining - Healthcare Mining</h2>
			</header>
            <form action="#" method="get">
            <div class="app-content-wrapper">
				<aside class="filter-section-wrapper">
					<h2 class="filter-title">Correlation Level</h2>
                    <h4 class="filter-title"><u>SYMPTOMS VS CORONAVIRUS:</u></h4>
					<div class="filter-content"></div>
					<button class="btn apply-filters" onclick=level3();>Level 3</button>
                    <button class="btn apply-filters" onclick=level4();>Level 4</button>
                    <button class="btn apply-filters" onclick=level5();>Level 5</button>
                    <button class="btn apply-filters" onclick=level6();>Level 6</button>
                    <button class="btn apply-filters" onclick=level7();>Level 7</button>
                    <button class="btn apply-filters" onclick=level8();>Level 8</button>

                    <h4 class="filter-title"><u>ALL SYMPTOMS:</u></h4>
                    <button class="btn apply-filters" onclick=level3all();>Level 3</button>
                    <button class="btn apply-filters" onclick=level4all();>Level 4</button>
                    <button class="btn apply-filters" onclick=level5all();>Level 5</button>
                    <button class="btn apply-filters" onclick=level6all();>Level 6</button>
                    <button class="btn apply-filters" onclick=level7all();>Level 7</button>
                    <button class="btn apply-filters" onclick=level8all();>Level 8</button>
				</aside>
				<main class="result-section">
					<div class="selected-filters"></div>
					<h2>Result:</h2>
					<div class="results">
                    <img  id="myImage" src="images/weight3.png" width="1100" height="500" >
                    </div>
				</main>
			</div>
    </form>
    </div>
	
</body>
<script>
    
    function level3(){
        document.getElementById('myImage')
        .src="images/weight3.png";
    }
      
    function level4(){
        document.getElementById('myImage')
        .src="images/weight4.png";
    }
    function level5(){
        document.getElementById('myImage')
        .src="images/weight5.png";
    }
      
    function level6(){
        document.getElementById('myImage')
        .src="images/weight6.png";
    }
    function level7(){
        document.getElementById('myImage')
        .src="images/weight7.png";
    }
      
    function level8(){
        document.getElementById('myImage')
        .src="images/weight8.png";
    }


    function level3all(){
        document.getElementById('myImage')
        .src="images/Overall_images/weight3.png";
    }
      
    function level4all(){
        document.getElementById('myImage')
        .src="images/Overall_images/weight4.png";
    }
    function level5all(){
        document.getElementById('myImage')
        .src="images/Overall_images/weight5.png";
    }
      
    function level6all(){
        document.getElementById('myImage')
        .src="images/Overall_images//weight6.png";
    }
    function level7all(){
        document.getElementById('myImage')
        .src="images/Overall_images/weight7.png";
    }
      
    function level8all(){
        document.getElementById('myImage')
        .src="images/Overall_images/weight8.png";
    }

</script>
</html>