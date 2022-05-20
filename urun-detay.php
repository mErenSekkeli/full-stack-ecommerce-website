<?php include 'header.php';

$urunsor=$db-> prepare("SELECT * from urun where urun_id=:id and urun_durum=:durum");
$urunsor->execute(array(
	'id'=>$_GET['urun_id'],
	'durum'=>1
));
$uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);

$renksor=$db->prepare("SELECT * FROM renk where urun_id=:id and renk_stok>0;");
$renksor->execute(array(
	'id' => $uruncek['urun_id']
));

$kategori_id=$uruncek['kategori_id'];

$urunsor2=$db-> prepare("SELECT * from urun where kategori_id=:kategori_id and urun_durum=:durum");
$urunsor2->execute(array(
	'kategori_id'=>$kategori_id,
	'durum'=>1
));


$yorumsor=$db-> prepare("SELECT * from yorum where yorum_durum=:durum");
$yorumsor->execute(array(
	'durum'=>1
));

?>
<title><?php echo $uruncek['urun_ad']; ?></title>
<div class="container">
	<div class="row">
		<div class="col-md-12">
		</div>
	</div>
	<?php
	$say=$urunsor->rowcount();
	if ($say==0) { ?>
		<br><br>
		<h3> Ürün Bulunamadı...</h3> 
		<div><a href="index.php"><img width="250" src="dimg/sadcat.png"></a><div class="spacer" align="left"><?php include 'side-bar.php'; ?></div></div></div>


		<?php	
		include 'footer.php';
		exit; }?>
		<div class="row">
			<div class="col-md-9"><!--Main content-->
				<div class="title-bg">
					<div class="title"><?php echo $uruncek['urun_ad']; ?></div>
				</div>
				<?php if (isset($_GET['durum'])) {
					
					if ($_GET['durum']=="ok") {
						echo "<p style=color:green;>Yorumun Değerlendiriliyor.</p>";
					}elseif ($_GET['durum']=="no"){
						echo "<p style=color:red;>Yorum Eklenemedi.</p>";
					} } ?>
					<?php if (isset($_GET['stok'])) { ?>
						<script type="text/javascript">alert("Seçtiğiniz Ürün Adedi Ürün Stoğunu Aşıyor. Lütfen Daha Az Adet Girin. ");</script>
					<?php	} ?>
					<?php if (isset($_GET['renk'])) { ?>
						<script type="text/javascript">alert("Lütfen Renk Seçmeyi Unutmayın. ");</script>
					<?php	} ?>
					<div class="row">
						<div class="col-md-6">
							<div class="dt-img">
								<?php $urunfotosor=$db->prepare("SELECT * FROM urunfoto where urun_id=:id order by urunfoto_sira ASC limit 1");
								$urunfotosor->execute(array(
									'id' => $uruncek['urun_id']

								));
								$urunfotocek=$urunfotosor->fetch(PDO::FETCH_ASSOC);
								?>
								<div  class="detpricetag blue"><div class="inner on-sale"><span class="onsale"><span class="oldprice"><?php echo $uruncek['urun_fakefiyat']."TL" ?></span><?php echo $uruncek['urun_fiyat']."TL" ?></span></div></div>
								<a class="fancybox" href="<?php echo $urunfotocek['urunfoto_yol'] ?>" data-fancybox-group="gallery" title="<?php echo $uruncek['urun_ad']; ?>"><img src="<?php echo $urunfotocek['urunfoto_yol'] ?>" alt="" class="img-responsive"></a>
							</div>
							<?php $urunfotosor2=$db->prepare("SELECT * FROM urunfoto where urun_id=:id order by urunfoto_sira ASC limit 1,10");
							$urunfotosor2->execute(array(
								'id' => $uruncek['urun_id']

							));

							?>
							<?php while ($urunfotocek2=$urunfotosor2->fetch(PDO::FETCH_ASSOC)) { ?>

								
								<div class="thumb-img">
									<a class="fancybox" href="<?php echo $urunfotocek2['urunfoto_yol'] ?>" data-fancybox-group="gallery" title="<?php echo $uruncek['urun_ad']; ?>"><img src="<?php echo $urunfotocek2['urunfoto_yol'] ?>" alt="" class="img-responsive"></a>
								</div>
							<?php } ?>
						</div>
						
						<div class="col-md-6 det-desc">
							<div class="productdata">
								<div class="infospan">Ürün Kodu: <span><?php echo $uruncek['urun_keyword']; ?></span></div>
								<div class="infospan">Stok Durumu: <span><?php if($uruncek['urun_stok']==0){ ?>
									<span style="color:red;">0</span>
									<?php	}else{ echo $uruncek['urun_fakestok'];} ?></span></div>
									<div class="infospan">Üretici Firma: <span><?php echo $uruncek['urun_uretici']; ?></span></div><br>

									<div align="center" class="sharing"><del><h2 style="color:#9a9a9a;"><?php echo $uruncek['urun_fakefiyat']." "."TL"; ?></h2></del> <h2><?php echo $uruncek['urun_fiyat']." "."TL"; ?></h2></div>

									<h4>Ürün Seçenekleri</h4>
									
									<form class="form-horizontal ava" method="POST" action="nedmin/netting/islem.php" role="form">

										<div class="form-group">
											<label for="color" class="col-sm-2 control-label">Renk</label>
											<div class="col-sm-10">
												<select class="form-control" name="renk_id" id="color">
													<option selected="" value="0">Renk Seçin</option>
													<?php while ($renkcek=$renksor->fetch(PDO::FETCH_ASSOC)) { ?>

														<option value="<?php echo $renkcek['renk_id']; ?>"><?php echo $renkcek['renk_ad']; ?></option>
													<?php	} ?>
												</select>
											</div>
											<div class="clearfix"></div>
											<div class="dash"></div>
										</div> 
										<?php $url="urun-".seo($uruncek['urun_ad'])."-".$uruncek['urun_id'];?>
										<div class="form-group">
											<label for="qty" class="col-sm-2 control-label">Adet</label>
											<div class="col-sm-4">
												<input min="1" max="5" value="1" type="number" class="form-control" name="urun_adet">

											</input>
										</div>
										<input type="hidden" name="kullanici_id" value="<?php echo $kullanicicek['kullanici_id']; ?>">
										<input type="hidden" name="urun_id" value="<?php echo $uruncek['urun_id']; ?>">
										<input type="hidden" name="urun_url" value="<?php echo $url; ?>">
										<div class="col-sm-4">
											<?php 	if (!isset($_SESSION['checkkullanici_mail'])) { ?>
												<p style="color:#DC143C; font-weight: bold;">Lütfen Giriş Yapın</p>
											<?php } ?>			
											<button <?php if($uruncek['urun_stok']==0){?> 
												disabled=""<?php }elseif(!isset($_SESSION['checkkullanici_mail'])){ ?>
													disabled=""
													<?php	} ?> type="submit" name="sepetekle" class="btn btn-success btn-m"><span class="addchart">Sepete Ekle</span></button>
												</div>
												<div class="clearfix"></div>
											</div>
										</form>

										<div class="sharing">
											<div class="share-bt">
												<div class="addthis_toolbox addthis_default_style ">
													<a class="addthis_counter addthis_pill_style"></a>
												</div>
												<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f0d0827271d1c3b"></script>
												<div class="clearfix"></div>
											</div>
											<div class="avatock"><span><?php if($uruncek['urun_stok']==0){?> <p style="color:red;">Stok Yok <?php }else{echo "Stok Var";} ?> </p> </span></div>
										</div>

									</div>
								</div>
							</div>
							<?php $yorumsor2=$db-> prepare("SELECT * from yorum where yorum_durum=:durum");
							$yorumsor2->execute(array(
								'durum'=>1
							)); $yorumsayısı=0;
							while($yorumcek2=$yorumsor2->fetch(PDO::FETCH_ASSOC)){
								$url2="urun-".seo($uruncek['urun_ad'])."-".$uruncek['urun_id'];
								if ($yorumcek2['yorum_url']==$url2){
									$yorumsayısı++;
								}
							}
							?>
							<div class="tab-review">
								<ul id="myTab" class="nav nav-tabs shop-tab">
									<li class="<?php if (empty($_GET['durum'])){echo "active";} ?>"><a href="#desc" data-toggle="tab">Açıklama</a></li>
									<li class="<?php if ($_GET['durum']=="ok"){echo "active";} ?>"><a href="#rev" data-toggle="tab">Yorumlar <?php echo "($yorumsayısı)"; ?></a></li>
								</ul>
								<div id="myTabContent" class="tab-content shop-tab-ct">
									<div class="tab-pane fade <?php if (empty($_GET['durum'])){echo "active in";} ?>" id="desc">
										<p>
											<?php echo $uruncek['urun_detay']; ?>
										</p>
									</div> 
									<div class="tab-pane fade <?php if ($_GET['durum']=="ok"){echo "active in";} ?>" id="rev">
										<?php //echo "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; bu da olur ?>

										<?php $say=0;
										while ($yorumcek=$yorumsor->fetch(PDO::FETCH_ASSOC)) { 
											$kullanici_id=$yorumcek['kullanici_id'];

											$kullanicisor2=$db->prepare("SELECT * FROM kullanici where kullanici_id=:id"); 
											$kullanicisor2->execute(array(
												'id' => $kullanici_id

											));
											$kullanicicek2=$kullanicisor2->fetch(PDO::FETCH_ASSOC);
											if($yorumcek['yorum_url']==$url){ $say++;  ?>
												<p class="dash">
													<span><?php echo $kullanicicek2['kullanici_ad']; ?></span> <?php echo "(".substr($yorumcek['yorum_zaman'],0,10).")"; ?><br><br>
													<?php echo $yorumcek['yorum_detay']; ?>
												</p>


											<?php	} } ?>
											<?php if($say==0){ ?>
												<p class="dash">
													<br><br>
													<?php echo "Hiç Yorum Yok."; ?>
													</p>	<?php } ?>

													<?php if (isset($_SESSION['checkkullanici_mail'])) { ?>


														<h4>Yorum Yazın</h4>
														<form role="form" action="nedmin/netting/islem.php" method="POST">
															<input type="hidden" name="kullanici_id" value="<?php echo $kullanicicek['kullanici_id']; ?>">
															<input type="hidden" name="yorum_durum" value="0">
															<input type="hidden" name="yorum_url" value="<?php echo $url; ?>">
															<div class="form-group">
																<textarea name="yorum_detay" class="form-control" id="text"></textarea>
															</div>

															<button type="submit" name="yorumekle" class="btn btn-default btn-warning btn-sm">Gönder</button>
														</form>
													<?php	}elseif (isset($_SESSION['checkkullanici_mail'])==NULL){ ?>
														<h4>Yorum Yazabilmek İçin <a href="login.php">Giriş</a> Yapın Ya da <a href="kullaniciekle.php">Kaydolun</a></h4>
														<form role="form">
															<div class="form-group">
																<input type="text" disabled="" class="form-control" id="name">
															</div>
															<div class="form-group">
																<textarea class="form-control" disabled="" id="text"></textarea>
															</div>
														<?php } ?>
													</div>
												</div>
											</div>

											<div id="title-bg">
												<div class="title">Benzer Ürünler</div>
											</div>
											<div class="row prdct"><!--Products-->
												<?php while ($uruncek2=$urunsor2->fetch(PDO::FETCH_ASSOC)) { ?>
													<?php if ($_GET['urun_id']==$uruncek2['urun_id']) {
														continue;
													} ?>
													<?php 
													$urunfotosor3=$db->prepare("SELECT * FROM urunfoto where urun_id=:id order by urunfoto_sira ASC limit 1");
													$urunfotosor3->execute(array(
														'id' => $uruncek2['urun_id']

													));
													$urunfotocek3=$urunfotosor3->fetch(PDO::FETCH_ASSOC);
													?>
													<div class="col-md-4">
														<div class="productwrap">
															<div class="pr-img">
																<div class="hot"></div>
																<a href="<?php echo"urun-".seo($uruncek2['urun_ad'])."-".$uruncek2['urun_id']; ?>"><img src="<?php echo $urunfotocek3['urunfoto_yol']; ?>" alt="" class="img-responsive"></a>
																<div class="pricetag on-sale"><div class="inner on-sale"><span class="onsale"><span class="oldprice"><?php echo $uruncek2['urun_fakefiyat']." "."TL"; ?></span><?php echo $uruncek2['urun_fiyat']." "."TL"; ?></span></div></div>
															</div>
															<span class="smalltitle"><a href="<?php echo"urun-".seo($uruncek2['urun_ad'])."-".$uruncek2['urun_id']; ?>"><?php echo $uruncek2['urun_ad']; ?></a></span>
															<span class="smalldesc">Ürün Kodu : <?php echo $uruncek2['urun_keyword']; ?></span>
														</div>
													</div>

												<?php } ?>


											</div><!--Products-->
											<div class="spacer"></div>
										</div><!--Main content-->
										<?php include 'side-bar.php'; ?>
										<!--sidebar-->
									</div>
								</div>
								<?php include 'footer.php'; ?>