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
		body {
			font-family: helvetica;
			font-size: 9px;
		}

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
			$date3 	= date('2023-08-01',strtotime($date3));
			$date1 	= date('Y-m-d',strtotime($arr_filter_date[0]));
			$date2 	= date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d/m/Y',strtotime($arr_filter_date[0])).' - '.date('d/m/Y',strtotime($arr_filter_date[1]));
			$filter_date_2 = date('Y-m-d',strtotime($date3)).' - '.date('Y-m-d',strtotime($arr_filter_date[1]));
		}
		
		?>
		
		<table width="98%" border="0" cellpadding="3">
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

			$total_penjualan_all = 0;
			$total_penjualan_all = $total_penjualan;

			$penjualan_limbah = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
			->from('pmm_productions pp')
			->join('penerima p', 'pp.client_id = p.id','left')
			->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
			->where("pp.date_production between '$date1' and '$date2'")
			->where("pp.product_id in (9)")
			->where("ppo.status in ('OPEN','CLOSED')")
			->group_by('pp.salesPo_id')
			->get()->result_array();

			$total_penjualan_limbah = 0;
			$total_volume_limbah = 0;

			foreach ($penjualan_limbah as $x){
				$total_penjualan_limbah += $x['price'];
				$total_volume_limbah += $x['volume'];
			}

			$penjualan_lain_lain = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
			->from('pmm_productions pp')
			->join('penerima p', 'pp.client_id = p.id','left')
			->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
			->where("pp.date_production between '$date1' and '$date2'")
			->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
			->where("ppo.status in ('OPEN','CLOSED')")
			->group_by('pp.salesPo_id')
			->get()->result_array();

			$total_penjualan_lain_lain = 0;
			$total_volume_lain_lain = 0;

			foreach ($penjualan_lain_lain as $x){
				$total_penjualan_lain_lain += $x['price'];
				$total_volume_lain_lain += $x['volume'];
			}

			$total_penjualan_all_lain_lain = 0;
			$total_penjualan_all_lain_lain = $total_penjualan_lain_lain;
			?>

			<?php
			$row = $this->db->select('r.*')
			->from('harga_jual r')
			->where("(r.tanggal_harga_jual <= '$date2')")
			->group_by("r.tanggal_harga_jual")->limit(1)
			->order_by('r.tanggal_harga_jual','desc')
			->get()->row_array();
			$harga_jual = $row['nilai_jual'];
			?>

			<!-- HPProduksi -->
			<!-- Bahan -->
			<?php
			$akumulasi_bahan_baku = $this->db->select('sum(pp.total_nilai_keluar) as boulder, sum(pp.total_nilai_keluar_2) as bbm')
			->from('akumulasi_bahan_baku_new pp')
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
			
			$nilai_realiasi = $total_nilai_produksi_boulder + $total_biaya_peralatan + $total_nilai_produksi_solar + $total_operasional;
			$rekapitulasi_produksi_harian = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
			->from('pmm_produksi_harian pph ')
			->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
			->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
			->where("(pph.date_prod between '$date1' and '$date2')")
			->where('pph.status','PUBLISH')
			->get()->row_array();
			$total_rekapitulasi_produksi_harian = round($rekapitulasi_produksi_harian['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_f'],2);
			$hpp =   $nilai_realiasi / round($total_rekapitulasi_produksi_harian,2);
			?>

			<?php
			$beban_pokok_penjualan = round($total_volume,2) * round($hpp,0);
			?>
			
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

			$biaya_umum_administratif = $biaya_umum_administratif_biaya['total'] + $biaya_umum_administratif_jurnal['total'];
			$biaya_lainnya = $biaya_lainnya_biaya['total'] + $biaya_lainnya_jurnal['total'];

			$total_harga_pokok_pendapatan = $beban_pokok_penjualan;
			$laba_kotor = ($total_penjualan_all + $total_penjualan_all_limbah + $total_penjualan_all_lain_lain) - $total_harga_pokok_pendapatan;
			$laba_usaha = $laba_kotor - ($biaya_umum_administratif + $biaya_lainnya);

			$total = $laba_usaha;
			$persentase = ($total_penjualan_all + $total_penjualan_all_limbah + $total_penjualan_all_lain_lain!=0)?($laba_kotor / ($total_penjualan_all + $total_penjualan_all_limbah + $total_penjualan_all_lain_lain))  * 100:0;

			//AKUMULASI 2
			$penjualan_2 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
			->from('pmm_productions pp')
			->join('penerima p', 'pp.client_id = p.id','left')
			->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
			->where("pp.date_production between '$date3' and '$date2'")
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

			$penjualan_limbah_2 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
			->from('pmm_productions pp')
			->join('penerima p', 'pp.client_id = p.id','left')
			->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
			->where("pp.date_production between '$date3' and '$date2'")
			->where("pp.product_id in (9)")
			->where("ppo.status in ('OPEN','CLOSED')")
			->group_by('pp.salesPo_id')
			->get()->result_array();

			$total_penjualan_limbah_2 = 0;
			$total_volume_limbah_2 = 0;

			foreach ($penjualan_limbah_2 as $x){
				$total_penjualan_limbah_2 += $x['price'];
				$total_volume_limbah_2 += $x['volume'];
			}

			$penjualan_lain_lain_2 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
			->from('pmm_productions pp')
			->join('penerima p', 'pp.client_id = p.id','left')
			->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
			->where("pp.date_production between '$date3' and '$date2'")
			->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
			->where("ppo.status in ('OPEN','CLOSED')")
			->group_by('pp.salesPo_id')
			->get()->result_array();

			$total_penjualan_lain_lain_2 = 0;
			$total_volume_lain_lain_2 = 0;

			foreach ($penjualan_lain_lain_2 as $x){
				$total_penjualan_lain_lain_2 += $x['price'];
				$total_volume_lain_lain_2 += $x['volume'];
			}

			$total_penjualan_all_lain_lain_2 = 0;
			$total_penjualan_all_lain_lain_2 = $total_penjualan_lain_lain_2;
			?>

			<?php
			$beban_pokok_penjualan_2 = $total_volume_2 * round($harga_jual,0);
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

			$biaya_umum_administratif_2 = $biaya_umum_administratif_biaya_2['total'] + $biaya_umum_administratif_jurnal_2['total'];
			$biaya_lainnya_2 = $biaya_lainnya_biaya_2['total'] + $biaya_lainnya_jurnal_2['total'];
	
			$total_harga_pokok_pendapatan_2 = $beban_pokok_penjualan_2;
			$laba_kotor_2 = ($total_penjualan_all_2 + $total_penjualan_all_limbah_2 + $total_penjualan_all_lain_lain_2) - $total_harga_pokok_pendapatan_2;
			$laba_usaha_2 = $laba_kotor_2 - ($biaya_umum_administratif_2 + $biaya_lainnya_2);

			$total_2 = $laba_usaha_2;
			$persentase_2 = ($total_penjualan_all_2 + $total_penjualan_all_limbah_2 + $total_penjualan_all_lain_lain_2!=0)?($laba_kotor_2 / ($total_penjualan_all_2 + $total_penjualan_all_limbah_2 + $total_penjualan_all_lain_lain_2))  * 100:0;
			?>
			<table width="98%" border="0" cellpadding="3">
				<tr class="table-active" style="">
					<td width="50%">
						<div style="display: block;font-weight: bold;font-size: 10px;">Periode</div>
					</td>
					<td align="right" width="25%">
						<div align="center" style="display: block;font-weight: bold;font-size: 10px;"><?php echo $filter_date;?></div>
					</td>
					<td align="right" width="25%">
						<div align="center" style="display: block;font-weight: bold;font-size: 10px;"><?php echo $filter_date = $filter_date_2 = date('d/m/Y',strtotime($date3)).' - '.date('d/m/Y',strtotime($arr_filter_date[1]));?></div>
					</td>
				</tr>
			</table>
			<hr width="98%">
			<tr class="table-active4">
				<th width="100%" align="left"><b>Pendapatan Usaha</b></th>
	        </tr>
			<tr class="table-active2">
				<th width="10%" align="center"></th>
				<th width="40%" align="left">Pendapatan Penjualan</th>
	            <th width="25%" align="center">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span>Rp.</span>
								</th>
								<th align="center" width="80%">
									<span><?php echo number_format($total_penjualan_all,0,',','.');?></span>
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
									<span><?php echo number_format($total_penjualan_all_2,0,',','.');?></span>
								</th>
							</tr>
					</table>
				</th>
	        </tr>
			<tr class="table-active2">
				<th width="10%" align="center"></th>
				<th width="40%" align="left">Pendapatan Lain - Lain</th>
	            <th width="25%" align="center">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span>Rp.</span>
								</th>
								<th align="center" width="80%">
									<span><?php echo number_format($total_penjualan_all_limbah + $total_penjualan_all_lain_lain,0,',','.');?></span>
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
									<span><?php echo number_format($total_penjualan_all_limbah_2 + $total_penjualan_all_lain_lain_2,0,',','.');?></span>
								</th>
							</tr>
					</table>
				</th>
	        </tr>
			<hr width="98%">
			<tr class="table-active2">
				<th width="50%" align="left"><b>Total Pendapatan</b></th>
	            <th width="25%" align="right">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span>Rp.</span>
								</th>
								<th align="center" width="80%">
									<span><b><?php echo number_format($total_penjualan_all + $total_penjualan_all_limbah + $total_penjualan_all_lain_lain,0,',','.');?></b></span>
								</th>
							</tr>
					</table>
				</th>
				<th width="25%" align="right">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span>Rp.</span>
								</th>
								<th align="center" width="80%">
									<span><b><?php echo number_format($total_penjualan_all_2 + $total_penjualan_all_limbah_2 + $total_penjualan_all_lain_lain_2,0,',','.');?></b></span>
								</th>
							</tr>
					</table>
				</th>
	        </tr>
			<tr class="table-active3">
				<th width="100%" align="left"></th>
	        </tr>
			<tr class="table-active4">
				<th width="100%" align="left"><b>Beban Pokok Penjualan</b></th>
	        </tr>
			<tr class="table-active2">
				<th width="10%" align="center"></th>
				<th width="40%" align="left">Beban Pokok Penjualan</th>
	            <th width="25%" align="center">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="left" width="20%">
									<span>Rp.</span>
								</th>
								<th align="center" width="80%">
									<span><?php echo number_format($total_harga_pokok_pendapatan,0,',','.');?></span>
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
			<!--<tr class="table-active3">
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
				$styleColor2 = $laba_usaha_2 < 0 ? 'color:red' : 'color:black';
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
	        </tr>-->
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