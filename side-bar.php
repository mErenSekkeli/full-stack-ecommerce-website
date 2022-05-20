<?php 
$kategorisor=$db->prepare("SELECT * FROM kategori order by kategori_sira");
$kategorisor->execute();

$urunsor=$db-> prepare("SELECT * from urun where urun_durum=:durum and urun_star=:urun_star order by urun_zaman DESC limit 4");
$urunsor->execute(array(
	'durum'=>1,
	'urun_star'=>1
));
?>
<div class="col-md-3"><!--sidebar-->
	<div class="title-bg">
		<div class="title">Kategoriler</div>
	</div>
	
	<div class="categorybox">
		<ul>
			<?php while($kategoricek=$kategorisor->fetch(PDO::FETCH_ASSOC)){ ?>		<li><a href="<?php echo"kategori-".seo($kategoricek['kategori_ad']); ?>"> <img width="35" src="dimg/<?php echo $kategoricek['kategori_icon'] ?>"><?php echo $kategoricek['kategori_ad'] ?></a></li>
		<?php } ?>	

	</ul>
</div>

<div class="title-bg">
	<div class="title">Reklam Köşesi</div>
</div>

	<!-- Reklam Yeri -->
	<a href="https://www.babafiyatlar.com" target="_blank"><img width="213" src="dimg/reklam2.jpg"></a>


<div class="title-bg">
	<div class="title">En İyiler</div>
</div>
<div class="best-seller">
	<ul>
		<?php while ($uruncek=$urunsor->fetch(PDO::FETCH_ASSOC)){ ?>
			<?php $urunfotosor=$db->prepare("SELECT * FROM urunfoto where urun_id=:id order by urunfoto_sira ASC limit 1");
			$urunfotosor->execute(array(
				'id' => $uruncek['urun_id']

			));
			$urunfotocek=$urunfotosor->fetch(PDO::FETCH_ASSOC);
			?>
			<li class="clearfix">
				<a href="<?php echo "urun-".$uruncek['urun_seourl']."-".$uruncek['urun_id']; ?>"><img style="width: 40px; height: 60px;" src="<?php echo $urunfotocek['urunfoto_yol']; ?>" alt="" class="img-responsive mini"></a><br>
				<div class="mini-meta">
					
					<p class="smallprice"><a href="<?php echo "urun-".$uruncek['urun_seourl']."-".$uruncek['urun_id']; ?>"><?php echo " Fiyat :"." ".$uruncek['urun_fiyat']."₺"; ?></a></p>
				</div>
			</li>
		<?php } ?>
	</ul>
</div>

</div>