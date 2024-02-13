<!DOCTYPE html>
<html>
	<head>
	  <?= include 'lib.php'; ?>

	  <style type="text/css">
			body {
				font-family: helvetica;
			}

			table.table-border-pojok-kiri, th.table-border-pojok-kiri, td.table-border-pojok-kiri {
				border-top: 1px solid black;
				border-bottom: 1px solid black;
				border-right: 1px solid #cccccc;
				border-left: 1px solid black;
			}

			table.table-border-pojok-tengah, th.table-border-pojok-tengah, td.table-border-pojok-tengah {
				border-top: 1px solid black;
				border-bottom: 1px solid black;
				border-right: 1px solid #cccccc;
			}

			table.table-border-pojok-kanan, th.table-border-pojok-kanan, td.table-border-pojok-kanan {
				border-top: 1px solid black;
				border-bottom: 1px solid black;
				border-right: 1px solid black;
			}

			table.table-border-spesial, th.table-border-spesial, td.table-border-spesial {
				border-left: 1px solid black;
				border-right: 1px solid black;
			}

			table.table-border-spesial-kiri, th.table-border-spesial-kiri, td.table-border-spesial-kiri {
				border-left: 1px solid black;
				border-top: 2px solid black;
				border-bottom: 2px solid black;
			}

			table.table-border-spesial-tengah, th.table-border-spesial-tengah, td.table-border-spesial-tengah {
				border-left: 1px solid #cccccc;
				border-right: 1px solid #cccccc;
				border-top: 2px solid black;
				border-bottom: 2px solid black;
			}

			table.table-border-spesial-kanan, th.table-border-spesial-kanan, td.table-border-spesial-kanan {
				border-left: 1px solid #cccccc;
				border-right: 1px solid black;
				border-top: 2px solid black;
				border-bottom: 2px solid black;
			}

			table tr.table-judul{
				border: 1px solid;
				background-color: #e69500;
				font-weight: bold;
				font-size: 7px;
				color: black;
			}
				
			table tr.table-baris1{
				background-color: none;
				font-size: 7px;
			}

			table tr.table-baris1-bold{
				background-color: none;
				font-size: 7px;
				font-weight: bold;
			}
				
			table tr.table-total{
				background-color: #FFFF00;
				font-weight: bold;
				font-size: 7px;
				color: black;
			}

			table tr.table-total2{
				background-color: #eeeeee;
				font-weight: bold;
				font-size: 7px;
				color: black;
			}
	  </style>

	</head>
	<body>
		<?php
		$tanggal = date('F Y', strtotime($rak['tanggal_rencana_kerja']));
		?>
			
		<div align="center" style="display: block;font-weight: bold;font-size: 12px;text-transform:uppercase;">RENCANA KERJA<br/>
		DIVISI STONE CRUSHER<br/>
		PT. BIA BUMI JAYENDRA<br/>
		BULAN <?php echo $tanggal;?></div>
				
		<br />
		<br />

		<div align="left" style="display: block;font-weight: bold;font-size: 9px;text-transform:uppercase;">1. RENCANA PRODUKSI</div>
		<br />
		<table cellpadding="3" width="98%">
			<tr class="table-judul">
				<?php
					$total = 0;
					?>
					<?php
					$total = $rak['vol_produk_a'] + $rak['vol_produk_b'] + $rak['vol_produk_c'] + $rak['vol_produk_d'] + $rak['vol_produk_e'];
				?>
                <th width="5%" align="center" class="table-border-pojok-kiri">NO.</th>
                <th width="20%" align="center" class="table-border-pojok-tengah">URAIAN</th>
				<th width="20%" align="center" class="table-border-pojok-tengah">VOLUME</th>
				<th width="15%" align="center" class="table-border-pojok-tengah">SATUAN</th>
				<th width="20%" align="center" class="table-border-pojok-tengah">HARGA SATUAN</th>
				<th width="20%" align="center" class="table-border-pojok-kanan">TOTAL</th>
            </tr>
			<tr class="table-baris1">
				<td align="center" class="table-border-pojok-kiri">1.</td>
				<td align="left" class="table-border-pojok-tengah">Batu Split 0 - 0,5 (Abu Batu)</td>
				<td align="right" class="table-border-pojok-tengah"><?= number_format($rak['vol_produk_a'],2,',','.'); ?></td>
				<td align="center" class="table-border-pojok-tengah">Ton</td>
				<td align="right" class="table-border-pojok-tengah"><?= number_format($rak['price_a'],2,',','.'); ?></td>
				<?php
				$a1 = round($rak['vol_produk_a'],2);
				$a2 = round($rak['price_a'],0);
				$a3 = $a1 * $a2;
				?>
				<td align="right" class="table-border-pojok-kanan"><?= number_format($a3,0,',','.'); ?></td>
			</tr>
			<tr class="table-baris1">
				<td align="center" class="table-border-pojok-kiri">2.</td>
				<td align="left" class="table-border-pojok-tengah">Batu Split 0,5 - 1</td>
				<td align="right" class="table-border-pojok-tengah"><?= number_format($rak['vol_produk_b'],2,',','.'); ?></td>
				<td align="center" class="table-border-pojok-tengah">Ton</td>
				<td align="right" class="table-border-pojok-tengah"><?= number_format($rak['price_b'],2,',','.'); ?></td>
				<?php
				$b1 = round($rak['vol_produk_b'],2);
				$b2 = round($rak['price_b'],0);
				$b3 = $b1 * $b2;
				?>
				<td align="right" class="table-border-pojok-kanan"><?= number_format($b3,0,',','.'); ?></td>
			</tr>
			<tr class="table-baris1">
				<td align="center" class="table-border-pojok-kiri">3.</td>
				<td align="left" class="table-border-pojok-tengah">Batu Split 1 - 1,5</td>
				<td align="right" class="table-border-pojok-tengah"><?= number_format($rak['vol_produk_c'],2,',','.'); ?></td>
				<td align="center" class="table-border-pojok-tengah">Ton</td>
				<td align="right" class="table-border-pojok-tengah"><?= number_format($rak['price_c'],2,',','.'); ?></td>
				<?php
				$c1 = round($rak['vol_produk_c'],2);
				$c2 = round($rak['price_c'],0);
				$c3 = $c1 * $c2;
				?>
				<td align="right" class="table-border-pojok-kanan"><?= number_format($c3,0,',','.'); ?></td>
			</tr>
			<tr class="table-baris1">
				<td align="center" class="table-border-pojok-kiri">4.</td>
				<td align="left" class="table-border-pojok-tengah">Batu Split 1 - 2</td>
				<td align="right" class="table-border-pojok-tengah"><?= number_format($rak['vol_produk_d'],2,',','.'); ?></td>
				<td align="center" class="table-border-pojok-tengah">Ton</td>
				<td align="right" class="table-border-pojok-tengah"><?= number_format($rak['price_d'],2,',','.'); ?></td>
				<?php
				$d1 = round($rak['vol_produk_d'],2);
				$d2 = round($rak['price_d'],0);
				$d3 = $d1 * $d2;
				?>
				<td align="right" class="table-border-pojok-kanan"><?= number_format($d3,0,',','.'); ?></td>
			</tr>
			<tr class="table-baris1">
				<td align="center" class="table-border-pojok-kiri">5.</td>
				<td align="left" class="table-border-pojok-tengah">Batu Split 2 - 3</td>
				<td align="right" class="table-border-pojok-tengah"><?= number_format($rak['vol_produk_e'],2,',','.'); ?></td>
				<td align="center" class="table-border-pojok-tengah">M3</td>
				<td align="right" class="table-border-pojok-tengah"><?= number_format($rak['price_e'],2,',','.'); ?></td>
				<?php
				$e1 = round($rak['vol_produk_e'],2);
				$e2 = round($rak['price_e'],0);
				$e3 = $e1 * $e2;
				$total_pendapatan = $a3 + $b3 + $c3 + $d3 + $e3;
				?>
				<td align="right" class="table-border-pojok-kanan"><?= number_format($e3,0,',','.'); ?></td>
			</tr>
			<tr class="table-total">
				<td align="right" colspan="2" class="table-border-pojok-kiri">RENCANA PRODUKSI</td>
				<td align="right" class="table-border-pojok-tengah"><?= number_format($total,2,',','.'); ?></td>
				<td align="center" class="table-border-pojok-tengah">M3</td>
				<td align="center" class="table-border-pojok-tengah"></td>
				<td align="right" class="table-border-pojok-kanan"><?= number_format($total_pendapatan,0,',','.'); ?></td>
			</tr>
		</table>
		<br />
		<br />
		<br />
		<div align="left" style="display: block;font-weight: bold;font-size: 9px;text-transform:uppercase;">2. BIAYA</div>
		<br />
		<table cellpadding="3" width="98%">
			<tr class="table-judul">
				<th width="5%" align="center" class="table-border-pojok-kiri">NO.</th>
				<th width="25%" align="center" class="table-border-pojok-tengah">URAIAN</th>
				<th width="15%" align="center" class="table-border-pojok-tengah">VOLUME</th>
				<th width="15%" align="center" class="table-border-pojok-tengah">SATUAN</th>
				<th width="20%" align="center" class="table-border-pojok-tengah">HARGA SATUAN</th>
				<th width="20%" align="center" class="table-border-pojok-kanan">TOTAL</th>
			</tr>
			<?php
			$volume_boulder = round($rak['vol_boulder'],2);
			$harga_boulder = round($rak['harga_boulder'],0);
			$nilai_boulder = $volume_boulder * $harga_boulder;

			$volume_bbm_solar = round($rak['vol_bbm_solar'],2);
			$harga_bbm_solar = round($rak['harga_solar'],0);
			$nilai_bbm_solar = $volume_bbm_solar * $harga_bbm_solar;
			?>
			<tr>
				<th align="center" class="table-border-spesial" colspan="6">
					<div align="left" style="display: block;font-weight: bold;font-size: 9px;text-transform:uppercase;">2.1. BAHAN</div>
				</th>	
			</tr>
			<tr class="table-baris1">
				<th align="center" class="table-border-pojok-kiri">1.</th>	
				<th align="left" class="table-border-pojok-tengah">Boulder</th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($volume_boulder,2,',','.');?></th>
				<th align="center" class="table-border-pojok-tengah">Ton</th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($harga_boulder,0,',','.');?></th>
				<th align="right" class="table-border-pojok-kanan"><?php echo number_format($nilai_boulder,0,',','.');?></th>
	        </tr>
			<tr class="table-baris1">
				<th align="center" class="table-border-pojok-kiri">2.</th>	
				<th align="left" class="table-border-pojok-tengah">BBM Solar</th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($volume_bbm_solar,2,',','.');?></th>
				<th align="center" class="table-border-pojok-tengah">M3</th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($harga_bbm_solar,0,',','.');?></th>
				<th align="right" class="table-border-pojok-kanan"><?php echo number_format($nilai_bbm_solar,0,',','.');?></th>
	        </tr>
			<?php
			$total_bahan = $nilai_boulder + $nilai_bbm_solar;
			?>
			<tr class="table-total2">	
				<th align="right" colspan="5" class="table-border-spesial-kiri">TOTAL KEBUTUHAN BIAYA BAHAN</th>
				<th align="right" class="table-border-spesial-kanan"><?php echo number_format($total_bahan,0,',','.');?></th>
	        </tr>
			<?php
			$row = $this->db->select('r.*')
			->from('rap r')
			->group_by("r.tanggal_rap")->limit(1)
			->order_by('r.tanggal_rap','desc')
			->get()->row_array();

			$penyusutan_tangki = $this->db->select('r.*, p.nama_produk')
			->from('penyusutan r')
			->join('produk p','r.produk = p.id','left')
			->where("r.status = 'PUBLISH'")
			->where("r.produk = '23'")
			->order_by('p.nama_produk','asc')
			->group_by("p.nama_produk")->limit(1)
			->get()->row_array();
			$penyusutan_tangki = (($penyusutan_tangki['nilai_penyusutan'] / 48) / 25) / 7;

			$penyusutan_sc = $this->db->select('r.*, p.nama_produk')
			->from('penyusutan r')
			->join('produk p','r.produk = p.id','left')
			->where("r.status = 'PUBLISH'")
			->where("r.produk = '16'")
			->order_by('p.nama_produk','asc')
			->group_by("p.nama_produk")->limit(1)
			->get()->row_array();
			$penyusutan_sc = (($penyusutan_sc['nilai_penyusutan'] / 48) / 25) / 7;

			$penyusutan_gns = $this->db->select('r.*, p.nama_produk')
			->from('penyusutan r')
			->join('produk p','r.produk = p.id','left')
			->where("r.status = 'PUBLISH'")
			->where("r.produk = '19'")
			->order_by('p.nama_produk','asc')
			->group_by("p.nama_produk")->limit(1)
			->get()->row_array();
			$penyusutan_gns = (($penyusutan_gns['nilai_penyusutan'] / 48) / 25) / 7;

			$penyusutan_wl = $this->db->select('r.*, p.nama_produk')
			->from('penyusutan r')
			->join('produk p','r.produk = p.id','left')
			->where("r.status = 'PUBLISH'")
			->where("r.produk = '17'")
			->order_by('p.nama_produk','asc')
			->group_by("p.nama_produk")->limit(1)
			->get()->row_array();
			$penyusutan_wl = (($penyusutan_wl['nilai_penyusutan'] / 48) / 25) / 7;

			$penyusutan_timbangan = $this->db->select('r.*, p.nama_produk')
			->from('penyusutan r')
			->join('produk p','r.produk = p.id','left')
			->where("r.status = 'PUBLISH'")
			->where("r.produk = '39'")
			->order_by('p.nama_produk','asc')
			->group_by("p.nama_produk")->limit(1)
			->get()->row_array();
			$penyusutan_timbangan = (($penyusutan_timbangan['nilai_penyusutan'] / 48) / 25) / 7;

			//M3
			$berat_isi_boulder = 1/$row['berat_isi_boulder'];
			$harsat_boulder = $row['price_boulder'] / $berat_isi_boulder;
			$nilai_boulder = $harsat_boulder * $row['vol_boulder'];
			//Ton
			$vol_boulder = $row['vol_boulder'];
			$nilai_boulder_ton = $vol_boulder * $row['price_boulder'];
			
			//M3
			$sc_a = $row['kapasitas_alat_sc'] * $row['efisiensi_alat_sc'];
			$sc_b = $sc_a / $row['berat_isi_batu_pecah'];
			$vol_sc = 1 / $sc_b;
			$nilai_sc = $vol_sc * $penyusutan_sc;
			//Ton
			$vol_sc_ton = 1 / $sc_a;
			$nilai_sc_ton = $vol_sc_ton * $penyusutan_sc;
			
			//M3
			$vol_tangki = $vol_sc;
			$nilai_tangki = $vol_tangki * $penyusutan_tangki;
			//Ton
			$vol_tangki_ton = $vol_sc_ton;
			$nilai_tangki_ton = $vol_tangki_ton * $penyusutan_tangki;
			
			//M3
			$vol_gns = $vol_sc;
			$nilai_gns = $vol_gns * $penyusutan_gns;
			//Ton
			$vol_gns_ton = $vol_sc_ton;
			$nilai_gns_ton = $vol_gns_ton * $penyusutan_gns;

			//M3
			$wl_a = $row['kapasitas_alat_wl'] * $row['efisiensi_alat_wl'];
			$wl_b = (60 / $row['waktu_siklus']) * $wl_a;
			$vol_wl = 1 / $wl_b;
			$nilai_wl = $vol_wl * $penyusutan_wl;
			//Ton
			$vol_wl_ton_rumus = (($wl_a / $row['waktu_siklus']) * 60) * $row['berat_isi_batu_pecah'];
			$vol_wl_ton = 1 / $vol_wl_ton_rumus;
			$nilai_wl_ton = $vol_wl_ton * $penyusutan_wl;

			//M3
			$vol_timbangan =  $vol_sc;
			$nilai_timbangan = $vol_timbangan * $penyusutan_timbangan;
			//Ton
			$vol_timbangan_ton = $vol_sc_ton;
			$nilai_timbangan_ton = $vol_timbangan_ton * $penyusutan_timbangan;

			//Ton
			$vol_bbm_solar_ton = $row['vol_bbm_solar'];
			$nilai_bbm_solar_ton = $vol_bbm_solar_ton * $row['price_bbm_solar'];

			//M3
			$vol_bbm_solar =  $vol_bbm_solar_ton * $row['berat_isi_boulder'];
			$nilai_bbm_solar = $vol_bbm_solar * $row['price_bbm_solar'];

			$total_overhead = $row['konsumsi'] + $row['gaji'] + $row['upah'] + $row['pengujian'] + $row['perbaikan'] + $row['akomodasi'] + $row['listrik'] + $row['thr'] + $row['bensin'] + $row['dinas'] + $row['komunikasi'] + $row['pakaian'] + $row['tulis'] + $row['keamanan'] + $row['perlengkapan'] + $row['beban'] + $row['adm'] + $row['lain'] + $row['sewa'] + $row['bpjs'] + $row['penyusutan_kantor'] + $row['penyusutan_kendaraan'] + $row['iuran'] + $row['kendaraan'] + $row['pajak'] + $row['solar'] + $row['donasi'] + $row['legal'] + $row['pengobatan'] + $row['lembur'] + $row['pelatihan'] + $row['supplies'];

			//$rumus_overhead = ($row['overhead'] / 25) / 8;
			//$rumus_overhead_1 = ($row['kapasitas_alat_sc'] * $row['efisiensi_alat_sc']) / $row['berat_isi_batu_pecah'] ;
			//$overhead = $rumus_overhead / $rumus_overhead_1;
			//$rumus_overhead_ton = $row['kapasitas_alat_sc'] * $row['efisiensi_alat_sc'];
			
			$overhead_ton = $total_overhead / 5000;
			$overhead = $overhead_ton;

			$total = $nilai_boulder + $nilai_tangki + $nilai_sc + $nilai_gns + $nilai_wl + $nilai_timbangan + $overhead + $nilai_bbm_solar;
			$total_ton = $nilai_boulder_ton + $nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $overhead_ton + $nilai_bbm_solar_ton;
			?>
			<?php
			$vol_alat = round($volume_boulder,2);
			$nilai_tangki = $vol_alat * $nilai_tangki_ton;
			$nilai_sc = $vol_alat * $nilai_sc_ton;
			$nilai_genset = $vol_alat * $nilai_gns_ton;
			$nilai_wl = $vol_alat * $nilai_wl_ton;
			$nilai_timbangan = $vol_alat * $nilai_timbangan_ton;
			?>
			<tr>
				<th align="center" class="table-border-spesial" colspan="6">
				<div align="left" style="display: block;font-weight: bold;font-size: 9px;text-transform:uppercase;">2.2. ALAT</div>
				</th>	
			</tr>
			<tr class="table-baris1">
				<th align="center" class="table-border-pojok-kiri">1.</th>	
				<th align="left" class="table-border-pojok-tengah">Tangki Solar</th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($vol_alat,2,',','.');?></th>
				<th align="center" class="table-border-pojok-tengah"></th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($nilai_tangki_ton,0,',','.');?></th>
				<th align="right" class="table-border-pojok-kanan"><?php echo number_format($nilai_tangki,0,',','.');?></th>
	        </tr>
			<tr class="table-baris1">
				<th align="center" class="table-border-pojok-kiri">2.</th>	
				<th align="left" class="table-border-pojok-tengah">Stone Crusher</th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($vol_alat,2,',','.');?></th>
				<th align="center" class="table-border-pojok-tengah"></th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($nilai_sc_ton,0,',','.');?></th>
				<th align="right" class="table-border-pojok-kanan"><?php echo number_format($nilai_sc,0,',','.');?></th>
	        </tr>
			<tr class="table-baris1">
				<th align="center" class="table-border-pojok-kiri">3.</th>	
				<th align="left" class="table-border-pojok-tengah">Genset</th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($vol_alat,2,',','.');?></th>
				<th align="center" class="table-border-pojok-tengah"></th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($nilai_gns_ton,0,',','.');?></th>
				<th align="right" class="table-border-pojok-kanan"><?php echo number_format($nilai_genset,0,',','.');?></th>
	        </tr>
			<tr class="table-baris1">
				<th align="center" class="table-border-pojok-kiri">4.</th>	
				<th align="left" class="table-border-pojok-tengah">Wheel Loader</th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($vol_alat,2,',','.');?></th>
				<th align="center" class="table-border-pojok-tengah"></th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($nilai_wl_ton,0,',','.');?></th>
				<th align="right" class="table-border-pojok-kanan"><?php echo number_format($nilai_wl,0,',','.');?></th>
	        </tr><tr class="table-baris1">
				<th align="center" class="table-border-pojok-kiri">5.</th>	
				<th align="left" class="table-border-pojok-tengah">Timbangan</th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($vol_alat,2,',','.');?></th>
				<th align="center" class="table-border-pojok-tengah"></th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($nilai_timbangan_ton,0,',','.');?></th>
				<th align="right" class="table-border-pojok-kanan"><?php echo number_format($nilai_timbangan,0,',','.');?></th>
	        </tr>
			<?php
			$total_alat = $nilai_tangki + $nilai_sc + $nilai_genset + $nilai_wl + $nilai_timbangan;
			?>
			<tr class="table-total2">	
				<th align="right" colspan="5" class="table-border-spesial-kiri">TOTAL KEBUTUHAN BIAYA ALAT</th>
				<th align="right" class="table-border-spesial-kanan"><?php echo number_format($total_alat,0,',','.');?></th>
	        </tr>
			<tr>
				<th align="center" class="table-border-spesial" colspan="6">
					<div align="left" style="display: block;font-weight: bold;font-size: 9px;text-transform:uppercase;">2.3. BIAYA UMUM & ADMINISTRATIF</div>
				</th>	
			</tr>
			<?php
			$total_overhead = $rak['overhead'];
			?>
			<tr class="table-total">	
				<th align="right" colspan="5" class="table-border-spesial-kiri">TOTAL BIAYA UMUM & ADMINISTRATIF</th>
				<th align="right" class="table-border-spesial-kanan"><?php echo number_format($total_overhead,0,',','.');?></th>
	        </tr>
			<tr>
				<th class="table-border-spesial" colspan="6"></th>
			</tr>
			<tr class="table-total">	
				<th align="right" colspan="5" class="table-border-spesial-kiri">SUBTOTAL KEBUTUHAN BIAYA (2.1 + 2.2 + 2.3)</th>
				<th align="right" class="table-border-spesial-kanan"><?php echo number_format($total_bahan + $total_alat + $total_overhead,0,',','.');?></th>
	        </tr>
		</table>
	</body>
</html>