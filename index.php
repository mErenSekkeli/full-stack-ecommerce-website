<?php  include 'header.php'; 
$slidersor=$db->prepare("SELECT * FROM slider where slider_durum=:durum order by slider_sira");
$slidersor->execute(array(
	'durum'=>1

));


$urunsor=$db-> prepare("SELECT * from urun where urun_durum=:durum and urun_star=:urun_star order by urun_zaman DESC");
$urunsor->execute(array(
	'durum'=>1,
	'urun_star'=>1
));
$urunsor2=$db-> prepare("SELECT * from urun where urun_durum=:durum order by urun_zaman DESC limit 6");
$urunsor2->execute(array(
	'durum'=>1
));

$hakkimizdasor=$db-> prepare("SELECT * from hakkimizda where hakkimizda_id=:id");
$hakkimizdasor->execute(array(
	'id' => 0

));
$hakkimizdacek=$hakkimizdasor->fetch(PDO::FETCH_ASSOC);

?> 
<head>
<title>Türkiye'nin En Baba Online Alışveriş Sitesi babafiyatlarvip.rf.gd</title>
	<!-- Start of  Zendesk Widget script -->
		<script id="ze-snippet" src="<?php echo $ayarcek['ayar_zopim']; ?>"> </script>
		<!-- End of  Zendesk Widget script --></head>

<div class="container">

	<ul class="small-menu">
		<?php if (isset($_SESSION['checkkullanici_mail'])) { ?>
			<?php
			$bildirimsor=$db->prepare("SELECT * FROM bildirim where bildirim_durum=:durum and kullanici_id=:id order by bildirim_id");
			$bildirimsor->execute(array(
				'durum'=>1,
				'id'=>$kullanicicek['kullanici_id']
			));

			$bildirimsor2=$db->prepare("SELECT * FROM bildirim where bildirim_durum=:durum and kullanici_id=:id order by bildirim_id");
			$bildirimsor2->execute(array(
				'durum'=>1,
				'id'=>$kullanicicek['kullanici_id']
			));
			$bilsay=0;											
			while ($bildirimcek2=$bildirimsor2->fetch(PDO::FETCH_ASSOC)) {
				$bilsay++;
			}
			?>
<style type="text/css">
	.numberCircle {
    border-radius: 50%;
    width: 36px;
    height: 36px;
    padding: 2px;

    background: #fff;
   
    color: #666;
    text-align: center;

    font: 14px Arial, sans-serif;
}
</style>
			<li class="dropdown">
				<a href="#" data-toggle="dropdown"><i class="fa fa-envelope"></i><span class="numberCircle" style="border-radius: 50%; background-color: #0096ff; "><b style="color:white;"> <?php echo $bilsay; ?></b></span></a>
				<ul class="dropdown-menu">
					<?php while ($bildirimcek=$bildirimsor->fetch(PDO::FETCH_ASSOC)) { ?>
						<li><a href="nedmin/netting/islem.php?bildirim=ok&bildirim_url=<?php echo $bildirimcek['bildirim_url']; ?>&kullanici_id=<?php echo $kullanicicek['kullanici_id']; ?>&bildirim_id=<?php echo $bildirimcek['bildirim_id']; ?>"><?php echo $bildirimcek['bildirim_ad']; ?> <br><span class="smalldesc"><?php echo $bildirimcek['bildirim_detay']; ?></span></a></li>


					<?php	}if ($bilsay==0) { ?>
						<li><a href="#">Hiç Mesajınız Yok</a></li>

					<?php	} ?>
					</ul>
				</li>
		<li><a href="hesabim.php" class="myacc">Hesabım</a></li>
		<li><a href="siparislerim.php" class="myshop">Siparişlerim</a></li>
		<li><a href="kullanicicikis.php" class="myacc">Çıkış Yap</a></li>
	<?php	}else{ ?>
		<li><a href="kullaniciekle.php" class="myacc">Kaydol</a></li>
		<li><a href="login.php" class="myacc">Giriş Yap</a></li>
	<?php } ?>

