<?php
require_once (dirname(__FILE__)) . '/libs/DBUtils.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>View Contact</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/contact-form.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li class="active"><a href="contacts.php">Home</a></li>
          <li><a href="all_contacts.php">All Contacts</a></li>
          <li><a href="index.php">Logout</a></li>
        </ul>
        <h3 class="text-muted">My Contacts</h3>
      </div>
      <h2>View Contact</h2>
      <?php
        if(!isset($_GET['id']) || ($_GET['id'] == '')){
          Utils::setSessionMessage('danger', 'An error occurred. Please try again.');
          header('Location: '.ROOT_URL.'contacts.php');
          exit();
        }
        $singleContact = Utils::getContactList($_GET['id']);
        if($singleContact['STAT_TYPE'] != SC_SUCCESS_CODE){
          Utils::setSessionMessage('danger', $singleContact['STAT_DESCRIPTION']);
          Utils::showSessionMessage();
          
        }
        else if ($singleContact['STAT_TYPE'] == SC_SUCCESS_CODE && $singleContact['DATA'] == null){
          Utils::setSessionMessage('warning', $singleContact['STAT_DESCRIPTION']);
          Utils::showSessionMessage();
        }
        else{
          ?>
      <div class="table-responsive">
        <table class="table table-striped">
          <tbody>
            <tr>
              <th>Name</th>
              <td><?php echo isset($singleContact['DATA'][0]['name']) ? $singleContact['DATA'][0]['name'] : null; ?></td>
            </tr>
            <tr>
              <th>Email</th>
              <td><?php echo isset($singleContact['DATA'][0]['email']) ? $singleContact['DATA'][0]['email'] : null; ?></td>
            </tr>
            <tr>
              <th>Phone Number</th>
              <td><?php echo isset($singleContact['DATA'][0]['phoneNumber']) ? $singleContact['DATA'][0]['phoneNumber'] : null; ?></td>
            </tr>
          </tr>
          </tbody>
       
      </table>
      </div>
          <?php
        }
      ?>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>