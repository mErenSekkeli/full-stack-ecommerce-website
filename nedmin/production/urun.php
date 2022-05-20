<?php include 'header.php';

$urunsor=$db->prepare("SELECT * FROM urun order by urun_zaman DESC");
  $urunsor->execute();
    
    
 

 ?>
 <head>
  <script src="https://cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>
 </head>

      <!-- page content -->
        <div class="right_col" role="main">
   

                    <h2>Ürün İşlemleri</h2>&nbsp;&nbsp;&nbsp;
                    <small>&nbsp;<?php
                    if (isset($_GET['durum'])) {
                   
                    
                     if ($_GET['durum']=="ok") {
                      ?><b style="color:green;">İşlem Başarılı.</b>                        
                    <?php } elseif ($_GET['durum']=="no") {
                     ?><b style="color:red;">İşlem Başarısız.</b><?php
                    } }?></small>

                   <?php                   
                    if ($_GET['urun_sil']=="ok") {
                      ?><b style="color:green;">Ürün Silindi.</b>                        
                    <?php } elseif ($_GET['urun_sil']=="no") {
                     ?><b style="color:red;">İşlem Başarısız.</b><?php
                    } ?></small>
                   
                   


                    <div class="x_panel">
                  <div class="x_title">
                    <h2>Ürün Listesi <small>Ürünler</small></h2>
                    <br>
                    <div align="right">
                    <button class="btn btn-primary"><a href="urun-ekle.php" style="color:white;">Ekle</a></button>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      
                    </p>
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Sıra No</th>
                          <th>Ürün Adı</th>
                          <th>Ürün Fiyatı</th>
                          <th>Resim İşlemleri</th>
                          <th>Ürün Stoğu</th>
                          <th>Ürün Durum</th>                
                          <th>İşlem</th>
                          <th>İşlem</th>
                        
                        </tr>
                      </thead>
                      <tbody>

                      <?php 
$say=0;
while ( $uruncek=$urunsor->fetch(PDO::FETCH_ASSOC)) { $say++;?>
                      <tr>
                          <td width="20"><?php echo $say; ?></td>
                          <td><?php echo $uruncek['urun_ad']; ?></td>
                          <td><?php echo $uruncek['urun_fiyat']; ?></td>
                           <td><center><a href="urun-galeri.php?urun_id=<?php echo $uruncek['urun_id'] ?>"><button class="btn btn-success btn-xs">Resim İşlemleri</button></a></center></td>
                          <td><?php echo $uruncek['urun_stok']; ?></td>
                          <td> <center><?php
                          if ($uruncek['urun_durum']==1) {?>
                          <button disabled="" class="btn btn-success btn-xs">Aktif</button>
                         <?php }else { ?>
                            <button disabled="" class="btn btn-danger btn-xs">Pasif</button>
                          <?php }  ?> </center></td>
                
                          <!--
                            success -> yeşil buton
                            warning -> turuncu buton
                            danger -> kırmızı buton
                            default -> beyaz buton
                            primary -> mavi buton
                            btn-xs -> butonu küçültür.
                            çıkartır.(Bootstrap4) -->
                          
                          <td><center><a href="urun-duzenle.php?urun_id=<?php echo $uruncek['urun_id'] ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a></center></td>
                          <td><center><a href="../netting/islem.php?urun_id=<?php echo $uruncek['urun_id'] ?>&urun_sil=ok"><button class="btn btn-danger btn-xs">Sil</button></a></center></td>
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
</html>
