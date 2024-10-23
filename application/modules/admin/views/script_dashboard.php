<!-- Akumulasi --->

<?php

	$date_now = date('Y-m-d');
	$date_juli23_akhir = date('2023-07-31');
	$date_agustus23_awal = date('2023-08-01');
    $date_agustus23_akhir = date('2023-08-31');
    $date_september23_awal = date('2023-09-01');
    $date_september23_akhir = date('2023-09-30');
    $date_oktober23_awal = date('2023-10-01');
    $date_oktober23_akhir = date('2023-10-31');
    $date_november23_awal = date('2023-11-01');
    $date_november23_akhir = date('2023-11-30');
    $date_desember23_awal = date('2023-12-01');
    $date_desember23_akhir = date('2023-12-31');
    $date_januari24_awal = date('2024-01-01');
    $date_januari24_akhir = date('2024-01-31');
    $date_februari24_awal = date('2024-02-01');
    $date_februari24_akhir = date('2024-02-29');
    $date_maret24_awal = date('2024-03-01');
    $date_maret24_akhir = date('2024-03-31');
    $date_april24_awal = date('2024-04-01');
    $date_april24_akhir = date('2024-04-30');
    $date_mei24_awal = date('2024-05-01');
    $date_mei24_akhir = date('2024-05-31');
    $date_juni24_awal = date('2024-06-01');
    $date_juni24_akhir = date('2024-06-30');
    $date_juli24_awal = date('2024-07-01');
    $date_juli24_akhir = date('2024-07-31');
    $date_agustus24_awal = date('2024-08-01');
    $date_agustus24_akhir = date('2024-08-31');
    $date_september24_awal = date('2024-09-01');
    $date_september24_akhir = date('2024-09-30');
    $date_oktober24_awal = date('2024-10-01');
    $date_oktober24_akhir = date('2024-10-31');
    $date_november24_awal = date('2024-11-01');
    $date_november24_akhir = date('2024-11-30');
    $date_desember24_awal = date('2024-12-01');
    $date_desember24_akhir = date('2024-12-31');
	$date_akumulasi_awal = date('2023-08-01');
    $date_akumulasi_akhir = date('2024-12-31');

	//RAP
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
	$total_ton_rap = $total_ton + (($total_ton * 10) / 100);

	//AGUSTUS23
	$penjualan_agustus23 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_agustus23_awal' and '$date_agustus23_akhir'")
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
	
	$total_penjualan_agustus23 = 0;
	$total_volume_penjualan_agustus23 = 0;

	foreach ($penjualan_agustus23 as $x){
		$total_penjualan_agustus23 += $x['price'];
		$total_volume_penjualan_agustus23 += $x['volume'];
	}

	$penjualan_limbah_agustus23 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_agustus23_awal' and '$date_agustus23_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_agustus23 = 0;

	foreach ($penjualan_limbah_agustus23 as $x){
		$total_penjualan_limbah_agustus23 += $x['price'];
	}

	$penjualan_lain_lain_agustus23 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_agustus23_awal' and '$date_agustus23_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_agustus23 = 0;

	foreach ($penjualan_lain_lain_agustus23 as $x){
		$total_penjualan_lain_lain_agustus23 += $x['price'];
	}

	$akumulasi_bahan_jadi_agustus23 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_agustus23')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_juli23_akhir' and '$date_agustus23_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_agustus23 = $akumulasi_bahan_jadi_agustus23['harsat_agustus23'];

	$penjualan_agustus23 = $total_penjualan_agustus23 + $total_penjualan_limbah_agustus23 + $total_penjualan_lain_lain_agustus23;
	$beban_pokok_penjualan_agustus23 = $total_volume_penjualan_agustus23 * $harsat_bahan_jadi_agustus23;
	$laba_kotor_agustus23 = $penjualan_agustus23 - $beban_pokok_penjualan_agustus23;

	$persentase_laba_kotor_agustus23 = ($penjualan_agustus23!=0)?($laba_kotor_agustus23 / $penjualan_agustus23) * 100:0;
	$persentase_laba_kotor_agustus23_fix = round($persentase_laba_kotor_agustus23,2);

	$laba_kotor_rap_agustus23 = $total_penjualan_agustus23 - ($total_volume_penjualan_agustus23 * $total_ton_rap);
	$persentase_laba_kotor_rap_agustus23 = ($penjualan_agustus23!=0)?($laba_kotor_rap_agustus23 / $penjualan_agustus23)  * 100:0;
	$persentase_laba_kotor_rap_agustus23_fix = round($persentase_laba_kotor_rap_agustus23,2);

	//SEPTEMBER23
	$penjualan_september23 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_september23_awal' and '$date_september23_akhir'")
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
	
	$total_penjualan_september23 = 0;
	$total_volume_penjualan_september23 = 0;

	foreach ($penjualan_september23 as $x){
		$total_penjualan_september23 += $x['price'];
		$total_volume_penjualan_september23 += $x['volume'];
	}

	$penjualan_limbah_september23 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_september23_awal' and '$date_september23_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_september23 = 0;

	foreach ($penjualan_limbah_september23 as $x){
		$total_penjualan_limbah_september23 += $x['price'];
	}

	$penjualan_lain_lain_september23 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_september23_awal' and '$date_september23_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_september23 = 0;

	foreach ($penjualan_lain_lain_september23 as $x){
		$total_penjualan_lain_lain_september23 += $x['price'];
	}

	$akumulasi_bahan_jadi_september23 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_september23')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_agustus23_akhir' and '$date_september23_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_september23 = $akumulasi_bahan_jadi_september23['harsat_september23'];

	$penjualan_september23 = $total_penjualan_september23 + $total_penjualan_limbah_september23 + $total_penjualan_lain_lain_september23;
	$beban_pokok_penjualan_september23 = $total_volume_penjualan_september23 * $harsat_bahan_jadi_september23;
	$laba_kotor_september23 = $penjualan_september23 - $beban_pokok_penjualan_september23;

	$persentase_laba_kotor_september23 = ($penjualan_september23!=0)?($laba_kotor_september23 / $penjualan_september23) * 100:0;
	$persentase_laba_kotor_september23_fix = round($persentase_laba_kotor_september23,2);

	$laba_kotor_rap_september23 = $penjualan_september23 - ($total_volume_penjualan_september23 * $total_ton_rap);
	$persentase_laba_kotor_rap_september23 = ($penjualan_september23!=0)?($laba_kotor_rap_september23 / $penjualan_september23)  * 100:0;
	$persentase_laba_kotor_rap_september23_fix = round($persentase_laba_kotor_rap_september23,2);

	//OKTOBER23
	$penjualan_oktober23 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_oktober23_awal' and '$date_oktober23_akhir'")
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
	
	$total_penjualan_oktober23 = 0;
	$total_volume_penjualan_oktober23 = 0;

	foreach ($penjualan_oktober23 as $x){
		$total_penjualan_oktober23 += $x['price'];
		$total_volume_penjualan_oktober23 += $x['volume'];
	}

	$penjualan_limbah_oktober23 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_oktober23_awal' and '$date_oktober23_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_oktober23 = 0;

	foreach ($penjualan_limbah_oktober23 as $x){
		$total_penjualan_limbah_oktober23 += $x['price'];
	}

	$penjualan_lain_lain_oktober23 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_oktober23_awal' and '$date_oktober23_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_oktober23 = 0;

	foreach ($penjualan_lain_lain_oktober23 as $x){
		$total_penjualan_lain_lain_oktober23 += $x['price'];
	}

	$akumulasi_bahan_jadi_oktober23 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_oktober23')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_september23_akhir' and '$date_oktober23_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_oktober23 = $akumulasi_bahan_jadi_oktober23['harsat_oktober23'];

	$penjualan_oktober23 = $total_penjualan_oktober23 + $total_penjualan_limbah_oktober23 + $total_penjualan_lain_lain_oktober23;
	$beban_pokok_penjualan_oktober23 = $total_volume_penjualan_oktober23 * $harsat_bahan_jadi_oktober23;
	$laba_kotor_oktober23 = $penjualan_oktober23 - $beban_pokok_penjualan_oktober23;

	$persentase_laba_kotor_oktober23 = ($penjualan_oktober23!=0)?($laba_kotor_oktober23 / $penjualan_oktober23) * 100:0;
	$persentase_laba_kotor_oktober23_fix = round($persentase_laba_kotor_oktober23,2);

	$laba_kotor_rap_oktober23 = $penjualan_oktober23 - ($total_volume_penjualan_oktober23 * $total_ton_rap);
	$persentase_laba_kotor_rap_oktober23 = ($penjualan_oktober23!=0)?($laba_kotor_rap_oktober23 / $penjualan_oktober23)  * 100:0;
	$persentase_laba_kotor_rap_oktober23_fix = round($persentase_laba_kotor_rap_oktober23,2);

	//NOVEMBER23
	$penjualan_november23 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_november23_awal' and '$date_november23_akhir'")
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
	
	$total_penjualan_november23 = 0;
	$total_volume_penjualan_november23 = 0;

	foreach ($penjualan_november23 as $x){
		$total_penjualan_november23 += $x['price'];
		$total_volume_penjualan_november23 += $x['volume'];
	}

	$penjualan_limbah_november23 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_november23_awal' and '$date_november23_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_november23 = 0;

	foreach ($penjualan_limbah_november23 as $x){
		$total_penjualan_limbah_november23 += $x['price'];
	}

	$penjualan_lain_lain_november23 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_november23_awal' and '$date_november23_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_november23 = 0;

	foreach ($penjualan_lain_lain_november23 as $x){
		$total_penjualan_lain_lain_november23 += $x['price'];
	}

	$akumulasi_bahan_jadi_november23 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_november23')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_oktober23_akhir' and '$date_november23_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_november23 = $akumulasi_bahan_jadi_november23['harsat_november23'];

	$penjualan_november23 = $total_penjualan_november23 + $total_penjualan_limbah_november23 + $total_penjualan_lain_lain_november23;
	$beban_pokok_penjualan_november23 = $total_volume_penjualan_november23 * $harsat_bahan_jadi_november23;
	$laba_kotor_november23 = $penjualan_november23 - $beban_pokok_penjualan_november23;

	
	$persentase_laba_kotor_november23 = ($penjualan_november23!=0)?($laba_kotor_november23 / $penjualan_november23) * 100:0;
	$persentase_laba_kotor_november23_fix = round($persentase_laba_kotor_november23,2);

	$laba_kotor_rap_november23 = $penjualan_november23 - ($total_volume_penjualan_november23 * $total_ton_rap);
	$persentase_laba_kotor_rap_november23 = ($penjualan_november23!=0)?($laba_kotor_rap_november23 / $penjualan_november23)  * 100:0;
	$persentase_laba_kotor_rap_november23_fix = round($persentase_laba_kotor_rap_november23,2);

	//DESEMBER23
	$penjualan_desember23 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_desember23_awal' and '$date_desember23_akhir'")
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
	
	$total_penjualan_desember23 = 0;
	$total_volume_penjualan_desember23 = 0;

	foreach ($penjualan_desember23 as $x){
		$total_penjualan_desember23 += $x['price'];
		$total_volume_penjualan_desember23 += $x['volume'];
	}

	$penjualan_limbah_desember23 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_desember23_awal' and '$date_desember23_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_desember23 = 0;

	foreach ($penjualan_limbah_desember23 as $x){
		$total_penjualan_limbah_desember23 += $x['price'];
	}

	$penjualan_lain_lain_desember23 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_desember23_awal' and '$date_desember23_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_desember23 = 0;

	foreach ($penjualan_lain_lain_desember23 as $x){
		$total_penjualan_lain_lain_desember23 += $x['price'];
	}

	$akumulasi_bahan_jadi_desember23 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_desember23')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_november23_akhir' and '$date_desember23_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_desember23 = $akumulasi_bahan_jadi_desember23['harsat_desember23'];

	$penjualan_desember23 = $total_penjualan_desember23 + $total_penjualan_limbah_desember23 + $total_penjualan_lain_lain_desember23;
	$beban_pokok_penjualan_desember23 = $total_volume_penjualan_desember23 * $harsat_bahan_jadi_desember23;
	$laba_kotor_desember23 = $penjualan_desember23 - $beban_pokok_penjualan_desember23;

	
	$persentase_laba_kotor_desember23 = ($penjualan_desember23!=0)?($laba_kotor_desember23 / $penjualan_desember23) * 100:0;
	$persentase_laba_kotor_desember23_fix = round($persentase_laba_kotor_desember23,2);

	$laba_kotor_rap_desember23 = $penjualan_desember23 - ($total_volume_penjualan_desember23 * $total_ton_rap);
	$persentase_laba_kotor_rap_desember23 = ($penjualan_desember23!=0)?($laba_kotor_rap_desember23 / $penjualan_desember23)  * 100:0;
	$persentase_laba_kotor_rap_desember23_fix = round($persentase_laba_kotor_rap_desember23,2);

	//JANUARI24
	$penjualan_januari24 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_januari24_awal' and '$date_januari24_akhir'")
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
	
	$total_penjualan_januari24 = 0;
	$total_volume_penjualan_januari24 = 0;

	foreach ($penjualan_januari24 as $x){
		$total_penjualan_januari24 += $x['price'];
		$total_volume_penjualan_januari24 += $x['volume'];
	}

	$penjualan_limbah_januari24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_januari24_awal' and '$date_januari24_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_januari24 = 0;

	foreach ($penjualan_limbah_januari24 as $x){
		$total_penjualan_limbah_januari24 += $x['price'];
	}

	$penjualan_lain_lain_januari24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_januari24_awal' and '$date_januari24_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_januari24 = 0;

	foreach ($penjualan_lain_lain_januari24 as $x){
		$total_penjualan_lain_lain_januari24 += $x['price'];
	}

	$akumulasi_bahan_jadi_januari24 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_januari24')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_desember23_akhir' and '$date_januari24_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_januari24 = $akumulasi_bahan_jadi_januari24['harsat_januari24'];

	$penjualan_januari24 = $total_penjualan_januari24 + $total_penjualan_limbah_januari24 + $total_penjualan_lain_lain_januari24;
	$beban_pokok_penjualan_januari24 = $total_volume_penjualan_januari24 * $harsat_bahan_jadi_januari24;
	$laba_kotor_januari24 = $penjualan_januari24 - $beban_pokok_penjualan_januari24;
	
	$persentase_laba_kotor_januari24 = ($penjualan_januari24!=0)?($laba_kotor_januari24 / $penjualan_januari24) * 100:0;
	$persentase_laba_kotor_januari24_fix = round($persentase_laba_kotor_januari24,2);

	$laba_kotor_rap_januari24 = $penjualan_januari24 - ($total_volume_penjualan_januari24 * $total_ton_rap);
	$persentase_laba_kotor_rap_januari24 = ($penjualan_januari24!=0)?($laba_kotor_rap_januari24 / $penjualan_januari24)  * 100:0;
	$persentase_laba_kotor_rap_januari24_fix = round($persentase_laba_kotor_rap_januari24,2);

	//FEBRUARI24
	$penjualan_februari24 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_februari24_awal' and '$date_februari24_akhir'")
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
	
	$total_penjualan_februari24 = 0;
	$total_volume_penjualan_februari24 = 0;

	foreach ($penjualan_februari24 as $x){
		$total_penjualan_februari24 += $x['price'];
		$total_volume_penjualan_februari24 += $x['volume'];
	}

	$penjualan_limbah_februari24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_februari24_awal' and '$date_februari24_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_februari24 = 0;

	foreach ($penjualan_limbah_februari24 as $x){
		$total_penjualan_limbah_februari24 += $x['price'];
	}

	$penjualan_lain_lain_februari24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_februari24_awal' and '$date_februari24_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_februari24 = 0;

	foreach ($penjualan_lain_lain_februari24 as $x){
		$total_penjualan_lain_lain_februari24 += $x['price'];
	}

	$akumulasi_bahan_jadi_februari24 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_februari24')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_januari24_akhir' and '$date_februari24_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_februari24 = $akumulasi_bahan_jadi_februari24['harsat_februari24'];

	$penjualan_februari24 = $total_penjualan_februari24 + $total_penjualan_limbah_februari24 + $total_penjualan_lain_lain_februari24;
	$beban_pokok_penjualan_februari24 = $total_volume_penjualan_februari24 * $harsat_bahan_jadi_februari24;
	$laba_kotor_februari24 = $penjualan_februari24 - $beban_pokok_penjualan_februari24;

	
	$persentase_laba_kotor_februari24 = ($penjualan_februari24!=0)?($laba_kotor_februari24 / $penjualan_februari24) * 100:0;
	$persentase_laba_kotor_februari24_fix = round($persentase_laba_kotor_februari24,2);

	$laba_kotor_rap_februari24 = $penjualan_februari24 - ($total_volume_penjualan_februari24 * $total_ton_rap);
	$persentase_laba_kotor_rap_februari24 = ($penjualan_februari24!=0)?($laba_kotor_rap_februari24 / $penjualan_februari24)  * 100:0;
	$persentase_laba_kotor_rap_februari24_fix = round($persentase_laba_kotor_rap_februari24,2);

	//MARET24
	$penjualan_maret24 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_maret24_awal' and '$date_maret24_akhir'")
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
	
	$total_penjualan_maret24 = 0;
	$total_volume_penjualan_maret24 = 0;

	foreach ($penjualan_maret24 as $x){
		$total_penjualan_maret24 += $x['price'];
		$total_volume_penjualan_maret24 += $x['volume'];
	}

	$penjualan_limbah_maret24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_maret24_awal' and '$date_maret24_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_maret24 = 0;

	foreach ($penjualan_limbah_maret24 as $x){
		$total_penjualan_limbah_maret24 += $x['price'];
	}

	$penjualan_lain_lain_maret24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_maret24_awal' and '$date_maret24_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_maret24 = 0;

	foreach ($penjualan_lain_lain_maret24 as $x){
		$total_penjualan_lain_lain_maret24 += $x['price'];
	}

	$akumulasi_bahan_jadi_maret24 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_maret24')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_februari24_akhir' and '$date_maret24_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_maret24 = $akumulasi_bahan_jadi_maret24['harsat_maret24'];

	$penjualan_maret24 = $total_penjualan_maret24 + $total_penjualan_limbah_maret24 + $total_penjualan_lain_lain_maret24;
	$beban_pokok_penjualan_maret24 = $total_volume_penjualan_maret24 * $harsat_bahan_jadi_maret24;
	$laba_kotor_maret24 = $penjualan_maret24 - $beban_pokok_penjualan_maret24;

	
	$persentase_laba_kotor_maret24 = ($penjualan_maret24!=0)?($laba_kotor_maret24 / $penjualan_maret24) * 100:0;
	$persentase_laba_kotor_maret24_fix = round($persentase_laba_kotor_maret24,2);

	$laba_kotor_rap_maret24 = $penjualan_maret24 - ($total_volume_penjualan_maret24 * $total_ton_rap);
	$persentase_laba_kotor_rap_maret24 = ($penjualan_maret24!=0)?($laba_kotor_rap_maret24 / $penjualan_maret24)  * 100:0;
	$persentase_laba_kotor_rap_maret24_fix = round($persentase_laba_kotor_rap_maret24,2);

	//APRIL24
	$penjualan_april24 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_april24_awal' and '$date_april24_akhir'")
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
	
	$total_penjualan_april24 = 0;
	$total_volume_penjualan_april24 = 0;

	foreach ($penjualan_april24 as $x){
		$total_penjualan_april24 += $x['price'];
		$total_volume_penjualan_april24 += $x['volume'];
	}

	$penjualan_limbah_april24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_april24_awal' and '$date_april24_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_april24 = 0;

	foreach ($penjualan_limbah_april24 as $x){
		$total_penjualan_limbah_april24 += $x['price'];
	}

	$penjualan_lain_lain_april24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_april24_awal' and '$date_april24_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_april24 = 0;

	foreach ($penjualan_lain_lain_april24 as $x){
		$total_penjualan_lain_lain_april24 += $x['price'];
	}

	$akumulasi_bahan_jadi_april24 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_april24')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_maret24_akhir' and '$date_april24_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_april24 = $akumulasi_bahan_jadi_april24['harsat_april24'];

	$penjualan_april24 = $total_penjualan_april24 + $total_penjualan_limbah_april24 + $total_penjualan_lain_lain_april24;
	$beban_pokok_penjualan_april24 = $total_volume_penjualan_april24 * $harsat_bahan_jadi_april24;
	$laba_kotor_april24 = $penjualan_april24 - $beban_pokok_penjualan_april24;

	
	$persentase_laba_kotor_april24 = ($penjualan_april24!=0)?($laba_kotor_april24 / $penjualan_april24) * 100:0;
	$persentase_laba_kotor_april24_fix = round($persentase_laba_kotor_april24,2);

	$laba_kotor_rap_april24 = $penjualan_april24 - ($total_volume_penjualan_april24 * $total_ton_rap);
	$persentase_laba_kotor_rap_april24 = ($penjualan_april24!=0)?($laba_kotor_rap_april24 / $penjualan_april24)  * 100:0;
	$persentase_laba_kotor_rap_april24_fix = round($persentase_laba_kotor_rap_april24,2);

	//MEI24
	$penjualan_mei24 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_mei24_awal' and '$date_mei24_akhir'")
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
	
	$total_penjualan_mei24 = 0;
	$total_volume_penjualan_mei24 = 0;

	foreach ($penjualan_mei24 as $x){
		$total_penjualan_mei24 += $x['price'];
		$total_volume_penjualan_mei24 += $x['volume'];
	}

	$penjualan_limbah_mei24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_mei24_awal' and '$date_mei24_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_mei24 = 0;

	foreach ($penjualan_limbah_mei24 as $x){
		$total_penjualan_limbah_mei24 += $x['price'];
	}

	$penjualan_lain_lain_mei24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_mei24_awal' and '$date_mei24_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_mei24 = 0;

	foreach ($penjualan_lain_lain_mei24 as $x){
		$total_penjualan_lain_lain_mei24 += $x['price'];
	}

	$akumulasi_bahan_jadi_mei24 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_mei24')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_maret24_akhir' and '$date_mei24_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_mei24 = $akumulasi_bahan_jadi_mei24['harsat_mei24'];

	$penjualan_mei24 = $total_penjualan_mei24 + $total_penjualan_limbah_mei24 + $total_penjualan_lain_lain_mei24;
	$beban_pokok_penjualan_mei24 = $total_volume_penjualan_mei24 * $harsat_bahan_jadi_mei24;
	$laba_kotor_mei24 = $penjualan_mei24 - $beban_pokok_penjualan_mei24;

	
	$persentase_laba_kotor_mei24 = ($penjualan_mei24!=0)?($laba_kotor_mei24 / $penjualan_mei24) * 100:0;
	$persentase_laba_kotor_mei24_fix = round($persentase_laba_kotor_mei24,2);

	$laba_kotor_rap_mei24 = $penjualan_mei24 - ($total_volume_penjualan_mei24 * $total_ton_rap);
	$persentase_laba_kotor_rap_mei24 = ($penjualan_mei24!=0)?($laba_kotor_rap_mei24 / $penjualan_mei24)  * 100:0;
	$persentase_laba_kotor_rap_mei24_fix = round($persentase_laba_kotor_rap_mei24,2);

	//JUNI24
	$penjualan_juni24 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_juni24_awal' and '$date_juni24_akhir'")
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
	
	$total_penjualan_juni24 = 0;
	$total_volume_penjualan_juni24 = 0;

	foreach ($penjualan_juni24 as $x){
		$total_penjualan_juni24 += $x['price'];
		$total_volume_penjualan_juni24 += $x['volume'];
	}

	$penjualan_limbah_juni24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_juni24_awal' and '$date_juni24_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_juni24 = 0;

	foreach ($penjualan_limbah_juni24 as $x){
		$total_penjualan_limbah_juni24 += $x['price'];
	}

	$penjualan_lain_lain_juni24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_juni24_awal' and '$date_juni24_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_juni24 = 0;

	foreach ($penjualan_lain_lain_juni24 as $x){
		$total_penjualan_lain_lain_juni24 += $x['price'];
	}

	$akumulasi_bahan_jadi_juni24 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_juni24')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_maret24_akhir' and '$date_juni24_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_juni24 = $akumulasi_bahan_jadi_juni24['harsat_juni24'];

	$penjualan_juni24 = $total_penjualan_juni24 + $total_penjualan_limbah_juni24 + $total_penjualan_lain_lain_juni24;
	$beban_pokok_penjualan_juni24 = $total_volume_penjualan_juni24 * $harsat_bahan_jadi_juni24;
	$laba_kotor_juni24 = $penjualan_juni24 - $beban_pokok_penjualan_juni24;

	
	$persentase_laba_kotor_juni24 = ($penjualan_juni24!=0)?($laba_kotor_juni24 / $penjualan_juni24) * 100:0;
	$persentase_laba_kotor_juni24_fix = round($persentase_laba_kotor_juni24,2);

	$laba_kotor_rap_juni24 = $penjualan_juni24 - ($total_volume_penjualan_juni24 * $total_ton_rap);
	$persentase_laba_kotor_rap_juni24 = ($penjualan_juni24!=0)?($laba_kotor_rap_juni24 / $penjualan_juni24)  * 100:0;
	$persentase_laba_kotor_rap_juni24_fix = round($persentase_laba_kotor_rap_juni24,2);

	//JULI24
	$penjualan_juli24 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_juli24_awal' and '$date_juli24_akhir'")
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
	
	$total_penjualan_juli24 = 0;
	$total_volume_penjualan_juli24 = 0;

	foreach ($penjualan_juli24 as $x){
		$total_penjualan_juli24 += $x['price'];
		$total_volume_penjualan_juli24 += $x['volume'];
	}

	$penjualan_limbah_juli24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_juli24_awal' and '$date_juli24_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_juli24 = 0;

	foreach ($penjualan_limbah_juli24 as $x){
		$total_penjualan_limbah_juli24 += $x['price'];
	}

	$penjualan_lain_lain_juli24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_juli24_awal' and '$date_juli24_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_juli24 = 0;

	foreach ($penjualan_lain_lain_juli24 as $x){
		$total_penjualan_lain_lain_juli24 += $x['price'];
	}

	$akumulasi_bahan_jadi_juli24 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_juli24')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_maret24_akhir' and '$date_juli24_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_juli24 = $akumulasi_bahan_jadi_juli24['harsat_juli24'];

	$penjualan_juli24 = $total_penjualan_juli24 + $total_penjualan_limbah_juli24 + $total_penjualan_lain_lain_juli24;
	$beban_pokok_penjualan_juli24 = $total_volume_penjualan_juli24 * $harsat_bahan_jadi_juli24;
	$laba_kotor_juli24 = $penjualan_juli24 - $beban_pokok_penjualan_juli24;

	
	$persentase_laba_kotor_juli24 = ($penjualan_juli24!=0)?($laba_kotor_juli24 / $penjualan_juli24) * 100:0;
	$persentase_laba_kotor_juli24_fix = round($persentase_laba_kotor_juli24,2);

	$laba_kotor_rap_juli24 = $penjualan_juli24 - ($total_volume_penjualan_juli24 * $total_ton_rap);
	$persentase_laba_kotor_rap_juli24 = ($penjualan_juli24!=0)?($laba_kotor_rap_juli24 / $penjualan_juli24)  * 100:0;
	$persentase_laba_kotor_rap_juli24_fix = round($persentase_laba_kotor_rap_juli24,2);

	//AGUSTUS24
	$penjualan_agustus24 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_agustus24_awal' and '$date_agustus24_akhir'")
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
	
	$total_penjualan_agustus24 = 0;
	$total_volume_penjualan_agustus24 = 0;

	foreach ($penjualan_agustus24 as $x){
		$total_penjualan_agustus24 += $x['price'];
		$total_volume_penjualan_agustus24 += $x['volume'];
	}

	$penjualan_limbah_agustus24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_agustus24_awal' and '$date_agustus24_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_agustus24 = 0;

	foreach ($penjualan_limbah_agustus24 as $x){
		$total_penjualan_limbah_agustus24 += $x['price'];
	}

	$penjualan_lain_lain_agustus24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_agustus24_awal' and '$date_agustus24_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_agustus24 = 0;

	foreach ($penjualan_lain_lain_agustus24 as $x){
		$total_penjualan_lain_lain_agustus24 += $x['price'];
	}

	$akumulasi_bahan_jadi_agustus24 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_agustus24')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_maret24_akhir' and '$date_agustus24_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_agustus24 = $akumulasi_bahan_jadi_agustus24['harsat_agustus24'];

	$penjualan_agustus24 = $total_penjualan_agustus24 + $total_penjualan_limbah_agustus24 + $total_penjualan_lain_lain_agustus24;
	$beban_pokok_penjualan_agustus24 = $total_volume_penjualan_agustus24 * $harsat_bahan_jadi_agustus24;
	$laba_kotor_agustus24 = $penjualan_agustus24 - $beban_pokok_penjualan_agustus24;

	
	$persentase_laba_kotor_agustus24 = ($penjualan_agustus24!=0)?($laba_kotor_agustus24 / $penjualan_agustus24) * 100:0;
	$persentase_laba_kotor_agustus24_fix = round($persentase_laba_kotor_agustus24,2);

	$laba_kotor_rap_agustus24 = $penjualan_agustus24 - ($total_volume_penjualan_agustus24 * $total_ton_rap);
	$persentase_laba_kotor_rap_agustus24 = ($penjualan_agustus24!=0)?($laba_kotor_rap_agustus24 / $penjualan_agustus24)  * 100:0;
	$persentase_laba_kotor_rap_agustus24_fix = round($persentase_laba_kotor_rap_agustus24,2);

	//SEPTEMBER24
	$penjualan_september24 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_september24_awal' and '$date_september24_akhir'")
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
	
	$total_penjualan_september24 = 0;
	$total_volume_penjualan_september24 = 0;

	foreach ($penjualan_september24 as $x){
		$total_penjualan_september24 += $x['price'];
		$total_volume_penjualan_september24 += $x['volume'];
	}

	$penjualan_limbah_september24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_september24_awal' and '$date_september24_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_september24 = 0;

	foreach ($penjualan_limbah_september24 as $x){
		$total_penjualan_limbah_september24 += $x['price'];
	}

	$penjualan_lain_lain_september24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_september24_awal' and '$date_september24_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_september24 = 0;

	foreach ($penjualan_lain_lain_september24 as $x){
		$total_penjualan_lain_lain_september24 += $x['price'];
	}

	$akumulasi_bahan_jadi_september24 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_september24')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_maret24_akhir' and '$date_september24_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_september24 = $akumulasi_bahan_jadi_september24['harsat_september24'];

	$penjualan_september24 = $total_penjualan_september24 + $total_penjualan_limbah_september24 + $total_penjualan_lain_lain_september24;
	$beban_pokok_penjualan_september24 = $total_volume_penjualan_september24 * $harsat_bahan_jadi_september24;
	$laba_kotor_september24 = $penjualan_september24 - $beban_pokok_penjualan_september24;

	
	$persentase_laba_kotor_september24 = ($penjualan_september24!=0)?($laba_kotor_september24 / $penjualan_september24) * 100:0;
	$persentase_laba_kotor_september24_fix = round($persentase_laba_kotor_september24,2);

	$laba_kotor_rap_september24 = $penjualan_september24 - ($total_volume_penjualan_september24 * $total_ton_rap);
	$persentase_laba_kotor_rap_september24 = ($penjualan_september24!=0)?($laba_kotor_rap_september24 / $penjualan_september24)  * 100:0;
	$persentase_laba_kotor_rap_september24_fix = round($persentase_laba_kotor_rap_september24,2);

	//OKTOBER24
	$penjualan_oktober24 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_oktober24_awal' and '$date_oktober24_akhir'")
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
	
	$total_penjualan_oktober24 = 0;
	$total_volume_penjualan_oktober24 = 0;

	foreach ($penjualan_oktober24 as $x){
		$total_penjualan_oktober24 += $x['price'];
		$total_volume_penjualan_oktober24 += $x['volume'];
	}

	$penjualan_limbah_oktober24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_oktober24_awal' and '$date_oktober24_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_oktober24 = 0;

	foreach ($penjualan_limbah_oktober24 as $x){
		$total_penjualan_limbah_oktober24 += $x['price'];
	}

	$penjualan_lain_lain_oktober24 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_oktober24_awal' and '$date_oktober24_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_oktober24 = 0;

	foreach ($penjualan_lain_lain_oktober24 as $x){
		$total_penjualan_lain_lain_oktober24 += $x['price'];
	}

	$akumulasi_bahan_jadi_oktober24 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_oktober24')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_maret24_akhir' and '$date_oktober24_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_oktober24 = $akumulasi_bahan_jadi_oktober24['harsat_oktober24'];

	$penjualan_oktober24 = $total_penjualan_oktober24 + $total_penjualan_limbah_oktober24 + $total_penjualan_lain_lain_oktober24;
	$beban_pokok_penjualan_oktober24 = $total_volume_penjualan_oktober24 * $harsat_bahan_jadi_oktober24;
	$laba_kotor_oktober24 = $penjualan_oktober24 - $beban_pokok_penjualan_oktober24;

	
	$persentase_laba_kotor_oktober24 = ($penjualan_oktober24!=0)?($laba_kotor_oktober24 / $penjualan_oktober24) * 100:0;
	$persentase_laba_kotor_oktober24_fix = round($persentase_laba_kotor_oktober24,2);

	$laba_kotor_rap_oktober24 = $penjualan_oktober24 - ($total_volume_penjualan_oktober24 * $total_ton_rap);
	$persentase_laba_kotor_rap_oktober24 = ($penjualan_oktober24!=0)?($laba_kotor_rap_oktober24 / $penjualan_oktober24)  * 100:0;
	$persentase_laba_kotor_rap_oktober24_fix = round($persentase_laba_kotor_rap_oktober24,2);
	
