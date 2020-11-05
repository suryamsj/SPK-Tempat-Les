<?php
require("../controller/Kriteria.php");

$kriteria = Index("SELECT * FROM kriteria");
$alternatif = Index("SELECT * FROM alternatif");
$bobot = Index("SELECT * FROM pembobotan");
$maxkriteria = Index("SELECT SUM(bobot) AS Total FROM kriteria");
$test = [];
$varV = [];
$totalS = 0;
?>
<section class="section">
    <div class="container">
        <div class="row">
            <div class="columns">
                <div class="column">
                    <div class="card animate__animated animate__zoomIn">
                        <div class="card-header">
                            <p class="card-header-title">Table penilaian</p>
                        </div>
                        <div class="card-content">
                            <div class="table-container">
                                <table class="table is-fullwidth">
                                    <thead class="has-background-success">
                                        <tr>
                                            <th class="has-text-white">No</th>
                                            <th class="has-text-white">Alternatif</th>
                                            <?php foreach ($kriteria as $header) : ?>
                                                <th class="has-text-white"><?= $header["nm_kriteria"] ?></th>
                                            <?php endforeach ?>
                                        </tr>
                                    </thead>
                                    <tfoot class="has-background-success">
                                        <tr>
                                            <th class="has-text-white">No</th>
                                            <th class="has-text-white">Alternatif</th>
                                            <?php foreach ($kriteria as $header) : ?>
                                                <th class="has-text-white"><?= $header["nm_kriteria"] ?></th>
                                            <?php endforeach ?>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $a = 1 ?>
                                        <?php foreach ($alternatif as $row) : ?>
                                            <tr>
                                                <th><?= $a++ ?></th>
                                                <td><?= $row["nm_les"] ?></td>
                                                <?php foreach ($bobot as $pembobot) : ?>
                                                    <?php if ($pembobot["id_les"] == $row["id_les"]) : ?>
                                                        <td><?= $pembobot["nilai"] ?></td>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                            <hr>

                            <!-- BAGIAN -->
                            <h4 class="subtitle">Bagian 1 : Mencari Nilai W</h4>
                            <hr>
                            <p>Bobot Tiap Kriteria :</p>
                            <p>W = [
                                <?php foreach ($kriteria as $tampildoang) : ?>
                                    <?= $tampildoang["bobot"] . "," ?>
                                <?php endforeach ?>
                                ]
                            </p>
                            <hr>
                            <p>Pembobotan :</p>
                            <?php $b = 1 ?>
                            <?php foreach ($kriteria as $bagibobot) : ?>
                                <?php foreach ($maxkriteria as $TotalLah) : ?>
                                    <p>W<?= $b++ ?> =
                                        <?= $bagibobot["bobot"] . "/" . $TotalLah["Total"] ?> = <?= round($bagibobot["bobot"] / $TotalLah["Total"], 3) ?>
                                    </p>
                                <?php endforeach ?>
                            <?php endforeach ?>
                            <hr>
                            <p>Normalisasi Berdasarkan Pembobotan :</p>
                            <?php $c = 1 ?>
                            <?php foreach ($kriteria as $bagibobot) : ?>
                                <?php foreach ($maxkriteria as $TotalLah) : ?>
                                    <p>W<?= $c++ ?> =
                                        <?php if ($bagibobot["status"] == "COST") : ?>
                                            <?= round($bagibobot["bobot"] / $TotalLah["Total"], 3) * -1 ?></p>
                                <?php else : ?>
                                    <?= round($bagibobot["bobot"] / $TotalLah["Total"], 3) ?></p>
                                <?php endif ?>
                            <?php endforeach ?>
                        <?php endforeach ?>
                        <hr>

                        <!-- BAGIAN 2 -->
                        <h4 class="subtitle">Bagian 2 : Mencari Nilai Vector (S)</h4>
                        <p>Pembobotan :</p>
                        <?php $d = 1 ?>
                        <?php $e = 0 ?>
                        <?php foreach ($alternatif as $les) : ?>
                            <?php $idles = $les["id_les"] ?>
                            <?php $bobot = Index("SELECT * FROM pembobotan WHERE id_les = $idles"); ?>
                            <?php $test[$e] = 1 ?>
                            S<?= $d++ ?> =
                            <?php foreach ($bobot as $pembobot) : ?>
                                <?php $idbobot = $pembobot["id_kriteria"] ?>
                                <?php $kriteria = Index("SELECT * FROM kriteria WHERE id_kriteria = $idbobot"); ?>
                                <?php foreach ($kriteria as $bagibobot) : ?>
                                    <?php $maxkriteria = Index("SELECT SUM(bobot) AS Total FROM kriteria"); ?>
                                    <?php foreach ($maxkriteria as $TotalLah) : ?>
                                        <?php if ($bagibobot["status"] == "COST") : ?>
                                            (<?= $pembobot["nilai"] . "<sup>" . round($bagibobot["bobot"] / $TotalLah["Total"], 3) * -1 . "</sup>" ?>)
                                            <?php $test[$e] = $test[$e] * pow($pembobot["nilai"], round($bagibobot["bobot"] / $TotalLah["Total"], 3) * -1) ?>
                                        <?php else : ?>
                                            (<?= $pembobot["nilai"] . "<sup>" . round($bagibobot["bobot"] / $TotalLah["Total"], 3) . "</sup>" ?>)
                                            <?php $test[$e] = $test[$e] * pow($pembobot["nilai"], round($bagibobot["bobot"] / $TotalLah["Total"], 3)) ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                <?php endforeach ?>
                            <?php endforeach ?>
                            =
                            <?= round($test[$e], 3) ?>
                            <?php $totalS = $totalS + $test[$e] ?>
                            <?php $e++ ?>
                            <br>
                        <?php endforeach ?>
                        <hr>
                        <h4 class="subtitle">Bagian 3 : Mencari Nilai V (V)</h4>
                        <?php $f = 1 ?>
                        <?php $g = 0 ?>
                        <?php foreach ($test as $row) : ?>
                            <p>V<?= $f++ ?> = <?= round($test[$g], 3) . "/" . round($totalS, 3) ?>
                                = <?= round(round($test[$g], 3) / round($totalS, 3), 3) ?></p>
                            <?php $g++ ?>
                        <?php endforeach ?>
                        <hr>
                        <h4 class="subtitle">Hasil</h4>
                        <div class="table-container">
                            <table class="table is-fullwidth">
                                <thead class="has-background-success">
                                    <tr>
                                        <th class="has-text-white">No</th>
                                        <th class="has-text-white">Alternatif</th>
                                        <th class="has-text-white">Nilai</th>
                                    </tr>
                                </thead>
                                <tfoot class="has-background-success">
                                    <tr>
                                        <th class="has-text-white">No</th>
                                        <th class="has-text-white">Alternatif</th>
                                        <th class="has-text-white">Nilai</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php $h = 1 ?>
                                    <?php $i = 0 ?>
                                    <?php $j = 0 ?>
                                    <?php foreach ($alternatif as $row) : ?>
                                        <?php $varV[$j] = 1 ?>
                                        <?php $varV[$j] = $test[$i] / $totalS ?>
                                        <tr>
                                            <th><?= $h++ ?></th>
                                            <td><?= $row["nm_les"] ?></td>
                                            <td><?= round(round($test[$i], 3) / round($totalS, 3), 3) ?></td>
                                        </tr>
                                        <?php $i++ ?>
                                        <?php $j++ ?>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>