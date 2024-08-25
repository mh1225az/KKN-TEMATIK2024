<?php
require_once'functions.php';

if ($act=='login'){
    $user = esc_field($_POST[user]);
    $pass = esc_field($_POST[pass]);
    
    $row = $db->get_row("SELECT * FROM tb_admin WHERE user='$user' AND pass='$pass'");
    if($row){
        $_SESSION[login] = $row->user;
        redirect_js("index.php");
    } else{
        print_msg("Salah kombinasi username dan password.");
    }          
} elseif($act=='logout'){
    unset($_SESSION[login]);
    header("location:login.php");
}

    /** LOGIN */ 
    if ($mod=='password'){
        $pass1 = $_POST[pass1];
        $pass2 = $_POST[pass2];
        $pass3 = $_POST[pass3];
        
        $row = $db->get_row("SELECT * FROM tb_admin WHERE user='$_SESSION[login]' AND pass='$pass1'");        
        
        if($pass1=='' || $pass2=='' || $pass3=='')
            print_msg('Field bertanda * harus diisi.');
        elseif(!$row)
            print_msg('Password lama salah.');
        elseif( $pass2 != $pass3 )
            print_msg('Password baru dan konfirmasi password baru tidak sama.');
        else{        
            $db->query("UPDATE tb_admin SET pass='$pass2' WHERE user='$_SESSION[login]'");                    
            print_msg('Password berhasil diubah.', 'success');
        }
    } 
    
    /** ALTERNATIF */
    elseif($mod=='alternatif_tambah'){
        $kode = $_POST['kode'];
        $nama = $_POST['nama'];
        $keterangan = $_POST['keterangan'];
        if($kode=='' || $nama=='')
            print_msg("Field yang bertanda * tidak boleh kosong!");
        elseif($db->get_results("SELECT * FROM tb_alternatif WHERE kode_alternatif='$kode'"))
            print_msg("Kode sudah ada!");
        else{
            $db->query("INSERT INTO tb_alternatif (kode_alternatif, nama_alternatif, keterangan) VALUES ('$kode', '$nama', '$keterangan')");
            
            $db->query("INSERT INTO tb_rel_alternatif(kode_alternatif, kode_kriteria, kode_subkriteria) SELECT '$kode', kode_kriteria, -1 FROM tb_kriteria");       
            redirect_js("index.php?m=alternatif");
        }
    } else if($mod=='alternatif_ubah'){
        $kode = $_POST['kode'];
        $nama = $_POST['nama'];
        $keterangan = $_POST['keterangan'];
        if($kode=='' || $nama=='')
            print_msg("Field yang bertanda * tidak boleh kosong!");
        else{
            $db->query("UPDATE tb_alternatif SET nama_alternatif='$nama', keterangan='$keterangan' WHERE kode_alternatif='$_GET[ID]'");
            redirect_js("index.php?m=alternatif");
        }
    } else if ($act=='alternatif_hapus'){
        $db->query("DELETE FROM tb_alternatif WHERE kode_alternatif='$_GET[ID]'");
        $db->query("DELETE FROM tb_rel_alternatif WHERE kode_alternatif='$_GET[ID]'");
        header("location:index.php?m=alternatif");
    } 
    
    /** KRITERIA */    
    if($mod=='kriteria_tambah'){
        $kode = $_POST['kode'];
        $nama = $_POST['nama'];
        $atribut = $_POST['atribut'];
        $bobot = $_POST['bobot'];
        
        if($kode=='' || $nama=='' || $atribut=='' || $bobot=='')
            print_msg("Field bertanda * tidak boleh kosong!");
        elseif($db->get_results("SELECT * FROM tb_kriteria WHERE kode_kriteria='$kode'"))
            print_msg("Kode sudah ada!");
        else{
            $db->query("INSERT INTO tb_kriteria (kode_kriteria, nama_kriteria, atribut, bobot) VALUES ('$kode', '$nama', '$atribut', '$bobot')");
            $id = $db->insert_id;        
            $db->query("INSERT INTO tb_rel_alternatif(kode_alternatif, kode_kriteria, kode_subkriteria) SELECT kode_alternatif, '$id', -1  FROM tb_alternatif");           
            redirect_js("index.php?m=kriteria");
        }                    
    } else if($mod=='kriteria_ubah'){
        $kode = $_POST['kode'];
        $nama = $_POST['nama'];
        $atribut = $_POST['atribut'];
        $bobot = $_POST['bobot'];
        
        if($kode=='' || $nama=='' || $atribut=='' || $bobot=='')
            print_msg("Field bertanda * tidak boleh kosong!");
        else{
            $db->query("UPDATE tb_kriteria SET nama_kriteria='$nama', atribut='$atribut', bobot='$bobot' WHERE kode_kriteria='$_GET[ID]'");
            redirect_js("index.php?m=kriteria");
        }    
    } else if ($act=='kriteria_hapus'){
        $db->query("DELETE FROM tb_kriteria WHERE kode_kriteria='$_GET[ID]'");
        $db->query("DELETE FROM tb_rel_alternatif WHERE kode_kriteria='$_GET[ID]'");
        header("location:index.php?m=kriteria");
    } 
        
    /** RELASI ALTERNATIF */ 
    else if ($act=='rel_alternatif_ubah'){
    foreach($_POST as $key => $value){
        $ID = str_replace('ID-', '', $key);
        $db->query("UPDATE tb_rel_alternatif SET kode_subkriteria='$value' WHERE ID='$ID'");
    }
    header("location:index.php?m=rel_alternatif");
}


    /** subkriteria */    
if($mod=='subkriteria_tambah'){
    $nilai = $_POST['nilai'];
    $keterangan = $_POST['keterangan'];
    
    if($nilai=='' || $keterangan=='')
        print_msg("Nilai dan nama tidak boleh kosong!");
    else{
        $db->query("INSERT INTO tb_subkriteria (kode_kriteria, nilai, keterangan) VALUES ('$_POST[kode_kriteria]', '$nilai', '$keterangan')");           
        redirect_js("index.php?m=subkriteria&kode_kriteria=$_GET[kode_kriteria]");
    }                  
} else if($mod=='subkriteria_ubah'){
    $nilai = $_POST['nilai'];
    $keterangan = $_POST['keterangan'];
    
    if($nilai=='' || $keterangan=='')
        print_msg("Nilai dan nama tidak boleh kosong!");
    else{
        $db->query("UPDATE tb_subkriteria SET nilai='$nilai', keterangan='$keterangan' WHERE kode_subkriteria='$_GET[ID]'");
        redirect_js("index.php?m=subkriteria&kode_kriteria=$_GET[kode_kriteria]");
    }   
} else if ($act=='subkriteria_hapus'){
    $db->query("DELETE FROM tb_subkriteria WHERE kode_subkriteria='$_GET[ID]'");
    header("location:index.php?m=subkriteria&kode_kriteria=$_GET[kode_kriteria]");
}               
?>