?>

<?php

	//AGUSTUS23
	$rekapitulasi_produksi_harian_agustus23 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_agustus23 = round($rekapitulasi_produksi_harian_agustus23['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_agustus23['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_agustus23['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_agustus23['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_agustus23['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_agustus23['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_agustus23 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_agustus23,2);
	$nilai_rap_bahan_agustus23_fix = round($nilai_rap_bahan_agustus23 / 1000000,0);

	$date1_ago_agustus23 = date('2020-01-01');
	$date2_ago_agustus23 = date('Y-m-d', strtotime('-1 days', strtotime($date_agustus23_awal)));
	$date3_ago_agustus23 = date('Y-m-d', strtotime('-1 months', strtotime($date_agustus23_awal)));
	$tanggal_opening_balance_agustus23 = date('Y-m-d', strtotime('-1 days', strtotime($date_agustus23_awal)));

	$stock_opname_batu_boulder_ago_agustus23 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_agustus23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$harga_boulder_agustus23 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_agustus23' and '$date2_ago_agustus23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_agustus23 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_agustus23_awal' and '$date_agustus23_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();

	$harga_baru_agustus23 = ($harga_boulder_agustus23['nilai_boulder'] + $pembelian_boulder_agustus23['nilai']) / (round($stock_opname_batu_boulder_ago_agustus23['volume'],2) + round($pembelian_boulder_agustus23['volume'],2));
	$total_nilai_produksi_boulder_agustus23 = $total_rekapitulasi_produksi_harian_agustus23 * $harga_baru_agustus23;
	$total_nilai_produksi_boulder_agustus23_fix = round($total_nilai_produksi_boulder_agustus23 / 1000000,0);

	//SEPTEMBER23
	$rekapitulasi_produksi_harian_september23 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_september23_awal' and '$date_september23_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_september23 = round($rekapitulasi_produksi_harian_september23['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_september23['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_september23['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_september23['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_september23['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_september23['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_september23 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_september23,2);
	$nilai_rap_bahan_september23_fix = round($nilai_rap_bahan_september23 / 1000000,0);

	$date1_ago_september23 = date('2020-01-01');
	$date2_ago_september23 = date('Y-m-d', strtotime('-1 days', strtotime($date_september23_awal)));
	$date3_ago_september23 = date('Y-m-d', strtotime('-1 months', strtotime($date_september23_awal)));
	$tanggal_opening_balance_september23 = date('Y-m-d', strtotime('-1 days', strtotime($date_september23_awal)));

	$stock_opname_batu_boulder_ago_september23 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_september23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_september23 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_september23' and '$date2_ago_september23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_september23 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_september23_awal' and '$date_september23_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_september23 = ($harga_boulder_september23['nilai_boulder'] + $pembelian_boulder_september23['nilai']) / (round($stock_opname_batu_boulder_ago_september23['volume'],2) + round($pembelian_boulder_september23['volume'],2));
	$total_nilai_produksi_boulder_september23 = $total_rekapitulasi_produksi_harian_september23 * $harga_baru_september23;
	$total_nilai_produksi_boulder_september23_fix = round($total_nilai_produksi_boulder_september23 / 1000000,0);

	//OKTOBER23
	$rekapitulasi_produksi_harian_oktober23 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_oktober23 = round($rekapitulasi_produksi_harian_oktober23['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_oktober23['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_oktober23['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_oktober23['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_oktober23['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_oktober23['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_oktober23 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_oktober23,2);
	$nilai_rap_bahan_oktober23_fix = round($nilai_rap_bahan_oktober23 / 1000000,0);

	$date1_ago_oktober23 = date('2020-01-01');
	$date2_ago_oktober23 = date('Y-m-d', strtotime('-1 days', strtotime($date_oktober23_awal)));
	$date3_ago_oktober23 = date('Y-m-d', strtotime('-1 months', strtotime($date_oktober23_awal)));
	$tanggal_opening_balance_oktober23 = date('Y-m-d', strtotime('-1 days', strtotime($date_oktober23_awal)));

	$stock_opname_batu_boulder_ago_oktober23 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_oktober23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_oktober23 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_oktober23' and '$date2_ago_oktober23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_oktober23 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_oktober23_awal' and '$date_oktober23_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_oktober23 = ($harga_boulder_oktober23['nilai_boulder'] + $pembelian_boulder_oktober23['nilai']) / (round($stock_opname_batu_boulder_ago_oktober23['volume'],2) + round($pembelian_boulder_oktober23['volume'],2));
	$total_nilai_produksi_boulder_oktober23 = $total_rekapitulasi_produksi_harian_oktober23 * $harga_baru_oktober23;
	$total_nilai_produksi_boulder_oktober23_fix = round($total_nilai_produksi_boulder_oktober23 / 1000000,0);

	//NOVEMBER23
	$rekapitulasi_produksi_harian_november23 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_november23_awal' and '$date_november23_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_november23 = round($rekapitulasi_produksi_harian_november23['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_november23['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_november23['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_november23['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_november23['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_november23['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_november23 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_november23,2);
	$nilai_rap_bahan_november23_fix = round($nilai_rap_bahan_november23 / 1000000,0);

	$date1_ago_november23 = date('2020-01-01');
	$date2_ago_november23 = date('Y-m-d', strtotime('-1 days', strtotime($date_november23_awal)));
	$date3_ago_november23 = date('Y-m-d', strtotime('-1 months', strtotime($date_november23_awal)));
	$tanggal_opening_balance_november23 = date('Y-m-d', strtotime('-1 days', strtotime($date_november23_awal)));

	$stock_opname_batu_boulder_ago_november23 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_november23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_november23 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_november23' and '$date2_ago_november23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_november23 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_november23_awal' and '$date_november23_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_november23 = ($harga_boulder_november23['nilai_boulder'] + $pembelian_boulder_november23['nilai']) / (round($stock_opname_batu_boulder_ago_november23['volume'],2) + round($pembelian_boulder_november23['volume'],2));
	$total_nilai_produksi_boulder_november23 = $total_rekapitulasi_produksi_harian_november23 * $harga_baru_november23;
	$total_nilai_produksi_boulder_november23_fix = round($total_nilai_produksi_boulder_november23 / 1000000,0);

	//DESEMBER23
	$rekapitulasi_produksi_harian_desember23 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_desember23_awal' and '$date_desember23_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_desember23 = round($rekapitulasi_produksi_harian_desember23['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_desember23['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_desember23['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_desember23['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_desember23['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_desember23['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_desember23 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_desember23,2);
	$nilai_rap_bahan_desember23_fix = round($nilai_rap_bahan_desember23 / 1000000,0);

	$date1_ago_desember23 = date('2020-01-01');
	$date2_ago_desember23 = date('Y-m-d', strtotime('-1 days', strtotime($date_desember23_awal)));
	$date3_ago_desember23 = date('Y-m-d', strtotime('-1 months', strtotime($date_desember23_awal)));
	$tanggal_opening_balance_desember23 = date('Y-m-d', strtotime('-1 days', strtotime($date_desember23_awal)));

	$stock_opname_batu_boulder_ago_desember23 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_desember23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_desember23 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_desember23' and '$date2_ago_desember23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_desember23 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_desember23_awal' and '$date_desember23_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_desember23 = ($harga_boulder_desember23['nilai_boulder'] + $pembelian_boulder_desember23['nilai']) / (round($stock_opname_batu_boulder_ago_desember23['volume'],2) + round($pembelian_boulder_desember23['volume'],2));
	$total_nilai_produksi_boulder_desember23 = $total_rekapitulasi_produksi_harian_desember23 * $harga_baru_desember23;
	$total_nilai_produksi_boulder_desember23_fix = round($total_nilai_produksi_boulder_desember23 / 1000000,0);

	//JANUARI24
	$rekapitulasi_produksi_harian_januari24 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_januari24_awal' and '$date_januari24_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_januari24 = round($rekapitulasi_produksi_harian_januari24['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_januari24['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_januari24['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_januari24['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_januari24['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_januari24['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_januari24 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_januari24,2);
	$nilai_rap_bahan_januari24_fix = round($nilai_rap_bahan_januari24 / 1000000,0);

	$date1_ago_januari24 = date('2020-01-01');
	$date2_ago_januari24 = date('Y-m-d', strtotime('-1 days', strtotime($date_januari24_awal)));
	$date3_ago_januari24 = date('Y-m-d', strtotime('-1 months', strtotime($date_januari24_awal)));
	$tanggal_opening_balance_januari24 = date('Y-m-d', strtotime('-1 days', strtotime($date_januari24_awal)));

	$stock_opname_batu_boulder_ago_januari24 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_januari24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_januari24 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_januari24' and '$date2_ago_januari24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_januari24 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_januari24_awal' and '$date_januari24_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_januari24 = ($harga_boulder_januari24['nilai_boulder'] + $pembelian_boulder_januari24['nilai']) / (round($stock_opname_batu_boulder_ago_januari24['volume'],2) + round($pembelian_boulder_januari24['volume'],2));
	$total_nilai_produksi_boulder_januari24 = $total_rekapitulasi_produksi_harian_januari24 * $harga_baru_januari24;
	$total_nilai_produksi_boulder_januari24_fix = round($total_nilai_produksi_boulder_januari24 / 1000000,0);

	//FEBRUARI24
	$rekapitulasi_produksi_harian_februari24 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_februari24_awal' and '$date_februari24_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_februari24 = round($rekapitulasi_produksi_harian_februari24['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_februari24['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_februari24['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_februari24['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_februari24['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_februari24['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_februari24 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_februari24,2);
	$nilai_rap_bahan_februari24_fix = round($nilai_rap_bahan_februari24 / 1000000,0);

	$date1_ago_februari24 = date('2020-01-01');
	$date2_ago_februari24 = date('Y-m-d', strtotime('-1 days', strtotime($date_februari24_awal)));
	$date3_ago_februari24 = date('Y-m-d', strtotime('-1 months', strtotime($date_februari24_awal)));
	$tanggal_opening_balance_februari24 = date('Y-m-d', strtotime('-1 days', strtotime($date_februari24_awal)));

	$stock_opname_batu_boulder_ago_februari24 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_februari24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_februari24 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_februari24' and '$date2_ago_februari24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_februari24 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_februari24_awal' and '$date_februari24_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_februari24 = ($harga_boulder_februari24['nilai_boulder'] + $pembelian_boulder_februari24['nilai']) / (round($stock_opname_batu_boulder_ago_februari24['volume'],2) + round($pembelian_boulder_februari24['volume'],2));
	$total_nilai_produksi_boulder_februari24 = $total_rekapitulasi_produksi_harian_februari24 * $harga_baru_februari24;
	$total_nilai_produksi_boulder_februari24_fix = round($total_nilai_produksi_boulder_februari24 / 1000000,0);

	//MARET24
	$rekapitulasi_produksi_harian_maret24 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_maret24_awal' and '$date_maret24_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_maret24 = round($rekapitulasi_produksi_harian_maret24['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_maret24['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_maret24['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_maret24['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_maret24['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_maret24['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_maret24 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_maret24,2);
	$nilai_rap_bahan_maret24_fix = round($nilai_rap_bahan_maret24 / 1000000,0);

	$date1_ago_maret24 = date('2020-01-01');
	$date2_ago_maret24 = date('Y-m-d', strtotime('-1 days', strtotime($date_maret24_awal)));
	$date3_ago_maret24 = date('Y-m-d', strtotime('-1 months', strtotime($date_maret24_awal)));
	$tanggal_opening_balance_maret24 = date('Y-m-d', strtotime('-1 days', strtotime($date_maret24_awal)));

	$stock_opname_batu_boulder_ago_maret24 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_maret24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_maret24 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_maret24' and '$date2_ago_maret24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_maret24 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_maret24_awal' and '$date_maret24_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_maret24 = ($harga_boulder_maret24['nilai_boulder'] + $pembelian_boulder_maret24['nilai']) / (round($stock_opname_batu_boulder_ago_maret24['volume'],2) + round($pembelian_boulder_maret24['volume'],2));
	$total_nilai_produksi_boulder_maret24 = $total_rekapitulasi_produksi_harian_maret24 * $harga_baru_maret24;
	$total_nilai_produksi_boulder_maret24_fix = round($total_nilai_produksi_boulder_maret24 / 1000000,0);

	//APRIL24
	$rekapitulasi_produksi_harian_april24 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_april24_awal' and '$date_april24_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_april24 = round($rekapitulasi_produksi_harian_april24['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_april24['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_april24['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_april24['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_april24['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_april24['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_april24 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_april24,2);
	$nilai_rap_bahan_april24_fix = round($nilai_rap_bahan_april24 / 1000000,0);

	$date1_ago_april24 = date('2020-01-01');
	$date2_ago_april24 = date('Y-m-d', strtotime('-1 days', strtotime($date_april24_awal)));
	$date3_ago_april24 = date('Y-m-d', strtotime('-1 months', strtotime($date_april24_awal)));
	$tanggal_opening_balance_april24 = date('Y-m-d', strtotime('-1 days', strtotime($date_april24_awal)));

	$stock_opname_batu_boulder_ago_april24 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_april24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_april24 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_april24' and '$date2_ago_april24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_april24 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_april24_awal' and '$date_april24_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_april24 = ($harga_boulder_april24['nilai_boulder'] + $pembelian_boulder_april24['nilai']) / (round($stock_opname_batu_boulder_ago_april24['volume'],2) + round($pembelian_boulder_april24['volume'],2));
	$total_nilai_produksi_boulder_april24 = $total_rekapitulasi_produksi_harian_april24 * $harga_baru_april24;
	$total_nilai_produksi_boulder_april24_fix = round($total_nilai_produksi_boulder_april24 / 1000000,0);

	//MEI24
	$rekapitulasi_produksi_harian_mei24 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_mei24_awal' and '$date_mei24_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_mei24 = round($rekapitulasi_produksi_harian_mei24['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_mei24['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_mei24['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_mei24['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_mei24['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_mei24['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_mei24 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_mei24,2);
	$nilai_rap_bahan_mei24_fix = round($nilai_rap_bahan_mei24 / 1000000,0);

	$date1_ago_mei24 = date('2020-01-01');
	$date2_ago_mei24 = date('Y-m-d', strtotime('-1 days', strtotime($date_mei24_awal)));
	$date3_ago_mei24 = date('Y-m-d', strtotime('-1 months', strtotime($date_mei24_awal)));
	$tanggal_opening_balance_mei24 = date('Y-m-d', strtotime('-1 days', strtotime($date_mei24_awal)));

	$stock_opname_batu_boulder_ago_mei24 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_mei24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_mei24 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_mei24' and '$date2_ago_mei24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_mei24 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_mei24_awal' and '$date_mei24_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_mei24 = ($harga_boulder_mei24['nilai_boulder'] + $pembelian_boulder_mei24['nilai']) / (round($stock_opname_batu_boulder_ago_mei24['volume'],2) + round($pembelian_boulder_mei24['volume'],2));
	$total_nilai_produksi_boulder_mei24 = $total_rekapitulasi_produksi_harian_mei24 * $harga_baru_mei24;
	$total_nilai_produksi_boulder_mei24_fix = round($total_nilai_produksi_boulder_april24 / 1000000,0);

	//JUNI24
	$rekapitulasi_produksi_harian_juni24 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_juni24_awal' and '$date_juni24_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_juni24 = round($rekapitulasi_produksi_harian_juni24['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_juni24['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_juni24['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_juni24['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_juni24['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_juni24['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_juni24 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_juni24,2);
	$nilai_rap_bahan_juni24_fix = round($nilai_rap_bahan_juni24 / 1000000,0);

	$date1_ago_juni24 = date('2020-01-01');
	$date2_ago_juni24 = date('Y-m-d', strtotime('-1 days', strtotime($date_juni24_awal)));
	$date3_ago_juni24 = date('Y-m-d', strtotime('-1 months', strtotime($date_juni24_awal)));
	$tanggal_opening_balance_juni24 = date('Y-m-d', strtotime('-1 days', strtotime($date_juni24_awal)));

	$stock_opname_batu_boulder_ago_juni24 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_juni24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_juni24 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_juni24' and '$date2_ago_juni24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_juni24 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_juni24_awal' and '$date_juni24_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_juni24 = ($harga_boulder_juni24['nilai_boulder'] + $pembelian_boulder_juni24['nilai']) / (round($stock_opname_batu_boulder_ago_juni24['volume'],2) + round($pembelian_boulder_juni24['volume'],2));
	$total_nilai_produksi_boulder_juni24 = $total_rekapitulasi_produksi_harian_juni24 * $harga_baru_juni24;
	$total_nilai_produksi_boulder_juni24_fix = round($total_nilai_produksi_boulder_april24 / 1000000,0);

	//JULI24
	$rekapitulasi_produksi_harian_juli24 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_juli24_awal' and '$date_juli24_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_juli24 = round($rekapitulasi_produksi_harian_juli24['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_juli24['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_juli24['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_juli24['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_juli24['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_juli24['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_juli24 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_juli24,2);
	$nilai_rap_bahan_juli24_fix = round($nilai_rap_bahan_juli24 / 1000000,0);

	$date1_ago_juli24 = date('2020-01-01');
	$date2_ago_juli24 = date('Y-m-d', strtotime('-1 days', strtotime($date_juli24_awal)));
	$date3_ago_juli24 = date('Y-m-d', strtotime('-1 months', strtotime($date_juli24_awal)));
	$tanggal_opening_balance_juli24 = date('Y-m-d', strtotime('-1 days', strtotime($date_juli24_awal)));

	$stock_opname_batu_boulder_ago_juli24 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_juli24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_juli24 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_juli24' and '$date2_ago_juli24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_juli24 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_juli24_awal' and '$date_juli24_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_juli24 = ($harga_boulder_juli24['nilai_boulder'] + $pembelian_boulder_juli24['nilai']) / (round($stock_opname_batu_boulder_ago_juli24['volume'],2) + round($pembelian_boulder_juli24['volume'],2));
	$total_nilai_produksi_boulder_juli24 = $total_rekapitulasi_produksi_harian_juli24 * $harga_baru_juli24;
	$total_nilai_produksi_boulder_juli24_fix = round($total_nilai_produksi_boulder_april24 / 1000000,0);

	//AGUSTUS24
	$rekapitulasi_produksi_harian_agustus24 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_agustus24 = round($rekapitulasi_produksi_harian_agustus24['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_agustus24['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_agustus24['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_agustus24['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_agustus24['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_agustus24['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_agustus24 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_agustus24,2);
	$nilai_rap_bahan_agustus24_fix = round($nilai_rap_bahan_agustus24 / 1000000,0);

	$date1_ago_agustus24 = date('2020-01-01');
	$date2_ago_agustus24 = date('Y-m-d', strtotime('-1 days', strtotime($date_agustus24_awal)));
	$date3_ago_agustus24 = date('Y-m-d', strtotime('-1 months', strtotime($date_agustus24_awal)));
	$tanggal_opening_balance_agustus24 = date('Y-m-d', strtotime('-1 days', strtotime($date_agustus24_awal)));

	$stock_opname_batu_boulder_ago_agustus24 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_agustus24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_agustus24 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_agustus24' and '$date2_ago_agustus24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_agustus24 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_agustus24_awal' and '$date_agustus24_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_agustus24 = ($harga_boulder_agustus24['nilai_boulder'] + $pembelian_boulder_agustus24['nilai']) / (round($stock_opname_batu_boulder_ago_agustus24['volume'],2) + round($pembelian_boulder_agustus24['volume'],2));
	$total_nilai_produksi_boulder_agustus24 = $total_rekapitulasi_produksi_harian_agustus24 * $harga_baru_agustus24;
	$total_nilai_produksi_boulder_agustus24_fix = round($total_nilai_produksi_boulder_april24 / 1000000,0);
?>

<?php
	//AGUSTUS23
	$vol_rap_alat_agustus23 = $total_rekapitulasi_produksi_harian_agustus23;
	$nilai_rap_alat_agustus23 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_agustus23,2);
	$nilai_rap_alat_agustus23_fix = round($nilai_rap_alat_agustus23 / 1000000,0);

	$stone_crusher_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$stone_crusher_agustus23 = $stone_crusher_biaya_agustus23['total'] + $stone_crusher_jurnal_agustus23['total'];
	
	$whell_loader_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$whell_loader_agustus23 = $whell_loader_biaya_agustus23['total'] + $whell_loader_jurnal_agustus23['total'];
	
	$genset_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$genset_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$genset_agustus23 = $genset_biaya_agustus23['total'] + $genset_jurnal_agustus23['total'];
	
	$timbangan_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$timbangan_agustus23 = $timbangan_biaya_agustus23['total'] + $timbangan_biaya_jurnal_agustus23['total'];
	
	$tangki_solar_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$tangki_solar_agustus23 = $tangki_solar_biaya_agustus23['total'] + $tangki_solar_jurnal_agustus23['total'];		
	
	$total_biaya_peralatan_agustus23 = $stone_crusher_agustus23 + $whell_loader_agustus23 + $genset_agustus23 + $timbangan_agustus23 + $tangki_solar_agustus23;

	//Opening Balance
	$date1_ago_agustus23 = date('2020-01-01');
	$date2_ago_agustus23 = date('Y-m-d', strtotime('-1 days', strtotime($date_agustus23_awal)));
	$date3_ago_agustus23 = date('Y-m-d', strtotime('-1 months', strtotime($date_agustus23_awal)));
	$tanggal_opening_balance_agustus23 = date('Y-m-d', strtotime('-1 days', strtotime($date_agustus23_awal)));

	$stock_opname_bbm_ago_agustus23 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_agustus23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_agustus23 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_agustus23' and '$date2_ago_agustus23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_agustus23 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_agustus23_awal' and '$date_agustus23_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_agustus23 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_agustus23 = $pemakaian_bbm_agustus23['volume'];
	$nilai_pemakaian_bbm_agustus23 = $pemakaian_bbm_agustus23['nilai'];

	$nilai_bbm_non_produksi_agustus23 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_agustus23 = $nilai_bbm_non_produksi_agustus23['memo'];
	$nilai_bbm_non_produksi_agustus23 = $nilai_bbm_non_produksi_agustus23['total'];
	$total_nilai_produksi_solar_agustus23 = $nilai_pemakaian_bbm_agustus23 + $nilai_bbm_non_produksi_agustus23;

	$nilai_realisasi_alat_agustus23 = $total_biaya_peralatan_agustus23 + $total_nilai_produksi_solar_agustus23;
	$nilai_realisasi_alat_agustus23_fix = round($nilai_realisasi_alat_agustus23 / 1000000,0);

	//SEPTEMBER23
	$vol_rap_alat_september23 = $total_rekapitulasi_produksi_harian_september23;
	$nilai_rap_alat_september23 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_september23,2);
	$nilai_rap_alat_september23_fix = round($nilai_rap_alat_september23 / 1000000,0);

	$stone_crusher_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$stone_crusher_september23 = $stone_crusher_biaya_september23['total'] + $stone_crusher_jurnal_september23['total'];
	
	$whell_loader_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$whell_loader_september23 = $whell_loader_biaya_september23['total'] + $whell_loader_jurnal_september23['total'];
	
	$genset_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$genset_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$genset_september23 = $genset_biaya_september23['total'] + $genset_jurnal_september23['total'];
	
	$timbangan_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$timbangan_september23 = $timbangan_biaya_september23['total'] + $timbangan_biaya_jurnal_september23['total'];
	
	$tangki_solar_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$tangki_solar_september23 = $tangki_solar_biaya_september23['total'] + $tangki_solar_jurnal_september23['total'];		
	
	$total_biaya_peralatan_september23 = $stone_crusher_september23 + $whell_loader_september23 + $genset_september23 + $timbangan_september23 + $tangki_solar_september23;

	//Opening Balance
	$date1_ago_september23 = date('2020-01-01');
	$date2_ago_september23 = date('Y-m-d', strtotime('-1 days', strtotime($date_september23_awal)));
	$date3_ago_september23 = date('Y-m-d', strtotime('-1 months', strtotime($date_september23_awal)));
	$tanggal_opening_balance_september23 = date('Y-m-d', strtotime('-1 days', strtotime($date_september23_awal)));

	$stock_opname_bbm_ago_september23 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_september23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_september23 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_september23' and '$date2_ago_september23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_september23 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_september23_awal' and '$date_september23_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_september23 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_september23_awal' and '$date_september23_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_september23 = $pemakaian_bbm_september23['volume'];
	$nilai_pemakaian_bbm_september23 = $pemakaian_bbm_september23['nilai'];

	$nilai_bbm_non_produksi_september23 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_september23 = $nilai_bbm_non_produksi_september23['memo'];
	$nilai_bbm_non_produksi_september23 = $nilai_bbm_non_produksi_september23['total'];
	$total_nilai_produksi_solar_september23 = $nilai_pemakaian_bbm_september23 + $nilai_bbm_non_produksi_september23;

	$nilai_realisasi_alat_september23 = $total_biaya_peralatan_september23 + $total_nilai_produksi_solar_september23;
	$nilai_realisasi_alat_september23_fix = round($nilai_realisasi_alat_september23 / 1000000,0);

	//OKTOBER23
	$vol_rap_alat_oktober23 = $total_rekapitulasi_produksi_harian_oktober23;
	$nilai_rap_alat_oktober23 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_oktober23,2);
	$nilai_rap_alat_oktober23_fix = round($nilai_rap_alat_oktober23 / 1000000,0);

	$stone_crusher_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$stone_crusher_oktober23 = $stone_crusher_biaya_oktober23['total'] + $stone_crusher_jurnal_oktober23['total'];
	
	$whell_loader_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$whell_loader_oktober23 = $whell_loader_biaya_oktober23['total'] + $whell_loader_jurnal_oktober23['total'];
	
	$genset_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$genset_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$genset_oktober23 = $genset_biaya_oktober23['total'] + $genset_jurnal_oktober23['total'];
	
	$timbangan_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$timbangan_oktober23 = $timbangan_biaya_oktober23['total'] + $timbangan_biaya_jurnal_oktober23['total'];
	
	$tangki_solar_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$tangki_solar_oktober23 = $tangki_solar_biaya_oktober23['total'] + $tangki_solar_jurnal_oktober23['total'];		
	
	$total_biaya_peralatan_oktober23 = $stone_crusher_oktober23 + $whell_loader_oktober23 + $genset_oktober23 + $timbangan_oktober23 + $tangki_solar_oktober23;

	//Opening Balance
	$date1_ago_oktober23 = date('2020-01-01');
	$date2_ago_oktober23 = date('Y-m-d', strtotime('-1 days', strtotime($date_oktober23_awal)));
	$date3_ago_oktober23 = date('Y-m-d', strtotime('-1 months', strtotime($date_oktober23_awal)));
	$tanggal_opening_balance_oktober23 = date('Y-m-d', strtotime('-1 days', strtotime($date_oktober23_awal)));

	$stock_opname_bbm_ago_oktober23 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_oktober23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_oktober23 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_oktober23' and '$date2_ago_oktober23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_oktober23 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_oktober23_awal' and '$date_oktober23_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_oktober23 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_oktober23 = $pemakaian_bbm_oktober23['volume'];
	$nilai_pemakaian_bbm_oktober23 = $pemakaian_bbm_oktober23['nilai'];

	$nilai_bbm_non_produksi_oktober23 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_oktober23 = $nilai_bbm_non_produksi_oktober23['memo'];
	$nilai_bbm_non_produksi_oktober23 = $nilai_bbm_non_produksi_oktober23['total'];
	$total_nilai_produksi_solar_oktober23 = $nilai_pemakaian_bbm_oktober23 + $nilai_bbm_non_produksi_oktober23;

	$nilai_realisasi_alat_oktober23 = $total_biaya_peralatan_oktober23 + $total_nilai_produksi_solar_oktober23;
	$nilai_realisasi_alat_oktober23_fix = round($nilai_realisasi_alat_oktober23 / 1000000,0);

	//NOVEMBER23
	$vol_rap_alat_november23 = $total_rekapitulasi_produksi_harian_november23;
	$nilai_rap_alat_november23 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_november23,2);
	$nilai_rap_alat_november23_fix = round($nilai_rap_alat_november23 / 1000000,0);

	$stone_crusher_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$stone_crusher_november23 = $stone_crusher_biaya_november23['total'] + $stone_crusher_jurnal_november23['total'];
	
	$whell_loader_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$whell_loader_november23 = $whell_loader_biaya_november23['total'] + $whell_loader_jurnal_november23['total'];
	
	$genset_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$genset_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$genset_november23 = $genset_biaya_november23['total'] + $genset_jurnal_november23['total'];
	
	$timbangan_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$timbangan_november23 = $timbangan_biaya_november23['total'] + $timbangan_biaya_jurnal_november23['total'];
	
	$tangki_solar_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$tangki_solar_november23 = $tangki_solar_biaya_november23['total'] + $tangki_solar_jurnal_november23['total'];		
	
	$total_biaya_peralatan_november23 = $stone_crusher_november23 + $whell_loader_november23 + $genset_november23 + $timbangan_november23 + $tangki_solar_november23;

	//Opening Balance
	$date1_ago_november23 = date('2020-01-01');
	$date2_ago_november23 = date('Y-m-d', strtotime('-1 days', strtotime($date_november23_awal)));
	$date3_ago_november23 = date('Y-m-d', strtotime('-1 months', strtotime($date_november23_awal)));
	$tanggal_opening_balance_november23 = date('Y-m-d', strtotime('-1 days', strtotime($date_november23_awal)));

	$stock_opname_bbm_ago_november23 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_november23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_november23 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_november23' and '$date2_ago_november23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_november23 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_november23_awal' and '$date_november23_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_november23 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_november23_awal' and '$date_november23_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_november23 = $pemakaian_bbm_november23['volume'];
	$nilai_pemakaian_bbm_november23 = $pemakaian_bbm_november23['nilai'];

	$nilai_bbm_non_produksi_november23 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_november23 = $nilai_bbm_non_produksi_november23['memo'];
	$nilai_bbm_non_produksi_november23 = $nilai_bbm_non_produksi_november23['total'];
	$total_nilai_produksi_solar_november23 = $nilai_pemakaian_bbm_november23 + $nilai_bbm_non_produksi_november23;

	$nilai_realisasi_alat_november23 = $total_biaya_peralatan_november23 + $total_nilai_produksi_solar_november23;
	$nilai_realisasi_alat_november23_fix = round($nilai_realisasi_alat_november23 / 1000000,0);

	//DESEMBER23
	$vol_rap_alat_desember23 = $total_rekapitulasi_produksi_harian_desember23;
	$nilai_rap_alat_desember23 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_desember23,2);
	$nilai_rap_alat_desember23_fix = round($nilai_rap_alat_desember23 / 1000000,0);

	$stone_crusher_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$stone_crusher_desember23 = $stone_crusher_biaya_desember23['total'] + $stone_crusher_jurnal_desember23['total'];
	
	$whell_loader_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$whell_loader_desember23 = $whell_loader_biaya_desember23['total'] + $whell_loader_jurnal_desember23['total'];
	
	$genset_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$genset_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$genset_desember23 = $genset_biaya_desember23['total'] + $genset_jurnal_desember23['total'];
	
	$timbangan_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$timbangan_desember23 = $timbangan_biaya_desember23['total'] + $timbangan_biaya_jurnal_desember23['total'];
	
	$tangki_solar_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$tangki_solar_desember23 = $tangki_solar_biaya_desember23['total'] + $tangki_solar_jurnal_desember23['total'];		
	
	$total_biaya_peralatan_desember23 = $stone_crusher_desember23 + $whell_loader_desember23 + $genset_desember23 + $timbangan_desember23 + $tangki_solar_desember23;

	//Opening Balance
	$date1_ago_desember23 = date('2020-01-01');
	$date2_ago_desember23 = date('Y-m-d', strtotime('-1 days', strtotime($date_desember23_awal)));
	$date3_ago_desember23 = date('Y-m-d', strtotime('-1 months', strtotime($date_desember23_awal)));
	$tanggal_opening_balance_desember23 = date('Y-m-d', strtotime('-1 days', strtotime($date_desember23_awal)));

	$stock_opname_bbm_ago_desember23 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_desember23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_desember23 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_desember23' and '$date2_ago_desember23')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_desember23 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_desember23_awal' and '$date_desember23_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_desember23 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_desember23_awal' and '$date_desember23_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_desember23 = $pemakaian_bbm_desember23['volume'];
	$nilai_pemakaian_bbm_desember23 = $pemakaian_bbm_desember23['nilai'];

	$nilai_bbm_non_produksi_desember23 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_desember23 = $nilai_bbm_non_produksi_desember23['memo'];
	$nilai_bbm_non_produksi_desember23 = $nilai_bbm_non_produksi_desember23['total'];
	$total_nilai_produksi_solar_desember23 = $nilai_pemakaian_bbm_desember23 + $nilai_bbm_non_produksi_desember23;

	$nilai_realisasi_alat_desember23 = $total_biaya_peralatan_desember23 + $total_nilai_produksi_solar_desember23;
	$nilai_realisasi_alat_desember23_fix = round($nilai_realisasi_alat_desember23 / 1000000,0);

	//JANUARI24
	$vol_rap_alat_januari24 = $total_rekapitulasi_produksi_harian_januari24;
	$nilai_rap_alat_januari24 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_januari24,2);
	$nilai_rap_alat_januari24_fix = round($nilai_rap_alat_januari24 / 1000000,0);

	$stone_crusher_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$stone_crusher_januari24 = $stone_crusher_biaya_januari24['total'] + $stone_crusher_jurnal_januari24['total'];
	
	$whell_loader_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$whell_loader_januari24 = $whell_loader_biaya_januari24['total'] + $whell_loader_jurnal_januari24['total'];
	
	$genset_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$genset_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$genset_januari24 = $genset_biaya_januari24['total'] + $genset_jurnal_januari24['total'];
	
	$timbangan_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$timbangan_januari24 = $timbangan_biaya_januari24['total'] + $timbangan_biaya_jurnal_januari24['total'];
	
	$tangki_solar_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$tangki_solar_januari24 = $tangki_solar_biaya_januari24['total'] + $tangki_solar_jurnal_januari24['total'];		
	
	$total_biaya_peralatan_januari24 = $stone_crusher_januari24 + $whell_loader_januari24 + $genset_januari24 + $timbangan_januari24 + $tangki_solar_januari24;

	//Opening Balance
	$date1_ago_januari24 = date('2020-01-01');
	$date2_ago_januari24 = date('Y-m-d', strtotime('-1 days', strtotime($date_januari24_awal)));
	$date3_ago_januari24 = date('Y-m-d', strtotime('-1 months', strtotime($date_januari24_awal)));
	$tanggal_opening_balance_januari24 = date('Y-m-d', strtotime('-1 days', strtotime($date_januari24_awal)));

	$stock_opname_bbm_ago_januari24 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_januari24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_januari24 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_januari24' and '$date2_ago_januari24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_januari24 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_januari24_awal' and '$date_januari24_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_januari24 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_januari24_awal' and '$date_januari24_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_januari24 = $pemakaian_bbm_januari24['volume'];
	$nilai_pemakaian_bbm_januari24 = $pemakaian_bbm_januari24['nilai'];

	$nilai_bbm_non_produksi_januari24 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_januari24 = $nilai_bbm_non_produksi_januari24['memo'];
	$nilai_bbm_non_produksi_januari24 = $nilai_bbm_non_produksi_januari24['total'];
	$total_nilai_produksi_solar_januari24 = $nilai_pemakaian_bbm_januari24 + $nilai_bbm_non_produksi_januari24;

	$nilai_realisasi_alat_januari24 = $total_biaya_peralatan_januari24 + $total_nilai_produksi_solar_januari24;
	$nilai_realisasi_alat_januari24_fix = round($nilai_realisasi_alat_januari24 / 1000000,0);

	//FEBRUARI24
	$vol_rap_alat_februari24 = $total_rekapitulasi_produksi_harian_februari24;
	$nilai_rap_alat_februari24 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_februari24,2);
	$nilai_rap_alat_februari24_fix = round($nilai_rap_alat_februari24 / 1000000,0);

	$stone_crusher_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$stone_crusher_februari24 = $stone_crusher_biaya_februari24['total'] + $stone_crusher_jurnal_februari24['total'];
	
	$whell_loader_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$whell_loader_februari24 = $whell_loader_biaya_februari24['total'] + $whell_loader_jurnal_februari24['total'];
	
	$genset_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$genset_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$genset_februari24 = $genset_biaya_februari24['total'] + $genset_jurnal_februari24['total'];
	
	$timbangan_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$timbangan_februari24 = $timbangan_biaya_februari24['total'] + $timbangan_biaya_jurnal_februari24['total'];
	
	$tangki_solar_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$tangki_solar_februari24 = $tangki_solar_biaya_februari24['total'] + $tangki_solar_jurnal_februari24['total'];		
	
	$total_biaya_peralatan_februari24 = $stone_crusher_februari24 + $whell_loader_februari24 + $genset_februari24 + $timbangan_februari24 + $tangki_solar_februari24;

	//Opening Balance
	$date1_ago_februari24 = date('2020-01-01');
	$date2_ago_februari24 = date('Y-m-d', strtotime('-1 days', strtotime($date_februari24_awal)));
	$date3_ago_februari24 = date('Y-m-d', strtotime('-1 months', strtotime($date_februari24_awal)));
	$tanggal_opening_balance_februari24 = date('Y-m-d', strtotime('-1 days', strtotime($date_februari24_awal)));

	$stock_opname_bbm_ago_februari24 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_februari24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_februari24 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_februari24' and '$date2_ago_februari24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_februari24 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_februari24_awal' and '$date_februari24_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_februari24 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_februari24_awal' and '$date_februari24_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_februari24 = $pemakaian_bbm_februari24['volume'];
	$nilai_pemakaian_bbm_februari24 = $pemakaian_bbm_februari24['nilai'];

	$nilai_bbm_non_produksi_februari24 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_februari24 = $nilai_bbm_non_produksi_februari24['memo'];
	$nilai_bbm_non_produksi_februari24 = $nilai_bbm_non_produksi_februari24['total'];
	$total_nilai_produksi_solar_februari24 = $nilai_pemakaian_bbm_februari24 + $nilai_bbm_non_produksi_februari24;

	$nilai_realisasi_alat_februari24 = $total_biaya_peralatan_februari24 + $total_nilai_produksi_solar_februari24;
	$nilai_realisasi_alat_februari24_fix = round($nilai_realisasi_alat_februari24 / 1000000,0);

	//MARET24
	$vol_rap_alat_maret24 = $total_rekapitulasi_produksi_harian_maret24;
	$nilai_rap_alat_maret24 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_maret24,2);
	$nilai_rap_alat_maret24_fix = round($nilai_rap_alat_maret24 / 1000000,0);

	$stone_crusher_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$stone_crusher_maret24 = $stone_crusher_biaya_maret24['total'] + $stone_crusher_jurnal_maret24['total'];
	
	$whell_loader_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$whell_loader_maret24 = $whell_loader_biaya_maret24['total'] + $whell_loader_jurnal_maret24['total'];
	
	$genset_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$genset_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$genset_maret24 = $genset_biaya_maret24['total'] + $genset_jurnal_maret24['total'];
	
	$timbangan_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$timbangan_maret24 = $timbangan_biaya_maret24['total'] + $timbangan_biaya_jurnal_maret24['total'];
	
	$tangki_solar_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$tangki_solar_maret24 = $tangki_solar_biaya_maret24['total'] + $tangki_solar_jurnal_maret24['total'];		
	
	$total_biaya_peralatan_maret24 = $stone_crusher_maret24 + $whell_loader_maret24 + $genset_maret24 + $timbangan_maret24 + $tangki_solar_maret24;

	//Opening Balance
	$date1_ago_maret24 = date('2020-01-01');
	$date2_ago_maret24 = date('Y-m-d', strtotime('-1 days', strtotime($date_maret24_awal)));
	$date3_ago_maret24 = date('Y-m-d', strtotime('-1 months', strtotime($date_maret24_awal)));
	$tanggal_opening_balance_maret24 = date('Y-m-d', strtotime('-1 days', strtotime($date_maret24_awal)));

	$stock_opname_bbm_ago_maret24 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_maret24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_maret24 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_maret24' and '$date2_ago_maret24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_maret24 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_maret24_awal' and '$date_maret24_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_maret24 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_maret24_awal' and '$date_maret24_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_maret24 = $pemakaian_bbm_maret24['volume'];
	$nilai_pemakaian_bbm_maret24 = $pemakaian_bbm_maret24['nilai'];

	$nilai_bbm_non_produksi_maret24 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_maret24 = $nilai_bbm_non_produksi_maret24['memo'];
	$nilai_bbm_non_produksi_maret24 = $nilai_bbm_non_produksi_maret24['total'];
	$total_nilai_produksi_solar_maret24 = $nilai_pemakaian_bbm_maret24 + $nilai_bbm_non_produksi_maret24;

	$nilai_realisasi_alat_maret24 = $total_biaya_peralatan_maret24 + $total_nilai_produksi_solar_maret24;
	$nilai_realisasi_alat_maret24_fix = round($nilai_realisasi_alat_maret24 / 1000000,0);

	//APRIL24
	$vol_rap_alat_april24 = $total_rekapitulasi_produksi_harian_april24;
	$nilai_rap_alat_april24 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_april24,2);
	$nilai_rap_alat_april24_fix = round($nilai_rap_alat_april24 / 1000000,0);

	$stone_crusher_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$stone_crusher_april24 = $stone_crusher_biaya_april24['total'] + $stone_crusher_jurnal_april24['total'];
	
	$whell_loader_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$whell_loader_april24 = $whell_loader_biaya_april24['total'] + $whell_loader_jurnal_april24['total'];
	
	$genset_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$genset_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$genset_april24 = $genset_biaya_april24['total'] + $genset_jurnal_april24['total'];
	
	$timbangan_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$timbangan_april24 = $timbangan_biaya_april24['total'] + $timbangan_biaya_jurnal_april24['total'];
	
	$tangki_solar_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$tangki_solar_april24 = $tangki_solar_biaya_april24['total'] + $tangki_solar_jurnal_april24['total'];		
	
	$total_biaya_peralatan_april24 = $stone_crusher_april24 + $whell_loader_april24 + $genset_april24 + $timbangan_april24 + $tangki_solar_april24;

	//Opening Balance
	$date1_ago_april24 = date('2020-01-01');
	$date2_ago_april24 = date('Y-m-d', strtotime('-1 days', strtotime($date_april24_awal)));
	$date3_ago_april24 = date('Y-m-d', strtotime('-1 months', strtotime($date_april24_awal)));
	$tanggal_opening_balance_april24 = date('Y-m-d', strtotime('-1 days', strtotime($date_april24_awal)));

	$stock_opname_bbm_ago_april24 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_april24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_april24 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_april24' and '$date2_ago_april24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_april24 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_april24_awal' and '$date_april24_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_april24 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_april24_awal' and '$date_april24_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_april24 = $pemakaian_bbm_april24['volume'];
	$nilai_pemakaian_bbm_april24 = $pemakaian_bbm_april24['nilai'];

	$nilai_bbm_non_produksi_april24 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_april24 = $nilai_bbm_non_produksi_april24['memo'];
	$nilai_bbm_non_produksi_april24 = $nilai_bbm_non_produksi_april24['total'];
	$total_nilai_produksi_solar_april24 = $nilai_pemakaian_bbm_april24 + $nilai_bbm_non_produksi_april24;

	$nilai_realisasi_alat_april24 = $total_biaya_peralatan_april24 + $total_nilai_produksi_solar_april24;
	$nilai_realisasi_alat_april24_fix = round($nilai_realisasi_alat_april24 / 1000000,0);

	//MEI24
	$vol_rap_alat_mei24 = $total_rekapitulasi_produksi_harian_mei24;
	$nilai_rap_alat_mei24 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_mei24,2);
	$nilai_rap_alat_mei24_fix = round($nilai_rap_alat_mei24 / 1000000,0);

	$stone_crusher_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$stone_crusher_mei24 = $stone_crusher_biaya_mei24['total'] + $stone_crusher_jurnal_mei24['total'];
	
	$whell_loader_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$whell_loader_mei24 = $whell_loader_biaya_mei24['total'] + $whell_loader_jurnal_mei24['total'];
	
	$genset_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$genset_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$genset_mei24 = $genset_biaya_mei24['total'] + $genset_jurnal_mei24['total'];
	
	$timbangan_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$timbangan_mei24 = $timbangan_biaya_mei24['total'] + $timbangan_biaya_jurnal_mei24['total'];
	
	$tangki_solar_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$tangki_solar_mei24 = $tangki_solar_biaya_mei24['total'] + $tangki_solar_jurnal_mei24['total'];		
	
	$total_biaya_peralatan_mei24 = $stone_crusher_mei24 + $whell_loader_mei24 + $genset_mei24 + $timbangan_mei24 + $tangki_solar_mei24;

	//Opening Balance
	$date1_ago_mei24 = date('2020-01-01');
	$date2_ago_mei24 = date('Y-m-d', strtotime('-1 days', strtotime($date_mei24_awal)));
	$date3_ago_mei24 = date('Y-m-d', strtotime('-1 months', strtotime($date_mei24_awal)));
	$tanggal_opening_balance_mei24 = date('Y-m-d', strtotime('-1 days', strtotime($date_mei24_awal)));

	$stock_opname_bbm_ago_mei24 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_mei24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_mei24 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_mei24' and '$date2_ago_mei24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_mei24 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_mei24_awal' and '$date_mei24_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_mei24 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_mei24_awal' and '$date_mei24_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_mei24 = $pemakaian_bbm_mei24['volume'];
	$nilai_pemakaian_bbm_mei24 = $pemakaian_bbm_mei24['nilai'];

	$nilai_bbm_non_produksi_mei24 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_mei24 = $nilai_bbm_non_produksi_mei24['memo'];
	$nilai_bbm_non_produksi_mei24 = $nilai_bbm_non_produksi_mei24['total'];
	$total_nilai_produksi_solar_mei24 = $nilai_pemakaian_bbm_mei24 + $nilai_bbm_non_produksi_mei24;

	$nilai_realisasi_alat_mei24 = $total_biaya_peralatan_mei24 + $total_nilai_produksi_solar_mei24;
	$nilai_realisasi_alat_mei24_fix = round($nilai_realisasi_alat_mei24 / 1000000,0);

	//JUNI24
	$vol_rap_alat_juni24 = $total_rekapitulasi_produksi_harian_juni24;
	$nilai_rap_alat_juni24 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_juni24,2);
	$nilai_rap_alat_juni24_fix = round($nilai_rap_alat_juni24 / 1000000,0);

	$stone_crusher_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$stone_crusher_juni24 = $stone_crusher_biaya_juni24['total'] + $stone_crusher_jurnal_juni24['total'];
	
	$whell_loader_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$whell_loader_juni24 = $whell_loader_biaya_juni24['total'] + $whell_loader_jurnal_juni24['total'];
	
	$genset_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$genset_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$genset_juni24 = $genset_biaya_juni24['total'] + $genset_jurnal_juni24['total'];
	
	$timbangan_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$timbangan_juni24 = $timbangan_biaya_juni24['total'] + $timbangan_biaya_jurnal_juni24['total'];
	
	$tangki_solar_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$tangki_solar_juni24 = $tangki_solar_biaya_juni24['total'] + $tangki_solar_jurnal_juni24['total'];		
	
	$total_biaya_peralatan_juni24 = $stone_crusher_juni24 + $whell_loader_juni24 + $genset_juni24 + $timbangan_juni24 + $tangki_solar_juni24;

	//Opening Balance
	$date1_ago_juni24 = date('2020-01-01');
	$date2_ago_juni24 = date('Y-m-d', strtotime('-1 days', strtotime($date_juni24_awal)));
	$date3_ago_juni24 = date('Y-m-d', strtotime('-1 months', strtotime($date_juni24_awal)));
	$tanggal_opening_balance_juni24 = date('Y-m-d', strtotime('-1 days', strtotime($date_juni24_awal)));

	$stock_opname_bbm_ago_juni24 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_juni24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_juni24 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_juni24' and '$date2_ago_juni24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_juni24 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_juni24_awal' and '$date_juni24_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_juni24 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_juni24_awal' and '$date_juni24_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_juni24 = $pemakaian_bbm_juni24['volume'];
	$nilai_pemakaian_bbm_juni24 = $pemakaian_bbm_juni24['nilai'];

	$nilai_bbm_non_produksi_juni24 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_juni24 = $nilai_bbm_non_produksi_juni24['memo'];
	$nilai_bbm_non_produksi_juni24 = $nilai_bbm_non_produksi_juni24['total'];
	$total_nilai_produksi_solar_juni24 = $nilai_pemakaian_bbm_juni24 + $nilai_bbm_non_produksi_juni24;

	$nilai_realisasi_alat_juni24 = $total_biaya_peralatan_juni24 + $total_nilai_produksi_solar_juni24;
	$nilai_realisasi_alat_juni24_fix = round($nilai_realisasi_alat_juni24 / 1000000,0);

	//JULI24
	$vol_rap_alat_juli24 = $total_rekapitulasi_produksi_harian_juli24;
	$nilai_rap_alat_juli24 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_juli24,2);
	$nilai_rap_alat_juli24_fix = round($nilai_rap_alat_juli24 / 1000000,0);

	$stone_crusher_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$stone_crusher_juli24 = $stone_crusher_biaya_juli24['total'] + $stone_crusher_jurnal_juli24['total'];
	
	$whell_loader_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$whell_loader_juli24 = $whell_loader_biaya_juli24['total'] + $whell_loader_jurnal_juli24['total'];
	
	$genset_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$genset_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$genset_juli24 = $genset_biaya_juli24['total'] + $genset_jurnal_juli24['total'];
	
	$timbangan_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$timbangan_juli24 = $timbangan_biaya_juli24['total'] + $timbangan_biaya_jurnal_juli24['total'];
	
	$tangki_solar_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$tangki_solar_juli24 = $tangki_solar_biaya_juli24['total'] + $tangki_solar_jurnal_juli24['total'];		
	
	$total_biaya_peralatan_juli24 = $stone_crusher_juli24 + $whell_loader_juli24 + $genset_juli24 + $timbangan_juli24 + $tangki_solar_juli24;

	//Opening Balance
	$date1_ago_juli24 = date('2020-01-01');
	$date2_ago_juli24 = date('Y-m-d', strtotime('-1 days', strtotime($date_juli24_awal)));
	$date3_ago_juli24 = date('Y-m-d', strtotime('-1 months', strtotime($date_juli24_awal)));
	$tanggal_opening_balance_juli24 = date('Y-m-d', strtotime('-1 days', strtotime($date_juli24_awal)));

	$stock_opname_bbm_ago_juli24 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_juli24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_juli24 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_juli24' and '$date2_ago_juli24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_juli24 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_juli24_awal' and '$date_juli24_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_juli24 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_juli24_awal' and '$date_juli24_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_juli24 = $pemakaian_bbm_juli24['volume'];
	$nilai_pemakaian_bbm_juli24 = $pemakaian_bbm_juli24['nilai'];

	$nilai_bbm_non_produksi_juli24 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_juli24 = $nilai_bbm_non_produksi_juli24['memo'];
	$nilai_bbm_non_produksi_juli24 = $nilai_bbm_non_produksi_juli24['total'];
	$total_nilai_produksi_solar_juli24 = $nilai_pemakaian_bbm_juli24 + $nilai_bbm_non_produksi_juli24;

	$nilai_realisasi_alat_juli24 = $total_biaya_peralatan_juli24 + $total_nilai_produksi_solar_juli24;
	$nilai_realisasi_alat_juli24_fix = round($nilai_realisasi_alat_juli24 / 1000000,0);

	//AGUSTUS24
	$vol_rap_alat_agustus24 = $total_rekapitulasi_produksi_harian_agustus24;
	$nilai_rap_alat_agustus24 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_agustus24,2);
	$nilai_rap_alat_agustus24_fix = round($nilai_rap_alat_agustus24 / 1000000,0);

	$stone_crusher_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$stone_crusher_agustus24 = $stone_crusher_biaya_agustus24['total'] + $stone_crusher_jurnal_agustus24['total'];
	
	$whell_loader_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$whell_loader_agustus24 = $whell_loader_biaya_agustus24['total'] + $whell_loader_jurnal_agustus24['total'];
	
	$genset_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$genset_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$genset_agustus24 = $genset_biaya_agustus24['total'] + $genset_jurnal_agustus24['total'];
	
	$timbangan_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$timbangan_agustus24 = $timbangan_biaya_agustus24['total'] + $timbangan_biaya_jurnal_agustus24['total'];
	
	$tangki_solar_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$tangki_solar_agustus24 = $tangki_solar_biaya_agustus24['total'] + $tangki_solar_jurnal_agustus24['total'];		
	
	$total_biaya_peralatan_agustus24 = $stone_crusher_agustus24 + $whell_loader_agustus24 + $genset_agustus24 + $timbangan_agustus24 + $tangki_solar_agustus24;

	//Opening Balance
	$date1_ago_agustus24 = date('2020-01-01');
	$date2_ago_agustus24 = date('Y-m-d', strtotime('-1 days', strtotime($date_agustus24_awal)));
	$date3_ago_agustus24 = date('Y-m-d', strtotime('-1 months', strtotime($date_agustus24_awal)));
	$tanggal_opening_balance_agustus24 = date('Y-m-d', strtotime('-1 days', strtotime($date_agustus24_awal)));

	$stock_opname_bbm_ago_agustus24 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_agustus24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_agustus24 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_agustus24' and '$date2_ago_agustus24')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_agustus24 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_agustus24_awal' and '$date_agustus24_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_agustus24 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_agustus24 = $pemakaian_bbm_agustus24['volume'];
	$nilai_pemakaian_bbm_agustus24 = $pemakaian_bbm_agustus24['nilai'];

	$nilai_bbm_non_produksi_agustus24 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_agustus24 = $nilai_bbm_non_produksi_agustus24['memo'];
	$nilai_bbm_non_produksi_agustus24 = $nilai_bbm_non_produksi_agustus24['total'];
	$total_nilai_produksi_solar_agustus24 = $nilai_pemakaian_bbm_agustus24 + $nilai_bbm_non_produksi_agustus24;

	$nilai_realisasi_alat_agustus24 = $total_biaya_peralatan_agustus24 + $total_nilai_produksi_solar_agustus24;
	$nilai_realisasi_alat_agustus24_fix = round($nilai_realisasi_alat_agustus24 / 1000000,0);
	
?>

<?php
	//AGUSTUS23
	$nilai_rap_overhead_agustus23 = $overhead_ton * round($total_rekapitulasi_produksi_harian_agustus23,2);
	$nilai_rap_overhead_agustus23_fix = round($nilai_rap_overhead_agustus23 / 1000000,0);

	$konsumsi_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$konsumsi_agustus23 = $konsumsi_biaya_agustus23['total'] + $konsumsi_jurnal_agustus23['total'];

	$gaji_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$gaji_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$gaji_agustus23 = $gaji_biaya_agustus23['total'] + $gaji_jurnal_agustus23['total'];

	$upah_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$upah_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$upah_agustus23 = $upah_biaya_agustus23['total'] + $upah_jurnal_agustus23['total'];

	$pengujian_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$pengujian_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$pengujian_agustus23 = $pengujian_biaya_agustus23['total'] + $pengujian_jurnal_agustus23['total'];

	$perbaikan_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$perbaikan_agustus23 = $perbaikan_biaya_agustus23['total'] + $perbaikan_jurnal_agustus23['total'];

	$akomodasi_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$akomodasi_agustus23 = $akomodasi_biaya_agustus23['total'] + $akomodasi_jurnal_agustus23['total'];

	$listrik_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$listrik_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$listrik_agustus23 = $listrik_biaya_agustus23['total'] + $listrik_jurnal_agustus23['total'];

	$thr_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$thr_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$thr_agustus23 = $thr_biaya_agustus23['total'] + $thr_jurnal_agustus23['total'];

	$bensin_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$bensin_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$bensin_agustus23 = $bensin_biaya_agustus23['total'] + $bensin_jurnal_agustus23['total'];

	$dinas_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$dinas_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$dinas_agustus23 = $dinas_biaya_agustus23['total'] + $dinas_jurnal_agustus23['total'];

	$komunikasi_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$komunikasi_agustus23 = $komunikasi_biaya_agustus23['total'] + $komunikasi_jurnal_agustus23['total'];

	$pakaian_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$pakaian_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$pakaian_agustus23 = $pakaian_biaya_agustus23['total'] + $pakaian_jurnal_agustus23['total'];

	$tulis_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$tulis_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$tulis_agustus23 = $tulis_biaya_agustus23['total'] + $tulis_jurnal_agustus23['total'];

	$keamanan_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$keamanan_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$keamanan_agustus23 = $keamanan_biaya_agustus23['total'] + $keamanan_jurnal_agustus23['total'];

	$perlengkapan_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$perlengkapan_agustus23 = $perlengkapan_biaya_agustus23['total'] + $perlengkapan_jurnal_agustus23['total'];

	$beban_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$beban_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$beban_agustus23 = $beban_biaya_agustus23['total'] + $beban_jurnal_agustus23['total'];

	$adm_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$adm_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$adm_agustus23 = $adm_biaya_agustus23['total'] + $adm_jurnal_agustus23['total'];

	$lain_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$lain_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$lain_agustus23 = $lain_biaya_agustus23['total'] + $lain_jurnal_agustus23['total'];

	$sewa_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$sewa_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$sewa_agustus23 = $sewa_biaya_agustus23['total'] + $sewa_jurnal_agustus23['total'];

	$bpjs_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$bpjs_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$bpjs_agustus23 = $bpjs_biaya_agustus23['total'] + $bpjs_jurnal_agustus23['total'];

	$penyusutan_kantor_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$penyusutan_kantor_agustus23 = $penyusutan_kantor_biaya_agustus23['total'] + $penyusutan_kantor_jurnal_agustus23['total'];

	$penyusutan_kendaraan_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_agustus23 = $penyusutan_kendaraan_biaya_agustus23['total'] + $penyusutan_kendaraan_jurnal_agustus23['total'];

	$iuran_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$iuran_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$iuran_agustus23 = $iuran_biaya_agustus23['total'] + $iuran_jurnal_agustus23['total'];

	$kendaraan_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$kendaraan_agustus23 = $kendaraan_biaya_agustus23['total'] + $kendaraan_jurnal_agustus23['total'];

	$pajak_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$pajak_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$pajak_agustus23 = $pajak_biaya_agustus23['total'] + $pajak_jurnal_agustus23['total'];

	$solar_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$solar_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$solar_agustus23 = 0;

	$donasi_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$donasi_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$donasi_agustus23 = $donasi_biaya_agustus23['total'] + $donasi_jurnal_agustus23['total'];

	$legal_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$legal_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$legal_agustus23 = $legal_biaya_agustus23['total'] + $legal_jurnal_agustus23['total'];

	$pengobatan_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$pengobatan_agustus23 = $pengobatan_biaya_agustus23['total'] + $pengobatan_jurnal_agustus23['total'];

	$lembur_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$lembur_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$lembur_agustus23 = $lembur_biaya_agustus23['total'] + $lembur_jurnal_agustus23['total'];

	$pelatihan_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$pelatihan_agustus23 = $pelatihan_biaya_agustus23_agustus23['total'] + $pelatihan_jurnal_agustus23['total'];

	$supplies_biaya_agustus23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();

	$supplies_jurnal_agustus23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus23_awal' and '$date_agustus23_akhir')")
	->get()->row_array();
	$supplies_agustus23 = $supplies_biaya_agustus23['total'] + $supplies_jurnal_agustus23['total'];

	$total_operasional_agustus23 = $konsumsi_agustus23 + $gaji_agustus23 + $upah_agustus23 + $pengujian_agustus23 + $perbaikan_agustus23 + $akomodasi_agustus23 + $listrik_agustus23 + $thr_agustus23 + 
	$bensin_agustus23 + $dinas_agustus23 + $komunikasi_agustus23 + $pakaian_agustus23 + $tulis_agustus23 + $keamanan_agustus23 + $perlengkapan_agustus23 + $beban_agustus23 + $adm_agustus23 + 
	$lain_agustus23 + $sewa_agustus23 + $bpjs_agustus23 + $penyusutan_kantor_agustus23 + $penyusutan_kendaraan_agustus23 + $iuran_agustus23 + $kendaraan_agustus23 + $pajak_agustus23 + $solar_agustus23 + 
	$donasi_agustus23 + $legal_agustus23 + $pengobatan_agustus23 + $lembur_agustus23 + $pelatihan_agustus23 + $supplies_agustus23;
	$nilai_realisasi_overhead_agustus23_fix = round($total_operasional_agustus23 / 1000000,0);

	//SEPTEMBER23
	$nilai_rap_overhead_september23 = $overhead_ton * round($total_rekapitulasi_produksi_harian_september23,2);
	$nilai_rap_overhead_september23_fix = round($nilai_rap_overhead_september23 / 1000000,0);

	$konsumsi_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$konsumsi_september23 = $konsumsi_biaya_september23['total'] + $konsumsi_jurnal_september23['total'];

	$gaji_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$gaji_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$gaji_september23 = $gaji_biaya_september23['total'] + $gaji_jurnal_september23['total'];

	$upah_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$upah_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$upah_september23 = $upah_biaya_september23['total'] + $upah_jurnal_september23['total'];

	$pengujian_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$pengujian_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$pengujian_september23 = $pengujian_biaya_september23['total'] + $pengujian_jurnal_september23['total'];

	$perbaikan_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$perbaikan_september23 = $perbaikan_biaya_september23['total'] + $perbaikan_jurnal_september23['total'];

	$akomodasi_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$akomodasi_september23 = $akomodasi_biaya_september23['total'] + $akomodasi_jurnal_september23['total'];

	$listrik_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$listrik_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$listrik_september23 = $listrik_biaya_september23['total'] + $listrik_jurnal_september23['total'];
	
	$thr_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$thr_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$thr_september23 = $thr_biaya_september23['total'] + $thr_jurnal_september23['total'];

	$bensin_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$bensin_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$bensin_september23 = $bensin_biaya_september23['total'] + $bensin_jurnal_september23['total'];

	$dinas_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$dinas_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$dinas_september23 = $dinas_biaya_september23['total'] + $dinas_jurnal_september23['total'];

	$komunikasi_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$komunikasi_september23 = $komunikasi_biaya_september23['total'] + $komunikasi_jurnal_september23['total'];

	$pakaian_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$pakaian_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$pakaian_september23 = $pakaian_biaya_september23['total'] + $pakaian_jurnal_september23['total'];
	
	$tulis_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$tulis_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$tulis_september23 = $tulis_biaya_september23['total'] + $tulis_jurnal_september23['total'];

	$keamanan_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$keamanan_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$keamanan_september23 = $keamanan_biaya_september23['total'] + $keamanan_jurnal_september23['total'];

	$perlengkapan_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$perlengkapan_september23 = $perlengkapan_biaya_september23['total'] + $perlengkapan_jurnal_september23['total'];

	$beban_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$beban_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$beban_september23 = $beban_biaya_september23['total'] + $beban_jurnal_september23['total'];

	$adm_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$adm_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$adm_september23 = $adm_biaya_september23['total'] + $adm_jurnal_september23['total'];

	$lain_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$lain_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$lain_september23 = $lain_biaya_september23['total'] + $lain_jurnal_september23['total'];

	$sewa_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$sewa_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$sewa_september23 = $sewa_biaya_september23['total'] + $sewa_jurnal_september23['total'];

	$bpjs_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$bpjs_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$bpjs_september23 = $bpjs_biaya_september23['total'] + $bpjs_jurnal_september23['total'];

	$penyusutan_kantor_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$penyusutan_kantor_september23 = $penyusutan_kantor_biaya_september23['total'] + $penyusutan_kantor_jurnal_september23['total'];

	$penyusutan_kendaraan_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_september23 = $penyusutan_kendaraan_biaya_september23['total'] + $penyusutan_kendaraan_jurnal_september23['total'];

	$iuran_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$iuran_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$iuran_september23 = $iuran_biaya_september23['total'] + $iuran_jurnal_september23['total'];

	$kendaraan_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$kendaraan_september23 = $kendaraan_biaya_september23['total'] + $kendaraan_jurnal_september23['total'];

	$pajak_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$pajak_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$pajak_september23 = $pajak_biaya_september23['total'] + $pajak_jurnal_september23['total'];

	$solar_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$solar_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$solar_september23 = 0;

	$donasi_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$donasi_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$donasi_september23 = $donasi_biaya_september23['total'] + $donasi_jurnal_september23['total'];

	$legal_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$legal_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$legal_september23 = $legal_biaya_september23['total'] + $legal_jurnal_september23['total'];

	$pengobatan_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$pengobatan_september23 = $pengobatan_biaya_september23['total'] + $pengobatan_jurnal_september23['total'];

	$lembur_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$lembur_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$lembur_september23 = $lembur_biaya_september23['total'] + $lembur_jurnal_september23['total'];

	$pelatihan_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$pelatihan_september23 = $pelatihan_biaya_september23_september23['total'] + $pelatihan_jurnal_september23['total'];

	$supplies_biaya_september23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();

	$supplies_jurnal_september23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september23_awal' and '$date_september23_akhir')")
	->get()->row_array();
	$supplies_september23 = $supplies_biaya_september23['total'] + $supplies_jurnal_september23['total'];

	$total_operasional_september23 = $konsumsi_september23 + $gaji_september23 + $upah_september23 + $pengujian_september23 + $perbaikan_september23 + $akomodasi_september23 + $listrik_september23 + $thr_september23 + 
	$bensin_september23 + $dinas_september23 + $komunikasi_september23 + $pakaian_september23 + $tulis_september23 + $keamanan_september23 + $perlengkapan_september23 + $beban_september23 + $adm_september23 + 
	$lain_september23 + $sewa_september23 + $bpjs_september23 + $penyusutan_kantor_september23 + $penyusutan_kendaraan_september23 + $iuran_september23 + $kendaraan_september23 + $pajak_september23 + $solar_september23 + 
	$donasi_september23 + $legal_september23 + $pengobatan_september23 + $lembur_september23 + $pelatihan_september23 + $supplies_september23;
	$nilai_realisasi_overhead_september23_fix = round($total_operasional_september23 / 1000000,0);

	//OKTOBER23
	$nilai_rap_overhead_oktober23 = $overhead_ton * round($total_rekapitulasi_produksi_harian_oktober23,2);
	$nilai_rap_overhead_oktober23_fix = round($nilai_rap_overhead_oktober23 / 1000000,0);

	$konsumsi_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$konsumsi_oktober23 = $konsumsi_biaya_oktober23['total'] + $konsumsi_jurnal_oktober23['total'];

	$gaji_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$gaji_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$gaji_oktober23 = $gaji_biaya_oktober23['total'] + $gaji_jurnal_oktober23['total'];

	$upah_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$upah_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$upah_oktober23 = $upah_biaya_oktober23['total'] + $upah_jurnal_oktober23['total'];

	$pengujian_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$pengujian_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$pengujian_oktober23 = $pengujian_biaya_oktober23['total'] + $pengujian_jurnal_oktober23['total'];

	$perbaikan_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$perbaikan_oktober23 = $perbaikan_biaya_oktober23['total'] + $perbaikan_jurnal_oktober23['total'];

	$akomodasi_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$akomodasi_oktober23 = $akomodasi_biaya_oktober23['total'] + $akomodasi_jurnal_oktober23['total'];

	$listrik_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$listrik_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$listrik_oktober23 = $listrik_biaya_oktober23['total'] + $listrik_jurnal_oktober23['total'];

	$thr_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$thr_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$thr_oktober23 = $thr_biaya_oktober23['total'] + $thr_jurnal_oktober23['total'];

	$bensin_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$bensin_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$bensin_oktober23 = $bensin_biaya_oktober23['total'] + $bensin_jurnal_oktober23['total'];

	$dinas_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$dinas_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$dinas_oktober23 = $dinas_biaya_oktober23['total'] + $dinas_jurnal_oktober23['total'];

	$komunikasi_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$komunikasi_oktober23 = $komunikasi_biaya_oktober23['total'] + $komunikasi_jurnal_oktober23['total'];

	$pakaian_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$pakaian_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$pakaian_oktober23 = $pakaian_biaya_oktober23['total'] + $pakaian_jurnal_oktober23['total'];

	$tulis_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$tulis_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$tulis_oktober23 = $tulis_biaya_oktober23['total'] + $tulis_jurnal_oktober23['total'];

	$keamanan_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$keamanan_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$keamanan_oktober23 = $keamanan_biaya_oktober23['total'] + $keamanan_jurnal_oktober23['total'];

	$perlengkapan_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$perlengkapan_oktober23 = $perlengkapan_biaya_oktober23['total'] + $perlengkapan_jurnal_oktober23['total'];

	$beban_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$beban_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$beban_oktober23 = $beban_biaya_oktober23['total'] + $beban_jurnal_oktober23['total'];

	$adm_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$adm_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$adm_oktober23 = $adm_biaya_oktober23['total'] + $adm_jurnal_oktober23['total'];

	$lain_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$lain_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$lain_oktober23 = $lain_biaya_oktober23['total'] + $lain_jurnal_oktober23['total'];

	$sewa_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$sewa_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$sewa_oktober23 = $sewa_biaya_oktober23['total'] + $sewa_jurnal_oktober23['total'];

	$bpjs_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$bpjs_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$bpjs_oktober23 = $bpjs_biaya_oktober23['total'] + $bpjs_jurnal_oktober23['total'];

	$penyusutan_kantor_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$penyusutan_kantor_oktober23 = $penyusutan_kantor_biaya_oktober23['total'] + $penyusutan_kantor_jurnal_oktober23['total'];

	$penyusutan_kendaraan_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_oktober23 = $penyusutan_kendaraan_biaya_oktober23['total'] + $penyusutan_kendaraan_jurnal_oktober23['total'];

	$iuran_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$iuran_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$iuran_oktober23 = $iuran_biaya_oktober23['total'] + $iuran_jurnal_oktober23['total'];

	$kendaraan_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$kendaraan_oktober23 = $kendaraan_biaya_oktober23['total'] + $kendaraan_jurnal_oktober23['total'];

	$pajak_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$pajak_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$pajak_oktober23 = $pajak_biaya_oktober23['total'] + $pajak_jurnal_oktober23['total'];

	$solar_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$solar_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$solar_oktober23 = 0;

	$donasi_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$donasi_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$donasi_oktober23 = $donasi_biaya_oktober23['total'] + $donasi_jurnal_oktober23['total'];

	$legal_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$legal_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$legal_oktober23 = $legal_biaya_oktober23['total'] + $legal_jurnal_oktober23['total'];

	$pengobatan_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$pengobatan_oktober23 = $pengobatan_biaya_oktober23['total'] + $pengobatan_jurnal_oktober23['total'];

	$lembur_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$lembur_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$lembur_oktober23 = $lembur_biaya_oktober23['total'] + $lembur_jurnal_oktober23['total'];

	$pelatihan_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$pelatihan_oktober23 = $pelatihan_biaya_oktober23_oktober23['total'] + $pelatihan_jurnal_oktober23['total'];

	$supplies_biaya_oktober23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();

	$supplies_jurnal_oktober23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober23_awal' and '$date_oktober23_akhir')")
	->get()->row_array();
	$supplies_oktober23 = $supplies_biaya_oktober23['total'] + $supplies_jurnal_oktober23['total'];

	$total_operasional_oktober23 = $konsumsi_oktober23 + $gaji_oktober23 + $upah_oktober23 + $pengujian_oktober23 + $perbaikan_oktober23 + $akomodasi_oktober23 + $listrik_oktober23 + $thr_oktober23 + 
	$bensin_oktober23 + $dinas_oktober23 + $komunikasi_oktober23 + $pakaian_oktober23 + $tulis_oktober23 + $keamanan_oktober23 + $perlengkapan_oktober23 + $beban_oktober23 + $adm_oktober23 + 
	$lain_oktober23 + $sewa_oktober23 + $bpjs_oktober23 + $penyusutan_kantor_oktober23 + $penyusutan_kendaraan_oktober23 + $iuran_oktober23 + $kendaraan_oktober23 + $pajak_oktober23 + $solar_oktober23 + 
	$donasi_oktober23 + $legal_oktober23 + $pengobatan_oktober23 + $lembur_oktober23 + $pelatihan_oktober23 + $supplies_oktober23;
	$nilai_realisasi_overhead_oktober23_fix = round($total_operasional_oktober23 / 1000000,0);

	//NOVEMBER23
	$nilai_rap_overhead_november23 = $overhead_ton * round($total_rekapitulasi_produksi_harian_november23,2);
	$nilai_rap_overhead_november23_fix = round($nilai_rap_overhead_november23 / 1000000,0);

	$konsumsi_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$konsumsi_november23 = $konsumsi_biaya_november23['total'] + $konsumsi_jurnal_november23['total'];

	$gaji_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$gaji_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$gaji_november23 = $gaji_biaya_november23['total'] + $gaji_jurnal_november23['total'];

	$upah_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$upah_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$upah_november23 = $upah_biaya_november23['total'] + $upah_jurnal_november23['total'];

	$pengujian_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$pengujian_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$pengujian_november23 = $pengujian_biaya_november23['total'] + $pengujian_jurnal_november23['total'];

	$perbaikan_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$perbaikan_november23 = $perbaikan_biaya_november23['total'] + $perbaikan_jurnal_november23['total'];

	$akomodasi_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$akomodasi_november23 = $akomodasi_biaya_november23['total'] + $akomodasi_jurnal_november23['total'];

	$listrik_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$listrik_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$listrik_november23 = $listrik_biaya_november23['total'] + $listrik_jurnal_november23['total'];

	$thr_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$thr_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$thr_november23 = $thr_biaya_november23['total'] + $thr_jurnal_november23['total'];

	$bensin_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$bensin_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$bensin_november23 = $bensin_biaya_november23['total'] + $bensin_jurnal_november23['total'];

	$dinas_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$dinas_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$dinas_november23 = $dinas_biaya_november23['total'] + $dinas_jurnal_november23['total'];

	$komunikasi_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$komunikasi_november23 = $komunikasi_biaya_november23['total'] + $komunikasi_jurnal_november23['total'];

	$pakaian_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$pakaian_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$pakaian_november23 = $pakaian_biaya_november23['total'] + $pakaian_jurnal_november23['total'];

	$tulis_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$tulis_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$tulis_november23 = $tulis_biaya_november23['total'] + $tulis_jurnal_november23['total'];

	$keamanan_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$keamanan_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$keamanan_november23 = $keamanan_biaya_november23['total'] + $keamanan_jurnal_november23['total'];

	$perlengkapan_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$perlengkapan_november23 = $perlengkapan_biaya_november23['total'] + $perlengkapan_jurnal_november23['total'];

	$beban_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$beban_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$beban_november23 = $beban_biaya_november23['total'] + $beban_jurnal_november23['total'];

	$adm_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$adm_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$adm_november23 = $adm_biaya_november23['total'] + $adm_jurnal_november23['total'];

	$lain_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$lain_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$lain_november23 = $lain_biaya_november23['total'] + $lain_jurnal_november23['total'];

	$sewa_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$sewa_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$sewa_november23 = $sewa_biaya_november23['total'] + $sewa_jurnal_november23['total'];

	$bpjs_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$bpjs_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$bpjs_november23 = $bpjs_biaya_november23['total'] + $bpjs_jurnal_november23['total'];

	$penyusutan_kantor_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$penyusutan_kantor_november23 = $penyusutan_kantor_biaya_november23['total'] + $penyusutan_kantor_jurnal_november23['total'];

	$penyusutan_kendaraan_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_november23 = $penyusutan_kendaraan_biaya_november23['total'] + $penyusutan_kendaraan_jurnal_november23['total'];

	$iuran_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$iuran_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$iuran_november23 = $iuran_biaya_november23['total'] + $iuran_jurnal_november23['total'];

	$kendaraan_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$kendaraan_november23 = $kendaraan_biaya_november23['total'] + $kendaraan_jurnal_november23['total'];

	$pajak_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$pajak_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$pajak_november23 = $pajak_biaya_november23['total'] + $pajak_jurnal_november23['total'];

	$solar_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$solar_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$solar_november23 = 0;

	$donasi_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$donasi_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$donasi_november23 = $donasi_biaya_november23['total'] + $donasi_jurnal_november23['total'];

	$legal_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$legal_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$legal_november23 = $legal_biaya_november23['total'] + $legal_jurnal_november23['total'];

	$pengobatan_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$pengobatan_november23 = $pengobatan_biaya_november23['total'] + $pengobatan_jurnal_november23['total'];

	$lembur_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$lembur_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$lembur_november23 = $lembur_biaya_november23['total'] + $lembur_jurnal_november23['total'];

	$pelatihan_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$pelatihan_november23 = $pelatihan_biaya_november23_november23['total'] + $pelatihan_jurnal_november23['total'];

	$supplies_biaya_november23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();

	$supplies_jurnal_november23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november23_awal' and '$date_november23_akhir')")
	->get()->row_array();
	$supplies_november23 = $supplies_biaya_november23['total'] + $supplies_jurnal_november23['total'];

	$total_operasional_november23 = $konsumsi_november23 + $gaji_november23 + $upah_november23 + $pengujian_november23 + $perbaikan_november23 + $akomodasi_november23 + $listrik_november23 + $thr_november23 + 
	$bensin_november23 + $dinas_november23 + $komunikasi_november23 + $pakaian_november23 + $tulis_november23 + $keamanan_november23 + $perlengkapan_november23 + $beban_november23 + $adm_november23 + 
	$lain_november23 + $sewa_november23 + $bpjs_november23 + $penyusutan_kantor_november23 + $penyusutan_kendaraan_november23 + $iuran_november23 + $kendaraan_november23 + $pajak_november23 + $solar_november23 + 
	$donasi_november23 + $legal_november23 + $pengobatan_november23 + $lembur_november23 + $pelatihan_november23 + $supplies_november23;
	$nilai_realisasi_overhead_november23_fix = round($total_operasional_november23 / 1000000,0);
//DESEMBER23
	$nilai_rap_overhead_desember23 = $overhead_ton * round($total_rekapitulasi_produksi_harian_desember23,2);
	$nilai_rap_overhead_desember23_fix = round($nilai_rap_overhead_desember23 / 1000000,0);

	$konsumsi_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$konsumsi_desember23 = $konsumsi_biaya_desember23['total'] + $konsumsi_jurnal_desember23['total'];

	$gaji_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$gaji_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$gaji_desember23 = $gaji_biaya_desember23['total'] + $gaji_jurnal_desember23['total'];

	$upah_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$upah_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$upah_desember23 = $upah_biaya_desember23['total'] + $upah_jurnal_desember23['total'];

	$pengujian_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$pengujian_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$pengujian_desember23 = $pengujian_biaya_desember23['total'] + $pengujian_jurnal_desember23['total'];

	$perbaikan_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$perbaikan_desember23 = $perbaikan_biaya_desember23['total'] + $perbaikan_jurnal_desember23['total'];

	$akomodasi_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$akomodasi_desember23 = $akomodasi_biaya_desember23['total'] + $akomodasi_jurnal_desember23['total'];

	$listrik_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$listrik_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$listrik_desember23 = $listrik_biaya_desember23['total'] + $listrik_jurnal_desember23['total'];

	$thr_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$thr_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$thr_desember23 = $thr_biaya_desember23['total'] + $thr_jurnal_desember23['total'];

	$bensin_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$bensin_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$bensin_desember23 = $bensin_biaya_desember23['total'] + $bensin_jurnal_desember23['total'];

	$dinas_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$dinas_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$dinas_desember23 = $dinas_biaya_desember23['total'] + $dinas_jurnal_desember23['total'];

	$komunikasi_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$komunikasi_desember23 = $komunikasi_biaya_desember23['total'] + $komunikasi_jurnal_desember23['total'];

	$pakaian_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$pakaian_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$pakaian_desember23 = $pakaian_biaya_desember23['total'] + $pakaian_jurnal_desember23['total'];

	$tulis_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$tulis_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$tulis_desember23 = $tulis_biaya_desember23['total'] + $tulis_jurnal_desember23['total'];

	$keamanan_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$keamanan_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$keamanan_desember23 = $keamanan_biaya_desember23['total'] + $keamanan_jurnal_desember23['total'];

	$perlengkapan_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$perlengkapan_desember23 = $perlengkapan_biaya_desember23['total'] + $perlengkapan_jurnal_desember23['total'];

	$beban_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$beban_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$beban_desember23 = $beban_biaya_desember23['total'] + $beban_jurnal_desember23['total'];

	$adm_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$adm_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$adm_desember23 = $adm_biaya_desember23['total'] + $adm_jurnal_desember23['total'];

	$lain_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$lain_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$lain_desember23 = $lain_biaya_desember23['total'] + $lain_jurnal_desember23['total'];

	$sewa_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$sewa_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$sewa_desember23 = $sewa_biaya_desember23['total'] + $sewa_jurnal_desember23['total'];

	$bpjs_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$bpjs_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$bpjs_desember23 = $bpjs_biaya_desember23['total'] + $bpjs_jurnal_desember23['total'];

	$penyusutan_kantor_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$penyusutan_kantor_desember23 = $penyusutan_kantor_biaya_desember23['total'] + $penyusutan_kantor_jurnal_desember23['total'];

	$penyusutan_kendaraan_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_desember23 = $penyusutan_kendaraan_biaya_desember23['total'] + $penyusutan_kendaraan_jurnal_desember23['total'];

	$iuran_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$iuran_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$iuran_desember23 = $iuran_biaya_desember23['total'] + $iuran_jurnal_desember23['total'];

	$kendaraan_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$kendaraan_desember23 = $kendaraan_biaya_desember23['total'] + $kendaraan_jurnal_desember23['total'];

	$pajak_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$pajak_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$pajak_desember23 = $pajak_biaya_desember23['total'] + $pajak_jurnal_desember23['total'];

	$solar_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$solar_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$solar_desember23 = 0;

	$donasi_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$donasi_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$donasi_desember23 = $donasi_biaya_desember23['total'] + $donasi_jurnal_desember23['total'];

	$legal_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$legal_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$legal_desember23 = $legal_biaya_desember23['total'] + $legal_jurnal_desember23['total'];

	$pengobatan_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$pengobatan_desember23 = $pengobatan_biaya_desember23['total'] + $pengobatan_jurnal_desember23['total'];

	$lembur_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$lembur_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$lembur_desember23 = $lembur_biaya_desember23['total'] + $lembur_jurnal_desember23['total'];

	$pelatihan_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$pelatihan_desember23 = $pelatihan_biaya_desember23_desember23['total'] + $pelatihan_jurnal_desember23['total'];

	$supplies_biaya_desember23 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();

	$supplies_jurnal_desember23 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember23_awal' and '$date_desember23_akhir')")
	->get()->row_array();
	$supplies_desember23 = $supplies_biaya_desember23['total'] + $supplies_jurnal_desember23['total'];

	$total_operasional_desember23 = $konsumsi_desember23 + $gaji_desember23 + $upah_desember23 + $pengujian_desember23 + $perbaikan_desember23 + $akomodasi_desember23 + $listrik_desember23 + $thr_desember23 + 
	$bensin_desember23 + $dinas_desember23 + $komunikasi_desember23 + $pakaian_desember23 + $tulis_desember23 + $keamanan_desember23 + $perlengkapan_desember23 + $beban_desember23 + $adm_desember23 + 
	$lain_desember23 + $sewa_desember23 + $bpjs_desember23 + $penyusutan_kantor_desember23 + $penyusutan_kendaraan_desember23 + $iuran_desember23 + $kendaraan_desember23 + $pajak_desember23 + $solar_desember23 + 
	$donasi_desember23 + $legal_desember23 + $pengobatan_desember23 + $lembur_desember23 + $pelatihan_desember23 + $supplies_desember23;
	$nilai_realisasi_overhead_desember23_fix = round($total_operasional_desember23 / 1000000,0);

	//JANUARI24
	$nilai_rap_overhead_januari24 = $overhead_ton * round($total_rekapitulasi_produksi_harian_januari24,2);
	$nilai_rap_overhead_januari24_fix = round($nilai_rap_overhead_januari24 / 1000000,0);

	$konsumsi_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$konsumsi_januari24 = $konsumsi_biaya_januari24['total'] + $konsumsi_jurnal_januari24['total'];

	$gaji_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$gaji_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$gaji_januari24 = $gaji_biaya_januari24['total'] + $gaji_jurnal_januari24['total'];

	$upah_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$upah_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$upah_januari24 = $upah_biaya_januari24['total'] + $upah_jurnal_januari24['total'];

	$pengujian_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$pengujian_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$pengujian_januari24 = $pengujian_biaya_januari24['total'] + $pengujian_jurnal_januari24['total'];

	$perbaikan_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$perbaikan_januari24 = $perbaikan_biaya_januari24['total'] + $perbaikan_jurnal_januari24['total'];

	$akomodasi_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$akomodasi_januari24 = $akomodasi_biaya_januari24['total'] + $akomodasi_jurnal_januari24['total'];

	$listrik_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$listrik_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$listrik_januari24 = $listrik_biaya_januari24['total'] + $listrik_jurnal_januari24['total'];

	$thr_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$thr_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$thr_januari24 = $thr_biaya_januari24['total'] + $thr_jurnal_januari24['total'];

	$bensin_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$bensin_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$bensin_januari24 = $bensin_biaya_januari24['total'] + $bensin_jurnal_januari24['total'];

	$dinas_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$dinas_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$dinas_januari24 = $dinas_biaya_januari24['total'] + $dinas_jurnal_januari24['total'];

	$komunikasi_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$komunikasi_januari24 = $komunikasi_biaya_januari24['total'] + $komunikasi_jurnal_januari24['total'];

	$pakaian_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$pakaian_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$pakaian_januari24 = $pakaian_biaya_januari24['total'] + $pakaian_jurnal_januari24['total'];

	$tulis_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$tulis_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$tulis_januari24 = $tulis_biaya_januari24['total'] + $tulis_jurnal_januari24['total'];

	$keamanan_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$keamanan_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$keamanan_januari24 = $keamanan_biaya_januari24['total'] + $keamanan_jurnal_januari24['total'];

	$perlengkapan_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$perlengkapan_januari24 = $perlengkapan_biaya_januari24['total'] + $perlengkapan_jurnal_januari24['total'];

	$beban_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$beban_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$beban_januari24 = $beban_biaya_januari24['total'] + $beban_jurnal_januari24['total'];

	$adm_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$adm_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$adm_januari24 = $adm_biaya_januari24['total'] + $adm_jurnal_januari24['total'];

	$lain_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$lain_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$lain_januari24 = $lain_biaya_januari24['total'] + $lain_jurnal_januari24['total'];

	$sewa_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$sewa_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$sewa_januari24 = $sewa_biaya_januari24['total'] + $sewa_jurnal_januari24['total'];

	$bpjs_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$bpjs_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$bpjs_januari24 = $bpjs_biaya_januari24['total'] + $bpjs_jurnal_januari24['total'];

	$penyusutan_kantor_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$penyusutan_kantor_januari24 = $penyusutan_kantor_biaya_januari24['total'] + $penyusutan_kantor_jurnal_januari24['total'];

	$penyusutan_kendaraan_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_januari24 = $penyusutan_kendaraan_biaya_januari24['total'] + $penyusutan_kendaraan_jurnal_januari24['total'];

	$iuran_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$iuran_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$iuran_januari24 = $iuran_biaya_januari24['total'] + $iuran_jurnal_januari24['total'];

	$kendaraan_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$kendaraan_januari24 = $kendaraan_biaya_januari24['total'] + $kendaraan_jurnal_januari24['total'];

	$pajak_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$pajak_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$pajak_januari24 = $pajak_biaya_januari24['total'] + $pajak_jurnal_januari24['total'];

	$solar_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$solar_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$solar_januari24 = 0;

	$donasi_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$donasi_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$donasi_januari24 = $donasi_biaya_januari24['total'] + $donasi_jurnal_januari24['total'];

	$legal_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$legal_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$legal_januari24 = $legal_biaya_januari24['total'] + $legal_jurnal_januari24['total'];

	$pengobatan_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$pengobatan_januari24 = $pengobatan_biaya_januari24['total'] + $pengobatan_jurnal_januari24['total'];

	$lembur_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$lembur_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$lembur_januari24 = $lembur_biaya_januari24['total'] + $lembur_jurnal_januari24['total'];

	$pelatihan_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$pelatihan_januari24 = $pelatihan_biaya_januari24_januari24['total'] + $pelatihan_jurnal_januari24['total'];

	$supplies_biaya_januari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();

	$supplies_jurnal_januari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari24_awal' and '$date_januari24_akhir')")
	->get()->row_array();
	$supplies_januari24 = $supplies_biaya_januari24['total'] + $supplies_jurnal_januari24['total'];

	$total_operasional_januari24 = $konsumsi_januari24 + $gaji_januari24 + $upah_januari24 + $pengujian_januari24 + $perbaikan_januari24 + $akomodasi_januari24 + $listrik_januari24 + $thr_januari24 + 
	$bensin_januari24 + $dinas_januari24 + $komunikasi_januari24 + $pakaian_januari24 + $tulis_januari24 + $keamanan_januari24 + $perlengkapan_januari24 + $beban_januari24 + $adm_januari24 + 
	$lain_januari24 + $sewa_januari24 + $bpjs_januari24 + $penyusutan_kantor_januari24 + $penyusutan_kendaraan_januari24 + $iuran_januari24 + $kendaraan_januari24 + $pajak_januari24 + $solar_januari24 + 
	$donasi_januari24 + $legal_januari24 + $pengobatan_januari24 + $lembur_januari24 + $pelatihan_januari24 + $supplies_januari24;
	$nilai_realisasi_overhead_januari24_fix = round($total_operasional_januari24 / 1000000,0);

	//FEBRUARI24
	$nilai_rap_overhead_februari24 = $overhead_ton * round($total_rekapitulasi_produksi_harian_februari24,2);
	$nilai_rap_overhead_februari24_fix = round($nilai_rap_overhead_februari24 / 1000000,0);

	$konsumsi_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$konsumsi_februari24 = $konsumsi_biaya_februari24['total'] + $konsumsi_jurnal_februari24['total'];

	$gaji_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$gaji_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$gaji_februari24 = $gaji_biaya_februari24['total'] + $gaji_jurnal_februari24['total'];

	$upah_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$upah_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$upah_februari24 = $upah_biaya_februari24['total'] + $upah_jurnal_februari24['total'];

	$pengujian_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$pengujian_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$pengujian_februari24 = $pengujian_biaya_februari24['total'] + $pengujian_jurnal_februari24['total'];

	$perbaikan_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$perbaikan_februari24 = $perbaikan_biaya_februari24['total'] + $perbaikan_jurnal_februari24['total'];

	$akomodasi_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$akomodasi_februari24 = $akomodasi_biaya_februari24['total'] + $akomodasi_jurnal_februari24['total'];

	$listrik_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$listrik_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$listrik_februari24 = $listrik_biaya_februari24['total'] + $listrik_jurnal_februari24['total'];

	$thr_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$thr_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$thr_februari24 = $thr_biaya_februari24['total'] + $thr_jurnal_februari24['total'];

	$bensin_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$bensin_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$bensin_februari24 = $bensin_biaya_februari24['total'] + $bensin_jurnal_februari24['total'];

	$dinas_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$dinas_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$dinas_februari24 = $dinas_biaya_februari24['total'] + $dinas_jurnal_februari24['total'];

	$komunikasi_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$komunikasi_februari24 = $komunikasi_biaya_februari24['total'] + $komunikasi_jurnal_februari24['total'];

	$pakaian_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$pakaian_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$pakaian_februari24 = $pakaian_biaya_februari24['total'] + $pakaian_jurnal_februari24['total'];

	$tulis_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$tulis_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$tulis_februari24 = $tulis_biaya_februari24['total'] + $tulis_jurnal_februari24['total'];

	$keamanan_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$keamanan_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$keamanan_februari24 = $keamanan_biaya_februari24['total'] + $keamanan_jurnal_februari24['total'];

	$perlengkapan_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$perlengkapan_februari24 = $perlengkapan_biaya_februari24['total'] + $perlengkapan_jurnal_februari24['total'];

	$beban_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$beban_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$beban_februari24 = $beban_biaya_februari24['total'] + $beban_jurnal_februari24['total'];

	$adm_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$adm_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$adm_februari24 = $adm_biaya_februari24['total'] + $adm_jurnal_februari24['total'];

	$lain_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$lain_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$lain_februari24 = $lain_biaya_februari24['total'] + $lain_jurnal_februari24['total'];

	$sewa_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$sewa_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$sewa_februari24 = $sewa_biaya_februari24['total'] + $sewa_jurnal_februari24['total'];

	$bpjs_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$bpjs_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$bpjs_februari24 = $bpjs_biaya_februari24['total'] + $bpjs_jurnal_februari24['total'];

	$penyusutan_kantor_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$penyusutan_kantor_februari24 = $penyusutan_kantor_biaya_februari24['total'] + $penyusutan_kantor_jurnal_februari24['total'];

	$penyusutan_kendaraan_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_februari24 = $penyusutan_kendaraan_biaya_februari24['total'] + $penyusutan_kendaraan_jurnal_februari24['total'];

	$iuran_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$iuran_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$iuran_februari24 = $iuran_biaya_februari24['total'] + $iuran_jurnal_februari24['total'];

	$kendaraan_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$kendaraan_februari24 = $kendaraan_biaya_februari24['total'] + $kendaraan_jurnal_februari24['total'];

	$pajak_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$pajak_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$pajak_februari24 = $pajak_biaya_februari24['total'] + $pajak_jurnal_februari24['total'];

	$solar_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$solar_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$solar_februari24 = 0;

	$donasi_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$donasi_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$donasi_februari24 = $donasi_biaya_februari24['total'] + $donasi_jurnal_februari24['total'];

	$legal_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$legal_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$legal_februari24 = $legal_biaya_februari24['total'] + $legal_jurnal_februari24['total'];

	$pengobatan_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$pengobatan_februari24 = $pengobatan_biaya_februari24['total'] + $pengobatan_jurnal_februari24['total'];

	$lembur_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$lembur_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$lembur_februari24 = $lembur_biaya_februari24['total'] + $lembur_jurnal_februari24['total'];

	$pelatihan_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$pelatihan_februari24 = $pelatihan_biaya_februari24_februari24['total'] + $pelatihan_jurnal_februari24['total'];

	$supplies_biaya_februari24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();

	$supplies_jurnal_februari24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari24_awal' and '$date_februari24_akhir')")
	->get()->row_array();
	$supplies_februari24 = $supplies_biaya_februari24['total'] + $supplies_jurnal_februari24['total'];

	$total_operasional_februari24 = $konsumsi_februari24 + $gaji_februari24 + $upah_februari24 + $pengujian_februari24 + $perbaikan_februari24 + $akomodasi_februari24 + $listrik_februari24 + $thr_februari24 + 
	$bensin_februari24 + $dinas_februari24 + $komunikasi_februari24 + $pakaian_februari24 + $tulis_februari24 + $keamanan_februari24 + $perlengkapan_februari24 + $beban_februari24 + $adm_februari24 + 
	$lain_februari24 + $sewa_februari24 + $bpjs_februari24 + $penyusutan_kantor_februari24 + $penyusutan_kendaraan_februari24 + $iuran_februari24 + $kendaraan_februari24 + $pajak_februari24 + $solar_februari24 + 
	$donasi_februari24 + $legal_februari24 + $pengobatan_februari24 + $lembur_februari24 + $pelatihan_februari24 + $supplies_februari24;
	$nilai_realisasi_overhead_februari24_fix = round($total_operasional_februari24 / 1000000,0);

	//MARET24
	$nilai_rap_overhead_maret24 = $overhead_ton * round($total_rekapitulasi_produksi_harian_maret24,2);
	$nilai_rap_overhead_maret24_fix = round($nilai_rap_overhead_maret24 / 1000000,0);

	$konsumsi_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$konsumsi_maret24 = $konsumsi_biaya_maret24['total'] + $konsumsi_jurnal_maret24['total'];

	$gaji_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$gaji_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$gaji_maret24 = $gaji_biaya_maret24['total'] + $gaji_jurnal_maret24['total'];

	$upah_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$upah_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$upah_maret24 = $upah_biaya_maret24['total'] + $upah_jurnal_maret24['total'];

	$pengujian_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$pengujian_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$pengujian_maret24 = $pengujian_biaya_maret24['total'] + $pengujian_jurnal_maret24['total'];

	$perbaikan_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$perbaikan_maret24 = $perbaikan_biaya_maret24['total'] + $perbaikan_jurnal_maret24['total'];

	$akomodasi_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$akomodasi_maret24 = $akomodasi_biaya_maret24['total'] + $akomodasi_jurnal_maret24['total'];

	$listrik_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$listrik_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$listrik_maret24 = $listrik_biaya_maret24['total'] + $listrik_jurnal_maret24['total'];

	$thr_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$thr_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$thr_maret24 = $thr_biaya_maret24['total'] + $thr_jurnal_maret24['total'];

	$bensin_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$bensin_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$bensin_maret24 = $bensin_biaya_maret24['total'] + $bensin_jurnal_maret24['total'];

	$dinas_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$dinas_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$dinas_maret24 = $dinas_biaya_maret24['total'] + $dinas_jurnal_maret24['total'];

	$komunikasi_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$komunikasi_maret24 = $komunikasi_biaya_maret24['total'] + $komunikasi_jurnal_maret24['total'];

	$pakaian_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$pakaian_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$pakaian_maret24 = $pakaian_biaya_maret24['total'] + $pakaian_jurnal_maret24['total'];

	$tulis_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$tulis_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$tulis_maret24 = $tulis_biaya_maret24['total'] + $tulis_jurnal_maret24['total'];

	$keamanan_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$keamanan_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$keamanan_maret24 = $keamanan_biaya_maret24['total'] + $keamanan_jurnal_maret24['total'];

	$perlengkapan_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$perlengkapan_maret24 = $perlengkapan_biaya_maret24['total'] + $perlengkapan_jurnal_maret24['total'];

	$beban_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$beban_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$beban_maret24 = $beban_biaya_maret24['total'] + $beban_jurnal_maret24['total'];

	$adm_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$adm_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$adm_maret24 = $adm_biaya_maret24['total'] + $adm_jurnal_maret24['total'];

	$lain_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$lain_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$lain_maret24 = $lain_biaya_maret24['total'] + $lain_jurnal_maret24['total'];

	$sewa_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$sewa_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$sewa_maret24 = $sewa_biaya_maret24['total'] + $sewa_jurnal_maret24['total'];

	$bpjs_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$bpjs_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$bpjs_maret24 = $bpjs_biaya_maret24['total'] + $bpjs_jurnal_maret24['total'];

	$penyusutan_kantor_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$penyusutan_kantor_maret24 = $penyusutan_kantor_biaya_maret24['total'] + $penyusutan_kantor_jurnal_maret24['total'];

	$penyusutan_kendaraan_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_maret24 = $penyusutan_kendaraan_biaya_maret24['total'] + $penyusutan_kendaraan_jurnal_maret24['total'];

	$iuran_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$iuran_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$iuran_maret24 = $iuran_biaya_maret24['total'] + $iuran_jurnal_maret24['total'];

	$kendaraan_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$kendaraan_maret24 = $kendaraan_biaya_maret24['total'] + $kendaraan_jurnal_maret24['total'];

	$pajak_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$pajak_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$pajak_maret24 = $pajak_biaya_maret24['total'] + $pajak_jurnal_maret24['total'];

	$solar_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$solar_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$solar_maret24 = 0;

	$donasi_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$donasi_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$donasi_maret24 = $donasi_biaya_maret24['total'] + $donasi_jurnal_maret24['total'];

	$legal_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$legal_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$legal_maret24 = $legal_biaya_maret24['total'] + $legal_jurnal_maret24['total'];

	$pengobatan_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$pengobatan_maret24 = $pengobatan_biaya_maret24['total'] + $pengobatan_jurnal_maret24['total'];

	$lembur_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$lembur_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$lembur_maret24 = $lembur_biaya_maret24['total'] + $lembur_jurnal_maret24['total'];

	$pelatihan_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$pelatihan_maret24 = $pelatihan_biaya_maret24_maret24['total'] + $pelatihan_jurnal_maret24['total'];

	$supplies_biaya_maret24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();

	$supplies_jurnal_maret24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret24_awal' and '$date_maret24_akhir')")
	->get()->row_array();
	$supplies_maret24 = $supplies_biaya_maret24['total'] + $supplies_jurnal_maret24['total'];

	$total_operasional_maret24 = $konsumsi_maret24 + $gaji_maret24 + $upah_maret24 + $pengujian_maret24 + $perbaikan_maret24 + $akomodasi_maret24 + $listrik_maret24 + $thr_maret24 + 
	$bensin_maret24 + $dinas_maret24 + $komunikasi_maret24 + $pakaian_maret24 + $tulis_maret24 + $keamanan_maret24 + $perlengkapan_maret24 + $beban_maret24 + $adm_maret24 + 
	$lain_maret24 + $sewa_maret24 + $bpjs_maret24 + $penyusutan_kantor_maret24 + $penyusutan_kendaraan_maret24 + $iuran_maret24 + $kendaraan_maret24 + $pajak_maret24 + $solar_maret24 + 
	$donasi_maret24 + $legal_maret24 + $pengobatan_maret24 + $lembur_maret24 + $pelatihan_maret24 + $supplies_maret24;
	$nilai_realisasi_overhead_maret24_fix = round($total_operasional_maret24 / 1000000,0);

	//APRIL24
	$nilai_rap_overhead_april24 = $overhead_ton * round($total_rekapitulasi_produksi_harian_april24,2);
	$nilai_rap_overhead_april24_fix = round($nilai_rap_overhead_april24 / 1000000,0);

	$konsumsi_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$konsumsi_april24 = $konsumsi_biaya_april24['total'] + $konsumsi_jurnal_april24['total'];

	$gaji_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$gaji_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$gaji_april24 = $gaji_biaya_april24['total'] + $gaji_jurnal_april24['total'];

	$upah_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$upah_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$upah_april24 = $upah_biaya_april24['total'] + $upah_jurnal_april24['total'];

	$pengujian_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$pengujian_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$pengujian_april24 = $pengujian_biaya_april24['total'] + $pengujian_jurnal_april24['total'];

	$perbaikan_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$perbaikan_april24 = $perbaikan_biaya_april24['total'] + $perbaikan_jurnal_april24['total'];

	$akomodasi_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$akomodasi_april24 = $akomodasi_biaya_april24['total'] + $akomodasi_jurnal_april24['total'];

	$listrik_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$listrik_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$listrik_april24 = $listrik_biaya_april24['total'] + $listrik_jurnal_april24['total'];

	$thr_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$thr_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$thr_april24 = $thr_biaya_april24['total'] + $thr_jurnal_april24['total'];

	$bensin_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$bensin_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$bensin_april24 = $bensin_biaya_april24['total'] + $bensin_jurnal_april24['total'];

	$dinas_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$dinas_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$dinas_april24 = $dinas_biaya_april24['total'] + $dinas_jurnal_april24['total'];

	$komunikasi_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$komunikasi_april24 = $komunikasi_biaya_april24['total'] + $komunikasi_jurnal_april24['total'];

	$pakaian_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$pakaian_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$pakaian_april24 = $pakaian_biaya_april24['total'] + $pakaian_jurnal_april24['total'];

	$tulis_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$tulis_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$tulis_april24 = $tulis_biaya_april24['total'] + $tulis_jurnal_april24['total'];

	$keamanan_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$keamanan_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$keamanan_april24 = $keamanan_biaya_april24['total'] + $keamanan_jurnal_april24['total'];

	$perlengkapan_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$perlengkapan_april24 = $perlengkapan_biaya_april24['total'] + $perlengkapan_jurnal_april24['total'];

	$beban_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$beban_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$beban_april24 = $beban_biaya_april24['total'] + $beban_jurnal_april24['total'];

	$adm_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$adm_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$adm_april24 = $adm_biaya_april24['total'] + $adm_jurnal_april24['total'];

	$lain_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$lain_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$lain_april24 = $lain_biaya_april24['total'] + $lain_jurnal_april24['total'];

	$sewa_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$sewa_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$sewa_april24 = $sewa_biaya_april24['total'] + $sewa_jurnal_april24['total'];

	$bpjs_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$bpjs_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$bpjs_april24 = $bpjs_biaya_april24['total'] + $bpjs_jurnal_april24['total'];

	$penyusutan_kantor_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$penyusutan_kantor_april24 = $penyusutan_kantor_biaya_april24['total'] + $penyusutan_kantor_jurnal_april24['total'];

	$penyusutan_kendaraan_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_april24 = $penyusutan_kendaraan_biaya_april24['total'] + $penyusutan_kendaraan_jurnal_april24['total'];

	$iuran_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$iuran_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$iuran_april24 = $iuran_biaya_april24['total'] + $iuran_jurnal_april24['total'];

	$kendaraan_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$kendaraan_april24 = $kendaraan_biaya_april24['total'] + $kendaraan_jurnal_april24['total'];

	$pajak_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$pajak_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$pajak_april24 = $pajak_biaya_april24['total'] + $pajak_jurnal_april24['total'];

	$solar_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$solar_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$solar_april24 = 0;

	$donasi_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$donasi_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$donasi_april24 = $donasi_biaya_april24['total'] + $donasi_jurnal_april24['total'];

	$legal_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$legal_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$legal_april24 = $legal_biaya_april24['total'] + $legal_jurnal_april24['total'];

	$pengobatan_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$pengobatan_april24 = $pengobatan_biaya_april24['total'] + $pengobatan_jurnal_april24['total'];

	$lembur_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$lembur_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$lembur_april24 = $lembur_biaya_april24['total'] + $lembur_jurnal_april24['total'];

	$pelatihan_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$pelatihan_april24 = $pelatihan_biaya_april24_april24['total'] + $pelatihan_jurnal_april24['total'];

	$supplies_biaya_april24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();

	$supplies_jurnal_april24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april24_awal' and '$date_april24_akhir')")
	->get()->row_array();
	$supplies_april24 = $supplies_biaya_april24['total'] + $supplies_jurnal_april24['total'];

	$total_operasional_april24 = $konsumsi_april24 + $gaji_april24 + $upah_april24 + $pengujian_april24 + $perbaikan_april24 + $akomodasi_april24 + $listrik_april24 + $thr_april24 + 
	$bensin_april24 + $dinas_april24 + $komunikasi_april24 + $pakaian_april24 + $tulis_april24 + $keamanan_april24 + $perlengkapan_april24 + $beban_april24 + $adm_april24 + 
	$lain_april24 + $sewa_april24 + $bpjs_april24 + $penyusutan_kantor_april24 + $penyusutan_kendaraan_april24 + $iuran_april24 + $kendaraan_april24 + $pajak_april24 + $solar_april24 + 
	$donasi_april24 + $legal_april24 + $pengobatan_april24 + $lembur_april24 + $pelatihan_april24 + $supplies_april24;
	$nilai_realisasi_overhead_april24_fix = round($total_operasional_april24 / 1000000,0);

	//MEI24
	$nilai_rap_overhead_mei24 = $overhead_ton * round($total_rekapitulasi_produksi_harian_mei24,2);
	$nilai_rap_overhead_mei24_fix = round($nilai_rap_overhead_mei24 / 1000000,0);

	$konsumsi_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$konsumsi_mei24 = $konsumsi_biaya_mei24['total'] + $konsumsi_jurnal_mei24['total'];

	$gaji_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$gaji_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$gaji_mei24 = $gaji_biaya_mei24['total'] + $gaji_jurnal_mei24['total'];

	$upah_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$upah_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$upah_mei24 = $upah_biaya_mei24['total'] + $upah_jurnal_mei24['total'];

	$pengujian_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$pengujian_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$pengujian_mei24 = $pengujian_biaya_mei24['total'] + $pengujian_jurnal_mei24['total'];

	$perbaikan_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$perbaikan_mei24 = $perbaikan_biaya_mei24['total'] + $perbaikan_jurnal_mei24['total'];

	$akomodasi_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$akomodasi_mei24 = $akomodasi_biaya_mei24['total'] + $akomodasi_jurnal_mei24['total'];

	$listrik_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$listrik_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$listrik_mei24 = $listrik_biaya_mei24['total'] + $listrik_jurnal_mei24['total'];

	$thr_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$thr_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$thr_mei24 = $thr_biaya_mei24['total'] + $thr_jurnal_mei24['total'];

	$bensin_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$bensin_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$bensin_mei24 = $bensin_biaya_mei24['total'] + $bensin_jurnal_mei24['total'];

	$dinas_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$dinas_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$dinas_mei24 = $dinas_biaya_mei24['total'] + $dinas_jurnal_mei24['total'];

	$komunikasi_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$komunikasi_mei24 = $komunikasi_biaya_mei24['total'] + $komunikasi_jurnal_mei24['total'];

	$pakaian_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$pakaian_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$pakaian_mei24 = $pakaian_biaya_mei24['total'] + $pakaian_jurnal_mei24['total'];

	$tulis_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$tulis_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$tulis_mei24 = $tulis_biaya_mei24['total'] + $tulis_jurnal_mei24['total'];

	$keamanan_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$keamanan_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$keamanan_mei24 = $keamanan_biaya_mei24['total'] + $keamanan_jurnal_mei24['total'];

	$perlengkapan_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$perlengkapan_mei24 = $perlengkapan_biaya_mei24['total'] + $perlengkapan_jurnal_mei24['total'];

	$beban_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$beban_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$beban_mei24 = $beban_biaya_mei24['total'] + $beban_jurnal_mei24['total'];

	$adm_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$adm_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$adm_mei24 = $adm_biaya_mei24['total'] + $adm_jurnal_mei24['total'];

	$lain_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$lain_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$lain_mei24 = $lain_biaya_mei24['total'] + $lain_jurnal_mei24['total'];

	$sewa_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$sewa_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$sewa_mei24 = $sewa_biaya_mei24['total'] + $sewa_jurnal_mei24['total'];

	$bpjs_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$bpjs_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$bpjs_mei24 = $bpjs_biaya_mei24['total'] + $bpjs_jurnal_mei24['total'];

	$penyusutan_kantor_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$penyusutan_kantor_mei24 = $penyusutan_kantor_biaya_mei24['total'] + $penyusutan_kantor_jurnal_mei24['total'];

	$penyusutan_kendaraan_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_mei24 = $penyusutan_kendaraan_biaya_mei24['total'] + $penyusutan_kendaraan_jurnal_mei24['total'];

	$iuran_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$iuran_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$iuran_mei24 = $iuran_biaya_mei24['total'] + $iuran_jurnal_mei24['total'];

	$kendaraan_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$kendaraan_mei24 = $kendaraan_biaya_mei24['total'] + $kendaraan_jurnal_mei24['total'];

	$pajak_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$pajak_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$pajak_mei24 = $pajak_biaya_mei24['total'] + $pajak_jurnal_mei24['total'];

	$solar_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$solar_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$solar_mei24 = 0;

	$donasi_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$donasi_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$donasi_mei24 = $donasi_biaya_mei24['total'] + $donasi_jurnal_mei24['total'];

	$legal_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$legal_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$legal_mei24 = $legal_biaya_mei24['total'] + $legal_jurnal_mei24['total'];

	$pengobatan_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$pengobatan_mei24 = $pengobatan_biaya_mei24['total'] + $pengobatan_jurnal_mei24['total'];

	$lembur_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$lembur_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$lembur_mei24 = $lembur_biaya_mei24['total'] + $lembur_jurnal_mei24['total'];

	$pelatihan_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$pelatihan_mei24 = $pelatihan_biaya_mei24_mei24['total'] + $pelatihan_jurnal_mei24['total'];

	$supplies_biaya_mei24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();

	$supplies_jurnal_mei24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei24_awal' and '$date_mei24_akhir')")
	->get()->row_array();
	$supplies_mei24 = $supplies_biaya_mei24['total'] + $supplies_jurnal_mei24['total'];

	$total_operasional_mei24 = $konsumsi_mei24 + $gaji_mei24 + $upah_mei24 + $pengujian_mei24 + $perbaikan_mei24 + $akomodasi_mei24 + $listrik_mei24 + $thr_mei24 + 
	$bensin_mei24 + $dinas_mei24 + $komunikasi_mei24 + $pakaian_mei24 + $tulis_mei24 + $keamanan_mei24 + $perlengkapan_mei24 + $beban_mei24 + $adm_mei24 + 
	$lain_mei24 + $sewa_mei24 + $bpjs_mei24 + $penyusutan_kantor_mei24 + $penyusutan_kendaraan_mei24 + $iuran_mei24 + $kendaraan_mei24 + $pajak_mei24 + $solar_mei24 + 
	$donasi_mei24 + $legal_mei24 + $pengobatan_mei24 + $lembur_mei24 + $pelatihan_mei24 + $supplies_mei24;
	$nilai_realisasi_overhead_mei24_fix = round($total_operasional_mei24 / 1000000,0);

	//JUNI24
	$nilai_rap_overhead_juni24 = $overhead_ton * round($total_rekapitulasi_produksi_harian_juni24,2);
	$nilai_rap_overhead_juni24_fix = round($nilai_rap_overhead_juni24 / 1000000,0);

	$konsumsi_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$konsumsi_juni24 = $konsumsi_biaya_juni24['total'] + $konsumsi_jurnal_juni24['total'];

	$gaji_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$gaji_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$gaji_juni24 = $gaji_biaya_juni24['total'] + $gaji_jurnal_juni24['total'];

	$upah_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$upah_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$upah_juni24 = $upah_biaya_juni24['total'] + $upah_jurnal_juni24['total'];

	$pengujian_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$pengujian_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$pengujian_juni24 = $pengujian_biaya_juni24['total'] + $pengujian_jurnal_juni24['total'];

	$perbaikan_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$perbaikan_juni24 = $perbaikan_biaya_juni24['total'] + $perbaikan_jurnal_juni24['total'];

	$akomodasi_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$akomodasi_juni24 = $akomodasi_biaya_juni24['total'] + $akomodasi_jurnal_juni24['total'];

	$listrik_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$listrik_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$listrik_juni24 = $listrik_biaya_juni24['total'] + $listrik_jurnal_juni24['total'];

	$thr_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$thr_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$thr_juni24 = $thr_biaya_juni24['total'] + $thr_jurnal_juni24['total'];

	$bensin_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$bensin_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$bensin_juni24 = $bensin_biaya_juni24['total'] + $bensin_jurnal_juni24['total'];

	$dinas_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$dinas_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$dinas_juni24 = $dinas_biaya_juni24['total'] + $dinas_jurnal_juni24['total'];

	$komunikasi_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$komunikasi_juni24 = $komunikasi_biaya_juni24['total'] + $komunikasi_jurnal_juni24['total'];

	$pakaian_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$pakaian_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$pakaian_juni24 = $pakaian_biaya_juni24['total'] + $pakaian_jurnal_juni24['total'];

	$tulis_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$tulis_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$tulis_juni24 = $tulis_biaya_juni24['total'] + $tulis_jurnal_juni24['total'];

	$keamanan_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$keamanan_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$keamanan_juni24 = $keamanan_biaya_juni24['total'] + $keamanan_jurnal_juni24['total'];

	$perlengkapan_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$perlengkapan_juni24 = $perlengkapan_biaya_juni24['total'] + $perlengkapan_jurnal_juni24['total'];

	$beban_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$beban_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$beban_juni24 = $beban_biaya_juni24['total'] + $beban_jurnal_juni24['total'];

	$adm_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$adm_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$adm_juni24 = $adm_biaya_juni24['total'] + $adm_jurnal_juni24['total'];

	$lain_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$lain_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$lain_juni24 = $lain_biaya_juni24['total'] + $lain_jurnal_juni24['total'];

	$sewa_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$sewa_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$sewa_juni24 = $sewa_biaya_juni24['total'] + $sewa_jurnal_juni24['total'];

	$bpjs_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$bpjs_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$bpjs_juni24 = $bpjs_biaya_juni24['total'] + $bpjs_jurnal_juni24['total'];

	$penyusutan_kantor_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$penyusutan_kantor_juni24 = $penyusutan_kantor_biaya_juni24['total'] + $penyusutan_kantor_jurnal_juni24['total'];

	$penyusutan_kendaraan_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_juni24 = $penyusutan_kendaraan_biaya_juni24['total'] + $penyusutan_kendaraan_jurnal_juni24['total'];

	$iuran_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$iuran_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$iuran_juni24 = $iuran_biaya_juni24['total'] + $iuran_jurnal_juni24['total'];

	$kendaraan_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$kendaraan_juni24 = $kendaraan_biaya_juni24['total'] + $kendaraan_jurnal_juni24['total'];

	$pajak_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$pajak_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$pajak_juni24 = $pajak_biaya_juni24['total'] + $pajak_jurnal_juni24['total'];

	$solar_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$solar_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$solar_juni24 = 0;

	$donasi_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$donasi_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$donasi_juni24 = $donasi_biaya_juni24['total'] + $donasi_jurnal_juni24['total'];

	$legal_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$legal_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$legal_juni24 = $legal_biaya_juni24['total'] + $legal_jurnal_juni24['total'];

	$pengobatan_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$pengobatan_juni24 = $pengobatan_biaya_juni24['total'] + $pengobatan_jurnal_juni24['total'];

	$lembur_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$lembur_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$lembur_juni24 = $lembur_biaya_juni24['total'] + $lembur_jurnal_juni24['total'];

	$pelatihan_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$pelatihan_juni24 = $pelatihan_biaya_juni24_juni24['total'] + $pelatihan_jurnal_juni24['total'];

	$supplies_biaya_juni24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();

	$supplies_jurnal_juni24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni24_awal' and '$date_juni24_akhir')")
	->get()->row_array();
	$supplies_juni24 = $supplies_biaya_juni24['total'] + $supplies_jurnal_juni24['total'];

	$total_operasional_juni24 = $konsumsi_juni24 + $gaji_juni24 + $upah_juni24 + $pengujian_juni24 + $perbaikan_juni24 + $akomodasi_juni24 + $listrik_juni24 + $thr_juni24 + 
	$bensin_juni24 + $dinas_juni24 + $komunikasi_juni24 + $pakaian_juni24 + $tulis_juni24 + $keamanan_juni24 + $perlengkapan_juni24 + $beban_juni24 + $adm_juni24 + 
	$lain_juni24 + $sewa_juni24 + $bpjs_juni24 + $penyusutan_kantor_juni24 + $penyusutan_kendaraan_juni24 + $iuran_juni24 + $kendaraan_juni24 + $pajak_juni24 + $solar_juni24 + 
	$donasi_juni24 + $legal_juni24 + $pengobatan_juni24 + $lembur_juni24 + $pelatihan_juni24 + $supplies_juni24;
	$nilai_realisasi_overhead_juni24_fix = round($total_operasional_juni24 / 1000000,0);

	//JULI24
	$nilai_rap_overhead_juli24 = $overhead_ton * round($total_rekapitulasi_produksi_harian_juli24,2);
	$nilai_rap_overhead_juli24_fix = round($nilai_rap_overhead_juli24 / 1000000,0);

	$konsumsi_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$konsumsi_juli24 = $konsumsi_biaya_juli24['total'] + $konsumsi_jurnal_juli24['total'];

	$gaji_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$gaji_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$gaji_juli24 = $gaji_biaya_juli24['total'] + $gaji_jurnal_juli24['total'];

	$upah_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$upah_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$upah_juli24 = $upah_biaya_juli24['total'] + $upah_jurnal_juli24['total'];

	$pengujian_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$pengujian_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$pengujian_juli24 = $pengujian_biaya_juli24['total'] + $pengujian_jurnal_juli24['total'];

	$perbaikan_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$perbaikan_juli24 = $perbaikan_biaya_juli24['total'] + $perbaikan_jurnal_juli24['total'];

	$akomodasi_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$akomodasi_juli24 = $akomodasi_biaya_juli24['total'] + $akomodasi_jurnal_juli24['total'];

	$listrik_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$listrik_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$listrik_juli24 = $listrik_biaya_juli24['total'] + $listrik_jurnal_juli24['total'];

	$thr_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$thr_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$thr_juli24 = $thr_biaya_juli24['total'] + $thr_jurnal_juli24['total'];

	$bensin_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$bensin_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$bensin_juli24 = $bensin_biaya_juli24['total'] + $bensin_jurnal_juli24['total'];

	$dinas_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$dinas_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$dinas_juli24 = $dinas_biaya_juli24['total'] + $dinas_jurnal_juli24['total'];

	$komunikasi_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$komunikasi_juli24 = $komunikasi_biaya_juli24['total'] + $komunikasi_jurnal_juli24['total'];

	$pakaian_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$pakaian_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$pakaian_juli24 = $pakaian_biaya_juli24['total'] + $pakaian_jurnal_juli24['total'];

	$tulis_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$tulis_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$tulis_juli24 = $tulis_biaya_juli24['total'] + $tulis_jurnal_juli24['total'];

	$keamanan_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$keamanan_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$keamanan_juli24 = $keamanan_biaya_juli24['total'] + $keamanan_jurnal_juli24['total'];

	$perlengkapan_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$perlengkapan_juli24 = $perlengkapan_biaya_juli24['total'] + $perlengkapan_jurnal_juli24['total'];

	$beban_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$beban_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$beban_juli24 = $beban_biaya_juli24['total'] + $beban_jurnal_juli24['total'];

	$adm_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$adm_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$adm_juli24 = $adm_biaya_juli24['total'] + $adm_jurnal_juli24['total'];

	$lain_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$lain_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$lain_juli24 = $lain_biaya_juli24['total'] + $lain_jurnal_juli24['total'];

	$sewa_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$sewa_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$sewa_juli24 = $sewa_biaya_juli24['total'] + $sewa_jurnal_juli24['total'];

	$bpjs_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$bpjs_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$bpjs_juli24 = $bpjs_biaya_juli24['total'] + $bpjs_jurnal_juli24['total'];

	$penyusutan_kantor_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$penyusutan_kantor_juli24 = $penyusutan_kantor_biaya_juli24['total'] + $penyusutan_kantor_jurnal_juli24['total'];

	$penyusutan_kendaraan_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_juli24 = $penyusutan_kendaraan_biaya_juli24['total'] + $penyusutan_kendaraan_jurnal_juli24['total'];

	$iuran_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$iuran_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$iuran_juli24 = $iuran_biaya_juli24['total'] + $iuran_jurnal_juli24['total'];

	$kendaraan_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$kendaraan_juli24 = $kendaraan_biaya_juli24['total'] + $kendaraan_jurnal_juli24['total'];

	$pajak_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$pajak_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$pajak_juli24 = $pajak_biaya_juli24['total'] + $pajak_jurnal_juli24['total'];

	$solar_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$solar_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$solar_juli24 = 0;

	$donasi_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$donasi_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$donasi_juli24 = $donasi_biaya_juli24['total'] + $donasi_jurnal_juli24['total'];

	$legal_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$legal_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$legal_juli24 = $legal_biaya_juli24['total'] + $legal_jurnal_juli24['total'];

	$pengobatan_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$pengobatan_juli24 = $pengobatan_biaya_juli24['total'] + $pengobatan_jurnal_juli24['total'];

	$lembur_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$lembur_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$lembur_juli24 = $lembur_biaya_juli24['total'] + $lembur_jurnal_juli24['total'];

	$pelatihan_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$pelatihan_juli24 = $pelatihan_biaya_juli24_juli24['total'] + $pelatihan_jurnal_juli24['total'];

	$supplies_biaya_juli24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();

	$supplies_jurnal_juli24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli24_awal' and '$date_juli24_akhir')")
	->get()->row_array();
	$supplies_juli24 = $supplies_biaya_juli24['total'] + $supplies_jurnal_juli24['total'];

	$total_operasional_juli24 = $konsumsi_juli24 + $gaji_juli24 + $upah_juli24 + $pengujian_juli24 + $perbaikan_juli24 + $akomodasi_juli24 + $listrik_juli24 + $thr_juli24 + 
	$bensin_juli24 + $dinas_juli24 + $komunikasi_juli24 + $pakaian_juli24 + $tulis_juli24 + $keamanan_juli24 + $perlengkapan_juli24 + $beban_juli24 + $adm_juli24 + 
	$lain_juli24 + $sewa_juli24 + $bpjs_juli24 + $penyusutan_kantor_juli24 + $penyusutan_kendaraan_juli24 + $iuran_juli24 + $kendaraan_juli24 + $pajak_juli24 + $solar_juli24 + 
	$donasi_juli24 + $legal_juli24 + $pengobatan_juli24 + $lembur_juli24 + $pelatihan_juli24 + $supplies_juli24;
	$nilai_realisasi_overhead_juli24_fix = round($total_operasional_juli24 / 1000000,0);

	//AGUSTUS24
	$nilai_rap_overhead_agustus24 = $overhead_ton * round($total_rekapitulasi_produksi_harian_agustus24,2);
	$nilai_rap_overhead_agustus24_fix = round($nilai_rap_overhead_agustus24 / 1000000,0);

	$konsumsi_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$konsumsi_agustus24 = $konsumsi_biaya_agustus24['total'] + $konsumsi_jurnal_agustus24['total'];

	$gaji_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$gaji_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$gaji_agustus24 = $gaji_biaya_agustus24['total'] + $gaji_jurnal_agustus24['total'];

	$upah_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$upah_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$upah_agustus24 = $upah_biaya_agustus24['total'] + $upah_jurnal_agustus24['total'];

	$pengujian_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$pengujian_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$pengujian_agustus24 = $pengujian_biaya_agustus24['total'] + $pengujian_jurnal_agustus24['total'];

	$perbaikan_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$perbaikan_agustus24 = $perbaikan_biaya_agustus24['total'] + $perbaikan_jurnal_agustus24['total'];

	$akomodasi_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$akomodasi_agustus24 = $akomodasi_biaya_agustus24['total'] + $akomodasi_jurnal_agustus24['total'];

	$listrik_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$listrik_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$listrik_agustus24 = $listrik_biaya_agustus24['total'] + $listrik_jurnal_agustus24['total'];

	$thr_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$thr_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$thr_agustus24 = $thr_biaya_agustus24['total'] + $thr_jurnal_agustus24['total'];

	$bensin_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$bensin_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$bensin_agustus24 = $bensin_biaya_agustus24['total'] + $bensin_jurnal_agustus24['total'];

	$dinas_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$dinas_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$dinas_agustus24 = $dinas_biaya_agustus24['total'] + $dinas_jurnal_agustus24['total'];

	$komunikasi_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$komunikasi_agustus24 = $komunikasi_biaya_agustus24['total'] + $komunikasi_jurnal_agustus24['total'];

	$pakaian_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$pakaian_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$pakaian_agustus24 = $pakaian_biaya_agustus24['total'] + $pakaian_jurnal_agustus24['total'];

	$tulis_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$tulis_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$tulis_agustus24 = $tulis_biaya_agustus24['total'] + $tulis_jurnal_agustus24['total'];

	$keamanan_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$keamanan_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$keamanan_agustus24 = $keamanan_biaya_agustus24['total'] + $keamanan_jurnal_agustus24['total'];

	$perlengkapan_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$perlengkapan_agustus24 = $perlengkapan_biaya_agustus24['total'] + $perlengkapan_jurnal_agustus24['total'];

	$beban_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$beban_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$beban_agustus24 = $beban_biaya_agustus24['total'] + $beban_jurnal_agustus24['total'];

	$adm_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$adm_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$adm_agustus24 = $adm_biaya_agustus24['total'] + $adm_jurnal_agustus24['total'];

	$lain_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$lain_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$lain_agustus24 = $lain_biaya_agustus24['total'] + $lain_jurnal_agustus24['total'];

	$sewa_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$sewa_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$sewa_agustus24 = $sewa_biaya_agustus24['total'] + $sewa_jurnal_agustus24['total'];

	$bpjs_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$bpjs_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$bpjs_agustus24 = $bpjs_biaya_agustus24['total'] + $bpjs_jurnal_agustus24['total'];

	$penyusutan_kantor_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$penyusutan_kantor_agustus24 = $penyusutan_kantor_biaya_agustus24['total'] + $penyusutan_kantor_jurnal_agustus24['total'];

	$penyusutan_kendaraan_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_agustus24 = $penyusutan_kendaraan_biaya_agustus24['total'] + $penyusutan_kendaraan_jurnal_agustus24['total'];

	$iuran_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$iuran_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$iuran_agustus24 = $iuran_biaya_agustus24['total'] + $iuran_jurnal_agustus24['total'];

	$kendaraan_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$kendaraan_agustus24 = $kendaraan_biaya_agustus24['total'] + $kendaraan_jurnal_agustus24['total'];

	$pajak_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$pajak_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$pajak_agustus24 = $pajak_biaya_agustus24['total'] + $pajak_jurnal_agustus24['total'];

	$solar_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$solar_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$solar_agustus24 = 0;

	$donasi_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$donasi_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$donasi_agustus24 = $donasi_biaya_agustus24['total'] + $donasi_jurnal_agustus24['total'];

	$legal_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$legal_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$legal_agustus24 = $legal_biaya_agustus24['total'] + $legal_jurnal_agustus24['total'];

	$pengobatan_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$pengobatan_agustus24 = $pengobatan_biaya_agustus24['total'] + $pengobatan_jurnal_agustus24['total'];

	$lembur_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$lembur_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$lembur_agustus24 = $lembur_biaya_agustus24['total'] + $lembur_jurnal_agustus24['total'];

	$pelatihan_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$pelatihan_agustus24 = $pelatihan_biaya_agustus24_agustus24['total'] + $pelatihan_jurnal_agustus24['total'];

	$supplies_biaya_agustus24 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();

	$supplies_jurnal_agustus24 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus24_awal' and '$date_agustus24_akhir')")
	->get()->row_array();
	$supplies_agustus24 = $supplies_biaya_agustus24['total'] + $supplies_jurnal_agustus24['total'];

	$total_operasional_agustus24 = $konsumsi_agustus24 + $gaji_agustus24 + $upah_agustus24 + $pengujian_agustus24 + $perbaikan_agustus24 + $akomodasi_agustus24 + $listrik_agustus24 + $thr_agustus24 + 
	$bensin_agustus24 + $dinas_agustus24 + $komunikasi_agustus24 + $pakaian_agustus24 + $tulis_agustus24 + $keamanan_agustus24 + $perlengkapan_agustus24 + $beban_agustus24 + $adm_agustus24 + 
	$lain_agustus24 + $sewa_agustus24 + $bpjs_agustus24 + $penyusutan_kantor_agustus24 + $penyusutan_kendaraan_agustus24 + $iuran_agustus24 + $kendaraan_agustus24 + $pajak_agustus24 + $solar_agustus24 + 
	$donasi_agustus24 + $legal_agustus24 + $pengobatan_agustus24 + $lembur_agustus24 + $pelatihan_agustus24 + $supplies_agustus24;
	$nilai_realisasi_overhead_agustus24_fix = round($total_operasional_agustus24 / 1000000,0);
?>