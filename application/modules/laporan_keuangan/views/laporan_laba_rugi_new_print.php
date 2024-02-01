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
			
			//Opening Balance
			$date1_ago = date('2020-01-01');
			$date2_ago = date('Y-m-d', strtotime('-1 days', strtotime($date1)));
			$date3_ago = date('Y-m-d', strtotime('-1 months', strtotime($date1)));
			$tanggal_opening_balance = date('Y-m-d', strtotime('-1 days', strtotime($date1)));
	
			$stock_opname_bbm_ago = $this->db->select('pp.vol_nilai_bbm as volume')
			->from('kunci_bahan_baku pp')
			->where("(pp.date = '$tanggal_opening_balance')")
			->order_by('pp.date','desc')->limit(1)
			->get()->row_array();
			
			$harga_bbm = $this->db->select('pp.nilai_bbm as nilai_bbm')
			->from('kunci_bahan_baku pp')
			->where("(pp.date between '$date3_ago' and '$date2_ago')")
			->order_by('pp.date','desc')->limit(1)
			->get()->row_array();
	
			$pembelian_bbm = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
			->from('pmm_receipt_material prm')
			->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
			->join('produk p', 'prm.material_id = p.id','left')
			->where("prm.date_receipt between '$date1' and '$date2'")
			->where("prm.material_id = 13")
			->group_by('prm.material_id')
			->get()->row_array();
	
			$pemakaian_bbm = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume')
			->from('kunci_bahan_baku pp')
			->where("(pp.date between '$date1' and '$date2')")
			->order_by('pp.date','desc')->limit(1)
			->get()->row_array();
			$vol_pemakaian_bbm = $pemakaian_bbm['volume'];
			
			$stok_volume_bbm_lalu = $stock_opname_bbm_ago['volume'];
			$stok_nilai_bbm_lalu = $harga_bbm['nilai_bbm'];
			$stok_harsat_bbm_lalu = (round($stok_volume_bbm_lalu,2)!=0)?$stok_nilai_bbm_lalu / round($stok_volume_bbm_lalu,2) * 1:0;

			$pembelian_volume = $pembelian_bbm['volume'];
			$pembelian_harga = $pembelian_bbm['harga'];
			$pembelian_nilai = $pembelian_bbm['nilai'];

			$total_stok_volume = $stok_volume_bbm_lalu + $pembelian_volume;
			$total_stok_nilai = $stok_nilai_bbm_lalu + $pembelian_nilai;
			$total_stok_harsat = (round($total_stok_volume,2)!=0)?$total_stok_nilai / round($total_stok_volume,2) * 1:0;

			$produksi_volume = $stok_volume_bbm_lalu;
			$produksi_harsat = $stok_harsat_bbm_lalu;
			$produksi_nilai = $stok_nilai_bbm_lalu;

			$key = 0;
			if($pembelian_harga == 0) {
				$key = $produksi_harsat;
			}

			if($pembelian_harga > 0) {
				$key = $pembelian_harga;
			}

			$produksi_2_volume = $vol_pemakaian_bbm - $produksi_volume;
			$produksi_2_harsat = $key;
			$produksi_2_nilai = $produksi_2_volume * $produksi_2_harsat;

			$total_produksi_volume = $produksi_volume + $produksi_2_volume;
			$total_produksi_nilai = $produksi_nilai + $produksi_2_nilai;

			$stok_akhir_volume = $total_stok_volume - $produksi_volume - $produksi_2_volume;
			$stok_akhir_nilai = $total_stok_nilai - $produksi_nilai - $produksi_2_nilai;

			$harga_baru = ($total_produksi_volume!=0)?$total_produksi_nilai / $total_produksi_volume * 1:0;
			$total_nilai_produksi_solar = $total_produksi_nilai;
			?>
	
			<!-- HPProduksi -->
			<!-- Overhead -->
			<?php
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
	
			$gaji_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 199")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$gaji_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 199")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$gaji = $gaji_biaya['total'] + $gaji_jurnal['total'];
	
			$upah_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 200")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$upah_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 200")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$upah = $upah_biaya['total'] + $upah_jurnal['total'];
	
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
	
			$akomodasi_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 204")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$akomodasi_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 204")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$akomodasi = $akomodasi_biaya['total'] + $akomodasi_jurnal['total'];
	
			$listrik_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 206")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$listrik_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 206")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$listrik = $listrik_biaya['total'] + $listrik_jurnal['total'];
			
			$thr_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 202")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$thr_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 202")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$thr = $thr_biaya['total'] + $thr_jurnal['total'];
	
			$bensin_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 129")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$bensin_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 129")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$bensin = $bensin_biaya['total'] + $bensin_jurnal['total'];
	
			$dinas_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 131")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$dinas_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 131")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$dinas = $dinas_biaya['total'] + $dinas_jurnal['total'];
	
			$komunikasi_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 133")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$komunikasi_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 133")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$komunikasi = $komunikasi_biaya['total'] + $komunikasi_jurnal['total'];
	
			$pakaian_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 138")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$pakaian_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 138")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$pakaian = $pakaian_biaya['total'] + $pakaian_jurnal['total'];
			
			$tulis_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 149")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$tulis_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 149")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$tulis = $tulis_biaya['total'] + $tulis_jurnal['total'];
	
			$keamanan_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 151")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$keamanan_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 151")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$keamanan = $keamanan_biaya['total'] + $keamanan_jurnal['total'];
	
			$perlengkapan_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 153")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$perlengkapan_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 153")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$perlengkapan = $perlengkapan_biaya['total'] + $perlengkapan_jurnal['total'];
	
			$beban_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 145")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$beban_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 145")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$beban = $beban_biaya['total'] + $beban_jurnal['total'];
	
			$adm_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 143")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$adm_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 143")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$adm = $adm_biaya['total'] + $adm_jurnal['total'];
	
			$lain_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 146")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$lain_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 146")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$lain = $lain_biaya['total'] + $lain_jurnal['total'];
	
			$sewa_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 154")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$sewa_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 154")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$sewa = $sewa_biaya['total'] + $sewa_jurnal['total'];
	
			$bpjs_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 123")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$bpjs_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 123")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$bpjs = $bpjs_biaya['total'] + $bpjs_jurnal['total'];
	
			$penyusutan_kantor_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 162")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$penyusutan_kantor_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 162")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$penyusutan_kantor = $penyusutan_kantor_biaya['total'] + $penyusutan_kantor_jurnal['total'];
	
			$penyusutan_kendaraan_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 160")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$penyusutan_kendaraan_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 160")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$penyusutan_kendaraan = $penyusutan_kendaraan_biaya['total'] + $penyusutan_kendaraan_jurnal['total'];
	
			$iuran_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 134")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$iuran_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 134")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$iuran = $iuran_biaya['total'] + $iuran_jurnal['total'];
	
			$kendaraan_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 155")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$kendaraan_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 155")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$kendaraan = $kendaraan_biaya['total'] + $kendaraan_jurnal['total'];
	
			$pajak_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 141")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$pajak_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 141")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$pajak = $pajak_biaya['total'] + $pajak_jurnal['total'];
	
			$solar_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 105")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$solar_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 105")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$solar = $solar_biaya['total'] + $solar_jurnal['total'];
	
			$donasi_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 127")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$donasi_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 127")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$donasi = $donasi_biaya['total'] + $donasi_jurnal['total'];
	
			$legal_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 136")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$legal_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 136")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$legal = $legal_biaya['total'] + $legal_jurnal['total'];
	
			$pengobatan_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 121")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$pengobatan_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 121")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$pengobatan = $pengobatan_biaya['total'] + $pengobatan_jurnal['total'];
	
			$lembur_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 120")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$lembur_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 120")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$lembur = $lembur_biaya['total'] + $lembur_jurnal['total'];
	
			$pelatihan_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 139")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$pelatihan_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 139")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$pelatihan = $pelatihan_biaya['total'] + $pelatihan_jurnal['total'];
	
			$supplies_biaya = $this->db->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 152")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
	
			$supplies_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 152")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$supplies = $supplies_biaya['total'] + $supplies_jurnal['total'];
	
			$total_operasional = $konsumsi + $gaji + $upah + $pengujian + $perbaikan + $akomodasi + $listrik + $thr + 
			$bensin + $dinas + $komunikasi + $pakaian + $tulis + $keamanan + $perlengkapan + $beban + $adm + 
			$lain + $sewa + $bpjs + $penyusutan_kantor + $penyusutan_kendaraan + $iuran + $kendaraan + $pajak + $solar + 
			$donasi + $legal + $pengobatan + $lembur + $pelatihan + $supplies;
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

			$harga_baru = ($total_rekapitulasi_produksi_harian!=0)?$total_produksi_nilai / $total_rekapitulasi_produksi_harian * 1:0;
			$total_nilai_produksi_boulder = $total_rekapitulasi_produksi_harian * $harga_baru;
			?>

			<?php
			$hpp = (round($total_rekapitulasi_produksi_harian,2)!=0)?($total_nilai_produksi_boulder + $total_biaya_peralatan + $total_nilai_produksi_solar + $total_operasional) / round($total_rekapitulasi_produksi_harian,2) * 1:0;
			$beban_pokok_penjualan = round($total_volume,2) * $hpp;
			?>
			
			<?php
			$total_harga_pokok_pendapatan = $beban_pokok_penjualan;
			$laba_kotor = ($total_penjualan_all + $total_penjualan_all_limbah + $total_penjualan_all_lain_lain) - $total_harga_pokok_pendapatan;
			$persentase = ($total_penjualan_all + $total_penjualan_all_limbah + $total_penjualan_all_lain_lain!=0)?($laba_kotor / ($total_penjualan_all + $total_penjualan_all_limbah + $total_penjualan_all_lain_lain))  * 100:0;
			?>
			<table width="98%" border="0" cellpadding="3">
				<tr class="table-active" style="">
					<td width="50%">
						<div style="display: block;font-weight: bold;font-size: 10px;">Periode</div>
					</td>
					<td align="right" width="50%">
						<div align="right" style="display: block;font-weight: bold;font-size: 10px;"><?php echo $filter_date;?></div>
					</td>
				</tr>
			</table>
			<hr width="98%">
			<tr class="table-active4">
				<th width="100%" align="left"><b>Pendapatan Usaha</b></th>
	        </tr>
			<tr class="table-active2">
				<th width="10%" align="center"></th>
				<th width="65%" align="left">Pendapatan Penjualan</th>
	            <th width="25%" align="center">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="right" width="20%">
									<span>Rp.</span>
								</th>
								<th align="right" width="80%">
									<span><?php echo number_format($total_penjualan_all,0,',','.');?></span>
								</th>
							</tr>
					</table>
				</th>
	        </tr>
			<tr class="table-active2">
				<th width="10%" align="center"></th>
				<th width="65%" align="left">Pendapatan Lain - Lain</th>
	            <th width="25%" align="center">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="right" width="20%">
									<span>Rp.</span>
								</th>
								<th align="right" width="80%">
									<span><?php echo number_format($total_penjualan_all_limbah + $total_penjualan_all_lain_lain,0,',','.');?></span>
								</th>
							</tr>
					</table>
				</th>
	        </tr>
			<hr width="98%">
			<tr class="table-active2">
				<th width="75%" align="left"><b>Total Pendapatan</b></th>
	            <th width="25%" align="right">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="right" width="20%">
									<span>Rp.</span>
								</th>
								<th align="right" width="80%">
									<span><b><?php echo number_format($total_penjualan_all + $total_penjualan_all_limbah + $total_penjualan_all_lain_lain,0,',','.');?></b></span>
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
				<th width="65%" align="left">Beban Pokok Penjualan</th>
	            <th width="25%" align="center">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="right" width="20%">
									<span>Rp.</span>
								</th>
								<th align="right" width="80%">
									<span><?php echo number_format($total_harga_pokok_pendapatan,0,',','.');?></span>
								</th>
							</tr>
					</table>
				</th>
	        </tr>
			<hr width="98%">
			<tr class="table-active2">
				<th width="75%" align="left"><b>Total Harga Pokok Pendapatan</b></th>
	            <th width="25%" align="right">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="right" width="20%">
									<span><b>Rp.</b></span>
								</th>
								<th align="right" width="80%">
									<span><b><?php echo number_format($total_harga_pokok_pendapatan,0,',','.');?></b></span>
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
			?>
			<tr class="table-active2">
	            <th width="75%" align="left"><b>Laba / Rugi Kotor</b></th>
	            <th width="25%" align="right" style="<?php echo $styleColor ?>">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="right" width="20%">
									<span><b>Rp.</b></span>
								</th>
								<th align="right" width="80%">
									<span><b><?php echo $laba_kotor < 0 ? "(".number_format(-$laba_kotor,0,',','.').")" : number_format($laba_kotor,0,',','.');?></b></span>
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