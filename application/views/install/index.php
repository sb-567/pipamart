<?php

session_start();

require_once(APPPATH . 'libraries/install/lb_helper.php'); // Include LicenseBox external/client api helper file

$api = new LicenseBoxAPI(); // Initialize a new LicenseBoxAPI object
 
$filename = APPPATH . 'views/install/database.sql';

$product_info=$api->get_latest_version();

//print_r($product_info);
//exit;

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title><?php echo $product_info['product_name']; ?> - Installer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
    <style type="text/css">
      body, html {
        background: #F7F7F7;
      }
    </style>
  </head>
  <body>
    <?php
      $errors = false;
      $step = isset($_GET['step']) ? $_GET['step'] : '';
    ?>
    <div class="container"> 
      <div class="section">
        <div class="column is-6 is-offset-3">
          <center>
            <h1 class="title" style="padding-top: 20px"><?php echo $product_info['product_name']; ?> Installer</h1><br>
          </center>
          <div class="box">
            <?php
            switch ($step) {
              default: ?>
                <div class="tabs is-fullwidth">
                  <ul>
                    <li class="is-active">
                      <a>
                        <span><b>Requirements</b></span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span>Verify</span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span>Database</span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span>Finish</span>
                      </a>
                    </li>
                  </ul>
                </div>
                <?php  
                // Add or remove your script's requirements below
                if(phpversion() < "7.2"){
                  $errors = true;
                  echo "<div class='notification is-danger' style='padding:12px;'><i class='fa fa-times'></i> Current PHP version is ".phpversion()."! minimum PHP 7.2 or higher required.</div>";
                }else{
                  echo "<div class='notification is-success' style='padding:12px;'><i class='fa fa-check'></i> You are running PHP version ".phpversion()."</div>";
                }

                if(!extension_loaded('openssl')){
                  $errors = true; 
                echo "<div class='notification is-danger' style='padding:12px;'><i class='fa fa-times'></i> Openssl PHP extension missing!</div>";
                }else{
                  echo "<div class='notification is-success' style='padding:12px;'><i class='fa fa-check'></i> Openssl PHP extension available</div>";
                }

                if(!extension_loaded('pdo')){
                  $errors = true; 
                echo "<div class='notification is-danger' style='padding:12px;'><i class='fa fa-times'></i> PDO PHP extension missing!</div>";
                }else{
                  echo "<div class='notification is-success' style='padding:12px;'><i class='fa fa-check'></i> PDO PHP extension available</div>";
                }

                if(!extension_loaded('mbstring')){
                  $errors = true; 
                  echo "<div class='notification is-danger' style='padding:12px;'><i class='fa fa-times'></i> Mbstring PHP extension missing!</div>";
                }else{
                  echo "<div class='notification is-success' style='padding:12px;'><i class='fa fa-check'></i> Mbstring PHP extension available</div>";
                }

                if(!extension_loaded('tokenizer')){
                  $errors = true; 
                  echo "<div class='notification is-danger' style='padding:12px;'><i class='fa fa-times'></i> Tokenizer PHP extension missing!</div>";
                }else{
                  echo "<div class='notification is-success' style='padding:12px;'><i class='fa fa-check'></i> Tokenizer PHP extension available</div>";
                }
 
               
                if(!extension_loaded('xml')){
                  $errors = true; 
                  echo "<div class='notification is-danger' style='padding:12px;'><i class='fa fa-times'></i> XML PHP extension missing!</div>";
                }else{
                  echo "<div class='notification is-success' style='padding:12px;'><i class='fa fa-check'></i> XML PHP extension available</div>";
                }

                if(!extension_loaded('ctype')){
                  $errors = true; 
                  echo "<div class='notification is-danger' style='padding:12px;'><i class='fa fa-times'></i> CTYPE PHP extension missing!</div>";
                }else{
                  echo "<div class='notification is-success' style='padding:12px;'><i class='fa fa-check'></i> CTYPE PHP extension available</div>";
                }

                if(!extension_loaded('json')){
                  $errors = true; 
                  echo "<div class='notification is-danger' style='padding:12px;'><i class='fa fa-times'></i> JSON PHP extension missing!</div>";
                }else{
                  echo "<div class='notification is-success' style='padding:12px;'><i class='fa fa-check'></i> JSON PHP extension available</div>";
                }

                if(!extension_loaded('curl')){
                  $errors = true; 
                  echo "<div class='notification is-danger' style='padding:12px;'><i class='fa fa-times'></i> Curl PHP extension missing!</div>";
                }else{
                  echo "<div class='notification is-success' style='padding:12px;'><i class='fa fa-check'></i> Curl PHP extension available</div>";
                }
                 
                ?>

                <div style='text-align: right;'>
                  <?php if($errors==true){ ?>
                  <a href="#" class="button is-link" disabled>Next</a>
                  <?php }else{ ?>
                  <a href="index.php?step=0" class="button is-link">Next</a>
                  <?php } ?>
                </div><?php
                break;
              case "0": ?>
                <div class="tabs is-fullwidth">
                  <ul>
                    <li>
                      <a>
                        <span><i class="fa fa-check-circle"></i> Requirements</span>
                      </a>
                    </li>
                    <li class="is-active">
                      <a>
                        <span><b>Verify</b></span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span>Database</span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span>Finish</span>
                      </a>
                    </li>
                  </ul>
                </div>
                <?php
                  $license_code = null;
                  $client_name = null;
                  if(!empty($_POST['license'])&&!empty($_POST['client'])){
                    $license_code = abc;
                    $client_name = strip_tags(trim($_POST["client"]));
                    /* Once we have the license code and client's name we can use LicenseBoxAPI's activate_license() function for activating/installing the license, if the third parameter is empty a local license file will be created which can be used for background license checks. */
                    $activate_response = $api->activate_license($license_code,$client_name);

                    $_SESSION['envato_buyer_name']=$client_name;
                    $_SESSION['envato_purchase_code']=$license_code;

                    if(empty($activate_response)){
                      $msg='Server is unavailable.';
                    }else{
                      $msg=$activate_response['message'];
                    }
                    if($activate_response['status'] != false){ ?>
                      <form action="index.php?step=0" method="POST">
                        <div class="notification is-danger"><?php echo ucfirst($msg); ?></div>
                        <div class="field">
                          <label class="label">Envato Username
                              <p class="control-label-help">https://codecanyon.net/user/<u style="color: #e91e63">viaviwebtech</u></p>
                              <p class="control-label-help">(<u style="color: #e91e63">viaviwebtech</u> is username)</p>
                          </label>
                          <div class="control">
                            <input class="input" type="text" placeholder="viaviwebtech" name="client" >
                          </div>
                        </div>
                        <div class="field">
                          <label class="label">Envato Purchase Code :-
                            <p class="control-label-help">(<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target="_blank">Where Is My Purchase Code?</a>)</p>
                          </label>
                          <div class="control">
                            <input class="input" type="text" placeholder="xxxx-xxxx-xxxx-xxxx-xxxx" name="license" >
                          </div>
                        </div>
                        <div style='text-align: right;'>
                          <button type="submit" class="button is-link">Verify</button>
                        </div>
                      </form><?php
                    }else{ ?>
                      <form action="index.php?step=1" method="POST">
                        <div class="notification is-success"><?php echo ucfirst($msg); ?></div>
                        <input type="hidden" name="lcscs" id="lcscs" value="<?php echo ucfirst($activate_response['status']); ?>">
                        <div style='text-align: right;'>
                          <button type="submit" class="button is-link">Next</button>
                        </div>
                      </form><?php
                    }
                  }else{ ?>
                    <form action="index.php?step=0" method="POST">
                      <div class="field">
                        <label class="label">Envato Username
                          <p class="control-label-help">https://codecanyon.net/user/<u style="color: #e91e63">viaviwebtech</u></p>
                          <p class="control-label-help">(<u style="color: #e91e63">viaviwebtech</u> is username)</p>
                        </label>
                        <div class="control">
                          <input class="input" type="text" placeholder="viaviwebtech" name="client">
                        </div>
                      </div>
                      <div class="field">
                        <label class="label">Envato Purchase Code :-
                          <p class="control-label-help">(<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target="_blank">Where Is My Purchase Code?</a>)</p>
                        </label>
                        <div class="control">
                          <input class="input" type="text" placeholder="xxxx-xxxx-xxxx-xxxx-xxxx" name="license" >
                        </div>
                      </div>
                      <div style='text-align: right;'>
                        <button type="submit" class="button is-link">Verify</button>
                      </div>
                    </form>
                  <?php } 
                break;
              case "1": ?>
                <div class="tabs is-fullwidth">
                  <ul>
                    <li>
                      <a>
                        <span><i class="fa fa-check-circle"></i> Requirements</span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span><i class="fa fa-check-circle"></i> Verify</span>
                      </a>
                    </li>
                    <li class="is-active">
                      <a>
                        <span><b>Database</b></span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span>Finish</span>
                      </a>
                    </li>
                  </ul>
                </div>
                <?php
                  if($_POST && isset($_POST["lcscs"])){
                    $valid = strip_tags(trim($_POST["lcscs"]));
                    $db_host = strip_tags(trim($_POST["host"]));
                    $db_user = strip_tags(trim($_POST["user"]));
                    $db_pass = strip_tags(trim($_POST["pass"]));
                    $db_name = strip_tags(trim($_POST["name"]));
                    // Let's import the sql file into the given database
                    if(!empty($db_host)){
                      $con = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);

                      mysqli_query($con,"SET NAMES 'utf8'");  

                      if(mysqli_connect_errno()){ ?>
                        <form action="index.php?step=1" method="POST">
                          <div class='notification is-danger'>Failed to connect to MySQL: <?php echo mysqli_connect_error(); ?></div>
                          <input type="hidden" name="lcscs" id="lcscs" value="<?php echo $valid; ?>">
                          <div class="field">
                            <label class="label">Database Host
                              <p class="control-label-help">Default Host: <u style="color: #e91e63">localhost</u></p>
                            </label>
                            <div class="control">
                              <input class="input" type="text" id="host" placeholder="enter your database host" name="host" required>
                            </div>
                          </div>
                          <div class="field">
                            <label class="label">Database Username</label>
                            <div class="control">
                              <input class="input" type="text" id="user" placeholder="enter your database username" name="user" required>
                            </div>
                          </div>
                          <div class="field">
                            <label class="label">Database Password</label>
                            <div class="control">
                              <input class="input" type="text" id="pass" placeholder="enter your database password" name="pass">
                            </div>
                          </div>
                          <div class="field">
                            <label class="label">Database Name</label>
                            <div class="control">
                              <input class="input" type="text" id="name" placeholder="enter your database name" name="name" required>
                            </div>
                          </div>
                          <div style='text-align: right;'>
                            <button type="submit" class="button is-link">Import</button>
                          </div>
                        </form><?php
                        exit;
                      }

                      $templine = '';
                      $lines = file($filename);

                      foreach($lines as $line){
                        if(substr($line, 0, 2) == '--' || $line == '')
                          continue;
                        $templine .= $line;
                        $query = false;
                        if(substr(trim($line), -1, 1) == ';'){
                          $query = mysqli_query($con, $templine);
                          $templine = '';
                        }
                      }

                      $dataFile=APPPATH . 'config/database.php';

                      $fhandle = fopen($dataFile,"r");
                      $content = fread($fhandle,filesize($dataFile));

                      $content = str_replace('db_name', $db_name, $content);

                      $content = str_replace('db_uname', $db_user, $content);

                      $content = str_replace('db_password', $db_pass, $content);

                      $content = str_replace('db_hname', $db_host, $content);

                      $fhandle = fopen($dataFile,"w");
                      fwrite($fhandle,$content);
                      fclose($fhandle);


                      // Update envato client details

                      mysqli_autocommit($con,FALSE);

                      $sqlUpdate="UPDATE tbl_verify SET 
                        `web_envato_buyer_name` = '".$_SESSION['envato_buyer_name']."',
                        `web_envato_purchase_code` = '".$_SESSION['envato_purchase_code']."',
                        `web_envato_buyer_email` = '-',
                        `android_envato_buyer_name` = '".$_SESSION['envato_buyer_name']."',
                        `web_envato_purchased_status` = '1' WHERE `id` = 1";

                      $result=mysqli_query($con, $sqlUpdate) or die(mysqli_error($con));

                      // Commit transaction
                      if (!mysqli_commit($con)) {
                        echo "Commit transaction failed";
                        exit();
                      }

                      // Close connection
                      mysqli_close($con);


                    ?>
                    <form action="index.php?step=2" method="POST">
                      <div class='notification is-success'>Database was successfully imported.</div>
                      <input type="hidden" name="dbscs" id="dbscs" value="true">
                      <div style='text-align: right;'>
                        <button type="submit" class="button is-link">Next</button>
                      </div>
                    </form><?php
                  }else{ ?>
                    <form action="index.php?step=1" method="POST">
                      <input type="hidden" name="lcscs" id="lcscs" value="<?php echo $valid; ?>">
                      <div class="field">
                        <label class="label">Database Host
                          <p class="control-label-help">Default Host: <u style="color: #e91e63">localhost</u></p>
                        </label>
                        <div class="control">
                          <input class="input" type="text" id="host" placeholder="enter your database host" name="host" required>
                        </div>
                      </div>
                      <div class="field">
                        <label class="label">Database Username</label>
                        <div class="control">
                          <input class="input" type="text" id="user" placeholder="enter your database username" name="user" required>
                        </div>
                      </div>
                      <div class="field">
                        <label class="label">Database Password</label>
                        <div class="control">
                          <input class="input" type="text" id="pass" placeholder="enter your database password" name="pass">
                        </div>
                      </div>
                      <div class="field">
                        <label class="label">Database Name</label>
                        <div class="control">
                          <input class="input" type="text" id="name" placeholder="enter your database name" name="name" required>
                        </div>
                      </div>
                      <div style='text-align: right;'>
                        <button type="submit" class="button is-link">Import</button>
                      </div>
                    </form><?php
                } 
              }else{ ?>
                <div class='notification is-danger'>Sorry, something went wrong.</div><?php
              }
              break;
            case "2": ?>
              <div class="tabs is-fullwidth">
                <ul>
                  <li>
                    <a>
                      <span><i class="fa fa-check-circle"></i> Requirements</span>
                    </a>
                  </li>
                  <li>
                    <a>
                      <span><i class="fa fa-check-circle"></i> Verify</span>
                    </a>
                  </li>
                  <li>
                    <a>
                      <span><i class="fa fa-check-circle"></i> Database</span>
                    </a>
                  </li>
                  <li class="is-active">
                    <a>
                      <span><b>Finish</b></span>
                    </a>
                  </li>
                </ul>
              </div>
              <?php
              if($_POST && isset($_POST["dbscs"])){
                $valid = $_POST["dbscs"];

                $old_file='application/config/routes_replace.php';
                $new_file='application/config/routes.php';

                if(!rename($old_file,$new_file)){
                    exit;
                }

                $old_file='application/config/autoload_replace.php';
                $new_file='application/config/autoload.php';

                if(!rename($old_file,$new_file)){
                    exit;
                }

                ?>
                <center>
                  <p><strong><?php echo $product_info['product_name']; ?> is successfully installed.</strong></p><br>
                  <br>
                  <p>You can now login using your username: <strong>admin</strong> and default password: <strong>admin</strong></p><br><strong>
                  <p><a class='button is-link' href='<?=base_url('admin')?>'>Login</a></p></strong>
                  <br>
                  <p class='help has-text-grey'>The first thing you should do is change your account details.</p>
                </center>
                <?php
              }else{ ?>
                <div class='notification is-danger'>Sorry, something went wrong.</div><?php
              } 
            break;
          } ?>
        </div>
      </div>
    </div>
  </div>
  <div class="content has-text-centered">
    <p>Copyright <?php echo date('Y'); ?> Viaviweb.com, All rights reserved.</p><br>
  </div>
</body>
</html>
 