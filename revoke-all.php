<?php
  /**
   *	This page revokes all unexpired links by deleting the keys file.
  */

  include("variables.php");

  require_once 'protect.php';
	Protect\with('admin-login.php', ADMIN_PASSWORD, 'dummy_arg_for_multipage_protection');

  // Delete the keys file in the keys subdirectory
  // using unlike() function 

  $male_status = 'unchecked';
  $female_status = 'unchecked';

  if (isset($_POST['Submit1'])) {

    $selected_confirmation = $_POST['confirmation'];

    if ($selected_confirmation == 'confirmed') { 
      // Use unlink() function to delete a file 
      $message = "";
      if (unlink(KEYS_FILE_PATH)) { 
        // $message = "The keys file has now been deleted. All links are now expired!";
        header('Location: view.php'); exit();
      } 
      else { 
        $message = KEYS_FILE_PATH . " file cannot be deleted due to an error. Has it already been deleted?"; 
      }
    }
    else if ($selected_radio == 'unconfirmed') {
      $message = "Please confirm you want to delete the keys file to revoke all download links";
    }
  }
?> 

<html>
	<head>
		<title>Revoke All Download Links</title>
			<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	    <link href="bootstrap/css/docs.css" rel="stylesheet">
	    <link href="bootstrap/google-code-prettify/prettify.css" rel="stylesheet">
	    <link href="custom.css" rel="stylesheet">
	</head>

	<body id="bootstrap-overrides">
		 <div class="container">
	    <div class="hero-unit">
				<h1>Revoke All Download Links</h1>
				<h4><?php echo $message;?></h4>
				<br>
        <!-- use: htmlspecialchars($_POST['type'], ENT_QUOTES, 'UTF-8') -->

        <form method="post" action="revoke-all.php">
          To delete the keys file and expire all download links, click the dot and then submit:<input type="radio" name="confirmation" value='confirmed'>&nbsp;
          <button name="Submit1">Submit</button><br/>
        </form>
        <a href="/single-use/view.php"><button>⬅ Back to Unexpired Download Links</button></a>
		  </div>
		</div>
	</body>
</html>
