<?php 
ob_start();
session_start();
include 'nedmin/netting/baglan.php';
include 'nedmin/production/fonksiyon.php';
$ayarsor=$db-> prepare("SELECT * from ayar where ayar_id=:id");
$ayarsor->execute(array(
	'id' => 0

));
$ayarcek=$ayarsor->fetch(PDO::FETCH_ASSOC);

$menusor=$db->prepare("SELECT * FROM menu order by menu_sira");
$menusor->execute(array(

));
$menusor2=$db->prepare("SELECT * FROM menu where menu_durum=:durum order by menu_sira ASC limit 5"); // order by sıralama yapar ASC ise baştan sona sıralar.
$menusor2->execute(array(
	'durum'=> 1
));

$kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail");
$kullanicisor->execute(array(
	'mail' => $_SESSION['checkkullanici_mail']

));
$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);

$kategorisor=$db->prepare("SELECT * FROM kategori order by kategori_sira");
$kategorisor->execute();
$toplam=0;
$url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<head><?php if ($url=="http://babafiyatlarvip.rf.gd/eticaret/index.php") { ?>
		<link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
		/>
	<?php } ?>
		
		<meta name="description" content="<?php echo $ayarcek['ayar_description'] ?>">
		<meta name="keywords" content="<?php echo $ayarcek['ayar_keywords'] ?>">
		<meta name="author" content="<?php echo $ayarcek['ayar_author'] ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="dimg\biyik.png">
	</head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,400italic,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
	<link href='font-awesome\css\font-awesome.css' rel="stylesheet" type="text/css">
	<!-- Bootstrap -->
	<link href="bootstrap\css\bootstrap.min.css" rel="stylesheet">
	
	<!-- Main Style -->
	<link rel="stylesheet" href="style.css">
	
	<!-- owl Style -->
	<link rel="stylesheet" href="css\owl.carousel.css">
	<link rel="stylesheet" href="css\owl.transitions.css">
	<link rel="stylesheet" type="text/css" href="js\product\jquery.fancybox.css?v=2.1.5" media="screen">
	

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
	<div id="wrapper">
		<div class="header"><!--Header -->
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-4 main-logo animate__animated animate__fadeInRightBig">
						<a href="index.php"><img style="width:400px; height:50px " src="<?php echo $ayarcek['ayar_logo'] ?>" alt="logo" class="logo img-responsive"></a>
					</div>

					<div class="col-md-8">

						<div class="pushright">
							<?php if (isset($_SESSION['checkkullanici_mail'])==NULL) { ?>



								<div class="top">
									<a href="#" id="reg" class="btn btn-default btn-dark">Giriş Yap<span>-- Ya da --</span>Kaydol</a>
									<div class="regwrap">
										<div class="row">
											<div class="col-md-6 regform">
												<div class="title-widget-bg">
													<div class="title-widget">Giriş</div>
												</div>
												<form action="nedmin/netting/islem.php" method="POST" role="form">
													<div class="form-group">
														<input type="text" class="form-control"  name="kullanici_mail" placeholder="E-mail">
													</div>
													<div class="form-group">
														<input type="password" class="form-control" name="kullanici_password"  placeholder="Şifre">
													</div>
													<div class="form-group">
														<button type="submit" name="kullanicigiris" class="btn btn-default btn-red btn-m">Giriş Yap</button>
														<a href="sifre-unuttum.php" class="pull-right">Şifremi Unuttum</a>
													</div>
												</form>
											</div>
											<div class="col-md-6">
												<div class="title-widget-bg">
													<div class="title-widget">Kaydol</div>
												</div>
												<p>
													Yeni misin? O halde kayıt olmanın tam zamanı! Siteye Kaydolarak sana özel indirimlerden haberdar ol!
												</p>
												<a href="kullaniciekle.php"><button class="btn btn-default btn-yellow">Kaydol</button></a>
											</div>
										</div>
									</div>
								<?php }else{ ?>
									<div class="top">
										<a href="#" id="reg" class="btn btn-default btn-dark"> <p>Hoş Geldin <?php echo $kullanicicek['kullanici_ad']; ?></p></a>
										<div class="regwrap">
											<div class="row">
												<div class="col-md-6 regform">	
													<ul>
														<li><a href="hesabim.php" style="color:white;" class="myacc"><button type="submit" class="btn btn-warning btn-sm">Hesabım</button></a></li><br>
														<li><a href="siparislerim.php" style="color:white;" class="myshop"><button type="submit" class="btn btn-warning btn-sm">Siparişlerim</button></a></li>


													</ul>

												</div>
												<div class="col-md-6">
													<ul>
														<li><i class="fa fa-sign-out btn-l"><a href="kullanicicikis.php"><button type="submit" class="btn btn-danger btn-sm">Çıkış Yap</button></a></i></li>

													</ul>

												</div>
											</div>
										</div>
									<?php } ?>

									<div class="srch-wrap">
										<a href="#" id="srch" class="btn btn-default btn-search"><i class="fa fa-search"></i></a>
									</div>
									<div class="srchwrap">
										<div class="row">
											<div class="col-md-12">
												<form action="arama.php" method="POST" class="form-horizontal" role="form">
													<div class="form-group">
														<button class="btn btn-warning" name="arama" type="submit">Ara</button>
														<div class="col-sm-10">
															<input type="text" name="aranan" class="form-control" id="search">
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="dashed"></div>
			</div><!--Header -->
			<div class="main-nav"><!--end main-nav -->
				<div class="navbar navbar-default navbar-static-top">
					<div class="container">
						<div class="row">
							<div class="col-md-10">
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
								</div>
								<div class="navbar-collapse collapse">
									<ul class="nav navbar-nav">
										<li><a href="index.php" class="active">Ana Sayfa</a><div class="curve"></div></li>
										<li class="dropdown menu-large">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">Menüler <b class="caret"></b></a>
											<ul class="dropdown-menu megamenu container row">
												<li class="col-sm-4">
													<h4>Başlıklar</h4>
													<ul>
														<?php while($menucek=$menusor->fetch(PDO::FETCH_ASSOC)) { ?>
															<li><a href="
																<?php

																if (!empty($menucek['menu_url'])){
																	echo $menucek['menu_url'];
																	} else {
																		echo"sayfa-".seo($menucek['menu_ad']);
																	}			
																	?>"><?php echo $menucek['menu_ad'] ; ?></a></li>
																<?php } ?>
															</ul>
															<div class="dashed-nav"></div>
														</li>
														<li class="col-sm-4">
															<h4>Page Template</h4>
															<ul>
																<li><a href="index-1.htm">Home Page</a></li>
																<li><a href="category.htm">Category Page</a></li>
																<li><a href="category-list.htm">Category List Page</a></li>
																<li><a href="category-fullwidth.htm">Category fullwidth</a></li>
																<li><a href="product.htm">Detail Product Page</a></li>
																<li><a href="page-sidebar.htm">Page with sidebar</a></li>
																<li><a href="register.htm">Register Page</a></li>
																<li><a href="order.htm">Order Page</a></li>
																<li><a href="checkout.htm">Checkout Page</a></li>
																<li><a href="cart.htm">Cart Page</a></li>
																<li><a href="contact.htm">Contact Page</a></li>
															</ul>
															<div class="dashed-nav"></div>
														</li>
														<li class="col-sm-4">

															<div class="dashed-nav"></div>
														</li>
													</ul>
												</li>
												<li class="dropdown">
													<a href="#" class="dropdown-toggle" data-toggle="dropdown">Ürünler<b class="caret"></b></a>
													<ul class="dropdown-menu">
														<?php while($kategoricek=$kategorisor->fetch(PDO::FETCH_ASSOC)){ ?>		<li><a href="<?php echo"kategori-".seo($kategoricek['kategori_ad']); ?>"> <img width="35" src="dimg/<?php echo $kategoricek['kategori_icon'] ?>"><?php echo $kategoricek['kategori_ad'] ?></a></li>>
													<?php } ?>
												</ul>
											</li>

											<?php while($menucek2=$menusor2->fetch(PDO::FETCH_ASSOC)) { ?>
												<li><a href="
													<?php
													
													if (!empty($menucek2['menu_url'])){
														echo $menucek2['menu_url'];
														} else {														
															echo"sayfa-".seo($menucek2['menu_ad']);

														}

														?>"><?php echo $menucek2['menu_ad'] ; ?></a></li>
													<?php } ?>												

												</div>
											</div>
											<div class="col-md-2 machart">

												<?php
												$kulllanici_id2=$kullanicicek['kullanici_id'];
												$sepetsor2=$db->prepare("SELECT * FROM sepet where kullanici_id=:id");
												$sepetsor2->execute(array(
													'id'=> $kulllanici_id2

												));


												while ($sepetcek2=$sepetsor2->fetch(PDO::FETCH_ASSOC)) {


													$urun_id2=$sepetcek2['urun_id'];

													$urunsor2=$db-> prepare("SELECT * from urun where urun_id=:urun_id");
													$urunsor2->execute(array(
														'urun_id'=>$urun_id2
													));
													$uruncek2=$urunsor2->fetch(PDO::FETCH_ASSOC);
													$fakefiyat2=$uruncek2['urun_fakefiyat'];
													$fiyat2=$uruncek2['urun_fiyat'];
													$adet2=$sepetcek2['urun_adet'];
													$temp=0;
													$temp=bcmul($adet2, $fiyat2,2);
													$toplam=$temp+$toplam;
												}
												?>
												<button id="popcart" class="btn btn-default btn-chart btn-sm "><span class="mychart">Sepetim</span>|<span class="allprice"><?php echo $toplam." "."TL"; ?></span></button>
												<div class="popcart">
													<table class="table table-condensed popcart-inner">
														<tbody>
															<?php 
															$kulllanici_id=$kullanicicek['kullanici_id'];

															$sepetsor=$db->prepare("SELECT * FROM sepet where kullanici_id=:id limit 3");
															$sepetsor->execute(array(
																'id'=> $kulllanici_id

															));

															?>
															<?php $say3=0;

															while ($sepetcek=$sepetsor->fetch(PDO::FETCH_ASSOC)) {
																$say3++;
																$urun_id=$sepetcek['urun_id'];

																$urunsor=$db-> prepare("SELECT * from urun where urun_id=:urun_id");
																$urunsor->execute(array(
																	'urun_id'=>$urun_id
																));
																$uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);
																$fakefiyat=$uruncek['urun_fakefiyat'];
																$fiyat=$uruncek['urun_fiyat'];
																$adet=$sepetcek['urun_adet'];
																?>
																<tr>
																	<td>
																		<a href="sepet.php"><img src="dimg\plt01.jpg" alt="" class="img-responsive"></a>
																	</td>
																	<td><a href="sepet.php"><?php echo $uruncek['urun_ad']; ?></a><br><span>Renk: Yeşil</span></td>
																	<td><?php echo $sepetcek['urun_adet']."X"; ?></td>
																	<td><?php echo $fiyat." "."TL"; ?></td>
																	<td><form method="POST" action="nedmin/netting/islem.php"><button type="submit" name="sepet_sil2" class="btn btn-danger btn-xs"><i class="fa fa-times-circle fa-2x"></i>
																		<input type="hidden" name="sepet_id" value="<?php echo $sepetcek['sepet_id']; ?>">
																	</button>
																</form></td>
															</tr>
														<?php } ?>
														<?php if ($say3==0) { ?>
															<tr>
																<td>

																</td><img src="dimg\sadcat.png" width="175"  class="">
																<td><br><span style="color:red;">Görünüşe Bakılırsa Sepetiniz Boş...</span></td>
															</tr>
														<?php	} ?>
													</tbody>
												</table>

												<br>
												<div class="btn-popcart">
													<a href="sepet.php" class="btn btn-default btn-yellow">Sepete Git</a>
												</div>
												<div class="popcart-tot">
													<p>
														Toplam<br>
														<span><?php
														if($toplam==0){
															echo $toplam." "."TL"; ?></span>
														<?php 	}else{echo $toplam." "."TL"; ?>
													<?php }  ?>
												</p>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
	</div><!--end main-nav -->