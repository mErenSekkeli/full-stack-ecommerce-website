<?php include 'header.php';
$kulllanici_id=$kullanicicek['kullanici_id'];

$siparissor=$db->prepare("SELECT * FROM siparis where kullanici_id=:id");
$siparissor->execute(array(
	'id'=> $kulllanici_id

));



?>
<title>Siparişlerim</title>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-title-wrap">
				<div class="page-title-inner">
					<div class="row">
						<div class="col-md-5">
							<div class="bigtitle"><?php if (isset($_GET['ekle'])) { ?>
								<p style="color:#FF8C00">Tebrikler!</p>
								<p>Siparişin Alındı</p>

								<?php	}else{echo "Siparişlerim";} ?></div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<?php if (isset($_GET['ekle'])) { ?>
			<div id="myTabContent" class="tab-content shop-tab-ct">
				<div style="font-weight: bold;" style="color:#006400" ><div style="color:#006400">Kargonu Heyecanla Beklediğini Biliyoruz. Siparişin En Kısa Sürede Sana Ulaşması İçin Elimizden Geleni Yapacağımıza Emin Olabilirsin.</div></div>

			</div><br>
		<?php	} ?>

		<div id="title-bg">
			
		</div>
		
		<div class="table-responsive">
			<table class="table table-bordered chart">
				<thead>
					<tr>
						<th>Sipariş NO</th>
						<th>Sipariş Tarihi</th>
						<th>Resim</th>
						<th>Durum</th>
						<th>Toplam</th>
						<th>Detaylar</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($sipariscek=$siparissor->fetch(PDO::FETCH_ASSOC)) { ?>
						<?php 
						$siparis_id=$sipariscek['siparis_id'];
						$siparisdetaysor=$db->prepare("SELECT * FROM siparisdetay where siparis_id=:siparis_id");
						$siparisdetaysor->execute(array(
							'siparis_id'=> $siparis_id

						));
						$siparisdetaycek=$siparisdetaysor->fetch(PDO::FETCH_ASSOC);

						$urun_id=$siparisdetaycek['urun_id'];

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
							<td><br><br><?php echo $sipariscek['siparis_id']; ?></td>
							<td><br><br><?php echo substr($sipariscek['siparis_zaman'],0,10); ?></td>
							<td><a  href="<?php echo "urun-".$uruncek['urun_seourl']."-".$uruncek['urun_id']; ?>"><img src="<?php echo $urunfotocek['urunfoto_yol'] ?>"width="100"></a></td>
							<td><br><br><?php if ($sipariscek['siparis_durum']==1) { ?>
								<span style="color:#228B22; font-weight: bold;">Siparişiniz Hazırlanıyor</span>
							<?php	}elseif ($sipariscek['siparis_durum']==0) { ?>
								<span style="color:#1E90FF; font-weight: bold;">Siparişiniz Kargoya Verildi</span>
							<?php } elseif ($sipariscek['siparis_durum']==2) { ?>
								<span style="color:#FF8C00; font-weight: bold;">Siparişiniz Şu Anda Beklemede</span>
							<?php	}elseif ($sipariscek['siparis_durum']==3) { ?>
								<span style="color:#FF0000; font-weight: bold;">Siparişiniz İptal Edildi</span>
								<?php	} ?></td>
								<td><br><br><?php echo $sipariscek['siparis_toplam']." "."₺"; ?></td>
								<td><br><br><a href="siparis-detay.php?siparis_no=<?php echo $sipariscek['siparis_id']; ?>"><button class="btn btn-default btn-yellow">Detaylar</button></a></td>
							</tr>
						<?php	} ?>
					</tbody>
				</table>
			</div>
			<div class="spacer"></div>
		</div>
		<br><br><br><br>
		<?php include 'footer.php'; ?>