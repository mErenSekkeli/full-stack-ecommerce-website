<?php include 'header.php';

$sayfada = 21; // sayfada gösterilecek içerik miktarını belirtiyoruz.
$sorgu=$db->prepare("SELECT * FROM kategori");
$sorgu->execute();
$toplam_icerik=$sorgu->rowCount();
$toplam_sayfa = ceil($toplam_icerik / $sayfada);
                  	// eğer sayfa girilmemişse 1 varsayalım.
$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
          			// eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
if($sayfa < 1) $sayfa = 1; 
        				// toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 
$limit = ($sayfa - 1) * $sayfada;




?>		
<?php 
$kategorisor=$db-> prepare("SELECT * from kategori where kategori_seourl=:seourl");
$kategorisor->execute(array(
	'seourl'=>$_GET['sef']
));
$kategoricek=$kategorisor->fetch(PDO::FETCH_ASSOC);
$kategori_id=$kategoricek['kategori_id'];

if (isset($_GET['sef'])) {
	$urunsor=$db->prepare("SELECT * FROM urun where kategori_id=:kategori_id and urun_durum=:durum order by urun_zaman DESC");
	$urunsor->execute(array(
		'kategori_id'=> $kategori_id,
		'durum'=>1
	)); ?>
<title><?php echo $kategoricek['kategori_ad']; ?></title> <?php  
}else{
	$urunsor=$db->prepare("SELECT * FROM urun where urun_durum=:durum order by urun_zaman DESC limit $limit,$sayfada");
	$urunsor->execute(array(
		'durum'=>1
	)); ?>
	<title>Tüm Ürünler</title> <?php
}
?>

<div class="container">
	<div class="row">	
		<div class="row">
			<div class="col-md-9"><!--Main content-->
				<div class="title-bg">
					<div class="title"><?php if(!empty($kategoricek['kategori_ad'])){echo $kategoricek['kategori_ad'];}else{echo "Tüm Ürünler";} ?></div>
				</div>
				<?php $say=$urunsor->rowcount();
				if ($say==0) { ?>
					<br><br>
					<h3> Ürün Bulunamadı...</h3>
					<a href="index.php"><img width="250" src="dimg/sadcat.png"></a>
				<?php	} ?>
				<div class="row prdct"><!--Products-->
					<?php while ($uruncek=$urunsor->fetch(PDO::FETCH_ASSOC)){ ?>
						<?php $urunfotosor=$db->prepare("SELECT * FROM urunfoto where urun_id=:id order by urunfoto_sira ASC limit 1");
						$urunfotosor->execute(array(
							'id' => $uruncek['urun_id']

						));
						$urunfotocek=$urunfotosor->fetch(PDO::FETCH_ASSOC);
						?>
						<div class="col-md-4">
							<div class="productwrap">
								<div class="pr-img">
									<div class="hot"></div>
									<a href="<?php echo"urun-".seo($uruncek['urun_ad'])."-".$uruncek['urun_id']; ?>"><img width="250" src="<?php echo $urunfotocek['urunfoto_yol'] ?>" alt="" class="img-responsive"></a>
									<div style="width: 75px; height:75px; " class="pricetag on-sale"><div class="inner on-sale"><span class="onsale"><span class="oldprice"><?php echo $uruncek['urun_fakefiyat']."TL" ?></span><?php echo $uruncek['urun_fiyat']."TL" ?></span></div></div>
								</div>
								<span class="smalltitle"><a href="<?php echo"urun-".seo($uruncek['urun_ad'])."-".$uruncek['urun_id']; ?>"><?php echo $uruncek['urun_ad']; ?></a></span>
								<span class="smalldesc"><?php echo "Ürün Kodu:"." ".$uruncek['urun_keyword']; ?></span><br>
								<span style="<?php if($uruncek['urun_fakestok']<5){?> color:red; <?php }elseif ($uruncek['urun_fakestok']<10) { ?> color:orange;
								<?php } ?>" class="smalldesc"><?php 
								if($uruncek['urun_stok']==0){
									echo "Stok Durumu:"." "."0";
								}else{
									echo "Stok Durumu: "." ".$uruncek['urun_fakestok']; } ?></span>
								</div>
							</div>
						<?php } ?>
					</div><!--Products-->
			<div align="right" class="col-md-12">
                     		<ul class="pagination">

                     			<?php

                     			$s=0;

                     			while ($s < $toplam_sayfa) {

                     				$s++; ?>

                     				<?php 

                     				if ($s==$sayfa) {?>

                     				<li class="active">

                     					<?php if (isset($_GET['sef'])) { ?>
                                                        <a href="kategori-<?php echo $_GET['sef']; ?>&sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>
                                                <?php }else{ ?>
                                                 <a href="kategoriler?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>
                                               <?php } ?>

                     				</li>

                     				<?php } else {?>


                     				<li>

                     					<?php if (isset($_GET['sef'])) { ?>
                                                        <a href="kategori-<?php echo $_GET['sef']; ?>&sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>
                                                <?php }else{ ?>
                                                 <a href="kategoriler?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>
                                               <?php } ?>

                     				</li>

                     				<?php   }

                     			}

                     			?>

                     		</ul>
                     	</div>

			</div>
			<!--sidebar-->
			
			<?php include 'side-bar.php' ?>
		</div>
	</div>
	<div class="spacer"></div>
</div>
<br><br><br><br><br><br><br><br>
<?php include 'footer.php'; ?>
