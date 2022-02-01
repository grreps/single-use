<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="bootstrap/css/docs.css" rel="stylesheet">
    <link href="bootstrap/google-code-prettify/prettify.css" rel="stylesheet">
    <link href="custom.css" rel="stylesheet">  

  </head>
  <body id="bootstrap-overrides">
    <!-- From https://gist.github.com/eric1234/4692807 - 'Protect page with simple password · GitHub'.
    The form protects multiple pages: index.php, generate.php, view.php.

    Access granted to one page grants access to all pages.

    Form configured to accept ADMIN_PASSWORD set in variables.php -->

    <div class="container">
      <div class="hero-unit">
        <form method="POST">
          <?php if( $_SERVER['REQUEST_METHOD'] == 'POST' ) { ?>
            Invalid password
          <?php } ?>
          <p>Enter password to access admin pages:
            <input type="password" name="password">
            <button type="submit">Submit</button>
          </p>
        </form>
      </div>
    </div>
  </body>
</html>