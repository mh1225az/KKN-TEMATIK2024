<?php
include 'config.php';
$NILAI = array(
    1 => 'Sangat Rendah',
    2 => 'Rendah',
    3 => 'Cukup',
    4 => 'Tinggi',
    5 => 'Sangat Tinggi'
);

$rows = $db->get_results("SELECT kode_alternatif, nama_alternatif FROM tb_alternatif ORDER BY kode_alternatif");
foreach($rows as $row){
    $ALTERNATIF[$row->kode_alternatif] = $row->nama_alternatif;
}

$rows = $db->get_results("SELECT kode_kriteria, nama_kriteria,bobot,atribut FROM tb_kriteria ORDER BY kode_kriteria");
foreach($rows as $row){
    $KRITERIA[$row->kode_kriteria] = array(
        'nama_kriteria'=>$row->nama_kriteria,
        'bobot'=>$row->bobot,
        'atribut'=>$row->atribut
    );
}

function get_rank($array){
    $data = $array;
    arsort($data);
    $no=1;
    $new = array();
    foreach($data as $key => $value){
        $new[$key] = $no++;
    }
    return $new;
}

function sub_kriteria(){
    global $db;
    $rows = $db->get_results("SELECT * FROM tb_subkriteria ORDER BY kode_subkriteria");
    $data= array();
    foreach($rows as $row){
        $data[$row->kode_subkriteria] = $row;
    }
    return $data;
}

function get_hasil_analisa(){
    global $db;
    $rows = $db->get_results("SELECT a.kode_alternatif, k.kode_kriteria,ra.kode_subkriteria
        FROM tb_alternatif a 
        INNER JOIN tb_rel_alternatif ra ON ra.kode_alternatif=a.kode_alternatif
        INNER JOIN tb_kriteria k ON k.kode_kriteria=ra.kode_kriteria
        LEFT JOIN tb_subkriteria c ON c.kode_subkriteria=ra.kode_subkriteria
        ORDER BY a.kode_alternatif, k.kode_kriteria");
    $data = array();
    foreach($rows as $row){
        $data[$row->kode_alternatif][$row->kode_kriteria] = $row->kode_subkriteria;
    }
    return $data;
}

// =============WP===============//
function get_bobot_kepentingan($array)
{
    global $db,$KRITERIA;
    $data = array();
    $total = 0;
    foreach ($KRITERIA as $key => $value) {
        $total+=$array[$key];
    }
    foreach ($KRITERIA as $key => $value) {
        $data['kepentingan'][$key] = $array[$key];
        $data['bobot'][$key] = $array[$key]/$total;
        if($value['atribut']=='Benefit'){
            $data['pangkat'][$key] = $array[$key]/$total;
        }else{
            $data['pangkat'][$key]=(-1*$array[$key]/$total);
        }

    }
    return $data;
}

function get_vektor($relasi,$bobot_kepentingan)
{
    global $db,$KRITERIA,$ALTERNATIF;
    $sub_kriteria = sub_kriteria();

    $rows = $relasi;
    $bobot = $bobot_kepentingan; 
    $data = array();
    $vektor = array();
    foreach ($rows as $key => $value) {
        $nilai_total = 1;
        foreach ($value as $k => $v) {
            $nilai_total= $nilai_total * pow($sub_kriteria[$v]->nilai,$bobot['pangkat'][$k]);
        }
        $data[$key] = $nilai_total;   
    }
    foreach ($data as $key => $value) {
       $vektor[$key]['s'] = $value;
       $vektor[$key]['v'] = $value/array_sum($data);
    }

    return $vektor;
}

// ====================================//
// =================WP================//
 function bobot_normal()
    {
        global $db,$KRITERIA;
        $array = $KRITERIA;    
        $total=0;
        $get_bobot = array();
        foreach ($array as $key => $value) {
            $total+=$value['bobot']; 
        } 
        foreach ($array as $key => $value) {
            $get_bobot[$key]=$value['bobot']/$total; 
        }

        return $get_bobot;
        
    }



    function get_normal($relasi,$bobot)
    {
        foreach ($relasi as $key => $value) {
            foreach ($value as $k => $v) {
                 $matriks[$key][$k]=(max($value)-$bobot[$k])/(max($value)-min($value));
            }
           
        }
        return $matriks;
    }

    function get_total($normalisasi = array())
    {
        foreach ($normalisasi as $key => $value) {
            $matriks[$key]=array_sum($value);
        }
        return $matriks;
    }

    
     function get_rank_smart($new_data = array()){
        $data = $new_data;
        $newdata = array();
        foreach ($data as $key => $value) {
            $newdata[$key]=$value;
        }
        arsort($newdata);
        $no=1;
        $new = array();
        foreach($newdata as $key => $value){
            $new[$key] = $no++;
        }
        return $new;
    }

    // =====================================================//

function get_atribut_option($selected = ''){
    $atribut = array('Benefit'=>'Benefit', 'Cost'=>'Cost');   
    foreach($atribut as $key => $value){
        if($selected==$key)
            $a.="<option value='$key' selected>$value</option>";
        else
            $a.= "<option value='$key'>$value</option>";
    }
    return $a;
}

function get_kriteria_option($selected = 0){
    global $KRITERIA;  
    print_r($KRITERIA);
    foreach($KRITERIA as $key => $value){
        if($key==$selected)
            $a.="<option value='$key' selected>$value[nama_kriteria]</option>";
        else
            $a.="<option value='$key'>$value[nama_kriteria]</option>";
    }
    return $a;
}

function get_bobot_option($selected = ''){
    global $NILAI;    
    foreach($NILAI as $key => $value){
        if($selected==$key)
            $a.="<option value='$key' selected>$key - $value</option>";
        else
            $a.= "<option value='$key'>$key - $value</option>";
    }
    return $a;
}
