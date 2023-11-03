<!DOCTYPE html>
<html>
	<head>
	  <title>Beban Pokok Penjualan</title>
	  
	  <style type="text/css">
	  	table.minimalistBlack {
		  border: 0px solid #000000;
		  width: 100%;
		  text-align: left;
		}
		table.minimalistBlack td, table.minimalistBlack th {
		  border: 1px solid #000000;
		  /*padding: 10px 4px;*/
		}
		table.minimalistBlack tr th {
		  /*font-size: 14px;*/
		  font-weight: bold;
		  color: #000000;
		  text-align: center;
		}
		table tr.table-active{
            background-color: #e69500;
        }
        table tr.table-active2{
            background-color: #b5b5b5;
        }
        table tr.table-active3{
            background-color: #eee;
        }
		hr{
			margin-top:0;
			margin-bottom:30px;
		}
		h3{
			margin-top:0;
		}
		.table-lap tr td, .table-lap tr th{
			border-bottom: 1px solid #000;
		}
	  </style>

	</head>
	<body>
		<table width="98%" border="0" cellpadding="3">
			<tr>
				<td align="center">
					<div style="display: block;font-weight: bold;font-size: 12px;">BEBAN POKOK PENJUALAN</div>
					<div style="display: block;font-weight: bold;font-size: 12px;">STONE CRUSHER</div>
				</td>
			</tr>
		</table>
		<br />
		<br />
		<br />

		<!-- Total Pendapatan / Penjualan -->
		<?php
		$penjualan = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
		->from('pmm_productions pp')
		->join('penerima p', 'pp.client_id = p.id','left')
		->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
		->where("pp.date_production between '$date1' and '$date2'")
		->where("pp.product_id in (3,4,7,8,14,24)")
		->where("pp.status = 'PUBLISH'")
		->where("ppo.status in ('OPEN','CLOSED')")
		->group_by("pp.client_id")
		->get()->result_array();
		
		$total_penjualan = 0;
		$total_volume = 0;

		foreach ($penjualan as $x){
			$total_penjualan += $x['price'];
			$total_volume += $x['volume'];
		}
		?>

		<!-- HPPenjualan -->
		<!-- Stok Awal Barang Jadi -->
		<?php
		$last_production = $this->db->select('date')->order_by('date','desc')->limit(1,5)->get_where('pmm_remaining_materials_cat',array('status'=>'PUBLISH','material_id'=>'4'))->row_array();
		$last_production_2 = $this->db->select('date')->order_by('date','desc')->limit(1,3)->get_where('pmm_remaining_materials_cat',array('status'=>'PUBLISH','material_id'=>'4'))->row_array();

		$date1_old = date('Y-m-d', strtotime('+1 days', strtotime($last_production['date'])));
		$date2_old = date('Y-m-d', strtotime($last_production_2['date']));

		$tanggal_opening_balance = date('Y-m-d', strtotime('-1 days', strtotime($date1)));

		$stock_opname_bahan_jadi_bulan_lalu = $this->db->select('sum(cat.volume) as volume')
		->from('pmm_remaining_materials_cat cat ')
		->where("(cat.date = '$tanggal_opening_balance')")
		->where("cat.material_id in (3, 4, 7, 8)")
		->where("cat.status = 'PUBLISH'")
		->order_by('date','desc')->limit(1)
		->get()->row_array();

		$harga_satuan_bahan_jadi_bulan_lalu = $this->db->select('(pp.harga_satuan_bahan_jadi) as harga_satuan_bahan_jadi')
		->from('hpp pp')
		->where("(pp.date_hpp = '$tanggal_opening_balance')")
		->order_by('pp.date_hpp','desc')->limit(1)
		->get()->row_array();
		?>

		<!-- HPProduksi -->
		<!-- Bahan -->
		<?php
		$akumulasi_bahan_baku = $this->db->select('sum(pp.total_nilai_keluar) as boulder, sum(pp.total_nilai_keluar_2) as bbm')
		->from('akumulasi_bahan_baku pp')
		->where("(pp.date_akumulasi between '$date1' and '$date2')")
		->get()->row_array();

		$total_nilai_produksi_boulder = $akumulasi_bahan_baku['boulder'];
		$total_nilai_produksi_solar = $akumulasi_bahan_baku['bbm'];
		?>

		<!-- HPProduksi -->
		<!-- Alat -->
		<?php
		$stone_crusher_biaya = $this->db->select('sum(pdb.jumlah) as total')
		->from('pmm_biaya pb ')
		->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
		->where("pdb.akun = 101")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$stone_crusher_jurnal = $this->db->select('sum(pdb.debit) as total')
		->from('pmm_jurnal_umum pb ')
		->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
		->where("pdb.akun = 101")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$stone_crusher = $stone_crusher_biaya['total'] + $stone_crusher_jurnal['total'];
		
		$whell_loader_biaya = $this->db->select('sum(pdb.jumlah) as total')
		->from('pmm_biaya pb ')
		->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
		->where("pdb.akun = 104")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$whell_loader_jurnal = $this->db->select('sum(pdb.debit) as total')
		->from('pmm_jurnal_umum pb ')
		->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
		->where("pdb.akun = 104")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$whell_loader = $whell_loader_biaya['total'] + $whell_loader_jurnal['total'];
		
		$excavator = $this->db->select('sum(prm.display_price) as price')
		->from('pmm_receipt_material prm ')
		->where("prm.material_id = 18")
		->where("(prm.date_receipt between '$date1' and '$date2')")
		->get()->row_array();
		
		$genset_biaya = $this->db->select('sum(pdb.jumlah) as total')
		->from('pmm_biaya pb ')
		->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
		->where("pdb.akun = 197")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$genset_jurnal = $this->db->select('sum(pdb.debit) as total')
		->from('pmm_jurnal_umum pb ')
		->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
		->where("pdb.akun = 197")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$genset = $genset_biaya['total'] + $genset_jurnal['total'];
		
		$timbangan_biaya = $this->db->select('sum(pdb.jumlah) as total')
		->from('pmm_biaya pb ')
		->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
		->where("pdb.akun = 198")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$timbangan_biaya_jurnal = $this->db->select('sum(pdb.debit) as total')
		->from('pmm_jurnal_umum pb ')
		->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
		->where("pdb.akun = 198")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$timbangan = $timbangan_biaya['total'] + $timbangan_biaya_jurnal['total'];
		
		$tangki_solar_biaya = $this->db->select('sum(pdb.jumlah) as total')
		->from('pmm_biaya pb ')
		->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
		->where("pdb.akun = 207")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$tangki_solar_jurnal = $this->db->select('sum(pdb.debit) as total')
		->from('pmm_jurnal_umum pb ')
		->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
		->where("pdb.akun = 207")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$tangki_solar = $tangki_solar_biaya['total'] + $tangki_solar_jurnal['total'];		
		
		$total_biaya_peralatan = $stone_crusher + $whell_loader + $excavator['price'] + $genset + $timbangan + $tangki_solar;
		?>

		<!-- HPProduksi -->
		<!-- Overhead -->
		<?php
		$gaji_upah_biaya = $this->db->select('sum(pdb.jumlah) as total')
		->from('pmm_biaya pb ')
		->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
		->where("pdb.akun in (199,200)")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$gaji_upah_jurnal = $this->db->select('sum(pdb.debit) as total')
		->from('pmm_jurnal_umum pb ')
		->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
		->where("pdb.akun in (199,200)")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$gaji_upah = $gaji_upah_biaya['total'] + $gaji_upah_jurnal['total'];
		
		$konsumsi_biaya = $this->db->select('sum(pdb.jumlah) as total')
		->from('pmm_biaya pb ')
		->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
		->where("pdb.akun = 201")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$konsumsi_jurnal = $this->db->select('sum(pdb.debit) as total')
		->from('pmm_jurnal_umum pb ')
		->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
		->where("pdb.akun = 201")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$konsumsi = $konsumsi_biaya['total'] + $konsumsi_jurnal['total'];
		
		$thr_bonus_biaya = $this->db->select('sum(pdb.jumlah) as total')
		->from('pmm_biaya pb ')
		->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
		->where("pdb.akun = 202")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$thr_bonus_jurnal = $this->db->select('sum(pdb.debit) as total')
		->from('pmm_jurnal_umum pb ')
		->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
		->where("pdb.akun = 202")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$thr_bonus = $thr_bonus_biaya['total'] + $thr_bonus_jurnal['total'];
		
		$perbaikan_biaya = $this->db->select('sum(pdb.jumlah) as total')
		->from('pmm_biaya pb ')
		->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
		->where("pdb.akun = 203")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$perbaikan_jurnal = $this->db->select('sum(pdb.debit) as total')
		->from('pmm_jurnal_umum pb ')
		->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
		->where("pdb.akun = 203")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();
		
		$perbaikan = $perbaikan_biaya['total'] + $perbaikan_jurnal['total'];

		$akomodasi_tamu_biaya = $this->db->select('sum(pdb.jumlah) as total')
		->from('pmm_biaya pb ')
		->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
		->where("pdb.akun = 204")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$akomodasi_tamu_jurnal = $this->db->select('sum(pdb.debit) as total')
		->from('pmm_jurnal_umum pb ')
		->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
		->where("pdb.akun = 204")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$akomodasi_tamu = $akomodasi_tamu_biaya['total'] + $akomodasi_tamu_jurnal['total'];
		
		$pengujian_biaya = $this->db->select('sum(pdb.jumlah) as total')
		->from('pmm_biaya pb ')
		->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
		->where("pdb.akun = 205")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$pengujian_jurnal = $this->db->select('sum(pdb.debit) as total')
		->from('pmm_jurnal_umum pb ')
		->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
		->where("pdb.akun = 205")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$pengujian = $pengujian_biaya['total'] + $pengujian_jurnal['total'];
		
		$listrik_internet_biaya = $this->db->select('sum(pdb.jumlah) as total')
		->from('pmm_biaya pb ')
		->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
		->where("pdb.akun = 206")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();

		$listrik_internet_jurnal = $this->db->select('sum(pdb.debit) as total')
		->from('pmm_jurnal_umum pb ')
		->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
		->where("pdb.akun = 206")
		->where("status = 'PAID'")
		->where("(tanggal_transaksi between '$date1' and '$date2')")
		->get()->row_array();
		
		$listrik_internet = $listrik_internet_biaya['total'] + $listrik_internet_jurnal['total'];

		$total_operasional = $gaji_upah + $konsumsi + $thr_bonus + $perbaikan + $akomodasi_tamu + $pengujian + $listrik_internet;
		?>

		<!--  Jumlah HPProduksi (Tanpa Limbah)  -->
		<?php
		$rekapitulasi_produksi_harian = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a,  (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b,  (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c,  (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d,  (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e')
		->from('pmm_produksi_harian pph ')
		->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
		->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id','left')
		->where("(pph.date_prod between '$date1' and '$date2')")
		->where('pph.status','PUBLISH')
		->get()->row_array();
		$total_rekapitulasi_produksi_harian = round($rekapitulasi_produksi_harian['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_d'],2);
		?>

		<!-- Persediaan Akhir Bahan Jadi -->
		<?php
		$stock_opname_bahan_jadi_bulan_akhir = $this->db->select('sum(cat.volume) as volume')
		->from('pmm_remaining_materials_cat cat ')
		->where("(cat.date = '$date2')")
		->where("cat.material_id in (3, 4, 7, 8)")
		->where("cat.status = 'PUBLISH'")
		->order_by('date','desc')->limit(1)
		->get()->row_array();
		?>

		<table class="table-lap" width="98%" border="0" cellpadding="3">
			<tr class="table-active" style="">
				<td width="50%" colspan="5">
					<div style="display: block;font-weight: bold;font-size: 8px;">PERIODE</div>
				</td>
				<td align="right" width="50%">
					<div style="display: block;font-weight: bold;font-size: 8px;"><?php echo $filter_date;?></div>
				</td>
			</tr>
			<tr class="table-active3">
				<th align="center" width="5%"><b>NO.</b></th>
				<th align="left" width="35%"><b>URAIAN</b></th>
				<th align="right" width="20%"><b>VOLUME (SATUAN)</b></th>
				<th align="right" width="25%"><b>NILAI (RP.)</b></th>
				<th align="right" width="15%"><b>HARGA</b></th>
			</tr>
			<tr style="font-weight:bold;">
				<th align="center">1.</th>
				<th align="left">Pendapatan / Penjualan</th>
				<th align="right"></th>
				<th align="right"></th>
				<th align="right"></th>
			</tr>
			<tr style="font-weight:bold;">
				<th align="center"></th>
				<th align="left">&nbsp;&nbsp;&nbsp;Total Pendapatan / Penjualan</th>
				<th align="right"><?php echo number_format($total_volume,2,',','.');?> (Ton)</th>
				<th align="right"><?php echo number_format($total_penjualan,0,',','.');?></th>
				<th align="right"><?php echo number_format($total_penjualan / $total_volume,0,',','.');?></th>
			</tr>
			<tr style="font-weight:bold;">
				<th align="center">2.</th>
				<th align="left">HPPenjualan</th>
				<th align="right"></th>
				<th align="right"></th>
				<th align="right"></th>
			</tr>
			<tr style="font-weight:bold;">
				<th align="center"></th>
				<th align="left">&nbsp;&nbsp;&nbsp;Stok Awal Barang Jadi</th>
				<th align="right"><?php echo number_format($stock_opname_bahan_jadi_bulan_lalu['volume'],2,',','.');?> (Ton)</th>
				<th align="right"><?php echo number_format(round($stock_opname_bahan_jadi_bulan_lalu['volume'],2) * $harga_satuan_bahan_jadi_bulan_lalu['harga_satuan_bahan_jadi'],0,',','.');?></th>
				<th align="right"><?php echo number_format($harga_satuan_bahan_jadi_bulan_lalu['harga_satuan_bahan_jadi'],0,',','.');?></th>
			</tr>
			<tr style="font-weight:bold;">
				<th align="center">3.</th>
				<th align="left">HPProduksi</th>
				<th align="right"></th>
				<th align="right"></th>
				<th align="right"></th>
			</tr>
			<tr style="font-weight:bold;">
				<th align="center"></th>
				<th align="left">&nbsp;&nbsp;&nbsp;Bahan</th>
				<th align="right"><?php echo number_format($total_volume_produksi_boulder,2,',','.');?> (Ton)</th>
				<th align="right"><?php echo number_format($total_nilai_produksi_boulder,0,',','.');?></th>
				<th align="right"></th>
			</tr>
			<tr style="font-weight:bold;">
				<th align="center"></th>
				<th align="left">&nbsp;&nbsp;&nbsp;Alat</th>
				<th align="right"></th>
				<th align="right"><?php echo number_format($total_biaya_peralatan + $total_nilai_produksi_solar,0,',','.');?></th>
				<th align="right"></th>
			</tr>
			<tr style="font-weight:bold;">
				<th align="center"></th>
				<th align="left">&nbsp;&nbsp;&nbsp;Overhead (Biaya Langsung)</th>
				<th align="right"></th>
				<th align="right"><?php echo number_format($total_operasional,0,',','.');?></th>
				<th align="right"></th>
			</tr>
			<tr style="font-weight:bold;">
				<th align="center"></th>
				<th align="left">&nbsp;&nbsp;&nbsp;Jumlah HPProduksi (Tanpa Limbah)</th>
				<th align="right"><?php echo number_format($total_rekapitulasi_produksi_harian,2,',','.');?> (Ton)</th>
				<th align="right"><?php echo number_format($total_nilai_produksi_boulder + $total_biaya_peralatan + $total_nilai_produksi_solar + $total_operasional,0,',','.');?></th>
				<?php
				$harga_hpproduksi = ($total_rekapitulasi_produksi_harian!=0)?($total_rekapitulasi_produksi_harian * $harga_bpp) / $total_rekapitulasi_produksi_harian * 100:0;
				?>
				<th align="right"><?php echo number_format($harga_hpproduksi,0,',','.');?></th>
			</tr>
			<tr style="font-weight:bold;">
				<th align="center">4.</th>
				<th align="left">Harga Pokok Penjualan (Siap Jual)</th>
				<th align="right"><?php echo number_format($stock_opname_bahan_jadi_bulan_lalu['volume'] + $total_rekapitulasi_produksi_harian,2,',','.');?> (Ton)</th>
				<th align="right"><?php echo number_format(($stock_opname_bahan_jadi_bulan_lalu['volume'] * $harga_satuan_bahan_jadi_bulan_lalu['harga_satuan_bahan_jadi']) + $total_nilai_produksi_boulder + $total_biaya_peralatan + $total_nilai_produksi_solar + $total_operasional,0,',','.');?></th>
				<?php
				$harga_siap_jual = (($stock_opname_bahan_jadi_bulan_lalu['volume'] * $harga_satuan_bahan_jadi_bulan_lalu['harga_satuan_bahan_jadi']) + $total_nilai_produksi_boulder + $total_biaya_peralatan + $total_nilai_produksi_solar + $total_operasional) / ($stock_opname_bahan_jadi_bulan_lalu['volume'] + $total_rekapitulasi_produksi_harian);
				$harga_siap_jual_new = round($harga_siap_jual,0);
				?>
				<th align="right" style="color:blue;"><?php echo number_format($harga_siap_jual,0,',','.');?></th>
			</tr>
			<tr style="font-weight:bold;">
				<th align="center">5.</th>
				<th align="left">Persediaan Akhir Bahan Jadi</th>
				<th align="right"><?php echo number_format($stock_opname_bahan_jadi_bulan_akhir['volume'],2,',','.');?> (Ton)</th>
				<th align="right"><?php echo number_format(round($stock_opname_bahan_jadi_bulan_akhir['volume'],2) * $harga_siap_jual_new,0,',','.');?></th>
				<th align="right"></th>
			</tr>
			<tr style="font-weight:bold;">
				<th align="center">6.</th>
				<th align="left">Jumlah Harga Pokok Penjualan</th>
				<th align="right"><?php echo number_format(($stock_opname_bahan_jadi_bulan_lalu['volume'] + $total_rekapitulasi_produksi_harian) - $stock_opname_bahan_jadi_bulan_akhir['volume'],2,',','.');?> (Ton)</th>
				<th align="right"><?php echo number_format((($stock_opname_bahan_jadi_bulan_lalu['volume'] * $harga_satuan_bahan_jadi_bulan_lalu['harga_satuan_bahan_jadi']) + $total_nilai_produksi_boulder + $total_biaya_peralatan + $total_nilai_produksi_solar + $total_operasional) - (round($stock_opname_bahan_jadi_bulan_akhir['volume'],2) * $harga_siap_jual_new),0,',','.');?></th>
				<th align="right"></th>
			</tr>
			<tr style="font-weight:bold;">
				<th align="center">7.</th>
				<th align="left">Jumlah Faktor Kehilangan</th>
				<th align="right"><?php echo number_format($stock_opname_bahan_jadi_bulan_lalu['volume'] + $total_rekapitulasi_produksi_harian - $total_volume - $stock_opname_bahan_jadi_bulan_akhir['volume'],2,',','.');?> (Ton)</th>
				<th align="right" style="color:green;"><?php echo number_format(($stock_opname_bahan_jadi_bulan_lalu['volume'] + $total_rekapitulasi_produksi_harian - $total_volume - $stock_opname_bahan_jadi_bulan_akhir['volume']) * $harga_siap_jual,0,',','.');?></th>
				<th align="right"></th>
			</tr>
		</table>
	</body>
</html>