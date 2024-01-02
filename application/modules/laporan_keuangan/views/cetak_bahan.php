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

			$pembalian_bahan_baku_bulan_lalu = $this->db->select('(cat.volume) as volume')
			->from('pmm_remaining_materials_cat cat ')
			->where("(cat.date = '$tanggal_opening_balance')")
			->where("cat.material_id = 15")
			->where("cat.status = 'PUBLISH'")
			->order_by('date','desc')->limit(1)
			->get()->row_array();
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