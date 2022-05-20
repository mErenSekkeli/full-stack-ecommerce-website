<?php include 'header.php';

$siparissor=$db->prepare("SELECT * FROM siparis order by siparis_zaman DESC");
$siparissor->execute();




?>
<head>
  <script src="https://cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>
</head>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
  </div>



  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">

         <?php
         if (isset($_GET['durum'])) {


           if ($_GET['durum']=="ok") {
            ?><b style="color:green;">İşlem Başarılı.</b>                        
          <?php } elseif ($_GET['durum']=="no") {
           ?><b style="color:red;">İşlem Başarısız.</b><?php
         } }?></small>

         <?php                   
         if ($_GET['sil']=="ok") {
          ?><b style="color:green;">Sipariş Silindi.</b>                        
        <?php } elseif ($_GET['sil']=="no") {
         ?><b style="color:red;">İşlem Başarısız.</b><?php
       } ?></small>




       <div class="x_panel">
        <div class="x_title">
          <h2>Sipariş Listesi <small>Siparişlar</small></h2>
          <div align="right">
            <button class="btn btn-primary"><a href="siparis-ekle.php" style="color:white;">Sipariş Ekle</a></button>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <p class="text-muted font-13 m-b-30">

          </p>
          <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Sipariş Tarihi</th>
                <th>Adı Soyadı</th>
                <th>Sipariş Durumu</th>
                <th>Toplam</th>
                <th>İşlem</th>
                <th>İşlem </th>

              </tr>
            </thead>
            <tbody>

              <?php 

              while ($sipariscek=$siparissor->fetch(PDO::FETCH_ASSOC)) {?>
                <?php 
                $kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_id=:id");
                $kullanicisor->execute(array(
                  'id'=>$sipariscek['kullanici_id']
                ));
                $kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);
                ?>

                <tr>
                  <td><?php echo substr($sipariscek['siparis_zaman'],0,10); ?></td>
                  <td><?php echo $kullanicicek['kullanici_ad']." ".$kullanicicek['kullanici_soyad']; ?></td>
                  <td><form action="../netting/islem.php" method="POST"><input type="hidden" name="siparis_id" value="<?php echo $sipariscek['siparis_id']; ?>"><select onchange="this.form.submit()" id="heard" class="form-control"  value="<?php echo $sipariscek['siparis_durum']; ?>" name="siparisdurumdegistir">              

                    <?php 

                    if ($sipariscek['siparis_durum']==0) {?>

                      <option value="0">Kargo Hazırlandı</option>
                      <option value="1">Kargo Hazırlanıyor</option>
                      <option value="2">Kargo Beklemede</option>
                      <option value="3">Kargo İptal Edildi</option>


                    <?php } elseif($sipariscek['siparis_durum']==1) { ?> 

                      <option value="1">Kargo Hazırlanıyor</option>
                      <option value="0">Kargo Hazırlandı</option>
                      <option value="2">Kargo Beklemede</option>
                      <option value="3">Kargo İptal Edildi</option>   



                    <?php }elseif ($sipariscek['siparis_durum']==2) { ?>
                      <option value="2">Kargo Beklemede</option>
                      <option value="1">Kargo Hazırlanıyor</option>
                      <option value="0">Kargo Hazırlandı</option>
                      <option value="3">Kargo İptal Edildi</option>
                    <?php   }else{ ?>
                      <option value="3">Kargo İptal Edildi</option>
                      <option value="2">Kargo Beklemede</option>
                      <option value="1">Kargo Hazırlanıyor</option>
                      <option value="0">Kargo Hazırlandı</option>

                    <?php } ?>

                  </select></form> </td>
                  <td><?php echo $sipariscek['siparis_toplam']." "."₺"; ?></td>
                  <td><center><a href="siparis-detay.php?siparis_id=<?php echo $sipariscek['siparis_id'] ?>"><button class="btn btn-primary btn-xs">Detaylar</button></a></center></td>
                  <td><center><a href="../netting/islem.php?siparis_id=<?php echo $sipariscek['siparis_id'] ?>&siparis_sil=ok"><button class="btn btn-danger btn-xs">Sil</button></a></center></td>
                </tr>

              <?php } ?>


            </tbody>  
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</div>





<div class="col-md-12 col-sm-12 col-xs-12">


</div></div>


<!-- /page content -->

<!-- footer content -->
<footer>
  <?php include 'footer.php'; ?>
</footer>
<!-- /footer content -->
</div>
</div>

