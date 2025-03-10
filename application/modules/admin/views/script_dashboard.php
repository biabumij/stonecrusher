<!-- Akumulasi --->

<?php

	$date_now = date('Y-m-d');
    $date_januari25_awal = date('2025-01-01');
    $date_januari25_akhir = date('2025-01-31');
    $date_februari25_awal = date('2025-02-01');
    $date_februari25_akhir = date('2025-02-28');
    $date_maret25_awal = date('2025-03-01');
    $date_maret25_akhir = date('2025-03-31');
    $date_april25_awal = date('2025-04-01');
    $date_april25_akhir = date('2025-04-30');
    $date_mei25_awal = date('2025-05-01');
    $date_mei25_akhir = date('2025-05-31');
    $date_juni25_awal = date('2025-06-01');
    $date_juni25_akhir = date('2025-06-30');
    $date_juli25_awal = date('2025-07-01');
    $date_juli25_akhir = date('2025-07-31');
    $date_agustus25_awal = date('2025-08-01');
    $date_agustus25_akhir = date('2025-08-31');
    $date_september25_awal = date('2025-09-01');
    $date_september25_akhir = date('2025-09-30');
    $date_oktober25_awal = date('2025-10-01');
    $date_oktober25_akhir = date('2025-10-31');
    $date_november25_awal = date('2025-11-01');
    $date_november25_akhir = date('2025-11-30');
    $date_desember25_awal = date('2025-12-01');
    $date_desember25_akhir = date('2025-12-31');
	$date_akumulasi_awal = date('2023-08-01');
    $date_akumulasi_akhir = date('2025-12-31');

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

	//JANUARI25
	$penjualan_januari25 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_januari25_awal' and '$date_januari25_akhir'")
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
	
	$total_penjualan_januari25 = 0;
	$total_volume_penjualan_januari25 = 0;

	foreach ($penjualan_januari25 as $x){
		$total_penjualan_januari25 += $x['price'];
		$total_volume_penjualan_januari25 += $x['volume'];
	}

	$penjualan_limbah_januari25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_januari25_awal' and '$date_januari25_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_januari25 = 0;

	foreach ($penjualan_limbah_januari25 as $x){
		$total_penjualan_limbah_januari25 += $x['price'];
	}

	$penjualan_lain_lain_januari25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_januari25_awal' and '$date_januari25_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_januari25 = 0;

	foreach ($penjualan_lain_lain_januari25 as $x){
		$total_penjualan_lain_lain_januari25 += $x['price'];
	}

	$akumulasi_bahan_jadi_januari25 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_januari25')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_desember23_akhir' and '$date_januari25_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_januari25 = $akumulasi_bahan_jadi_januari25['harsat_januari25'];

	$penjualan_januari25 = $total_penjualan_januari25 + $total_penjualan_limbah_januari25 + $total_penjualan_lain_lain_januari25;
	$beban_pokok_penjualan_januari25 = $total_volume_penjualan_januari25 * $harsat_bahan_jadi_januari25;
	$produksi_januari25 = $this->db->select('produksi')
	->from('kunci_bahan_jadi')
	->where("date between '$date_januari25_awal' and '$date_januari25_akhir'")
	->order_by('id','desc')->limit(1)
	->get()->row_array();
	$produksi_januari25 = $produksi_januari25['produksi'];
	$beban_pokok_penjualan_januari25 = $beban_pokok_penjualan_januari25 *$produksi_januari25;
	$laba_kotor_januari25 = $penjualan_januari25 - $beban_pokok_penjualan_januari25;
	
	$persentase_laba_kotor_januari25 = ($penjualan_januari25!=0)?($laba_kotor_januari25 / $penjualan_januari25) * 100:0;
	$persentase_laba_kotor_januari25_fix = round($persentase_laba_kotor_januari25,2);

	$laba_kotor_rap_januari25 = $penjualan_januari25 - ($total_volume_penjualan_januari25 * $total_ton_rap);
	$persentase_laba_kotor_rap_januari25 = ($penjualan_januari25!=0)?($laba_kotor_rap_januari25 / $penjualan_januari25)  * 100:0;
	$persentase_laba_kotor_rap_januari25_fix = round($persentase_laba_kotor_rap_januari25,2);

	//FEBRUARI25
	$penjualan_februari25 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_februari25_awal' and '$date_februari25_akhir'")
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
	
	$total_penjualan_februari25 = 0;
	$total_volume_penjualan_februari25 = 0;

	foreach ($penjualan_februari25 as $x){
		$total_penjualan_februari25 += $x['price'];
		$total_volume_penjualan_februari25 += $x['volume'];
	}

	$penjualan_limbah_februari25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_februari25_awal' and '$date_februari25_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_februari25 = 0;

	foreach ($penjualan_limbah_februari25 as $x){
		$total_penjualan_limbah_februari25 += $x['price'];
	}

	$penjualan_lain_lain_februari25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_februari25_awal' and '$date_februari25_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_februari25 = 0;

	foreach ($penjualan_lain_lain_februari25 as $x){
		$total_penjualan_lain_lain_februari25 += $x['price'];
	}

	$akumulasi_bahan_jadi_februari25 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_februari25')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_januari25_akhir' and '$date_februari25_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_februari25 = $akumulasi_bahan_jadi_februari25['harsat_februari25'];

	$penjualan_februari25 = $total_penjualan_februari25 + $total_penjualan_limbah_februari25 + $total_penjualan_lain_lain_februari25;
	$beban_pokok_penjualan_februari25 = $total_volume_penjualan_februari25 * $harsat_bahan_jadi_februari25;
	$produksi_februari25 = $this->db->select('produksi')
	->from('kunci_bahan_jadi')
	->where("date between '$date_februari25_awal' and '$date_februari25_akhir'")
	->order_by('id','desc')->limit(1)
	->get()->row_array();
	$produksi_februari25 = $produksi_februari25['produksi'];
	$beban_pokok_penjualan_februari25 = $beban_pokok_penjualan_februari25 *$produksi_februari25;
	$laba_kotor_februari25 = $penjualan_februari25 - $beban_pokok_penjualan_februari25;
	
	$persentase_laba_kotor_februari25 = ($penjualan_februari25!=0)?($laba_kotor_februari25 / $penjualan_februari25) * 100:0;
	$persentase_laba_kotor_februari25_fix = round($persentase_laba_kotor_februari25,2);

	$laba_kotor_rap_februari25 = $penjualan_februari25 - ($total_volume_penjualan_februari25 * $total_ton_rap);
	$persentase_laba_kotor_rap_februari25 = ($penjualan_februari25!=0)?($laba_kotor_rap_februari25 / $penjualan_februari25)  * 100:0;
	$persentase_laba_kotor_rap_februari25_fix = round($persentase_laba_kotor_rap_februari25,2);

	//MARET25
	$penjualan_maret25 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_maret25_awal' and '$date_maret25_akhir'")
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
	
	$total_penjualan_maret25 = 0;
	$total_volume_penjualan_maret25 = 0;

	foreach ($penjualan_maret25 as $x){
		$total_penjualan_maret25 += $x['price'];
		$total_volume_penjualan_maret25 += $x['volume'];
	}

	$penjualan_limbah_maret25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_maret25_awal' and '$date_maret25_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_maret25 = 0;

	foreach ($penjualan_limbah_maret25 as $x){
		$total_penjualan_limbah_maret25 += $x['price'];
	}

	$penjualan_lain_lain_maret25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_maret25_awal' and '$date_maret25_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_maret25 = 0;

	foreach ($penjualan_lain_lain_maret25 as $x){
		$total_penjualan_lain_lain_maret25 += $x['price'];
	}

	$akumulasi_bahan_jadi_maret25 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_maret25')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_februari25_akhir' and '$date_maret25_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_maret25 = $akumulasi_bahan_jadi_maret25['harsat_maret25'];

	$penjualan_maret25 = $total_penjualan_maret25 + $total_penjualan_limbah_maret25 + $total_penjualan_lain_lain_maret25;
	$beban_pokok_penjualan_maret25 = $total_volume_penjualan_maret25 * $harsat_bahan_jadi_maret25;
	$produksi_maret25 = $this->db->select('produksi')
	->from('kunci_bahan_jadi')
	->where("date between '$date_maret25_awal' and '$date_maret25_akhir'")
	->order_by('id','desc')->limit(1)
	->get()->row_array();
	$produksi_maret25 = $produksi_maret25['produksi'];
	$beban_pokok_penjualan_maret25 = $beban_pokok_penjualan_maret25 *$produksi_maret25;
	$laba_kotor_maret25 = $penjualan_maret25 - $beban_pokok_penjualan_maret25;
	
	$persentase_laba_kotor_maret25 = ($penjualan_maret25!=0)?($laba_kotor_maret25 / $penjualan_maret25) * 100:0;
	$persentase_laba_kotor_maret25_fix = round($persentase_laba_kotor_maret25,2);

	$laba_kotor_rap_maret25 = $penjualan_maret25 - ($total_volume_penjualan_maret25 * $total_ton_rap);
	$persentase_laba_kotor_rap_maret25 = ($penjualan_maret25!=0)?($laba_kotor_rap_maret25 / $penjualan_maret25)  * 100:0;
	$persentase_laba_kotor_rap_maret25_fix = round($persentase_laba_kotor_rap_maret25,2);

	//APRIL25
	$penjualan_april25 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_april25_awal' and '$date_april25_akhir'")
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
	
	$total_penjualan_april25 = 0;
	$total_volume_penjualan_april25 = 0;

	foreach ($penjualan_april25 as $x){
		$total_penjualan_april25 += $x['price'];
		$total_volume_penjualan_april25 += $x['volume'];
	}

	$penjualan_limbah_april25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_april25_awal' and '$date_april25_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_april25 = 0;

	foreach ($penjualan_limbah_april25 as $x){
		$total_penjualan_limbah_april25 += $x['price'];
	}

	$penjualan_lain_lain_april25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_april25_awal' and '$date_april25_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_april25 = 0;

	foreach ($penjualan_lain_lain_april25 as $x){
		$total_penjualan_lain_lain_april25 += $x['price'];
	}

	$akumulasi_bahan_jadi_april25 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_april25')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_maret25_akhir' and '$date_april25_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_april25 = $akumulasi_bahan_jadi_april25['harsat_april25'];

	$penjualan_april25 = $total_penjualan_april25 + $total_penjualan_limbah_april25 + $total_penjualan_lain_lain_april25;
	$beban_pokok_penjualan_april25 = $total_volume_penjualan_april25 * $harsat_bahan_jadi_april25;
	$produksi_april25 = $this->db->select('produksi')
	->from('kunci_bahan_jadi')
	->where("date between '$date_april25_awal' and '$date_april25_akhir'")
	->order_by('id','desc')->limit(1)
	->get()->row_array();
	$produksi_april25 = $produksi_april25['produksi'];
	$beban_pokok_penjualan_april25 = $beban_pokok_penjualan_april25 *$produksi_april25;
	$laba_kotor_april25 = $penjualan_april25 - $beban_pokok_penjualan_april25;

	$persentase_laba_kotor_april25 = ($penjualan_april25!=0)?($laba_kotor_april25 / $penjualan_april25) * 100:0;
	$persentase_laba_kotor_april25_fix = round($persentase_laba_kotor_april25,2);

	$laba_kotor_rap_april25 = $penjualan_april25 - ($total_volume_penjualan_april25 * $total_ton_rap);
	$persentase_laba_kotor_rap_april25 = ($penjualan_april25!=0)?($laba_kotor_rap_april25 / $penjualan_april25)  * 100:0;
	$persentase_laba_kotor_rap_april25_fix = round($persentase_laba_kotor_rap_april25,2);

	//MEI25
	$penjualan_mei25 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_mei25_awal' and '$date_mei25_akhir'")
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
	
	$total_penjualan_mei25 = 0;
	$total_volume_penjualan_mei25 = 0;

	foreach ($penjualan_mei25 as $x){
		$total_penjualan_mei25 += $x['price'];
		$total_volume_penjualan_mei25 += $x['volume'];
	}

	$penjualan_limbah_mei25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_mei25_awal' and '$date_mei25_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_mei25 = 0;

	foreach ($penjualan_limbah_mei25 as $x){
		$total_penjualan_limbah_mei25 += $x['price'];
	}

	$penjualan_lain_lain_mei25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_mei25_awal' and '$date_mei25_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_mei25 = 0;

	foreach ($penjualan_lain_lain_mei25 as $x){
		$total_penjualan_lain_lain_mei25 += $x['price'];
	}

	$akumulasi_bahan_jadi_mei25 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_mei25')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_april25_akhir' and '$date_mei25_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_mei25 = $akumulasi_bahan_jadi_mei25['harsat_mei25'];

	$penjualan_mei25 = $total_penjualan_mei25 + $total_penjualan_limbah_mei25 + $total_penjualan_lain_lain_mei25;
	$beban_pokok_penjualan_mei25 = $total_volume_penjualan_mei25 * $harsat_bahan_jadi_mei25;
	$produksi_mei25 = $this->db->select('produksi')
	->from('kunci_bahan_jadi')
	->where("date between '$date_mei25_awal' and '$date_mei25_akhir'")
	->order_by('id','desc')->limit(1)
	->get()->row_array();
	$produksi_mei25 = $produksi_mei25['produksi'];
	$beban_pokok_penjualan_mei25 = $beban_pokok_penjualan_mei25 *$produksi_mei25;
	$laba_kotor_mei25 = $penjualan_mei25 - $beban_pokok_penjualan_mei25;
	
	$persentase_laba_kotor_mei25 = ($penjualan_mei25!=0)?($laba_kotor_mei25 / $penjualan_mei25) * 100:0;
	$persentase_laba_kotor_mei25_fix = round($persentase_laba_kotor_mei25,2);

	$laba_kotor_rap_mei25 = $penjualan_mei25 - ($total_volume_penjualan_mei25 * $total_ton_rap);
	$persentase_laba_kotor_rap_mei25 = ($penjualan_mei25!=0)?($laba_kotor_rap_mei25 / $penjualan_mei25)  * 100:0;
	$persentase_laba_kotor_rap_mei25_fix = round($persentase_laba_kotor_rap_mei25,2);

	//JUNI25
	$penjualan_juni25 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_juni25_awal' and '$date_juni25_akhir'")
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
	
	$total_penjualan_juni25 = 0;
	$total_volume_penjualan_juni25 = 0;

	foreach ($penjualan_juni25 as $x){
		$total_penjualan_juni25 += $x['price'];
		$total_volume_penjualan_juni25 += $x['volume'];
	}

	$penjualan_limbah_juni25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_juni25_awal' and '$date_juni25_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_juni25 = 0;

	foreach ($penjualan_limbah_juni25 as $x){
		$total_penjualan_limbah_juni25 += $x['price'];
	}

	$penjualan_lain_lain_juni25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_juni25_awal' and '$date_juni25_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_juni25 = 0;

	foreach ($penjualan_lain_lain_juni25 as $x){
		$total_penjualan_lain_lain_juni25 += $x['price'];
	}

	$akumulasi_bahan_jadi_juni25 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_juni25')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_mei25_akhir' and '$date_juni25_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_juni25 = $akumulasi_bahan_jadi_juni25['harsat_juni25'];

	$penjualan_juni25 = $total_penjualan_juni25 + $total_penjualan_limbah_juni25 + $total_penjualan_lain_lain_juni25;
	$beban_pokok_penjualan_juni25 = $total_volume_penjualan_juni25 * $harsat_bahan_jadi_juni25;
	$produksi_juni25 = $this->db->select('produksi')
	->from('kunci_bahan_jadi')
	->where("date between '$date_juni25_awal' and '$date_juni25_akhir'")
	->order_by('id','desc')->limit(1)
	->get()->row_array();
	$produksi_juni25 = $produksi_juni25['produksi'];
	$beban_pokok_penjualan_juni25 = $beban_pokok_penjualan_juni25 *$produksi_juni25;
	$laba_kotor_juni25 = $penjualan_juni25 - $beban_pokok_penjualan_juni25;
	
	$persentase_laba_kotor_juni25 = ($penjualan_juni25!=0)?($laba_kotor_juni25 / $penjualan_juni25) * 100:0;
	$persentase_laba_kotor_juni25_fix = round($persentase_laba_kotor_juni25,2);

	$laba_kotor_rap_juni25 = $penjualan_juni25 - ($total_volume_penjualan_juni25 * $total_ton_rap);
	$persentase_laba_kotor_rap_juni25 = ($penjualan_juni25!=0)?($laba_kotor_rap_juni25 / $penjualan_juni25)  * 100:0;
	$persentase_laba_kotor_rap_juni25_fix = round($persentase_laba_kotor_rap_juni25,2);

	//JULI25
	$penjualan_juli25 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_juli25_awal' and '$date_juli25_akhir'")
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
	
	$total_penjualan_juli25 = 0;
	$total_volume_penjualan_juli25 = 0;

	foreach ($penjualan_juli25 as $x){
		$total_penjualan_juli25 += $x['price'];
		$total_volume_penjualan_juli25 += $x['volume'];
	}

	$penjualan_limbah_juli25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_juli25_awal' and '$date_juli25_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_juli25 = 0;

	foreach ($penjualan_limbah_juli25 as $x){
		$total_penjualan_limbah_juli25 += $x['price'];
	}

	$penjualan_lain_lain_juli25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_juli25_awal' and '$date_juli25_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_juli25 = 0;

	foreach ($penjualan_lain_lain_juli25 as $x){
		$total_penjualan_lain_lain_juli25 += $x['price'];
	}

	$akumulasi_bahan_jadi_juli25 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_juli25')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_juni25_akhir' and '$date_juli25_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_juli25 = $akumulasi_bahan_jadi_juli25['harsat_juli25'];

	$penjualan_juli25 = $total_penjualan_juli25 + $total_penjualan_limbah_juli25 + $total_penjualan_lain_lain_juli25;
	$beban_pokok_penjualan_juli25 = $total_volume_penjualan_juli25 * $harsat_bahan_jadi_juli25;
	$produksi_juli25 = $this->db->select('produksi')
	->from('kunci_bahan_jadi')
	->where("date between '$date_juli25_awal' and '$date_juli25_akhir'")
	->order_by('id','desc')->limit(1)
	->get()->row_array();
	$produksi_juli25 = $produksi_juli25['produksi'];
	$beban_pokok_penjualan_juli25 = $beban_pokok_penjualan_juli25 *$produksi_juli25;
	$laba_kotor_juli25 = $penjualan_juli25 - $beban_pokok_penjualan_juli25;
	
	$persentase_laba_kotor_juli25 = ($penjualan_juli25!=0)?($laba_kotor_juli25 / $penjualan_juli25) * 100:0;
	$persentase_laba_kotor_juli25_fix = round($persentase_laba_kotor_juli25,2);

	$laba_kotor_rap_juli25 = $penjualan_juli25 - ($total_volume_penjualan_juli25 * $total_ton_rap);
	$persentase_laba_kotor_rap_juli25 = ($penjualan_juli25!=0)?($laba_kotor_rap_juli25 / $penjualan_juli25)  * 100:0;
	$persentase_laba_kotor_rap_juli25_fix = round($persentase_laba_kotor_rap_juli25,2);

	//AGUSTUS25
	$penjualan_agustus25 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_agustus25_awal' and '$date_agustus25_akhir'")
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
	
	$total_penjualan_agustus25 = 0;
	$total_volume_penjualan_agustus25 = 0;

	foreach ($penjualan_agustus25 as $x){
		$total_penjualan_agustus25 += $x['price'];
		$total_volume_penjualan_agustus25 += $x['volume'];
	}

	$penjualan_limbah_agustus25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_agustus25_awal' and '$date_agustus25_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_agustus25 = 0;

	foreach ($penjualan_limbah_agustus25 as $x){
		$total_penjualan_limbah_agustus25 += $x['price'];
	}

	$penjualan_lain_lain_agustus25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_agustus25_awal' and '$date_agustus25_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_agustus25 = 0;

	foreach ($penjualan_lain_lain_agustus25 as $x){
		$total_penjualan_lain_lain_agustus25 += $x['price'];
	}

	$akumulasi_bahan_jadi_agustus25 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_agustus25')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_juli25_akhir' and '$date_agustus25_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_agustus25 = $akumulasi_bahan_jadi_agustus25['harsat_agustus25'];

	$penjualan_agustus25 = $total_penjualan_agustus25 + $total_penjualan_limbah_agustus25 + $total_penjualan_lain_lain_agustus25;
	$beban_pokok_penjualan_agustus25 = $total_volume_penjualan_agustus25 * $harsat_bahan_jadi_agustus25;
	$produksi_agustus25 = $this->db->select('produksi')
	->from('kunci_bahan_jadi')
	->where("date between '$date_agustus25_awal' and '$date_agustus25_akhir'")
	->order_by('id','desc')->limit(1)
	->get()->row_array();
	$produksi_agustus25 = $produksi_agustus25['produksi'];
	$beban_pokok_penjualan_agustus25 = $beban_pokok_penjualan_agustus25 *$produksi_agustus25;
	$laba_kotor_agustus25 = $penjualan_agustus25 - $beban_pokok_penjualan_agustus25;
	
	$persentase_laba_kotor_agustus25 = ($penjualan_agustus25!=0)?($laba_kotor_agustus25 / $penjualan_agustus25) * 100:0;
	$persentase_laba_kotor_agustus25_fix = round($persentase_laba_kotor_agustus25,2);

	$laba_kotor_rap_agustus25 = $penjualan_agustus25 - ($total_volume_penjualan_agustus25 * $total_ton_rap);
	$persentase_laba_kotor_rap_agustus25 = ($penjualan_agustus25!=0)?($laba_kotor_rap_agustus25 / $penjualan_agustus25)  * 100:0;
	$persentase_laba_kotor_rap_agustus25_fix = round($persentase_laba_kotor_rap_agustus25,2);

	//SEPTEMBER25
	$penjualan_september25 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_september25_awal' and '$date_september25_akhir'")
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
	
	$total_penjualan_september25 = 0;
	$total_volume_penjualan_september25 = 0;

	foreach ($penjualan_september25 as $x){
		$total_penjualan_september25 += $x['price'];
		$total_volume_penjualan_september25 += $x['volume'];
	}

	$penjualan_limbah_september25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_september25_awal' and '$date_september25_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_september25 = 0;

	foreach ($penjualan_limbah_september25 as $x){
		$total_penjualan_limbah_september25 += $x['price'];
	}

	$penjualan_lain_lain_september25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_september25_awal' and '$date_september25_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_september25 = 0;

	foreach ($penjualan_lain_lain_september25 as $x){
		$total_penjualan_lain_lain_september25 += $x['price'];
	}

	$akumulasi_bahan_jadi_september25 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_september25')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_agustus25_akhir' and '$date_september25_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_september25 = $akumulasi_bahan_jadi_september25['harsat_september25'];

	$penjualan_september25 = $total_penjualan_september25 + $total_penjualan_limbah_september25 + $total_penjualan_lain_lain_september25;
	$beban_pokok_penjualan_september25 = $total_volume_penjualan_september25 * $harsat_bahan_jadi_september25;
	$produksi_september25 = $this->db->select('produksi')
	->from('kunci_bahan_jadi')
	->where("date between '$date_september25_awal' and '$date_september25_akhir'")
	->order_by('id','desc')->limit(1)
	->get()->row_array();
	$produksi_september25 = $produksi_september25['produksi'];
	$beban_pokok_penjualan_september25 = $beban_pokok_penjualan_september25 *$produksi_september25;
	$laba_kotor_september25 = $penjualan_september25 - $beban_pokok_penjualan_september25;

	$persentase_laba_kotor_september25 = ($penjualan_september25!=0)?($laba_kotor_september25 / $penjualan_september25) * 100:0;
	$persentase_laba_kotor_september25_fix = round($persentase_laba_kotor_september25,2);

	$laba_kotor_rap_september25 = $penjualan_september25 - ($total_volume_penjualan_september25 * $total_ton_rap);
	$persentase_laba_kotor_rap_september25 = ($penjualan_september25!=0)?($laba_kotor_rap_september25 / $penjualan_september25)  * 100:0;
	$persentase_laba_kotor_rap_september25_fix = round($persentase_laba_kotor_rap_september25,2);

	//OKTOBER25
	$penjualan_oktober25 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_oktober25_awal' and '$date_oktober25_akhir'")
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
	
	$total_penjualan_oktober25 = 0;
	$total_volume_penjualan_oktober25 = 0;

	foreach ($penjualan_oktober25 as $x){
		$total_penjualan_oktober25 += $x['price'];
		$total_volume_penjualan_oktober25 += $x['volume'];
	}

	$penjualan_limbah_oktober25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_oktober25_awal' and '$date_oktober25_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_oktober25 = 0;

	foreach ($penjualan_limbah_oktober25 as $x){
		$total_penjualan_limbah_oktober25 += $x['price'];
	}

	$penjualan_lain_lain_oktober25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_oktober25_awal' and '$date_oktober25_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_oktober25 = 0;

	foreach ($penjualan_lain_lain_oktober25 as $x){
		$total_penjualan_lain_lain_oktober25 += $x['price'];
	}

	$akumulasi_bahan_jadi_oktober25 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_oktober25')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_september25_akhir' and '$date_oktober25_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_oktober25 = $akumulasi_bahan_jadi_oktober25['harsat_oktober25'];

	$penjualan_oktober25 = $total_penjualan_oktober25 + $total_penjualan_limbah_oktober25 + $total_penjualan_lain_lain_oktober25;
	$beban_pokok_penjualan_oktober25 = $total_volume_penjualan_oktober25 * $harsat_bahan_jadi_oktober25;
	$produksi_oktober25 = $this->db->select('produksi')
	->from('kunci_bahan_jadi')
	->where("date between '$date_oktober25_awal' and '$date_oktober25_akhir'")
	->order_by('id','desc')->limit(1)
	->get()->row_array();
	$produksi_oktober25 = $produksi_oktober25['produksi'];
	$beban_pokok_penjualan_oktober25 = $beban_pokok_penjualan_oktober25 *$produksi_oktober25;
	$laba_kotor_oktober25 = $penjualan_oktober25 - $beban_pokok_penjualan_oktober25;

	$persentase_laba_kotor_oktober25 = ($penjualan_oktober25!=0)?($laba_kotor_oktober25 / $penjualan_oktober25) * 100:0;
	$persentase_laba_kotor_oktober25_fix = round($persentase_laba_kotor_oktober25,2);

	$laba_kotor_rap_oktober25 = $penjualan_oktober25 - ($total_volume_penjualan_oktober25 * $total_ton_rap);
	$persentase_laba_kotor_rap_oktober25 = ($penjualan_oktober25!=0)?($laba_kotor_rap_oktober25 / $penjualan_oktober25)  * 100:0;
	$persentase_laba_kotor_rap_oktober25_fix = round($persentase_laba_kotor_rap_oktober25,2);

	//NOVEMBER25
	$penjualan_november25 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_november25_awal' and '$date_november25_akhir'")
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
	
	$total_penjualan_november25 = 0;
	$total_volume_penjualan_november25 = 0;

	foreach ($penjualan_november25 as $x){
		$total_penjualan_november25 += $x['price'];
		$total_volume_penjualan_november25 += $x['volume'];
	}

	$penjualan_limbah_november25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_november25_awal' and '$date_november25_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_november25 = 0;

	foreach ($penjualan_limbah_november25 as $x){
		$total_penjualan_limbah_november25 += $x['price'];
	}

	$penjualan_lain_lain_november25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_november25_awal' and '$date_november25_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_november25 = 0;

	foreach ($penjualan_lain_lain_november25 as $x){
		$total_penjualan_lain_lain_november25 += $x['price'];
	}

	$akumulasi_bahan_jadi_november25 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_november25')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_oktober25_akhir' and '$date_november25_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_november25 = $akumulasi_bahan_jadi_november25['harsat_november25'];

	$penjualan_november25 = $total_penjualan_november25 + $total_penjualan_limbah_november25 + $total_penjualan_lain_lain_november25;
	$beban_pokok_penjualan_november25 = $total_volume_penjualan_november25 * $harsat_bahan_jadi_november25;
	$produksi_november25 = $this->db->select('produksi')
	->from('kunci_bahan_jadi')
	->where("date between '$date_november25_awal' and '$date_november25_akhir'")
	->order_by('id','desc')->limit(1)
	->get()->row_array();
	$produksi_november25 = $produksi_november25['produksi'];
	$beban_pokok_penjualan_november25 = $beban_pokok_penjualan_november25 *$produksi_november25;
	$laba_kotor_november25 = $penjualan_november25 - $beban_pokok_penjualan_november25;

	$persentase_laba_kotor_november25 = ($penjualan_november25!=0)?($laba_kotor_november25 / $penjualan_november25) * 100:0;
	$persentase_laba_kotor_november25_fix = round($persentase_laba_kotor_november25,2);

	$laba_kotor_rap_november25 = $penjualan_november25 - ($total_volume_penjualan_november25 * $total_ton_rap);
	$persentase_laba_kotor_rap_november25 = ($penjualan_november25!=0)?($laba_kotor_rap_november25 / $penjualan_november25)  * 100:0;
	$persentase_laba_kotor_rap_november25_fix = round($persentase_laba_kotor_rap_november25,2);

	//DESEMBER25
	$penjualan_desember25 = $this->db->select('SUM(pp.display_price) as price, SUM(pp.display_volume) as volume')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_desember25_awal' and '$date_desember25_akhir'")
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
	
	$total_penjualan_desember25 = 0;
	$total_volume_penjualan_desember25 = 0;

	foreach ($penjualan_desember25 as $x){
		$total_penjualan_desember25 += $x['price'];
		$total_volume_penjualan_desember25 += $x['volume'];
	}

	$penjualan_limbah_desember25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_desember25_awal' and '$date_desember25_akhir'")
	->where("pp.product_id in (9)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_limbah_desember25 = 0;

	foreach ($penjualan_limbah_desember25 as $x){
		$total_penjualan_limbah_desember25 += $x['price'];
	}

	$penjualan_lain_lain_desember25 = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
	->from('pmm_productions pp')
	->join('penerima p', 'pp.client_id = p.id','left')
	->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
	->where("pp.date_production between '$date_desember25_awal' and '$date_desember25_akhir'")
	->where("pp.salesPo_id in (536,532,537,533,534,535,546,542,547,543,548,538,544,549,539,545,541,530,531)")
	->where("ppo.status in ('OPEN','CLOSED')")
	->group_by('pp.salesPo_id')
	->get()->result_array();

	$total_penjualan_lain_lain_desember25 = 0;

	foreach ($penjualan_lain_lain_desember25 as $x){
		$total_penjualan_lain_lain_desember25 += $x['price'];
	}

	$akumulasi_bahan_jadi_desember25 = $this->db->select('(pp.nilai) / (pp.volume) as harsat_desember25')
	->from('kunci_bahan_jadi pp')
	->where("pp.date between '$date_november25_akhir' and '$date_desember25_akhir'")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$harsat_bahan_jadi_desember25 = $akumulasi_bahan_jadi_desember25['harsat_desember25'];

	$penjualan_desember25 = $total_penjualan_desember25 + $total_penjualan_limbah_desember25 + $total_penjualan_lain_lain_desember25;
	$beban_pokok_penjualan_desember25 = $total_volume_penjualan_desember25 * $harsat_bahan_jadi_desember25;
	$produksi_desember25 = $this->db->select('produksi')
	->from('kunci_bahan_jadi')
	->where("date between '$date_desember25_awal' and '$date_desember25_akhir'")
	->order_by('id','desc')->limit(1)
	->get()->row_array();
	$produksi_desember25 = $produksi_desember25['produksi'];
	$beban_pokok_penjualan_desember25 = $beban_pokok_penjualan_desember25 *$produksi_desember25;
	$laba_kotor_desember25 = $penjualan_desember25 - $beban_pokok_penjualan_desember25;

	$persentase_laba_kotor_desember25 = ($penjualan_desember25!=0)?($laba_kotor_desember25 / $penjualan_desember25) * 100:0;
	$persentase_laba_kotor_desember25_fix = round($persentase_laba_kotor_desember25,2);

	$laba_kotor_rap_desember25 = $penjualan_desember25 - ($total_volume_penjualan_desember25 * $total_ton_rap);
	$persentase_laba_kotor_rap_desember25 = ($penjualan_desember25!=0)?($laba_kotor_rap_desember25 / $penjualan_desember25)  * 100:0;
	$persentase_laba_kotor_rap_desember25_fix = round($persentase_laba_kotor_rap_desember25,2);
?>

<?php
	//JANUARI25
	$rekapitulasi_produksi_harian_januari25 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_januari25_awal' and '$date_januari25_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_januari25 = round($rekapitulasi_produksi_harian_januari25['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_januari25['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_januari25['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_januari25['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_januari25['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_januari25['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_januari25 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_januari25,2);
	$nilai_rap_bahan_januari25_fix = round($nilai_rap_bahan_januari25 / 1000000,0);

	$date1_ago_januari25 = date('2020-01-01');
	$date2_ago_januari25 = date('Y-m-d', strtotime('-1 days', strtotime($date_januari25_awal)));
	$date3_ago_januari25 = date('Y-m-d', strtotime('-1 months', strtotime($date_januari25_awal)));
	$tanggal_opening_balance_januari25 = date('Y-m-d', strtotime('-1 days', strtotime($date_januari25_awal)));

	$stock_opname_batu_boulder_ago_januari25 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_januari25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_januari25 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_januari25' and '$date2_ago_januari25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_januari25 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_januari25_awal' and '$date_januari25_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_januari25 = ($harga_boulder_januari25['nilai_boulder'] + $pembelian_boulder_januari25['nilai']) / (round($stock_opname_batu_boulder_ago_januari25['volume'],2) + round($pembelian_boulder_januari25['volume'],2));
	$total_nilai_produksi_boulder_januari25 = $total_rekapitulasi_produksi_harian_januari25 * $harga_baru_januari25;
	$total_nilai_produksi_boulder_januari25_fix = round($total_nilai_produksi_boulder_januari25 / 1000000,0);

	//FEBRUARI25
	$rekapitulasi_produksi_harian_februari25 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_februari25_awal' and '$date_februari25_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_februari25 = round($rekapitulasi_produksi_harian_februari25['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_februari25['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_februari25['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_februari25['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_februari25['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_februari25['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_februari25 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_februari25,2);
	$nilai_rap_bahan_februari25_fix = round($nilai_rap_bahan_februari25 / 1000000,0);

	$date1_ago_februari25 = date('2020-01-01');
	$date2_ago_februari25 = date('Y-m-d', strtotime('-1 days', strtotime($date_februari25_awal)));
	$date3_ago_februari25 = date('Y-m-d', strtotime('-1 months', strtotime($date_februari25_awal)));
	$tanggal_opening_balance_februari25 = date('Y-m-d', strtotime('-1 days', strtotime($date_februari25_awal)));

	$stock_opname_batu_boulder_ago_februari25 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_februari25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_februari25 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_februari25' and '$date2_ago_februari25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_februari25 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_februari25_awal' and '$date_februari25_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_februari25 = ($harga_boulder_februari25['nilai_boulder'] + $pembelian_boulder_februari25['nilai']) / (round($stock_opname_batu_boulder_ago_februari25['volume'],2) + round($pembelian_boulder_februari25['volume'],2));
	$total_nilai_produksi_boulder_februari25 = $total_rekapitulasi_produksi_harian_februari25 * $harga_baru_februari25;
	$total_nilai_produksi_boulder_februari25_fix = round($total_nilai_produksi_boulder_februari25 / 1000000,0);

	//MARET25
	$rekapitulasi_produksi_harian_maret25 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_maret25_awal' and '$date_maret25_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_maret25 = round($rekapitulasi_produksi_harian_maret25['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_maret25['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_maret25['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_maret25['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_maret25['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_maret25['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_maret25 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_maret25,2);
	$nilai_rap_bahan_maret25_fix = round($nilai_rap_bahan_maret25 / 1000000,0);

	$date1_ago_maret25 = date('2020-01-01');
	$date2_ago_maret25 = date('Y-m-d', strtotime('-1 days', strtotime($date_maret25_awal)));
	$date3_ago_maret25 = date('Y-m-d', strtotime('-1 months', strtotime($date_maret25_awal)));
	$tanggal_opening_balance_maret25 = date('Y-m-d', strtotime('-1 days', strtotime($date_maret25_awal)));

	$stock_opname_batu_boulder_ago_maret25 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_maret25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_maret25 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_maret25' and '$date2_ago_maret25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_maret25 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_maret25_awal' and '$date_maret25_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_maret25 = ($harga_boulder_maret25['nilai_boulder'] + $pembelian_boulder_maret25['nilai']) / (round($stock_opname_batu_boulder_ago_maret25['volume'],2) + round($pembelian_boulder_maret25['volume'],2));
	$total_nilai_produksi_boulder_maret25 = $total_rekapitulasi_produksi_harian_maret25 * $harga_baru_maret25;
	$total_nilai_produksi_boulder_maret25_fix = round($total_nilai_produksi_boulder_maret25 / 1000000,0);

	//APRIL25
	$rekapitulasi_produksi_harian_april25 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_april25_awal' and '$date_april25_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_april25 = round($rekapitulasi_produksi_harian_april25['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_april25['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_april25['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_april25['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_april25['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_april25['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_april25 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_april25,2);
	$nilai_rap_bahan_april25_fix = round($nilai_rap_bahan_april25 / 1000000,0);

	$date1_ago_april25 = date('2020-01-01');
	$date2_ago_april25 = date('Y-m-d', strtotime('-1 days', strtotime($date_april25_awal)));
	$date3_ago_april25 = date('Y-m-d', strtotime('-1 months', strtotime($date_april25_awal)));
	$tanggal_opening_balance_april25 = date('Y-m-d', strtotime('-1 days', strtotime($date_april25_awal)));

	$stock_opname_batu_boulder_ago_april25 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_april25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_april25 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_april25' and '$date2_ago_april25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_april25 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_april25_awal' and '$date_april25_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_april25 = ($harga_boulder_april25['nilai_boulder'] + $pembelian_boulder_april25['nilai']) / (round($stock_opname_batu_boulder_ago_april25['volume'],2) + round($pembelian_boulder_april25['volume'],2));
	$total_nilai_produksi_boulder_april25 = $total_rekapitulasi_produksi_harian_april25 * $harga_baru_april25;
	$total_nilai_produksi_boulder_april25_fix = round($total_nilai_produksi_boulder_april25 / 1000000,0);

	//MEI25
	$rekapitulasi_produksi_harian_mei25 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_mei25_awal' and '$date_mei25_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_mei25 = round($rekapitulasi_produksi_harian_mei25['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_mei25['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_mei25['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_mei25['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_mei25['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_mei25['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_mei25 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_mei25,2);
	$nilai_rap_bahan_mei25_fix = round($nilai_rap_bahan_mei25 / 1000000,0);

	$date1_ago_mei25 = date('2020-01-01');
	$date2_ago_mei25 = date('Y-m-d', strtotime('-1 days', strtotime($date_mei25_awal)));
	$date3_ago_mei25 = date('Y-m-d', strtotime('-1 months', strtotime($date_mei25_awal)));
	$tanggal_opening_balance_mei25 = date('Y-m-d', strtotime('-1 days', strtotime($date_mei25_awal)));

	$stock_opname_batu_boulder_ago_mei25 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_mei25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_mei25 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_mei25' and '$date2_ago_mei25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_mei25 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_mei25_awal' and '$date_mei25_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_mei25 = ($harga_boulder_mei25['nilai_boulder'] + $pembelian_boulder_mei25['nilai']) / (round($stock_opname_batu_boulder_ago_mei25['volume'],2) + round($pembelian_boulder_mei25['volume'],2));
	$total_nilai_produksi_boulder_mei25 = $total_rekapitulasi_produksi_harian_mei25 * $harga_baru_mei25;
	$total_nilai_produksi_boulder_mei25_fix = round($total_nilai_produksi_boulder_mei25 / 1000000,0);

	//JUNI25
	$rekapitulasi_produksi_harian_juni25 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_juni25_awal' and '$date_juni25_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_juni25 = round($rekapitulasi_produksi_harian_juni25['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_juni25['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_juni25['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_juni25['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_juni25['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_juni25['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_juni25 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_juni25,2);
	$nilai_rap_bahan_juni25_fix = round($nilai_rap_bahan_juni25 / 1000000,0);

	$date1_ago_juni25 = date('2020-01-01');
	$date2_ago_juni25 = date('Y-m-d', strtotime('-1 days', strtotime($date_juni25_awal)));
	$date3_ago_juni25 = date('Y-m-d', strtotime('-1 months', strtotime($date_juni25_awal)));
	$tanggal_opening_balance_juni25 = date('Y-m-d', strtotime('-1 days', strtotime($date_juni25_awal)));

	$stock_opname_batu_boulder_ago_juni25 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_juni25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_juni25 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_juni25' and '$date2_ago_juni25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_juni25 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_juni25_awal' and '$date_juni25_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_juni25 = ($harga_boulder_juni25['nilai_boulder'] + $pembelian_boulder_juni25['nilai']) / (round($stock_opname_batu_boulder_ago_juni25['volume'],2) + round($pembelian_boulder_juni25['volume'],2));
	$total_nilai_produksi_boulder_juni25 = $total_rekapitulasi_produksi_harian_juni25 * $harga_baru_juni25;
	$total_nilai_produksi_boulder_juni25_fix = round($total_nilai_produksi_boulder_juni25 / 1000000,0);

	//JULI25
	$rekapitulasi_produksi_harian_juli25 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_juli25_awal' and '$date_juli25_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_juli25 = round($rekapitulasi_produksi_harian_juli25['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_juli25['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_juli25['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_juli25['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_juli25['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_juli25['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_juli25 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_juli25,2);
	$nilai_rap_bahan_juli25_fix = round($nilai_rap_bahan_juli25 / 1000000,0);

	$date1_ago_juli25 = date('2020-01-01');
	$date2_ago_juli25 = date('Y-m-d', strtotime('-1 days', strtotime($date_juli25_awal)));
	$date3_ago_juli25 = date('Y-m-d', strtotime('-1 months', strtotime($date_juli25_awal)));
	$tanggal_opening_balance_juli25 = date('Y-m-d', strtotime('-1 days', strtotime($date_juli25_awal)));

	$stock_opname_batu_boulder_ago_juli25 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_juli25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_juli25 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_juli25' and '$date2_ago_juli25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_juli25 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_juli25_awal' and '$date_juli25_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_juli25 = ($harga_boulder_juli25['nilai_boulder'] + $pembelian_boulder_juli25['nilai']) / (round($stock_opname_batu_boulder_ago_juli25['volume'],2) + round($pembelian_boulder_juli25['volume'],2));
	$total_nilai_produksi_boulder_juli25 = $total_rekapitulasi_produksi_harian_juli25 * $harga_baru_juli25;
	$total_nilai_produksi_boulder_juli25_fix = round($total_nilai_produksi_boulder_juli25 / 1000000,0);

	//AGUSTUS25
	$rekapitulasi_produksi_harian_agustus25 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_agustus25 = round($rekapitulasi_produksi_harian_agustus25['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_agustus25['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_agustus25['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_agustus25['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_agustus25['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_agustus25['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_agustus25 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_agustus25,2);
	$nilai_rap_bahan_agustus25_fix = round($nilai_rap_bahan_agustus25 / 1000000,0);

	$date1_ago_agustus25 = date('2020-01-01');
	$date2_ago_agustus25 = date('Y-m-d', strtotime('-1 days', strtotime($date_agustus25_awal)));
	$date3_ago_agustus25 = date('Y-m-d', strtotime('-1 months', strtotime($date_agustus25_awal)));
	$tanggal_opening_balance_agustus25 = date('Y-m-d', strtotime('-1 days', strtotime($date_agustus25_awal)));

	$stock_opname_batu_boulder_ago_agustus25 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_agustus25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_boulder_agustus25 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_agustus25' and '$date2_ago_agustus25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_agustus25 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_agustus25_awal' and '$date_agustus25_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();
	
	$harga_baru_agustus25 = ($harga_boulder_agustus25['nilai_boulder'] + $pembelian_boulder_agustus25['nilai']) / (round($stock_opname_batu_boulder_ago_agustus25['volume'],2) + round($pembelian_boulder_agustus25['volume'],2));
	$total_nilai_produksi_boulder_agustus25 = $total_rekapitulasi_produksi_harian_agustus25 * $harga_baru_agustus25;
	$total_nilai_produksi_boulder_agustus25_fix = round($total_nilai_produksi_boulder_agustus25 / 1000000,0);

	//SEPTEMBER25
	$rekapitulasi_produksi_harian_september25 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_september25_awal' and '$date_september25_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_september25 = round($rekapitulasi_produksi_harian_september25['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_september25['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_september25['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_september25['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_september25['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_september25['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_september25 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_september25,2);
	$nilai_rap_bahan_september25_fix = round($nilai_rap_bahan_september25 / 1000000,0);

	$date1_ago_september25 = date('2020-01-01');
	$date2_ago_september25 = date('Y-m-d', strtotime('-1 days', strtotime($date_september25_awal)));
	$date3_ago_september25 = date('Y-m-d', strtotime('-1 months', strtotime($date_september25_awal)));
	$tanggal_opening_balance_september25 = date('Y-m-d', strtotime('-1 days', strtotime($date_september25_awal)));

	$stock_opname_batu_boulder_ago_september25 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_september25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$harga_boulder_september25 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_september25' and '$date2_ago_september25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_september25 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_september25_awal' and '$date_september25_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();

	$harga_baru_september25 = ($harga_boulder_september25['nilai_boulder'] + $pembelian_boulder_september25['nilai']) / (round($stock_opname_batu_boulder_ago_september25['volume'],2) + round($pembelian_boulder_september25['volume'],2));
	$total_nilai_produksi_boulder_september25 = $total_rekapitulasi_produksi_harian_september25 * $harga_baru_september25;
	$total_nilai_produksi_boulder_september25_fix = round($total_nilai_produksi_boulder_september25 / 1000000,0);

	//OKTOBER25
	$rekapitulasi_produksi_harian_oktober25 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_oktober25 = round($rekapitulasi_produksi_harian_oktober25['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_oktober25['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_oktober25['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_oktober25['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_oktober25['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_oktober25['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_oktober25 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_oktober25,2);
	$nilai_rap_bahan_oktober25_fix = round($nilai_rap_bahan_oktober25 / 1000000,0);

	$date1_ago_oktober25 = date('2020-01-01');
	$date2_ago_oktober25 = date('Y-m-d', strtotime('-1 days', strtotime($date_oktober25_awal)));
	$date3_ago_oktober25 = date('Y-m-d', strtotime('-1 months', strtotime($date_oktober25_awal)));
	$tanggal_opening_balance_oktober25 = date('Y-m-d', strtotime('-1 days', strtotime($date_oktober25_awal)));

	$stock_opname_batu_boulder_ago_oktober25 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_oktober25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$harga_boulder_oktober25 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_oktober25' and '$date2_ago_oktober25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_oktober25 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_oktober25_awal' and '$date_oktober25_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();

	$harga_baru_oktober25 = ($harga_boulder_oktober25['nilai_boulder'] + $pembelian_boulder_oktober25['nilai']) / (round($stock_opname_batu_boulder_ago_oktober25['volume'],2) + round($pembelian_boulder_oktober25['volume'],2));
	$total_nilai_produksi_boulder_oktober25 = $total_rekapitulasi_produksi_harian_oktober25 * $harga_baru_oktober25;
	$total_nilai_produksi_boulder_oktober25_fix = round($total_nilai_produksi_boulder_oktober25 / 1000000,0);

	//NOVEMBER25
	$rekapitulasi_produksi_harian_november25 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_november25_awal' and '$date_november25_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_november25 = round($rekapitulasi_produksi_harian_november25['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_november25['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_november25['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_november25['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_november25['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_november25['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_november25 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_november25,2);
	$nilai_rap_bahan_november25_fix = round($nilai_rap_bahan_november25 / 1000000,0);

	$date1_ago_november25 = date('2020-01-01');
	$date2_ago_november25 = date('Y-m-d', strtotime('-1 days', strtotime($date_november25_awal)));
	$date3_ago_november25 = date('Y-m-d', strtotime('-1 months', strtotime($date_november25_awal)));
	$tanggal_opening_balance_november25 = date('Y-m-d', strtotime('-1 days', strtotime($date_november25_awal)));

	$stock_opname_batu_boulder_ago_november25 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_november25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$harga_boulder_november25 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_november25' and '$date2_ago_november25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_november25 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_november25_awal' and '$date_november25_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();

	$harga_baru_november25 = ($harga_boulder_november25['nilai_boulder'] + $pembelian_boulder_november25['nilai']) / (round($stock_opname_batu_boulder_ago_november25['volume'],2) + round($pembelian_boulder_november25['volume'],2));
	$total_nilai_produksi_boulder_november25 = $total_rekapitulasi_produksi_harian_november25 * $harga_baru_november25;
	$total_nilai_produksi_boulder_november25_fix = round($total_nilai_produksi_boulder_november25 / 1000000,0);

	//DESEMBER25
	$rekapitulasi_produksi_harian_desember25 = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
	->from('pmm_produksi_harian pph ')
	->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
	->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
	->where("(pph.date_prod between '$date_desember25_awal' and '$date_desember25_akhir')")
	->where('pph.status','PUBLISH')
	->get()->row_array();
	$total_rekapitulasi_produksi_harian_desember25 = round($rekapitulasi_produksi_harian_desember25['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian_desember25['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian_desember25['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian_desember25['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian_desember25['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian_desember25['jumlah_pemakaian_f'],2);

	$nilai_rap_bahan_desember25 = $nilai_boulder_ton * round($total_rekapitulasi_produksi_harian_desember25,2);
	$nilai_rap_bahan_desember25_fix = round($nilai_rap_bahan_desember25 / 1000000,0);

	$date1_ago_desember25 = date('2020-01-01');
	$date2_ago_desember25 = date('Y-m-d', strtotime('-1 days', strtotime($date_desember25_awal)));
	$date3_ago_desember25 = date('Y-m-d', strtotime('-1 months', strtotime($date_desember25_awal)));
	$tanggal_opening_balance_desember25 = date('Y-m-d', strtotime('-1 days', strtotime($date_desember25_awal)));

	$stock_opname_batu_boulder_ago_desember25 = $this->db->select('pp.vol_nilai_boulder as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_desember25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$harga_boulder_desember25 = $this->db->select('pp.nilai_boulder as nilai_boulder')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_desember25' and '$date2_ago_desember25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_boulder_desember25 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_desember25_awal' and '$date_desember25_akhir'")
	->where("prm.material_id = 15")
	->group_by('prm.material_id')
	->get()->row_array();

	$harga_baru_desember25 = ($harga_boulder_desember25['nilai_boulder'] + $pembelian_boulder_desember25['nilai']) / (round($stock_opname_batu_boulder_ago_desember25['volume'],2) + round($pembelian_boulder_desember25['volume'],2));
	$total_nilai_produksi_boulder_desember25 = $total_rekapitulasi_produksi_harian_desember25 * $harga_baru_desember25;
	$total_nilai_produksi_boulder_desember25_fix = round($total_nilai_produksi_boulder_desember25 / 1000000,0);
	?>

	<?php
	//JANUARI25
	$vol_rap_alat_januari25 = $total_rekapitulasi_produksi_harian_januari25;
	$nilai_rap_alat_januari25 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_januari25,2);
	$nilai_rap_alat_januari25_fix = round($nilai_rap_alat_januari25 / 1000000,0);

	$stone_crusher_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$stone_crusher_januari25 = $stone_crusher_biaya_januari25['total'] + $stone_crusher_jurnal_januari25['total'];
	
	$whell_loader_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$whell_loader_januari25 = $whell_loader_biaya_januari25['total'] + $whell_loader_jurnal_januari25['total'];
	
	$genset_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$genset_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$genset_januari25 = $genset_biaya_januari25['total'] + $genset_jurnal_januari25['total'];
	
	$timbangan_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$timbangan_januari25 = $timbangan_biaya_januari25['total'] + $timbangan_biaya_jurnal_januari25['total'];
	
	$tangki_solar_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$tangki_solar_januari25 = $tangki_solar_biaya_januari25['total'] + $tangki_solar_jurnal_januari25['total'];		
	
	$total_biaya_peralatan_januari25 = $stone_crusher_januari25 + $whell_loader_januari25 + $genset_januari25 + $timbangan_januari25 + $tangki_solar_januari25;

	//Opening Balance
	$date1_ago_januari25 = date('2020-01-01');
	$date2_ago_januari25 = date('Y-m-d', strtotime('-1 days', strtotime($date_januari25_awal)));
	$date3_ago_januari25 = date('Y-m-d', strtotime('-1 months', strtotime($date_januari25_awal)));
	$tanggal_opening_balance_januari25 = date('Y-m-d', strtotime('-1 days', strtotime($date_januari25_awal)));

	$stock_opname_bbm_ago_januari25 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_januari25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_januari25 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_januari25' and '$date2_ago_januari25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_januari25 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_januari25_awal' and '$date_januari25_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_januari25 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_januari25_awal' and '$date_januari25_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_januari25 = $pemakaian_bbm_januari25['volume'];
	$nilai_pemakaian_bbm_januari25 = $pemakaian_bbm_januari25['nilai'];

	$nilai_bbm_non_produksi_januari25 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_januari25 = $nilai_bbm_non_produksi_januari25['memo'];
	$nilai_bbm_non_produksi_januari25 = $nilai_bbm_non_produksi_januari25['total'];
	$total_nilai_produksi_solar_januari25 = $nilai_pemakaian_bbm_januari25 + $nilai_bbm_non_produksi_januari25;

	$nilai_realisasi_alat_januari25 = $total_biaya_peralatan_januari25 + $total_nilai_produksi_solar_januari25;
	$nilai_realisasi_alat_januari25_fix = round($nilai_realisasi_alat_januari25 / 1000000,0);

	//FEBRUARI25
	$vol_rap_alat_februari25 = $total_rekapitulasi_produksi_harian_februari25;
	$nilai_rap_alat_februari25 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_februari25,2);
	$nilai_rap_alat_februari25_fix = round($nilai_rap_alat_februari25 / 1000000,0);

	$stone_crusher_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$stone_crusher_februari25 = $stone_crusher_biaya_februari25['total'] + $stone_crusher_jurnal_februari25['total'];
	
	$whell_loader_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$whell_loader_februari25 = $whell_loader_biaya_februari25['total'] + $whell_loader_jurnal_februari25['total'];
	
	$genset_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$genset_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$genset_februari25 = $genset_biaya_februari25['total'] + $genset_jurnal_februari25['total'];
	
	$timbangan_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$timbangan_februari25 = $timbangan_biaya_februari25['total'] + $timbangan_biaya_jurnal_februari25['total'];
	
	$tangki_solar_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$tangki_solar_februari25 = $tangki_solar_biaya_februari25['total'] + $tangki_solar_jurnal_februari25['total'];		
	
	$total_biaya_peralatan_februari25 = $stone_crusher_februari25 + $whell_loader_februari25 + $genset_februari25 + $timbangan_februari25 + $tangki_solar_februari25;

	//Opening Balance
	$date1_ago_februari25 = date('2020-01-01');
	$date2_ago_februari25 = date('Y-m-d', strtotime('-1 days', strtotime($date_februari25_awal)));
	$date3_ago_februari25 = date('Y-m-d', strtotime('-1 months', strtotime($date_februari25_awal)));
	$tanggal_opening_balance_februari25 = date('Y-m-d', strtotime('-1 days', strtotime($date_februari25_awal)));

	$stock_opname_bbm_ago_februari25 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_februari25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_februari25 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_februari25' and '$date2_ago_februari25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_februari25 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_februari25_awal' and '$date_februari25_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_februari25 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_februari25_awal' and '$date_februari25_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_februari25 = $pemakaian_bbm_februari25['volume'];
	$nilai_pemakaian_bbm_februari25 = $pemakaian_bbm_februari25['nilai'];

	$nilai_bbm_non_produksi_februari25 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_februari25 = $nilai_bbm_non_produksi_februari25['memo'];
	$nilai_bbm_non_produksi_februari25 = $nilai_bbm_non_produksi_februari25['total'];
	$total_nilai_produksi_solar_februari25 = $nilai_pemakaian_bbm_februari25 + $nilai_bbm_non_produksi_februari25;

	$nilai_realisasi_alat_februari25 = $total_biaya_peralatan_februari25 + $total_nilai_produksi_solar_februari25;
	$nilai_realisasi_alat_februari25_fix = round($nilai_realisasi_alat_februari25 / 1000000,0);

	//MARET25
	$vol_rap_alat_maret25 = $total_rekapitulasi_produksi_harian_maret25;
	$nilai_rap_alat_maret25 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_maret25,2);
	$nilai_rap_alat_maret25_fix = round($nilai_rap_alat_maret25 / 1000000,0);

	$stone_crusher_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$stone_crusher_maret25 = $stone_crusher_biaya_maret25['total'] + $stone_crusher_jurnal_maret25['total'];
	
	$whell_loader_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$whell_loader_maret25 = $whell_loader_biaya_maret25['total'] + $whell_loader_jurnal_maret25['total'];
	
	$genset_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$genset_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$genset_maret25 = $genset_biaya_maret25['total'] + $genset_jurnal_maret25['total'];
	
	$timbangan_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$timbangan_maret25 = $timbangan_biaya_maret25['total'] + $timbangan_biaya_jurnal_maret25['total'];
	
	$tangki_solar_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$tangki_solar_maret25 = $tangki_solar_biaya_maret25['total'] + $tangki_solar_jurnal_maret25['total'];		
	
	$total_biaya_peralatan_maret25 = $stone_crusher_maret25 + $whell_loader_maret25 + $genset_maret25 + $timbangan_maret25 + $tangki_solar_maret25;

	//Opening Balance
	$date1_ago_maret25 = date('2020-01-01');
	$date2_ago_maret25 = date('Y-m-d', strtotime('-1 days', strtotime($date_maret25_awal)));
	$date3_ago_maret25 = date('Y-m-d', strtotime('-1 months', strtotime($date_maret25_awal)));
	$tanggal_opening_balance_maret25 = date('Y-m-d', strtotime('-1 days', strtotime($date_maret25_awal)));

	$stock_opname_bbm_ago_maret25 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_maret25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_maret25 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_maret25' and '$date2_ago_maret25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_maret25 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_maret25_awal' and '$date_maret25_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_maret25 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_maret25_awal' and '$date_maret25_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_maret25 = $pemakaian_bbm_maret25['volume'];
	$nilai_pemakaian_bbm_maret25 = $pemakaian_bbm_maret25['nilai'];

	$nilai_bbm_non_produksi_maret25 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_maret25 = $nilai_bbm_non_produksi_maret25['memo'];
	$nilai_bbm_non_produksi_maret25 = $nilai_bbm_non_produksi_maret25['total'];
	$total_nilai_produksi_solar_maret25 = $nilai_pemakaian_bbm_maret25 + $nilai_bbm_non_produksi_maret25;

	$nilai_realisasi_alat_maret25 = $total_biaya_peralatan_maret25 + $total_nilai_produksi_solar_maret25;
	$nilai_realisasi_alat_maret25_fix = round($nilai_realisasi_alat_maret25 / 1000000,0);

	//APRIL25
	$vol_rap_alat_april25 = $total_rekapitulasi_produksi_harian_april25;
	$nilai_rap_alat_april25 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_april25,2);
	$nilai_rap_alat_april25_fix = round($nilai_rap_alat_april25 / 1000000,0);

	$stone_crusher_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$stone_crusher_april25 = $stone_crusher_biaya_april25['total'] + $stone_crusher_jurnal_april25['total'];
	
	$whell_loader_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$whell_loader_april25 = $whell_loader_biaya_april25['total'] + $whell_loader_jurnal_april25['total'];
	
	$genset_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$genset_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$genset_april25 = $genset_biaya_april25['total'] + $genset_jurnal_april25['total'];
	
	$timbangan_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$timbangan_april25 = $timbangan_biaya_april25['total'] + $timbangan_biaya_jurnal_april25['total'];
	
	$tangki_solar_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$tangki_solar_april25 = $tangki_solar_biaya_april25['total'] + $tangki_solar_jurnal_april25['total'];		
	
	$total_biaya_peralatan_april25 = $stone_crusher_april25 + $whell_loader_april25 + $genset_april25 + $timbangan_april25 + $tangki_solar_april25;

	//Opening Balance
	$date1_ago_april25 = date('2020-01-01');
	$date2_ago_april25 = date('Y-m-d', strtotime('-1 days', strtotime($date_april25_awal)));
	$date3_ago_april25 = date('Y-m-d', strtotime('-1 months', strtotime($date_april25_awal)));
	$tanggal_opening_balance_april25 = date('Y-m-d', strtotime('-1 days', strtotime($date_april25_awal)));

	$stock_opname_bbm_ago_april25 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_april25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_april25 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_april25' and '$date2_ago_april25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_april25 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_april25_awal' and '$date_april25_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_april25 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_april25_awal' and '$date_april25_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_april25 = $pemakaian_bbm_april25['volume'];
	$nilai_pemakaian_bbm_april25 = $pemakaian_bbm_april25['nilai'];

	$nilai_bbm_non_produksi_april25 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_april25 = $nilai_bbm_non_produksi_april25['memo'];
	$nilai_bbm_non_produksi_april25 = $nilai_bbm_non_produksi_april25['total'];
	$total_nilai_produksi_solar_april25 = $nilai_pemakaian_bbm_april25 + $nilai_bbm_non_produksi_april25;

	$nilai_realisasi_alat_april25 = $total_biaya_peralatan_april25 + $total_nilai_produksi_solar_april25;
	$nilai_realisasi_alat_april25_fix = round($nilai_realisasi_alat_april25 / 1000000,0);

	//MEI25
	$vol_rap_alat_mei25 = $total_rekapitulasi_produksi_harian_mei25;
	$nilai_rap_alat_mei25 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_mei25,2);
	$nilai_rap_alat_mei25_fix = round($nilai_rap_alat_mei25 / 1000000,0);

	$stone_crusher_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$stone_crusher_mei25 = $stone_crusher_biaya_mei25['total'] + $stone_crusher_jurnal_mei25['total'];
	
	$whell_loader_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$whell_loader_mei25 = $whell_loader_biaya_mei25['total'] + $whell_loader_jurnal_mei25['total'];
	
	$genset_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$genset_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$genset_mei25 = $genset_biaya_mei25['total'] + $genset_jurnal_mei25['total'];
	
	$timbangan_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$timbangan_mei25 = $timbangan_biaya_mei25['total'] + $timbangan_biaya_jurnal_mei25['total'];
	
	$tangki_solar_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$tangki_solar_mei25 = $tangki_solar_biaya_mei25['total'] + $tangki_solar_jurnal_mei25['total'];		
	
	$total_biaya_peralatan_mei25 = $stone_crusher_mei25 + $whell_loader_mei25 + $genset_mei25 + $timbangan_mei25 + $tangki_solar_mei25;

	//Opening Balance
	$date1_ago_mei25 = date('2020-01-01');
	$date2_ago_mei25 = date('Y-m-d', strtotime('-1 days', strtotime($date_mei25_awal)));
	$date3_ago_mei25 = date('Y-m-d', strtotime('-1 months', strtotime($date_mei25_awal)));
	$tanggal_opening_balance_mei25 = date('Y-m-d', strtotime('-1 days', strtotime($date_mei25_awal)));

	$stock_opname_bbm_ago_mei25 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_mei25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_mei25 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_mei25' and '$date2_ago_mei25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_mei25 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_mei25_awal' and '$date_mei25_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_mei25 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_mei25_awal' and '$date_mei25_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_mei25 = $pemakaian_bbm_mei25['volume'];
	$nilai_pemakaian_bbm_mei25 = $pemakaian_bbm_mei25['nilai'];

	$nilai_bbm_non_produksi_mei25 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_mei25 = $nilai_bbm_non_produksi_mei25['memo'];
	$nilai_bbm_non_produksi_mei25 = $nilai_bbm_non_produksi_mei25['total'];
	$total_nilai_produksi_solar_mei25 = $nilai_pemakaian_bbm_mei25 + $nilai_bbm_non_produksi_mei25;

	$nilai_realisasi_alat_mei25 = $total_biaya_peralatan_mei25 + $total_nilai_produksi_solar_mei25;
	$nilai_realisasi_alat_mei25_fix = round($nilai_realisasi_alat_mei25 / 1000000,0);

	//JUNI25
	$vol_rap_alat_juni25 = $total_rekapitulasi_produksi_harian_juni25;
	$nilai_rap_alat_juni25 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_juni25,2);
	$nilai_rap_alat_juni25_fix = round($nilai_rap_alat_juni25 / 1000000,0);

	$stone_crusher_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$stone_crusher_juni25 = $stone_crusher_biaya_juni25['total'] + $stone_crusher_jurnal_juni25['total'];
	
	$whell_loader_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$whell_loader_juni25 = $whell_loader_biaya_juni25['total'] + $whell_loader_jurnal_juni25['total'];
	
	$genset_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$genset_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$genset_juni25 = $genset_biaya_juni25['total'] + $genset_jurnal_juni25['total'];
	
	$timbangan_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$timbangan_juni25 = $timbangan_biaya_juni25['total'] + $timbangan_biaya_jurnal_juni25['total'];
	
	$tangki_solar_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$tangki_solar_juni25 = $tangki_solar_biaya_juni25['total'] + $tangki_solar_jurnal_juni25['total'];		
	
	$total_biaya_peralatan_juni25 = $stone_crusher_juni25 + $whell_loader_juni25 + $genset_juni25 + $timbangan_juni25 + $tangki_solar_juni25;

	//Opening Balance
	$date1_ago_juni25 = date('2020-01-01');
	$date2_ago_juni25 = date('Y-m-d', strtotime('-1 days', strtotime($date_juni25_awal)));
	$date3_ago_juni25 = date('Y-m-d', strtotime('-1 months', strtotime($date_juni25_awal)));
	$tanggal_opening_balance_juni25 = date('Y-m-d', strtotime('-1 days', strtotime($date_juni25_awal)));

	$stock_opname_bbm_ago_juni25 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_juni25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_juni25 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_juni25' and '$date2_ago_juni25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_juni25 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_juni25_awal' and '$date_juni25_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_juni25 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_juni25_awal' and '$date_juni25_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_juni25 = $pemakaian_bbm_juni25['volume'];
	$nilai_pemakaian_bbm_juni25 = $pemakaian_bbm_juni25['nilai'];

	$nilai_bbm_non_produksi_juni25 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_juni25 = $nilai_bbm_non_produksi_juni25['memo'];
	$nilai_bbm_non_produksi_juni25 = $nilai_bbm_non_produksi_juni25['total'];
	$total_nilai_produksi_solar_juni25 = $nilai_pemakaian_bbm_juni25 + $nilai_bbm_non_produksi_juni25;

	$nilai_realisasi_alat_juni25 = $total_biaya_peralatan_juni25 + $total_nilai_produksi_solar_juni25;
	$nilai_realisasi_alat_juni25_fix = round($nilai_realisasi_alat_juni25 / 1000000,0);

	//JULI25
	$vol_rap_alat_juli25 = $total_rekapitulasi_produksi_harian_juli25;
	$nilai_rap_alat_juli25 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_juli25,2);
	$nilai_rap_alat_juli25_fix = round($nilai_rap_alat_juli25 / 1000000,0);

	$stone_crusher_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$stone_crusher_juli25 = $stone_crusher_biaya_juli25['total'] + $stone_crusher_jurnal_juli25['total'];
	
	$whell_loader_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$whell_loader_juli25 = $whell_loader_biaya_juli25['total'] + $whell_loader_jurnal_juli25['total'];
	
	$genset_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$genset_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$genset_juli25 = $genset_biaya_juli25['total'] + $genset_jurnal_juli25['total'];
	
	$timbangan_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$timbangan_juli25 = $timbangan_biaya_juli25['total'] + $timbangan_biaya_jurnal_juli25['total'];
	
	$tangki_solar_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$tangki_solar_juli25 = $tangki_solar_biaya_juli25['total'] + $tangki_solar_jurnal_juli25['total'];		
	
	$total_biaya_peralatan_juli25 = $stone_crusher_juli25 + $whell_loader_juli25 + $genset_juli25 + $timbangan_juli25 + $tangki_solar_juli25;

	//Opening Balance
	$date1_ago_juli25 = date('2020-01-01');
	$date2_ago_juli25 = date('Y-m-d', strtotime('-1 days', strtotime($date_juli25_awal)));
	$date3_ago_juli25 = date('Y-m-d', strtotime('-1 months', strtotime($date_juli25_awal)));
	$tanggal_opening_balance_juli25 = date('Y-m-d', strtotime('-1 days', strtotime($date_juli25_awal)));

	$stock_opname_bbm_ago_juli25 = $this->db->select('pp.vol_nilai_bbm as volume')
	->from('kunci_bahan_baku pp')
	->where("(pp.date = '$tanggal_opening_balance_juli25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	
	$harga_bbm_juli25 = $this->db->select('pp.nilai_bbm as nilai_bbm')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date3_ago_juli25' and '$date2_ago_juli25')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();

	$pembelian_bbm_juli25 = $this->db->select('prm.display_measure as satuan, SUM(prm.display_volume) as volume, (prm.display_price / prm.display_volume) as harga, SUM(prm.display_price) as nilai')
	->from('pmm_receipt_material prm')
	->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
	->join('produk p', 'prm.material_id = p.id','left')
	->where("prm.date_receipt between '$date_juli25_awal' and '$date_juli25_akhir'")
	->where("prm.material_id = 13")
	->group_by('prm.material_id')
	->get()->row_array();

	$pemakaian_bbm_juli25 = $this->db->select('sum(pp.vol_pemakaian_bbm) as volume, sum(pp.nilai_pemakaian_bbm) as nilai')
	->from('kunci_bahan_baku pp')
	->where("(pp.date between '$date_juli25_awal' and '$date_juli25_akhir')")
	->order_by('pp.date','desc')->limit(1)
	->get()->row_array();
	$vol_pemakaian_bbm_juli25 = $pemakaian_bbm_juli25['volume'];
	$nilai_pemakaian_bbm_juli25 = $pemakaian_bbm_juli25['nilai'];

	$nilai_bbm_non_produksi_juli25 = $this->db->select('sum(pdb.jumlah) as total, sum(pb.memo) as memo')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$vol_bbm_non_produksi_juli25 = $nilai_bbm_non_produksi_juli25['memo'];
	$nilai_bbm_non_produksi_juli25 = $nilai_bbm_non_produksi_juli25['total'];
	$total_nilai_produksi_solar_juli25 = $nilai_pemakaian_bbm_juli25 + $nilai_bbm_non_produksi_juli25;

	$nilai_realisasi_alat_juli25 = $total_biaya_peralatan_juli25 + $total_nilai_produksi_solar_juli25;
	$nilai_realisasi_alat_juli25_fix = round($nilai_realisasi_alat_juli25 / 1000000,0);

	//AGUSTUS25
	$vol_rap_alat_agustus25 = $total_rekapitulasi_produksi_harian_agustus25;
	$nilai_rap_alat_agustus25 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_agustus25,2);
	$nilai_rap_alat_agustus25_fix = round($nilai_rap_alat_agustus25 / 1000000,0);

	$stone_crusher_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$stone_crusher_agustus25 = $stone_crusher_biaya_agustus25['total'] + $stone_crusher_jurnal_agustus25['total'];
	
	$whell_loader_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$whell_loader_agustus25 = $whell_loader_biaya_agustus25['total'] + $whell_loader_jurnal_agustus25['total'];
	
	$genset_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$genset_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$genset_agustus25 = $genset_biaya_agustus25['total'] + $genset_jurnal_agustus25['total'];
	
	$timbangan_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$timbangan_agustus25 = $timbangan_biaya_agustus25['total'] + $timbangan_biaya_jurnal_agustus25['total'];
	
	$tangki_solar_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$tangki_solar_agustus25 = $tangki_solar_biaya_agustus25['total'] + $tangki_solar_jurnal_agustus25['total'];		
	
	$total_biaya_peralatan_agustus25 = $stone_crusher_agustus25 + $whell_loader_agustus25 + $genset_agustus25 + $timbangan_agustus25 + $tangki_solar_agustus25;

	//SEPTEMBER25
	$vol_rap_alat_september25 = $total_rekapitulasi_produksi_harian_september25;
	$nilai_rap_alat_september25 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_september25,2);
	$nilai_rap_alat_september25_fix = round($nilai_rap_alat_september25 / 1000000,0);

	$stone_crusher_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$stone_crusher_september25 = $stone_crusher_biaya_september25['total'] + $stone_crusher_jurnal_september25['total'];
	
	$whell_loader_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$whell_loader_september25 = $whell_loader_biaya_september25['total'] + $whell_loader_jurnal_september25['total'];
	
	$genset_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$genset_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$genset_september25 = $genset_biaya_september25['total'] + $genset_jurnal_september25['total'];
	
	$timbangan_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$timbangan_september25 = $timbangan_biaya_september25['total'] + $timbangan_biaya_jurnal_september25['total'];
	
	$tangki_solar_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$tangki_solar_september25 = $tangki_solar_biaya_september25['total'] + $tangki_solar_jurnal_september25['total'];		
	
	$total_biaya_peralatan_september25 = $stone_crusher_september25 + $whell_loader_september25 + $genset_september25 + $timbangan_september25 + $tangki_solar_september25;

	//OKTOBER25
	$vol_rap_alat_oktober25 = $total_rekapitulasi_produksi_harian_oktober25;
	$nilai_rap_alat_oktober25 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_oktober25,2);
	$nilai_rap_alat_oktober25_fix = round($nilai_rap_alat_oktober25 / 1000000,0);

	$stone_crusher_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$stone_crusher_oktober25 = $stone_crusher_biaya_oktober25['total'] + $stone_crusher_jurnal_oktober25['total'];
	
	$whell_loader_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$whell_loader_oktober25 = $whell_loader_biaya_oktober25['total'] + $whell_loader_jurnal_oktober25['total'];
	
	$genset_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$genset_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$genset_oktober25 = $genset_biaya_oktober25['total'] + $genset_jurnal_oktober25['total'];
	
	$timbangan_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$timbangan_oktober25 = $timbangan_biaya_oktober25['total'] + $timbangan_biaya_jurnal_oktober25['total'];
	
	$tangki_solar_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$tangki_solar_oktober25 = $tangki_solar_biaya_oktober25['total'] + $tangki_solar_jurnal_oktober25['total'];		
	
	$total_biaya_peralatan_oktober25 = $stone_crusher_oktober25 + $whell_loader_oktober25 + $genset_oktober25 + $timbangan_oktober25 + $tangki_solar_oktober25;

	//NOVEMBER25
	$vol_rap_alat_november25 = $total_rekapitulasi_produksi_harian_november25;
	$nilai_rap_alat_november25 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_november25,2);
	$nilai_rap_alat_november25_fix = round($nilai_rap_alat_november25 / 1000000,0);

	$stone_crusher_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$stone_crusher_november25 = $stone_crusher_biaya_november25['total'] + $stone_crusher_jurnal_november25['total'];
	
	$whell_loader_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$whell_loader_november25 = $whell_loader_biaya_november25['total'] + $whell_loader_jurnal_november25['total'];
	
	$genset_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$genset_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$genset_november25 = $genset_biaya_november25['total'] + $genset_jurnal_november25['total'];
	
	$timbangan_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$timbangan_november25 = $timbangan_biaya_november25['total'] + $timbangan_biaya_jurnal_november25['total'];
	
	$tangki_solar_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$tangki_solar_november25 = $tangki_solar_biaya_november25['total'] + $tangki_solar_jurnal_november25['total'];		
	
	$total_biaya_peralatan_november25 = $stone_crusher_november25 + $whell_loader_november25 + $genset_november25 + $timbangan_november25 + $tangki_solar_november25;

	//DESEMBER25
	$vol_rap_alat_desember25 = $total_rekapitulasi_produksi_harian_desember25;
	$nilai_rap_alat_desember25 = ($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($vol_rap_alat_desember25,2);
	$nilai_rap_alat_desember25_fix = round($nilai_rap_alat_desember25 / 1000000,0);

	$stone_crusher_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$stone_crusher_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 101")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$stone_crusher_desember25 = $stone_crusher_biaya_desember25['total'] + $stone_crusher_jurnal_desember25['total'];
	
	$whell_loader_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$whell_loader_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 104")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$whell_loader_desember25 = $whell_loader_biaya_desember25['total'] + $whell_loader_jurnal_desember25['total'];
	
	$genset_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$genset_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 197")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$genset_desember25 = $genset_biaya_desember25['total'] + $genset_jurnal_desember25['total'];
	
	$timbangan_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$timbangan_biaya_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 198")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$timbangan_desember25 = $timbangan_biaya_desember25['total'] + $timbangan_biaya_jurnal_desember25['total'];
	
	$tangki_solar_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$tangki_solar_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 207")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$tangki_solar_desember25 = $tangki_solar_biaya_desember25['total'] + $tangki_solar_jurnal_desember25['total'];		
	
	$total_biaya_peralatan_desember25 = $stone_crusher_desember25 + $whell_loader_desember25 + $genset_desember25 + $timbangan_desember25 + $tangki_solar_desember25;
	
?>

<?php
	//JANUARI25
	$nilai_rap_overhead_januari25 = $overhead_ton * round($total_rekapitulasi_produksi_harian_januari25,2);
	$nilai_rap_overhead_januari25_fix = round($nilai_rap_overhead_januari25 / 1000000,0);

	$konsumsi_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$konsumsi_januari25 = $konsumsi_biaya_januari25['total'] + $konsumsi_jurnal_januari25['total'];

	$gaji_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$gaji_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$gaji_januari25 = $gaji_biaya_januari25['total'] + $gaji_jurnal_januari25['total'];

	$upah_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$upah_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$upah_januari25 = $upah_biaya_januari25['total'] + $upah_jurnal_januari25['total'];

	$pengujian_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$pengujian_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$pengujian_januari25 = $pengujian_biaya_januari25['total'] + $pengujian_jurnal_januari25['total'];

	$perbaikan_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$perbaikan_januari25 = $perbaikan_biaya_januari25['total'] + $perbaikan_jurnal_januari25['total'];

	$akomodasi_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$akomodasi_januari25 = $akomodasi_biaya_januari25['total'] + $akomodasi_jurnal_januari25['total'];

	$listrik_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$listrik_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$listrik_januari25 = $listrik_biaya_januari25['total'] + $listrik_jurnal_januari25['total'];

	$thr_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$thr_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$thr_januari25 = $thr_biaya_januari25['total'] + $thr_jurnal_januari25['total'];

	$bensin_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$bensin_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$bensin_januari25 = $bensin_biaya_januari25['total'] + $bensin_jurnal_januari25['total'];

	$dinas_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$dinas_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$dinas_januari25 = $dinas_biaya_januari25['total'] + $dinas_jurnal_januari25['total'];

	$komunikasi_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$komunikasi_januari25 = $komunikasi_biaya_januari25['total'] + $komunikasi_jurnal_januari25['total'];

	$pakaian_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$pakaian_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$pakaian_januari25 = $pakaian_biaya_januari25['total'] + $pakaian_jurnal_januari25['total'];

	$tulis_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$tulis_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$tulis_januari25 = $tulis_biaya_januari25['total'] + $tulis_jurnal_januari25['total'];

	$keamanan_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$keamanan_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$keamanan_januari25 = $keamanan_biaya_januari25['total'] + $keamanan_jurnal_januari25['total'];

	$perlengkapan_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$perlengkapan_januari25 = $perlengkapan_biaya_januari25['total'] + $perlengkapan_jurnal_januari25['total'];

	$beban_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$beban_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$beban_januari25 = $beban_biaya_januari25['total'] + $beban_jurnal_januari25['total'];

	$adm_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$adm_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$adm_januari25 = $adm_biaya_januari25['total'] + $adm_jurnal_januari25['total'];

	$lain_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$lain_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$lain_januari25 = $lain_biaya_januari25['total'] + $lain_jurnal_januari25['total'];

	$sewa_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$sewa_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$sewa_januari25 = $sewa_biaya_januari25['total'] + $sewa_jurnal_januari25['total'];

	$bpjs_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$bpjs_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$bpjs_januari25 = $bpjs_biaya_januari25['total'] + $bpjs_jurnal_januari25['total'];

	$penyusutan_kantor_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$penyusutan_kantor_januari25 = $penyusutan_kantor_biaya_januari25['total'] + $penyusutan_kantor_jurnal_januari25['total'];

	$penyusutan_kendaraan_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_januari25 = $penyusutan_kendaraan_biaya_januari25['total'] + $penyusutan_kendaraan_jurnal_januari25['total'];

	$iuran_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$iuran_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$iuran_januari25 = $iuran_biaya_januari25['total'] + $iuran_jurnal_januari25['total'];

	$kendaraan_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$kendaraan_januari25 = $kendaraan_biaya_januari25['total'] + $kendaraan_jurnal_januari25['total'];

	$pajak_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$pajak_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$pajak_januari25 = $pajak_biaya_januari25['total'] + $pajak_jurnal_januari25['total'];

	$solar_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$solar_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$solar_januari25 = 0;

	$donasi_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$donasi_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$donasi_januari25 = $donasi_biaya_januari25['total'] + $donasi_jurnal_januari25['total'];

	$legal_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$legal_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$legal_januari25 = $legal_biaya_januari25['total'] + $legal_jurnal_januari25['total'];

	$pengobatan_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$pengobatan_januari25 = $pengobatan_biaya_januari25['total'] + $pengobatan_jurnal_januari25['total'];

	$lembur_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$lembur_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$lembur_januari25 = $lembur_biaya_januari25['total'] + $lembur_jurnal_januari25['total'];

	$pelatihan_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$pelatihan_januari25 = $pelatihan_biaya_januari25['total'] + $pelatihan_jurnal_januari25['total'];

	$supplies_biaya_januari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();

	$supplies_jurnal_januari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_januari25_awal' and '$date_januari25_akhir')")
	->get()->row_array();
	$supplies_januari25 = $supplies_biaya_januari25['total'] + $supplies_jurnal_januari25['total'];

	$total_operasional_januari25 = $konsumsi_januari25 + $gaji_januari25 + $upah_januari25 + $pengujian_januari25 + $perbaikan_januari25 + $akomodasi_januari25 + $listrik_januari25 + $thr_januari25 + 
	$bensin_januari25 + $dinas_januari25 + $komunikasi_januari25 + $pakaian_januari25 + $tulis_januari25 + $keamanan_januari25 + $perlengkapan_januari25 + $beban_januari25 + $adm_januari25 + 
	$lain_januari25 + $sewa_januari25 + $bpjs_januari25 + $penyusutan_kantor_januari25 + $penyusutan_kendaraan_januari25 + $iuran_januari25 + $kendaraan_januari25 + $pajak_januari25 + $solar_januari25 + 
	$donasi_januari25 + $legal_januari25 + $pengobatan_januari25 + $lembur_januari25 + $pelatihan_januari25 + $supplies_januari25;
	$nilai_realisasi_overhead_januari25_fix = round($total_operasional_januari25 / 1000000,0);

	//FEBRUARI25
	$nilai_rap_overhead_februari25 = $overhead_ton * round($total_rekapitulasi_produksi_harian_februari25,2);
	$nilai_rap_overhead_februari25_fix = round($nilai_rap_overhead_februari25 / 1000000,0);

	$konsumsi_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$konsumsi_februari25 = $konsumsi_biaya_februari25['total'] + $konsumsi_jurnal_februari25['total'];

	$gaji_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$gaji_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$gaji_februari25 = $gaji_biaya_februari25['total'] + $gaji_jurnal_februari25['total'];

	$upah_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$upah_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$upah_februari25 = $upah_biaya_februari25['total'] + $upah_jurnal_februari25['total'];

	$pengujian_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$pengujian_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$pengujian_februari25 = $pengujian_biaya_februari25['total'] + $pengujian_jurnal_februari25['total'];

	$perbaikan_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$perbaikan_februari25 = $perbaikan_biaya_februari25['total'] + $perbaikan_jurnal_februari25['total'];

	$akomodasi_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$akomodasi_februari25 = $akomodasi_biaya_februari25['total'] + $akomodasi_jurnal_februari25['total'];

	$listrik_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$listrik_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$listrik_februari25 = $listrik_biaya_februari25['total'] + $listrik_jurnal_februari25['total'];

	$thr_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$thr_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$thr_februari25 = $thr_biaya_februari25['total'] + $thr_jurnal_februari25['total'];

	$bensin_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$bensin_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$bensin_februari25 = $bensin_biaya_februari25['total'] + $bensin_jurnal_februari25['total'];

	$dinas_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$dinas_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$dinas_februari25 = $dinas_biaya_februari25['total'] + $dinas_jurnal_februari25['total'];

	$komunikasi_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$komunikasi_februari25 = $komunikasi_biaya_februari25['total'] + $komunikasi_jurnal_februari25['total'];

	$pakaian_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$pakaian_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$pakaian_februari25 = $pakaian_biaya_februari25['total'] + $pakaian_jurnal_februari25['total'];

	$tulis_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$tulis_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$tulis_februari25 = $tulis_biaya_februari25['total'] + $tulis_jurnal_februari25['total'];

	$keamanan_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$keamanan_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$keamanan_februari25 = $keamanan_biaya_februari25['total'] + $keamanan_jurnal_februari25['total'];

	$perlengkapan_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$perlengkapan_februari25 = $perlengkapan_biaya_februari25['total'] + $perlengkapan_jurnal_februari25['total'];

	$beban_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$beban_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$beban_februari25 = $beban_biaya_februari25['total'] + $beban_jurnal_februari25['total'];

	$adm_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$adm_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$adm_februari25 = $adm_biaya_februari25['total'] + $adm_jurnal_februari25['total'];

	$lain_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$lain_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$lain_februari25 = $lain_biaya_februari25['total'] + $lain_jurnal_februari25['total'];

	$sewa_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$sewa_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$sewa_februari25 = $sewa_biaya_februari25['total'] + $sewa_jurnal_februari25['total'];

	$bpjs_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$bpjs_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$bpjs_februari25 = $bpjs_biaya_februari25['total'] + $bpjs_jurnal_februari25['total'];

	$penyusutan_kantor_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$penyusutan_kantor_februari25 = $penyusutan_kantor_biaya_februari25['total'] + $penyusutan_kantor_jurnal_februari25['total'];

	$penyusutan_kendaraan_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_februari25 = $penyusutan_kendaraan_biaya_februari25['total'] + $penyusutan_kendaraan_jurnal_februari25['total'];

	$iuran_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$iuran_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$iuran_februari25 = $iuran_biaya_februari25['total'] + $iuran_jurnal_februari25['total'];

	$kendaraan_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$kendaraan_februari25 = $kendaraan_biaya_februari25['total'] + $kendaraan_jurnal_februari25['total'];

	$pajak_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$pajak_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$pajak_februari25 = $pajak_biaya_februari25['total'] + $pajak_jurnal_februari25['total'];

	$solar_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$solar_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$solar_februari25 = 0;

	$donasi_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$donasi_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$donasi_februari25 = $donasi_biaya_februari25['total'] + $donasi_jurnal_februari25['total'];

	$legal_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$legal_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$legal_februari25 = $legal_biaya_februari25['total'] + $legal_jurnal_februari25['total'];

	$pengobatan_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$pengobatan_februari25 = $pengobatan_biaya_februari25['total'] + $pengobatan_jurnal_februari25['total'];

	$lembur_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$lembur_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$lembur_februari25 = $lembur_biaya_februari25['total'] + $lembur_jurnal_februari25['total'];

	$pelatihan_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$pelatihan_februari25 = $pelatihan_biaya_februari25['total'] + $pelatihan_jurnal_februari25['total'];

	$supplies_biaya_februari25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();

	$supplies_jurnal_februari25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_februari25_awal' and '$date_februari25_akhir')")
	->get()->row_array();
	$supplies_februari25 = $supplies_biaya_februari25['total'] + $supplies_jurnal_februari25['total'];

	$total_operasional_februari25 = $konsumsi_februari25 + $gaji_februari25 + $upah_februari25 + $pengujian_februari25 + $perbaikan_februari25 + $akomodasi_februari25 + $listrik_februari25 + $thr_februari25 + 
	$bensin_februari25 + $dinas_februari25 + $komunikasi_februari25 + $pakaian_februari25 + $tulis_februari25 + $keamanan_februari25 + $perlengkapan_februari25 + $beban_februari25 + $adm_februari25 + 
	$lain_februari25 + $sewa_februari25 + $bpjs_februari25 + $penyusutan_kantor_februari25 + $penyusutan_kendaraan_februari25 + $iuran_februari25 + $kendaraan_februari25 + $pajak_februari25 + $solar_februari25 + 
	$donasi_februari25 + $legal_februari25 + $pengobatan_februari25 + $lembur_februari25 + $pelatihan_februari25 + $supplies_februari25;
	$nilai_realisasi_overhead_februari25_fix = round($total_operasional_februari25 / 1000000,0);

	//MARET25
	$nilai_rap_overhead_maret25 = $overhead_ton * round($total_rekapitulasi_produksi_harian_maret25,2);
	$nilai_rap_overhead_maret25_fix = round($nilai_rap_overhead_maret25 / 1000000,0);

	$konsumsi_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$konsumsi_maret25 = $konsumsi_biaya_maret25['total'] + $konsumsi_jurnal_maret25['total'];

	$gaji_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$gaji_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$gaji_maret25 = $gaji_biaya_maret25['total'] + $gaji_jurnal_maret25['total'];

	$upah_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$upah_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$upah_maret25 = $upah_biaya_maret25['total'] + $upah_jurnal_maret25['total'];

	$pengujian_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$pengujian_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$pengujian_maret25 = $pengujian_biaya_maret25['total'] + $pengujian_jurnal_maret25['total'];

	$perbaikan_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$perbaikan_maret25 = $perbaikan_biaya_maret25['total'] + $perbaikan_jurnal_maret25['total'];

	$akomodasi_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$akomodasi_maret25 = $akomodasi_biaya_maret25['total'] + $akomodasi_jurnal_maret25['total'];

	$listrik_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$listrik_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$listrik_maret25 = $listrik_biaya_maret25['total'] + $listrik_jurnal_maret25['total'];

	$thr_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$thr_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$thr_maret25 = $thr_biaya_maret25['total'] + $thr_jurnal_maret25['total'];

	$bensin_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$bensin_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$bensin_maret25 = $bensin_biaya_maret25['total'] + $bensin_jurnal_maret25['total'];

	$dinas_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$dinas_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$dinas_maret25 = $dinas_biaya_maret25['total'] + $dinas_jurnal_maret25['total'];

	$komunikasi_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$komunikasi_maret25 = $komunikasi_biaya_maret25['total'] + $komunikasi_jurnal_maret25['total'];

	$pakaian_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$pakaian_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$pakaian_maret25 = $pakaian_biaya_maret25['total'] + $pakaian_jurnal_maret25['total'];

	$tulis_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$tulis_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$tulis_maret25 = $tulis_biaya_maret25['total'] + $tulis_jurnal_maret25['total'];

	$keamanan_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$keamanan_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$keamanan_maret25 = $keamanan_biaya_maret25['total'] + $keamanan_jurnal_maret25['total'];

	$perlengkapan_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$perlengkapan_maret25 = $perlengkapan_biaya_maret25['total'] + $perlengkapan_jurnal_maret25['total'];

	$beban_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$beban_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$beban_maret25 = $beban_biaya_maret25['total'] + $beban_jurnal_maret25['total'];

	$adm_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$adm_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$adm_maret25 = $adm_biaya_maret25['total'] + $adm_jurnal_maret25['total'];

	$lain_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$lain_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$lain_maret25 = $lain_biaya_maret25['total'] + $lain_jurnal_maret25['total'];

	$sewa_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$sewa_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$sewa_maret25 = $sewa_biaya_maret25['total'] + $sewa_jurnal_maret25['total'];

	$bpjs_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$bpjs_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$bpjs_maret25 = $bpjs_biaya_maret25['total'] + $bpjs_jurnal_maret25['total'];

	$penyusutan_kantor_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$penyusutan_kantor_maret25 = $penyusutan_kantor_biaya_maret25['total'] + $penyusutan_kantor_jurnal_maret25['total'];

	$penyusutan_kendaraan_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_maret25 = $penyusutan_kendaraan_biaya_maret25['total'] + $penyusutan_kendaraan_jurnal_maret25['total'];

	$iuran_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$iuran_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$iuran_maret25 = $iuran_biaya_maret25['total'] + $iuran_jurnal_maret25['total'];

	$kendaraan_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$kendaraan_maret25 = $kendaraan_biaya_maret25['total'] + $kendaraan_jurnal_maret25['total'];

	$pajak_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$pajak_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$pajak_maret25 = $pajak_biaya_maret25['total'] + $pajak_jurnal_maret25['total'];

	$solar_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$solar_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$solar_maret25 = 0;

	$donasi_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$donasi_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$donasi_maret25 = $donasi_biaya_maret25['total'] + $donasi_jurnal_maret25['total'];

	$legal_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$legal_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$legal_maret25 = $legal_biaya_maret25['total'] + $legal_jurnal_maret25['total'];

	$pengobatan_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$pengobatan_maret25 = $pengobatan_biaya_maret25['total'] + $pengobatan_jurnal_maret25['total'];

	$lembur_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$lembur_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$lembur_maret25 = $lembur_biaya_maret25['total'] + $lembur_jurnal_maret25['total'];

	$pelatihan_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$pelatihan_maret25 = $pelatihan_biaya_maret25['total'] + $pelatihan_jurnal_maret25['total'];

	$supplies_biaya_maret25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();

	$supplies_jurnal_maret25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_maret25_awal' and '$date_maret25_akhir')")
	->get()->row_array();
	$supplies_maret25 = $supplies_biaya_maret25['total'] + $supplies_jurnal_maret25['total'];

	$total_operasional_maret25 = $konsumsi_maret25 + $gaji_maret25 + $upah_maret25 + $pengujian_maret25 + $perbaikan_maret25 + $akomodasi_maret25 + $listrik_maret25 + $thr_maret25 + 
	$bensin_maret25 + $dinas_maret25 + $komunikasi_maret25 + $pakaian_maret25 + $tulis_maret25 + $keamanan_maret25 + $perlengkapan_maret25 + $beban_maret25 + $adm_maret25 + 
	$lain_maret25 + $sewa_maret25 + $bpjs_maret25 + $penyusutan_kantor_maret25 + $penyusutan_kendaraan_maret25 + $iuran_maret25 + $kendaraan_maret25 + $pajak_maret25 + $solar_maret25 + 
	$donasi_maret25 + $legal_maret25 + $pengobatan_maret25 + $lembur_maret25 + $pelatihan_maret25 + $supplies_maret25;
	$nilai_realisasi_overhead_maret25_fix = round($total_operasional_maret25 / 1000000,0);

	//APRIL25
	$nilai_rap_overhead_april25 = $overhead_ton * round($total_rekapitulasi_produksi_harian_april25,2);
	$nilai_rap_overhead_april25_fix = round($nilai_rap_overhead_april25 / 1000000,0);

	$konsumsi_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$konsumsi_april25 = $konsumsi_biaya_april25['total'] + $konsumsi_jurnal_april25['total'];

	$gaji_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$gaji_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$gaji_april25 = $gaji_biaya_april25['total'] + $gaji_jurnal_april25['total'];

	$upah_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$upah_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$upah_april25 = $upah_biaya_april25['total'] + $upah_jurnal_april25['total'];

	$pengujian_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$pengujian_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$pengujian_april25 = $pengujian_biaya_april25['total'] + $pengujian_jurnal_april25['total'];

	$perbaikan_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$perbaikan_april25 = $perbaikan_biaya_april25['total'] + $perbaikan_jurnal_april25['total'];

	$akomodasi_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$akomodasi_april25 = $akomodasi_biaya_april25['total'] + $akomodasi_jurnal_april25['total'];

	$listrik_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$listrik_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$listrik_april25 = $listrik_biaya_april25['total'] + $listrik_jurnal_april25['total'];

	$thr_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$thr_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$thr_april25 = $thr_biaya_april25['total'] + $thr_jurnal_april25['total'];

	$bensin_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$bensin_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$bensin_april25 = $bensin_biaya_april25['total'] + $bensin_jurnal_april25['total'];

	$dinas_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$dinas_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$dinas_april25 = $dinas_biaya_april25['total'] + $dinas_jurnal_april25['total'];

	$komunikasi_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$komunikasi_april25 = $komunikasi_biaya_april25['total'] + $komunikasi_jurnal_april25['total'];

	$pakaian_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$pakaian_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$pakaian_april25 = $pakaian_biaya_april25['total'] + $pakaian_jurnal_april25['total'];

	$tulis_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$tulis_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$tulis_april25 = $tulis_biaya_april25['total'] + $tulis_jurnal_april25['total'];

	$keamanan_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$keamanan_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$keamanan_april25 = $keamanan_biaya_april25['total'] + $keamanan_jurnal_april25['total'];

	$perlengkapan_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$perlengkapan_april25 = $perlengkapan_biaya_april25['total'] + $perlengkapan_jurnal_april25['total'];

	$beban_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$beban_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$beban_april25 = $beban_biaya_april25['total'] + $beban_jurnal_april25['total'];

	$adm_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$adm_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$adm_april25 = $adm_biaya_april25['total'] + $adm_jurnal_april25['total'];

	$lain_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$lain_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$lain_april25 = $lain_biaya_april25['total'] + $lain_jurnal_april25['total'];

	$sewa_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$sewa_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$sewa_april25 = $sewa_biaya_april25['total'] + $sewa_jurnal_april25['total'];

	$bpjs_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$bpjs_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$bpjs_april25 = $bpjs_biaya_april25['total'] + $bpjs_jurnal_april25['total'];

	$penyusutan_kantor_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$penyusutan_kantor_april25 = $penyusutan_kantor_biaya_april25['total'] + $penyusutan_kantor_jurnal_april25['total'];

	$penyusutan_kendaraan_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_april25 = $penyusutan_kendaraan_biaya_april25['total'] + $penyusutan_kendaraan_jurnal_april25['total'];

	$iuran_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$iuran_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$iuran_april25 = $iuran_biaya_april25['total'] + $iuran_jurnal_april25['total'];

	$kendaraan_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$kendaraan_april25 = $kendaraan_biaya_april25['total'] + $kendaraan_jurnal_april25['total'];

	$pajak_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$pajak_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$pajak_april25 = $pajak_biaya_april25['total'] + $pajak_jurnal_april25['total'];

	$solar_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$solar_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$solar_april25 = 0;

	$donasi_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$donasi_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$donasi_april25 = $donasi_biaya_april25['total'] + $donasi_jurnal_april25['total'];

	$legal_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$legal_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$legal_april25 = $legal_biaya_april25['total'] + $legal_jurnal_april25['total'];

	$pengobatan_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$pengobatan_april25 = $pengobatan_biaya_april25['total'] + $pengobatan_jurnal_april25['total'];

	$lembur_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$lembur_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$lembur_april25 = $lembur_biaya_april25['total'] + $lembur_jurnal_april25['total'];

	$pelatihan_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$pelatihan_april25 = $pelatihan_biaya_april25['total'] + $pelatihan_jurnal_april25['total'];

	$supplies_biaya_april25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();

	$supplies_jurnal_april25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_april25_awal' and '$date_april25_akhir')")
	->get()->row_array();
	$supplies_april25 = $supplies_biaya_april25['total'] + $supplies_jurnal_april25['total'];

	$total_operasional_april25 = $konsumsi_april25 + $gaji_april25 + $upah_april25 + $pengujian_april25 + $perbaikan_april25 + $akomodasi_april25 + $listrik_april25 + $thr_april25 + 
	$bensin_april25 + $dinas_april25 + $komunikasi_april25 + $pakaian_april25 + $tulis_april25 + $keamanan_april25 + $perlengkapan_april25 + $beban_april25 + $adm_april25 + 
	$lain_april25 + $sewa_april25 + $bpjs_april25 + $penyusutan_kantor_april25 + $penyusutan_kendaraan_april25 + $iuran_april25 + $kendaraan_april25 + $pajak_april25 + $solar_april25 + 
	$donasi_april25 + $legal_april25 + $pengobatan_april25 + $lembur_april25 + $pelatihan_april25 + $supplies_april25;
	$nilai_realisasi_overhead_april25_fix = round($total_operasional_april25 / 1000000,0);

	//MEI25
	$nilai_rap_overhead_mei25 = $overhead_ton * round($total_rekapitulasi_produksi_harian_mei25,2);
	$nilai_rap_overhead_mei25_fix = round($nilai_rap_overhead_mei25 / 1000000,0);

	$konsumsi_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$konsumsi_mei25 = $konsumsi_biaya_mei25['total'] + $konsumsi_jurnal_mei25['total'];

	$gaji_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$gaji_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$gaji_mei25 = $gaji_biaya_mei25['total'] + $gaji_jurnal_mei25['total'];

	$upah_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$upah_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$upah_mei25 = $upah_biaya_mei25['total'] + $upah_jurnal_mei25['total'];

	$pengujian_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$pengujian_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$pengujian_mei25 = $pengujian_biaya_mei25['total'] + $pengujian_jurnal_mei25['total'];

	$perbaikan_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$perbaikan_mei25 = $perbaikan_biaya_mei25['total'] + $perbaikan_jurnal_mei25['total'];

	$akomodasi_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$akomodasi_mei25 = $akomodasi_biaya_mei25['total'] + $akomodasi_jurnal_mei25['total'];

	$listrik_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$listrik_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$listrik_mei25 = $listrik_biaya_mei25['total'] + $listrik_jurnal_mei25['total'];

	$thr_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$thr_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$thr_mei25 = $thr_biaya_mei25['total'] + $thr_jurnal_mei25['total'];

	$bensin_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$bensin_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$bensin_mei25 = $bensin_biaya_mei25['total'] + $bensin_jurnal_mei25['total'];

	$dinas_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$dinas_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$dinas_mei25 = $dinas_biaya_mei25['total'] + $dinas_jurnal_mei25['total'];

	$komunikasi_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$komunikasi_mei25 = $komunikasi_biaya_mei25['total'] + $komunikasi_jurnal_mei25['total'];

	$pakaian_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$pakaian_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$pakaian_mei25 = $pakaian_biaya_mei25['total'] + $pakaian_jurnal_mei25['total'];

	$tulis_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$tulis_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$tulis_mei25 = $tulis_biaya_mei25['total'] + $tulis_jurnal_mei25['total'];

	$keamanan_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$keamanan_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$keamanan_mei25 = $keamanan_biaya_mei25['total'] + $keamanan_jurnal_mei25['total'];

	$perlengkapan_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$perlengkapan_mei25 = $perlengkapan_biaya_mei25['total'] + $perlengkapan_jurnal_mei25['total'];

	$beban_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$beban_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$beban_mei25 = $beban_biaya_mei25['total'] + $beban_jurnal_mei25['total'];

	$adm_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$adm_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$adm_mei25 = $adm_biaya_mei25['total'] + $adm_jurnal_mei25['total'];

	$lain_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$lain_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$lain_mei25 = $lain_biaya_mei25['total'] + $lain_jurnal_mei25['total'];

	$sewa_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$sewa_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$sewa_mei25 = $sewa_biaya_mei25['total'] + $sewa_jurnal_mei25['total'];

	$bpjs_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$bpjs_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$bpjs_mei25 = $bpjs_biaya_mei25['total'] + $bpjs_jurnal_mei25['total'];

	$penyusutan_kantor_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$penyusutan_kantor_mei25 = $penyusutan_kantor_biaya_mei25['total'] + $penyusutan_kantor_jurnal_mei25['total'];

	$penyusutan_kendaraan_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_mei25 = $penyusutan_kendaraan_biaya_mei25['total'] + $penyusutan_kendaraan_jurnal_mei25['total'];

	$iuran_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$iuran_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$iuran_mei25 = $iuran_biaya_mei25['total'] + $iuran_jurnal_mei25['total'];

	$kendaraan_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$kendaraan_mei25 = $kendaraan_biaya_mei25['total'] + $kendaraan_jurnal_mei25['total'];

	$pajak_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$pajak_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$pajak_mei25 = $pajak_biaya_mei25['total'] + $pajak_jurnal_mei25['total'];

	$solar_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$solar_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$solar_mei25 = 0;

	$donasi_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$donasi_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$donasi_mei25 = $donasi_biaya_mei25['total'] + $donasi_jurnal_mei25['total'];

	$legal_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$legal_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$legal_mei25 = $legal_biaya_mei25['total'] + $legal_jurnal_mei25['total'];

	$pengobatan_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$pengobatan_mei25 = $pengobatan_biaya_mei25['total'] + $pengobatan_jurnal_mei25['total'];

	$lembur_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$lembur_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$lembur_mei25 = $lembur_biaya_mei25['total'] + $lembur_jurnal_mei25['total'];

	$pelatihan_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$pelatihan_mei25 = $pelatihan_biaya_mei25['total'] + $pelatihan_jurnal_mei25['total'];

	$supplies_biaya_mei25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();

	$supplies_jurnal_mei25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_mei25_awal' and '$date_mei25_akhir')")
	->get()->row_array();
	$supplies_mei25 = $supplies_biaya_mei25['total'] + $supplies_jurnal_mei25['total'];

	$total_operasional_mei25 = $konsumsi_mei25 + $gaji_mei25 + $upah_mei25 + $pengujian_mei25 + $perbaikan_mei25 + $akomodasi_mei25 + $listrik_mei25 + $thr_mei25 + 
	$bensin_mei25 + $dinas_mei25 + $komunikasi_mei25 + $pakaian_mei25 + $tulis_mei25 + $keamanan_mei25 + $perlengkapan_mei25 + $beban_mei25 + $adm_mei25 + 
	$lain_mei25 + $sewa_mei25 + $bpjs_mei25 + $penyusutan_kantor_mei25 + $penyusutan_kendaraan_mei25 + $iuran_mei25 + $kendaraan_mei25 + $pajak_mei25 + $solar_mei25 + 
	$donasi_mei25 + $legal_mei25 + $pengobatan_mei25 + $lembur_mei25 + $pelatihan_mei25 + $supplies_mei25;
	$nilai_realisasi_overhead_mei25_fix = round($total_operasional_mei25 / 1000000,0);

	//JUNI25
	$nilai_rap_overhead_juni25 = $overhead_ton * round($total_rekapitulasi_produksi_harian_juni25,2);
	$nilai_rap_overhead_juni25_fix = round($nilai_rap_overhead_juni25 / 1000000,0);

	$konsumsi_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$konsumsi_juni25 = $konsumsi_biaya_juni25['total'] + $konsumsi_jurnal_juni25['total'];

	$gaji_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$gaji_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$gaji_juni25 = $gaji_biaya_juni25['total'] + $gaji_jurnal_juni25['total'];

	$upah_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$upah_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$upah_juni25 = $upah_biaya_juni25['total'] + $upah_jurnal_juni25['total'];

	$pengujian_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$pengujian_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$pengujian_juni25 = $pengujian_biaya_juni25['total'] + $pengujian_jurnal_juni25['total'];

	$perbaikan_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$perbaikan_juni25 = $perbaikan_biaya_juni25['total'] + $perbaikan_jurnal_juni25['total'];

	$akomodasi_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$akomodasi_juni25 = $akomodasi_biaya_juni25['total'] + $akomodasi_jurnal_juni25['total'];

	$listrik_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$listrik_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$listrik_juni25 = $listrik_biaya_juni25['total'] + $listrik_jurnal_juni25['total'];

	$thr_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$thr_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$thr_juni25 = $thr_biaya_juni25['total'] + $thr_jurnal_juni25['total'];

	$bensin_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$bensin_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$bensin_juni25 = $bensin_biaya_juni25['total'] + $bensin_jurnal_juni25['total'];

	$dinas_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$dinas_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$dinas_juni25 = $dinas_biaya_juni25['total'] + $dinas_jurnal_juni25['total'];

	$komunikasi_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$komunikasi_juni25 = $komunikasi_biaya_juni25['total'] + $komunikasi_jurnal_juni25['total'];

	$pakaian_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$pakaian_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$pakaian_juni25 = $pakaian_biaya_juni25['total'] + $pakaian_jurnal_juni25['total'];

	$tulis_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$tulis_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$tulis_juni25 = $tulis_biaya_juni25['total'] + $tulis_jurnal_juni25['total'];

	$keamanan_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$keamanan_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$keamanan_juni25 = $keamanan_biaya_juni25['total'] + $keamanan_jurnal_juni25['total'];

	$perlengkapan_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$perlengkapan_juni25 = $perlengkapan_biaya_juni25['total'] + $perlengkapan_jurnal_juni25['total'];

	$beban_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$beban_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$beban_juni25 = $beban_biaya_juni25['total'] + $beban_jurnal_juni25['total'];

	$adm_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$adm_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$adm_juni25 = $adm_biaya_juni25['total'] + $adm_jurnal_juni25['total'];

	$lain_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$lain_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$lain_juni25 = $lain_biaya_juni25['total'] + $lain_jurnal_juni25['total'];

	$sewa_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$sewa_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$sewa_juni25 = $sewa_biaya_juni25['total'] + $sewa_jurnal_juni25['total'];

	$bpjs_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$bpjs_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$bpjs_juni25 = $bpjs_biaya_juni25['total'] + $bpjs_jurnal_juni25['total'];

	$penyusutan_kantor_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$penyusutan_kantor_juni25 = $penyusutan_kantor_biaya_juni25['total'] + $penyusutan_kantor_jurnal_juni25['total'];

	$penyusutan_kendaraan_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_juni25 = $penyusutan_kendaraan_biaya_juni25['total'] + $penyusutan_kendaraan_jurnal_juni25['total'];

	$iuran_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$iuran_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$iuran_juni25 = $iuran_biaya_juni25['total'] + $iuran_jurnal_juni25['total'];

	$kendaraan_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$kendaraan_juni25 = $kendaraan_biaya_juni25['total'] + $kendaraan_jurnal_juni25['total'];

	$pajak_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$pajak_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$pajak_juni25 = $pajak_biaya_juni25['total'] + $pajak_jurnal_juni25['total'];

	$solar_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$solar_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$solar_juni25 = 0;

	$donasi_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$donasi_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$donasi_juni25 = $donasi_biaya_juni25['total'] + $donasi_jurnal_juni25['total'];

	$legal_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$legal_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$legal_juni25 = $legal_biaya_juni25['total'] + $legal_jurnal_juni25['total'];

	$pengobatan_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$pengobatan_juni25 = $pengobatan_biaya_juni25['total'] + $pengobatan_jurnal_juni25['total'];

	$lembur_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$lembur_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$lembur_juni25 = $lembur_biaya_juni25['total'] + $lembur_jurnal_juni25['total'];

	$pelatihan_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$pelatihan_juni25 = $pelatihan_biaya_juni25['total'] + $pelatihan_jurnal_juni25['total'];

	$supplies_biaya_juni25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();

	$supplies_jurnal_juni25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juni25_awal' and '$date_juni25_akhir')")
	->get()->row_array();
	$supplies_juni25 = $supplies_biaya_juni25['total'] + $supplies_jurnal_juni25['total'];

	$total_operasional_juni25 = $konsumsi_juni25 + $gaji_juni25 + $upah_juni25 + $pengujian_juni25 + $perbaikan_juni25 + $akomodasi_juni25 + $listrik_juni25 + $thr_juni25 + 
	$bensin_juni25 + $dinas_juni25 + $komunikasi_juni25 + $pakaian_juni25 + $tulis_juni25 + $keamanan_juni25 + $perlengkapan_juni25 + $beban_juni25 + $adm_juni25 + 
	$lain_juni25 + $sewa_juni25 + $bpjs_juni25 + $penyusutan_kantor_juni25 + $penyusutan_kendaraan_juni25 + $iuran_juni25 + $kendaraan_juni25 + $pajak_juni25 + $solar_juni25 + 
	$donasi_juni25 + $legal_juni25 + $pengobatan_juni25 + $lembur_juni25 + $pelatihan_juni25 + $supplies_juni25;
	$nilai_realisasi_overhead_juni25_fix = round($total_operasional_juni25 / 1000000,0);

	//JULI25
	$nilai_rap_overhead_juli25 = $overhead_ton * round($total_rekapitulasi_produksi_harian_juli25,2);
	$nilai_rap_overhead_juli25_fix = round($nilai_rap_overhead_juli25 / 1000000,0);

	$konsumsi_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$konsumsi_juli25 = $konsumsi_biaya_juli25['total'] + $konsumsi_jurnal_juli25['total'];

	$gaji_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$gaji_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$gaji_juli25 = $gaji_biaya_juli25['total'] + $gaji_jurnal_juli25['total'];

	$upah_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$upah_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$upah_juli25 = $upah_biaya_juli25['total'] + $upah_jurnal_juli25['total'];

	$pengujian_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$pengujian_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$pengujian_juli25 = $pengujian_biaya_juli25['total'] + $pengujian_jurnal_juli25['total'];

	$perbaikan_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$perbaikan_juli25 = $perbaikan_biaya_juli25['total'] + $perbaikan_jurnal_juli25['total'];

	$akomodasi_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$akomodasi_juli25 = $akomodasi_biaya_juli25['total'] + $akomodasi_jurnal_juli25['total'];

	$listrik_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$listrik_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$listrik_juli25 = $listrik_biaya_juli25['total'] + $listrik_jurnal_juli25['total'];

	$thr_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$thr_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$thr_juli25 = $thr_biaya_juli25['total'] + $thr_jurnal_juli25['total'];

	$bensin_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$bensin_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$bensin_juli25 = $bensin_biaya_juli25['total'] + $bensin_jurnal_juli25['total'];

	$dinas_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$dinas_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$dinas_juli25 = $dinas_biaya_juli25['total'] + $dinas_jurnal_juli25['total'];

	$komunikasi_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$komunikasi_juli25 = $komunikasi_biaya_juli25['total'] + $komunikasi_jurnal_juli25['total'];

	$pakaian_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$pakaian_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$pakaian_juli25 = $pakaian_biaya_juli25['total'] + $pakaian_jurnal_juli25['total'];

	$tulis_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$tulis_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$tulis_juli25 = $tulis_biaya_juli25['total'] + $tulis_jurnal_juli25['total'];

	$keamanan_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$keamanan_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$keamanan_juli25 = $keamanan_biaya_juli25['total'] + $keamanan_jurnal_juli25['total'];

	$perlengkapan_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$perlengkapan_juli25 = $perlengkapan_biaya_juli25['total'] + $perlengkapan_jurnal_juli25['total'];

	$beban_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$beban_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$beban_juli25 = $beban_biaya_juli25['total'] + $beban_jurnal_juli25['total'];

	$adm_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$adm_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$adm_juli25 = $adm_biaya_juli25['total'] + $adm_jurnal_juli25['total'];

	$lain_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$lain_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$lain_juli25 = $lain_biaya_juli25['total'] + $lain_jurnal_juli25['total'];

	$sewa_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$sewa_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$sewa_juli25 = $sewa_biaya_juli25['total'] + $sewa_jurnal_juli25['total'];

	$bpjs_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$bpjs_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$bpjs_juli25 = $bpjs_biaya_juli25['total'] + $bpjs_jurnal_juli25['total'];

	$penyusutan_kantor_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$penyusutan_kantor_juli25 = $penyusutan_kantor_biaya_juli25['total'] + $penyusutan_kantor_jurnal_juli25['total'];

	$penyusutan_kendaraan_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_juli25 = $penyusutan_kendaraan_biaya_juli25['total'] + $penyusutan_kendaraan_jurnal_juli25['total'];

	$iuran_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$iuran_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$iuran_juli25 = $iuran_biaya_juli25['total'] + $iuran_jurnal_juli25['total'];

	$kendaraan_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$kendaraan_juli25 = $kendaraan_biaya_juli25['total'] + $kendaraan_jurnal_juli25['total'];

	$pajak_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$pajak_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$pajak_juli25 = $pajak_biaya_juli25['total'] + $pajak_jurnal_juli25['total'];

	$solar_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$solar_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$solar_juli25 = 0;

	$donasi_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$donasi_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$donasi_juli25 = $donasi_biaya_juli25['total'] + $donasi_jurnal_juli25['total'];

	$legal_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$legal_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$legal_juli25 = $legal_biaya_juli25['total'] + $legal_jurnal_juli25['total'];

	$pengobatan_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$pengobatan_juli25 = $pengobatan_biaya_juli25['total'] + $pengobatan_jurnal_juli25['total'];

	$lembur_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$lembur_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$lembur_juli25 = $lembur_biaya_juli25['total'] + $lembur_jurnal_juli25['total'];

	$pelatihan_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$pelatihan_juli25 = $pelatihan_biaya_juli25['total'] + $pelatihan_jurnal_juli25['total'];

	$supplies_biaya_juli25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();

	$supplies_jurnal_juli25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_juli25_awal' and '$date_juli25_akhir')")
	->get()->row_array();
	$supplies_juli25 = $supplies_biaya_juli25['total'] + $supplies_jurnal_juli25['total'];

	$total_operasional_juli25 = $konsumsi_juli25 + $gaji_juli25 + $upah_juli25 + $pengujian_juli25 + $perbaikan_juli25 + $akomodasi_juli25 + $listrik_juli25 + $thr_juli25 + 
	$bensin_juli25 + $dinas_juli25 + $komunikasi_juli25 + $pakaian_juli25 + $tulis_juli25 + $keamanan_juli25 + $perlengkapan_juli25 + $beban_juli25 + $adm_juli25 + 
	$lain_juli25 + $sewa_juli25 + $bpjs_juli25 + $penyusutan_kantor_juli25 + $penyusutan_kendaraan_juli25 + $iuran_juli25 + $kendaraan_juli25 + $pajak_juli25 + $solar_juli25 + 
	$donasi_juli25 + $legal_juli25 + $pengobatan_juli25 + $lembur_juli25 + $pelatihan_juli25 + $supplies_juli25;
	$nilai_realisasi_overhead_juli25_fix = round($total_operasional_juli25 / 1000000,0);

	//AGUSTUS25
	$nilai_rap_overhead_agustus25 = $overhead_ton * round($total_rekapitulasi_produksi_harian_agustus25,2);
	$nilai_rap_overhead_agustus25_fix = round($nilai_rap_overhead_agustus25 / 1000000,0);

	$konsumsi_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$konsumsi_agustus25 = $konsumsi_biaya_agustus25['total'] + $konsumsi_jurnal_agustus25['total'];

	$gaji_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$gaji_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$gaji_agustus25 = $gaji_biaya_agustus25['total'] + $gaji_jurnal_agustus25['total'];

	$upah_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$upah_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$upah_agustus25 = $upah_biaya_agustus25['total'] + $upah_jurnal_agustus25['total'];

	$pengujian_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$pengujian_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$pengujian_agustus25 = $pengujian_biaya_agustus25['total'] + $pengujian_jurnal_agustus25['total'];

	$perbaikan_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$perbaikan_agustus25 = $perbaikan_biaya_agustus25['total'] + $perbaikan_jurnal_agustus25['total'];

	$akomodasi_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$akomodasi_agustus25 = $akomodasi_biaya_agustus25['total'] + $akomodasi_jurnal_agustus25['total'];

	$listrik_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$listrik_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$listrik_agustus25 = $listrik_biaya_agustus25['total'] + $listrik_jurnal_agustus25['total'];

	$thr_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$thr_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$thr_agustus25 = $thr_biaya_agustus25['total'] + $thr_jurnal_agustus25['total'];

	$bensin_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$bensin_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$bensin_agustus25 = $bensin_biaya_agustus25['total'] + $bensin_jurnal_agustus25['total'];

	$dinas_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$dinas_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$dinas_agustus25 = $dinas_biaya_agustus25['total'] + $dinas_jurnal_agustus25['total'];

	$komunikasi_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$komunikasi_agustus25 = $komunikasi_biaya_agustus25['total'] + $komunikasi_jurnal_agustus25['total'];

	$pakaian_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$pakaian_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$pakaian_agustus25 = $pakaian_biaya_agustus25['total'] + $pakaian_jurnal_agustus25['total'];

	$tulis_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$tulis_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$tulis_agustus25 = $tulis_biaya_agustus25['total'] + $tulis_jurnal_agustus25['total'];

	$keamanan_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$keamanan_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$keamanan_agustus25 = $keamanan_biaya_agustus25['total'] + $keamanan_jurnal_agustus25['total'];

	$perlengkapan_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$perlengkapan_agustus25 = $perlengkapan_biaya_agustus25['total'] + $perlengkapan_jurnal_agustus25['total'];

	$beban_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$beban_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$beban_agustus25 = $beban_biaya_agustus25['total'] + $beban_jurnal_agustus25['total'];

	$adm_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$adm_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$adm_agustus25 = $adm_biaya_agustus25['total'] + $adm_jurnal_agustus25['total'];

	$lain_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$lain_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$lain_agustus25 = $lain_biaya_agustus25['total'] + $lain_jurnal_agustus25['total'];

	$sewa_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$sewa_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$sewa_agustus25 = $sewa_biaya_agustus25['total'] + $sewa_jurnal_agustus25['total'];

	$bpjs_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$bpjs_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$bpjs_agustus25 = $bpjs_biaya_agustus25['total'] + $bpjs_jurnal_agustus25['total'];

	$penyusutan_kantor_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$penyusutan_kantor_agustus25 = $penyusutan_kantor_biaya_agustus25['total'] + $penyusutan_kantor_jurnal_agustus25['total'];

	$penyusutan_kendaraan_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_agustus25 = $penyusutan_kendaraan_biaya_agustus25['total'] + $penyusutan_kendaraan_jurnal_agustus25['total'];

	$iuran_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$iuran_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$iuran_agustus25 = $iuran_biaya_agustus25['total'] + $iuran_jurnal_agustus25['total'];

	$kendaraan_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$kendaraan_agustus25 = $kendaraan_biaya_agustus25['total'] + $kendaraan_jurnal_agustus25['total'];

	$pajak_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$pajak_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$pajak_agustus25 = $pajak_biaya_agustus25['total'] + $pajak_jurnal_agustus25['total'];

	$solar_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$solar_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$solar_agustus25 = 0;

	$donasi_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$donasi_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$donasi_agustus25 = $donasi_biaya_agustus25['total'] + $donasi_jurnal_agustus25['total'];

	$legal_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$legal_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$legal_agustus25 = $legal_biaya_agustus25['total'] + $legal_jurnal_agustus25['total'];

	$pengobatan_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$pengobatan_agustus25 = $pengobatan_biaya_agustus25['total'] + $pengobatan_jurnal_agustus25['total'];

	$lembur_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$lembur_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$lembur_agustus25 = $lembur_biaya_agustus25['total'] + $lembur_jurnal_agustus25['total'];

	$pelatihan_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$pelatihan_agustus25 = $pelatihan_biaya_agustus25['total'] + $pelatihan_jurnal_agustus25['total'];

	$supplies_biaya_agustus25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();

	$supplies_jurnal_agustus25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_agustus25_awal' and '$date_agustus25_akhir')")
	->get()->row_array();
	$supplies_agustus25 = $supplies_biaya_agustus25['total'] + $supplies_jurnal_agustus25['total'];

	$total_operasional_agustus25 = $konsumsi_agustus25 + $gaji_agustus25 + $upah_agustus25 + $pengujian_agustus25 + $perbaikan_agustus25 + $akomodasi_agustus25 + $listrik_agustus25 + $thr_agustus25 + 
	$bensin_agustus25 + $dinas_agustus25 + $komunikasi_agustus25 + $pakaian_agustus25 + $tulis_agustus25 + $keamanan_agustus25 + $perlengkapan_agustus25 + $beban_agustus25 + $adm_agustus25 + 
	$lain_agustus25 + $sewa_agustus25 + $bpjs_agustus25 + $penyusutan_kantor_agustus25 + $penyusutan_kendaraan_agustus25 + $iuran_agustus25 + $kendaraan_agustus25 + $pajak_agustus25 + $solar_agustus25 + 
	$donasi_agustus25 + $legal_agustus25 + $pengobatan_agustus25 + $lembur_agustus25 + $pelatihan_agustus25 + $supplies_agustus25;
	$nilai_realisasi_overhead_agustus25_fix = round($total_operasional_agustus25 / 1000000,0);

	//SEPTEMBER25
	$nilai_rap_overhead_september25 = $overhead_ton * round($total_rekapitulasi_produksi_harian_september25,2);
	$nilai_rap_overhead_september25_fix = round($nilai_rap_overhead_september25 / 1000000,0);

	$konsumsi_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$konsumsi_september25 = $konsumsi_biaya_september25['total'] + $konsumsi_jurnal_september25['total'];

	$gaji_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$gaji_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$gaji_september25 = $gaji_biaya_september25['total'] + $gaji_jurnal_september25['total'];

	$upah_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$upah_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$upah_september25 = $upah_biaya_september25['total'] + $upah_jurnal_september25['total'];

	$pengujian_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$pengujian_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$pengujian_september25 = $pengujian_biaya_september25['total'] + $pengujian_jurnal_september25['total'];

	$perbaikan_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$perbaikan_september25 = $perbaikan_biaya_september25['total'] + $perbaikan_jurnal_september25['total'];

	$akomodasi_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$akomodasi_september25 = $akomodasi_biaya_september25['total'] + $akomodasi_jurnal_september25['total'];

	$listrik_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$listrik_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$listrik_september25 = $listrik_biaya_september25['total'] + $listrik_jurnal_september25['total'];

	$thr_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$thr_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$thr_september25 = $thr_biaya_september25['total'] + $thr_jurnal_september25['total'];

	$bensin_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$bensin_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$bensin_september25 = $bensin_biaya_september25['total'] + $bensin_jurnal_september25['total'];

	$dinas_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$dinas_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$dinas_september25 = $dinas_biaya_september25['total'] + $dinas_jurnal_september25['total'];

	$komunikasi_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$komunikasi_september25 = $komunikasi_biaya_september25['total'] + $komunikasi_jurnal_september25['total'];

	$pakaian_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$pakaian_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$pakaian_september25 = $pakaian_biaya_september25['total'] + $pakaian_jurnal_september25['total'];

	$tulis_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$tulis_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$tulis_september25 = $tulis_biaya_september25['total'] + $tulis_jurnal_september25['total'];

	$keamanan_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$keamanan_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$keamanan_september25 = $keamanan_biaya_september25['total'] + $keamanan_jurnal_september25['total'];

	$perlengkapan_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$perlengkapan_september25 = $perlengkapan_biaya_september25['total'] + $perlengkapan_jurnal_september25['total'];

	$beban_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$beban_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$beban_september25 = $beban_biaya_september25['total'] + $beban_jurnal_september25['total'];

	$adm_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$adm_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$adm_september25 = $adm_biaya_september25['total'] + $adm_jurnal_september25['total'];

	$lain_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$lain_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$lain_september25 = $lain_biaya_september25['total'] + $lain_jurnal_september25['total'];

	$sewa_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$sewa_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$sewa_september25 = $sewa_biaya_september25['total'] + $sewa_jurnal_september25['total'];

	$bpjs_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$bpjs_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$bpjs_september25 = $bpjs_biaya_september25['total'] + $bpjs_jurnal_september25['total'];

	$penyusutan_kantor_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$penyusutan_kantor_september25 = $penyusutan_kantor_biaya_september25['total'] + $penyusutan_kantor_jurnal_september25['total'];

	$penyusutan_kendaraan_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_september25 = $penyusutan_kendaraan_biaya_september25['total'] + $penyusutan_kendaraan_jurnal_september25['total'];

	$iuran_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$iuran_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$iuran_september25 = $iuran_biaya_september25['total'] + $iuran_jurnal_september25['total'];

	$kendaraan_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$kendaraan_september25 = $kendaraan_biaya_september25['total'] + $kendaraan_jurnal_september25['total'];

	$pajak_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$pajak_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$pajak_september25 = $pajak_biaya_september25['total'] + $pajak_jurnal_september25['total'];

	$solar_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$solar_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$solar_september25 = 0;

	$donasi_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$donasi_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$donasi_september25 = $donasi_biaya_september25['total'] + $donasi_jurnal_september25['total'];

	$legal_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$legal_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$legal_september25 = $legal_biaya_september25['total'] + $legal_jurnal_september25['total'];

	$pengobatan_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$pengobatan_september25 = $pengobatan_biaya_september25['total'] + $pengobatan_jurnal_september25['total'];

	$lembur_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$lembur_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$lembur_september25 = $lembur_biaya_september25['total'] + $lembur_jurnal_september25['total'];

	$pelatihan_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$pelatihan_september25 = $pelatihan_biaya_september25['total'] + $pelatihan_jurnal_september25['total'];

	$supplies_biaya_september25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();

	$supplies_jurnal_september25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_september25_awal' and '$date_september25_akhir')")
	->get()->row_array();
	$supplies_september25 = $supplies_biaya_september25['total'] + $supplies_jurnal_september25['total'];

	$total_operasional_september25 = $konsumsi_september25 + $gaji_september25 + $upah_september25 + $pengujian_september25 + $perbaikan_september25 + $akomodasi_september25 + $listrik_september25 + $thr_september25 + 
	$bensin_september25 + $dinas_september25 + $komunikasi_september25 + $pakaian_september25 + $tulis_september25 + $keamanan_september25 + $perlengkapan_september25 + $beban_september25 + $adm_september25 + 
	$lain_september25 + $sewa_september25 + $bpjs_september25 + $penyusutan_kantor_september25 + $penyusutan_kendaraan_september25 + $iuran_september25 + $kendaraan_september25 + $pajak_september25 + $solar_september25 + 
	$donasi_september25 + $legal_september25 + $pengobatan_september25 + $lembur_september25 + $pelatihan_september25 + $supplies_september25;
	$nilai_realisasi_overhead_september25_fix = round($total_operasional_september25 / 1000000,0);

	//OKTOBER25
	$nilai_rap_overhead_oktober25 = $overhead_ton * round($total_rekapitulasi_produksi_harian_oktober25,2);
	$nilai_rap_overhead_oktober25_fix = round($nilai_rap_overhead_oktober25 / 1000000,0);

	$konsumsi_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$konsumsi_oktober25 = $konsumsi_biaya_oktober25['total'] + $konsumsi_jurnal_oktober25['total'];

	$gaji_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$gaji_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$gaji_oktober25 = $gaji_biaya_oktober25['total'] + $gaji_jurnal_oktober25['total'];

	$upah_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$upah_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$upah_oktober25 = $upah_biaya_oktober25['total'] + $upah_jurnal_oktober25['total'];

	$pengujian_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$pengujian_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$pengujian_oktober25 = $pengujian_biaya_oktober25['total'] + $pengujian_jurnal_oktober25['total'];

	$perbaikan_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$perbaikan_oktober25 = $perbaikan_biaya_oktober25['total'] + $perbaikan_jurnal_oktober25['total'];

	$akomodasi_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$akomodasi_oktober25 = $akomodasi_biaya_oktober25['total'] + $akomodasi_jurnal_oktober25['total'];

	$listrik_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$listrik_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$listrik_oktober25 = $listrik_biaya_oktober25['total'] + $listrik_jurnal_oktober25['total'];

	$thr_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$thr_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$thr_oktober25 = $thr_biaya_oktober25['total'] + $thr_jurnal_oktober25['total'];

	$bensin_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$bensin_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$bensin_oktober25 = $bensin_biaya_oktober25['total'] + $bensin_jurnal_oktober25['total'];

	$dinas_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$dinas_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$dinas_oktober25 = $dinas_biaya_oktober25['total'] + $dinas_jurnal_oktober25['total'];

	$komunikasi_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$komunikasi_oktober25 = $komunikasi_biaya_oktober25['total'] + $komunikasi_jurnal_oktober25['total'];

	$pakaian_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$pakaian_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$pakaian_oktober25 = $pakaian_biaya_oktober25['total'] + $pakaian_jurnal_oktober25['total'];

	$tulis_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$tulis_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$tulis_oktober25 = $tulis_biaya_oktober25['total'] + $tulis_jurnal_oktober25['total'];

	$keamanan_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$keamanan_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$keamanan_oktober25 = $keamanan_biaya_oktober25['total'] + $keamanan_jurnal_oktober25['total'];

	$perlengkapan_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$perlengkapan_oktober25 = $perlengkapan_biaya_oktober25['total'] + $perlengkapan_jurnal_oktober25['total'];

	$beban_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$beban_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$beban_oktober25 = $beban_biaya_oktober25['total'] + $beban_jurnal_oktober25['total'];

	$adm_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$adm_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$adm_oktober25 = $adm_biaya_oktober25['total'] + $adm_jurnal_oktober25['total'];

	$lain_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$lain_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$lain_oktober25 = $lain_biaya_oktober25['total'] + $lain_jurnal_oktober25['total'];

	$sewa_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$sewa_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$sewa_oktober25 = $sewa_biaya_oktober25['total'] + $sewa_jurnal_oktober25['total'];

	$bpjs_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$bpjs_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$bpjs_oktober25 = $bpjs_biaya_oktober25['total'] + $bpjs_jurnal_oktober25['total'];

	$penyusutan_kantor_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$penyusutan_kantor_oktober25 = $penyusutan_kantor_biaya_oktober25['total'] + $penyusutan_kantor_jurnal_oktober25['total'];

	$penyusutan_kendaraan_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_oktober25 = $penyusutan_kendaraan_biaya_oktober25['total'] + $penyusutan_kendaraan_jurnal_oktober25['total'];

	$iuran_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$iuran_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$iuran_oktober25 = $iuran_biaya_oktober25['total'] + $iuran_jurnal_oktober25['total'];

	$kendaraan_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$kendaraan_oktober25 = $kendaraan_biaya_oktober25['total'] + $kendaraan_jurnal_oktober25['total'];

	$pajak_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$pajak_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$pajak_oktober25 = $pajak_biaya_oktober25['total'] + $pajak_jurnal_oktober25['total'];

	$solar_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$solar_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$solar_oktober25 = 0;

	$donasi_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$donasi_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$donasi_oktober25 = $donasi_biaya_oktober25['total'] + $donasi_jurnal_oktober25['total'];

	$legal_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$legal_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$legal_oktober25 = $legal_biaya_oktober25['total'] + $legal_jurnal_oktober25['total'];

	$pengobatan_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$pengobatan_oktober25 = $pengobatan_biaya_oktober25['total'] + $pengobatan_jurnal_oktober25['total'];

	$lembur_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$lembur_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$lembur_oktober25 = $lembur_biaya_oktober25['total'] + $lembur_jurnal_oktober25['total'];

	$pelatihan_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$pelatihan_oktober25 = $pelatihan_biaya_oktober25['total'] + $pelatihan_jurnal_oktober25['total'];

	$supplies_biaya_oktober25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();

	$supplies_jurnal_oktober25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_oktober25_awal' and '$date_oktober25_akhir')")
	->get()->row_array();
	$supplies_oktober25 = $supplies_biaya_oktober25['total'] + $supplies_jurnal_oktober25['total'];

	$total_operasional_oktober25 = $konsumsi_oktober25 + $gaji_oktober25 + $upah_oktober25 + $pengujian_oktober25 + $perbaikan_oktober25 + $akomodasi_oktober25 + $listrik_oktober25 + $thr_oktober25 + 
	$bensin_oktober25 + $dinas_oktober25 + $komunikasi_oktober25 + $pakaian_oktober25 + $tulis_oktober25 + $keamanan_oktober25 + $perlengkapan_oktober25 + $beban_oktober25 + $adm_oktober25 + 
	$lain_oktober25 + $sewa_oktober25 + $bpjs_oktober25 + $penyusutan_kantor_oktober25 + $penyusutan_kendaraan_oktober25 + $iuran_oktober25 + $kendaraan_oktober25 + $pajak_oktober25 + $solar_oktober25 + 
	$donasi_oktober25 + $legal_oktober25 + $pengobatan_oktober25 + $lembur_oktober25 + $pelatihan_oktober25 + $supplies_oktober25;
	$nilai_realisasi_overhead_oktober25_fix = round($total_operasional_oktober25 / 1000000,0);

	//NOVEMBER25
	$nilai_rap_overhead_november25 = $overhead_ton * round($total_rekapitulasi_produksi_harian_november25,2);
	$nilai_rap_overhead_november25_fix = round($nilai_rap_overhead_november25 / 1000000,0);

	$konsumsi_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$konsumsi_november25 = $konsumsi_biaya_november25['total'] + $konsumsi_jurnal_november25['total'];

	$gaji_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$gaji_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$gaji_november25 = $gaji_biaya_november25['total'] + $gaji_jurnal_november25['total'];

	$upah_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$upah_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$upah_november25 = $upah_biaya_november25['total'] + $upah_jurnal_november25['total'];

	$pengujian_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$pengujian_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$pengujian_november25 = $pengujian_biaya_november25['total'] + $pengujian_jurnal_november25['total'];

	$perbaikan_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$perbaikan_november25 = $perbaikan_biaya_november25['total'] + $perbaikan_jurnal_november25['total'];

	$akomodasi_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$akomodasi_november25 = $akomodasi_biaya_november25['total'] + $akomodasi_jurnal_november25['total'];

	$listrik_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$listrik_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$listrik_november25 = $listrik_biaya_november25['total'] + $listrik_jurnal_november25['total'];

	$thr_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$thr_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$thr_november25 = $thr_biaya_november25['total'] + $thr_jurnal_november25['total'];

	$bensin_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$bensin_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$bensin_november25 = $bensin_biaya_november25['total'] + $bensin_jurnal_november25['total'];

	$dinas_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$dinas_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$dinas_november25 = $dinas_biaya_november25['total'] + $dinas_jurnal_november25['total'];

	$komunikasi_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$komunikasi_november25 = $komunikasi_biaya_november25['total'] + $komunikasi_jurnal_november25['total'];

	$pakaian_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$pakaian_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$pakaian_november25 = $pakaian_biaya_november25['total'] + $pakaian_jurnal_november25['total'];

	$tulis_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$tulis_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$tulis_november25 = $tulis_biaya_november25['total'] + $tulis_jurnal_november25['total'];

	$keamanan_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$keamanan_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$keamanan_november25 = $keamanan_biaya_november25['total'] + $keamanan_jurnal_november25['total'];

	$perlengkapan_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$perlengkapan_november25 = $perlengkapan_biaya_november25['total'] + $perlengkapan_jurnal_november25['total'];

	$beban_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$beban_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$beban_november25 = $beban_biaya_november25['total'] + $beban_jurnal_november25['total'];

	$adm_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$adm_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$adm_november25 = $adm_biaya_november25['total'] + $adm_jurnal_november25['total'];

	$lain_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$lain_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$lain_november25 = $lain_biaya_november25['total'] + $lain_jurnal_november25['total'];

	$sewa_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$sewa_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$sewa_november25 = $sewa_biaya_november25['total'] + $sewa_jurnal_november25['total'];

	$bpjs_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$bpjs_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$bpjs_november25 = $bpjs_biaya_november25['total'] + $bpjs_jurnal_november25['total'];

	$penyusutan_kantor_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$penyusutan_kantor_november25 = $penyusutan_kantor_biaya_november25['total'] + $penyusutan_kantor_jurnal_november25['total'];

	$penyusutan_kendaraan_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_november25 = $penyusutan_kendaraan_biaya_november25['total'] + $penyusutan_kendaraan_jurnal_november25['total'];

	$iuran_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$iuran_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$iuran_november25 = $iuran_biaya_november25['total'] + $iuran_jurnal_november25['total'];

	$kendaraan_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$kendaraan_november25 = $kendaraan_biaya_november25['total'] + $kendaraan_jurnal_november25['total'];

	$pajak_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$pajak_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$pajak_november25 = $pajak_biaya_november25['total'] + $pajak_jurnal_november25['total'];

	$solar_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$solar_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$solar_november25 = 0;

	$donasi_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$donasi_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$donasi_november25 = $donasi_biaya_november25['total'] + $donasi_jurnal_november25['total'];

	$legal_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$legal_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$legal_november25 = $legal_biaya_november25['total'] + $legal_jurnal_november25['total'];

	$pengobatan_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$pengobatan_november25 = $pengobatan_biaya_november25['total'] + $pengobatan_jurnal_november25['total'];

	$lembur_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$lembur_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$lembur_november25 = $lembur_biaya_november25['total'] + $lembur_jurnal_november25['total'];

	$pelatihan_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$pelatihan_november25 = $pelatihan_biaya_november25['total'] + $pelatihan_jurnal_november25['total'];

	$supplies_biaya_november25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();

	$supplies_jurnal_november25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_november25_awal' and '$date_november25_akhir')")
	->get()->row_array();
	$supplies_november25 = $supplies_biaya_november25['total'] + $supplies_jurnal_november25['total'];

	$total_operasional_november25 = $konsumsi_november25 + $gaji_november25 + $upah_november25 + $pengujian_november25 + $perbaikan_november25 + $akomodasi_november25 + $listrik_november25 + $thr_november25 + 
	$bensin_november25 + $dinas_november25 + $komunikasi_november25 + $pakaian_november25 + $tulis_november25 + $keamanan_november25 + $perlengkapan_november25 + $beban_november25 + $adm_november25 + 
	$lain_november25 + $sewa_november25 + $bpjs_november25 + $penyusutan_kantor_november25 + $penyusutan_kendaraan_november25 + $iuran_november25 + $kendaraan_november25 + $pajak_november25 + $solar_november25 + 
	$donasi_november25 + $legal_november25 + $pengobatan_november25 + $lembur_november25 + $pelatihan_november25 + $supplies_november25;
	$nilai_realisasi_overhead_november25_fix = round($total_operasional_november25 / 1000000,0);

	//DESEMBER25
	$nilai_rap_overhead_desember25 = $overhead_ton * round($total_rekapitulasi_produksi_harian_desember25,2);
	$nilai_rap_overhead_desember25_fix = round($nilai_rap_overhead_desember25 / 1000000,0);

	$konsumsi_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$konsumsi_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 201")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$konsumsi_desember25 = $konsumsi_biaya_desember25['total'] + $konsumsi_jurnal_desember25['total'];

	$gaji_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$gaji_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 199")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$gaji_desember25 = $gaji_biaya_desember25['total'] + $gaji_jurnal_desember25['total'];

	$upah_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$upah_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 200")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$upah_desember25 = $upah_biaya_desember25['total'] + $upah_jurnal_desember25['total'];

	$pengujian_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$pengujian_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 205")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$pengujian_desember25 = $pengujian_biaya_desember25['total'] + $pengujian_jurnal_desember25['total'];

	$perbaikan_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$perbaikan_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 203")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$perbaikan_desember25 = $perbaikan_biaya_desember25['total'] + $perbaikan_jurnal_desember25['total'];

	$akomodasi_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$akomodasi_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 204")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$akomodasi_desember25 = $akomodasi_biaya_desember25['total'] + $akomodasi_jurnal_desember25['total'];

	$listrik_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$listrik_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 206")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$listrik_desember25 = $listrik_biaya_desember25['total'] + $listrik_jurnal_desember25['total'];

	$thr_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$thr_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 202")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$thr_desember25 = $thr_biaya_desember25['total'] + $thr_jurnal_desember25['total'];

	$bensin_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$bensin_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 129")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$bensin_desember25 = $bensin_biaya_desember25['total'] + $bensin_jurnal_desember25['total'];

	$dinas_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$dinas_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 131")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$dinas_desember25 = $dinas_biaya_desember25['total'] + $dinas_jurnal_desember25['total'];

	$komunikasi_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$komunikasi_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 133")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$komunikasi_desember25 = $komunikasi_biaya_desember25['total'] + $komunikasi_jurnal_desember25['total'];

	$pakaian_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$pakaian_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 138")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$pakaian_desember25 = $pakaian_biaya_desember25['total'] + $pakaian_jurnal_desember25['total'];

	$tulis_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$tulis_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 149")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$tulis_desember25 = $tulis_biaya_desember25['total'] + $tulis_jurnal_desember25['total'];

	$keamanan_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$keamanan_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 151")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$keamanan_desember25 = $keamanan_biaya_desember25['total'] + $keamanan_jurnal_desember25['total'];

	$perlengkapan_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$perlengkapan_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 153")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$perlengkapan_desember25 = $perlengkapan_biaya_desember25['total'] + $perlengkapan_jurnal_desember25['total'];

	$beban_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$beban_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 145")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$beban_desember25 = $beban_biaya_desember25['total'] + $beban_jurnal_desember25['total'];

	$adm_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$adm_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 143")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$adm_desember25 = $adm_biaya_desember25['total'] + $adm_jurnal_desember25['total'];

	$lain_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$lain_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 146")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$lain_desember25 = $lain_biaya_desember25['total'] + $lain_jurnal_desember25['total'];

	$sewa_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$sewa_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 154")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$sewa_desember25 = $sewa_biaya_desember25['total'] + $sewa_jurnal_desember25['total'];

	$bpjs_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$bpjs_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 123")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$bpjs_desember25 = $bpjs_biaya_desember25['total'] + $bpjs_jurnal_desember25['total'];

	$penyusutan_kantor_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$penyusutan_kantor_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 162")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$penyusutan_kantor_desember25 = $penyusutan_kantor_biaya_desember25['total'] + $penyusutan_kantor_jurnal_desember25['total'];

	$penyusutan_kendaraan_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$penyusutan_kendaraan_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 160")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$penyusutan_kendaraan_desember25 = $penyusutan_kendaraan_biaya_desember25['total'] + $penyusutan_kendaraan_jurnal_desember25['total'];

	$iuran_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$iuran_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 134")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$iuran_desember25 = $iuran_biaya_desember25['total'] + $iuran_jurnal_desember25['total'];

	$kendaraan_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$kendaraan_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 155")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$kendaraan_desember25 = $kendaraan_biaya_desember25['total'] + $kendaraan_jurnal_desember25['total'];

	$pajak_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$pajak_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 141")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$pajak_desember25 = $pajak_biaya_desember25['total'] + $pajak_jurnal_desember25['total'];

	$solar_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$solar_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 105")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$solar_desember25 = 0;

	$donasi_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$donasi_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 127")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$donasi_desember25 = $donasi_biaya_desember25['total'] + $donasi_jurnal_desember25['total'];

	$legal_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$legal_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 136")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$legal_desember25 = $legal_biaya_desember25['total'] + $legal_jurnal_desember25['total'];

	$pengobatan_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$pengobatan_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 121")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$pengobatan_desember25 = $pengobatan_biaya_desember25['total'] + $pengobatan_jurnal_desember25['total'];

	$lembur_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$lembur_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 120")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$lembur_desember25 = $lembur_biaya_desember25['total'] + $lembur_jurnal_desember25['total'];

	$pelatihan_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$pelatihan_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 139")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$pelatihan_desember25 = $pelatihan_biaya_desember25['total'] + $pelatihan_jurnal_desember25['total'];

	$supplies_biaya_desember25 = $this->db->select('sum(pdb.jumlah) as total')
	->from('pmm_biaya pb ')
	->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();

	$supplies_jurnal_desember25 = $this->db->select('sum(pdb.debit) as total')
	->from('pmm_jurnal_umum pb ')
	->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
	->where("pdb.akun = 152")
	->where("status = 'PAID'")
	->where("(tanggal_transaksi between '$date_desember25_awal' and '$date_desember25_akhir')")
	->get()->row_array();
	$supplies_desember25 = $supplies_biaya_desember25['total'] + $supplies_jurnal_desember25['total'];

	$total_operasional_desember25 = $konsumsi_desember25 + $gaji_desember25 + $upah_desember25 + $pengujian_desember25 + $perbaikan_desember25 + $akomodasi_desember25 + $listrik_desember25 + $thr_desember25 + 
	$bensin_desember25 + $dinas_desember25 + $komunikasi_desember25 + $pakaian_desember25 + $tulis_desember25 + $keamanan_desember25 + $perlengkapan_desember25 + $beban_desember25 + $adm_desember25 + 
	$lain_desember25 + $sewa_desember25 + $bpjs_desember25 + $penyusutan_kantor_desember25 + $penyusutan_kendaraan_desember25 + $iuran_desember25 + $kendaraan_desember25 + $pajak_desember25 + $solar_desember25 + 
	$donasi_desember25 + $legal_desember25 + $pengobatan_desember25 + $lembur_desember25 + $pelatihan_desember25 + $supplies_desember25;
	$nilai_realisasi_overhead_desember25_fix = round($total_operasional_desember25 / 1000000,0);
?>