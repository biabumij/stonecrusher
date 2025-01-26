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
			font-weight: bold;
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
				<td align="center" width="100%">
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
			
			//$total_harga_pokok_pendapatan = $this->pmm_model->getBebanPokokPenjualan($date1,$date2);
			$bpp = $this->db->select('sum(bpp) as bpp')
			->from('kunci_bahan_jadi')
			->where("date between '$date1' and '$date2'")
			->get()->row_array();
			$bpp = $bpp['bpp'];
			
			$produksi = $this->db->select('produksi')
			->from('kunci_bahan_jadi')
			->where("date between '$date1' and '$date2'")
			->order_by('id','desc')->limit(1)
			->get()->row_array();
			$produksi = $produksi['produksi'];
			$total_harga_pokok_pendapatan = $bpp * $produksi;

			$laba_kotor = ($total_penjualan_all + $total_penjualan_all_limbah + $total_penjualan_all_lain_lain) - $total_harga_pokok_pendapatan;
			$persentase = ($total_penjualan_all + $total_penjualan_all_limbah + $total_penjualan_all_lain_lain!=0)?($laba_kotor / ($total_penjualan_all + $total_penjualan_all_limbah + $total_penjualan_all_lain_lain))  * 100:0;
			?>

			<!-- FILTER AKUMULASI -->
			<?php
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
			->where("ppo.status in ('OPEN','CLOSED')")
			->group_by('pp.salesPo_id')
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
			<br />
			<table width="98%" border="0" cellpadding="3">
				<tr class="table-active">
					<td width="50%">
						<div style="display: block;font-weight: bold;font-size: 9px;">Periode</div>
					</td>
					<td align="right" width="25%">
						<div align="center" style="display: block;font-weight: bold;font-size: 9px;"><?php echo $filter_date;?></div>
					</td>
					<td align="right" width="25%">
						<div align="center" style="display: block;font-weight: bold;font-size: 9px;">SD. <?php echo date('d/m/Y',strtotime($arr_filter_date[1]));?></div>
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
								<th align="right" width="20%">
									<span>Rp.</span>
								</th>
								<th align="right" width="80%">
									<span><?php echo number_format($total_penjualan_all,0,',','.');?></span>
								</th>
							</tr>
					</table>
				</th>
				<th width="25%" align="center">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="right" width="20%">
									<span>Rp.</span>
								</th>
								<th align="right" width="80%">
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
								<th align="right" width="20%">
									<span>Rp.</span>
								</th>
								<th align="right" width="80%">
									<span><?php echo number_format($total_penjualan_all_limbah + $total_penjualan_all_lain_lain,0,',','.');?></span>
								</th>
							</tr>
					</table>
				</th>
				<th width="25%" align="center">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="right" width="20%">
									<span>Rp.</span>
								</th>
								<th align="right" width="80%">
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
								<th align="right" width="20%">
									<span>Rp.</span>
								</th>
								<th align="right" width="80%">
									<span><b><?php echo number_format($total_penjualan_all + $total_penjualan_all_limbah + $total_penjualan_all_lain_lain,0,',','.');?></b></span>
								</th>
							</tr>
					</table>
				</th>
				<th width="25%" align="right">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="right" width="20%">
									<span>Rp.</span>
								</th>
								<th align="right" width="80%">
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
								<th align="right" width="20%">
									<span>Rp.</span>
								</th>
								<th align="right" width="80%">
									<span><?php echo number_format($total_harga_pokok_pendapatan,0,',','.');?></span>
								</th>
							</tr>
					</table>
				</th>
				<?php
				//$total_harga_pokok_pendapatan_2 = $this->pmm_model->getBebanPokokPenjualanAkumulasi($date3,$date2);
				$bpp = $this->db->select('sum(bpp) as bpp')
				->from('kunci_bahan_jadi')
				->where("date between '$date3' and '$date2'")
				->get()->row_array();
				$bpp = $bpp['bpp'];
				$total_harga_pokok_pendapatan_2 = $bpp;

				$laba_kotor_2 = ($total_penjualan_all_2 + $total_penjualan_all_limbah_2 + $total_penjualan_all_lain_lain_2) - $total_harga_pokok_pendapatan_2;
				$persentase_2 = ($total_penjualan_all_2 + $total_penjualan_all_limbah_2 + $total_penjualan_all_lain_lain_2!=0)?($laba_kotor_2 / ($total_penjualan_all_2 + $total_penjualan_all_limbah_2 + $total_penjualan_all_lain_lain_2)) * 100:0;
				?>
				<th width="25%" align="center">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="right" width="20%">
									<span>Rp.</span>
								</th>
								<th align="right" width="80%">
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
								<th align="right" width="20%">
									<span><b>Rp.</b></span>
								</th>
								<th align="right" width="80%">
									<span><b><?php echo number_format($total_harga_pokok_pendapatan,0,',','.');?></b></span>
								</th>
							</tr>
					</table>
				</th>
				<th width="25%" align="right">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="right" width="20%">
									<span><b>Rp.</b></span>
								</th>
								<th align="right" width="80%">
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
			?>
			<tr class="table-active2">
	            <th width="50%" align="left"><b>Laba / Rugi Kotor</b></th>
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
				<?php
					$styleColor = $laba_kotor_2 < 0 ? 'color:red' : 'color:black';
				?>
				<th width="25%" align="right" style="<?php echo $styleColor ?>">
					<table width="100%" border="0" cellpadding="0">
						<tr>
								<th align="right" width="20%">
									<span><b>Rp.</b></span>
								</th>
								<th align="right" width="80%">
									<span><b><?php echo $laba_kotor_2 < 0 ? "(".number_format(-$laba_kotor_2,0,',','.').")" : number_format($laba_kotor_2,0,',','.');?></b></span>
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
								Dibuat Oleh
							</td>
							<td align="center">
								Diperiksa Oleh
							</td>
							<td align="center">
								Disetujui Oleh
							</td>
						</tr>
						<tr class="">
							<td align="center" height="55px">
								<img src="uploads/ttd_tri.png" width="70px">
							</td>
							<td align="center">
								<img src="uploads/ttd_erika.png" width="70px">
							</td>
							<td align="center">
								<img src="uploads/ttd_deddy.png" width="70px">
							</td>
						</tr>
						<tr>
							<td align="center">
								<b><u>Tri Wahyu Rahadi</u><br />
								Ka. Plant</b>
							</td>
							<td align="center">
								<b><u>Erika Sinaga</u><br />
								Dir. Keuangan & SDM</b>
							</td>
							<td align="center">
								<b><u>Deddy Sarwobiso</u><br />
								Direktur Utama</b>
							</td>
						</tr>
					</table>
				</td>
				<td width="5%"></td>
			</tr>
		</table>
		
	</body>
</html>