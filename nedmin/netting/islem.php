<?php
ob_start();
session_start();

include 'baglan.php';
include '../production/fonksiyon.php';

if (isset($_POST['admingiris'])) {
// md5-> şifreyi gizli tutar.
  $kullanici_mail=$_POST['kullanici_mail'];
  $kullanici_password=($_POST['kullanici_password']); // md5 şifreyi şifreler :D

  $kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail and kullanici_password=:password and kullanici_yetki=:yetki");
  $kullanicisor->execute(array(
    'mail' => $kullanici_mail,
    'password' => md5($kullanici_password),
    'yetki' => 5
  ));

  echo $say=$kullanicisor->rowCount();

  if ($say==1) {
        // session kullanıcının sitede olup olmadığını kontrol eder.
    $_SESSION['kullanici_mail']=$kullanici_mail;
    $deger=rand(10000, 100000); $deger2=rand(100,500000);
    header("Location:../production/index.php?durum=ok&token=$deger$deger2");
    



  } else {

    header("Location:../production/login.php?durum=no");
    exit;
  }
  

}

if (isset($_POST['kullanicigiris'])) {
  $kullanici_mail=htmlspecialchars($_POST['kullanici_mail']);
  $kullanici_password=htmlspecialchars($_POST['kullanici_password']);
// md5-> şifreyi gizli tutar.

  
  $kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail and kullanici_password=:password and kullanici_durum=:durum");
  $kullanicisor->execute(array(
    'mail' => $kullanici_mail,
    'password' => md5($kullanici_password),
    'durum' => 1
  ));

  $say=$kullanicisor->rowCount();

  $kullanicisor2=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail");
  $kullanicisor2->execute(array(
    'mail' => $kullanici_mail

  ));
  $kullanicicek2=$kullanicisor2->fetch(PDO::FETCH_ASSOC);

  $kaydet=$db->prepare("INSERT into bildirim set

   bildirim_ad=:bildirim_ad,
   bildirim_detay=:bildirim_detay,
   bildirim_url=:bildirim_url,
   kullanici_id=:kullanici_id,
   bildirim_durum=:bildirim_durum
   ");

  $insert2=$kaydet->execute(array(

    'bildirim_ad' => "Sadece Sana!",
    'bildirim_detay' => "Özel İndirimler İçin Tıkla",
    'bildirim_url' => "kategoriler.php",
    'kullanici_id' => $kullanicicek2['kullanici_id'],
    'bildirim_durum' => 1

  ));

  if ($say==1) {
        // session kullanıcının sitede olup olmadığını kontrol eder.
   $_SESSION['checkkullanici_mail']=$kullanici_mail;
   header("Location:../../index.php?durum=loginbasarili");
   
 } else {
  header("Location:../../index.php?durum=no");

}

}

if (isset($_POST['kullanicigiris2'])) {

// md5-> şifreyi gizli tutar.
  $kullanici_mail=htmlspecialchars($_POST['kullanici_mail']);
  $kullanici_password=htmlspecialchars($_POST['kullanici_password']);

  
  $kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail and kullanici_password=:password and kullanici_durum=:durum");
  $kullanicisor->execute(array(
    'mail' => $kullanici_mail,
    'password' => md5($kullanici_password),
    'durum' => 1
  ));

  $say=$kullanicisor->rowCount();

  $kullanicisor2=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail");
  $kullanicisor2->execute(array(
    'mail' => $kullanici_mail

  ));
  $kullanicicek2=$kullanicisor2->fetch(PDO::FETCH_ASSOC);

  $kaydet=$db->prepare("INSERT into bildirim set

   bildirim_ad=:bildirim_ad,
   bildirim_detay=:bildirim_detay,
   bildirim_url=:bildirim_url,
   kullanici_id=:kullanici_id,
   bildirim_durum=:bildirim_durum
   ");

  $insert2=$kaydet->execute(array(

    'bildirim_ad' => "Sadece Sana!",
    'bildirim_detay' => "Özel İndirimler İçin Tıkla",
    'bildirim_url' => "kategoriler.php",
    'kullanici_id' => $kullanicicek2['kullanici_id'],
    'bildirim_durum' => 1

  ));


  if ($say==1) {
        // session kullanıcının sitede olup olmadığını kontrol eder.
   $_SESSION['checkkullanici_mail']=$kullanici_mail;
   header("Location:../../index.php?durum=loginbasarili");
   
 } else {
  header("Location:../../login.php?durum=no");

}

}

if (isset($_POST['genelayarkaydet'])) {
  $ayar_id=$_POST['ayar_id'];
  $ayarkaydet=$db->prepare("UPDATE ayar set 

    ayar_title=:ayar_title,
    ayar_description=:ayar_description,
    ayar_keywords=:ayar_keywords,
    ayar_author=:ayar_author
    where ayar_id=0");
  $update=$ayarkaydet->execute(array(

    'ayar_title'=>$_POST['ayar_title'],
    'ayar_description'=>$_POST['ayar_description'],
    'ayar_keywords'=>$_POST['ayar_keywords'],
    'ayar_author'=>$_POST['ayar_author']

  ));

  

  if ($update) {
    echo "Kaydedildi.";
    header("location:../production/genel-ayar.php?durum=ok");
    exit;
  }else{
    echo "Kaydedilemedi.";
    header("location:../production/genel-ayar.php?durum=no");
    exit;
  }



}

if (isset($_POST['logoayarkaydet'])) {

  $uploads_dir='../../dimg';

  $extension = pathinfo($_FILES["ayar_logo"]["name"], PATHINFO_EXTENSION);

  if($extension=='jpg' || $extension=='jpeg' || $extension=='png' || $extension=='gif')
  {




    @$tmp_name=$_FILES['ayar_logo']["tmp_name"];
    @$name=$_FILES['ayar_logo']["name"];

    $benzersizsayi=rand(20000,35000);
    $refimgyol=substr($uploads_dir,6)."/".$benzersizsayi.$name;
    @move_uploaded_file($tmp_name, "$uploads_dir/$benzersizsayi$name");

    $ayar_id=$_POST['ayar_id'];
    $ayarkaydet=$db->prepare("UPDATE ayar set 

      ayar_logo=:ayar_logo

      where ayar_id=0");
    $update=$ayarkaydet->execute(array(

      'ayar_logo'=>$refimgyol

    ));

    if ($update) {
//hata var!!!
      $resimunlink=$_POST['old_img'];
      unlink("../../$resimunlink");

      header("location:../production/logo-ayar.php?durum=ok");
      exit;
    }else{
     header("location:../production/logo-ayar.php?durum=no");
     exit;
   }

 }else{
  header("location:../production/logo-ayar.php?durum=img");
  exit;
}

}



if (isset($_POST['iletisimayarkaydet'])) {
  $ayar_id=$_POST['ayar_id'];
  $ayarkaydet=$db->prepare("UPDATE ayar set 

    ayar_tel=:ayar_tel,
    ayar_gsm=:ayar_gsm,
    ayar_mail=:ayar_mail,
    ayar_mail2=:ayar_mail2
    where ayar_id=0");
  $update=$ayarkaydet->execute(array(

    'ayar_tel'=>$_POST['ayar_tel'],
    'ayar_gsm'=>$_POST['ayar_gsm'],
    'ayar_mail'=>$_POST['ayar_mail'],
    'ayar_mail2'=>$_POST['ayar_mail2']
  ));

  if ($update) {
    echo "Kaydedildi.";
    header("location:../production/iletisim-ayar.php?durum=ok");
    exit;
  }else{
    echo "Kaydedilemedi.";
    header("location:../production/iletisim-ayar.php?durum=no");
    exit;
  }



}


if (isset($_POST['sosyalmedyaayarkaydet'])) {
  $ayar_id=$_POST['ayar_id'];
  $ayarkaydet=$db->prepare("UPDATE ayar set 

    ayar_facebook=:ayar_facebook,
    ayar_instagram=:ayar_instagram,
    ayar_twitter=:ayar_twitter,
    ayar_youtube=:ayar_youtube
    where ayar_id=0");
  $update=$ayarkaydet->execute(array(

    'ayar_facebook'=>$_POST['ayar_facebook'],
    'ayar_instagram'=>$_POST['ayar_instagram'],
    'ayar_twitter'=>$_POST['ayar_twitter'],
    'ayar_youtube'=>$_POST['ayar_youtube']
  ));

  if ($update) {
    echo "Kaydedildi.";
    header("location:../production/sosyalmedya-ayar.php?durum=ok");
    exit;
  }else{
    echo "Kaydedilemedi.";
    header("location:../production/sosyalmedya-ayar.php?durum=no");
    exit;
  }



}


if (isset($_POST['adresayarkaydet'])) {
  $ayar_id=$_POST['ayar_id'];
  $ayarkaydet=$db->prepare("UPDATE ayar set 

    ayar_ilce=:ayar_ilce,
    ayar_il=:ayar_il,
    ayar_adres=:ayar_adres,
    ayar_mesai=:ayar_mesai
    where ayar_id=0");
  $update=$ayarkaydet->execute(array(

    'ayar_ilce'=>$_POST['ayar_ilce'],
    'ayar_il'=>$_POST['ayar_il'],
    'ayar_adres'=>$_POST['ayar_adres'],
    'ayar_mesai'=>$_POST['ayar_mesai']
  ));

  if ($update) {
    echo "Kaydedildi.";
    header("location:../production/adres-ayar.php?durum=ok");
    exit;
  }else{
    echo "Kaydedilemedi.";
    header("location:../production/adres-ayar.php?durum=no");
    exit;
  }



}


if (isset($_POST['apiayarkaydet'])) {
  $ayar_id=$_POST['ayar_id'];
  $ayarkaydet=$db->prepare("UPDATE ayar set 

    ayar_analystic=:ayar_analystic,
    ayar_maps=:ayar_maps,
    ayar_zopim=:ayar_zopim
    where ayar_id=0");
  $update=$ayarkaydet->execute(array(

    'ayar_analystic'=>$_POST['ayar_analystic'],
    'ayar_maps'=>$_POST['ayar_maps'],
    'ayar_zopim'=>$_POST['ayar_zopim']
  ));

  if ($update) {
    echo "Kaydedildi.";
    header("location:../production/api-ayar.php?durum=ok");
    exit;
  }else{
    echo "Kaydedilemedi.";
    header("location:../production/api-ayar.php?durum=no");
    exit;
  }



}


if (isset($_POST['mailayarkaydet'])) {
  $ayar_id=$_POST['ayar_id'];
  $ayarkaydet=$db->prepare("UPDATE ayar set 

    ayar_smtphost=:ayar_smtphost,
    ayar_smtpuser=:ayar_smtpuser,
    ayar_smtpassword=:ayar_smtpassword,
    ayar_smtpport=:ayar_smtpport
    where ayar_id=0");
  $update=$ayarkaydet->execute(array(

    'ayar_smtphost'=>$_POST['ayar_smtphost'],
    'ayar_smtpuser'=>$_POST['ayar_smtpuser'],
    'ayar_smtpassword'=>$_POST['ayar_smtpassword'],
    'ayar_smtpport'=>$_POST['ayar_smtpport']
  ));

  if ($update) {
    echo "Kaydedildi.";
    header("location:../production/mail-ayar.php?durum=ok");
    exit;
  }else{
    echo "Kaydedilemedi.";
    header("location:../production/mail-ayar.php?durum=no");
    exit;
  }



}



if (isset($_POST['hakkimizdaayarkaydet'])) {
  $hakkimizda_id=$_POST['hakkimizda_id'];
  $hakkimizdakaydet=$db->prepare("UPDATE hakkimizda set 

    hakkimizda_baslik=:hakkimizda_baslik,
    hakkimizda_icerik=:hakkimizda_icerik,
    hakkimizda_video=:hakkimizda_video,
    hakkimizda_vizyon=:hakkimizda_vizyon,
    hakkimizda_misyon=:hakkimizda_misyon
    where hakkimizda_id=0");
  $update=$hakkimizdakaydet->execute(array(

    'hakkimizda_baslik'=>$_POST['hakkimizda_baslik'],
    'hakkimizda_icerik'=>$_POST['hakkimizda_icerik'],
    'hakkimizda_video'=>$_POST['hakkimizda_video'],
    'hakkimizda_vizyon'=>$_POST['hakkimizda_vizyon'],
    'hakkimizda_misyon'=>$_POST['hakkimizda_misyon']
  ));

  if ($update) {
    echo "Kaydedildi.";
    header("location:../production/hakkimizda-ayar.php?durum=ok");
    exit;
  }else{
    echo "Kaydedilemedi.";
    header("location:../production/hakkimizda-ayar.php?durum=no");
    exit;
  }



}


if (isset($_POST['kullaniciduzenlekaydet'])) {
  $kullanici_id=$_POST['kullanici_id'];
  $kullaniciduzenle=$db->prepare("UPDATE kullanici set 

    kullanici_adsoyad=:kullanici_adsoyad,
    kullanici_gsm=:kullanici_gsm,
    kullanici_mail=:kullanici_mail,
    kullanici_adres=:kullanici_adres,
    kullanici_durum=:kullanici_durum
    where kullanici_id={$_POST['kullanici_id']}");
  $update=$kullaniciduzenle->execute(array(

    'kullanici_adsoyad'=>$_POST['kullanici_adsoyad'],
    'kullanici_gsm'=>$_POST['kullanici_gsm'],
    'kullanici_mail'=>$_POST['kullanici_mail'],
    'kullanici_adres'=>$_POST['kullanici_adres'],
    'kullanici_durum'=>$_POST['kullanici_durum']
  ));

  if ($update) {
    echo "Kaydedildi.";
    header("location:../production/kullanici.php?kullanici_id=$kullanici_id&durum=ok");
    exit;
  }else{
    echo "Kaydedilemedi.";
    header("location:../production/kullanici.php?durum=no");
    exit;
  }



}

if ($_GET['kullanici_sil']=="ok") {
  giriskontrol();

  $sil=$db->prepare("DELETE from kullanici where kullanici_id=:id");
  $kontrol=$sil->execute(array(
    'id'=>$_GET['kullanici_id']

  ));
  if ($kontrol) {

    header("location:../production/kullanici.php?sil=ok");
  }else {
    header("location:../production/kullanici.php?sil=islem tamamlanamadı.");
  }


}

if (isset($_POST['kullaniciekle'])) {
  if (empty($_POST['kullanici_mail']) or empty($_POST['kullanici_ad']) or empty($_POST['kullanici_soyad']) or empty($_POST['kullanici_password']) or empty($_POST['kullanici_gsm']) or empty($_POST['kullanici_mail']) or empty($_POST['kullanici_adres'])) {
    header("location:../production/kullanici-ekle.php?durum=no");
  }elseif ($_POST['kullanici_password']!=$_POST['kullanici_password2']) {
    header("location:../production/kullanici-ekle.php?durum=eslesme");

  } else{
    $password=md5($_POST['kullanici_password']);

    $kaydet=$db->prepare("INSERT into kullanici set

      kullanici_ad=:kullanici_ad,
      kullanici_soyad=:kullanici_soyad,
      kullanici_gsm=:kullanici_gsm,
      kullanici_mail=:kullanici_mail,
      kullanici_password=:kullanici_password,
      kullanici_adres=:kullanici_adres,
      kullanici_yetki=:kullanici_yetki
      ");

    $insert=$kaydet->execute(array(

      'kullanici_ad' => $_POST['kullanici_ad'],
      'kullanici_soyad' => $_POST['kullanici_soyad'],
      'kullanici_gsm' => $_POST['kullanici_gsm'],
      'kullanici_mail' => $_POST['kullanici_mail'],
      'kullanici_password' => $password,
      'kullanici_adres' => $_POST['kullanici_adres'],
      'kullanici_yetki' => $_POST['kullanici_yetki']

    ));


    if ($insert) {

      header("location:../production/kullanici.php?kullaniciekle=ok");
      exit;
    }else{

      header("location:../production/kullanici.php?kullaniciekle=no");
      exit;
    }
  }
}

if (isset($_POST['menuduzenlekaydet'])) {
  $menu_seourl=seo($_POST['menu_ad']);
  $menu_id=$_POST['menu_id'];
  $menuduzenle=$db->prepare("UPDATE menu set 

    menu_ad=:menu_ad,
    menu_url=:menu_url,
    menu_sira=:menu_sira,
    menu_durum=:menu_durum,
    menu_detay=:menu_detay,
    menu_seourl=:menu_seourl
    where menu_id={$_POST['menu_id']}");
  $update=$menuduzenle->execute(array(

    'menu_ad' => $_POST['menu_ad'],
    'menu_url' => $_POST['menu_url'],
    'menu_sira' => $_POST['menu_sira'],
    'menu_durum' => $_POST['menu_durum'],
    'menu_detay' => $_POST['menu_detay'],
    'menu_seourl' => $menu_seourl
  ));

  if ($update) {
    echo "Kaydedildi.";
    header("location:../production/menu.php?menu_id=$menu_id&durum=ok");
    exit;
  }else{
    echo "Kaydedilemedi.";
    header("location:../production/menu.php?durum=no");
    exit;
  }



}

if (isset($_POST['menuekle'])) {
  $menu_seourl=seo($_POST['menu_ad']);

  if (empty($_POST['menu_ad']) or empty($_POST['menu_sira']) or $_POST['menu_durum']==-1 or empty($_POST['menu_detay'])) {
    header("location:../production/menu-ekle.php?durum=no");
  } else{

    $kaydet=$db->prepare("INSERT into menu set

      menu_ad=:menu_ad,
      menu_url=:menu_url,
      menu_sira=:menu_sira,
      menu_durum=:menu_durum,
      menu_detay=:menu_detay,
      menu_seourl=:menu_seourl
      ");

    $insert=$kaydet->execute(array(

      'menu_ad' => $_POST['menu_ad'],
      'menu_url' => $_POST['menu_url'],
      'menu_sira' => $_POST['menu_sira'],
      'menu_durum' => $_POST['menu_durum'],
      'menu_detay' => $_POST['menu_detay'],
      'menu_seourl' => $menu_seourl
    ));


    if ($insert) {

      header("location:../production/menu.php?menuekle=ok");
      exit;
    }else{

      header("location:../production/menu.php?menuekle=no");
      exit;
    }
  }
}

if ($_GET['menu_sil']=="ok") {
  giriskontrol();
  $sil=$db->prepare("DELETE from menu where menu_id=:id");
  $kontrol=$sil->execute(array(
    'id'=>$_GET['menu_id']

  ));
  if ($kontrol) {

    header("location:../production/menu.php?menu_sil=ok");
  }else {
    header("location:../production/menu.php?menu_sil=no");
  }


}



if (isset($_POST['sliderduzenlekaydet'])) {


  if($_FILES['slider_resimyol']["size"] > 0)  { 

    $extension = pathinfo($_FILES["slider_resimyol"]["name"], PATHINFO_EXTENSION);

    if($extension=='jpg' || $extension=='jpeg' || $extension=='png' || $extension=='gif')
    {

      $uploads_dir = '../../dimg/slider';
      @$tmp_name = $_FILES['slider_resimyol']["tmp_name"];
      @$name = $_FILES['slider_resimyol']["name"];
      $benzersizsayi1=rand(20000,32000);
      $benzersizsayi2=rand(20000,32000);
      $benzersizsayi3=rand(20000,32000);
      $benzersizsayi4=rand(20000,32000);
      $benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
      $refimgyol=substr($uploads_dir, 6)."/".$benzersizad.$name;
      @move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");

      $duzenle=$db->prepare("UPDATE slider SET
       slider_ad=:slider_ad,
       slider_icerik=:slider_icerik,
       slider_link=:slider_link,
       slider_sira=:slider_sira,
       slider_durum=:slider_durum,
       slider_button=:slider_button,
       slider_deal=:slider_deal,
       slider_fakefiyat=:slider_fakefiyat,
       slider_fiyat=:slider_fiyat,
       slider_resimyol=:resimyol 
       WHERE slider_id={$_POST['slider_id']}");
      $update=$duzenle->execute(array(
        'slider_ad' => $_POST['slider_ad'],
        'slider_icerik' => $_POST['slider_icerik'],
        'slider_link' => $_POST['slider_link'],
        'slider_sira' => $_POST['slider_sira'],
        'slider_durum' => $_POST['slider_durum'],
        'slider_button' => $_POST['slider_button'],
        'slider_deal' => $_POST['slider_deal'],
        'slider_fakefiyat' => $_POST['slider_fakefiyat'],
        'slider_fiyat' => $_POST['slider_fiyat'],
        'resimyol' => $refimgyol
      ));


      $slider_id=$_POST['slider_id'];

      if ($update) {

       $resimsilunlink=$_POST['old_slider'];
        unlink("../../$resimsilunlink");

        Header("Location:../production/slider-duzenle.php?slider_id=$slider_id&durum=ok");

      } else {

        Header("Location:../production/slider-duzenle.php?durum=no");
      }

    }else{
      $slider_id=$_POST['slider_id'];
      Header("Location:../production/slider-duzenle.php?slider_id=$slider_id&durum=img");
      exit;
    }

  } else {

    $duzenle=$db->prepare("UPDATE slider SET
     slider_ad=:slider_ad,
     slider_link=:slider_link,
     slider_sira=:slider_sira,
     slider_durum=:slider_durum,
     slider_button=:slider_button,
     slider_deal=:slider_deal,
     slider_fakefiyat=:slider_fakefiyat,
     slider_fiyat=:slider_fiyat   
     WHERE slider_id={$_POST['slider_id']}");
    $update=$duzenle->execute(array(
      'slider_ad' => $_POST['slider_ad'],
      'slider_link' => $_POST['slider_link'],
      'slider_sira' => $_POST['slider_sira'],
      'slider_durum' => $_POST['slider_durum'],
      'slider_button' => $_POST['slider_button'],
      'slider_deal' => $_POST['slider_deal'],
      'slider_fakefiyat' => $_POST['slider_fakefiyat'],
      'slider_fiyat' => $_POST['slider_fiyat']
    ));

    $slider_id=$_POST['slider_id'];

    if ($update) {

      Header("Location:../production/slider-duzenle.php?slider_id=$slider_id&durum=ok");

    } else {

      Header("Location:../production/slider-duzenle.php?slider_id=$slider_id&durum=no");
    }
  }

}



if (isset($_POST['sliderekle'])) {
 if (empty($_POST['slider_sira']) or $_POST['slider_durum']==-1 or empty($_POST['slider_link']) or empty($_POST['slider_resimyol'])) {
  header("location:../production/slider-ekle.php?durum=no");
}
$extension = pathinfo($_FILES["slider_resimyol"]["name"], PATHINFO_EXTENSION);
if($extension=='jpg' || $extension=='jpeg' || $extension=='png' || $extension=='gif')
{

  $uploads_dir = '../../dimg/slider';
  @$tmp_name = $_FILES['slider_resimyol']["tmp_name"];
  @$name = $_FILES['slider_resimyol']["name"];
  //resmin isminin benzersiz olması
  $benzersizsayi1=rand(20000,32000);
  $benzersizsayi2=rand(20000,32000);
  $benzersizsayi3=rand(20000,32000);
  $benzersizsayi4=rand(20000,32000);  
  $benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
  $refimgyol=substr($uploads_dir, 6)."/".$benzersizad.$name;
  @move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");



  $kaydet=$db->prepare("INSERT INTO slider SET
    slider_ad=:slider_ad,
    slider_link=:slider_link,
    slider_sira=:slider_sira,
    slider_durum=:slider_durum,
    slider_button=:slider_button,
    slider_deal=:slider_deal,
    slider_fakefiyat=:slider_fakefiyat,
    slider_fiyat=:slider_fiyat,
    slider_resimyol=:resimyol 
    ");
  $insert=$kaydet->execute(array(
    'slider_ad' => $_POST['slider_ad'],
    'slider_link' => $_POST['slider_link'],
    'slider_sira' => $_POST['slider_sira'],
    'slider_durum' => $_POST['slider_durum'],
    'slider_button' => $_POST['slider_button'],
    'slider_deal' => $_POST['slider_deal'],
    'slider_fakefiyat' => $_POST['slider_fakefiyat'],
    'slider_fiyat' => $_POST['slider_fiyat'],
    'resimyol' => $refimgyol
  ));

  if ($insert) {

    Header("Location:../production/slider.php?durum=ok");

  } else {

    Header("Location:../production/slider.php?durum=no");
  }


}else{
  Header("Location:../production/slider-ekle.php?durum=img");
  exit;
}

}

if ($_GET['slider_sil']=="ok") {
  giriskontrol();
  $sil=$db->prepare("DELETE from slider where slider_id=:id");
  $kontrol=$sil->execute(array(
    'id'=>$_GET['slider_id']

  ));
  $old_slidersil=$_GET['old_slider'];
  unlink("../../$old_slidersil");
  if ($kontrol) {

    header("location:../production/slider.php?slider_sil=ok");
  }else {
    header("location:../production/slider.php?slider_sil=no");
  }


}

if (isset($_POST['sitekullaniciekle'])) {
 $token=0;
 $random1=0; $random2=0; $random3=0; $random4=0;

 $random1=rand(0,50000);
 $random2=rand(0,100000);
 $random3=rand(0,35000);
 $random4=rand(11,85000);
 $token=$random1.$random2.$random3.$random4;

 $kullanici_ad=htmlspecialchars($_POST['kullanici_ad']);
 $kullanici_soyad=htmlspecialchars($_POST['kullanici_soyad']);
 $kullanici_mail=htmlspecialchars($_POST['kullanici_mail']);
 $kullanici_password=htmlspecialchars($_POST['kullanici_password']);
 $kullanici_gsm=htmlspecialchars($_POST['kullanici_gsm']);
 $kullanici_adres=htmlspecialchars($_POST['kullanici_adres']);


 if (empty($_POST['kullanici_mail']) or empty($_POST['kullanici_ad']) or empty($_POST['kullanici_soyad']) or empty($_POST['kullanici_password']) or empty($_POST['kullanici_gsm']) or empty($_POST['kullanici_mail']) or empty($_POST['kullanici_adres']) or empty($_POST['kullanici_ulke'])) {
  header("location:../../kullaniciekle.php?durum=empty");
}elseif (strlen($_POST['kullanici_password'])<6) {
  header("location:../../kullaniciekle.php?durum=eksiksifre");
}elseif ($_POST['kullanici_password']!=$_POST['kullanici_password2']) {
  header("location:../../kullaniciekle.php?durum=eslesmehata");
} else{

  $kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail");
  $kullanicisor->execute(array(
    'mail'=>$kullanici_mail

  ));
  $say=$kullanicisor -> rowCount();


  if($say==0){
    $password=md5($kullanici_password);

    $kaydet=$db->prepare("INSERT into kullanici set

      kullanici_ad=:kullanici_ad,
      kullanici_soyad=:kullanici_soyad,
      kullanici_mail=:kullanici_mail,
      kullanici_password=:kullanici_password,
      kullanici_gsm=:kullanici_gsm,
      kullanici_ulke=:kullanici_ulke,
      kullanici_adres=:kullanici_adres,
      kullanici_token=:kullanici_token
      ");

    $insert=$kaydet->execute(array(

      'kullanici_ad' => $kullanici_ad,
      'kullanici_soyad' => $kullanici_soyad,
      'kullanici_mail' => $kullanici_mail,
      'kullanici_password' => $password,
      'kullanici_gsm' => $kullanici_gsm,
      'kullanici_ulke' => $_POST['kullanici_ulke'],
      'kullanici_adres' => $kullanici_adres,
      'kullanici_token' => $token
    ));


    if ($insert) {

      require '../../mail/class.phpmailer.php';

      require '../../mail/PHPMailerAutoload.php';

      require '../../mail/class.smtp.php';  

      $mail = new PHPMailer;            

      $mail->IsSMTP();
      //$mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = 'tls'; // Güvenli baglanti icin ssl normal baglanti icin tls
      $mail->Host = "smtp-relay.sendinblue.com"; // Mail sunucusuna ismi
      $mail->Port = 587; // Gucenli baglanti icin 465 Normal baglanti icin 587
      $mail->IsHTML(true);
      $mail->SetLanguage("tr", "phpmailer/language");
      $mail->CharSet  ="utf-8";
      $mail->Username = "asdpasd02@gmail.com"; // Mail adresimizin kullanicý adi
      $mail->Password = "d8YbAwUXhxGFvByf"; // Mail adresimizin sifresi
      $mail->SetFrom("asdpasd02@gmail.com","BabafiyatlarVİP"); // Mail attigimizda gorulecek ismimiz
      $mail->AddAddress($_POST['kullanici_mail'],$_POST['kullanici_ad']); // Maili gonderecegimiz kisi yani alici
      $mail->addReplyTo($_POST['kullanici_mail'], $_POST['kullanici_ad']);
      $mail->Subject = "Babafiyatlara Hoşgeldin!"; // Konu basligi
      $mail->Body = "Merhaba"." ".$_POST['kullanici_ad']." <br /> BabafiyatlarVİP Ailesine Katıldığın İçin Teşekkürler. Sana özel modeller, indirimler ve daha birçok avantaj için aşağıdaki linke tıklayarak üyeliğini aktif etmelisin. Sitemizde Keyifli zaman geçirmen dileğiyle.<b>Made BY ME$</b><br />"."<div style='background:#eee;padding:5px;margin:5px;width:300px;'> LİNK : "."<a href=http://babafiyatlarvip.rf.gd/eticaret/login.php?token=".$token.">http://babafiyatlarvip.rf.gd/eticaret/login.php?token=".$token."</a></div>";
      if(!$mail->Send()){

        echo 'mail gonderilemedi';

      }
      $kullanici_id=$db->lastInsertId();

      header("location:../../login.php?durum=kayitbasarili&id=$kullanici_id");
      exit;
    }else{

      header("location:../../kullaniciekle.php?durum=no");
      exit;
    }
  }else{
    header("location:../../kullaniciekle.php?durum=kullanicivar");
  }
}
}

if (isset($_POST['tekrarmailgonder'])) {
  $token=$_POST['kullanici_token'];

  require '../../mail/class.phpmailer.php';

  require '../../mail/PHPMailerAutoload.php';

  require '../../mail/class.smtp.php';  

  $mail = new PHPMailer;            

  $mail->IsSMTP();
      //$mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
  $mail->SMTPAuth = true;
      $mail->SMTPSecure = 'tls'; // Güvenli baglanti icin ssl normal baglanti icin tls
      $mail->Host = "smtp-relay.sendinblue.com"; // Mail sunucusuna ismi
      $mail->Port = 587; // Gucenli baglanti icin 465 Normal baglanti icin 587
      $mail->IsHTML(true);
      $mail->SetLanguage("tr", "phpmailer/language");
      $mail->CharSet  ="utf-8";
      $mail->Username = "asdpasd02@gmail.com"; // Mail adresimizin kullanicý adi
      $mail->Password = "d8YbAwUXhxGFvByf"; // Mail adresimizin sifresi
      $mail->SetFrom("asdpasd02@gmail.com","BabafiyatlarVİP"); // Mail attigimizda gorulecek ismimiz
      $mail->AddAddress($_POST['kullanici_mail'],$_POST['kullanici_ad']); // Maili gonderecegimiz kisi yani alici
      $mail->addReplyTo($_POST['kullanici_mail'], $_POST['kullanici_ad']);
      $mail->Subject = "Babafiyatlara Hoşgeldin!"; // Konu basligi
      $mail->Body = "Merhaba"." ".$_POST['kullanici_ad']." <br /> BabafiyatlarVİP Ailesine Katıldığın İçin Teşekkürler. Sana özel modeller, indirimler ve daha birçok avantaj için aşağıdaki linke tıklayarak üyeliğini aktif etmelisin. Sitemizde Keyifli zaman geçirmen dileğiyle.<b>Made BY ME$</b><br />"."<div style='background:#eee;padding:5px;margin:5px;width:300px;'> LİNK : "."<a href=http://babafiyatlarvip.rf.gd/eticaret/login.php?token=".$token.">http://babafiyatlarvip.rf.gd/eticaret/login.php?token=".$token."</a></div>";

      if(!$mail->Send()){

        echo 'mail gonderilemedi';

      }else{
        $kullanici_id=$_POST['kullanici_id'];
        header("location:../../login.php?durum=kayitbasarili&id=$kullanici_id");
      }      

    }

    if (isset($_POST['gsmdegistir'])) {
      $kullanici_gsm=htmlspecialchars($_POST['kullanici_gsm']);
      $kullanici_id=$_POST['kullanici_id'];

      $kullaniciduzenle=$db->prepare("UPDATE kullanici set 


        kullanici_gsm=:kullanici_gsm

        where kullanici_id={$_POST['kullanici_id']}");
      $update=$kullaniciduzenle->execute(array(

        'kullanici_gsm'=>$kullanici_gsm

      ));

      if ($update) {
       header("location:../../hesabim.php?durum=ok");

     }else{
       header("location:../../hesabim.php?durum=no");

     }

   }

   if (isset($_POST['adresdegistir'])) {
    $kullanici_adres=htmlspecialchars($_POST['kullanici_adres']);
    $kullanici_id=$_POST['kullanici_id'];
    $kullaniciduzenle=$db->prepare("UPDATE kullanici set 


      kullanici_adres=:kullanici_adres

      where kullanici_id={$_POST['kullanici_id']}");
    $update=$kullaniciduzenle->execute(array(

      'kullanici_adres'=>$kullanici_adres

    ));

    if ($update) {
     header("location:../../hesabim.php?durum=ok");

   }else{
     header("location:../../hesabim.php?durum=no");

   }

 }

 if (isset($_POST['adresdegistir2'])) {
  $kullanici_adres=htmlspecialchars($_POST['kullanici_adres']);

  $kullanici_id=$_POST['kullanici_id'];
  $kullaniciduzenle=$db->prepare("UPDATE kullanici set 


    kullanici_adres=:kullanici_adres

    where kullanici_id={$_POST['kullanici_id']}");
  $update=$kullaniciduzenle->execute(array(

    'kullanici_adres'=>$kullanici_adres

  ));

  if ($update) {
   header("location:../../odeme.php");

 }else{
   header("location:../../odeme.php");

 }

}

if (isset($_POST['sifredegistir'])) {

  $oldpass=md5($_POST['kullanici_oldpass']);
  if ($_POST['kullanici_password']!=$oldpass) {
   header("location:../../hesabim.php?durum=eslesmehata");
 }elseif ($_POST['kullanici_newpassword']!=$_POST['kullanici_newpassword2']) {
  header("location:../../hesabim.php?durum=eslesmehata");
}elseif(strlen($_POST['kullanici_newpassword'])<6){
  header("location:../../hesabim.php?durum=eksiksifre");
} else{
 $kullanici_newpassword=htmlspecialchars($_POST['kullanici_newpassword']);
 $newpass=md5($kullanici_newpassword);
 $kullanici_id=$_POST['kullanici_id'];
 $kullaniciduzenle=$db->prepare("UPDATE kullanici set 

  kullanici_password=:kullanici_password

  where kullanici_id={$_POST['kullanici_id']}");
 $update=$kullaniciduzenle->execute(array(

  'kullanici_password'=>$newpass

));

 if ($update) {
   header("location:../../hesabim.php?durum=ok");

 }else{
   header("location:../../hesabim.php?durum=no");

 }
}
}

if (isset($_POST['iconresimkaydet'])) {
  $uploads_dir='../../dimg';

  @$tmp_name=$_FILES['ayar_logo']["tmp_name"];
  @$name=$_FILES['ayar_logo']["name"];

  $benzersizsayi=rand(20000,35000);
  $refimgyol=substr($uploads_dir,6)."/".$benzersizsayi.$name;
  @move_uploaded_file($tmp_name, "$uploads_dir/$benzersizsayi$name");
  $kategori_id=$_POST['kategori_id'];
  $kategoriduzenle=$db->prepare("UPDATE kategori set 
    kategori_icon=:kategori_icon

    where kategori_id={$_POST['kategori_id']}");
  $update=$kategoriduzenle->execute(array(

    'kategori_icon' => $_POST['kategori_icon']

  ));
  if ($update) {
//hata var!!!
    $resimunlink=$_POST['old_icon'];
    unlink("../../$resimunlink");

    header("location:../production/kategori.php?durum=ok");
    exit;
  }else{
   header("location:../production/kategori.php?durum=no");
   exit;
 }
}

if (isset($_POST['kategoriduzenlekaydet'])) {
  $kategori_seourl=seo($_POST['kategori_ad']);
  $kategori_id=$_POST['kategori_id'];
  $kategoriduzenle=$db->prepare("UPDATE kategori set 

    kategori_ad=:kategori_ad,
    kategori_sira=:kategori_sira,
    kategori_durum=:kategori_durum,
    kategori_seourl=:kategori_seourl
    where kategori_id={$_POST['kategori_id']}");
  $update=$kategoriduzenle->execute(array(

    'kategori_ad' => $_POST['kategori_ad'],
    'kategori_sira' => $_POST['kategori_sira'],
    'kategori_durum' => $_POST['kategori_durum'],
    'kategori_seourl' => $kategori_seourl
  ));

  if ($update) {
   header("location:../production/kategori.php?kategori_id=$kategori_id&durum=ok");
   exit;
 }else{
   header("location:../production/kategori.php?durum=no");
   exit;
 }

}

if (isset($_POST['kategoriekle'])) {
  $kategori_seourl=seo($_POST['kategori_ad']);
  if (empty($_POST['kategori_sira']) or $_POST['kategori_durum']==-1 or empty($_POST['kategori_ad']) or empty($_POST['kategori_icon'])) {
    header("location:../production/kategori-ekle.php?durum=no");
  } else{

    $kaydet=$db->prepare("INSERT into kategori set

      kategori_icon=:kategori_icon,
      kategori_ad=:kategori_ad,
      kategori_sira=:kategori_sira,
      kategori_durum=:kategori_durum,
      kategori_seourl=:kategori_seourl
      ");

    $insert=$kaydet->execute(array(

      'kategori_icon' => $_POST['kategori_icon'],
      'kategori_ad' => $_POST['kategori_ad'],
      'kategori_sira' => $_POST['kategori_sira'],
      'kategori_durum' => $_POST['kategori_durum'],
      'kategori_seourl' => $kategori_seourl
    ));


    if ($insert) {

      header("location:../production/kategori.php?durum=ok");
      exit;
    }else{

      header("location:../production/kategori.php?durum=no");
      exit;
    }
  }
}

if ($_GET['kategori_sil']=="ok") {
  giriskontrol();
  $sil=$db->prepare("DELETE from kategori where kategori_id=:id");
  $kontrol=$sil->execute(array(
    'id'=>$_GET['kategori_id']

  ));
  if ($kontrol) {

    header("location:../production/kategori.php?kategori_sil=ok");
  }else {
    header("location:../production/kategori.php?kategori_sil=no");
  }


}

if (isset($_POST['urunduzenlekaydet'])) {
  $urun_seourl=seo($_POST['urun_ad']);
  $urun_id=$_POST['urun_id'];
  $deger=$_GET['token'];
  $urunduzenle=$db->prepare("UPDATE urun set 

    urun_ad=:urun_ad,
    kategori_id=:kategori_id,
    urun_keyword=:urun_keyword,
    urun_uretici=:urun_uretici,
    urun_detay=:urun_detay,
    urun_fiyat=:urun_fiyat,
    urun_fakefiyat=:urun_fakefiyat,
    urun_renk=:urun_renk,
    urun_stok=:urun_stok,
    urun_fakestok=:urun_fakestok,
    urun_star=:urun_star,
    urun_durum=:urun_durum,
    urun_seourl=:urun_seourl
    where urun_id={$_POST['urun_id']}");
  $update=$urunduzenle->execute(array(

    'urun_ad' => $_POST['urun_ad'],
    'kategori_id' => $_POST['kategori_id'],
    'urun_keyword' => $_POST['urun_keyword'],
    'urun_uretici' => $_POST['urun_uretici'],
    'urun_detay' => $_POST['urun_detay'],
    'urun_fiyat' => $_POST['urun_fiyat'],
    'urun_fakefiyat' => $_POST['urun_fakefiyat'],
    'urun_renk' => $_POST['urun_renk'],
    'urun_stok' => $_POST['urun_stok'],
    'urun_fakestok' => $_POST['urun_fakestok'],
    'urun_star' => $_POST['urun_star'],
    'urun_durum' => $_POST['urun_durum'],
    'urun_seourl'=>$urun_seourl
  ));

  if ($update) {
    echo "Kaydedildi.";
    header("location:../production/urun.php?urun_id=$urun_id&durum=ok&token=$deger");
    exit;
  }else{
    echo "Kaydedilemedi.";
    header("location:../production/urun.php?durum=no");
    exit;
  }



}

if (isset($_POST['urunekle'])) {
  $urun_seourl=seo($_POST['urun_ad']);

  if (empty($_POST['urun_ad']) or empty($_POST['urun_keyword']) or empty($_POST['urun_uretici']) or empty($_POST['urun_fiyat']) or empty($_POST['urun_fakefiyat']) or empty($_POST['urun_stok'])  or $_POST['kategori_id']==-1 or $_POST['urun_durum']==-1 or $_POST['urun_star']==-1 or empty($_POST['urun_fakestok'])) {
    header("location:../production/urun-ekle.php?durum=no");
  } else{

    $kaydet=$db->prepare("INSERT into urun set

      urun_ad=:urun_ad,
      kategori_id=:kategori_id,
      urun_keyword=:urun_keyword,
      urun_uretici=:urun_uretici,
      urun_detay=:urun_detay,
      urun_fiyat=:urun_fiyat,
      urun_fakefiyat=:urun_fakefiyat,
      urun_renk=:urun_renk,
      urun_stok=:urun_stok,
      urun_fakestok=:urun_fakestok,
      urun_star=:urun_star,
      urun_durum=:urun_durum,
      urun_seourl=:urun_seourl
      ");

    $insert=$kaydet->execute(array(

      'urun_ad' => $_POST['urun_ad'],
      'kategori_id' => $_POST['kategori_id'],
      'urun_keyword' => $_POST['urun_keyword'],
      'urun_uretici' => $_POST['urun_uretici'],
      'urun_detay' => $_POST['urun_detay'],
      'urun_fiyat' => $_POST['urun_fiyat'],
      'urun_fakefiyat' => $_POST['urun_fakefiyat'],
      'urun_renk' => $_POST['urun_renk'],
      'urun_stok' => $_POST['urun_stok'],
      'urun_fakestok' => $_POST['urun_fakestok'],
      'urun_star' => $_POST['urun_star'],
      'urun_durum' => $_POST['urun_durum'],
      'urun_seourl'=>$urun_seourl
    ));


    if ($insert) {

      header("location:../production/urun.php?urunekle=ok");
      exit;
    }else{

      header("location:../production/urun.php?urunekle=no");
      exit;
    }
  }
}

if ($_GET['urun_sil']=="ok") {
  giriskontrol();

  $sil=$db->prepare("DELETE from urun where urun_id=:id");
  $kontrol=$sil->execute(array(
    'id'=>$_GET['urun_id']

  ));
  if ($kontrol) {

    header("location:../production/urun.php?urun_sil=ok");
  }else {
    header("location:../production/urun.php?urun_sil=no");
  }


}

if (isset($_POST['renkduzenlekaydet'])) {
  $urun_id=$_POST['urun_id'];
  $renkler=$_POST['renk_ad'];

  $renkduzenle=$db->prepare("UPDATE renk set 

    renk_ad=:renk_ad,
    renk_stok=:renk_stok 
    where renk_id={$_POST['renk_id']}");
  $update=$renkduzenle->execute(array(

    'renk_ad' => $_POST['renk_ad'],
    'renk_stok' => $_POST['renk_stok']
  ));

  if ($update) {
   header("location:../production/renk-duzenle.php?urun_id=$urun_id&durum=ok");
   exit;
 }else{

   header("location:../production/renk-duzenle.php?urun_id=$urun_id&durum=no");
   exit;
 }



}

if (isset($_POST['renkekle'])) {
 $renkler=$_POST['renk_ad'];
 $urun_id=$_POST['urun_id'];

 foreach ($renkler as $renk ) {


  $kaydet=$db->prepare("INSERT into renk set


    renk_ad=:renk_ad,
    urun_id=:urun_id
    ");

  $insert=$kaydet->execute(array(


    'renk_ad' => $renk,
    'urun_id'=> $urun_id
  ));

}
if ($insert) {

  header("location:../production/renk-duzenle.php?urun_id=$urun_id&durum=ok");
  exit;
}else{

  header("location:../production/renk-duzenle.php?urun_id=$urun_id&durum=no");
  exit;
}

}

if (isset($_POST['renk_sil'])) {
  giriskontrol();
  $urun_id=$_POST['urun_id'];

  $sil=$db->prepare("DELETE from renk where renk_id=:id");
  $kontrol=$sil->execute(array(
    'id'=>$_POST['renk_id']

  ));
  if ($kontrol) {

    header("location:../production/renk-duzenle.php?urun_id=$urun_id&sil=ok");
  }else {
    header("location:../production/renk-duzenle.php?urun_id=$urun_id&sil=no");
  }


}

if (isset($_POST['yorumekle'])) {
  $yorum_detay=htmlspecialchars($_POST['yorum_detay']);
  $kullanici_id=$_POST['kullanici_id'];
  $yorum_url=$_POST['yorum_url'];
  if (empty($_POST['yorum_detay'])) {
    header("location:../../$yorum_url?durum=no");
  } else{

    $kaydet=$db->prepare("INSERT into yorum set

      yorum_detay=:yorum_detay,
      kullanici_id=:kullanici_id,
      yorum_durum=:yorum_durum,
      yorum_url=:yorum_url
      ");

    $insert=$kaydet->execute(array(

      'yorum_detay' => $yorum_detay,
      'kullanici_id' => $kullanici_id,
      'yorum_durum' => $_POST['yorum_durum'],
      'yorum_url' => $_POST['yorum_url']
    ));


    if ($insert) {

      header("location:../../$yorum_url?durum=ok");
      exit;
    }else{

      header("location:../../$yorum_url?durum=no");
      exit;
    }
  }
}

if ($_GET['yorum_sil']=="ok") {
  giriskontrol();
  $sil=$db->prepare("DELETE from yorum where yorum_id=:id");
  $kontrol=$sil->execute(array(
    'id'=>$_GET['yorum_id']

  ));
  if ($kontrol) {

    header("location:../production/yorum-islem.php?sil=ok");
  }else {
    header("location:../production/yorum-islem.php?sil=no");
  }


}

if (isset($_POST['yorumduzenlekaydet'])) {

  $yorumduzenle=$db->prepare("UPDATE yorum set 

    yorum_detay=:yorum_detay,
    yorum_durum=:yorum_durum
    where yorum_id={$_POST['yorum_id']}");
  $update=$yorumduzenle->execute(array(

    'yorum_detay' => $_POST['yorum_detay'],
    'yorum_durum' => $_POST['yorum_durum']
  ));

  if ($update) {
   header("location:../production/yorum-islem.php?durum=ok");
   exit;
 }else{

   header("location:../production/yorum-islem.php?durum=no");
   exit;
 }

}

if (isset($_POST['sepetekle'])) {
  $urun_url=$_POST['urun_url'];
  $kullanici_id=$_POST['kullanici_id'];
  $renk_id=$_POST['renk_id'];

  $sepetsor5=$db->prepare("SELECT * FROM sepet where kullanici_id=:id");
  $sepetsor5->execute(array(
    'id'=> $kullanici_id

  ));
  $sepetcek5=$sepetsor5->fetch(PDO::FETCH_ASSOC);
  $urunsor=$db-> prepare("SELECT * from urun where urun_id=:id");
  $urunsor->execute(array(
    'id'=>$_POST['urun_id']
  ));
  $uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);

  $renksor=$db->prepare("SELECT * FROM renk where renk_id=:id");
  $renksor->execute(array(
    'id' => $renk_id
  ));
  $renkcek=$renksor->fetch(PDO::FETCH_ASSOC);

  if ($_POST['urun_adet']>$uruncek['urun_stok']){
    header("location:../../$urun_url?stok=no");
    exit;

  }if($renk_id==0){
    header("location:../../$urun_url?renk=no");
    exit;
  }if ($_POST['urun_adet']>$renkcek['renk_stok']) {
    header("location:../../$urun_url?stok=no");
    exit;
  }if ($sepetcek5['urun_renk']==$renkcek['renk_ad'] and $sepetcek5['urun_id']==$_POST['urun_id']) {

    $sepetduzenle=$db->prepare("UPDATE sepet set 

      urun_adet=:urun_adet

      where sepet_id={$sepetcek5['sepet_id']}");
    $update=$sepetduzenle->execute(array(

      'urun_adet' => $_POST['urun_adet']+$sepetcek5['urun_adet']
    ));

    if ($update) {
     header("location:../../sepet.php?durum=ok");
     exit;
   }else{

     header("location:../../sepet.php?durum=no");
     exit;
   }

 }else {
  $urun_id=$_POST['urun_id'];

  
  $kaydet=$db->prepare("INSERT into sepet set

    urun_adet=:urun_adet,
    kullanici_id=:kullanici_id,
    urun_id=:urun_id,
    urun_renk=:urun_renk
    ");

  $insert=$kaydet->execute(array(

    'urun_adet' => $_POST['urun_adet'],
    'kullanici_id' => $kullanici_id,
    'urun_id' => $urun_id,
    'urun_renk' => $renkcek['renk_ad']
  ));


  if ($insert) {

    header("location:../../sepet.php?durum=ok");
    exit;
  }else{

    header("location:../../sepet.php?durum=no");
    exit;
  }
}
}


if (isset($_POST['sepet_sil'])) {
  $sil=$db->prepare("DELETE from sepet where sepet_id=:id");
  $kontrol=$sil->execute(array(
    'id'=>$_POST['sepet_id']

  ));
  if ($kontrol) {

    header("location:../../sepet.php?sil=ok");
  }else {
    header("location:../../sepet.php?sil=no");
  }


}
if (isset($_POST['sepet_sil2'])) {

  $sil=$db->prepare("DELETE from sepet where sepet_id=:id");
  $kontrol=$sil->execute(array(
    'id'=>$_POST['sepet_id']

  ));
  if ($kontrol) {

    header("location:../../index.php?sil=ok");
  }else {
    header("location:../../index.php?sil=no");
  }


}

if (isset($_POST['adetdegistir'])) {

  $urunsor=$db-> prepare("SELECT * from urun where urun_id=:id");
  $urunsor->execute(array(
    'id'=>$_POST['urun_id']
  ));
  $uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);

  $renksor=$db->prepare("SELECT * FROM renk where renk_ad=:ad and urun_id=:id");
  $renksor->execute(array(
    'ad' => $_POST['renk_ad'],
    'id'=>$uruncek['urun_id']
  ));
  $renkcek=$renksor->fetch(PDO::FETCH_ASSOC);
  if ($_POST['urun_adet']>$uruncek['urun_stok']){
    header("location:../../sepet.php?stok=no");
    exit;

  }if ($_POST['urun_adet']>$renkcek['renk_stok']) {
   header("location:../../sepet.php?stok=no");
   exit;
 }
 $sepetduzenle=$db->prepare("UPDATE sepet set 

  urun_adet=:urun_adet

  where sepet_id={$_POST['sepet_id']}");
 $update=$sepetduzenle->execute(array(

  'urun_adet' => $_POST['urun_adet']
));

 if ($update) {
   header("location:../../sepet.php?durum=ok");
   exit;
 }else{

   header("location:../../sepet.php?durum=no");
   exit;
 }

}

if (isset($_POST['kuponduzenlekaydet'])) {
  $kupon_id=$_POST['kupon_id'];
  $kuponduzenle=$db->prepare("UPDATE kupon set 

    kupon_ad=:kupon_ad,
    kupon_keyword=:kupon_keyword,
    kupon_adet=:kupon_adet,
    kupon_fiyat=:kupon_fiyat,
    kupon_durum=:kupon_durum
    where kupon_id={$_POST['kupon_id']}");
  $update=$kuponduzenle->execute(array(

    'kupon_ad' => $_POST['kupon_ad'],
    'kupon_keyword' => $_POST['kupon_keyword'],
    'kupon_adet' => $_POST['kupon_adet'],
    'kupon_fiyat' => $_POST['kupon_fiyat'],
    'kupon_durum' => $_POST['kupon_durum']

  ));

  if ($update) {
    echo "Kaydedildi.";
    header("location:../production/kupon.php?durum=ok");
    exit;
  }else{
    echo "Kaydedilemedi.";
    header("location:../production/kupon.php?durum=no");
    exit;
  }



}

if (isset($_POST['kuponekle'])) {


  if (empty($_POST['kupon_ad']) or empty($_POST['kupon_keyword']) or $_POST['kupon_durum']==-1 or empty($_POST['kupon_adet'])) {
    header("location:../production/kupon-ekle.php?durum=no");
  } else{

    $kaydet=$db->prepare("INSERT into kupon set

      kupon_ad=:kupon_ad,
      kupon_keyword=:kupon_keyword,
      kupon_adet=:kupon_adet,
      kupon_fiyat=:kupon_fiyat,
      kupon_durum=:kupon_durum

      ");

    $insert=$kaydet->execute(array(

      'kupon_ad' => $_POST['kupon_ad'],
      'kupon_keyword' => $_POST['kupon_keyword'],
      'kupon_adet' => $_POST['kupon_adet'],
      'kupon_fiyat' => $_POST['kupon_fiyat'],
      'kupon_durum' => $_POST['kupon_durum']

    ));


    if ($insert) {

      header("location:../production/kupon.php?durum=ok");
      exit;
    }else{

      header("location:../production/kupon.php?durum=no");
      exit;
    }
  }
}

if (isset($_GET['kupon_sil'])) {
  giriskontrol();
  $sil=$db->prepare("DELETE from kupon where kupon_id=:id");
  $kontrol=$sil->execute(array(
    'id'=>$_GET['kupon_id']

  ));
  if ($kontrol) {

    header("location:../production/kupon.php?sil=ok");
  }else {
    header("location:../production/kupon.php?sil=no");
  }


}

if (isset($_POST['kuponinsert'])) {
  $kupon_keyword=htmlspecialchars($_POST['kupon_keyword']);
  $sepet_id=$_POST['sepet_id'];
  $kuponsor=$db->prepare("SELECT * FROM kupon where kupon_durum=:durum and kupon_adet>0");
  $kuponsor->execute(array(
    'durum'=> 1
  ));
  $keyword=$kupon_keyword;
  $say=0;
  
  while($kuponcek=$kuponsor->fetch(PDO::FETCH_ASSOC)){
    if ($kuponcek['kupon_keyword']==$keyword) {
      $say++;

      $sepetduzenle=$db->prepare("UPDATE sepet set 

        urun_kupon=:urun_kupon

        where sepet_id={$sepet_id}");
      $update=$sepetduzenle->execute(array(

        'urun_kupon' => 1


      ));
      header("location:../../odeme.php?kupon_ad=$keyword");
    }else{
      continue;
    }

  }
  if ($say==0) {
   header("location:../../odeme.php?kupon_ad=no");
 }


}


if (isset($_POST['bankaduzenlekaydet'])) {
  $banka_id=$_POST['banka_id'];
  $bankaduzenle=$db->prepare("UPDATE banka set 

    banka_ad=:banka_ad,
    banka_iban=:banka_iban,
    banka_adsoyad=:banka_adsoyad,
    banka_durum=:banka_durum
    where banka_id={$_POST['banka_id']}");
  $update=$bankaduzenle->execute(array(

    'banka_ad' => $_POST['banka_ad'],
    'banka_iban' => $_POST['banka_iban'],
    'banka_adsoyad' => $_POST['banka_adsoyad'],
    'banka_durum' => $_POST['banka_durum']

  ));

  if ($update) {
    echo "Kaydedildi.";
    header("location:../production/banka.php?durum=ok");
    exit;
  }else{
    echo "Kaydedilemedi.";
    header("location:../production/banka.php?durum=no");
    exit;
  }



}

if (isset($_POST['bankaekle'])) {


  if (empty($_POST['banka_ad']) or empty($_POST['banka_iban']) or empty($_POST['banka_adsoyad']) or $_POST['banka_durum']==-1) {
    header("location:../production/banka-ekle.php?durum=no");
  } else{

    $kaydet=$db->prepare("INSERT into banka set

      banka_ad=:banka_ad,
      banka_iban=:banka_iban,
      banka_adsoyad=:banka_adsoyad,
      banka_durum=:banka_durum

      ");

    $insert=$kaydet->execute(array(

      'banka_ad' => $_POST['banka_ad'],
      'banka_iban' => $_POST['banka_iban'],
      'banka_adsoyad' => $_POST['banka_adsoyad'],
      'banka_durum' => $_POST['banka_durum']

    ));


    if ($insert) {

      header("location:../production/banka.php?durum=ok");
      exit;
    }else{

      header("location:../production/banka.php?durum=no");
      exit;
    }
  }
}

if (isset($_GET['banka_sil'])) {
  giriskontrol();
  $sil=$db->prepare("DELETE from banka where banka_id=:id");
  $kontrol=$sil->execute(array(
    'id'=>$_GET['banka_id']

  ));
  if ($kontrol) {

    header("location:../production/banka.php?sil=ok");
  }else {
    header("location:../production/banka.php?sil=no");
  }


}

if (isset($_POST['kargoduzenlekaydet'])) {
  $kargo_id=$_POST['kargo_id'];
  $kargoduzenle=$db->prepare("UPDATE kargo set 

    kargo_ad=:kargo_ad,
    kargo_fiyat=:kargo_fiyat,
    kargo_durum=:kargo_durum
    where kargo_id={$_POST['kargo_id']}");
  $update=$kargoduzenle->execute(array(

    'kargo_ad' => $_POST['kargo_ad'],
    'kargo_fiyat' => $_POST['kargo_fiyat'],
    'kargo_durum' => $_POST['kargo_durum']

  ));

  if ($update) {
    echo "Kaydedildi.";
    header("location:../production/kargo.php?durum=ok");
    exit;
  }else{
    echo "Kaydedilemedi.";
    header("location:../production/kargo.php?durum=no");
    exit;
  }

}

if (isset($_POST['kargoekle'])) {


  if (empty($_POST['kargo_ad']) or empty($_POST['kargo_fiyat']) or $_POST['kargo_durum']==-1) {
    header("location:../production/kargo-ekle.php?durum=no");
  } else{

    $kaydet=$db->prepare("INSERT into kargo set

      kargo_ad=:kargo_ad,
      kargo_fiyat=:kargo_fiyat,
      kargo_durum=:kargo_durum

      ");

    $insert=$kaydet->execute(array(

      'kargo_ad' => $_POST['kargo_ad'],
      'kargo_fiyat' => $_POST['kargo_fiyat'],
      'kargo_durum' => $_POST['kargo_durum']

    ));


    if ($insert) {

      header("location:../production/kargo.php?durum=ok");
      exit;
    }else{

      header("location:../production/kargo.php?durum=no");
      exit;
    }
  }
}

if (isset($_GET['kargo_sil'])) {
  giriskontrol();
  $sil=$db->prepare("DELETE from kargo where kargo_id=:id");
  $kontrol=$sil->execute(array(
    'id'=>$_GET['kargo_id']

  ));
  if ($kontrol) {

    header("location:../production/kargo.php?sil=ok");
  }else {
    header("location:../production/kargo.php?sil=no");
  }

}

if (isset($_POST['havalesipariskaydet'])) {
  $bankasor=$db->prepare("SELECT * FROM banka where banka_id=:id");
  $bankasor->execute(array(
    'id'=>$_POST['banka_id']
  ));
  $bankacek=$bankasor->fetch(PDO::FETCH_ASSOC);

  $kargosor=$db->prepare("SELECT * FROM kargo where kargo_id=:id");
  $kargosor->execute(array(
    'id'=>$_POST['kargo_id']
  ));
  $kargocek=$kargosor->fetch(PDO::FETCH_ASSOC);

  $banka=$bankacek['banka_ad'];
  $kargo=$kargocek['kargo_ad'];
  $siparis_tip="Banka Havalesi";
  $kullanici_id=$_POST['kullanici_id'];

  if (empty($_POST['banka_id']) and empty($_POST['kargo_id'])) {
    header("location:../../odeme.php?durum=no");
  } else{

    $kaydet=$db->prepare("INSERT into siparis set

      kullanici_id=:kullanici_id,
      siparis_banka=:siparis_banka,
      siparis_kargo=:siparis_kargo,
      siparis_toplam=:siparis_toplam,
      siparis_tip=:siparis_tip,
      siparis_aciklama=:siparis_aciklama,
      siparis_durum=:siparis_durum
      ");

    $insert=$kaydet->execute(array(

      'kullanici_id' => $kullanici_id,
      'siparis_banka' => $banka,
      'siparis_kargo' => $kargo,
      'siparis_toplam' => $_POST['siparis_toplam'],
      'siparis_tip' => $siparis_tip,
      'siparis_aciklama' => $_POST['siparis_aciklama'],
      'siparis_durum' => 1
    ));


    if ($insert) {
//lastinsertid-> Son kaydedilen idyi alır.
     $siparis_id = $db->lastInsertId();
     $kullanici_id=$_POST['kullanici_id'];
     $sepetsor=$db->prepare("SELECT * FROM sepet where kullanici_id=:id");
     $sepetsor->execute(array(
      'id'=> $kullanici_id

    ));

     while ($sepetcek=$sepetsor->fetch(PDO::FETCH_ASSOC)){
      $urun=$sepetcek['urun_id'];
      $urunsor=$db-> prepare("SELECT * from urun where urun_id=:id");
      $urunsor->execute(array(
        'id'=>$urun
      ));
      $renksor=$db->prepare("SELECT * FROM renk where urun_id=:id and renk_ad=:ad");
      $renksor->execute(array(
        'id' => $urun,
        'ad'=>$sepetcek['urun_renk']
      ));
      $renkcek=$renksor->fetch(PDO::FETCH_ASSOC);
      $uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);
      $urun_adet=$sepetcek['urun_adet'];
      $urun_renk=$sepetcek['urun_renk'];
      $urun_fiyat=$uruncek['urun_fiyat'];

      $kaydet=$db->prepare("INSERT into siparisdetay set

        siparis_id=:siparis_id,
        urun_id=:urun_id,
        urun_fiyat=:urun_fiyat,
        urun_kupon=:urun_kupon,
        urun_adet=:urun_adet,
        urun_renk=:urun_renk
        ");

      $insert2=$kaydet->execute(array(

        'siparis_id' => $siparis_id,
        'urun_id' => $urun,
        'urun_fiyat' => $urun_fiyat,
        'urun_kupon' => $sepetcek['urun_kupon'],
        'urun_adet' => $urun_adet,
        'urun_renk' => $urun_renk

      ));

      $urunduzenle=$db->prepare("UPDATE urun set 

        urun_stok=:urun_stok

        where urun_id={$uruncek['urun_id']}");
      $update=$urunduzenle->execute(array(


        'urun_stok' => $uruncek['urun_stok']-$sepetcek['urun_adet']

      ));
      $renkduzenle=$db->prepare("UPDATE renk set 

        renk_stok=:renk_stok

        where renk_id={$renkcek['renk_id']}");
      $update=$renkduzenle->execute(array(


        'renk_stok' => $renkcek['renk_stok']-$sepetcek['urun_adet']

      ));
    }
    if ($insert2) {
      //sepet silme, ürün adet düşme ve kupon varsa kupon adeti düşme

      $sil=$db->prepare("DELETE from sepet where kullanici_id=:id");
      $kontrol=$sil->execute(array(
        'id'=>$kullanici_id

      ));

      $kaydet=$db->prepare("INSERT into bildirim set

       bildirim_ad=:bildirim_ad,
       bildirim_detay=:bildirim_detay,
       bildirim_url=:bildirim_url,
       kullanici_id=:kullanici_id,
       bildirim_durum=:bildirim_durum
       ");

      $insert2=$kaydet->execute(array(

        'bildirim_ad' => "Tebrikler",
        'bildirim_detay' => "Siparişin Alındı",
        'bildirim_url' => "siparislerim.php",
        'kullanici_id' => $kullanici_id,
        'bildirim_durum' => 1

      ));
      

      if ($_POST['kupon_indirim']>0) {

        $kuponsor=$db->prepare("SELECT * FROM kupon where kupon_keyword=:keyword");
        $kuponsor->execute(array(
          'keyword'=>$_POST['kupon_ozel']
        ));
        $kuponcek=$kuponsor->fetch(PDO::FETCH_ASSOC);
        $kuponduzenle=$db->prepare("UPDATE kupon set 

          kupon_adet=:kupon_adet

          where kupon_id={$kuponcek['kupon_id']}");
        $update=$kuponduzenle->execute(array(


          'kupon_adet' => $kuponcek['kupon_adet']-1

        ));
      }

      
      if ($kontrol) {

        header("location:../../siparislerim.php?ekle=ok");
      }else {
        header("location:../../siparislerim.php?ekle=no");
      }





    }else{
      header("location:../../odeme.php?durum=no");
      exit;
    }

  }else{

    header("location:../../odeme.php?durum=no");
    exit;
  }
}
}

if (isset($_POST['kapidasipariskaydet'])) {

  $kargosor=$db->prepare("SELECT * FROM kargo where kargo_id=:id");
  $kargosor->execute(array(
    'id'=>$_POST['kargo_id']
  ));
  $kargocek=$kargosor->fetch(PDO::FETCH_ASSOC);

  $kargo=$kargocek['kargo_ad'];
  $siparis_tip="Kapıda Ödeme";
  $kullanici_id=$_POST['kullanici_id'];

  if (empty($_POST['kargo_id'])) {
    header("location:../../odeme.php?durum=no");
  } else{

    $kaydet=$db->prepare("INSERT into siparis set

      kullanici_id=:kullanici_id,
      siparis_kargo=:siparis_kargo,
      siparis_toplam=:siparis_toplam,
      siparis_tip=:siparis_tip,
      siparis_aciklama=:siparis_aciklama,
      siparis_durum=:siparis_durum
      ");

    $insert=$kaydet->execute(array(

      'kullanici_id' => $kullanici_id,
      'siparis_kargo' => $kargo,
      'siparis_toplam' => $_POST['siparis_toplam']+$kargocek['kargo_fiyat'],
      'siparis_tip' => $siparis_tip,
      'siparis_aciklama' => $_POST['siparis_aciklama'],
      'siparis_durum' => 1
    ));


    if ($insert) {
//lastinsertid-> Son kaydedilen idyi alır.
     $siparis_id = $db->lastInsertId();
     $kullanici_id=$_POST['kullanici_id'];
     $sepetsor=$db->prepare("SELECT * FROM sepet where kullanici_id=:id");
     $sepetsor->execute(array(
      'id'=> $kullanici_id

    ));

     while ($sepetcek=$sepetsor->fetch(PDO::FETCH_ASSOC)){
      $urun=$sepetcek['urun_id'];
      $urunsor=$db-> prepare("SELECT * from urun where urun_id=:id");
      $urunsor->execute(array(
        'id'=>$urun
      ));

      $renksor=$db->prepare("SELECT * FROM renk where urun_id=:id and renk_ad=:ad");
      $renksor->execute(array(
        'id' => $urun,
        'ad'=>$sepetcek['urun_renk']
      ));
      $renkcek=$renksor->fetch(PDO::FETCH_ASSOC);
      $uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);
      $urun_adet=$sepetcek['urun_adet'];
      $urun_renk=$sepetcek['urun_renk'];
      $urun_fiyat=$uruncek['urun_fiyat'];

      $kaydet=$db->prepare("INSERT into siparisdetay set

        siparis_id=:siparis_id,
        urun_id=:urun_id,
        urun_fiyat=:urun_fiyat,
        urun_kupon=:urun_kupon,
        urun_adet=:urun_adet,
        urun_renk=:urun_renk
        ");

      $insert2=$kaydet->execute(array(

        'siparis_id' => $siparis_id,
        'urun_id' => $urun,
        'urun_fiyat' => $urun_fiyat,
        'urun_kupon' => $sepetcek['urun_kupon'],
        'urun_adet' => $urun_adet,
        'urun_renk' => $urun_renk

      ));

      $urunduzenle=$db->prepare("UPDATE urun set 

        urun_stok=:urun_stok

        where urun_id={$uruncek['urun_id']}");
      $update=$urunduzenle->execute(array(


        'urun_stok' => $uruncek['urun_stok']-$sepetcek['urun_adet']

      ));

      $renkduzenle=$db->prepare("UPDATE renk set 

        renk_stok=:renk_stok

        where renk_id={$renkcek['renk_id']}");
      $update=$renkduzenle->execute(array(


        'renk_stok' => $renkcek['renk_stok']-$sepetcek['urun_adet']

      ));
    }
    if ($insert2) {
      //sepet silme, ürün adet düşme ve kupon varsa kupon adeti düşme

      $sil=$db->prepare("DELETE from sepet where kullanici_id=:id");
      $kontrol=$sil->execute(array(
        'id'=>$kullanici_id

      ));

      $kaydet=$db->prepare("INSERT into bildirim set

       bildirim_ad=:bildirim_ad,
       bildirim_detay=:bildirim_detay,
       bildirim_url=:bildirim_url,
       kullanici_id=:kullanici_id,
       bildirim_durum=:bildirim_durum
       ");

      $insert2=$kaydet->execute(array(

        'bildirim_ad' => "Tebrikler",
        'bildirim_detay' => "Siparişin Alındı",
        'bildirim_url' => "siparislerim.php",
        'kullanici_id' => $kullanici_id,
        'bildirim_durum' => 1

      ));
      

      if ($_POST['kupon_indirim']>0) {

        $kuponsor=$db->prepare("SELECT * FROM kupon where kupon_keyword=:keyword");
        $kuponsor->execute(array(
          'keyword'=>$_POST['kupon_ozel']
        ));
        $kuponcek=$kuponsor->fetch(PDO::FETCH_ASSOC);
        $kuponduzenle=$db->prepare("UPDATE kupon set 

          kupon_adet=:kupon_adet

          where kupon_id={$kuponcek['kupon_id']}");
        $update=$kuponduzenle->execute(array(


          'kupon_adet' => $kuponcek['kupon_adet']-1

        ));
      }

      
      if ($kontrol) {

        header("location:../../siparislerim.php?ekle=ok");
      }else {
        header("location:../../siparislerim.php?ekle=no");
      }





    }else{
      header("location:../../odeme.php?durum=no");
      exit;
    }

  }else{

    header("location:../../odeme.php?durum=no");
    exit;
  }
}
}


if (isset($_POST['havaleetkin'])) {

  $yenideger=$_POST['entegre_havale'];
  $entegreduzenle=$db->prepare("UPDATE entegre set 

    entegre_havale=:entegre_havale

    where entegre_id={$_POST['entegre_id']}");
  $update=$entegreduzenle->execute(array(

    'entegre_havale' => $yenideger
  ));

  if ($update) {
   header("location:../production/entegre-ayar.php?durum=ok");
   exit;
 }else{

   header("location:../production/entegre-ayar?durum=no");
   exit;
 }

}

if (isset($_POST['kapidaetkin'])) {

  $yenideger=$_POST['entegre_kapida'];
  $entegreduzenle=$db->prepare("UPDATE entegre set 

    entegre_kapida=:entegre_kapida

    where entegre_id={$_POST['entegre_id']}");
  $update=$entegreduzenle->execute(array(

    'entegre_kapida' => $yenideger
  ));

  if ($update) {
   header("location:../production/entegre-ayar.php?durum=ok");
   exit;
 }else{

   header("location:../production/entegre-ayar?durum=no");
   exit;
 }

}

if (isset($_POST['kartetkin'])) {

  $yenideger=$_POST['entegre_kart'];
  $entegreduzenle=$db->prepare("UPDATE entegre set 

    entegre_kart=:entegre_kart

    where entegre_id={$_POST['entegre_id']}");
  $update=$entegreduzenle->execute(array(

    'entegre_kart' => $yenideger
  ));

  if ($update) {
   header("location:../production/entegre-ayar.php?durum=ok");
   exit;
 }else{

   header("location:../production/entegre-ayar?durum=no");
   exit;
 }

}

if (isset($_POST['siparisdurumdegistir'])) {
  $siparis_id=$_POST['siparis_id'];

  $siparissor2=$db->prepare("SELECT * FROM siparis where siparis_id=:id");
  $siparissor2->execute(array(
    'id' => $siparis_id

  ));
  $sipariscek2=$siparissor2->fetch(PDO::FETCH_ASSOC);

  $siparisduzenle=$db->prepare("UPDATE siparis set 

    siparis_durum=:siparis_durum
    where siparis_id={$siparis_id}");
  $update=$siparisduzenle->execute(array(

    'siparis_durum' => $_POST['siparisdurumdegistir']

  ));

  $kullanicisor2=$db->prepare("SELECT * FROM kullanici where kullanici_id=:id");
  $kullanicisor2->execute(array(
    'id' => $sipariscek2['kullanici_id']

  ));
  $kullanicicek2=$kullanicisor2->fetch(PDO::FETCH_ASSOC);

  $kaydet=$db->prepare("INSERT into bildirim set

   bildirim_ad=:bildirim_ad,
   bildirim_detay=:bildirim_detay,
   bildirim_url=:bildirim_url,
   kullanici_id=:kullanici_id,
   bildirim_durum=:bildirim_durum
   ");

  $insert2=$kaydet->execute(array(

    'bildirim_ad' => "Sipariş Durumu",
    'bildirim_detay' => "Sipariş Durumun Değişti. Öğrenmek İçin Tıkla!",
    'bildirim_url' => "siparislerim.php",
    'kullanici_id' => $kullanicicek2['kullanici_id'],
    'bildirim_durum' => 1

  ));

  if ($update) {
    echo "Kaydedildi.";
    header("location:../production/siparis.php?durum=ok");
    exit;
  }else{
    echo "Kaydedilemedi.";
    header("location:../production/siparis.php?durum=no");
    exit;
  }

}
if (isset($_POST['siparisdurumdegistir2'])) {

  $siparis_id=$_POST['siparis_id'];

  $siparissor2=$db->prepare("SELECT * FROM siparis where siparis_id=:id");
  $siparissor2->execute(array(
    'id' => $siparis_id

  ));
  $sipariscek2=$siparissor2->fetch(PDO::FETCH_ASSOC);

  $siparisduzenle=$db->prepare("UPDATE siparis set 

    siparis_durum=:siparis_durum
    where siparis_id={$siparis_id}");
  $update=$siparisduzenle->execute(array(

    'siparis_durum' => $_POST['siparisdurumdegistir']

  ));

  $kullanicisor2=$db->prepare("SELECT * FROM kullanici where kullanici_id=:id");
  $kullanicisor2->execute(array(
    'id' => $sipariscek2['kullanici_id']

  ));
  $kullanicicek2=$kullanicisor2->fetch(PDO::FETCH_ASSOC);

  $kaydet=$db->prepare("INSERT into bildirim set

   bildirim_ad=:bildirim_ad,
   bildirim_detay=:bildirim_detay,
   bildirim_url=:bildirim_url,
   kullanici_id=:kullanici_id,
   bildirim_durum=:bildirim_durum
   ");

  $insert2=$kaydet->execute(array(

    'bildirim_ad' => "Sipariş Durumu",
    'bildirim_detay' => "Sipariş Durumun Değişti. Öğrenmek İçin Tıkla!",
    'bildirim_url' => "siparislerim.php",
    'kullanici_id' => $kullanicicek2['kullanici_id'],
    'bildirim_durum' => 1

  ));

  if ($update) {
    echo "Kaydedildi.";
    header("location:../production/siparis-detay.php?siparis_id=$siparis_id&durum=ok");
    exit;
  }else{
    echo "Kaydedilemedi.";
    header("location:../production/siparis-detay.php?siparis_id=$siparis_id&durum=no");
    exit;
  }



}

if ($_GET['siparis_sil']=="ok") {
giriskontrol();
  $sil=$db->prepare("DELETE from siparis where siparis_id=:id");
  $kontrol=$sil->execute(array(
    'id'=>$_GET['siparis_id']

  ));
  if ($kontrol) {
    $siparisdetaysor=$db->prepare("SELECT * FROM siparisdetay where siparis_id=:id");
    $siparisdetaysor->execute(array(
      'id'=>$_GET['siparis_id']
    ));
    while ($siparisdetaycek=$siparisdetaysor->fetch(PDO::FETCH_ASSOC)) {

      $sil=$db->prepare("DELETE from siparisdetay where siparisdetay_id=:id");
      $kontrol=$sil->execute(array(
        'id'=>$siparisdetaycek['siparisdetay_id']
      ));
    }
    header("location:../production/siparis.php?sil=ok");

  }else {
    header("location:../production/siparis.php?sil=no");
    
  }

}

if(isset($_POST['urunfotosil'])) {
giriskontrol();
  $urun_id=$_POST['urun_id'];


   $checklist = $_POST['urunfotosec'];

  
  foreach($checklist as $list) {

    $sil=$db->prepare("DELETE from urunfoto where urunfoto_id=:urunfoto_id");
    $kontrol=$sil->execute(array(
      'urunfoto_id' => $list
    ));
  }

  if ($kontrol) {

    Header("Location:../production/urun-galeri.php?urun_id=$urun_id&durum=ok");

  } else {

    Header("Location:../production/urun-galeri.php?urun_id=$urun_id&durum=no");
  }


} 

if (isset($_POST['urunfotosirakaydet'])) {
  $urunfoto_id=$_POST['urunfoto_id'];
  $urun_id=$_POST['urun_id'];


  $urunfotoduzenle=$db->prepare("UPDATE urunfoto set 

    urunfoto_sira=:urunfoto_sira

    where urunfoto_id={$_POST['urunfoto_id']}");
  $update=$urunfotoduzenle->execute(array(

    'urunfoto_sira' => $_POST['urunfoto_sira']
  ));

  if ($update) {
   header("location:../production/urunfoto-duzenle.php?urun_id=$urun_id&durum=ok");
   exit;
 }else{

   header("location:../production/urunfoto-duzenle.php?urun_id=$urun_id&durum=no");
   exit;
 }

}


if (isset($_POST['sifremiunuttum'])) {
 $kullanici_mail=htmlspecialchars($_POST['kullanici_mail']);

 $token=0;
 $random1=0; $random2=0; $random3=0;
 $soru_cevap=$_POST['soru_cevap']; $kullanici_soru=htmlspecialchars($_POST['kullanici_soru']);
 $kullanicisor3=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail");
 $kullanicisor3->execute(array(
  'mail' => $kullanici_mail

));

 $kullanicicek3=$kullanicisor3->fetch(PDO::FETCH_ASSOC);
 if (empty($kullanicicek3)) {
  header("location:../../sifre-unuttum.php?durum=posta");
  exit;
}elseif($soru_cevap!=$kullanici_soru){
  header("location:../../sifre-unuttum.php?durum=soru");
  exit;
}else{
  $random1=rand(0,50000);
  $random2=rand(0,100000);
  $random3=rand(0,35000);
  $random4=rand(11,85000);

  require '../../mail/class.phpmailer.php';

  require '../../mail/PHPMailerAutoload.php';

  require '../../mail/class.smtp.php';  

  $mail = new PHPMailer;            

  $mail->IsSMTP();
      //$mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
  $mail->SMTPAuth = true;
      $mail->SMTPSecure = 'tls'; // Güvenli baglanti icin ssl normal baglanti icin tls
      $mail->Host = "smtp-relay.sendinblue.com"; // Mail sunucusuna ismi
      $mail->Port = 587; // Gucenli baglanti icin 465 Normal baglanti icin 587
      $mail->IsHTML(true);
      $mail->SetLanguage("tr", "phpmailer/language");
      $mail->CharSet  ="utf-8";
      $mail->Username = "asdpasd02@gmail.com"; // Mail adresimizin kullanicý adi
      $mail->Password = "d8YbAwUXhxGFvByf"; // Mail adresimizin sifresi
      $mail->SetFrom("asdpasd02@gmail.com","BabafiyatlarVİP"); // Mail attigimizda gorulecek ismimiz
      $mail->AddAddress($kullanicicek3['kullanici_mail'],$kullanicicek3['kullanici_ad']); // Maili gonderecegimiz kisi yani alici
      $mail->addReplyTo($kullanicicek3['kullanici_mail'], $kullanicicek3['kullanici_ad']);
      $mail->Subject = "Şifremi Unuttum"; // Konu basligi
      $mail->Body = "Merhaba"." ".$kullanicicek3['kullanici_ad']." <br /> Şifreni unuttuğunu öğrendik. Şifreni değiştirmen için sana link bıraktık. Linke tıklayarak yeni şifreni oluşturabilirsin.<br />"."<div style='background:#eee;padding:5px;margin:5px;width:300px;'> LİNK : "."<a href=http://babafiyatlarvip.rf.gd/eticaret/sifre-duzenle.php?token=".$random1.$random2.$random3.$random4.">http://babafiyatlarvip.rf.gd/eticaret/sifre-duzenle.php?token=".$random1.$random2.$random3.$random4."</a></div>"; 
      if(!$mail->Send()){

        echo 'mail gonderilemedi';

      }else { 
       $token=$random1.$random2.$random3.$random4;

       $kullaniciduzenle=$db->prepare("UPDATE kullanici set 

        kullanici_token=:kullanici_token
        where kullanici_id={$kullanicicek3['kullanici_id']}");
       $update=$kullaniciduzenle->execute(array(

        'kullanici_token' => $token

      ));
       $mail=$kullanicicek3['kullanici_mail'];
       header("location:../../sifre-unuttum.php?durum=ok&mail=$mail");


     }

   }

 }

 if (isset($_POST['tekrarsifregönder'])) {
  $mail=$_POST['kullanici_mail'];
  $soru_cevap=$_POST['soru_cevap']; $kullanici_soru=htmlspecialchars($_POST['kullanici_soru']);
  if($soru_cevap!=$kullanici_soru){
    header("location:../../sifre-unuttum.php?durum=soru");
    exit;
  }

  $kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail");
  $kullanicisor->execute(array(
    'mail' => $mail

  ));
  $kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);

  require '../../mail/class.phpmailer.php';

  require '../../mail/PHPMailerAutoload.php';

  require '../../mail/class.smtp.php';  

  $mail = new PHPMailer;            

  $mail->IsSMTP();
      //$mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
  $mail->SMTPAuth = true;
      $mail->SMTPSecure = 'tls'; // Güvenli baglanti icin ssl normal baglanti icin tls
      $mail->Host = "smtp-relay.sendinblue.com"; // Mail sunucusuna ismi
      $mail->Port = 587; // Gucenli baglanti icin 465 Normal baglanti icin 587
      $mail->IsHTML(true);
      $mail->SetLanguage("tr", "phpmailer/language");
      $mail->CharSet  ="utf-8";
      $mail->Username = "asdpasd02@gmail.com"; // Mail adresimizin kullanicý adi
      $mail->Password = "d8YbAwUXhxGFvByf"; // Mail adresimizin sifresi
      $mail->SetFrom("asdpasd02@gmail.com","BabafiyatlarVİP"); // Mail attigimizda gorulecek ismimiz
      $mail->AddAddress($kullanicicek['kullanici_mail'],$kullanicicek['kullanici_ad']); // Maili gonderecegimiz kisi yani alici
      $mail->addReplyTo($kullanicicek['kullanici_mail'], $kullanicicek['kullanici_ad']);
      $mail->Subject = "Şifremi Unuttum"; // Konu basligi
      $mail->Body = "Merhaba"." ".$kullanicicek['kullanici_ad']." <br /> Şifreni unuttuğunu öğrendik. Şifreni değiştirmen için sana link bıraktık. Linke tıklayarak yeni şifreni oluşturabilirsin.<br />"."<div style='background:#eee;padding:5px;margin:5px;width:300px;'> LİNK : "."<a href=http://babafiyatlarvip.rf.gd/eticaret/sifre-duzenle.php?token=".$kullanicicek['kullanici_token'].">http://babafiyatlarvip.rf.gd/eticaret/sifre-duzenle.php?token=".$kullanicicek['kullanici_token']."</a></div>"; 

      if(!$mail->Send()){

        echo 'mail gonderilemedi';

      }else{
       $mail=$kullanicicek['kullanici_mail'];
       header("location:../../sifre-unuttum.php?durum=ok&mail=$mail");
     }      

   }

   if (isset($_POST['yenisifregir'])) {


    if ($_POST['kullanici_newpassword']!=$_POST['kullanici_newpassword2']) {
      header("location:../../sifre-duzenle.php?durum=eslesmehata");
    }elseif(strlen($_POST['kullanici_newpassword'])<6){
      header("location:../../sifre-duzenle.php?durum=eksiksifre");
    } else{
      $kullanici_newpassword=htmlspecialchars($_POST['kullanici_newpassword']);
      $newpass=md5($kullanici_newpassword);
      $kullanici_id=$_POST['kullanici_id'];
      $kullaniciduzenle=$db->prepare("UPDATE kullanici set 

        kullanici_password=:kullanici_password

        where kullanici_id={$_POST['kullanici_id']}");
      $update=$kullaniciduzenle->execute(array(

        'kullanici_password'=>$newpass

      ));

      if ($update) {
       header("location:../../login.php?durum=ok");

     }else{
       header("location:../../login.php?durum=no");

     }
   }
 }

 if (isset($_POST['bildirimekle'])) {
   $kullanici_id=$_POST['kullanici_id'];

   if (empty($_POST['bildirim_ad']) or empty($_POST['bildirim_detay'])  or $_POST['bildirim_durum']==-1) {
    header("location:../production/bildirim-ekle.php?durum=no");
  } else{

    if ($kullanici_id=="all-id") {

     $kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_durum=:durum");
     $kullanicisor->execute(array(
      'durum' => 1

    ));

     while ($kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC)) {

      $kaydet=$db->prepare("INSERT into bildirim set

       bildirim_ad=:bildirim_ad,
       bildirim_detay=:bildirim_detay,
       bildirim_url=:bildirim_url,
       kullanici_id=:kullanici_id,
       bildirim_durum=:bildirim_durum

       ");

      $insert=$kaydet->execute(array(

        'bildirim_ad' => $_POST['bildirim_ad'],
        'bildirim_detay' => $_POST['bildirim_detay'],
        'bildirim_url' => $_POST['bildirim_url'],
        'kullanici_id' => $kullanicicek['kullanici_id'],
        'bildirim_durum' => $_POST['bildirim_durum']

      ));


    }

  }else{

   $kaydet=$db->prepare("INSERT into bildirim set

     bildirim_ad=:bildirim_ad,
     bildirim_detay=:bildirim_detay,
     bildirim_url=:bildirim_url,
     kullanici_id=:kullanici_id,
     bildirim_durum=:bildirim_durum

     ");

   $insert=$kaydet->execute(array(

    'bildirim_ad' => $_POST['bildirim_ad'],
    'bildirim_detay' => $_POST['bildirim_detay'],
    'bildirim_url' => $_POST['bildirim_url'],
    'kullanici_id' => $kullanici_id,
    'bildirim_durum' => $_POST['bildirim_durum']

  ));

 }
 if ($insert) {

  header("location:../production/bildirim.php?durum=ok");
  exit;
}else{

  header("location:../production/bildirim.php?durum=no");
  exit;
    }
  }
}

if ($_GET['bildirim']=="ok") {
 $url=$_GET['bildirim_url'];
 $id=$_GET['kullanici_id'];
 $bildirim_id=$_GET['bildirim_id'];

 $sil=$db->prepare("DELETE from bildirim where bildirim_id=:id");
 $kontrol=$sil->execute(array(
  'id'=>$bildirim_id

));

 if ($update) {
   header("location:../../$url");

 }else{
   header("location:../../$url");

 }

}

if ($_GET['bildirim_sil']=="ok") {
  giriskontrol();
  $sil=$db->prepare("DELETE from bildirim where bildirim_id=:id");
  $kontrol=$sil->execute(array(
    'id'=>$_GET['bildirim_id']

  ));
  if ($kontrol) {

    header("location:../production/bildirim.php?sil=ok");
  }else {
    header("location:../production/bildirim.php?sil=no");
  }


}


if (isset($_POST['iletisimgonder'])) {
 $kullanici_mail=$_POST['kullanici_mail'];
 $isim=$_POST['kullanici_adsoyad'];
 $detay=$_POST['kullanici_ileti'];
 $soru_input=$_POST['kullanici_soru'];
 $cevap=$_POST['soru_cevap'];

 if ($cevap!=$soru_input) {
  header("location:../../iletisim.php?durum=soru");
  exit;
}

require '../../mail/class.phpmailer.php';

require '../../mail/PHPMailerAutoload.php';

require '../../mail/class.smtp.php';  

$mail = new PHPMailer;            

$mail->IsSMTP();
      //$mail->SMTPDebug = 1; // hata ayiklama: 1 = hata ve mesaj, 2 = sadece mesaj
$mail->SMTPAuth = true;
      $mail->SMTPSecure = 'tls'; // Güvenli baglanti icin ssl normal baglanti icin tls
      $mail->Host = "smtp-relay.sendinblue.com"; // Mail sunucusuna ismi
      $mail->Port = 587; // Gucenli baglanti icin 465 Normal baglanti icin 587
      $mail->IsHTML(true);
      $mail->SetLanguage("tr", "phpmailer/language");
      $mail->CharSet  ="utf-8";
      $mail->Username = "asdpasd02@gmail.com"; // Mail adresimizin kullanicý adi
      $mail->Password = "d8YbAwUXhxGFvByf"; // Mail adresimizin sifresi
      $mail->From     = "asdpasd02@gmail.com";
      $mail->SetFrom($kullanici_mail,"BabafiyatlarVİP"); // Mail attigimizda gorulecek ismimiz
      $mail->AddAddress("asdpasd02@gmail.com","Kullanıcı İletisi"); // Maili gonderecegimiz kisi yani alici
      $mail->Subject = $isim."-"."Müşteri İletişim"; // Konu basligi
      $mail->Body = "<div style='background:#eee;padding:5px;margin:5px;width:300px;'> "."Gönderen: ".$kullanici_mail."<br>"."$detay"."</div>"; 

      if(!$mail->Send()){

        echo 'mail gonderilemedi';

      }else{
       header("location:../../iletisim.php?durum=ok");
       exit;
     }      



   }




   ?>