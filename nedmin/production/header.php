<!DOCTYPE html>
<html lang="en">
<head>
  <?php
  ob_start();
  session_start();
  include '../netting/baglan.php';

  $kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail");
  $kullanicisor->execute(array(
    'mail' => $_SESSION['kullanici_mail']
    
  ));
  $say=$kullanicisor->rowCount ();
  $kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);
  //bu ifi yaparak izinsiz girişler engelleniyor.
  if ($say==0) {
    header("Location:login.php?durum=izinsiz");
    exit;
  }

  $ayarsor=$db-> prepare("SELECT * from ayar where ayar_id=:id");
  $ayarsor->execute(array(
    'id' => 0

  ));
  $ayarcek=$ayarsor->fetch(PDO::FETCH_ASSOC);


  $hakkimizdasor=$db-> prepare("SELECT * from hakkimizda where hakkimizda_id=:id");
  $hakkimizdasor->execute(array(
    'id' => 0

  ));
  $hakkimizdacek=$hakkimizdasor->fetch(PDO::FETCH_ASSOC);


  ?>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../../images/lock-icon-11.png">
  <title>Admin Paneli</title>

  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <!-- Datatables -->
  <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

  <!-- Dropzone.js -->

  <link href="../vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">



  <!-- Dropzone.js -->

  <script src="../vendors/dropzone/dist/min/dropzone.min.js"></script>

  <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="index.php" class="site_title"><i class="fa fa-dollar"></i> <span>Admin Paneli</span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <a href="index.php"> <img src="images/ben.jpg" alt="..." class="img-circle profile_img"></a> 
            </div>
            <div class="profile_info">
              <span>Hoş Geldin,</span>
              <h2><?php echo $kullanicicek['kullanici_ad']." ".$kullanicicek['kullanici_soyad'] ?></h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>Panel</h3>
              <ul class="nav side-menu">
                <li><a href="index.php"><i class="fa fa-home"></i> Ana Sayfa </a></li>
                <li><a><i class="fa fa-shopping-bag"></i>Siparişler <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><span class="fa fa-barcode"></span><a href="siparis.php">Sipariş Listesi</a></li>
                    <li><span class="fa fa-plus"></span><a href="siparis-ekle.php">Sipariş Ekleme</a></li>

                  </ul> 
                  <li><a><i class="fa fa-shopping-basket"></i>Ürünler <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><span class="fa fa-archive"></span><a href="urun.php">Ürün Listesi</a></li>
                    <li><span class="fa fa-plus"></span><a href="urun-ekle.php">Ürün Ekleme</a></li>

                  </ul> 
                  <li><a href="yorum-islem.php"><i class="fa fa-comments"></i>Yorum İşlemleri </a>
                    <li><a href="kupon.php"><i class="fa fa-tag"></i>Kupon İşlemleri </a>      
                      <li><a><i class="fa fa-users"></i> Kullanıcı İşlemleri <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                         <li><span class="fa fa-list"></span><a href="kullanici.php">Kullanıcı Listesi</a></li>
                         <li><span class="fa fa-user-plus"></span><a href="kullanici-ekle.php">Kullanıcı Ekleme</a></li>  
                       </ul>
                       <li><a><i class="fa fa-bars"></i> Menü İşlemleri <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><span class="fa fa-bars"></span><a href="menu.php">Menü Listesi</a></li>
                          <li><span class="fa fa-plus"></span><a href="menu-ekle.php">Menü Ekleme</a></li>

                        </ul>          
                        <li><a><i class="fa fa-image"></i> Slider İşlemleri <span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li><span class="fa fa-bars"></span><a href="slider.php">Slider Listesi</a></li>
                            <li><span class="fa fa-plus"></span><a href="slider-ekle.php">Slider Ekleme</a></li>

                          </ul>

                          <li><a><i class="fa fa-align-justify"></i> Kategori İşlemleri <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                              <li><span class="fa fa-bars"></span><a href="kategori.php">Kategori Listesi</a></li>
                              <li><span class="fa fa-plus"></span><a href="kategori-ekle.php">Kategori Ekleme</a></li>

                            </ul>

                            <li><a><i class="fa fa-cogs"></i> Ayarlar <span class="fa fa-chevron-down"></span></a>

                              <ul class="nav child_menu">
                                <li><span class="fa fa-cog"></span><a href="genel-ayar.php">Genel Ayarlar</a></li>
                                <li><span class="fa fa-shopping-cart"></span><a href="entegre-ayar.php">Ödeme Entegre Ayarları</a></li>
                                <li><span class=""></span><a href="logo-ayar.php">Logo Ayarları</a></li>
                                <li><span class="fa fa-phone-square"></span><a href="iletisim-ayar.php">İletişim Ayarları</a></li>
                                <li><span class="fa fa-facebook-square"></span><a href="sosyalmedya-ayar.php">Sosyal Medya Ayarları</a></li>
                                <li><span class="fa fa-map"></span><a href="adres-ayar.php">Adres Ayarları</a></li>
                                <li><span class="fa fa-server"></span><a href="api-ayar.php">APİ Ayarları</a></li>
                                <li><span class="fa fa-envelope"></span><a href="mail-ayar.php">Mail Ayarları</a></li>
                                <li><span class="fa fa-info"></span><a href="hakkimizda-ayar.php">Hakkımızda Ayarları</a></li>
                              </ul>
                              <li><a href="banka.php"><i class="fa fa-money"></i>Banka İşlemleri </a>
                                <li><a href="kargo.php"><i class="fa fa-truck"></i>Kargo İşlemleri </a>
                                <li><a href="bildirim.php"><i class="fa fa-bell"></i>Bildirimler </a>                             
                                </div>


                              </div>
                              <!-- /sidebar menu -->

                              <!-- /menu footer buttons -->
                              <div class="sidebar-footer hidden-small">
                                <a data-toggle="tooltip" href="genel-ayar.php" data-placement="top" title="Settings">
                                  <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                </a>
                                <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                                  <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                                </a>
                                <a data-toggle="tooltip" data-placement="top" title="Lock">
                                  <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                                </a>
                                <a data-toggle="tooltip" href="logout.php" data-placement="top" title="Çıkış Yap">
                                  <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                                </a>
                              </div>
                              <!-- /menu footer buttons -->
                            </div>
                          </div>

                          <!-- top navigation -->
                          <div class="top_nav">
                            <div class="nav_menu">
                              <nav>
                                <div class="nav toggle">
                                  <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                                </div>

                                <ul class="nav navbar-nav navbar-right">
                                  <li class="">
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                      <img src="images/ben.jpg" alt=""><?php echo $kullanicicek['kullanici_adsoyad']; ?>
                                      <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                                      <li><a href="javascript:;"> Profil</a></li>

                                      <li><a href="javascript:;">Yardım</a></li>
                                      <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i>Çıkış Yap</a></li>
                                    </ul>
                                  </li>

                                  <li role="presentation" class="dropdown">
                                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                      <i class="fa fa-envelope-o"></i>
                                      <span class="badge bg-green">6</span>
                                    </a>
                                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                      <li>
                                        <a>
                                          <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                          <span>
                                            <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                          </span>
                                          <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                          </span>
                                        </a>
                                      </li>
                                      <li>
                                        <a>
                                          <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                          <span>
                                            <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                          </span>
                                          <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                          </span>
                                        </a>
                                      </li>
                                      <li>
                                        <a>
                                          <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                          <span>
                                            <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                          </span>
                                          <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                          </span>
                                        </a>
                                      </li>
                                      <li>
                                        <a>
                                          <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                          <span>
                                            <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                          </span>
                                          <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                          </span>
                                        </a>
                                      </li>
                                      <li>
                                        <div class="text-center">
                                          <a>
                                            <strong>See All Alerts</strong>
                                            <i class="fa fa-angle-right"></i>
                                          </a>
                                        </div>
                                      </li>
                                    </ul>
                                  </li>
                                </ul>
                              </nav>
                            </div>
                          </div>
                          <!-- /top navigation -->
