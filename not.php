<?php
$config = include('config.php');
$hesaplar = include('hesaplar.php');

if(is_array($hesaplar)){
    include("class.php");
    $not = new not();

    foreach($hesaplar as $hesap){
        $username = $hesap['username'];
        $password = $hesap['password'];
        $email = $hesap['email'];
        $sendemail = $hesap['sendemail'];

        //Kullanıcı adına uygun bir txt dosyası açıyoruz.
        if (!is_file("esogu_" . $username . ".txt")) {
            fopen("esogu_" . $username . ".txt", "w");
        }
        //Açtığımız dosyanın içeriğini alıyoruz.
        //Aldığımız içerik, md5 formatında.
        $filemd5 = file_get_contents("esogu_" . $username . ".txt");

        //Sınav sonuçları sayfasının html kodlarını alıyoruz.
        $sonuc = $not->esogu_sinavsonuc($username, $password, $config['yil']);
        if ($sonuc == "null") {
            die("error");
        }

        //ESOGUBS'den dönen sonucun md5 halini açtığımız txt dosyasına kaydediyoruz.
        $sonucmd5 = md5($sonuc);
        file_put_contents("esogu_" . $username . ".txt", $sonucmd5);

        //Eğer esogubs den gelen sonuç md5 değeri ile, dosyamızdaki md5 değeri eşleşmiyorsa, bir değişiklik var demektir.
        if ($sonucmd5 != $filemd5) {
            //Mail gönderilmesini istemişsek bir mail göndereceğiz.
            if ($sendemail == 1) {
                $mailhtml = 'Bu mail esogu bilgi sisteminde yeni bir sinav sonucu olabilecegine dair gonderildi. (Olmaya da bilir)<br><br><br>
                ' . $sonuc;
                mail($email,'Sinav sonuclari sayfanda bir degisiklik var',$mailhtml);
                /*
                require 'mailer/PHPMailerAutoload.php';
                $mail = new PHPMailer;

                $mail->isMail();
                $mail->From = 'sinav@guvenatbakan.com';
                $mail->FromName = 'Esogu Sinav';
                $mail->addAddress($email, $email); // Add a recipient
                //$mail->WordWrap = 50; // Set word wrap to 50 characters
                $mail->Subject = 'Sinav aciklanmis olabilir';
                $mail->Body = '
                Bu mail esogu bilgi sisteminde yeni bir sinav sonucu olabilecegine dair gonderildi.<br><br><br>
                ' . $sonuc;
                $mail->isHTML(true);
                $mailstatus = $mail->send();
                if(!$mailstatus){
                    echo 'Message could not be sent.';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                    exit;
                }*/
            }
            //Sonuç olarak değişiklik olduğundan dolayı ekrana true yazdırıyoruz.
            die("true");
        } else {
            //Değişiklik olmadığı için ekrana false yazdırıyoruz.
            die("false");
        }
    }
}


