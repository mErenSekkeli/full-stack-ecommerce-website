<?php include 'header.php';
$kulllanici_id=$kullanicicek['kullanici_id'];

$siparissor=$db->prepare("SELECT * FROM siparis where kullanici_id=:id and siparis_id=:siparis_id");
$siparissor->execute(array(
	'id'=> $kulllanici_id,
	'siparis_id'=>$_GET['siparis_no']

));

$siparissor2=$db->prepare("SELECT * FROM siparis where kullanici_id=:id and siparis_id=:siparis_id");
$siparissor2->execute(array(
	'id'=> $kulllanici_id,
	'siparis_id'=>$_GET['siparis_no']
));

$siparissor3=$db->prepare("SELECT * FROM siparis where kullanici_id=:id and siparis_id=:siparis_id");
$siparissor3->execute(array(
	'id'=> $kulllanici_id,
	'siparis_id'=>$_GET['siparis_no']
));
$fiyatsorgu1=0;
$fiyatsorgu2=0;
?>
<title>Sipariş Detayı</title>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-title-wrap">
				<div class="page-title-inner">
					<div class="row">
						<div class="col-md-5">
							<div class="bigtitle">
								Sipariş Detayları
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="table-responsive">
		<table class="table table-bordered chart">
			<thead>
				<tr>
					<th>Ürün Adı</th>
					<th>Resim</th>
					<th>Model</th>
					<th>Adet</th>
					<th>Renk</th>
					<th>Ürün Fiyatı</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($sipariscek=$siparissor->fetch(PDO::FETCH_ASSOC)) { ?>
					<?php 
					$siparis_id=$_GET['siparis_no'];
					$siparisdetaysor=$db->prepare("SELECT * FROM siparisdetay where siparis_id=:siparis_id");
					$siparisdetaysor->execute(array(
						'siparis_id'=> $siparis_id

					));
					$siparisdetaycek=$siparisdetaysor->fetch(PDO::FETCH_ASSOC);

					$siparis_id=$_GET['siparis_no'];
					$siparisdetaysor2=$db->prepare("SELECT * FROM siparisdetay where siparis_id=:siparis_id");
					$siparisdetaysor2->execute(array(
						'siparis_id'=> $siparis_id

					));

					

					$kargosor=$db->prepare("SELECT * FROM kargo where kargo_ad=:ad");
					$kargosor->execute(array(
						'ad'=>$sipariscek['siparis_kargo']
					));
					$kargocek=$kargosor->fetch(PDO::FETCH_ASSOC);
					?>
					<?php while ($siparisdetaycek2=$siparisdetaysor2->fetch(PDO::FETCH_ASSOC)) {
						$urun_id=$siparisdetaycek2['urun_id'];

						$urunsor=$db-> prepare("SELECT * from urun where urun_id=:urun_id");
						$urunsor->execute(array(
							'urun_id'=>$urun_id
						));
						$uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);
						?>

						<?php $urunfotosor=$db->prepare("SELECT * FROM urunfoto where urun_id=:id order by urunfoto_sira ASC limit 1");
						$urunfotosor->execute(array(
							'id' => $urun_id

						));
						$urunfotocek=$urunfotosor->fetch(PDO::FETCH_ASSOC);
						?>
						<tr>
							<td><br><br><?php echo $uruncek['urun_ad']; ?></td>
							<td><a  href="<?php echo "urun-".$uruncek['urun_seourl']."-".$uruncek['urun_id']; ?>"><img src="<?php echo $urunfotocek['urunfoto_yol'] ?>"width="100"></a></td>
							<td><br><br><?php echo $uruncek['urun_keyword']; ?></td>
							<td><br><br><?php echo $siparisdetaycek2['urun_adet']; ?></td>
							<td><br><br><?php echo $siparisdetaycek2['urun_renk']; ?></td>
							<td><br><br><?php echo $fiyatsorgu1=$siparisdetaycek2['urun_fiyat']." "."₺"; ?></td>
							
						</tr>
					<?php	} ?>
				<?php	} ?>
			</tbody>
		</table>
	</div>
	<div class="table-responsive">
		<table class="table table-bordered chart">
			<thead>
				<tr>
					<th>Ödeme Tipi</th>
					<th>Adres</th>
					<th>Toplam</th>
					<th>Kupon</th>
					<th>Kargo</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($sipariscek2=$siparissor2->fetch(PDO::FETCH_ASSOC)) { ?>
					<?php 
					$siparis_id=$_GET['siparis_no'];
					$siparisdetaysor2=$db->prepare("SELECT * FROM siparisdetay where siparis_id=:siparis_id");
					$siparisdetaysor2->execute(array(
						'siparis_id'=> $siparis_id

					));
					$siparisdetaycek2=$siparisdetaysor2->fetch(PDO::FETCH_ASSOC);

					$urun_id2=$siparisdetaycek2['urun_id'];

					$urunsor2=$db-> prepare("SELECT * from urun where urun_id=:urun_id");
					$urunsor2->execute(array(
						'urun_id'=>$urun_id2
					));
					$uruncek2=$urunsor2->fetch(PDO::FETCH_ASSOC);
					?>

					<tr>
						<td><br><span style="color:#1E90FF;"><?php echo $sipariscek2['siparis_tip']; ?><br><?php echo $sipariscek2['siparis_banka']; ?></span></td>
						<td><br><?php echo $kullanicicek['kullanici_adres']; ?></td>
						<td><br><?php echo $fiyatsorgu2=$sipariscek2['siparis_toplam']." "."₺"; ?></td>
						<td><br><?php if ($siparisdetaycek2['urun_kupon']==1){ ?>
							<span style="color:#228B22; font-weight: bold;">Kupon Kullanıldı</span>
						<?php }else{ ?>
							<span style="color:#FF8C00; font-weight: bold;">Kupon Kullanılmadı	</span>
							<?php	} ?></td>
							<td><br><?php if ($sipariscek2['siparis_tip']=="Kapıda Ödeme") {
								echo $kargocek['kargo_ad']; ?><br><br><?php echo $kargocek['kargo_fiyat']." "."₺";
							}elseif ($sipariscek2['siparis_tip']=="Banka Havalesi"){
								echo $kargocek['kargo_ad']; ?><br><br><?php echo "0.00"." "."₺";
							}  ?></td>

						</tr>
					<?php	} ?>
				</tbody>
			</table>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered chart">
				<thead>
					<tr>
						<th>Açıklama</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($sipariscek3=$siparissor3->fetch(PDO::FETCH_ASSOC)) { ?>
						

						<tr>

							<td><?php echo $sipariscek3['siparis_aciklama']; ?></td>


						</tr>
					<?php	} ?>
				</tbody>
			</table>
		</div>
		<div class="spacer"></div>
	</div>
	<br><br><br><br>
	<?php include 'footer.php'; ?>