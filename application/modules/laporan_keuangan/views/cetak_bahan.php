<!DOCTYPE html>
<html>
	<head>
	  <title>PEMAKAIAN BAHAN BAKU</title>
	  
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
		<table width="98%" cellpadding="30">
			<tr>
				<td align="center"  width="100%">
					<div style="display: block;font-weight: bold;font-size: 12px;">BAHAN BAKU</div>
					<div style="display: block;font-weight: bold;font-size: 12px; text-transform: uppercase;">PERIODE : <?php echo str_replace($search, $replace, $subject);?></div>
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
		$date1 = '';
		$date2 = '';

		if(count($arr_filter_date) == 2){
			$date1 	= date('Y-m-d',strtotime($arr_filter_date[0]));
			$date2 	= date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		
		?>
		
		<table width="98%" border="0" cellpadding="3" border="0">
		
		<?php

			//Opening Balance
			$date1_ago = date('2020-01-01');
			$date2_ago = date('Y-m-d', strtotime('-1 days', strtotime($date1)));
			$date3_ago = date('Y-m-d', strtotime('-1 months', strtotime($date1)));
			$tanggal_opening_balance = date('Y-m-d', strtotime('-1 days', strtotime($date1)));

			$stock_opname_batu_boulder_ago = $this->db->select('(cat.volume) as volume')
			->from('pmm_remaining_materials_cat cat ')
			->where("(cat.date = '$tanggal_opening_balance')")
			->where("cat.material_id = 15")
			->where("cat.status = 'PUBLISH'")
			->order_by('date','desc')->limit(1)
			->get()->row_array();

			$harga_hpp_bahan_baku = $this->db->select('pp.date_hpp, pp.boulder, pp.bbm')
			->from('hpp_bahan_baku pp')
			->where("(pp.date_hpp between '$date3_ago' and '$date2_ago')")
			->order_by('pp.date_hpp','desc')->limit(1)
			->get()->row_array();

			$volume_opening_balance = $stock_opname_batu_boulder_ago['volume'];
			$harga_opening_balance = $harga_hpp_bahan_baku['boulder'];
			$nilai_opening_balance = $volume_opening_balance * $harga_opening_balance;

			//Now
			//Bahan Baku			
			$pergerakan_bahan_baku = $this->db->select('
			p.nama_produk, 
			prm.display_measure as satuan, 
			SUM(prm.display_volume) as volume, 
			(prm.display_price / prm.display_volume) as harga, 
			SUM(prm.display_price) as nilai')
			->from('pmm_receipt_material prm')
			->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
			->join('produk p', 'prm.material_id = p.id','left')
			->where("prm.date_receipt between '$date1' and '$date2'")
			->where("prm.material_id = 15")
			->group_by('prm.material_id')
			->get()->row_array();
			
			$total_volume_pembelian = $pergerakan_bahan_baku['volume'];
			$total_nilai_pembelian =  $pergerakan_bahan_baku['nilai'];
			$total_harga_pembelian = ($total_volume_pembelian!=0)?$total_nilai_pembelian / $total_volume_pembelian * 1:0;

			$total_volume_pembelian_akhir  = round($volume_opening_balance + $total_volume_pembelian,2);
			$total_harga_pembelian_akhir = ($total_volume_pembelian_akhir!=0)?($nilai_opening_balance + $total_nilai_pembelian) / $total_volume_pembelian_akhir * 1:0;
			$total_nilai_pembelian_akhir =  $total_volume_pembelian_akhir * $total_harga_pembelian_akhir;			
			
			$stock_opname_batu_boulder = $this->db->select('(cat.volume) as volume')
			->from('pmm_remaining_materials_cat cat ')
			->where("(cat.date = '$date2')")
			->where("cat.material_id = 15")
			->where("cat.status = 'PUBLISH'")
			->order_by('date','desc')->limit(1)
			->get()->row_array();

			$rekapitulasi_produksi_harian = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a,  (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b,  (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c,  (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d,  (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e')
			->from('pmm_produksi_harian pph ')
			->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
			->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id','left')
			->where("(pph.date_prod between '$date1' and '$date2')")
			->where('pph.status','PUBLISH')
			->get()->row_array();
			$total_rekapitulasi_produksi_harian = round($rekapitulasi_produksi_harian['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_e'],2);

			$total_volume_produksi = $total_rekapitulasi_produksi_harian;
			$total_harga_produksi = round($total_harga_pembelian_akhir,0);
			$total_nilai_produksi = $total_volume_produksi * $total_harga_produksi;

			$total_volume_produksi_akhir = $total_volume_pembelian_akhir - $total_volume_produksi;
			$total_harga_produksi_akhir = round($total_harga_pembelian_akhir,0);
			$total_nilai_produksi_akhir = $total_volume_produksi_akhir * $total_harga_produksi_akhir;

			$total_volume_produksi_loss_akhir = $stock_opname_batu_boulder['volume'];
			$total_harga_produksi_loss_akhir = round($total_harga_pembelian_akhir,0);
			$total_nilai_produksi_loss_akhir = $total_volume_produksi_loss_akhir * $total_harga_produksi_loss_akhir;

			$total_volume_produksi_loss = round($total_volume_produksi_akhir - $total_volume_produksi_loss_akhir,2);
			$total_harga_produksi_loss = $total_harga_produksi_akhir;
			$total_nilai_produksi_loss = $total_volume_produksi_loss * $total_harga_produksi_loss;

			//Total
			$total_volume_produksi_boulder = round($total_volume_produksi + $total_volume_produksi_loss,2);
			$total_harga_produksi_boulder = $total_harga_produksi_loss_akhir;
			$total_nilai_produksi_boulder = $total_nilai_produksi + $total_nilai_produksi_loss;

			//Total Opening Balance
			$opening_balance_bahan_baku = $nilai_opening_balance + $nilai_opening_balance_solar;

			//Total
			$total_nilai_masuk = $total_nilai_pembelian;
			$total_nilai_keluar = $total_nilai_produksi + $total_nilai_produksi_loss;
			$total_nilai_akhir = $total_nilai_produksi_loss_akhir;
	        ?>
			
		<tr class="table-judul">
			<th width="11%" align="center" rowspan="2">&nbsp;<br>URAIAN</th>
			<th width="8%" align="center" rowspan="2">&nbsp;<br>SATUAN</th>
			<th width="27%" align="center" colspan="3">MASUK</th>
			<th width="27%" align="center" colspan="3">KELUAR</th>
			<th width="27%" align="center" colspan="3">AKHIR</th>
		</tr>
		<tr class="table-judul">
			<th align="center" width="8%">VOLUME</th>
			<th align="center" width="8%">HARGA</th>
			<th align="center" width="11%">NILAI</th>
			<th align="center" width="8%">VOLUME</th>
			<th align="center" width="8%">HARGA</th>
			<th align="center" width="11%">NILAI</th>
			<th align="center" width="8%">VOLUME</th>
			<th align="center" width="8%">HARGA</th>
			<th align="center" width="11%">NILAI</th>
		</tr>
		<tr class="table-baris1">
			<th align="left" colspan="11"><b>BAHAN BAKU</b></th>
		</tr>
		<tr class="table-baris1">
			<th align="center"style="vertical-align:middle"><?php echo $date2_ago;?></th>			
			<th align="left" colspan="7">Opening Balance</th>
			<th align="right"><?php echo number_format($volume_opening_balance,2,',','.');?></th>
			<th align="right"><?php echo number_format($harga_opening_balance,0,',','.');?></th>
			<th align="right"><?php echo number_format($nilai_opening_balance,0,',','.');?></th>
		</tr>
		<tr class="table-baris1">
			<th align="left">Batu Boulder</th>
			<th align="center">Ton</th>
			<th align="right"><?php echo number_format($pergerakan_bahan_baku['volume'],2,',','.');?></th>
			<th align="right"><?php echo number_format($total_harga_pembelian,0,',','.');?></th>
			<th align="right"><?php echo number_format($pergerakan_bahan_baku['nilai'],0,',','.');?></th>
			<th align="right"><?php echo number_format($total_volume_produksi_boulder,2,',','.');?></th>
			<th align="right"><?php echo number_format($total_harga_produksi_boulder,0,',','.');?></th>
			<th align="right"><?php echo number_format($total_nilai_produksi_boulder,0,',','.');?></th>
			<th align="right"><?php echo number_format($total_volume_produksi_loss_akhir,2,',','.');?></th>
			<th align="right"><?php echo number_format($total_harga_produksi_loss_akhir,0,',','.');?></th>
			<th align="right"><?php echo number_format($total_nilai_produksi_loss_akhir,0,',','.');?></th>					
		</tr>
		<tr class="table-total">
			<th align="center" colspan="2">TOTAL</th>
			<th align="right"></th>
			<th align="right"></th>
			<th align="right"><?php echo number_format($total_nilai_masuk,0,',','.');?></th>
			<th align="right"></th>
			<th align="right"></th>
			<th align="right"><?php echo number_format($total_nilai_keluar,0,',','.');?></th>
			<th align="right"></th>
			<th align="right"></th>
			<th align="right"><?php echo number_format($total_nilai_akhir,0,',','.');?></th>
		</tr>
	</table>
	</body>
</html>