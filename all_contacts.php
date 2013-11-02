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

    <title>All Contacts</title>

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
      <?php
        Utils::showSessionMessage();
        $contactList = Utils::getContactList();
      ?>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Phone Number</th>
              <th>Email Address</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
              if($contactList['STAT_TYPE'] != SC_SUCCESS_CODE){
                ?>
                <tr><td colspan="4" style="text-align: center"><?php echo $contactList['STAT_DESCRIPTION']; ?></td></tr>
                <?php
              }
              else if ($contactList['STAT_TYPE'] == SC_SUCCESS_CODE && $contactList['DATA'] == null){
                ?>
                <tr><td colspan="4" style="text-align: center"><?php echo $contactList['STAT_DESCRIPTION']; ?></td></tr>
                <?php
              }
              else{
                foreach ($contactList['DATA'] as $record) {
                  $row = '<tr>'
                    .'<td>'.$record['id'].'</td>'
                    .'<td><a href="view_contact.php?id='.$record['id'].'">'.$record['name'].'</a></td>'
                    .'<td>'.$record['phoneNumber'].'</td>'
                    .'<td>'.$record['email'].'</td>'
                    .'<td>'
                      .'<a title="Click to update" href="update_contact.php?id='.$record['id'].'&name='.urlencode($record['name']).'&phoneNumber='.urlencode($record['phoneNumber']).'&email='.urlencode($record['email']).'">'.'<span class="glyphicon glyphicon-edit"></span>'.'</a>'
                      .'&nbsp;&nbsp;<a title="Click to remove" href="remove_contact.php?id='.$record['id'].'">'.'<span class="glyphicon glyphicon-trash"></span>'.'</a>'
                    .'</td>'
                    .'</tr>';
                    echo $row;
                }
              }
            ?>
          </tbody>
        </table>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>