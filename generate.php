<?php
/**
 *	This page creates the single use download link
 *	The page is password-protected with the ADMIN_PASSWORD defined in variables.php
 *   (using page protection code from https://gist.github.com/eric1234/4692807)
 */
	include("variables.php");
  // Page password protection code from https://gist.github.com/eric1234/4692807
	require_once 'protect.php';
	Protect\with('admin-login.php', ADMIN_PASSWORD, 'dummy_arg_for_multipage_protection');

	// Get a human readable file size from bytes
	function human_filesize($bytes, $decimals = 2) {
		$sz = 'BKMGTP';
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
	}
	
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
			fwrite($file,"{$new},{$protected_or_remote_file},{$suggested_name},{$filesize}\n");
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
	</head>

	<body id="bootstrap-overrides">
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
				<a href="/single-use/index.php"><button>⬅ Back to the demo</button></a>
				<a href="/single-use/view.php"><button>📜 View all unexpired links</button></a>
				<a href="/single-use/generate.php"><button>⚡ Generate new links</button></a>

			</div>
		</div>
	</body>
</html>

