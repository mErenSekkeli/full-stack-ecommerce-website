<?php include 'header.php';



$yorumsor=$db->prepare("SELECT * FROM yorum order by yorum_zaman DESC");
  $yorumsor->execute();



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
                      ?><b style="color:green;">Yorum Silindi.</b>                        
                    <?php } elseif ($_GET['sil']=="no") {
                     ?><b style="color:red;">İşlem Başarısız.</b><?php
                    } ?></small>




                    <div class="x_panel">
                  <div class="x_title">
                    <h2>Yorum Listesi <small>Yorumlar</small></h2>
                    <div align="right">
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      
                    </p>
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Yorum Tarihi</th>                          
                          <th>Ürün Linki</th>
                          <th>Kullanıcı Adı</th>
                          <th>Yorum Durumu</th>
                          <th>İşlem</th>
                          <th>İşlem </th>
                        
                        </tr>
                      </thead>
                      <tbody>

                      <?php 

while ($yorumcek=$yorumsor->fetch(PDO::FETCH_ASSOC)) {?>
<?php

$kullanici_id=$yorumcek['kullanici_id'];

$kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_id=:id");
  $kullanicisor->execute(array(
'id'=> $kullanici_id

  ));
  $kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);  ?>
                        <tr>
                          <td><?php echo substr($yorumcek['yorum_zaman'],0,10); ?></td>
                          <td><a target="_blank" href="<?php echo "http://babafiyatlarvip.rf.gd/eticaret/".$yorumcek['yorum_url']; ?>"><?php echo "babafiyatlarvip.rf.gd/eticaret/".$yorumcek['yorum_url']; ?>
                            
                          </a></td>
                          <td><?php echo $kullanicicek['kullanici_ad']." ".$kullanicicek['kullanici_soyad']; ?></td>
                         <td><?php
                          if ($yorumcek['yorum_durum']==1) {?>
                          <button disabled="" class="btn btn-success btn-xs">Aktif</button>
                         <?php }else { ?>
                            <button disabled="" class="btn btn-danger btn-xs">Pasif</button>
                          <?php }  ?></td>
                          <td><center><a href="yorum-duzenle.php?yorum_id=<?php echo $yorumcek['yorum_id']; ?>"><button class="btn btn-primary btn-xs">Detaylar</button></a></center></td>
                          <td><center><a href="../netting/islem.php?yorum_id=<?php echo $yorumcek['yorum_id'] ?>&yorum_sil=ok"><button class="btn btn-danger btn-xs">Sil</button></a></center></td>
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

   