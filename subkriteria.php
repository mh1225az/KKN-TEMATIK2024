<div class="page-header">
    <h1>Nilai Subkriteria</h1>
</div>
<div class="panel panel-default">
<div class="panel-heading">
<form class="form-inline">
    <input type="hidden" name="m" value="subkriteria" />
    <div class="form-group">
        <select class="form-control" name="kode_kriteria" onchange="this.form.submit()">
        <option value="">Pilih kriteria</option>
        <?=get_kriteria_option($_GET['kode_kriteria'])?>
        </select>
    </div>
    <div class="form-group">
        <a class="btn btn-primary" href="?m=subkriteria_tambah&kode_kriteria=<?=$_GET[kode_kriteria]?>"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
    </div>
</form>
</div>
<table class="table table-bordered table-hover table-striped">
<thead>
    <tr>
        <th>No</th>
        <th>Kode Subkriteria</th>
        <th>Nama Kriteria</th>
        <th>Keterangan</th>
        <th>Nilai</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
<?php
$q = esc_field($_GET['q']);
$rows = $db->get_results("SELECT c.kode_subkriteria, c.kode_kriteria, k.nama_kriteria, c.keterangan, c.nilai FROM tb_subkriteria c INNER JOIN tb_kriteria k ON k.kode_kriteria=c.kode_kriteria WHERE c.kode_kriteria='$_GET[kode_kriteria]' ORDER BY k.nama_kriteria, nilai");
$no=1;
foreach($rows as $row):?>
<tr>
    <td><?=$no++?></td>
    <td><?=$row->kode_subkriteria?></td>
    <td><?=$row->nama_kriteria?></td>
    <td><?=$row->keterangan?></td>
    <td><?=$row->nilai?></td>
    <td>
        <a class="btn btn-xs btn-warning" href="?m=subkriteria_ubah&ID=<?=$row->kode_subkriteria?>&kode_kriteria=<?=$row->kode_kriteria?>"><span class="glyphicon glyphicon-edit"></span></a>
        <a class="btn btn-xs btn-danger" href="aksi.php?act=subkriteria_hapus&ID=<?=$row->kode_subkriteria?>&kode_kriteria=<?=$row->kode_kriteria?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span></a>
    </td>
</tr>
<?php endforeach;
?>
</tbody>
</table>
</div>