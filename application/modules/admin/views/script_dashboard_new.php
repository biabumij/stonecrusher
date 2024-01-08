<!-- Akumulasi --->

<?php

	$date_now = date('Y-m-d');
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

	$akumulasi_bahan_jadi_agustus23 = $this->db->select('sum(pp.nilai) / sum(pp.volume) as harsat_agustus23')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_agustus23_awal' and '$date_agustus23_akhir'")
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

	$akumulasi_bahan_jadi_september23 = $this->db->select('sum(pp.nilai) / sum(pp.volume) as harsat_september23')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_september23_awal' and '$date_september23_akhir'")
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

	$akumulasi_bahan_jadi_oktober23 = $this->db->select('sum(pp.nilai) / sum(pp.volume) as harsat_oktober23')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_oktober23_awal' and '$date_oktober23_akhir'")
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

	$akumulasi_bahan_jadi_november23 = $this->db->select('sum(pp.nilai) / sum(pp.volume) as harsat_november23')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_november23_awal' and '$date_november23_akhir'")
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

	$akumulasi_bahan_jadi_desember23 = $this->db->select('sum(pp.nilai) / sum(pp.volume) as harsat_desember23')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_desember23_awal' and '$date_desember23_akhir'")
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
	
?>