<?php
session_start();

require __DIR__.'/../../../../includes/connection.php';
require __DIR__.'/../../../../includes/globalFunctions.php';
require __DIR__.'/../../../../includes/brandlogin/functions.php';
require __DIR__.'/../../../../includes/erf/functions.php';

// cek cookie
if( isset($_COOKIE['ghlf']) && isset($_COOKIE['ksla']) && isset($_COOKIE['tp']) ) {
    if( $_COOKIE['tp'] === hash('sha256', 'brand')) {
        $id = $_COOKIE['ghlf'];
        $key = $_COOKIE['ksla'];
    
        // ambil username berdasarkan cookie nya
        $result = mysqli_query($conn, "SELECT * FROM brand WHERE id = '$id'");
        $row = mysqli_fetch_assoc($result);
    
        // cek cookie dan username
        if( $key === hash('sha256', $row['brand_name']) ) {
            $_SESSION['login'] = true;
            $_SESSION['brand_username'] = $row['brand_name'];
        }
    }
}

// cek login
if( !isset($_SESSION['login']) || !isset($_SESSION['brand_username']) ) {
    header('Location: ../../login/brandlogin/login.php');
}

$brand_name = $_SESSION['brand_username'];

?>

<!DOCTYPE html> 
<html lang="en" style="height:100%;">
    <head> 
        <meta charset="utf-8"> 
        <title>Endorsement Requirement Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="keywords" content="pinegrow, blocks, bootstrap" />
        <meta name="description" content="SIGN UP INFLUENCER" />
        <link rel="shortcut icon" href="ico/favicon.png"> 
        <!-- Core CSS -->         
        <link href="../../../bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
        <link href="../../../style/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet">
        <!-- Style Library -->         
        <link href="../../../style/css/style-library-1.css" rel="stylesheet">
        <link href="../../../style/css/plugins.css" rel="stylesheet">
        <link href="../../../style/css/blocks.css" rel="stylesheet">
        <link href="../../../style/css/table.css" rel="stylesheet">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->         
        <!--[if lt IE 9]>
      <script src="../../../style/js/html5shiv.js"></script>
      <script src="../../../style/js/respond.min.js"></script>
    <![endif]-->         
    </head>     
    <body>
        <section id="content-3-7" class="content-block content-3-7">
            <div class="container">
                <div class="col-sm-12">
                    <div class="underlined-title">
                        <h1>Add ERF Task</h1>
                        <hr>
                    </div>
                </div>
            </div>
        </section>
        <div class="content-block contact-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div id="contact" class="form-container">
                            <fieldset>
                                <center>
                                    <h4>TASK<br></h4>
                                    <h6>ENDORSE REQUIREMENT FORM<br></h6>
                                </center>
                                <div id="message"></div>
                                <form method="post">
                                    <div class="form-group">
                                        <!--// TASK NAME -->
                                        <label for="task_name">TASK NAME</label>
                                        <input name="task_name" id="task_name" type="text" value="" placeholder="EX: Make a Purchase" class="form-control" required /><br>
                                        <!--// TASK DEADLINE -->
                                        <label for="task_deadline">TASK DEADLINE</label>
                                        <input name="task_deadline" id="task_deadline" type="date" value="" class="form-control" required /><br>
                                        <!--// BRIEF -->
                                        <label for="brief">BRIEF</label>
                                        <textarea cols="30" rows="3" name="brief" id="brief" type="text" placeholder="note for this task" class="form-control" style="max-width:100%;max-height:300px;min-width:100%;min-height:100px;"></textarea>
                                        <button type="submit" name="set_task" class="btn btn-primary">Set Task</button>
                                    </div>
                                </form>
                            </fieldset>
                        </div>
                        <!-- /.form-container -->
                    </div>
                    <div class="col-md-6">
                        <fieldset>
                            <center>
                                <h4>RULES<br></h4>
                                <h6>ENDORSE REQUIREMENT FORM<br></h6>
                            </center>
                            <div id="message"></div>
                            <form method="post" action="">
                                <div class="form-group">
                                </div>
                                <div class="form-group">
                                    <!--// DO -->
                                    <label for="do">DO</label>
                                    <input name="do" id="do" type="text" value="" placeholder="EX: Review the Product" class="form-control" /><br>
                                    <!--// DONT DO -->
                                    <label for="dont">DON'T DO</label>
                                    <input name="dont" id="dont" type="text" value="" placeholder="EX: Don't Show another Brand Product" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="add_rules" class="btn btn-primary">Add Rules</button>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <div class="editContent">
                                            <div class="btn-group"> 
</div>
                                            <p class="small text-muted"><span class="guardsman">* All fields are required.</span> Once we receive your message we will respond as soon as possible.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
</div>
                            </form>
                        </fieldset>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </div>
        <section id="content-3-7" class="content-block content-3-7">
            <div class="container">
                <div class="col-sm-12">
                    <div class="underlined-title">
                        <h1>Rules</h1>
                        <hr>
                        <!--// TABLE VIEW IS REALTIME -->
                        <center>
                            <table class="styled-table">
                                <thead>
                                    <tr>
                                        <th>Task ID</th>
                                        <th>Task Name</th>
                                        <th>Task Deadline</th>
                                        <th>DO</th>
                                        <th>DON'T DO</th>
                                        <th>DELETE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bold-approved">
                                        <td>1</td>
                                        <td>Make a Purchase</td>
                                        <td>(02-15-2022) - (02-25-2022)</td>
                                        <td>Review The Product</td>
                                        <td>Don't Show Other Brand</td>
                                        <td>
                                            <button class="button button2">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>
                    </div>
                </div>
            </div>
        </section>
        <script type="text/javascript" src="../../../style/js/jquery-1.11.1.min.js"></script>         
        <script type="text/javascript" src="../../../style/js/bootstrap.min.js"></script>         
        <script type="text/javascript" src="../../../style/js/plugins.js"></script>
        <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript" src="../../../style/js/bskit-scripts.js"></script>         
    </body>     
</html>