</ul> 
<div class="clearfix"></div>
<div class="lines"></div>
<div class="main-slide">
	<div id="sync1" class="owl-carousel animate__animated animate__zoomIn">
		<?php while($slidercek=$slidersor->fetch(PDO::FETCH_ASSOC)){ ?>
			<div class="item">
				<div class="slide-desc">
					<div class="inner">

						<p>
							<?php echo substr($slidercek['slider_icerik'], 0, 80); ?>
						</p>
						<?php if($slidercek['slider_button']==1){ ?>
							<a href="<?php echo $slidercek['slider_link']; ?>"><button class="btn btn-default btn-red btn-lg">Ürüne Git</button></a>
						<?php }else{

						} ?>
					</div>
					<?php if($slidercek['slider_deal']==1){ ?>
						<div class="inner">
							<div class="pro-pricetag big-deal">
								<div class="inner">
									<span class="oldprice"><?php echo $slidercek['slider_fakefiyat']." "."₺" ?></span>
									<span><?php echo $slidercek['slider_fiyat']."₺" ?></span>
									<span class="ondeal">En iyi Fiyat</span>
								</div>
							</div>
						</div>
					<?php }else{

					} ?>
				</div>
				<div class="slide-type-1">
					<a href="<?php echo $slidercek['slider_link']; ?>"><img src="<?php echo $slidercek['slider_resimyol']; ?>" alt="" class="img-responsive"></a>
				</div>
			</div>
		<?php } ?>

	</div>
</div>
</div>
</div>
<br><br>
<div class="f-widget featpro">
	<div class="container">
		<div class="title-widget-bg">
			<div class="title-widget">Öne Çıkanlar</div>
			<div class="carousel-nav">
				<a class="prev"></a>
				<a class="next"></a>
			</div>
		</div>
		<div id="product-carousel" class="owl-carousel owl-theme">
			<?php while ($uruncek=$urunsor->fetch(PDO::FETCH_ASSOC)){ ?>
				<?php $urunfotosor=$db->prepare("SELECT * FROM urunfoto where urun_id=:id order by urunfoto_sira ASC limit 1");
				$urunfotosor->execute(array(
					'id' => $uruncek['urun_id']

				));
				$urunfotocek=$urunfotosor->fetch(PDO::FETCH_ASSOC);
				?>
				<div class="item">
					<div class="productwrap">
						<div class="pr-img">
							<div class="hot"></div>
							<a href="<?php echo"urun-".seo($uruncek['urun_ad'])."-".$uruncek['urun_id']; ?>"><img src="<?php echo $urunfotocek['urunfoto_yol'] ?>" alt="" class="img-responsive"></a>
							<div class="pricetag on-sale"><div class="inner"><span class="onsale"><span class="oldprice"><?php echo $uruncek['urun_fakefiyat']."₺" ?></span><?php echo $uruncek['urun_fiyat']."₺" ?></span></div></div>
						</div>
						<span class="smalltitle"><a href="<?php echo"urun-".seo($uruncek['urun_ad'])."-".$uruncek['urun_id']; ?>"><?php echo $uruncek['urun_ad']; ?></a></span>
						<span class="smalldesc"><?php echo "Ürün Kodu:"." ".$uruncek['urun_keyword']; ?></span>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>



<div class="container">
	<div class="row">
		<div class="col-md-9"><!--Main content-->
			<div class="title-bg">
				<div class="title">Neden Biz</div>
			</div>
			<p class="ct">
				<?php echo substr($hakkimizdacek['hakkimizda_icerik'],0,1100);  ?>
			</p>
			<p class="ct">

			</p>
			<a href="hakkimizda.php" class="btn btn-default btn-yellow">Daha Fazlası</a>

			<div class="title-bg">
				<div class="title">Yeni Eklenenler</div>
			</div>
			<div class="row prdct"><!--Products-->
				<?php while ($uruncek2=$urunsor2->fetch(PDO::FETCH_ASSOC)){ ?>
					<?php $urunfotosor2=$db->prepare("SELECT * FROM urunfoto where urun_id=:id order by urunfoto_sira ASC limit 1");
					$urunfotosor2->execute(array(
						'id' => $uruncek2['urun_id']

					));
					$urunfotocek2=$urunfotosor2->fetch(PDO::FETCH_ASSOC);
					?>
					<div class="col-md-4">
						<div class="productwrap">
							<div class="pr-img">
								<a href="<?php echo"urun-".seo($uruncek2['urun_ad'])."-".$uruncek2['urun_id']; ?>"><img src="<?php echo $urunfotocek2['urunfoto_yol'] ?>" alt="" class="img-responsive"></a>
								<div class="pricetag on-sale"><div class="inner"><span class="onsale"><span class="oldprice"><?php echo $uruncek2['urun_fakefiyat']."₺" ?></span><?php echo $uruncek2['urun_fiyat']."₺" ?></span></div></div>
							</div>
							<span class="smalltitle"><a href="<?php echo"urun-".seo($uruncek2['urun_ad'])."-".$uruncek2['urun_id']; ?>"><?php echo $uruncek2['urun_ad']; ?></a></span>
							<span class="smalldesc"><?php echo "Ürün Kodu:"." ".$uruncek2['urun_keyword']; ?></span>
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

<?php include 'footer.php' ?>