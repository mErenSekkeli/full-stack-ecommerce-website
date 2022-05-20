<?php include 'header.php';

$kulllanici_id=$kullanicicek['kullanici_id'];

$sepetsor=$db->prepare("SELECT * FROM sepet where kullanici_id=:id");
$sepetsor->execute(array(
	'id'=> $kulllanici_id

));

$toplam2=0; $toplam=0;
?>
<title>Sepet</title>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			
		</div>
	</div>
	<div class="title-bg">
		<div class="title">Alışveriş Sepetim</div>
		</div><?php 
		if ($_GET['sil']=="ok") {
			echo "<span style='color:red;'>Ürün Silindi</span>";
		}

		?>
		<?php if (isset($_GET['stok'])) { ?>
			<script type="text/javascript">alert("Seçtiğiniz Ürün Adedi Ürün Stoğunu Aşıyor. Lütfen Daha Az Adet Girin. ");</script>
		<?php	} ?>
		<div class="table-responsive">
			<table class="table table-bordered chart">
				<thead>
					<tr>
						<th>İşlem</th>
						<th>Resim</th>
						<th>Ürün İsmi</th>
						<th>Ürün Kodu</th>
						<th>Adet</th>
						<th>Renk</th>
						<th>Ara Toplam</th>
						<th>Genel Toplam</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($sepetcek=$sepetsor->fetch(PDO::FETCH_ASSOC)) {
						
						$urun_id=$sepetcek['urun_id'];

						$urunsor=$db-> prepare("SELECT * from urun where urun_id=:urun_id");
						$urunsor->execute(array(
							'urun_id'=>$urun_id
						));
						$uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);
						$fakefiyat=$uruncek['urun_fakefiyat'];
						$fiyat=$uruncek['urun_fiyat'];
						$adet=$sepetcek['urun_adet'];
						$temp=0;
						$temp=bcmul($adet, $fiyat,2);
						$toplam=$temp+$toplam;
						$temp2=0;
						$temp2=bcmul($adet, $fakefiyat,2);
						$toplam2=$temp2+$toplam2;
						?>
						
						<tr>
							<?php $urunfotosor=$db->prepare("SELECT * FROM urunfoto where urun_id=:id order by urunfoto_sira ASC limit 1");
								$urunfotosor->execute(array(
									'id' => $urun_id

								));
								$urunfotocek=$urunfotosor->fetch(PDO::FETCH_ASSOC);
								?>
							<td><form method="POST" action="nedmin/netting/islem.php"><button class="btn btn-danger btn-sm" type="submit" name="sepet_sil">Ürünü Sil</button></td>
								<input type="hidden" name="sepet_id" value="<?php echo $sepetcek['sepet_id']; ?>"></form>
								<td><img src="<?php echo $urunfotocek['urunfoto_yol'] ?>" width="100" alt=""></td>
								<td><?php echo $uruncek['urun_ad']; ?></td>
								<td><?php echo $uruncek['urun_keyword']; ?></td>
								<td><form method="POST" action="nedmin/netting/islem.php"><input min="1" max="5" type="number" name="urun_adet" value="<?php echo $sepetcek['urun_adet']; ?>" class="form-control quantity"><br><button type="submit" class="btn btn-warning btn-sm"  name="adetdegistir"><i class="fa fa-retweet"></i></button><input type="hidden" name="sepet_id" value="<?php echo $sepetcek['sepet_id']; ?>"><input type="hidden" name="urun_id" value="<?php echo $uruncek['urun_id']; ?>"><input type="hidden" name="renk_ad" value="<?php echo $sepetcek['urun_renk']; ?>"></form></td>
								<td><?php echo $sepetcek['urun_renk']; ?></td>
								<td><?php echo bcmul($adet, $fakefiyat, 2)." "."₺"; ?></td>
								<td><?php echo bcmul($adet, $fiyat, 2)." "."₺"; ?></td>
							</tr>
						<?php	} ?>
					</tbody>
				</table>
			</div>
			<br>

			
			<div class="row">
				<div class="col-md-6">
					<?php if ($toplam==0 and $toplam2==0) {
						echo "";
					}else { ?>
						
					<?php } ?>
				</div>
				<?php if ($toplam==0 and $toplam2==0) { ?>
					<p>Sepetiniz Boş...<img src="dimg/sadcat.png" width="200"></p>
				<?php }else{ ?>
					<div class="col-md-3 col-md-offset-3">
						<div class="subtotal-wrap">
							<div class="subtotal">

							</div>

							<a href="kategoriler.php" class="btn btn-default btn-red btn-sm">Alışverişe Devam Et</a>
							<div class="clearfix"></div>
							<a href="odeme.php" class="btn btn-default btn-yellow">Ödemeye Git</a>
						</div>
					<?php } ?>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="spacer"></div>
		</div>
		
		<?php include 'footer.php'; ?>