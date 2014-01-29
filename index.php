<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>Logger Pro CZ - CSV fix</title>
		<link rel="stylesheet" type="text/css" href="css/main.css"/>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<script type="text/javascript" src="js/jquery.js"></script>
	</head>
	<body>
		<div id="page">
			<div id="content">
				<div id="main">
					<h1>Logger Pro (počeštěná verze) - CSV fix</h1>
					<p>Pokud používáte Logger Pro (Lite) a používáte export do CSV, asi jste zjistili, že program používá desetinné čárky také jako oddělovač. Z toho důvodu jsem napsal tento script který vámi nahraný soubor opraví tak aby bylo možné ho zpracovat v Excelu (Libre Office,...)</p>
					<br />
					<form action="upload.php" method="post" enctype="multipart/form-data">
					<div id="file_upload_form">
						<span id="upload_text">Klikněte pro výběr souboru(ů)</span>
						<input class="custom_file" type="file" name="csv_file[]" multiple/>
					</div>
					<input id="submit_form" type="submit" value="Nahrát"/>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		$(".custom_file").change(function(){
			var fileName = $(this).val();
			$("#upload_text").html(fileName);
		});
		</script>
	</body>
</html>
