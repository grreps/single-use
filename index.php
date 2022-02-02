<!DOCTYPE html>
<?php
 /**
 *	This page creates the single use download link(s)
 *	The page is password-protected with the ADMIN_PASSWORD defined in variables.php
 *   (using page protection code from https://gist.github.com/eric1234/4692807)
 */
  include("variables.php");
	require_once 'protect.php';
	Protect\with('admin-login.php', ADMIN_PASSWORD, 'dummy_arg_for_multipage_protection');
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Single use download link</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="bootstrap/google-code-prettify/prettify.js"></script>
	<script type="text/javascript">
			$(document).ready(function() {
				$("*").DomInspector({
					callback : function(results) {
						// Returns an Array of each element
						$(".results").html(results.join(", "));
					}
				
				});
			
				// make code pretty
			    window.prettyPrint && prettyPrint();
			});
			
	</script>
		
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="bootstrap/css/docs.css" rel="stylesheet">
    <link href="bootstrap/google-code-prettify/prettify.css" rel="stylesheet">
    <link href="custom.css" rel="stylesheet">
  
  </head>

  <body id="bootstrap-overrides">
    <div class="container">
		<!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Single use download</h1>
        <br>
        <h2>Brief</h2><br>
        <p>This script was written to be a very easy way for non-programmers to be able to create a secure way to share a single file. It is ideal for 
        bands looking to give a single song to a single person, and invalidating the link once the song has been downloaded. However, 
        it will work for any type of file.</p>
        <br>
        <h2>Description</h2><br>
        <p>This script allows you to generate a unique link to download a file. This file will only be allowed to be downloaded one time. 
        This link will also have also have an expiration date set on it.</p>
        <br>
        <p>For instance, if you wanted to sell a song for your band. You sold the song on your website for $1, you could use this script 
        to allow that person to download your song only one time. It would only give them a limited number of hours/days/weeks/years 
        to claim their download.</p>
        <br>
        <p>You can also mask the name of the file being downloaded, for further protection. For example, if your song was called 
        "greatsong.zip", you could set the download link as "Band_Awesome-Awesome_Song.zip" (it is not a good idea to leave spaces in URL titles)</p>
        <h2>Update</h2><br>
        <p>On July 11, 2016 a multi-file feature branch was merged with the single file. It is now possible to download multiple files at once. </p>
        <br>
        <h2>Example</h2><br>
        <p>Click to generate new download links for local and/or remote files declared in variables.php.</p>
      	<p>Currently, variables.php declares two demo local files in ./secret folder plus an example dropbox folder.</p>
        <p>Generating new links does not affect any previously-generated unexpired links.</p>
        <p>
        <a href="/single-use/view.php?<?php echo ADMIN_PASSWORD; ?>"><button>📜 View existing links</button></a>
        <a href="/single-use/generate.php?<?php echo ADMIN_PASSWORD; ?>"><button>⚡ Generate new links</button></a>
        </p>
        <br>
        <p>To maximize security of secret files:
          <ul>
            <li>Password-protect your secret files by putting them in zip files with at least 256-bit AES encryption</li>
            <li>Give the recipient the password(s) only after he/she confirms he/she has the files</li>
            <li>Give the passwords over a communication channel different from the one you use to send download links</li>
            <li>Delete the copies of secret files from your web server once the recipient has confirmed he/she can open them</li>
          </ul>
        </p>
		</div>
	</div>

    <footer class="footer">
      <div class="container">

		    <p>
         Made by Josh Pangell <a href="http://joshpangell.com">http://joshpangell.com</a><br>
         This demo page was built using <a href="http://twitter.github.com/bootstrap/" target="_blank">Twitter bootstrap</a>
        </p>
      </div>
    </footer>

  </body>
</html>
