<!DOCTYPE html>
<html>
	<head>
	  <title>LAPORAN LABA RUGI</title>
	  
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
	  	table tr.table-active{
            background-color: #e69500;
			font-size: 9px;
		}
			
		table tr.table-active2{
			font-size: 9px;
		}
			
		table tr.table-active3{
			font-size: 9px;
		}
			
		table tr.table-active4{
			background-color: #D0D0D0;
			font-weight: bold;
			font-size: 9px;
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
					<div style="display: block;font-weight: bold;font-size: 12px;">LAPORAN LABA RUGI<br/>
					<div style="text-transform: uppercase;">PERIODE <?php echo str_replace($search, $replace, $subject);?></div></div>
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
			$date3 	= date('2021-01-01',strtotime($date3));
			$date1 	= date('Y-m-d',strtotime($arr_filter_date[0]));
			$date2 	= date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d/m/Y',strtotime($arr_filter_date[0])).' - '.date('d/m/Y',strtotime($arr_filter_date[1]));
			$filter_date_2 = date('Y-m-d',strtotime($date3)).' - '.date('Y-m-d',strtotime($arr_filter_date[1]));
		}
		
		?>
		
		<table width="98%" border="0" cellpadding="3">
		
			<?php
			$penjualan_limbah = $this->db->select('SUM(pp.display_price) as price')
			->from('pmm_productions pp')
			->join('penerima p', 'pp.client_id = p.id','left')
			->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
			->where("pp.date_production between '$date1' and '$date2'")
			->where("pp.product_id = 9 ")
			->where("pp.status = 'PUBLISH'")
			->where("ppo.status in ('OPEN','CLOSED')")
			->group_by("pp.client_id")
			->get()->result_array();

			$total_penjualan_limbah = 0;
			foreach ($penjualan_limbah as $y){
				$total_penjualan_limbah += $y['price'];
			}

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
			$measure = 0;

			foreach ($penjualan as $x){
				$total_penjualan += $x['price'];
				$total_volume += $x['volume'];
			}

			$total_penjualan_all = 0;
			$total_penjualan_all = $total_penjualan;

			?>

			<!--BEBAN POKOK PENJUALAN-->
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

			$nilai_persediaan_bahan_jadi = $this->db->select('(pp.nilai) as nilai')
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

			$faktor_kehilangan = $this->db->select('sum(pp.faktor_kehilangan) as faktor_kehilangan')
			->from('hpp pp')
			->where("(pp.date_hpp between '$date1' and '$date2')")
			->order_by('pp.date_hpp','desc')->limit(1)
			->get()->row_array();

			$nilai_hpp_siap_jual = $nilai_persediaan_bahan_jadi['nilai'] + $total_nilai_produksi_boulder + $total_biaya_peralatan + $total_nilai_produksi_solar + $total_operasional;
			$harga_siap_jual = ($nilai_persediaan_bahan_jadi['nilai'] + $total_nilai_produksi_boulder + $total_biaya_peralatan + $total_nilai_produksi_solar + $total_operasional) / ($stock_opname_bahan_jadi_bulan_lalu['volume'] + $total_rekapitulasi_produksi_harian);
			$nilai_persediaan_akhir = round($stock_opname_bahan_jadi_bulan_akhir['volume'],2) * $harga_siap_jual;
			$nilai_harga_pokok_penjualan = $nilai_hpp_siap_jual - $nilai_persediaan_akhir;

			$beban_pokok_penjualan = $nilai_harga_pokok_penjualan - $faktor_kehilangan['faktor_kehilangan'];
			?>
			<!-- BEBAN POKOK PENJUALAN -->
			
			<?php
			$biaya_umum_administratif_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->join('pmm_coa c','pdb.akun = c.id','left')
			->where('c.coa_category',16)
			->where("pb.status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();

			$biaya_umum_administratif_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->join('pmm_coa c','pdb.akun = c.id','left')
			->where('c.coa_category',16)
			->where("pb.status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();

			$biaya_lainnya_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->join('pmm_coa c','pdb.akun = c.id','left')
			->where('c.coa_category',17)
			->where("pb.status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();

			$biaya_lainnya_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->join('pmm_coa c','pdb.akun = c.id','left')
			->where('c.coa_category',17)
			->where("pb.status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();

			$akumulasi_bahan_baku = $this->db->select('pp.date_akumulasi, (pp.total_nilai_keluar) as total, SUM(pp.total_nilai_keluar_2) as total_2, SUM(pp.total_nilai_akhir) as total_akhir')
			->from('akumulasi_bahan_baku pp')
			->where("(pp.date_akumulasi = '$date2')")
			->order_by('pp.date_akumulasi','desc')->limit(1)
			->get()->row_array();

			$biaya_umum_administratif = $biaya_umum_administratif_biaya['total'] + $biaya_umum_administratif_jurnal['total'];
			$biaya_lainnya = $biaya_lainnya_biaya['total'] + $biaya_lainnya_jurnal['total'];

			$total_harga_pokok_pendapatan = $beban_pokok_penjualan;
			$laba_kotor = $total_penjualan_all - $total_harga_pokok_pendapatan;
			$laba_usaha = $laba_kotor - ($biaya_umum_administratif + $biaya_lainnya);

			$nilai_akhir_pergerakan_bahan_baku = $this->db->select('sum(pp.total_nilai_akhir) as total_nilai_akhir')
			->from('akumulasi_bahan_baku pp')
			->where("(pp.date_akumulasi between '$date1' and '$date2')")
			->order_by('pp.date_akumulasi','desc')->limit(1)
			->get()->row_array();

			$persedian_bahan_jadi  = $stock_opname_bahan_jadi_bulan_akhir['volume'] * ($total_akumulasi_bahan_jadi_bulan_lalu + $total_nilai_produksi_boulder + $total_biaya_peralatan + $total_nilai_produksi_solar + $total_operasional) / ($stock_opname_bahan_jadi_bulan_lalu['volume'] + $total_rekapitulasi_produksi_harian);

			$total = $laba_usaha + $nilai_akhir_pergerakan_bahan_baku['total_nilai_akhir'] + $persedian_bahan_jadi + $total_penjualan_limbah;
			$persentase = ($total_penjualan_all!=0)?($laba_usaha / $total_penjualan_all)  * 100:0;

			//AKUMULASI 2
			$penjualan_limbah_2 = $this->db->select('SUM(pp.display_price) as price')
			->from('pmm_productions pp')
			->join('penerima p', 'pp.client_id = p.id','left')
			->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
			->where("pp.date_production between '$date3' and '$date2'")
			->where("pp.product_id = 9 ")
			->where("pp.status = 'PUBLISH'")
			->where("ppo.status in ('OPEN','CLOSED')")
			->group_by("pp.client_id")
			->get()->result_array();

			$total_penjualan_limbah_2 = 0;
			foreach ($penjualan_limbah_2 as $y){
				$total_penjualan_limbah_2 += $y['price'];
			}

			$penjualan_2 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
			->from('pmm_productions pp')
			->join('penerima p', 'pp.client_id = p.id','left')
			->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
			->where("pp.date_production between '$date3' and '$date2'")
			->where("pp.product_id in (3,4,7,8,14,24)")
			->where("pp.status = 'PUBLISH'")
			->where("ppo.status in ('OPEN','CLOSED')")
			->group_by("pp.client_id")
			->get()->result_array();
			
			$total_penjualan_2 = 0;
			$total_volume_2 = 0;

			foreach ($penjualan_2 as $x){
				$total_penjualan_2 += $x['price'];
				$total_volume_2 += $x['volume'];
			}

			$total_penjualan_all_2 = 0;
			$total_penjualan_all_2 = $total_penjualan_2;

			?>

			<?php
			$biaya_umum_administratif_biaya_2 = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->join('pmm_coa c','pdb.akun = c.id','left')
			->where('c.coa_category',16)
			->where("pb.status = 'PAID'")
			->where("(tanggal_transaksi between '$date3' and '$date2')")
			->get()->row_array();

			$biaya_umum_administratif_jurnal_2 = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->join('pmm_coa c','pdb.akun = c.id','left')
			->where('c.coa_category',16)
			->where("pb.status = 'PAID'")
			->where("(tanggal_transaksi between '$date3' and '$date2')")
			->get()->row_array();

			$biaya_lainnya_biaya_2 = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->join('pmm_coa c','pdb.akun = c.id','left')
			->where('c.coa_category',17)
			->where("pb.status = 'PAID'")
			->where("(tanggal_transaksi between '$date3' and '$date2')")
			->get()->row_array();

			$biaya_lainnya_jurnal_2 = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->join('pmm_coa c','pdb.akun = c.id','left')
			->where('c.coa_category',17)
			->where("pb.status = 'PAID'")
			->where("(tanggal_transaksi between '$date3' and '$date2')")
			->get()->row_array();

			$akumulasi_bahan_baku_2 = $this->db->select('pp.date_akumulasi, (pp.total_nilai_keluar) as total, SUM(pp.total_nilai_keluar_2) as total_2, SUM(pp.total_nilai_akhir) as total_akhir')
			->from('akumulasi_bahan_baku pp')
			->where("(pp.date_akumulasi = '$date2')")
			->order_by('pp.date_akumulasi','desc')->limit(1)
			->get()->row_array();

			$biaya_umum_administratif_2 = $biaya_umum_administratif_biaya_2['total'] + $biaya_umum_administratif_jurnal_2['total'];
			$biaya_lainnya_2 = $biaya_lainnya_biaya_2['total'] + $biaya_lainnya_jurnal_2['total'];
	        ?>
				<th width="25%" align="center">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span>Rp.</span>
								</th>
								<th align="center" width="80%">
									<span><?php echo number_format($total_harga_pokok_pendapatan_2,0,',','.');?></span>
								</th>
							</tr>
					</table>
				</th>
	        </tr>
			<hr width="98%">
			<tr class="table-active2">
				<th width="50%" align="left"><b>Total Harga Pokok Pendapatan</b></th>
	            <th width="25%" align="right">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span><b>Rp.</b></span>
								</th>
								<th align="center" width="80%">
									<span><b><?php echo number_format($total_harga_pokok_pendapatan,0,',','.');?></b></span>
								</th>
							</tr>
					</table>
				</th>
				<th width="25%" align="right">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span><b>Rp.</b></span>
								</th>
								<th align="center" width="80%">
									<span><b><?php echo number_format($total_harga_pokok_pendapatan_2,0,',','.');?></b></span>
								</th>
							</tr>
					</table>
				</th>
	        </tr>
			<tr class="table-active3">
				<th width="100%" align="left"></th>
	        </tr>
			<?php
				$styleColor = $laba_kotor < 0 ? 'color:red' : 'color:black';
				$styleColor2 = $laba_kotor_2 < 0 ? 'color:red' : 'color:black';
			?>
			<tr class="table-active2">
	            <th width="50%" align="left"><b>Laba / Rugi Kotor</b></th>
	            <th width="25%" align="right" style="<?php echo $styleColor ?>">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span><b>Rp.</b></span>
								</th>
								<th align="center" width="80%">
									<span><b><?php echo $laba_kotor < 0 ? "(".number_format(-$laba_kotor,0,',','.').")" : number_format($laba_kotor,0,',','.');?></b></span>
								</th>
							</tr>
					</table>
				</th>
				<th width="25%" align="right" style="<?php echo $styleColor2 ?>">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span><b>Rp.</b></span>
								</th>
								<th align="center" width="80%">
									<span><b><?php echo $laba_kotor_2 < 0 ? "(".number_format(-$laba_kotor_2,0,',','.').")" : number_format($laba_kotor_2,0,',','.');?></b></span>
								</th>
							</tr>
					</table>
				</th>
	        </tr>
			<tr class="table-active3">
				<th width="100%" align="left"></th>
	        </tr>
			<tr class="table-active4">
				<th width="50%" colspan="3" align="left"><b>Biaya Umum & Administratif</b></th>
				<th width="25%" align="center">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span>Rp.</span>
								</th>
								<th align="center" width="80%">
									<span><?php echo number_format($biaya_umum_administratif,0,',','.');?></span>
								</th>
							</tr>
					</table>
				</th>
				<th width="25%" align="center">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span>Rp.</span>
								</th>
								<th align="center" width="80%">
									<span><?php echo number_format($biaya_umum_administratif_2,0,',','.');?></span>
								</th>
							</tr>
					</table>
				</th>
	        </tr>
			<tr class="table-active4">
				<th width="50%" colspan="3" align="left"><b>Biaya Lainnya</b></th>
				<th width="25%" align="center">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span>Rp.</span>
								</th>
								<th align="center" width="80%">
									<span><?php echo number_format($biaya_lainnya,0,',','.');?></span>
								</th>
							</tr>
					</table>
				</th>
				<th width="25%" align="center">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span>Rp.</span>
								</th>
								<th align="center" width="80%">
									<span><?php echo number_format($biaya_lainnya_2,0,',','.');?></span>
								</th>
							</tr>
					</table>
				</th>
	        </tr>
			<tr class="table-active3">
				<th width="100%" align="left"></th>
	        </tr>
			<?php
				$styleColor = $laba_usaha < 0 ? 'color:red' : 'color:black';
				$styleColorw = $laba_usaha_2 < 0 ? 'color:red' : 'color:black';
			?>	
			<tr class="table-active3">
	            <th width="50%" align="left"><b>Laba / Rugi Usaha</b></th>
	            <th width="25%" align="right" style="<?php echo $styleColor ?>">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span><b>Rp.</b></span>
								</th>
								<th align="center" width="80%">
									<span><b><?php echo $laba_usaha < 0 ? "(".number_format(-$laba_usaha,0,',','.').")" : number_format($laba_usaha,0,',','.');?></b></span>
								</th>
							</tr>
					</table>
				</th>
				<th width="25%" align="right" style="<?php echo $styleColor2 ?>">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span><b>Rp.</b></span>
								</th>
								<th align="center" width="80%">
									<span><b><?php echo $laba_usaha_2 < 0 ? "(".number_format(-$laba_usaha_2,0,',','.').")" : number_format($laba_usaha_2,0,',','.');?></b></span>
								</th>
							</tr>
					</table>
				</th>
	        </tr>
			<tr class="table-active3">
				<th width="100%" align="left"></th>
	        </tr>
			<tr class="table-active4">
	            <th width="50%" align="left"><b>Nilai Persediaan Bahan Baku</b></th>
	            <th width="25%" align="right">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span><b>Rp.</b></span>
								</th>
								<th align="center" width="80%">
									<span><b><?php echo number_format($nilai_akhir_pergerakan_bahan_baku['total_nilai_akhir'],0,',','.');?></b></span>
								</th>
							</tr>
					</table>
				</th>
				<th width="25%" align="right">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span><b>Rp.</b></span>
								</th>
								<th align="center" width="80%">
									<span><b><?php echo number_format($nilai_akhir_pergerakan_bahan_baku_2['total_nilai_akhir'],0,',','.');?></b></span>
								</th>
							</tr>
					</table>
				</th>
	        </tr>
			<tr class="table-active4">
	            <th width="50%" align="left"><b>Nilai Persediaan Barang Jadi</b></th>
	            <th width="25%" align="right">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span><b>Rp.</b></span>
								</th>
								<th align="center" width="80%">
									<span><b><?php echo number_format($persedian_bahan_jadi,0,',','.');?></b></span>
								</th>
							</tr>
					</table>
				</th>
				<th width="25%" align="right">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span><b>Rp.</b></span>
								</th>
								<th align="center" width="80%">
									<span><b><?php echo number_format($persedian_bahan_jadi_2,0,',','.');?></b></span>
								</th>
							</tr>
					</table>
				</th>
	        </tr>
			<tr class="table-active4">
	            <th width="50%" align="left"><b>Pendapatan Lain - Lain (Limbah)</b></th>
	            <th width="25%" align="right">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span><b>Rp.</b></span>
								</th>
								<th align="center" width="80%">
									<span><b><?php echo number_format($total_penjualan_limbah,0,',','.');?></b></span>
								</th>
							</tr>
					</table>
				</th>
				<th width="25%" align="right">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span><b>Rp.</b></span>
								</th>
								<th align="center" width="80%">
									<span><b><?php echo number_format($total_penjualan_limbah_2,0,',','.');?></b></span>
								</th>
							</tr>
					</table>
				</th>
	        </tr>
			<tr class="table-active3">
				<th width="100%" align="left"></th>
	        </tr>
			<?php
				$styleColor = $total < 0 ? 'color:red' : 'color:black';
				$styleColor2 = $total_2 < 0 ? 'color:red' : 'color:black';
			?>	
			<tr class="table-active3">
	            <th width="50%" align="left"><b>Total</b></th>
	            <th width="25%" align="right" style="<?php echo $styleColor ?>">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span><b>Rp.</b></span>
								</th>
								<th align="center" width="80%">
									<span><b><?php echo $total < 0 ? "(".number_format(-$total,0,',','.').")" : number_format($total,0,',','.');?></b></span>
								</th>
							</tr>
					</table>
				</th>
				<th width="25%" align="right" style="<?php echo $styleColor2 ?>">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span><b>Rp.</b></span>
								</th>
								<th align="center" width="80%">
									<span><b><?php echo $total_2 < 0 ? "(".number_format(-$total_2,0,',','.').")" : number_format($total_2,0,',','.');?></b></span>
								</th>
							</tr>
					</table>
				</th>
	        </tr>
	    </table>

		<table width="98%" border="0" cellpadding="30">
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
							$create = $this->db->select('id, unit_head, logistik, admin')
							->from('akumulasi_bahan_baku')
							->where("(date_akumulasi = '$end_date')")
							->order_by('id','desc')->limit(1)
							->get()->row_array();

							$this->db->select('a.admin_name, g.admin_group_name, a.admin_ttd');
							$this->db->join('tbl_admin_group g','a.admin_group_id = g.admin_group_id','left');
							$this->db->where('a.admin_id',$create['unit_head']);
							$unit_head = $this->db->get('tbl_admin a')->row_array();

							$dirut = $this->pmm_model->GetNameGroup(6);
						?>
						<tr class="">
							<td align="center" height="70px">
							
							</td>
							<td align="center">
								<img src="<?= $unit_head['admin_ttd']?>" width="70px">
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