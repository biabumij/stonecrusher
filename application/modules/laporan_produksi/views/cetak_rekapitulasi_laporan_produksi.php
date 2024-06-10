<!DOCTYPE html>
<html>
	<head>
	  <title>REKAPITULASI LAPORAN PRODUKSI</title>
	  
	  <?php
		$search = array(
		'January',
		'February',
		'March',
		'April',
		'May',
		'June',
		'July',
		'August',
		'September',
		'October',
		'November',
		'December'
		);
		
		$replace = array(
		'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
		);
		
		$subject = "$filter_date";

		echo str_replace($search, $replace, $subject);

	  ?>

	  <style type="text/css">
		body {
			font-family: helvetica;
			font-size: 8px;
		}
		
		table tr.table-judul{
			background-color: #e69500;
			font-weight: bold;
			font-size: 8px;
			color: black;
		}
			
		table tr.table-baris1{
			background-color: #F0F0F0;
			font-size: 8px;
		}

		table tr.table-baris1-bold{
			background-color: #F0F0F0;
			font-size: 8px;
			font-weight: bold;
		}
			
		table tr.table-baris2{
			font-size: 8px;
			background-color: #E8E8E8;
		}

		table tr.table-baris2-bold{
			font-size: 8px;
			background-color: #E8E8E8;
			font-weight: bold;
		}
			
		table tr.table-total{
			background-color: #cccccc;
			font-weight: bold;
			font-size: 8px;
			color: black;
		}
	  </style>

	</head>
	<body>
		<table width="98%">
			<tr>
				<td width="100%" align="center">
					<div style="display: block;font-weight: bold;font-size: 11px;">REKAPITULASI LAPORAN PRODUKSI</div>
					<div style="display: block;font-weight: bold;font-size: 11px; text-transform: uppercase;">PERIODE : <?php echo str_replace($search, $replace, $subject);?></div>
				</td>
			</tr>
		</table>
		<br />
		<br />
		<?php
			$rekapitulasi_produksi_harian = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
			->from('pmm_produksi_harian pph ')
			->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
			->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
			->where("(pph.date_prod between '$start_date' and '$end_date')")
			->where('pph.status','PUBLISH')
			->group_by('pph.id')
			->get()->result_array();

			$jumlah_pemakaian_a = 0;
			$jumlah_pemakaian_b = 0;
			$jumlah_pemakaian_c = 0;
			$jumlah_pemakaian_d = 0;
			$jumlah_pemakaian_e = 0;
			$jumlah_pemakaian_f = 0;

			$presentase_a = 0;
			$presentase_b = 0;
			$presentase_c = 0;
			$presentase_d = 0;
			$presentase_e = 0;
			$presentase_f = 0;

			foreach ($rekapitulasi_produksi_harian as $x){
				$jumlah_pemakaian_a += $x['jumlah_pemakaian_a'];
				$jumlah_pemakaian_b += $x['jumlah_pemakaian_b'];
				$jumlah_pemakaian_c += $x['jumlah_pemakaian_c'];
				$jumlah_pemakaian_d += $x['jumlah_pemakaian_d'];
				$jumlah_pemakaian_e += $x['jumlah_pemakaian_e'];
				$jumlah_pemakaian_f += $x['jumlah_pemakaian_f'];
				$presentase_a = $x['presentase_a'];
				$presentase_b = $x['presentase_b'];
				$presentase_c = $x['presentase_c'];
				$presentase_d = $x['presentase_d'];
				$presentase_e = $x['presentase_e'];
				$presentase_f = $x['presentase_f'];
			}

			$total_rekapitulasi_produksi_harian = 0;
			$total_rekapitulasi_produksi_harian = round($jumlah_pemakaian_a,2) + round($jumlah_pemakaian_b,2) + round($jumlah_pemakaian_c,2) + round($jumlah_pemakaian_d,2) + round($jumlah_pemakaian_e,2) + round($jumlah_pemakaian_f,2);
			$total_presentase_produksi_harian = $presentase_a + $presentase_b + $presentase_c + $presentase_d + $presentase_e + $presentase_f;
		?>
		<table cellpadding="3" width="98%" border="0">
			<tr class="table-judul">
				<th align="center" width="5%">NO.</th>
				<th align="center" width="35%">URAIAN</th>
				<th align="center" width="20%">SATUAN</th>
				<th align="center" width="20%">PRESENTASE</th>
				<th align="center" width="20%">VOLUME</th>
            </tr>
            
			<tr class="table-baris1">
				<td align="center">1.</td>	
				<td align="left">Batu Split 0 - 0,5 (Abu Batu)</td>
				<td align="center">Ton</td>
				<td align="center"><?php echo number_format($presentase_a,2,',','.');?> %</td>
				<td align="right"><?php echo number_format($jumlah_pemakaian_a,2,',','.');?></td>
			</tr>
			<tr class="table-baris1">
				<td align="center">2.</td>	
				<td align="left">Batu Split 0,5 - 1</td>
				<td align="center">Ton</td>
				<td align="center"><?php echo number_format($presentase_b,2,',','.');?> %</td>
				<td align="right"><?php echo number_format($jumlah_pemakaian_b,2,',','.');?></td>
			</tr>
			<tr class="table-baris1">
				<td align="center">3.</td>	
				<td align="left">Batu Split 0 - 0,5 (Abu Batu)</td>
				<td align="center">Ton</td>
				<td align="center"><?php echo number_format($presentase_c,2,',','.');?> %</td>
				<td align="right"><?php echo number_format($jumlah_pemakaian_c,2,',','.');?></td>
			</tr>
			<tr class="table-baris1">
				<td align="center">4.</td>	
				<td align="left">Batu Split 1 - 2</td>
				<td align="center">Ton</td>
				<td align="center"><?php echo number_format($presentase_d,2,',','.');?> %</td>
				<td align="right"><?php echo number_format($jumlah_pemakaian_d,2,',','.');?></td>
			</tr>
			<tr class="table-baris1">
				<td align="center">5.</td>	
				<td align="left">Batu Split 2 - 3</td>
				<td align="center">Ton</td>
				<td align="center"><?php echo number_format($presentase_e,2,',','.');?> %</td>
				<td align="right"><?php echo number_format($jumlah_pemakaian_e,2,',','.');?></td>
			</tr>
			<tr class="table-baris1">
				<td align="center">6.</td>	
				<td align="left">Limbah</td>
				<td align="center">Ton</td>
				<td align="center"><?php echo number_format($presentase_f,2,',','.');?> %</td>
				<td align="right"><?php echo number_format($jumlah_pemakaian_f,2,',','.');?></td>
			</tr>
            <tr class="table-total">
            	<th width="40%" align="center" colspan="2"><b>TOTAL</b></th>
				<th width="20%" align="center"><b>Ton</b></th>
				<th width="20%" align="center"><?php echo number_format($total_presentase_produksi_harian,2,',','.');?> %</th>
            	<th width="20%" align="right"><?php echo number_format($total_rekapitulasi_produksi_harian,2,',','.');?></th>
            </tr>
			
		</table>
		<br />
		<br />
		<table width="98%">
			<tr >
				<td width="5%"></td>
				<td width="90%">
					<table width="100%" border="0" cellpadding="2">
						<tr>
							<td align="center" >
								Disetujui Oleh
							</td>
							<td align="center">
								Diperiksa Oleh
							</td>
							<td align="center">
								Dibuat Oleh
							</td>
						</tr>
						<?php
							$create = $this->db->select('*')
							->from('kunci_bahan_jadi')
							->where("(date = '$end_date')")
							->order_by('id','desc')->limit(1)
							->get()->row_array();

							$this->db->select('g.admin_group_name, a.admin_ttd, a.admin_name');
							$this->db->join('tbl_admin_group g','a.admin_group_id = g.admin_group_id','left');
							$this->db->where('a.admin_id',$create['unit_head']);
							$unit_head = $this->db->get('tbl_admin a')->row_array();

							$this->db->select('g.admin_group_name, a.admin_ttd, a.admin_name');
							$this->db->join('tbl_admin_group g','a.admin_group_id = g.admin_group_id','left');
							$this->db->where('a.admin_id',$create['logistik']);
							$logistik = $this->db->get('tbl_admin a')->row_array();
						?>
						<tr class="">
							<td align="center" height="70px">
								<img src="<?= $unit_head['admin_ttd']?>" width="70px">
							</td>
							<td align="center">
								<img src="<?= $logistik['admin_ttd']?>" width="70px">
							</td>
							<td align="center">
								<img src="<?= $logistik['admin_ttd']?>" width="70px">
							</td>
						</tr>
						<tr>
							<td align="center">
								<b><u><?= $unit_head['admin_name']?></u><br />
								Ka. Unit Bisnis</b>
							</td>
							<td align="center">
								<b><u><?= $logistik['admin_name']?></u><br />
								Pj. Produksi dan HSE</b>
							</td>
							<td align="center">
								<b><u><?= $logistik['admin_name']?></u><br />
								Produksi</b>
							</td>
						</tr>
					</table>
				</td>
				<td width="5%"></td>
			</tr>
		</table>
	</body>
</html>