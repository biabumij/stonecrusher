<!DOCTYPE html>
<html>
	<head>
	  <title>Beban Pokok Penjualan</title>
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
		}

		.table-lap tr td, .table-lap tr th{
			border: 1px solid #000000;
		}

		table tr.table-active{
            background-color: #e69500;
        }

        table tr.table-active2{
            background-color: #fff;
        }

		table tr.table-active3{
            background-color: #666;
			color:white;
        }
	  </style>

	</head>
	<body>
		<table width="98%" border="0" cellpadding="3">
			<tr>
				<td align="center">
					<div style="display: block;font-weight: bold;font-size: 12px;">BEBAN POKOK PENJUALAN</div>
					<div style="display: block;font-weight: bold;font-size: 12px;">DIVISI STONE CRUSHER</div>
				</td>
			</tr>
		</table>
		<br /><br /><br />
		<!-- Total Pendapatan / Penjualan -->
		<?php
		$penjualan = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
		->from('pmm_productions pp')
		->join('penerima p', 'pp.client_id = p.id','left')
		->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
		->where("pp.date_production between '$date1' and '$date2'")
		->where("pp.product_id in (3,4,7,8,9,14,24,63)")
		->where("pp.salesPo_id <> 536 ")
		->where("pp.salesPo_id <> 532 ")
		->where("pp.salesPo_id <> 537 ")
		->where("pp.salesPo_id <> 533 ")
		->where("pp.salesPo_id <> 534 ")
		->where("pp.salesPo_id <> 535 ")
		->where("pp.salesPo_id <> 546 ")
		->where("pp.salesPo_id <> 542 ")
		->where("pp.salesPo_id <> 547 ")
		->where("pp.salesPo_id <> 543 ")
		->where("pp.salesPo_id <> 548 ")
		->where("pp.salesPo_id <> 538 ")
		->where("pp.salesPo_id <> 544 ")
		->where("pp.salesPo_id <> 549 ")
		->where("pp.salesPo_id <> 539 ")
		->where("pp.salesPo_id <> 545 ")
		->where("pp.salesPo_id <> 541 ")
		->where("pp.salesPo_id <> 530 ")
		->where("pp.salesPo_id <> 531 ")
		->where("ppo.status in ('OPEN','CLOSED')")
		->group_by('pp.salesPo_id')
		->get()->result_array();
		
		$total_penjualan = 0;
		$total_volume = 0;

		foreach ($penjualan as $x){
			$total_penjualan += $x['price'];
			$total_volume += $x['volume'];
		}
		?>

		<!-- HPPenjualan -->
		<?php
		$last_production = $this->db->select('date')->order_by('date','desc')->limit(1,5)->get_where('pmm_remaining_materials_cat',array('status'=>'PUBLISH','material_id'=>'4'))->row_array();
		$last_production_2 = $this->db->select('date')->order_by('date','desc')->limit(1,3)->get_where('pmm_remaining_materials_cat',array('status'=>'PUBLISH','material_id'=>'4'))->row_array();

		$date1_old = date('Y-m-d', strtotime('+1 days', strtotime($last_production['date'])));
		$date2_old = date('Y-m-d', strtotime($last_production_2['date']));

		$tanggal_opening_balance = date('Y-m-d', strtotime('-1 days', strtotime($date1)));

		$akumulasi_bahan_jadi = $this->db->select('sum(pp.volume) as volume, sum(pp.nilai) as nilai')
		->from('kunci_bahan_jadi pp')
		->where("(pp.date = '$tanggal_opening_balance')")
		->get()->row_array();
		$akumulasi_bahan_jadi_volume = $akumulasi_bahan_jadi['volume'];
		$akumulasi_bahan_jadi_nilai = $akumulasi_bahan_jadi['nilai'];
		?>

		<!-- HPProduksi -->
		<!-- Alat -->
		<?php
		$alat = $this->db->select('sum(alat) as total')
        ->from('bpp')
        ->where("(date between '$date1' and '$date2')")
        ->get()->row_array();
        $total_biaya_peralatan = $alat['total'];
		$total_nilai_produksi_solar = 0;
		?>

		<!-- HPProduksi -->
		<!-- Overhead -->
		<?php
		$overhead = $this->db->select('sum(overhead) as total')
        ->from('bpp')
        ->where("(date between '$date1' and '$date2')")
        ->get()->row_array();
        $total_operasional = $overhead['total'];
		?>

		<!--  Jumlah HPProduksi (Tanpa Limbah)  -->
		<?php
		$rekapitulasi_produksi_harian = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
		->from('pmm_produksi_harian pph ')
		->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
		->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
		->where("(pph.date_prod between '$date1' and '$date2')")
		->where('pph.status','PUBLISH')
		->get()->row_array();
		$total_rekapitulasi_produksi_harian = round($rekapitulasi_produksi_harian['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_f'],2);
		?>
		<table class="table-lap" width="98%" border="0" cellpadding="5">
			<tr class="table-active" style="">
				<td width="50%" colspan="5">
					<div style="display: block;font-weight: bold;font-size: 8px;">PERIODE</div>
				</td>
				<td align="right" width="50%">
					<div style="display: block;font-weight: bold;font-size: 8px;"><?php echo str_replace($search, $replace, $subject);?></div>
				</td>
			</tr>
			<tr class="table-active3">
				<th align="center" width="5%" rowspan="2">&nbsp; <br /><b>NO.</b></th>
				<th align="center" width="30%" rowspan="2">&nbsp; <br /><b>URAIAN</b></th>
				<th align="center" width="15%" rowspan="2">&nbsp; <br /><b>VOLUME</b></th>
				
				<th align="center" width="25%" colspan="2" style="background-color:blue; color:white;"><b>RAP</b></th>
				<th align="center" width="25%" colspan="2" style="background-color:green; color:white;"><b>REALISASI</b></th>
			</tr>
			<tr class="table-active3">
				<th align="center" width="15%" style="background-color:blue; color:white;"><b>NILAI</b></th>
				<th align="center" width="10%" style="background-color:blue; color:white;"><b>HARSAT</b></th>
				<th align="center" width="15%" style="background-color:green; color:white;"><b>NILAI</b></th>
				<th align="center" width="10%" style="background-color:green; color:white;"><b>HARSAT</b></th>
			</tr>
			<tr class="table-active2" style="font-weight:bold;">
				<th align="center">1.</th>
				<th align="left">HP Produksi</th>
				<th align="right"></th>
				<th align="right"></th>
				<th align="right"></th>
				<th align="right"></th>
				<th align="right"></th>
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
			$bahan = $this->db->select('sum(bahan) as total')
			->from('bpp')
			->where("(date between '$date1' and '$date2')")
			->get()->row_array();
			$total_nilai_produksi_boulder = $bahan['total'];
			?>
			<?php
			$produksi = $this->db->select('pp.produksi')
			->from('kunci_bahan_jadi pp')
			->where("(pp.date between '$date1' and '$date2')")
			->group_by('pp.produksi')
			->order_by('pp.id','desc')->limit(1)
			->get()->row_array();
			$produksi = $produksi['produksi'];
			?>
			<tr class="table-active2" style="font-weight:bold;">
				<th align="center"></th>
				<th align="left">&nbsp;&nbsp;&nbsp;Bahan Baku</th>
				<th align="right"></th>
				<th align="right"><?php echo number_format($nilai_boulder_ton * round($total_rekapitulasi_produksi_harian,2),0,',','.');?></th>
				<th align="right"></th>
				<th align="right"><a target="_blank" href="<?= base_url("laporan/cetak_bahan?filter_date=".$filter_date = date('d-m-Y',strtotime($date1)).' - '.date('d-m-Y',strtotime($date2))) ?>"><?php echo number_format($total_nilai_produksi_boulder,0,',','.');?></a></th>
				<th align="right"></th>
			</tr>
			<tr class="table-active2" style="font-weight:bold;">
				<th align="center"></th>
				<th align="left">&nbsp;&nbsp;&nbsp;Alat</th>
				<th align="right"></th>
				<th align="right"><?php echo number_format(($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($total_rekapitulasi_produksi_harian,2),0,',','.');?></th>
				<th align="right"></th>
				<th align="right"><a target="_blank" href="<?= base_url("laporan/cetak_alat?filter_date=".$filter_date = date('d-m-Y',strtotime($date1)).' - '.date('d-m-Y',strtotime($date2))) ?>"><?php echo number_format($total_biaya_peralatan + $total_nilai_produksi_solar,0,',','.');?></a></th>
				<th align="right"></th>
			</tr>
			<tr class="table-active2" style="font-weight:bold;">
				<th align="center"></th>
				<th align="left">&nbsp;&nbsp;&nbsp;Overhead</th>
				<th align="right"></th>
				<th align="right"><?php echo number_format($overhead_ton * round($total_rekapitulasi_produksi_harian,2),0,',','.');?></th>
				<th align="right"></th>
				<th align="right"><a target="_blank" href="<?= base_url("laporan/cetak_overhead?filter_date=".$filter_date = date('d-m-Y',strtotime($date1)).' - '.date('d-m-Y',strtotime($date2))) ?>"><?php echo number_format($total_operasional,0,',','.');?></a></th>
				<th align="right"></th>
			</tr>
			<tr class="table-active2" style="font-weight:bold; background-color:#cccccc;">
				<th align="right" colspan="2">&nbsp;&nbsp;&nbsp;Jumlah HP Produksi</th>
				<th align="right"><?php echo number_format($total_rekapitulasi_produksi_harian,2,',','');?> (Ton)</th>
				<?php
				$total_nilai_rap = ($nilai_boulder_ton * round($total_rekapitulasi_produksi_harian,2)) + (($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($total_rekapitulasi_produksi_harian,2)) + ($overhead_ton * round($total_rekapitulasi_produksi_harian,2));
				?>
				<th align="right"><?php echo number_format($total_nilai_rap,0,',','.');?></th>
				<th align="right"><?php echo number_format((round($total_rekapitulasi_produksi_harian,2)!=0)?$total_nilai_rap / round($total_rekapitulasi_produksi_harian,2) * 1:0,0,',','.');?></th>
				<th align="right"><?php echo number_format(($total_nilai_produksi_boulder + $total_biaya_peralatan + $total_nilai_produksi_solar + $total_operasional) * $produksi,0,',','.');?></th>
				<th align="right"><?php echo number_format((round($total_rekapitulasi_produksi_harian,2)!=0)?($total_nilai_produksi_boulder + $total_biaya_peralatan + $total_nilai_produksi_solar + $total_operasional) / round($total_rekapitulasi_produksi_harian,2) * 1:0,0,',','.');?></th>
			</tr>
			<tr class="table-active2" style="font-weight:bold;">
				<th align="center">2.</th>
				<th align="left">HP Penjualan</th>
				<th align="right"></th>
				<th align="right"></th>
				<th align="right"></th>
				<th align="right"></th>
				<th align="right"></th>
			</tr>
			<tr class="table-active2" style="font-weight:bold; background-color:#cccccc;">
				<th align="right" colspan="2">&nbsp;&nbsp;&nbsp;Stok Awal Barang Jadi</th>
				<th align="right"><?php echo number_format($akumulasi_bahan_jadi_volume,2,',','');?> (Ton)</th>
				<th align="right"></th>
				<th align="right"></th>
				<th align="right"><?php echo number_format($akumulasi_bahan_jadi_nilai,0,',','.');?></th>
				<th align="right"><?php echo number_format((round($akumulasi_bahan_jadi_volume,2)!=0)?$akumulasi_bahan_jadi_nilai / round($akumulasi_bahan_jadi_volume,2) * 1:0,0,',','.');?></th>
			</tr>
			<tr class="table-active2" style="font-weight:bold; background-color:#e69500;">
				<th align="right" colspan="2">Harga Pokok Penjualan (Siap Jual)</th>
				<th align="right"><?php echo number_format(round($akumulasi_bahan_jadi_volume,2) + round($total_rekapitulasi_produksi_harian,2),2,',','');?> (Ton)</th>
				<th align="right"></th>
				<th align="right"></th>
				<?php
				$nilai_hpp_siap_jual = ($akumulasi_bahan_jadi_nilai) + (($total_nilai_produksi_boulder + $total_biaya_peralatan + $total_nilai_produksi_solar + $total_operasional) * $produksi);
				?>
				<th align="right"><?php echo number_format($nilai_hpp_siap_jual,0,',','.');?></th>
				<th align="right"></th>
			</tr>
			<tr class="table-active2" style="font-weight:bold;">
				<th align="center">3.</th>
				<th align="left">Pendapatan / Penjualan</th>
				<th align="right"></th>
				<th align="right"></th>
				<th align="right"></th>
				<th align="right"></th>
				<th align="right"></th>
			</tr>
			<tr class="table-active2" style="font-weight:bold; background-color:#cccccc;">
				<th align="right" colspan="2">&nbsp;&nbsp;&nbsp;Total Pendapatan / Penjualan</th>
				<th align="right"><?php echo number_format($total_volume,2,',','');?> (Ton)</th>
				<th align="right"></th>
				<th align="right"></th>
				<th align="right"><?php echo number_format($total_penjualan,0,',','.');?></th>
				<th align="right"><?php echo number_format((round($total_volume,2)!=0)?$total_penjualan / round($total_volume,2) * 1:0,0,',','.');?></th>
			</tr>
			<tr class="table-active2" style="font-weight:bold;">
				<th align="center">4.</th>
				<th align="left">Persediaan Akhir Bahan Jadi</th>
				<th align="right"><?php echo number_format(round($akumulasi_bahan_jadi_volume,2) + round($total_rekapitulasi_produksi_harian,2) - round($total_volume,2),2,',','');?> (Ton)</th>
				<th align="right"></th>
				<th align="right"></th>
				<?php
				$volume = round($akumulasi_bahan_jadi_volume,2) + round($total_rekapitulasi_produksi_harian,2) - round($total_volume,2);
				$harsat_produksi = (round($total_rekapitulasi_produksi_harian,2)!=0)?($total_nilai_produksi_boulder + $total_biaya_peralatan + $total_nilai_produksi_solar + $total_operasional) / round($total_rekapitulasi_produksi_harian,2) * 1:0;
				$harsat_produksi_stok = (round($akumulasi_bahan_jadi_volume,2)!=0)?$akumulasi_bahan_jadi_nilai / round($akumulasi_bahan_jadi_volume,2) * 1:0;
				$key = 0;
				if($harsat_produksi == 0) {
					$key = $harsat_produksi_stok;
				}

				if($harsat_produksi > 0) {
					$key = $harsat_produksi;
				}
				?>
				<th align="right"><?php echo number_format($volume * $key,0,',','.');?></th>
				<th align="right"><?php echo number_format($key,0,',','.');?></th>
			</tr>
			<tr class="table-active2" style="font-weight:bold;">
				<th align="center">5.</th>
				<th align="left">Beban Pokok Penjualan</th>
				<th align="right"><?php echo number_format($total_volume,2,',','');?> (Ton)</th>
				<th align="right"></th>
				<th align="right"></th>
				<?php
				$nilai_beban_produksi = $total_volume * $key;
				?>
				<th align="right"><?php echo number_format($nilai_beban_produksi,0,',','.');?></th>
				<th align="right"><?php echo number_format($key,0,',','.');?></th>
			</tr>
		</table>
		<br /><br /><br /><br /><br />
		<table width="98%" border="0" cellpadding="0">
			<tr >
				<td width="5%"></td>
				<td width="90%">
					<table width="100%" border="0" cellpadding="2">
						<tr>
							<td align="center" >
								Disetujui Oleh
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

							$this->db->select('a.admin_name, g.admin_group_name, a.admin_ttd');
							$this->db->join('tbl_admin_group g','a.admin_group_id = g.admin_group_id','left');
							$this->db->where('a.admin_id',$create['unit_head']);
							$unit_head = $this->db->get('tbl_admin a')->row_array();

							$dirut = $this->pmm_model->GetNameGroup(6);
						?>
						<tr class="">
							<td align="center" height="60px">
							
							</td>
							<td align="center">
								<img src="<?= $unit_head['admin_ttd']?>" width="60px">
							</td>
						</tr>
						<tr>
							<td align="center">
								<b><u><?= $dirut['admin_name'];?></u><br />
								<?=  $dirut['admin_group_name'];?></b>
							</td>
							<td align="center">
								<b><u><?= $unit_head['admin_name'];?></u><br />
								Kepala Unit Bisnis</b>
							</td>
						</tr>
					</table>
				</td>
				<td width="5%"></td>
			</tr>
		</table>
	</body>
</html>