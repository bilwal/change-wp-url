<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Change WP Site Url</title>
		<link href="bootstrap.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script type="text/javascript" src="jquery-1.11.3.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="row"><!--.col-xs-12 .col-sm-6 .col-lg-8 -->
				<div class="col-lg-2 col-sm-1"></div>
				<div class="col-lg-8 col-sm-10 col-xs-12">
					<form role="form" id="myfrm">
						<div id="chng_pst" class="form-group">
							<label for="url">Your Old Url:</label>
							<input type="text" name="url2" id="turl2" class="form-control">
						</div>
						<div class="form-group">
							<label for="url">Your New Url:</label>
							<input type="text" name="url" id="turl" class="form-control">
						</div>
						<div class="checkbox">
							<label><input type="checkbox" value="chng_pst">I want to change my all post content with new url.</label>
						</div>
						<button type="submit" class="btn btn-default">Submit</button>
						
					</form>
				</div>
				<div class="col-lg-2 col-sm-1"></div>
			</div>
		

<?php
	if(isset($_POST['url'])){$url = $_POST['url'];}
	if(isset($_POST['url2'])){$url2 = $_POST['url2'];}
	if(!empty($url)){
	include('config.php');
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	// sql to create table
	$sql = "UPDATE ".$dbname.".".$db_prefix."options SET option_value = '".$url."' WHERE ".$db_prefix."options.option_name = 'siteurl';";
	$sql.= "UPDATE ".$dbname.".".$db_prefix."options SET option_value = '".$url."' WHERE ".$db_prefix."options.option_name = 'home';";
	if(!empty($url2)){
	$sql.="UPDATE ".$dbname.".".$db_prefix."posts SET post_content = REPLACE(post_content, '".$url2."', '".$url."') WHERE post_content LIKE '%".$url2."%'";
	}
	
	if ($conn->multi_query($sql)) { ?>
	
		<?php }else{
		echo "Failed to change site url: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	
	
	
	$conn->close();
	}
?>
		<div id="sssc" class="row">
			<div class="col-lg-2 col-sm-1"></div>
				<div class="col-lg-8 col-sm-10 col-xs-12">
					<div class="alert alert-success">
						<strong>Success!</strong> Site url has been changed.
					</div>
					<div id="response"></div>
				</div>
			<div class="col-lg-2 col-sm-1"></div>	
		</div>

</div>
		
	<script type="text/javascript">
		$(document).ready(function(){
			$('input[type="checkbox"]').click(function(){
				if($(this).attr("value")=="chng_pst"){
					$("#chng_pst").toggle();
				}
			});
			
			$('#myfrm').submit(function(event) {
				event.preventDefault();
				if($('#turl').val() == ''){
					  alert('Please type url');
				   }
				if(!$('#turl').val() == ''){
				$.ajax({
					url: 'index.php',
					type: 'POST',
					data: $(this).serialize(),
					success: function(data) {
						$('#sssc').show().fadeOut(5000);
					}
				});
				}
			});
		});
	</script>
	
		
	</body>
</html>
