<div class="f-widget"><!--footer Widget-->
		<div class="container">
			<div class="row">
				<div class="col-md-4"><!--footer twitter widget-->
					<div class="title-widget-bg">
						<div class="title-widget">İnstagram Postları</div>
					</div>
					<ul class="tweets">
						<li><a target="_blank" href="https://www.instagram.com/p/CKMC59oFxEj/"> <img style="width:200px; height:200px" class="FFVAD" decoding="auto" style="object-fit: cover;" sizes="598px" src="https://instagram.fist7-1.fna.fbcdn.net/v/t51.2885-15/sh0.08/e35/s750x750/139522473_812554575967087_7176018771714447699_n.jpg?_nc_ht=instagram.fist7-1.fna.fbcdn.net&_nc_cat=107&_nc_ohc=NmW1i-N2JFQAX9tkHLj&tp=1&oh=e1c3428bff35cc6efe8c4db7788f540d&oe=6037CB77"> </a>
						<span>2 hours ago</span></li></ul>

						
					
					
				</div><!--footer twitter widget-->
				<div class="col-md-4"><!--footer newsletter widget-->
					<div class="title-widget-bg">
						
					</div>
					<div class="newsletter">
					<ul class="tweets">
						<li><a target="_blank" href="https://www.instagram.com/p/CKWEDTHFRxs/"> <img style="width:200px; height:200px" class="FFVAD" decoding="auto" style="object-fit: cover;" sizes="598px" src="https://instagram.fist7-1.fna.fbcdn.net/v/t51.2885-15/sh0.08/e35/s640x640/140371555_435080727684359_1260798790409023934_n.jpg?_nc_ht=instagram.fist7-1.fna.fbcdn.net&_nc_cat=111&_nc_ohc=n6GFgA4U3WYAX8IX4i3&tp=1&oh=8d3198bc5e73cb292678ed740a7b1d45&oe=603713D9"> </a>
						<span>2 hours ago</span></li>
						
					</div>
					</ul>
				</div><!--footer newsletter widget-->
				<div class="col-md-4"><!--footer contact widget-->
					<div class="title-widget-bg">
						<div class="title-widget-cursive">Babafiyatlar</div>
					</div>
					<ul class="contact-widget">
						<li class="fphone"><?php echo $ayarcek['ayar_tel'] ?> <br><?php echo $ayarcek['ayar_gsm'] ?></li>
						<li class="fmobile"><?php echo $ayarcek['ayar_tel'] ?><br><?php echo $ayarcek['ayar_tel'] ?></li>
						<li class="fmail lastone"><?php echo $ayarcek['ayar_mail'] ?><br><?php echo $ayarcek['ayar_mail2'] ?></li>
					</ul>
				</div><!--footer contact widget-->
			</div>
			<div class="spacer"></div>
		</div>
	</div><!--footer Widget-->
	<div class="footer"><!--footer-->
		<div class="container">
			<div class="row">
				<div class="col-md-9">
					<ul class="footermenu"><!--footer nav-->
						<?php if (isset($_SESSION['checkkullanici_mail'])) { ?>
									<li><a href="index.php">Ana Sayfa</a></li>
									<li><a href="siparislerim.php">Siparişlerim</a></li>
									<li><a href="hesabim.php">Hesabım</a></li>
									<li><a href="kategoriler.php">Tüm Ürünler</a></li>
									<li><a href="hakkimizda.php">Hakkımızda</a></li>
								<?php	}else{ ?>
									<li><a href="index.php">Ana Sayfa</a></li>
									<li><a href="iletisim.php">İletişim</a></li>
									<li><a href="http://babafiyatlarvip.rf.gd/eticaret/sayfa-satis-sozlesmesi">Sözleşme</a></li>
									<li><a href="kategoriler.php">Tüm Ürünler</a></li>
									<li><a href="hakkimizda.php">Hakkımızda</a></li>

									<?php	} ?>
					</ul><!--footer nav-->
					<div class="f-credit">&copy;All rights reserved by <a target="_blank" href="https://babafiyatlar.com">babafiyatlar.com @2021</a></div>
                    <p>Beta Testine Katıldığın Teşekkürler.&nbsp;  (V.1.93)</p>
					<a href=""><div class="payment visa"></div></a>
					<a href=""><div class="payment paypal"></div></a>
					<a href=""><div class="payment mc"></div></a>
					<a href=""><div class="payment nh"></div></a>

				</div>
				<div class="col-md-3"><!--footer Share-->
					<div class="followon">Bizi Takip Et!</div>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
						<a target="_blank" href="<?php echo $ayarcek['ayar_facebook'] ?>"><img src="images/facebook.png"></a>
						<a target="_blank" href="<?php echo $ayarcek['ayar_twitter'] ?>"><img src="images/twitter.png"></a>						
					 	<a target="_blank" href="<?php echo $ayarcek['ayar_instagram'] ?>"><img src="images/instagram.png"></a>									 
						<a target="_blank" href="<?php echo $ayarcek['ayar_youtube'] ?>" ><img src="images/youtube.png"></a>
						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
				</div><!--footer Share-->
			</div>
		</div>
	</div><!--footer-->
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap\js\bootstrap.min.js"></script>
	
	<!-- map -->
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
	<script type="text/javascript" src="js\jquery.ui.map.js"></script>
	<script type="text/javascript" src="js\demo.js"></script>
	
	<!-- owl carousel -->
    <script src="js\owl.carousel.min.js"></script>
	
	<!-- rating -->
	<script src="js\rate\jquery.raty.js"></script>
	<script src="js\labs.js" type="text/javascript"></script>
	
	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="js\product\lib\jquery.mousewheel-3.0.6.pack.js"></script>
	
	<!-- fancybox -->
    <script type="text/javascript" src="js\product\jquery.fancybox.js?v=2.1.5"></script>
	
	<!-- custom js -->
    <script src="js\shop.js"></script>
	</div>
  </body>
</html>
