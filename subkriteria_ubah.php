<?php
    $row = $db->get_row("SELECT * FROM tb_subkriteria WHERE kode_subkriteria='$_GET[ID]'"); 
?>
<div class="page-header">
    <h1>Ubah Subkriteria</h1>
</div>
<div class="row">
<div class="col-sm-6">
<?php if($_POST) include'aksi.php'?>
<form method="post" action="?m=subkriteria_ubah&ID=<?=$row->kode_subkriteria?>&kode_kriteria=<?=$row->kode_kriteria?>">
<div class="form-group">
    <label>Kriteria</label>
    <select disabled="" class="form-control" name="kode_kriteria"><?=get_kriteria_option($row->kode_kriteria)?></select>
</div>
<div class="form-group">
    <label>Nama</label>
    <input class="form-control" type="text" name="keterangan" value="<?=$row->keterangan?>" />
</div>
<div class="form-group">
    <label>Nilai</label>
    <input class="form-control" type="text" name="nilai" value="<?=$row->nilai?>" />
</div>
<button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
<a class="btn btn-danger" href="?m=subkriteria&kode_kriteria=<?=$_GET[kode_kriteria]?>"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
</form>
</div>
</div>
