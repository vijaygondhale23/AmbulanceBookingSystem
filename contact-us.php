<?php
session_start();
error_reporting(0);
include('includes/config.php');

$msg = '';
$error = '';

if(isset($_POST['send'])) {
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];
    $message = $_POST['message'];

    $sql = "INSERT INTO tblcontactusquery (name, EmailId, ContactNumber, Message) VALUES (:name, :email, :contactno, :message)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':contactno', $contactno, PDO::PARAM_STR);
    $query->bindParam(':message', $message, PDO::PARAM_STR);
    
    if ($query->execute()) {
        $msg = "Query Sent. We will contact you shortly";
    } else {
        $error = "Something went wrong. Please try again";
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AmbulanceForYou</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Custom Style -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <!-- Switcher -->
    <link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all">
    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
    <!-- Other CSS files -->
    <!-- You can add additional CSS files here -->
    <style>
        .errorWrap, .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }

        .errorWrap {
            border-color: #dd3d36;
        }

        .succWrap {
            border-color: #5cb85c;
        }
    </style>
</head>
<body>

<!-- Start Switcher -->
<?php include('includes/colorswitcher.php');?>
<!-- /Switcher -->  

<!-- Header -->
<?php include('includes/header.php');?>
<!-- /Header --> 

<!-- Page Header -->
<section class="page-header contactus_page">
    <div class="container">
        <div class="page-header_wrap">
            <div class="page-heading">
                <h1>Contact Us</h1>
            </div>
            <ul class="coustom-breadcrumb">
                <li><a href="#">Home</a></li>
                <li>Contact Us</li>
            </ul>
        </div>
    </div>
    <!-- Dark Overlay-->
    <div class="dark-overlay"></div>
</section>
<!-- /Page Header --> 

<!-- Contact Us -->
<section class="contact_us section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>Get in touch using the form below</h3>
                <?php if(!empty($error)): ?>
                    <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div>
                <?php elseif(!empty($msg)): ?>
                    <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?></div>
                <?php endif; ?>
                <div class="contact_form gray-bg">
                    <form method="post">
                        <div class="form-group">
                            <label class="control-label">Full Name <span>*</span></label>
                            <input type="text" name="fullname" class="form-control white_bg" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email Address <span>*</span></label>
                            <input type="email" name="email" class="form-control white_bg" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Phone Number <span>*</span></label>
                            <input type="text" name="contactno" class="form-control white_bg" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Message <span>*</span></label>
                            <textarea class="form-control white_bg" name="message" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn" type="submit" name="send">Send Message <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <h3>Contact Info</h3>
                <div class="contact_detail">
                    <?php
                    $sql = "SELECT Address, EmailId, ContactNo FROM tblcontactusinfo";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    foreach($results as $result):
                    ?>
                    <ul>
                        <li>
                            <div class="icon_wrap"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                            <div class="contact_info_m"><?php echo htmlentities($result->Address); ?></div>
                        </li>
                        <li>
                            <div class="icon_wrap"><i class="fa fa-phone" aria-hidden="true"></i></div>
                            <div class="contact_info_m"><a href="tel:<?php echo htmlentities($result->ContactNo); ?>"><?php echo htmlentities($result->ContactNo); ?></a></div>
                        </li>
                        <li>
                            <div class="icon_wrap"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
                            <div class="contact_info_m"><a href="mailto:<?php echo htmlentities($result->EmailId); ?>"><?php echo htmlentities($result->EmailId); ?></a></div>
                        </li>
                    </ul>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Contact Us --> 

<!-- Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer --> 

<!-- Back to top -->
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<!-- /Back to top --> 

<!-- Login Form -->
<?php include('includes/login.php');?>
<!-- /Login Form --> 

<!-- Register Form -->
<?php include('includes/registration.php');?>
<!-- /Register Form --> 

<!-- Forgot Password Form -->
<?php include('includes/forgotpassword.php');?>
<!-- /Forgot Password Form --> 

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<!-- Switcher -->
<script src="assets/switcher/js/switcher.js"></script>
</body>
</html>
