<?php include 'header.php';

$kuponsor=$db->prepare("SELECT * FROM kupon order by kupon_zaman DESC");
  $kuponsor->execute();
    
    
 

 ?>
 <head>
  <script src="https://cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>
 </head>

      <!-- page content -->
        <div class="right_col" role="main">
   

                    <h2>Kupon İşlemleri</h2>&nbsp;&nbsp;&nbsp;
                    <small>&nbsp;<?php
                    if (isset($_GET['durum'])) {
                   
                    
                     if ($_GET['durum']=="ok") {
                      ?><b style="color:green;">İşlem Başarılı.</b>                        
                    <?php } elseif ($_GET['durum']=="no") {
                     ?><b style="color:red;">İşlem Başarısız.</b><?php
                    } }?></small>

                   <?php                   
                    if ($_GET['menu_sil']=="ok") {
                      ?><b style="color:green;">Kupon Silindi.</b>                        
                    <?php } elseif ($_GET['menu_sil']=="no") {
                     ?><b style="color:red;">İşlem Başarısız.</b><?php
                    } ?></small>
                   
                   


                    <div class="x_panel">
                  <div class="x_title">
                    <h2>Kupon Listesi <small>Kuponlar</small></h2>
                    <br>
                    <div align="right">
                    <button class="btn btn-primary"><a href="kupon-ekle.php" style="color:white;">Ekle</a></button>
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
                          <th>Kupon Adı</th>
                          <th>Kupon Anahtarı</th>
                          <th>Kupon Adedi</th>
                          <th>Kupon İndirimi</th>
                          <th>Kupon Durum</th>
                          <th>İşlem</th>
                          <th>İşlem</th>
                        
                        </tr>
                      </thead>
                      <tbody>

                      <?php 
$say=0;
while ( $kuponcek=$kuponsor->fetch(PDO::FETCH_ASSOC)) { $say++;?>
  

                        <tr>
                          <td width="20"><?php echo $say; ?></td>
                          <td><?php echo $kuponcek['kupon_ad'] ?></td>
                          <td><?php echo $kuponcek['kupon_keyword'] ?></td>
                          <td><?php echo $kuponcek['kupon_adet']; ?></td>
                          <td><?php echo $kuponcek['kupon_fiyat']." "."₺"; ?></td>
                          <td><?php
                          if ($kuponcek['kupon_durum']==1) {?>
                          <button disabled="" class="btn btn-success btn-xs">Aktif</button>
                         <?php }else { ?>
                            <button disabled="" class="btn btn-danger btn-xs">Pasif</button>
                          <?php }  ?></td>
                          <!--
                            success -> yeşil buton
                            warning -> turuncu buton
                            danger -> kırmızı buton
                            default -> beyaz buton
                            primary -> mavi buton
                            btn-xs -> butonu küçültür.
                            çıkartır.(Bootstrap4) -->
                          
                          <td><center><a href="kupon-duzenle.php?kupon_id=<?php echo $kuponcek['kupon_id'] ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a></center></td>
                          <td><center><a href="../netting/islem.php?kupon_id=<?php echo $kuponcek['kupon_id'] ?>&kupon_sil=ok"><button class="btn btn-danger btn-xs">Sil</button></a></center></td>
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
