<?php
/**
 *	This file creates the single use download link
 *	The query string should be the password (which is set in variables.php)
 *	If the password fails, then 404 is rendered
 *
 *	Expects: generate.php?1234
 */
	include("variables.php");
	
	// Grab the query string as a password
	$password = trim($_SERVER['QUERY_STRING']);

	// Get a human readable file size from bytes
	function human_filesize($bytes, $decimals = 2) {
		$sz = 'BKMGTP';
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
	}
	
	/*
	 *	Verify the admin password (in variables.php)
	 */ 
	if($password == ADMIN_PASSWORD) {
		// Create a list of files to download from
		$download_list = array();
		
		if(is_array($PROTECTED_DOWNLOADS)) {
			foreach ($PROTECTED_DOWNLOADS as $key => $download) {
				// Create a new key
				$new = uniqid('key',TRUE);
				
				// get download link and file size
				$download_link = "https://" . $_SERVER['HTTP_HOST'] . DOWNLOAD_PATH . "?key=" . $new . "&i=" . $key; 
				$filesize = (isset($download['file_size'])) ? $download['file_size'] : human_filesize(filesize($download['protected_path']), 2);
				$protected_file = $download['protected_path'];
				$suggested_name = $download['suggested_name'];
				$remote_file = $download['remote_path'];
				$protected_or_remote_file = (isset($protected_file)) ? $protected_file : $remote_file;

				// Add to the download list
				$download_list[] = array(
					'download_link' => $download_link,
					'filesize' => $filesize,
					'protected_or_remote_file' => $protected_or_remote_file,
					'suggested_name' => $suggested_name
				);

				/*
				 *	Create a protected directory to store keys in
				 */
				if(!is_dir('keys')) {
					mkdir('keys');
					$file = fopen('keys/.htaccess','w');
					fwrite($file,"Order allow,deny\nDeny from all");
					fclose($file);
				}
				
				/*
				 *	Write the key key to the keys list
				 */
				$file = fopen('keys/keys','a');
				fwrite($file,"{$new}\n");
				fclose($file);
			}
		}
		
?>

<html>
	<head>
		<title>Download created</title>
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	    <link href="bootstrap/css/docs.css" rel="stylesheet">
	    <link href="bootstrap/google-code-prettify/prettify.css" rel="stylesheet">
	    <link href="custom.css" rel="stylesheet">

		<style>
			body {
	    		padding-top: 25px;
	    	}
		</style>
	</head>
	<body>
		 <div class="container">
		 <div class="hero-unit">
			<h1>Download key created</h1>
			<h6>Your new single-use download links:<h6><br>
				<h4>Caution: clicking a valid download link will set the link status to expired and will prompt you to open or save the file.</h4><br>
				<p>To copy a link, RIGHT-click it and select "Copy link address" (or "Copy Link" if using Firefox).</p>
			<?php foreach ($download_list as $download) { ?>			
			<h4><br>
				<a href="<?php echo $download['download_link'] ?>"><?php echo $download['download_link'] ?></a><br>
				Protected file name: <?php echo $download['protected_or_remote_file'] ?><br>
				Suggested file name: <?php echo $download['suggested_name'] ?><br>
				Size: <?php echo $download['filesize'] ?><br>
			</h4>
			<?php } ?>

			<br><br>
			<a href="/single-use/index.php"><button>Back to the demo</button></a>
			</div>
		</div>
	</body>
</html>

<?php
	} else {
		/*
		 *	Someone stumbled upon this link with the wrong password
		 *	Fake a 404 so it does not look like this is a correct path
		 */
		header("HTTP/1.0 404 Not Found");
	}
?>
