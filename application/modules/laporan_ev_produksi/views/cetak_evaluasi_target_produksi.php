<!DOCTYPE html>
<html>
	<head>
	  <title>EVALUASI TARGET PRODUKSI</title>
	  
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
				font-size: 7px;
			}

			table.table-border-pojok-kiri, th.table-border-pojok-kiri, td.table-border-pojok-kiri {
				border-top: 1px solid black;
				border-bottom: 1px solid black;
				border-right: 1px solid #cccccc;
				border-left: 1px solid black;
			}

			table.table-border-pojok-tengah, th.table-border-pojok-tengah, td.table-border-pojok-tengah {
				border-top: 1px solid black;
				border-bottom: 1px solid black;
				border-right: 1px solid #cccccc;
			}

			table.table-border-pojok-kanan, th.table-border-pojok-kanan, td.table-border-pojok-kanan {
				border-top: 1px solid black;
				border-bottom: 1px solid black;
				border-right: 1px solid black;
			}

			table.table-border-spesial, th.table-border-spesial, td.table-border-spesial {
				border-left: 1px solid black;
				border-right: 1px solid black;
			}

			table.table-border-spesial-kiri, th.table-border-spesial-kiri, td.table-border-spesial-kiri {
				border-left: 1px solid black;
				border-top: 2px solid black;
				border-bottom: 2px solid black;
			}

			table.table-border-spesial-tengah, th.table-border-spesial-tengah, td.table-border-spesial-tengah {
				border-left: 1px solid #cccccc;
				border-right: 1px solid #cccccc;
				border-top: 2px solid black;
				border-bottom: 2px solid black;
			}

			table.table-border-spesial-kanan, th.table-border-spesial-kanan, td.table-border-spesial-kanan {
				border-left: 1px solid #cccccc;
				border-right: 1px solid black;
				border-top: 2px solid black;
				border-bottom: 2px solid black;
			}

			table tr.table-judul{
				border: 1px solid;
				background-color: #e69500;
				font-weight: bold;
				font-size: 7px;
				color: black;
			}
				
			table tr.table-baris1{
				background-color: none;
				font-size: 7px;
			}

			table tr.table-baris1-bold{
				background-color: none;
				font-size: 7px;
				font-weight: bold;
			}
				
			table tr.table-total{
				background-color: #FFFF00;
				font-weight: bold;
				font-size: 7px;
				color: black;
			}

			table tr.table-total2{
				background-color: #eeeeee;
				font-weight: bold;
				font-size: 7px;
				color: black;
			}
		</style>

	</head>
	<body>
		<div align="center" style="display: block;font-weight: bold;font-size: 11px;">EVALUASI TARGET PRODUKSI</div>
		<div align="center" style="display: block;font-weight: bold;font-size: 11px;">DIVISI STONE CRUSHER</div>
		<div align="center" style="display: block;font-weight: bold;font-size: 11px; text-transform: uppercase;">PERIODE : <?php echo str_replace($search, $replace, $subject);?></div>
		<br /><br /><br />
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
		
		<table class="table table-bordered" width="98%"  cellpadding="3">
		<?php
			$rak = $this->db->select('r.*')
			->from('rak r')
			->where("(r.tanggal_rencana_kerja between '$date1' and '$date2')")
			->group_by("r.id")
			->get()->row_array();

			$penjualan_abu_batu = $this->db->select('SUM(pp.display_volume) as volume, SUM(pp.display_price) as price')
			->from('pmm_productions pp')
			->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
			->where("pp.date_production between '$date1' and '$date2'")
			->where("pp.product_id in (7)")
			->where("ppo.status in ('OPEN','CLOSED')")
			->get()->row_array();

			$penjualan_0510 = $this->db->select('SUM(pp.display_volume) as volume, SUM(pp.display_price) as price')
			->from('pmm_productions pp')
			->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
			->where("pp.date_production between '$date1' and '$date2'")
			->where("pp.product_id in (8)")
			->where("ppo.status in ('OPEN','CLOSED')")
			->get()->row_array();

			$penjualan_0115 = $this->db->select('SUM(pp.display_volume) as volume, SUM(pp.display_price) as price')
			->from('pmm_productions pp')
			->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
			->where("pp.date_production between '$date1' and '$date2'")
			->where("pp.product_id in (63)")
			->where("ppo.status in ('OPEN','CLOSED')")
			->get()->row_array();

			$penjualan_1020 = $this->db->select('SUM(pp.display_volume) as volume, SUM(pp.display_price) as price')
			->from('pmm_productions pp')
			->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
			->where("pp.date_production between '$date1' and '$date2'")
			->where("pp.product_id in (3)")
			->where("ppo.status in ('OPEN','CLOSED')")
			->get()->row_array();

			$penjualan_2030 = $this->db->select('SUM(pp.display_volume) as volume, SUM(pp.display_price) as price')
			->from('pmm_productions pp')
			->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
			->where("pp.date_production between '$date1' and '$date2'")
			->where("pp.product_id in (4)")
			->where("ppo.status in ('OPEN','CLOSED')")
			->get()->row_array();

			$evaluasi_produk_a = $penjualan_abu_batu['volume'] - $rak['vol_produk_a'];
			$evaluasi_produk_b = $penjualan_0510['volume'] - $rak['vol_produk_b'];
			$evaluasi_produk_c = $penjualan_0115['volume'] - $rak['vol_produk_c'];
			$evaluasi_produk_d = $penjualan_1020['volume'] - $rak['vol_produk_d'];
			$evaluasi_produk_e = $penjualan_2030['volume'] - $rak['vol_produk_e'];

			$total_volume_rap = $rak['vol_produk_a'] + $rak['vol_produk_b'] + $rak['vol_produk_c'] + $rak['vol_produk_d'] + $rak['vol_produk_e'] + $rak['vol_produk_e'];
			$total_volume_realiasi =  $penjualan_abu_batu['volume'] + $penjualan_0510['volume'] + $penjualan_0115['volume'] + $penjualan_1020['volume'] + $penjualan_2030['volume'];
			$total_volume_evaluasi = $total_volume_realiasi - $total_volume_rap;

			$pu_a = $rak['vol_produk_a'] * $rak['price_a'];
			$pu_b = $rak['vol_produk_b'] * $rak['price_b'];
			$pu_c = $rak['vol_produk_c'] * $rak['price_c'];
			$pu_d = $rak['vol_produk_d'] * $rak['price_d'];
			$pu_e = $rak['vol_produk_e'] * $rak['price_e'];
			$total_pu = $pu_a + $pu_b + $pu_c + $pu_d + $pu_e;

			$total_penjualan = $penjualan_abu_batu['price'] + $penjualan_0510['price'] + $penjualan_0115['price'] + $penjualan_1020['price'] + $penjualan_2030['price'];
			$total_evulasi_pu = $total_penjualan - $total_pu;
			?>

			<?php
			$id_boulder = $rak['penawaran_id_boulder'];

			$pnw_boulder = $this->db->select('(ppd.price) as price')
			->from('pmm_penawaran_pembelian_detail ppd')
			->where("ppd.penawaran_pembelian_id = $id_boulder")
			->get()->row_array();
			
			$biaya_boulder = $rak['vol_boulder'] * $pnw_boulder['price'];
			$biaya_bahan = $biaya_boulder;
			?>

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
			
			$vol_alat = round($rak['vol_boulder'],2);
			$nilai_tangki = $vol_alat * $nilai_tangki_ton;
			$nilai_sc = $vol_alat * $nilai_sc_ton;
			$nilai_genset = $vol_alat * $nilai_gns_ton;
			$nilai_wl = $vol_alat * $nilai_wl_ton;
			$nilai_timbangan = $vol_alat * $nilai_timbangan_ton;

			$id_solar = $rak['penawaran_id_solar'];
			$pnw_solar = $this->db->select('(ppd.price) as price')
			->from('pmm_penawaran_pembelian_detail ppd')
			->where("ppd.penawaran_pembelian_id = $id_solar")
			->get()->row_array();

			$biaya_solar = $rak['vol_bbm_solar'] * $pnw_solar['price'];

			$biaya_alat = $nilai_tangki + $nilai_sc + $nilai_genset + $nilai_wl + $nilai_timbangan + $biaya_solar;
			?>

			<?php
			$overhead = $rak['overhead'];
			?>

			<?php
			$total_biaya_rak = $biaya_bahan + $biaya_alat + $overhead;
			?>

			<?php
			$rekapitulasi_produksi_harian = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
			->from('pmm_produksi_harian pph ')
			->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
			->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
			->where("(pph.date_prod between '$date1' and '$date2')")
			->where('pph.status','PUBLISH')
			->get()->row_array();
			$total_rekapitulasi_produksi_harian = round($rekapitulasi_produksi_harian['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_f'],2);
			
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

			$biaya_bahan_realisasi = $total_nilai_produksi_boulder;
			?>

			<?php
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

			$pemakaian_bbm = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
			->from('kunci_bahan_baku pp')
			->where("(pp.date between '$date1' and '$date2')")
			->order_by('pp.date','desc')->limit(1)
			->get()->row_array();
			$vol_pemakaian_bbm = $pemakaian_bbm['volume'];
			$nilai_pemakaian_bbm = $pemakaian_bbm['nilai'];
			$harsat_pemakaian_bbm = (round($vol_pemakaian_bbm,2)!=0)?$nilai_pemakaian_bbm / round($vol_pemakaian_bbm,2) * 1:0;

			$pemakaian_bbm_2 = $this->db->select('sum(pp.vol_pemakaian_bbm_2) as volume, sum(pp.nilai_pemakaian_bbm_2) as nilai')
			->from('kunci_bahan_baku pp')
			->where("(pp.date between '$date1' and '$date2')")
			->order_by('pp.date','desc')->limit(1)
			->get()->row_array();
			$vol_pemakaian_bbm_2 = $pemakaian_bbm_2['volume'];
			$nilai_pemakaian_bbm_2 = $pemakaian_bbm_2['nilai'];
			$harsat_pemakaian_bbm_2 = (round($vol_pemakaian_bbm_2,2)!=0)?$nilai_pemakaian_bbm_2 / round($vol_pemakaian_bbm_2,2) * 1:0;

			$stok_volume_bbm_lalu = $stock_opname_bbm_ago['volume'];
			$stok_nilai_bbm_lalu = $harga_bbm['nilai_bbm'];
			$stok_harsat_bbm_lalu = (round($stok_volume_bbm_lalu,2)!=0)?$stok_nilai_bbm_lalu / round($stok_volume_bbm_lalu,2) * 1:0;

			$pembelian_volume = $pembelian_bbm['volume'];
			$pembelian_harga = $pembelian_bbm['harga'];
			$pembelian_nilai = $pembelian_bbm['nilai'];

			$total_stok_volume = $stok_volume_bbm_lalu + $pembelian_volume;
			$total_stok_nilai = $stok_nilai_bbm_lalu + $pembelian_nilai;
			$total_stok_harsat = (round($total_stok_volume,2)!=0)?$total_stok_nilai / round($total_stok_volume,2) * 1:0;

			$produksi_volume = $vol_pemakaian_bbm;
			$produksi_harsat = $harsat_pemakaian_bbm;
			$produksi_nilai = $nilai_pemakaian_bbm;

			$produksi_2_volume = $vol_pemakaian_bbm_2;
			$produksi_2_harsat = $harsat_pemakaian_bbm_2;
			$produksi_2_nilai = $nilai_pemakaian_bbm_2;

			//PEMAKAIAN DILUAR PRODUKSI
			$nilai_bbm_non_produksi = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->where("pdb.akun = 105")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$vol_bbm_non_produksi = $nilai_bbm_non_produksi['memo'];
			$nilai_bbm_non_produksi = $nilai_bbm_non_produksi['total'];

			$total_produksi_volume = $produksi_volume + $produksi_2_volume + $vol_bbm_non_produksi;
			$total_produksi_nilai = $produksi_nilai + $produksi_2_nilai + $nilai_bbm_non_produksi;

			$harga_baru = $total_produksi_nilai / $total_produksi_volume;
			$total_nilai_produksi_solar = $total_produksi_nilai;

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
			
			$total_biaya_peralatan = $stone_crusher + $whell_loader + $genset + $timbangan + $tangki_solar;

			$biaya_alat_realisasi = $total_biaya_peralatan + $total_nilai_produksi_solar;
			?>
			
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
			//$solar = $solar_biaya['total'] + $solar_jurnal['total'];
			$solar = 0;

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

			$overhead_realisasi = $total_operasional;
			?>

			<?php
			$total_biaya_realisasi = $biaya_bahan_realisasi + $biaya_alat_realisasi + $overhead_realisasi;
			$biaya_bahan_evaluasi = $biaya_bahan - $biaya_bahan_realisasi;
			$biaya_alat_evaluasi = $biaya_alat - $biaya_alat_realisasi;
			$overhead_evaluasi = $overhead - $overhead_realisasi;
			$total_biaya_evaluasi = $total_biaya_rak - $total_biaya_realisasi;
			$laba_rak = $total_pu - $total_biaya_rak;
			$presentase_rak = ($total_pu!=0)?($laba_rak / $total_pu) * 1:0;
			$laba_realisasi = $total_penjualan - $total_biaya_realisasi;
			$presentase_realisasi = ($total_penjualan!=0)?($laba_realisasi / $total_penjualan) * 1:0;
			?>
			
			<tr class="table-judul">
				<th width="5%" align="center" class="table-border-pojok-kiri">NO.</th>
				<th width="25%" align="center" class="table-border-pojok-tengah">URAIAN</th>
				<th width="10%" align="center" class="table-border-pojok-tengah">SATUAN</th>
				<th width="20%" align="center" class="table-border-pojok-tengah">RENCANA</th>
				<th width="20%" align="center" class="table-border-pojok-tengah">REALISASI</th>
				<th width="20%" align="center" class="table-border-pojok-kanan">EVALUASI</th>
	        </tr>
			<tr class="table-total2">
				<th align="left" colspan="6" class="table-border-spesial">RENCANA PRODUKSI & PENDAPATAN USAHA</th>
			</tr>
			<?php
				$styleColorA = $evaluasi_produk_a < 0 ? 'color:red' : 'color:black';
				$styleColorB = $evaluasi_produk_b < 0 ? 'color:red' : 'color:black';
				$styleColorC = $evaluasi_produk_c < 0 ? 'color:red' : 'color:black';
				$styleColorD = $evaluasi_produk_d < 0 ? 'color:red' : 'color:black';
				$styleColorE = $evaluasi_produk_e < 0 ? 'color:red' : 'color:black';
				$styleColorF = $total_volume_evaluasi < 0 ? 'color:red' : 'color:black';
				$styleColorG = $total_evulasi_pu < 0 ? 'color:red' : 'color:black';
				$styleColorH = $biaya_bahan_evaluasi < 0 ? 'color:red' : 'color:black';
				$styleColorI = $biaya_alat_evaluasi < 0 ? 'color:red' : 'color:black';
				$styleColorJ = $overhead_evaluasi < 0 ? 'color:red' : 'color:black';
				$styleColorK = $total_biaya_evaluasi < 0 ? 'color:red' : 'color:black';
				$styleColorL = $laba_rak < 0 ? 'color:red' : 'color:black';
				$styleColorM = $laba_realisasi < 0 ? 'color:red' : 'color:black';
				$styleColorN = $presentase_rak < 0 ? 'color:red' : 'color:black';
				$styleColorO = $presentase_realisasi < 0 ? 'color:red' : 'color:black';
			?>
			<tr class="table-baris1">
				<th align="center" class="table-border-pojok-kiri">1.</th>
				<th align="left" class="table-border-pojok-tengah">Batu Split 0 - 0,5 (Abu Batu)</th>
				<th align="center" class="table-border-pojok-tengah">Ton</th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($rak['vol_produk_a'],2,',','.');?></th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($penjualan_abu_batu['volume'],2,',','.');?></th>
				<th align="right" class="table-border-pojok-kanan" style="<?php echo $styleColorA ?>"><?php echo $evaluasi_produk_a < 0 ? "(".number_format(-$evaluasi_produk_a,2,',','.').")" : number_format($evaluasi_produk_a,2,',','.');?></th>
			</tr>
			<tr class="table-baris1">
				<th align="center" class="table-border-pojok-kiri">2.</th>
				<th align="left" class="table-border-pojok-tengah">Batu Split 0,5 - 1</th>
				<th align="center" class="table-border-pojok-tengah">Ton</th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($rak['vol_produk_b'],2,',','.');?></th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($penjualan_0510['volume'],2,',','.');?></th>
				<th align="right" class="table-border-pojok-kanan" style="<?php echo $styleColorB ?>"><?php echo $evaluasi_produk_b < 0 ? "(".number_format(-$evaluasi_produk_b,2,',','.').")" : number_format($evaluasi_produk_b,2,',','.');?></th>
			</tr>
			<tr class="table-baris1">
				<th align="center" class="table-border-pojok-kiri">3.</th>
				<th align="left" class="table-border-pojok-tengah">Batu Split 1 - 1,5</th>
				<th align="center" class="table-border-pojok-tengah">Ton</th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($rak['vol_produk_c'],2,',','.');?></th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($penjualan_0115['volume'],2,',','.');?></th>
				<th align="right" class="table-border-pojok-kanan" style="<?php echo $styleColorC ?>"><?php echo $evaluasi_produk_c < 0 ? "(".number_format(-$evaluasi_produk_c,2,',','.').")" : number_format($evaluasi_produk_c,2,',','.');?></th>
			</tr>
			<tr class="table-baris1">
				<th align="center" class="table-border-pojok-kiri">4.</th>
				<th align="left" class="table-border-pojok-tengah">Batu Split 1 - 2</th>
				<th align="center" class="table-border-pojok-tengah">Ton</th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($rak['vol_produk_d'],2,',','.');?></th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($penjualan_1020['volume'],2,',','.');?></th>
				<th align="right" class="table-border-pojok-kanan" style="<?php echo $styleColorD ?>"><?php echo $evaluasi_produk_d < 0 ? "(".number_format(-$evaluasi_produk_d,2,',','.').")" : number_format($evaluasi_produk_d,2,',','.');?></th>
			</tr>
			<tr class="table-baris1">
				<th align="center" class="table-border-pojok-kiri">5.</th>
				<th align="left" class="table-border-pojok-tengah">Batu Split 2 - 3</th>
				<th align="center" class="table-border-pojok-tengah">Ton</th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($rak['vol_produk_e'],2,',','.');?></th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($penjualan_2030['volume'],2,',','.');?></th>
				<th align="right" class="table-border-pojok-kanan" style="<?php echo $styleColorE ?>"><?php echo $evaluasi_produk_e < 0 ? "(".number_format(-$evaluasi_produk_e,2,',','.').")" : number_format($evaluasi_produk_e,2,',','.');?></th>
			</tr>
			<tr class="table-total2">
				<th align="right" colspan="2" class="table-border-spesial-kiri">TOTAL VOLUME</th>
				<th align="center" class="table-border-spesial-tengah">Ton</th>
				<th align="right" class="table-border-spesial-tengah"><?php echo number_format($total_volume_rap,2,',','.');?></th>
				<th align="right" class="table-border-spesial-tengah"><?php echo number_format($total_volume_realiasi,2,',','.');?></th>
				<th align="right" class="table-border-spesial-kanan" style="<?php echo $styleColorF ?>"><?php echo $total_volume_evaluasi < 0 ? "(".number_format(-$total_volume_evaluasi,2,',','.').")" : number_format($total_volume_evaluasi,2,',','.');?></th>
			</tr>
			<tr class="table-total">
				<th align="right" colspan="2" class="table-border-spesial-kiri">PENDAPATAN USAHA</th>
				<th align="center"class="table-border-spesial-tengah"></th>
				<th align="right" class="table-border-spesial-tengah"><?php echo number_format($total_pu,0,',','.');?></th>
				<th align="right" class="table-border-spesial-tengah"><?php echo number_format($total_penjualan,0,',','.');?></th>
				<th align="right" class="table-border-spesial-kanan" style="<?php echo $styleColorG ?>"><?php echo $total_evulasi_pu < 0 ? "(".number_format(-$total_evulasi_pu,0,',','.').")" : number_format($total_evulasi_pu,0,',','.');?></th>
			</tr>
			<tr class="table-total2">
				<th align="left" colspan="6" class="table-border-spesial">BIAYA</th>
			</tr>
			<tr class="table-baris1">
				<th align="center" class="table-border-pojok-kiri">1.</th>
				<th align="left" class="table-border-pojok-tengah">Bahan</th>
				<th align="center" class="table-border-pojok-tengah">Ls</th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($biaya_bahan,0,',','.');?></th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($biaya_bahan_realisasi,0,',','.');?></th>
				<th align="right" class="table-border-pojok-kanan" style="<?php echo $styleColorH ?>"><?php echo $biaya_bahan_evaluasi < 0 ? "(".number_format(-$biaya_bahan_evaluasi,0,',','.').")" : number_format($biaya_bahan_evaluasi,0,',','.');?></th>
			</tr>
			<tr class="table-baris1">
				<th align="center" class="table-border-pojok-kiri">2.</th>
				<th align="left" class="table-border-pojok-tengah">Alat</th>
				<th align="center" class="table-border-pojok-tengah">Ls</th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($biaya_alat,0,',','.');?></th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($biaya_alat_realisasi,0,',','.');?></th>
				<th align="right" class="table-border-pojok-kanan" style="<?php echo $styleColorI ?>"><?php echo $biaya_alat_evaluasi < 0 ? "(".number_format(-$biaya_alat_evaluasi,0,',','.').")" : number_format($biaya_alat_evaluasi,0,',','.');?></th>
			</tr>
			<tr class="table-baris1">
				<th align="center" class="table-border-pojok-kiri">3.</th>
				<th align="left" class="table-border-pojok-tengah">Overhead</th>
				<th align="center" class="table-border-pojok-tengah">Ls</th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($overhead,0,',','.');?></th>
				<th align="right" class="table-border-pojok-tengah"><?php echo number_format($overhead_realisasi,0,',','.');?></th>
				<th align="right" class="table-border-pojok-kanan" style="<?php echo $styleColorJ ?>"><?php echo $overhead_evaluasi < 0 ? "(".number_format(-$overhead_evaluasi,0,',','.').")" : number_format($overhead_evaluasi,0,',','.');?></th>
			</tr>
			<tr class="table-total2">
				<th align="right" colspan="2" class="table-border-spesial-kiri">JUMLAH</th>
				<th align="center" class="table-border-spesial-tengah"></th>
				<th align="right" class="table-border-spesial-tengah"><?php echo number_format($total_biaya_rak,0,',','.');?></th>
				<th align="right" class="table-border-spesial-tengah"><?php echo number_format($total_biaya_realisasi,0,',','.');?></th>
				<th align="right" class="table-border-spesial-kanan" style="<?php echo $styleColorK ?>"><?php echo $total_biaya_evaluasi < 0 ? "(".number_format(-$total_biaya_evaluasi,0,',','.').")" : number_format($total_biaya_evaluasi,0,',','.');?></th>
			</tr>
			<tr class="table-judul">
				<th align="right" colspan="2" class="table-border-spesial-kiri">LABA</th>
				<th align="center" class="table-border-spesial-tengah"></th>
				<th align="right" class="table-border-spesial-tengah" style="<?php echo $styleColorL ?>"><?php echo $laba_rak < 0 ? "(".number_format(-$laba_rak,0,',','.').")" : number_format($laba_rak,0,',','.');?></th>
				<th align="right" class="table-border-spesial-tengah" style="<?php echo $styleColorM ?>"><?php echo $laba_realisasi < 0 ? "(".number_format(-$laba_realisasi,0,',','.').")" : number_format($laba_realisasi,0,',','.');?></th>
				<th align="right" class="table-border-spesial-kanan"></th>
			</tr>
			<tr class="table-judul">
				<th align="right" colspan="2" class="table-border-spesial-kiri">PRESENTASE</th>
				<th align="center" class="table-border-spesial-tengah"></th>
				<th align="right" class="table-border-spesial-tengah" style="<?php echo $styleColorN ?>"><?php echo $presentase_rak < 0 ? "(".number_format(-$presentase_rak,2,',','.').")" : number_format($presentase_rak,2,',','.');?> %</th>
				<th align="right" class="table-border-spesial-tengah" style="<?php echo $styleColorO ?>"><?php echo $presentase_realisasi < 0 ? "(".number_format(-$presentase_realisasi,2,',','.').")" : number_format($presentase_realisasi,2,',','.');?> %</th>
				<th align="right" class="table-border-spesial-kanan"></th>
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