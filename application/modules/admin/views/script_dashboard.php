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
    $date_februari24_akhir = date('2024-02-28');
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
?>