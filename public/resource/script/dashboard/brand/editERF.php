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

if( isset($_GET['erf_id']) ) {
    $_SESSION['erf_id'] = $_GET['erf_id'];
}
$erf_id = $_SESSION['erf_id'];
$brand_name = $_SESSION['brand_username'];
$brand_id = query("SELECT brand_id FROM brand WHERE brand_name = \"$brand_name\"")[0]['brand_id'];
$test_erf_draft = query("SELECT * FROM erf WHERE brand_id = $brand_id AND erf_id = $erf_id");
if( isset($test_erf_draft[0]) ) {
    $erf_draft = $test_erf_draft[0];
    $erf_id = $erf_draft['erf_id'];
    $task_list = query("SELECT * FROM task WHERE erf_id = $erf_id");
}
$path = '../../../images/brands/erf/';

if( isset($_SESSION['prev_url']) ) {
    session_unset($_SESSION['prev_url']);
}

if( isset($_SESSION['task_id']) ) {
    session_unset($_SESSION['task_id']);
}

if( isset($task_list) ) {
    if( empty($task_list[0]) ) {
        unset($task_list);
    }
}

if( isset($erf_draft['erf_id']) ) {
    $erf_id = $erf_draft['erf_id'];
    $inf_criteria = query("SELECT * FROM inf_criteria WHERE erf_id = $erf_id");
}

if( isset($erf_draft['erf_id']) ) {
    $erf_id = $erf_draft['erf_id'];
    $ref_link = query("SELECT * FROM ref_link WHERE erf_id = $erf_id");
}

if( isset($_POST['set_erf']) ) {
    if( !isset($_POST['negotiation'])) {
        $_POST['negotiation'] = 0;
    }
    if( $_FILES['erf_pict']['name'] != '' ) {
        $erf_pict = upload($_FILES['erf_pict'], $path);
        if($erf_pict == false) {
            echo "
                    <script>
                        alert('gagal upload foto produk');
                        window.location = 'editERF.php';
                    </script>
                ";
        }
    } else {
        $erf_pict = 'null';
    }
    if( setERF($_POST, $erf_draft, $brand_id, $erf_pict) >= 0 ) {
        echo "
                <script>
                    alert('erf berhasil diset');
                    window.location = 'editERF.php';
                </script>
            ";
    } else {
        echo "
                <script>
                    alert('erf gagal diset');
                    window.location = 'editERF.php';
                </script>
            ";
    }
}

if( isset($_POST['add_inf_criteria'])) {
    // jika erf belum diset, tidak dapat menambah kriteria
    if( isset($erf_draft['erf_id']) ) {
        if(add_criteria($_POST, $erf_draft['erf_id']) >= 0) {
            echo "
                    <script>
                        alert('kriteria berhasil ditambahkan');
                        window.location = 'editERF.php';
                    </script>
                ";
        } else {
            echo "
                    <script>
                        alert('kriteria gagal ditambahkan');
                        window.location = 'editERF.php';
                    </script>
                ";
        }
    } else {
        echo "
                <script>
                    alert('set erf terlebih dahulu');
                    window.location = 'editERF.php';
                </script>
            ";
    }
}

if( isset($_POST['add_ref_link'])) {
    // jika erf belum diset, tidak dapat menambah kriteria
    if( isset($erf_draft['erf_id']) ) {
        if(add_ref_link($_POST, $erf_draft['erf_id']) >= 0) {
            echo "
                    <script>
                        alert('reference link berhasil ditambahkan');
                        window.location = 'editERF.php';
                    </script>
                ";
        } else {
            echo "
                    <script>
                        alert('reference link gagal ditambahkan');
                        window.location = 'editERF.php';
                    </script>
                ";
        }
    } else {
        echo "
                <script>
                    alert('set erf terlebih dahulu');
                    window.location = 'newERF.php';
                </script>
            ";
    }
}

