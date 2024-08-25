 <h4 class="page-head-line">PERHITUNGAN</h4>
<div class="panel panel-primary">
    <div class="panel-heading">Masukan Nilai Kepentingan</div>
    <div class="panel-body"> 
        <form class="form-inline" method="POST">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Kriteria</th>
                            <?php 
                            foreach ($KRITERIA as $kt):?>
                                <th><?=$kt['nama_kriteria']?></th>
                            <?php endforeach;?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Kepentingan</th>
                            <?php
                            $NO=1;
                            foreach ($KRITERIA as $kt => $val):?>
                                <td><input type="text" name="bobot[<?=$kt?>]" class="form-control" value="<?=$val['bobot']?>"/></td>
                            <?php endforeach;?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel-footer">
            <button class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Hitung</button>
        </div>

    </form>

</div>
<?php if($_POST):
    $bobot = (array)$_POST['bobot'];
    $bobot_kepentingan=get_bobot_kepentingan($bobot);
    $matriks=get_hasil_analisa();
    $vektor=get_vektor($matriks,$bobot_kepentingan);
    $rank = get_rank($vektor);
    ?>
    <div class="panel panel-primary">
        <div class="panel-heading">Metode WP</div>
        <div class="panel-body"> 

            <div class="panel panel-primary">
                <div class="panel-heading">Bobot Kepentingan</div>
                <div class="panel-body"> 
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Kriteria</th>
                                <?php foreach ($KRITERIA as $kt):?>
                                    <th><?=$kt['nama_kriteria']?></th>
                                <?php endforeach;?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Kepentingan</th>
                                <?php foreach ($bobot_kepentingan['kepentingan'] as $kt => $value):?>
                                    <td><?=round($value,2)?></td>
                                <?php endforeach;?>
                            </tr>
                            <tr>
                                <th>Bobot</th>
                                <?php foreach ($bobot_kepentingan['bobot'] as $kt => $value):?>
                                    <td><?=round($value,2)?></td>
                                <?php endforeach;?>
                            </tr>
                            <tr>
                                <th>Pangkat</th>
                                <?php foreach ($bobot_kepentingan['pangkat'] as $kt => $value):?>
                                    <td><?=round($value,2)?></td>
                                <?php endforeach;?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">Hasil Analisa</div>
                <div class="panel-body">
                    <div class="table-responsive">
                       <table class="table table-bordered table-striped table-hover">
                        <tr><thead>
                            <th></th>
                            <?php 
                            $sub_kriteria = sub_kriteria();
                            foreach ($KRITERIA as $kt):?>
                                <th><?=$kt['nama_kriteria']?></th>
                            <?php endforeach;?>
                        </thead></tr>    
                        <?php foreach($matriks as $key => $val):?>
                            <tr>
                                <th><?=$ALTERNATIF[$key]?></th>
                                <?php foreach($val as $k => $v):?>
                                    <td><?=$sub_kriteria[$v]->keterangan?></td>
                                <?php endforeach?>  
                            </tr>
                        <?php endforeach?>        
                    </table>
                    <table class="table table-bordered table-striped table-hover">
                        <tr><thead>
                            <th></th>
                            <?php 
                            foreach ($KRITERIA as $kt):?>
                                <th><?=$kt['nama_kriteria']?></th>
                            <?php endforeach;?>
                        </thead></tr>    
                        <?php foreach($matriks as $key => $val):?>
                            <tr>
                                <th><?=$ALTERNATIF[$key]?></th>
                                <?php foreach($val as $k => $v):?>
                                    <td><?=$sub_kriteria[$v]->nilai?></td>
                                <?php endforeach?>  
                            </tr>
                        <?php endforeach?>        
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">Hasil Vektor S dan V</div>
            <div class="panel-body"> 
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Alternatif</th>
                                <th>Vektor S</th>
                                <th>Vektor V</th>

                            </tr>   
                        </thead> 
                        <?php foreach($vektor as $key => $val):?>
                            <tr>
                                <th><?=$key?>-<?=$ALTERNATIF[$key]?></th>
                                <td><?=$val['s']?></td>
                                <td><?=$val['v']?></td>
                            </tr>
                        <?php endforeach?>  
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">Perangkingan</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <th>Nama</th>
                            <th>Total</th>
                            <th>Rank</th>
                            <th>Status</th>
                        </tr>
                        <?php  
                        foreach($rank as $key => $val): ?>
                            <tr>                
                                <td><?=$key?>-<?=$ALTERNATIF[$key]?></td>                
                                <td class="text-primary"><?=round($vektor[$key]['v'], 4)?></td>
                                <td class='text-primary'><?=$val?> </td>
                                <td class='text-primary'><?=($vektor[$key]['v']>=0.02)?'Layak':'Tidak Layak'?> </td>
                            </tr>                
                        <?php endforeach?>
                    </table>                           
                </div>
            </div>
        </div>

    </div>
</div>
<?php endif;?>