<?php

class not{

    var $username;
    var $password;
    var $agent;

    function __constructor(){
        $this->agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3 (FM Scene 4.6.1)';
    }

    function esogukontrol($username,$password,$season){
        if($username != "121620093005")
            return null;
        $postfields = "param01=".$username."&param02=".$password;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 1); // Get the header
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Allow redirection
        curl_setopt($ch, CURLOPT_USERAGENT, $this->agent);
        curl_setopt($ch, CURLOPT_COOKIEJAR, "/tmp/cookie");
        curl_setopt($ch, CURLOPT_URL,"http://esogubsweb1.ogu.edu.tr:7777/pls/osmangaziuniversitesibilgisistemi/ASP.pageid");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$postfields");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $source = curl_exec($ch);

        //echo $source;

        // Sınav sonuç sayfasını post ederek açıyoruz!
        $asd = explode('param02',$source);$dsa = explode('=',$asd[1]);$csa = explode('"',$dsa[1]);$param02 = $csa[0];
        if ($param02 == "")
            return 'null';
        $postfields = "param01=".$username."&param02=$param02&param04=$season";
        curl_setopt($ch, CURLOPT_HEADER, 0); // Get the header
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Allow redirection
        curl_setopt($ch, CURLOPT_USERAGENT, $this->agent);
        curl_setopt($ch, CURLOPT_COOKIEJAR, "/tmp/cookie");
        curl_setopt($ch, CURLOPT_URL,"http://esogubsweb1.ogu.edu.tr:7777/pls/osmangaziuniversitesibilgisistemi/ASP.pageid_000080?param01=".$username."&param02=$param02");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$postfields");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $source = curl_exec($ch);
        curl_close($ch);

        $bizimkod = explode('<BLOCKQUOTE>',$source);
        $bizimkod2= explode('</BLOCKQUOTE>',$bizimkod[1]);
        $source = str_replace($param02,"",$bizimkod2[0]);

        $source = preg_replace('#<form.*</form>#is', '', $source);
        $source = preg_replace("/\<a(.*)\>(.*)\<\/a\>/iU", "$2", $source);

        if (trim($source) != ""){
            return 'dolu';
        }else{
            return 'null';
        }
    }

    function esogu_sinavsonuc($username,$password,$season){
        if($username != "121620093005")
            return null;
        // Login oluyoruz!
        $postfields = "param01=".$username."&param02=".$password;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 1); // Get the header
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Allow redirection
        curl_setopt($ch, CURLOPT_USERAGENT, $this->agent);
        curl_setopt($ch, CURLOPT_COOKIEJAR, "/tmp/cookie");
        curl_setopt($ch, CURLOPT_URL,"http://esogubsweb1.ogu.edu.tr:7777/pls/osmangaziuniversitesibilgisistemi/ASP.pageid");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$postfields");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $source = curl_exec($ch);

        // Sınav sonuç sayfasını post ederek açıyoruz!
        $asd = explode('param02',$source);$dsa = explode('=',$asd[1]);$csa = explode('"',$dsa[1]);$param02 = $csa[0];
        $postfields = "param01=".$username."&param02=$param02&param04=$season";
        curl_setopt($ch, CURLOPT_HEADER, 0); // Get the header
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Allow redirection
        curl_setopt($ch, CURLOPT_USERAGENT, $this->agent);
        curl_setopt($ch, CURLOPT_COOKIEJAR, "/tmp/cookie");
        curl_setopt($ch, CURLOPT_URL,"http://esogubsweb1.ogu.edu.tr:7777/pls/osmangaziuniversitesibilgisistemi/ASP.pageid_000080?param01=".$username."&param02=$param02");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$postfields");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $source = curl_exec($ch);
        curl_close($ch);

        $bizimkod = explode('<BLOCKQUOTE>',$source);
        $bizimkod2= explode('</BLOCKQUOTE>',@$bizimkod[1]);
        // her zaman değişken olan param02 siliniyor ki, değişiklik olarak algılanmasın.
        $source = str_replace($param02,"",$bizimkod2[0]);
        //TODO: Burada <FORM ..... </FORM> içeriği silinecek.
        //$source = preg_replace("#((<[\s\/]*form\b[^>]*>)([^>]*)(<\/form>))#is","",$source);
        $source = preg_replace('#<form.*</form>#is', '', $source);
        //$source = preg_replace("/\<a(.*)\>(.*)\<\/a\>/iU", "$2", $source);
        //$source = str_replace("Sınav sonuçlarına ait detaylı bilgi için (ortalama, dağılım) ilgili sınav adına tıklayınız.","",$source);

        $source = '
        <script type="text/javascript">
            function window_open(url_name, byk)
            {
                var i;
                if (byk==1)
                {window.open(url_name,"kkhbc","toolbar=0,location=0,history=0,directories=0,status=,menubar=0,scrollbars=1,resizable=no,width=800,height=600");}
                if (byk==2)
                {window.open(url_name,"kkhbc","toolbar=0,location=0,history=0,directories=0,status=,menubar=0,scrollbars=1,resizable=no,width=350,height=400");}
                if (byk==3)
                {window.open(url_name,"kkhbc","toolbar=0,location=0,history=0,directories=0,status=,menubar=0,scrollbars=1,resizable=no,width=800,height=600");}
            }
        </script>
        '.$source;
        return $source;
    }

}
