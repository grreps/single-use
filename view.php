<?php
/**
 *	This page displays a list of single use download links
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
	
	// Display a list of links to download from
	$keys_list=explode("\n",file_get_contents("keys/keys"));

	$download_list = array();

	if(is_array($PROTECTED_DOWNLOADS)) {
		foreach ($keys_list as $key => $keys_line) {
			$keys_line_items = explode(',', $keys_line);
			$unique_id = $keys_line_items[0];
			$protected_file = $keys_line_items[1];
			$suggested_name = $keys_line_items[2];
			$filesize = $keys_line_items[3];
			
			// get download link and file size
			$download_link = "https://" . $_SERVER['HTTP_HOST'] . DOWNLOAD_PATH . "?key=" . $unique_id . "&i=" . $key; 

			// Add to the download list
			$download_list[] = array(
				'link_index_num' => ++$key,
				'download_link' => $download_link,
				'protected_file' => $protected_file,
				'suggested_name' => $suggested_name,
				'filesize' => $filesize
			);
		}
	}
?>

<html>
	<head>
		<title>Existing Download Links</title>
			<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	    <link href="bootstrap/css/docs.css" rel="stylesheet">
	    <link href="bootstrap/google-code-prettify/prettify.css" rel="stylesheet">
	    <link href="custom.css" rel="stylesheet">
	</head>

	<body id="bootstrap-overrides">
		 <div class="container">
	    <div class="hero-unit">
				<h1>Existing Download Links</h1>
				<h6>Showing all unexpired single-use download links as at <?php echo date('Y-m-d g:i:s a', time()) . " (" . date_default_timezone_get() . ") ";?>. Refresh page to check again.</h6>
				<br>
				<?php
					if ($keys_list[0]==""){
						?><p>No valid download links exist.</p>
						<p>Any previously-generated links have now all been used or revoked.</p>
						<a href="/single-use/index.php"><button>⬅ Back to the demo</button></a>
					<?php
					}
					else {
					?>
						<p>To copy a link, RIGHT-click it and select "Copy link address" (or "Copy Link" if using Firefox).</p>
						<p>To revoke a link, left-click it; to revoke all links, delete the 'keys' file, which is auto-created as needed.</p>
						<?php
						foreach ($download_list as $download_list_entry) { 
							if ($download_list_entry['protected_file'] != ''){ ?>	
							<h3>Download link #<?php echo $download_list_entry['link_index_num'] ?></h3>
							<h4>
							<a href="<?php echo $download_list_entry['download_link']; ?>"><?php echo $download_list_entry['download_link'] ?></a><br>
							</h4>
							<h4>
							Protected file: <?php echo $download_list_entry['protected_file'] ?><br>
							Name assigned to downloaded file: <?php echo $download_list_entry['suggested_name'] ?><br>
							Size: <?php echo $download_list_entry['filesize'] ?>
							</h4>
						<?php
							}
						}?>
						<a href="/single-use/index.php"><button>⬅ Back to the demo</button></a>
						<a href="/single-use/view.php"><button>↻ Check again (refresh page)</button></a>
					<?php
					}?>
				<a href="/single-use/generate.php"><button>⚡ Generate new links</button></a>
				<br>
		  </div>
		</div>
	</body>
</html>

