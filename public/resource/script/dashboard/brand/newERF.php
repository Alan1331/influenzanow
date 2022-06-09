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
$brand_id = query("SELECT brand_id FROM brand WHERE brand_name = \"$brand_name\"")[0]['brand_id'];
$erf_draft = query("SELECT * FROM erf WHERE brand_id = $brand_id AND erf_status = 'drafted'")[0];

if( !empty($erf_draft) ) {
    $erf_id = $erf_draft['erf_id'];
    $inf_criteria = query("SELECT * FROM inf_criteria WHERE erf_id = $erf_id");
}

if( !empty($erf_draft) ) {
    $erf_id = $erf_draft['erf_id'];
    $ref_link = query("SELECT * FROM ref_link WHERE erf_id = $erf_id");
}

if( isset($_POST['set_erf']) ) {
    if( $_POST['erf_pict'] == "" ) {
        $_POST['erf_pict'] = 'default.png';
    }
    if( !isset($_POST['negotiation'])) {
        $_POST['negotiation'] = 0;
    }
    if( setERF($_POST, $erf_draft, $brand_id) > 0 ) {
        echo "
                <script>
                    alert('erf berhasil diset');
                    window.location = 'newERF.php';
                </script>
            ";
    } else {
        echo "
                <script>
                    alert('erf gagal diset');
                    window.location = 'newERF.php';
                </script>
            ";
    }
}

if( isset($_POST['add_inf_criteria'])) {
    // jika erf belum diset, tidak dapat menambah kriteria
    if( empty($erf_draft) ) {
        echo "
                <script>
                    alert('set erf terlebih dahulu');
                    window.location = 'newERF.php';
                </script>
            ";
    } else {
        if(add_criteria($_POST, $erf_draft['erf_id']) > 0) {
            echo "
                    <script>
                        alert('kriteria berhasil ditambahkan');
                        window.location = 'newERF.php';
                    </script>
                ";
        } else {
            echo "
                    <script>
                        alert('kriteria gagal ditambahkan');
                        window.location = 'newERF.php';
                    </script>
                ";
        }
    }
}

if( isset($_POST['add_ref_link'])) {
    // jika erf belum diset, tidak dapat menambah kriteria
    if( empty($erf_draft) ) {
        echo "
                <script>
                    alert('set erf terlebih dahulu');
                    window.location = 'newERF.php';
                </script>
            ";
    } else {
        if(add_ref_link($_POST, $erf_draft['erf_id']) > 0) {
            echo "
                    <script>
                        alert('reference link berhasil ditambahkan');
                        window.location = 'newERF.php';
                    </script>
                ";
        } else {
            echo "
                    <script>
                        alert('reference link gagal ditambahkan');
                        window.location = 'newERF.php';
                    </script>
                ";
        }
    }
}

if( isset($_POST['add_task'])) {
    // jika erf belum diset, tidak dapat menambah kriteria
    if( empty($erf_draft) ) {
        header('Location: newTask.php');
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
                                <form method="post" action="">
                                    <!--// PRODUCT PICTURE -->
                                    <div class="form-group">
                                        <label for="erf_pict">PRODUCT PICTURE</label>
                                        <input name="erf_pict" id="erf_pict" type="file" value="<?= $erf_draft['erf_pict'] ?>" class="form-control" />
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
                                        <input name="product_price" id="product_price" type="number" min="0" step="0.01" value="<?= $erf_draft['product_price'] ?>" placeholder="EX: Rp 200.000,-" class="form-control" required />
                                    </div>
                                    <!--// GENERAL BRIEF -->
                                    <div class="form-group">
                                        <!--// GENERAL BRIEF --> <!--// FYI AKU GATAU FUNGSI GENERAL BRIEF APA DAN TARO MANA WKWKWKWK -->
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
                                        <button type="submit" name="set_erf">SET ERF</button>
                                        <button type="submit" name="submit_erf">SUBMIT ERF</button>
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
                                    <label for="inf_criteria">PARTICIPANT CRITERIA</label>
                                    <?php if( !empty($erf_draft) ): ?>
                                        <ul style="list-style-type:disc">
                                            <?php foreach($inf_criteria as $criteria): ?>
                                                <li><?= $criteria['criteria'] ?> <a href="hapusCriteria.php?erf_id=<?= $criteria['erf_id'] ?>&criteria=<?= $criteria['criteria'] ?>" style="color:red;">X</a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                    <input name="inf_criteria" id="inf_criteria" type="text" value="" placeholder="Input Criteria" class="form-control" />
                                    <button type="submit" name="add_inf_criteria" class="btn btn-primary">+ ADD MORE CRITERIA</button>
                                    <!--// END PARTICIPANT CRITERIA -->
                                </div>
                                <div class="form-group">
                                    <!--// REFERENSI -->
                                    <label for="ref_link">REFERENCE LINKS</label>
                                    <?php if( !empty($erf_draft) ): ?>
                                        <ul style="list-style-type:disc">
                                            <?php for($i = 0; $i < sizeof($ref_link); $i++): ?>
                                                <li><a target="_blank" href="<?= $ref_link[$i]['link'] ?>"><?= 'Link' . ($i + 1); ?></a> <a href="hapusRefLink.php?erf_id=<?= $ref_link[$i]['erf_id'] ?>&link=<?= $ref_link[$i]['link'] ?>" style="color:red;">X</a></li>
                                            <?php endfor; ?>
                                        </ul>
                                    <?php endif; ?>
                                    <input name="ref_link" id="ref_link" type="text" value="" placeholder="Input Link Here" class="form-control" />
                                    <button type="url" name="add_ref_link" class="btn btn-primary">+ ADD MORE LINK</button>
                                    <!--// END REFERENCE -->
                                </div>
                                <div class="form-group">
                                    <!--// REFERENSI -->
                                    <label for="task_name">ERF TASKS</label>
                                    <input name="task_name" id="task_name" type="text" value="" placeholder="Input Link Here" class="form-control" />
                                    <button type="submit" name="add_task" class="btn btn-primary">+ ADD MORE TASK</button>
                                    <!--// END REFERENCE -->
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
        <script type="text/javascript" src="../../../style/js/jquery-1.11.1.min.js"></script>         
        <script type="text/javascript" src="../../../style/js/bootstrap.min.js"></script>         
        <script type="text/javascript" src="../../../style/js/plugins.js"></script>
        <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript" src="../../../style/js/bskit-scripts.js"></script>         
    </body>     
</html>
