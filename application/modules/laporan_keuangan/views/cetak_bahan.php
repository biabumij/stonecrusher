<!DOCTYPE html>
<html>
	<head>
	  <title>BAHAN BAKU</title>
	  <?= include 'lib.php'; ?>
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

	  	table tr.table-active{
            background-color: #e69500;
			font-size: 8px;
			font-weight: bold;
		}
			
		table tr.table-active2{
			font-size: 8px;
		}
			
		table tr.table-active3{
			font-size: 8px;
		}
			
		table tr.table-active4{
			background-color: #D0D0D0;
			font-weight: bold;
			font-size: 8px;
		}
		
		tr.border-bottom td {
        	border-bottom: 1pt solid #ff000d;
      }
	  </style>

	</head>
	<body>
		<br />
		<br />
		<table width="98%" cellpadding="3">
			<tr>
				<td align="center"  width="100%">
					<div style="display: block;font-weight: bold;font-size: 12px;">BAHAN</div>
					<div style="display: block;font-weight: bold;font-size: 12px; text-transform: uppercase;">PERIODE <?php echo str_replace($search, $replace, $subject);?></div>
				</td>
			</tr>
		</table>
		<br />
		<br />
		<br />
		<?php
		$data = array();
		
		$arr_date = $this->input->get('filter_date');
		$arr_filter_date = explode(' - ', $arr_date);
		$date3 = '';
		$date1 = '';
		$date2 = '';

		if(count($arr_filter_date) == 2){
			$date3 	= date('2023-08-01',strtotime($date3));
			$date1 	= date('Y-m-d',strtotime($arr_filter_date[0]));
			$date2 	= date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d/m/Y',strtotime($arr_filter_date[0])).' - '.date('d/m/Y',strtotime($arr_filter_date[1]));
			$filter_date_2 = date('Y-m-d',strtotime($date3)).' - '.date('Y-m-d',strtotime($arr_filter_date[1]));
		}
		
		?>

		<table width="98%" border="0" cellpadding="3">
			<!--  Jumlah HPProduksi -->
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
			
			<!-- Total Pendapatan / Penjualan -->
			<?php
			$penjualan = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
			->from('pmm_productions pp')
			->join('penerima p', 'pp.client_id = p.id','left')
			->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
			->where("pp.date_production between '$date1' and '$date2'")
			->where("pp.product_id in (3,4,7,8,9,14,24,63)")
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

			$nilai_persediaan_bahan_jadi = $this->db->select('(pp.nilai) as nilai')
			->from('kunci_bahan_jadi pp')
			->where("(pp.date = '$tanggal_opening_balance')")
			->order_by('pp.date','desc')->limit(1)
			->get()->row_array();
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
			<tr class="table-active">
	            <th width="5%" align="center" rowspan="2">&nbsp; <br />NO.</th>
				<th width="20%"  align="left" rowspan="2">&nbsp; <br />URAIAN</th>
				<th width="25%"  align="center" colspan="3">RAP</th>
				<th width="25%"  align="center" colspan="3">REALISASI</th>
				<th width="25%"  align="center" colspan="3">DEVIASI</th>
	        </tr>
			<tr class="table-active">
	            <th align="right">VOL (TON)</th>
				<th align="right">HARSAT</th>
				<th align="right">NILAI</th>
				<th align="right">VOL (TON)</th>
				<th align="right">HARSAT</th>
				<th align="right">NILAI</th>
				<th align="right">VOL (TON)</th>
				<th align="right">HARSAT</th>
				<th align="right">NILAI</th>
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

			$rumus_overhead = ($row['overhead'] / 25) / 8;
			$rumus_overhead_1 = ($row['kapasitas_alat_sc'] * $row['efisiensi_alat_sc']) / $row['berat_isi_batu_pecah'] ;
			//$overhead = $rumus_overhead / $rumus_overhead_1;

			$rumus_overhead_ton = $row['kapasitas_alat_sc'] * $row['efisiensi_alat_sc'];
			$overhead_ton = $rumus_overhead / $rumus_overhead_ton;
			$overhead = $overhead_ton;

			$total = $nilai_boulder + $nilai_tangki + $nilai_sc + $nilai_gns + $nilai_wl + $nilai_timbangan + $overhead + $nilai_bbm_solar;
			$total_ton = $nilai_boulder_ton + $nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $overhead_ton + $nilai_bbm_solar_ton;
			?>
			<?php
			//Opening Balance
			$date1_ago = date('2020-01-01');
			$date2_ago = date('Y-m-d', strtotime('-1 days', strtotime($date1)));
			$date3_ago = date('Y-m-d', strtotime('-1 months', strtotime($date1)));
			$tanggal_opening_balance = date('Y-m-d', strtotime('-1 days', strtotime($date1)));

			$stock_opname_batu_boulder_ago = $this->db->select('pp.vol_nilai_boulder as volume')
			->from('kunci_bahan_baku pp')
			->where("(pp.date = '$tanggal_opening_balance')")
			->order_by('pp.date','desc')->limit(1)
			->get()->row_array();
			
			$harga_boulder = $this->db->select('pp.nilai_boulder as nilai_boulder')
			->from('kunci_bahan_baku pp')
			->where("(pp.date between '$date3_ago' and '$date2_ago')")
			->order_by('pp.date','desc')->limit(1)
			->get()->row_array();

			$pembelian_boulder = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
			->from('pmm_receipt_material prm')
			->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
			->join('produk p', 'prm.material_id = p.id','left')
			->where("prm.date_receipt between '$date1' and '$date2'")
			->where("prm.material_id = 15")
			->group_by('prm.material_id')
			->get()->row_array();

			$rekapitulasi_produksi_harian = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
			->from('pmm_produksi_harian pph ')
			->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
			->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
			->where("(pph.date_prod between '$date1' and '$date2')")
			->where('pph.status','PUBLISH')
			->get()->row_array();
			$total_rekapitulasi_produksi_harian = round($rekapitulasi_produksi_harian['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_f'],2);
			?>

			<?php
			$stok_volume_boulder_lalu = $stock_opname_batu_boulder_ago['volume'];
			$stok_nilai_boulder_lalu = $harga_boulder['nilai_boulder'];
			$stok_harsat_boulder_lalu = (round($stok_volume_boulder_lalu,2)!=0)?$stok_nilai_boulder_lalu / round($stok_volume_boulder_lalu,2) * 1:0;
		
			$pembelian_volume = $pembelian_boulder['volume'];
			$pembelian_nilai = $pembelian_boulder['nilai'];
			$pembelian_harga = (round($pembelian_volume,2)!=0)?$pembelian_nilai / round($pembelian_volume,2) * 1:0;

			$total_stok_volume = $stok_volume_boulder_lalu + $pembelian_volume;
			$total_stok_nilai = $stok_nilai_boulder_lalu + $pembelian_nilai;

			$produksi_volume = $stok_volume_boulder_lalu;
			$produksi_harsat = $stok_harsat_boulder_lalu;
			$produksi_nilai = $stok_nilai_boulder_lalu;

			$key = 0;
			if($pembelian_harga == 0) {
				$key = $produksi_harsat;
			}

			if($pembelian_harga > 0) {
				$key = $pembelian_harga;
			}

			$produksi_2_volume = $total_rekapitulasi_produksi_harian - $produksi_volume;
			$produksi_2_harsat = $key;
			$produksi_2_nilai = $produksi_2_volume * $produksi_2_harsat;

			$total_produksi_volume = $produksi_volume + $produksi_2_volume;
			$total_produksi_nilai = $produksi_nilai + $produksi_2_nilai;

			$stok_akhir_volume = $total_stok_volume - $produksi_volume - $produksi_2_volume;
			$stok_akhir_nilai = $total_stok_nilai - $produksi_nilai - $produksi_2_nilai;
			?>

			<tr class="table-active3">
	            <th align="center"><b>1</b></th>
				<th align="left"><b>BOULDER</b></th>
				<th align="right"><?php echo number_format($total_rekapitulasi_produksi_harian,2,',','.');?></th>
				<th align="right"><?php echo number_format($nilai_boulder_ton,0,',','.');?></th>
				<th align="right"><?php echo number_format($nilai_boulder_ton * round($total_rekapitulasi_produksi_harian,2),0,',','.');?></th>
				<th align="right"><?php echo number_format($total_rekapitulasi_produksi_harian,2,',','.');?></th>
				<?php
					$harga_baru = ($total_rekapitulasi_produksi_harian!=0)?$total_produksi_nilai / $total_rekapitulasi_produksi_harian * 1:0;
				?>
				<th align="right"><?php echo number_format($harga_baru,0,',','.');?></th>
				<th align="right"><?php echo number_format($total_produksi_nilai,0,',','.');?></th>
				<?php
					$nilai_evaluasi_bahan = ($nilai_boulder_ton * round($total_rekapitulasi_produksi_harian,2)) - ($total_rekapitulasi_produksi_harian * $harga_baru);
					$styleColor = $nilai_evaluasi_bahan < 0 ? 'color:red' : 'color:black';
				?>
				<th align="right"><?php echo number_format($total_rekapitulasi_produksi_harian,0,',','.');?></th>
				<th align="right"><?php echo number_format($nilai_boulder_ton,0,',','.');?></th>
				<th align="right" style="<?php echo $styleColor ?>"><?php echo $nilai_evaluasi_bahan < 0 ? "(".number_format(-$nilai_evaluasi_bahan,0,',','.').")" : number_format($nilai_evaluasi_bahan,0,',','.');?></th>
	        </tr>
			<tr class="table-active4">
				<th align="right" colspan="2">TOTAL</th>
				<th align="right"></th>
				<th align="right"></th>
				<th align="right"><?php echo number_format($nilai_boulder_ton * round($total_rekapitulasi_produksi_harian,2),0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
				<th align="right"><?php echo number_format($total_rekapitulasi_produksi_harian * $harga_baru,0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
				<th align="right" style="<?php echo $styleColor ?>"><?php echo $nilai_evaluasi_bahan < 0 ? "(".number_format(-$nilai_evaluasi_bahan,0,',','.').")" : number_format($nilai_evaluasi_bahan,0,',','.');?></th>
			</tr>
		</table>
		<?php
		if(in_array($this->session->userdata('admin_group_id'), array(1))){
		?>
		<br /><br />
		<b>* Perhitungan Boulder</b><br /><br />
		<table width="98%" border="0" cellpadding="3" style="font-size: 6px;">
			<tr>
				<th align="left" width="25%" style="font-weight:bold; background-color:white; color:black;">Stok Boulder Bulan Lalu (<?= convertDateDBtoIndo($date2_ago); ?>)</th>
				<th align="right" width="10%" style="font-weight:bold; background-color:white; color:black;"><?php echo number_format($stok_volume_boulder_lalu,2,',','');?> (Ton)</th>
				<th align="right" width="10%" style="font-weight:bold; background-color:white; color:black;"><?php echo number_format($stok_harsat_boulder_lalu,0,',','.');?></th>
				<th align="right" width="10%" style="font-weight:bold; background-color:white; color:black;"><?php echo number_format($stok_nilai_boulder_lalu,0,',','.');?></th>
			</tr>
			<tr>
				<th align="left" style="font-weight:bold; background-color:white; color:black;">Pembelian Boulder Bulan Ini</th>
				<th align="right" style="font-weight:bold; background-color:white; color:black;"><?php echo number_format($pembelian_volume,2,',','');?> (Ton)</th>
				<th align="right" width="10%" style="font-weight:bold; background-color:white; color:black;"><?php echo number_format($pembelian_harga,0,',','.');?></th>
				<th align="right" width="10%" style="font-weight:bold; background-color:white; color:black;"><?php echo number_format($pembelian_nilai,0,',','.');?></th>
			</tr>
			<tr>
				<th align="left" style="font-weight:bold; background-color:grey; color:white;">Total Stok Boulder Bulan Ini</th>
				<th align="right" style="font-weight:bold; background-color:grey; color:white;"><?php echo number_format($total_stok_volume,2,',','');?> (Ton)</th>
				<th align="right" width="10%" style="font-weight:bold; background-color:grey; color:white;"></th>
				<th align="right" width="10%" style="font-weight:bold; background-color:grey; color:white;"><?php echo number_format($total_stok_nilai,0,',','.');?></th>
			</tr>
			<tr>
				<th align="left" style="font-weight:bold; background-color:white; color:black;">Produksi Bulan Ini (1)</th>
				<th align="right" style="font-weight:bold; background-color:white; color:black;"><?php echo number_format($produksi_volume,2,',','');?> (Ton)</th>
				<th align="right" width="10%" style="font-weight:bold; background-color:white; color:black;"><?php echo number_format($produksi_harsat,0,',','.');?></th>
				<th align="right" width="10%" style="font-weight:bold; background-color:white; color:black;"><?php echo number_format($produksi_nilai,0,',','.');?></th>
			</tr>
			<tr>
				<th align="left" style="font-weight:bold; background-color:white; color:black;">Produksi Bulan Ini (2)</th>
				<th align="right" style="font-weight:bold; background-color:white; color:black;"><?php echo number_format($produksi_2_volume,2,',','');?> (Ton)</th>
				<th align="right" width="10%" style="font-weight:bold; background-color:white; color:black;"><?php echo number_format($produksi_2_harsat,0,',','.');?></th>
				<th align="right" width="10%" style="font-weight:bold; background-color:white; color:black;"><?php echo number_format($produksi_2_nilai,0,',','.');?></th>
			</tr>
			<tr>
				<th align="left" style="font-weight:bold; background-color:grey; color:white;">Total Produksi Bulan Ini</th>
				<th align="right" style="font-weight:bold; background-color:grey; color:white;"><?php echo number_format($total_produksi_volume,2,',','');?> (Ton)</th>
				<th align="right" width="10%" style="font-weight:bold; background-color:grey; color:white;"></th>
				<th align="right" width="10%" style="font-weight:bold; background-color:grey; color:white;"><?php echo number_format($total_produksi_nilai,0,',','.');?></th>
			</tr>
			<tr>
				<th align="left" style="font-weight:bold; background-color:red; color:white;">Stok Bahan Baku Akhir</th>
				<th align="right" style="font-weight:bold; background-color:red; color:white;"><?php echo number_format($stok_akhir_volume,2,',','');?> (Ton)</th>
				<th align="right" style="font-weight:bold; background-color:red; color:white;"></th>
				<th align="right" style="font-weight:bold; background-color:red; color:white;"><?php echo number_format($stok_akhir_nilai,0,',','.');?></th>
			</tr>
		</table>
		<?php
		}
		?>
	</body>
</html>