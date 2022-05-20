<?php include 'header.php';


if (isset($_POST['arama'])) {
	$aranan=htmlspecialchars($_POST['aranan']);
	$urunsor=$db->prepare("SELECT * FROM urun where urun_durum=:durum and urun_ad LIKE '%$aranan%'");
	$urunsor->execute(array(
		'durum'=>1
	));
}else{
	header("location:index.php?durum=bos");
	exit;
}

?>
<title>Arama Sonuçları</title>				
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
			<!--	<ul class="pagination shop-pag">
					<li><a href="#"><i class="fa fa-caret-left"></i></a></li>
					<li><a href="#">1</a></li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li><a href="#">4</a></li>
					<li><a href="#">5</a></li>
					<li><a href="#"><i class="fa fa-caret-right"></i></a></li>
				</ul> --> <!--pagination--> 
			</div>
			<!--sidebar-->
			
			<?php include 'side-bar.php' ?>
		</div>
	</div>
	<div class="spacer"></div>
</div>
<br><br><br><br><br><br><br><br>
<?php include 'footer.php'; ?>