if( isset($_POST['add_task']) ) {
    if( isset($erf_draft['erf_id']) ) {
        $erf_id = $erf_draft['erf_id'];
        $_SESSION['erf_id'] = $erf_id;
        header('Location: newTask.php?prev_url=editERF.php');
    } else {
        echo "
                <script>
                    alert('set erf terlebih dahulu');
                    window.location = 'newERF.php';
                </script>
            ";
    }
}

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
        <script>
        </script>
    </head>     
    <body data-spy="scroll" data-target="nav">
        <header id="header-1" class="soft-scroll header-1">
            <!-- Navbar -->
            <nav class="main-nav navbar-fixed-top headroom headroom--pinned">
                <div class="container">
                    <!-- Brand and toggle -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="#"><img src="../../../images/logo-white.png" class="brand-img img-responsive"></a>
                    </div>
                    <!-- Navigation -->
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="active nav-item">
                                <a href="home.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a href="brandProfile.php">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a href="#">Notification</a>
                            </li>
                            <!--//dropdown-->                             
                            <li class="nav-item">
                                <a href="#">Message</a>
                            </li>
                            <li class="nav-item">
                                <a href="#">Settings</a>
                            </li>
                            <li class="nav-item">
                                <a href="#">Review</a>
                            </li>
                            <li class="nav-item">
                                <a href="../../login/brandlogin/logout.php">Log Out</a>
                            </li>
                        </ul>
                        <!--//nav-->
                    </div>
                    <!--// End Navigation -->
                </div>
                <!--// End Container -->
            </nav>
            <!--// End Navbar -->
        </header>
        <section id="content-3-7" class="content-block content-3-7">
            <div class="container">
                <div class="col-sm-12">
                    <div class="underlined-title">
                        <h1>Endorsement Requirement Form</h1>
                        <hr>
                        <h2>brand is just a perception, and perception will match reality overtime</h2>
                        <h3>- Elon Musk -</h3>
                    </div>
                    <div class="col-sm-4">
                        <!--// <a href="home.php"><--Back to home</a> -->
                        <button class="btn btn-primary" onclick="window.location='home.php'">Back to Home</button>
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
                                    <h4>OVERVIEW<br></h4>
                                    <h6>ENDORSE REQUIREMENT FORM<br></h6>
                                </center>
                                <div id="message"></div>
                                <form method="post" action="" enctype="multipart/form-data">
                                    <!--// PRODUCT PICTURE -->
                                    <div class="form-group">
                                        <label for="erf_pict">PRODUCT PICTURE</label>
                                        <?php if( isset($erf_draft['erf_pict']) ): ?>
                                            <div>
                                                <img class="img" src="<?= $path . $erf_draft['erf_pict']; ?>" alt="Product Picture" style="width:50%;">
                                            </div>
                                        <?php else: ?>
                                            <div>
                                                <img class="img" src="<?= $path . 'default.png'; ?>" alt="Product Picture" style="width:50%;">
                                            </div>
                                        <?php endif; ?>
                                        <input name="erf_pict" id="erf_pict" type="file" class="form-control" />
                                    </div>
                                    <!--// ERF NAME -->
                                    <div class="form-group">
                                        <label for="erf_name">ERF NAME</label>
                                        <input name="erf_name" id="erf_name" type="text" value="<?= $erf_draft['erf_name'] ?>" placeholder="EX: Looking for Brand Ambassador" class="form-control" required />
                                    </div>
                                    <!--// PRODUCT NAME -->
                                    <div class="form-group">
                                        <label for="product_name">PRODUCT NAME</label>
                                        <input name="product_name" id="product_name" type="text" value="<?= $erf_draft['product_name'] ?>" placeholder="EX: Polo T-Shirt" class="form-control" required />
                                    </div>
                                    <!--// PRODUCT PRICE -->
                                    <div class="form-group">
                                        <label for="product_price">PRODUCT PRICE</label>
                                        <input name="product_price" id="product_price" type="number" min="0" step="0.01" value="<?= $erf_draft['product_price'] ?>" placeholder="EX: 20000" class="form-control" required />
                                    </div>
                                    <!--// REGISTRATION DEADLINE -->
                                    <div class="form-group">
                                        <label for="reg_deadline">REGISTRATION DEADLINE</label>
                                        <input name="reg_deadline" id="reg_deadline" type="date" value="<?= $erf_draft['reg_deadline'] ?>" class="form-control" required />
                                    </div>
                                    <!--// PARTICIPANT NUMBER -->
                                    <div class="form-group">
                                        <label for="inf_required">PARTICIPANT NUMBER</label>
                                        <input name="inf_required" id="inf_required" type="number" min="1" step="1" value="<?= $erf_draft['inf_required'] ?>" placeholder="EX: 50" class="form-control" required />
                                    </div>
                                    <!--// GENERAL BRIEF -->
                                    <div class="form-group">
                                        <label for="gen_brief">GENEREAL BRIEF</label>
                                        <textarea cols="30" rows="5" name="gen_brief" id="gen_brief" type="text" placeholder="Type Here" class="form-control" required style="max-width:100%;max-height:300px;min-width:100%;min-height:100px;"><?= $erf_draft['gen_brief'] ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <!--// NEGO -->
                                        <label for="negotiation">
                                        <input class="control-label" type="checkbox" name="negotiation" id="negotiation" value="1" <?php echo ($erf_draft['negotiation']==1 ? 'checked' : ''); ?> > Negotiation        
                                        </label>
                                        <!--// END NEGO -->
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit" name="set_erf">APPLY ERF CHANGES</button>
                                        <p class="small text-muted"><span class="guardsman">* Click "APPLY ERF CHANGES" to apply ERF data changes.</span> this button can be performed to change ERF data(not ERF components).</p>
                                    </div>
                                </form>
                            </fieldset>
                        </div>
                        <!-- /.form-container -->
                    </div>
                    <div class="col-md-6">
                        <fieldset>
                            <center>
                                <h4>COMPONENTS<br></h4>
                                <h6>ENDORSE REQUIREMENT FORM<br></h6>
                            </center>
                            <div id="message"></div>
                            <form method="post" action="">
                                <div class="form-group">
                                    <!--// PARTICIPANT CRITERIA -->
                                    <label for="inf_criteria">PARTICIPANT CRITERIA</label><span class="guardsman"> * mandatory, input at least one data.</span>
                                    <?php if( isset($inf_criteria) ): ?>
                                        <?php if( !empty($erf_draft) ): ?>
                                            <ul style="list-style-type:disc">
                                                <?php foreach($inf_criteria as $criteria): ?>
                                                    <li>
                                                        <?= $criteria['criteria'] ?>
                                                        <?php if( sizeof($inf_criteria) > 1 ): ?>
                                                            <a href="hapusCriteria.php?erf_id=<?= $criteria['erf_id'] ?>&criteria=<?= $criteria['criteria'] ?>" style="color:red;">X</a>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <input name="inf_criteria" id="inf_criteria" type="text" value="" placeholder="Input Criteria" class="form-control" />
                                    <button type="submit" name="add_inf_criteria" class="btn btn-primary">+ ADD MORE CRITERIA</button>
                                    <!--// END PARTICIPANT CRITERIA -->
                                </div>
                                <div class="form-group">
                                    <!--// REFERENSI -->
                                    <label for="ref_link">REFERENCE LINKS</label>
                                    <?php if( isset($ref_link) ): ?>
                                        <?php if( !empty($erf_draft) ): ?>
                                            <ul style="list-style-type:disc">
                                                <?php for($i = 0; $i < sizeof($ref_link); $i++): ?>
                                                    <li><a target="_blank" href="<?= $ref_link[$i]['link'] ?>"><?= 'Link' . ($i + 1); ?></a> <a href="hapusRefLink.php?erf_id=<?= $ref_link[$i]['erf_id'] ?>&link=<?= $ref_link[$i]['link'] ?>" style="color:red;">X</a></li>
                                                <?php endfor; ?>
                                            </ul>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <input name="ref_link" id="ref_link" type="text" value="" placeholder="Input Link Here" class="form-control" />
                                    <button type="url" name="add_ref_link" class="btn btn-primary">+ ADD MORE LINK</button>
                                    <!--// END REFERENCE -->
                                </div>
                                <div class="form-group">
                                    <!--// REFERENSI -->
                                    <label for="task_name">ERF TASKS</label><span class="guardsman"> * mandatory, input at least one data.</span>
                                    <button type="submit" name="add_task" class="btn btn-primary">+ ADD MORE TASK</button>
                                    <?php if( isset($task_list) ): ?>
                                        <table class="styled-table">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Task Name</th>
                                                    <th>Deadline</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for($i = 0; $i < sizeof($task_list); $i++): ?>
                                                    <tr class="bold-approved">
                                                        <td><?= $i+1; ?></td>
                                                        <td><?= $task_list[$i]['task_name']; ?></td>
                                                        <td><?= $task_list[$i]['task_deadline']; ?></td>
                                                        <td><?= $task_list[$i]['task_status']; ?></td>
                                                        <td>
                                                            <?php if( sizeof($task_list) > 1 ): ?>
                                                                <a href="hapusTask.php?task_id=<?= $task_list[$i]['task_id']; ?>">
                                                                    <button type="button" class="button button2">
                                                                        <i class="fa fa-trash" aria-hidden="true" style="color:red;"></i>
                                                                    </button>
                                                                </a>
                                                            <?php endif; ?>
                                                            <a href="editTask.php?task_id=<?= $task_list[$i]['task_id']; ?>&prev_url=editERF.php">
                                                                <button type="button">Edit</button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endfor; ?>
                                            </tbody>
                                        </table>
                                    <?php endif; ?>
                                    <!--// END REFERENCE -->
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <div class="editContent">
                                            <div class="btn-group">
                                    </div>
                                            <p class="small text-muted"><span class="guardsman">* Mandatory ERF components are Participant Criteria and ERF Task.</span> Once those mandatory components added (minimal 1 data), you could submit the ERF.</p>
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
        <script type="text/javascript" src="../../../style/js/jquery-1.11.1.min.js"></script>         
        <script type="text/javascript" src="../../../style/js/bootstrap.min.js"></script>         
        <script type="text/javascript" src="../../../style/js/plugins.js"></script>
        <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript" src="../../../style/js/bskit-scripts.js"></script>         
    </body>
</html>
