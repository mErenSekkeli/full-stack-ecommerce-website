<?php include 'header.php';

$kullanicisor=$db->prepare("SELECT * FROM kullanici order by kullanici_zaman DESC");
  $kullanicisor->execute();
    
    
 

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
                      ?><b style="color:green;">Kullanıcı Silindi.</b>                        
                    <?php } elseif ($_GET['sil']=="no") {
                     ?><b style="color:red;">İşlem Başarısız.</b><?php
                    } ?></small>




                    <div class="x_panel">
                  <div class="x_title">
                    <h2>Kullanıcı Listesi <small>Kullanıcılar</small></h2>
                    <div align="right">
                    <button class="btn btn-primary"><a href="kullanici-ekle.php" style="color:white;">Kullanıcı Ekle</a></button>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      
                    </p>
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Kayıt Tarihi</th>
                          <th>Ad-Soyad</th>
                          <th>Mail Adresi</th>
                          <th>Telefon</th>
                          <th>İşlem</th>
                          <th>İşlem </th>
                        
                        </tr>
                      </thead>
                      <tbody>

                      <?php 

while ( $kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC)) {?>
  



                  


                        <tr>
                          <td><?php echo $kullanicicek['kullanici_zaman'] ?></td>
                          <td><?php echo $kullanicicek['kullanici_ad']." ".$kullanicicek['kullanici_soyad']; ?></td>
                          <td><?php echo $kullanicicek['kullanici_mail']; ?></td>
                          <td><?php echo $kullanicicek['kullanici_gsm']; ?></td>
                          <td><center><a href="kullanici-duzenle.php?kullanici_id=<?php echo $kullanicicek['kullanici_id'] ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a></center></td>
                          <td><center><a href="../netting/islem.php?kullanici_id=<?php echo $kullanicicek['kullanici_id'] ?>&kullanici_sil=ok"><button class="btn btn-danger btn-xs">Sil</button></a></center></td>
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

   