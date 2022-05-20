<?php include 'header.php';

$kullanici_id2=$kullanicicek['kullanici_id'];

$sepetsor6=$db->prepare("SELECT * FROM sepet where kullanici_id=:id");
$sepetsor6->execute(array(
	'id'=> $kullanici_id2

));
$sepetcek6=$sepetsor6->fetch(PDO::FETCH_ASSOC);

if (empty($sepetcek6)) {
	header("location:sepet.php");
	exit;
}	

$kullanici_id=$kullanicicek['kullanici_id'];

$sepetsor=$db->prepare("SELECT * FROM sepet where kullanici_id=:id");
$sepetsor->execute(array(
	'id'=> $kullanici_id

));

$entegresor=$db->prepare("SELECT * FROM entegre where entegre_id=:id");
$entegresor->execute(array(
	'id'=>1
));
$entegrecek=$entegresor->fetch(PDO::FETCH_ASSOC);

$toplam2=0; $toplam=0;
?>
<title>Ödeme</title>
<div class="container">
	<div class="row">
		<div class="col-md-12">

		</div>
	</div>
	<div class="title-bg">
		<div class="title">Ödeme İşlemleri</div>
		</div><?php 
		if ($_GET['sil']=="ok") {
			echo "<span style='color:red;'>Ürün Silindi</span>";
		}

		?>
		<?php
		if (empty($_GET['kupon_ad'])) {
			echo "";
		}elseif ($_GET['kupon_ad']=="no") { ?>
			<script type="text/javascript">alert("Kupon Geçersiz Veya Tükendi");</script>
		<?php	}elseif($_GET['kupon_ad']!="no"){ ?>
			<span style="color:green;">Kupon Eklendi</span>
		<?php	} ?>
		<?php 
		if ($_GET['durum']=="no") { ?>
			<script type="text/javascript">alert("Lütfen Sizden İstenen Bilgileri Doldurun");</script>
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
							<td><a href="sepet.php"><button class="btn btn-danger btn-sm">Sepete Git</button></a></td>

							<td><img src="<?php echo $urunfotocek['urunfoto_yol'] ?>" width="100" alt=""></td>
							<td><?php echo $uruncek['urun_ad']; ?></td>
							<td><?php echo $uruncek['urun_keyword']; ?></td>
							<td><button class="btn btn-success btn-m"><?php echo $sepetcek['urun_adet']; ?></button></td>
							<td><?php echo $sepetcek['urun_renk'] ?></td>
							<td><?php echo bcmul($adet, $fakefiyat, 2)." "."₺"; ?></td>
							<td><?php echo bcmul($adet, $fiyat, 2)." "."₺"; ?></td>
							<form class="form-horizontal coupon" method="POST" action="nedmin/netting/islem.php" role="form">
								<input type="hidden" name="sepet_id" value="<?php echo $sepetcek['sepet_id']; ?>">
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

						
						<div class="form-group">
							<label for="coupon" class="col-sm-3 control-label">Kupon Kodu:</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" name="kupon_keyword" placeholder="Kupon">
							</div>
							<div class="col-sm-2">
								<button type="submit"  name="kuponinsert" class="btn btn-default btn-red btn-sm">Kuponu Gir</button>
							</div>
						</div>

					<?php } ?>

				</div><br><br><br>
				<div class="form-group">
					<label class="control-label col-md-1 col-sm-3 col-xs-12" for="first-name">Adresim:
					</label>
					<div class="col-md-8 col-sm-6 col-xs-12">
						<textarea style="width:500px;" name="kullanici_adres" required="required" ><?php echo $kullanicicek['kullanici_adres']; ?></textarea>&nbsp;&nbsp;
						<button class="btn btn-primary" style="vertical-align: top;" name="adresdegistir2" type="submit">Değiştir</button> 
					</div>
				</div><br><br><br>
				<div class="form-group">
					<label class="control-label col-md-1 col-sm-3 col-xs-12" for="first-name">Açıklama:
					</label>
					<div class="col-md-8 col-sm-6 col-xs-12">
						<textarea style="width:500px; height: 100px;" placeholder="Siparişiniz için açıklama girebilirsiniz." name="siparis_aciklama"  ></textarea>&nbsp;&nbsp;
						
					</div>
				</div><br><br><br><br><br>
				<div class="tab-review">
					<ul id="myTab" class="nav nav-tabs shop-tab">
						<li class="active"><a href="#desc" data-toggle="tab">Kapıda Ödeme</a></li>
						<li class=""><a href="#rev" data-toggle="tab">Kredi kartı İle Ödeme</a></li>
						<li class=""><a href="#sav" data-toggle="tab">Havale İle Ödeme</a></li>
					</ul>
					<div id="myTabContent" class="tab-content shop-tab-ct">
						<div class="tab-pane fade active in" id="desc">
							<?php if ($entegrecek['entegre_kapida']==0) { ?>
								<h4 style="text-align: center;">Kapıda Ödeme Entegrasyonu Şu Anda Aktif Değildir. <br><br> Lütfen Diğer Ödeme Yöntemlerini Kullanın.</h4>
							<?php	}else{ ?>
								<p ><span style="font-weight: bold; font-size: 13px; color:#DC143C">Önemli Not: </span><span style="font-size: 13px; color:#696969">Kapıda ödeme metodlarında eğer verdiğiniz adrese özel bir durumunuz varsa açıklamaya belirtiniz. <br>-Hangi kargoyu kullanmak istiyorsanız onu seçerek ödemeyi tamamlayın.</span></p>
								
								<?php 
								$kargosor=$db->prepare("SELECT * FROM kargo where kargo_durum=:durum");
								$kargosor->execute(array(
									'durum'=>1
								));
								?><div style="color:#228B22; font-weight: bold; font-size: 20px;">-Kargo Tipi-</div>
								<?php  while($kargocek=$kargosor->fetch(PDO::FETCH_ASSOC)){ ?>
									<p class="dash">
										<input type="radio" id="res" class="form-check-input" name="kargo_id" value="<?php echo $kargocek['kargo_id']; ?>">&nbsp;&nbsp; <span style="font-weight: bold; font-size: 20px;">Kargo Adı: <span style="color:#FF8C00"><?php echo $kargocek['kargo_ad']; ?></span></span><br><br>
										<span style="font-weight: bold; font-size: 20px;">Kargo Fiyatı: <span style="color:#FF8C00"><?php echo $kargocek['kargo_fiyat']." "."₺"; ?></span></span><br><br>
										
									</p>
								<?php	} ?>

								<div class="subtotal" style="text-align: center;">
									<p>İndirim Tutarı: <?php echo $toplam2-$toplam." "."₺"; ?></p>
									<p>Kupon İndirimi : <?php
									$kuponsor=$db->prepare("SELECT * FROM kupon");
									$kuponsor->execute();
									$keyword=$_POST['kupon_keyword'];
									$say5=0;
									while($kuponcek=$kuponsor->fetch(PDO::FETCH_ASSOC)){
										if ($_GET['kupon_ad']==$kuponcek['kupon_keyword']) { $say5++;
											echo $kupon_indirim=$kuponcek["kupon_fiyat"]." "."₺";
										}
									} ?> <?php if ($say5==0) {
										echo "0 ₺";
									} ?></p>

								</div>

								<div class="total" style="text-align: center;">Toplam : <span class="bigprice"><?php echo $toplam-$kupon_indirim." "."₺"." "."+"." "."Kargo Fiyatı"; ?></span></div>
								<div class="clearfix"></div>
								<input type="hidden" name="kullanici_id" value="<?php echo $kullanicicek['kullanici_id']; ?>"><br>
								<input type="hidden" name="siparis_toplam" value="<?php echo $toplam-$kupon_indirim; ?>">
								<input type="hidden" name="kupon_indirim" value="<?php echo $say5 ?>">
								<input type="hidden" name="kupon_ozel" value="<?php echo $kupon_ad ?>">
								<div style="text-align: center;"><button  type="submit" class="btn btn-default btn-yellow" name="kapidasipariskaydet">Sipariş Ver</button></div>
							<?php	} ?>
						</div>
						<div class="tab-pane fade" id="rev">							
							<h4 style="text-align: center;">Kredi Kartı Entegrasyonu En Kısa Sürede Yapılacaktır. <br><br> Lütfen Diğer Ödeme Yöntemlerini Kullanın.</h4>

						</div>
						<div class="tab-pane fade" id="sav">
							<?php if ($entegrecek['entegre_havale']==0) { ?>
								<h4 style="text-align: center;">Havale İşlemi Entegrasyonu Şu Anda Aktif Değildir. <br><br> Lütfen Diğer Ödeme Yöntemlerini Kullanın.</h4>
							<?php	}else{ ?>


								<p ><span style="font-weight: bold; font-size: 13px; color:#DC143C">Önemli Not: </span><span style="font-size: 13px; color:#696969">Havale ile ödeme metodlarında kargonuzda gecikmeler yaşanabilir. Bunu sebebi gönderilen ürün tutarının tarafımıza ulaşma süresinden kaynaklıdır. <br>-Hangi bankayı ve kargoyu kullanmak istiyorsanız onu seçerek ödemeyi tamamlayın.</span></p>
								<div style="color:#228B22; font-weight: bold; font-size: 20px;">-Banka Tipi-</div>
								<?php 
								$bankasor=$db->prepare("SELECT * FROM banka where banka_durum=:durum");
								$bankasor->execute(array(
									'durum'=>1
								));
								while($bankacek=$bankasor->fetch(PDO::FETCH_ASSOC)){ ?>

									<p class="dash">
										<input type="radio" id="res" class="form-check-input" name="banka_id" value="<?php echo $bankacek['banka_id']; ?>">&nbsp;&nbsp; <span style="font-weight: bold; font-size: 20px;">Banka Adı: <span style="color:#FF8C00"><?php echo $bankacek['banka_ad']; ?></span></span><br><br>
										<span style="font-weight: bold; font-size: 20px;">Hesap Adı Ve Soyadı: <span style="color:#FF8C00"><?php echo $bankacek['banka_adsoyad']; ?></span></span><br><br>
										<span style="font-size: 20px;">İban NO: <span style="color:#FF8C00"><?php echo $bankacek['banka_iban']; ?></span></span>
									</p><br>
									<?php	} ?><div style="color:#228B22; font-weight: bold; font-size: 20px;">-Kargo Tipi-</div>
									<?php 
									$kargosor2=$db->prepare("SELECT * FROM kargo where kargo_durum=:durum");
									$kargosor2->execute(array(
										'durum'=>1
									));
									?>
									<?php  while($kargocek2=$kargosor2->fetch(PDO::FETCH_ASSOC)){ ?>
										<p class="dash">
											<input type="radio" id="res" class="form-check-input" name="kargo_id" value="<?php echo $kargocek2['kargo_id']; ?>">&nbsp;&nbsp; <span style="font-weight: bold; font-size: 20px;">Kargo Adı: <span style="color:#FF8C00"><?php echo $kargocek2['kargo_ad']; ?></span></span><br><br>
											<span style="font-weight: bold; font-size: 20px;">Kargo Fiyatı: <span style="color:#FF8C00"><?php echo "0.00"." "."₺"; ?></span></span><br><br>

										</p>
									<?php	} ?>

									<div class="subtotal" style="text-align: center;">
										<p>İndirim Tutarı: <?php echo $toplam2-$toplam." "."₺"; ?></p>
										<p>Kupon İndirimi : <?php
										$kuponsor=$db->prepare("SELECT * FROM kupon");
										$kuponsor->execute();
										$keyword=$_POST['kupon_keyword'];
										$say5=0;
										while($kuponcek=$kuponsor->fetch(PDO::FETCH_ASSOC)){
											if ($_GET['kupon_ad']==$kuponcek['kupon_keyword']) { $say5++;
												echo $kupon_indirim=$kuponcek["kupon_fiyat"]." "."₺";
												$kupon_ad=$_GET['kupon_ad'];
											}
										} ?> <?php if ($say5==0) {
											echo "0 ₺";
										} ?></p>

									</div>

									<div class="total" style="text-align: center;">Toplam : <span class="bigprice"><?php echo $toplam-$kupon_indirim." "."₺"; ?></span></div>

									<div class="clearfix"></div>
									<input type="hidden" name="kullanici_id" value="<?php echo $kullanicicek['kullanici_id']; ?>"><br>
									<input type="hidden" name="siparis_toplam" value="<?php echo $toplam-$kupon_indirim; ?>">
									<input type="hidden" name="kupon_indirim" value="<?php echo $say5 ?>">
									<input type="hidden" name="kupon_ozel" value="<?php echo $kupon_ad ?>">
									<div style="text-align: center;"><button type="submit" class="btn btn-default btn-yellow" name="havalesipariskaydet">Sipariş Ver</button></div>
								<?php	} ?>
							</div>
						</div>
					</div>
				</form>

				<div class="clearfix"></div>
			</div>
		</div>
		<div class="spacer"></div>
	</div>

	<?php include 'footer.php'; ?>