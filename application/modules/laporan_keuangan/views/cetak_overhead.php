<!DOCTYPE html>
<html>
	<head>
	  <title>OVERHEAD</title>
	  
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
			font-weight: bold;
			font-weight: bold;
		}
			
		table tr.table-active4{
			background-color: #D0D0D0;
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
					<div style="display: block;font-weight: bold;font-size: 12px;">OVERHEAD</div>
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
		$date1 = '';
		$date2 = '';

		if(count($arr_filter_date) == 2){
			$date1 	= date('Y-m-d',strtotime($arr_filter_date[0]));
			$date2 	= date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		
		?>

		<table width="98%" border="0" cellpadding="3">
			<?php
			$row = $this->db->select('r.*')
			->from('rap r')
			->group_by("r.tanggal_rap")->limit(1)
			->order_by('r.tanggal_rap','desc')
			->get()->row_array();
			$total_overhead_rap = $row['konsumsi'] + $row['gaji'] + $row['pengujian'] + $row['perbaikan'] + $row['akomodasi'] + $row['listrik'] + $row['thr'] + $row['bensin'] + $row['dinas'] + $row['komunikasi'] + $row['pakaian'] + $row['tulis'] + $row['keamanan'] + $row['perlengkapan'] + $row['beban'] + $row['adm'] + $row['lain'] + $row['sewa'] + $row['bpjs'] + $row['penyusutan'] + $row['iuran'] + $row['kendaraan'] + $row['pajak'] + $row['solar'] + $row['donasi'] + $row['legal'] + $row['pengobatan'] + $row['lembur'] + $row['pelatihan'];
			
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
			->where("pdb.akun in (199,200)")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();

			$gaji_jurnal = $this->db->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun in (199,200)")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$gaji = $gaji_biaya['total'] + $gaji_jurnal['total'];

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
			$total_overhead_realisasi = $konsumsi + $gaji + $pengujian + $perbaikan + $akomodasi + $listrik + $thr;
			?>
			<tr class="table-active">
	            <th width="5%" align="center">NO.</th>
				<th width="35%"  align="left">URAIAN</th>
				<th width="20%"  align="right">RAP</th>
				<th width="20%"  align="right">REALISASI</th>
				<th width="20%"  align="right">DEVIASI</th>
	        </tr>
			<tr class="table-active3">
	            <th align="center">1</th>
				<th align="left">Konsumsi</th>
				<th align="right"><?php echo number_format($row['konsumsi'],0,',','.');?></th>
				<th align="right"><?php echo number_format($konsumsi,0,',','.');?></th>
				<?php
					$evaluasi_konsumsi = $row['konsumsi'] - $konsumsi;
					$styleColor = $evaluasi_konsumsi < 0 ? 'color:red' : 'color:black';
				?>
				<th align="right" style="<?php echo $styleColor ?>"><?php echo $evaluasi_konsumsi < 0 ? "(".number_format(-$evaluasi_konsumsi,0,',','.').")" : number_format($evaluasi_konsumsi,0,',','.');?></th>
	        </tr>
			<tr class="table-active3" style="background-color: #cccccc;">
	            <th align="center">2</th>
				<th align="left">Gaji / Upah</th>
				<th align="right"><?php echo number_format($row['gaji'],0,',','.');?></th>
				<th align="right"><?php echo number_format($gaji,0,',','.');?></th>
				<?php
					$evaluasi_gaji = $row['gaji'] - $gaji;
					$styleColor = $evaluasi_gaji < 0 ? 'color:red' : 'color:black';
				?>
				<th align="right" style="<?php echo $styleColor ?>"><?php echo $evaluasi_gaji < 0 ? "(".number_format(-$evaluasi_gaji,0,',','.').")" : number_format($evaluasi_gaji,0,',','.');?></th>
	        </tr>
			<tr class="table-active3">
	            <th align="center">3</th>
				<th align="left">Pengujian Material dan Laboratorium</th>
				<th align="right"><?php echo number_format($row['pengujian'],0,',','.');?></th>
				<th align="right"><?php echo number_format($pengujian,0,',','.');?></th>
				<?php
					$evaluasi_pengujian = $row['pengujian'] - $pengujian;
					$styleColor = $evaluasi_pengujian < 0 ? 'color:red' : 'color:black';
				?>
				<th align="right" style="<?php echo $styleColor ?>"><?php echo $evaluasi_pengujian < 0 ? "(".number_format(-$evaluasi_pengujian,0,',','.').")" : number_format($evaluasi_pengujian,0,',','.');?></th>
	        </tr>
			<tr class="table-active3" style="background-color: #cccccc;">
	            <th align="center">4</th>
				<th align="left">Perbaikan dan Pemeliharaan</th>
				<th align="right"><?php echo number_format($row['perbaikan'],0,',','.');?></th>
				<th align="right"><?php echo number_format($perbaikan,0,',','.');?></th>
				<?php
					$evaluasi_perbaikan = $row['perbaikan'] - $perbaikan;
					$styleColor = $evaluasi_perbaikan < 0 ? 'color:red' : 'color:black';
				?>
				<th align="right" style="<?php echo $styleColor ?>"><?php echo $evaluasi_perbaikan < 0 ? "(".number_format(-$evaluasi_perbaikan,0,',','.').")" : number_format($evaluasi_perbaikan,0,',','.');?></th>
	        </tr>
			<tr class="table-active3">
	            <th align="center">5</th>
				<th align="left">Akomodasi Tamu</th>
				<th align="right"><?php echo number_format($row['akomodasi'],0,',','.');?></th>
				<th align="right"><?php echo number_format($akomodasi,0,',','.');?></th>
				<?php
					$evaluasi_akomodasi = $row['akomodasi'] - $akomodasi;
					$styleColor = $evaluasi_akomodasi < 0 ? 'color:red' : 'color:black';
				?>
				<th align="right" style="<?php echo $styleColor ?>"><?php echo $evaluasi_akomodasi < 0 ? "(".number_format(-$evaluasi_akomodasi,0,',','.').")" : number_format($evaluasi_akomodasi,0,',','.');?></th>
	        </tr>
			<tr class="table-active3" style="background-color: #cccccc;">
	            <th align="center">6</th>
				<th align="left">Listrik & Internet</th>
				<th align="right"><?php echo number_format($row['listrik'],0,',','.');?></th>
				<th align="right"><?php echo number_format($listrik,0,',','.');?></th>
				<?php
					$evaluasi_listrik = $row['listrik'] - $listrik;
					$styleColor = $evaluasi_listrik < 0 ? 'color:red' : 'color:black';
				?>
				<th align="right" style="<?php echo $styleColor ?>"><?php echo $evaluasi_listrik < 0 ? "(".number_format(-$evaluasi_listrik,0,',','.').")" : number_format($evaluasi_listrik,0,',','.');?></th>
	        </tr>
			<tr class="table-active3">
	            <th align="center">7</th>
				<th align="left">THR & Bonus</th>
				<th align="right"><?php echo number_format($row['thr'],0,',','.');?></th>
				<th align="right"><?php echo number_format($thr,0,',','.');?></th>
				<?php
					$evaluasi_thr = $row['thr'] - $thr;
					$styleColor = $evaluasi_thr < 0 ? 'color:red' : 'color:black';
				?>
				<th align="right" style="<?php echo $styleColor ?>"><?php echo $evaluasi_thr < 0 ? "(".number_format(-$evaluasi_thr,0,',','.').")" : number_format($evaluasi_thr,0,',','.');?></th>
	        </tr>
			<tr class="table-active3" style="background-color: #cccccc;">
	            <th align="center">8</th>
				<th align="left">Bensin, Tol & Parkir - Umum</th>
				<th align="right"><?php echo number_format($row['bensin'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3">
	            <th align="center">9</th>
				<th align="left">Perjalanan Dinas - Umum</th>
				<th align="right"><?php echo number_format($row['dinas'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3" style="background-color: #cccccc;">
	            <th align="center">10</th>
				<th align="left">Komunikasi - Umum</th>
				<th align="right"><?php echo number_format($row['komunikasi'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3">
	            <th align="center">11</th>
				<th align="left">Pakaian Dinas & K3</th>
				<th align="right"><?php echo number_format($row['pakaian'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3" style="background-color: #cccccc;">
	            <th align="center">12</th>
				<th align="left">Alat Tulis Kantor & Printing</th>
				<th align="right"><?php echo number_format($row['tulis'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3">
	            <th align="center">13</th>
				<th align="left">Keamanan dan Kebersihan</th>
				<th align="right"><?php echo number_format($row['keamanan'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3" style="background-color: #cccccc;">
	            <th align="center">14</th>
				<th align="left">Perlengkapan Kantor</th>
				<th align="right"><?php echo number_format($row['perlengkapan'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3">
	            <th align="center">15</th>
				<th align="left">Beban Kirim</th>
				<th align="right"><?php echo number_format($row['beban'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3" style="background-color: #cccccc;">
	            <th align="center">16</th>
				<th align="left">Beban Adm Bank</th>
				<th align="right"><?php echo number_format($row['adm'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3">
	            <th align="center">17</th>
				<th align="left">Beban Lain-lain</th>
				<th align="right"><?php echo number_format($row['lain'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3" style="background-color: #cccccc;">
	            <th align="center">18</th>
				<th align="left">Biaya Sewa Bangunan</th>
				<th align="right"><?php echo number_format($row['sewa'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3">
	            <th align="center">19</th>
				<th align="left">BPJS Kesehatan dan ketenagakerjaan</th>
				<th align="right"><?php echo number_format($row['bpjs'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3" style="background-color: #cccccc;">
	            <th align="center">20</th>
				<th align="left">Penyusutan Peralatan Kantor dan Kendaraan</th>
				<th align="right"><?php echo number_format($row['penyusutan'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3">
	            <th align="center">21</th>
				<th align="left">Iuran & Langganan</th>
				<th align="right"><?php echo number_format($row['iuran'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3" style="background-color: #cccccc;">
	            <th align="center">22</th>
				<th align="left">Biaya Sewa - Kendaraan</th>
				<th align="right"><?php echo number_format($row['kendaraan'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3">
	            <th align="center">23</th>
				<th align="left">Pajak dan Perizinan</th>
				<th align="right"><?php echo number_format($row['pajak'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3" style="background-color: #cccccc;">
	            <th align="center">24</th>
				<th align="left">Solar</th>
				<th align="right"><?php echo number_format($row['solar'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3">
	            <th align="center">25</th>
				<th align="left">Donasi</th>
				<th align="right"><?php echo number_format($row['donasi'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3" style="background-color: #cccccc;">
	            <th align="center">26</th>
				<th align="left">Legal & Profesional</th>
				<th align="right"><?php echo number_format($row['legal'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3">
	            <th align="center">27</th>
				<th align="left">Pengobatan</th>
				<th align="right"><?php echo number_format($row['pengobatan'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3" style="background-color: #cccccc;">
	            <th align="center">28</th>
				<th align="left">Lembur</th>
				<th align="right"><?php echo number_format($row['lembur'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active3">
	            <th align="center">29</th>
				<th align="left">Pelatihan dan Pengembangan</th>
				<th align="right"><?php echo number_format($row['pelatihan'],0,',','.');?></th>
				<th align="right"></th>
				<th align="right"></th>
	        </tr>
			<tr class="table-active">
	            <th align="center" colspan="2">TOTAL</th>
				<th align="right"><?php echo number_format($total_overhead_rap,0,',','.');?></th>
				<th align="right"><?php echo number_format($total_overhead_realisasi,0,',','.');?></th>
				<?php
					$evaluasi_overhead = $total_overhead_rap - $total_overhead_realisasi;
					$styleColor = $evaluasi_overhead < 0 ? 'color:red' : 'color:black';
				?>
				<th align="right" style="<?php echo $styleColor ?>"><?php echo $evaluasi_overhead < 0 ? "(".number_format(-$evaluasi_overhead,0,',','.').")" : number_format($evaluasi_overhead,0,',','.');?></th>
	        </tr>
		</table>
	</body>
</html>