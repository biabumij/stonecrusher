<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produksi extends Secure_Controller {

	public function __construct()
	{
        parent::__construct();
        // Your own constructor code
        $this->load->model(array('admin/m_admin','crud_global','m_themes','pages/m_pages','menu/m_menu','admin_access/m_admin_access','DB_model','member_back/m_member_back','m_member','pmm/pmm_model','admin/Templates','pmm/pmm_finance','produk/m_produk'));
        $this->load->library('enkrip');
		$this->load->library('filter');
		$this->load->library('waktu');
		$this->load->library('session');
    }
	
	public function remaining_material_print()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        
        $pdf->SetFont('helvetica','',7); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		        $pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;

		$this->db->where('status','PUBLISH');
		$this->db->order_by('date','desc');
		$this->db->order_by('id','desc');
		if(!empty($this->input->get('filter_tag'))){
			$this->db->where('filter_tag',$this->input->post('filter_tag'));
		}
		$filter_date = $this->input->get('filter_date');
		if(!empty($filter_date)){
			$arr_date = explode(' - ', $filter_date);
			$this->db->where('date >=',date('Y-m-d',strtotime($arr_date[0])));
			$this->db->where('date <=',date('Y-m-d',strtotime($arr_date[1])));
		}
		$query = $this->db->get('pmm_remaining_materials_cat');
		$data['data'] = $query->result_array();
		$data['custom_date'] = $this->input->get('custom_date');
        $html = $this->load->view('produksi/remaining_material_print',$data,TRUE);

        
        $pdf->SetTitle('Sisa Bahan');
        $pdf->nsi_html($html);
        $pdf->Output('Sisa-Bahan.pdf', 'I');
	
	}
	
	public function form_kalibrasi()
	{
		$check = $this->m_admin->check_login();
		if ($check == true) {
			$data['products'] = $this->db->select('*')->get_where('produk', array('status' => 'PUBLISH', 'agregat' => 1))->result_array();
			$data['measures'] = $this->db->select('*')->get_where('pmm_measures', array('status' => 'PUBLISH'))->result_array();
			$this->load->view('produksi/form_kalibrasi', $data);
		} else {
			redirect('admin');
		}
	}
	
	public function submit_kalibrasi()
	{
		$date_kalibrasi = $this->input->post('date_kalibrasi');
		$no_kalibrasi = $this->input->post('no_kalibrasi');
		$jobs_type = $this->input->post('jobs_type');
		
		$produk_a = $this->input->post('produk_a');
		$produk_b = $this->input->post('produk_b');
		$produk_c = $this->input->post('produk_c');
		$produk_d = $this->input->post('produk_d');
		$produk_e = $this->input->post('produk_e');
		$produk_f = $this->input->post('produk_f');
		$measure_a = $this->input->post('measure_a');
		$measure_b = $this->input->post('measure_b');
		$measure_c = $this->input->post('measure_c');
		$measure_d = $this->input->post('measure_d');
		$measure_e = $this->input->post('measure_e');
		$measure_f = $this->input->post('measure_f');
		$presentase_a = $this->input->post('presentase_a');
		$presentase_b = $this->input->post('presentase_b');
		$presentase_c = $this->input->post('presentase_c');
		$presentase_d = $this->input->post('presentase_d');
		$presentase_e = $this->input->post('presentase_e');
		$presentase_f = $this->input->post('presentase_f');
		
		$memo = $this->input->post('memo');
		$attach = $this->input->post('files[]');


		$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

		$arr_insert = array(
			'date_kalibrasi' => date('Y-m-d', strtotime($date_kalibrasi)),
			'no_kalibrasi' => $no_kalibrasi,
			'jobs_type' => $jobs_type,
			'produk_a' => $produk_a,
			'produk_b' => $produk_b,
			'produk_c' => $produk_c,
			'produk_d' => $produk_d,
			'produk_e' => $produk_e,
			'produk_f' => $produk_f,
			'measure_a' => $measure_a,
			'measure_b' => $measure_b,
			'measure_c' => $measure_c,
			'measure_d' => $measure_d,
			'measure_e' => $measure_e,
			'measure_f' => $measure_f,
			'presentase_a' => $presentase_a,
			'presentase_b' => $presentase_b,
			'presentase_c' => $presentase_c,
			'presentase_d' => $presentase_d,
			'presentase_e' => $presentase_e,
			'presentase_f' => $presentase_f,
			'memo' => $memo,
			'attach' => $attach,
			'status' => 'PUBLISH',
			'created_by' => $this->session->userdata('admin_id'),
			'created_on' => date('Y-m-d H:i:s')
		);

		if ($this->db->insert('pmm_kalibrasi', $arr_insert)) {
			$kalibrasi_id = $this->db->insert_id();

			if (!file_exists('uploads/kalibrasi')) {
			    mkdir('uploads/kalibrasi', 0777, true);
			}

			$data = [];
			$count = count($_FILES['files']['name']);
			for ($i = 0; $i < $count; $i++) {

				if (!empty($_FILES['files']['name'][$i])) {

					$_FILES['file']['name'] = $_FILES['files']['name'][$i];
					$_FILES['file']['type'] = $_FILES['files']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['files']['error'][$i];
					$_FILES['file']['size'] = $_FILES['files']['size'][$i];

					$config['upload_path'] = 'uploads/kalibrasi';
					$config['allowed_types'] = 'jpg|jpeg|png|pdf';
					$config['file_name'] = $_FILES['files']['name'][$i];

					$this->load->library('upload', $config);

					if ($this->upload->do_upload('file')) {
						$uploadData = $this->upload->data();
						$filename = $uploadData['file_name'];

						$data['totalFiles'][] = $filename;


						$data[$i] = array(
							'kalibrasi_id' => $kalibrasi_id,
							'lampiran'  => $data['totalFiles'][$i]
						);

						$this->db->insert('pmm_lampiran_kalibrasi', $data[$i]);
					}
				}
			}
		}


		if ($this->db->trans_status() === FALSE) {
			# Something went wrong.
			$this->db->trans_rollback();
			$this->session->set_flashdata('notif_error', '<b>REJECTED</b>');
			redirect('produksi/kalibrasi');
		} else {
			# Everything is Perfect. 
			# Committing data to the database.
			$this->db->trans_commit();
			$this->session->set_flashdata('notif_success', '<b>SAVED</b>');
			redirect('admin/produksi');
		}
	}

	public function table_kalibrasi()
	{   
        $data = array();
		$filter_date = $this->input->post('filter_date');
		if(!empty($filter_date)){
			$arr_date = explode(' - ', $filter_date);
			$this->db->where('kb.date_kalibrasi >=',date('Y-m-d',strtotime($arr_date[0])));
			$this->db->where('kb.date_kalibrasi <=',date('Y-m-d',strtotime($arr_date[1])));
		}
		$jobs_type = $this->input->post('jobs_type');
		if(!empty($jobs_type)){
			$this->db->where('kb.jobs_type',$jobs_type);
		}
        $this->db->select('kb.id, kb.jobs_type, kb.no_kalibrasi, kb.date_kalibrasi, lk.kalibrasi_id, lk.lampiran, kb.created_by, kb.created_on, kb.status');
		$this->db->join('pmm_lampiran_kalibrasi lk', 'kb.id = lk.kalibrasi_id','left');
		$this->db->where('kb.date_kalibrasi >=', date('2023-08-01'));
		$this->db->order_by('kb.created_on','desc');		
		$query = $this->db->get('pmm_kalibrasi kb');
		
       if($query->num_rows() > 0){
			foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
				$row['jobs_type'] = $row["jobs_type"];
                $row['tanggal_kalibrasi'] = date('d-m-Y',strtotime($row['date_kalibrasi']));
                $row['no_kalibrasi'] = $row['no_kalibrasi'];
				$row['lampiran'] = "<a  target='_blank' href=" . base_url('uploads/kalibrasi/' . $row["lampiran"]) . ">" . $row["lampiran"] . "</a>";  
                $row['admin_name'] = $this->crud_global->GetField('tbl_admin',array('admin_id'=>$row['created_by']),'admin_name');
                $row['created_on'] = date('d/m/Y H:i:s',strtotime($row['created_on']));
				$row['status'] = $this->pmm_model->GetStatus4($row['status']);
				$row['view'] = '<a href="'.site_url().'produksi/data_kalibrasi/'.$row['id'].'" class="btn btn-warning" style="border-radius:10px";><i class="glyphicon glyphicon-folder-open"></i> </a>';
				$row['print'] = '<a href="'.site_url().'produksi/cetak_kalibrasi/'.$row['id'].'" target="_blank" class="btn btn-info" style="border-radius:10px"><i class="fa fa-print"></i> </a>';
				if($this->session->userdata('admin_group_id') == 1 || $this->session->userdata('admin_group_id') == 5 || $this->session->userdata('admin_group_id') == 6 || $this->session->userdata('admin_group_id') == 11 || $this->session->userdata('admin_group_id') == 15){
					$row['actions'] = '<a href="javascript:void(0);" onclick="DeleteDataKalibrasi('.$row['id'].')" class="btn btn-danger" style="font-weight:bold; border-radius:10px;"><i class="fa fa-close"></i> </a>';
				}else {
					$row['actions'] = '<button type="button" class="btn btn-danger" style="font-weight:bold; border-radius:10px;"><i class="fa fa-ban"></i> No Access</button>';
				}
				
                $data[] = $row;
            }

        }
        echo json_encode(array('data'=>$data));
    }
          
	public function approve_kalibrasi($id)
    {
        $this->db->set("status", "OPEN");
        $this->db->where("id", $id);
        $this->db->update("kalibrasi");

        $this->db->update('kalibrasi_detail', array('status' => 'OPEN'), array('kalibrasi_id' => $id));
        $this->session->set_flashdata('notif_success', 'Berhasil menyetujui Kalibrasi');
        redirect("admin/produksi");
    }

    public function closed_kalibrasi($id)
    {
        $this->db->set("status", "CLOSED");
        $this->db->where("id", $id);
        $this->db->update("kalibrasi");

        $this->db->update('kalibrasi_detail', array('status' => 'CLOSED'), array('kalibrasi_id' => $id));
        $this->session->set_flashdata('notif_success', 'Berhasil Melakukan Closed Kalibrasi');
        redirect("admin/produksi");
    }

    public function hapus_kalibrasi($id)
    {
        $this->db->trans_start(); # Starting Transaction


        $this->db->delete('pmm_kalibrasi', array('id' => $id));

        if ($this->db->trans_status() === FALSE) {
            # Something went wrong.
            $this->db->trans_rollback();
            $this->session->set_flashdata('notif_error', 'Gagal Menghapus Kalibrasi');
            redirect('produksi/data_kalibrasi');
        } else {
            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            $this->session->set_flashdata('notif_success', 'Berhasil Menghapus Kalibrasi');
            redirect("admin/produksi");
        }
    }
	
	public function data_kalibrasi($id)
	{
		$check = $this->m_admin->check_login();
		if ($check == true) {
			$data['tes'] = '';
			$data['kalibrasi'] = $this->db->get_where("pmm_kalibrasi", ["id" => $id])->row_array();
			$data['lampiran'] = $this->db->get_where("pmm_lampiran_kalibrasi", ["kalibrasi_id" => $id])->result_array();
			$this->load->view('produksi/data_kalibrasi', $data);
		} else {
			redirect('admin');
		}
	}
	
	public function cetak_kalibrasi($id){

		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $pdf->SetFont('helvetica','',7); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$data['row'] = $this->db->get_where('pmm_kalibrasi',array('id'=>$id))->row_array();
        $html = $this->load->view('produksi/cetak_kalibrasi',$data,TRUE);
        $row = $this->db->get_where('pmm_kalibrasi',array('id'=>$id))->row_array();


        
        $pdf->SetTitle($row['no_kalibrasi']);
        $pdf->nsi_html($html);
        $pdf->Output($row['no_kalibrasi'].'.pdf', 'I');
	}
	
	public function form_produksi_harian()
	{
		$check = $this->m_admin->check_login();
		if ($check == true) {
			$data['kalibrasi'] = $this->db->select('*')->get_where('pmm_kalibrasi', array('status' => 'PUBLISH'))->result_array();
			$this->load->view('produksi/form_produksi_harian', $data);
		} else {
			redirect('admin');
		}
	}
	
	
	public function submit_produksi_harian()
	{
		$date_prod = $this->input->post('date_prod');
		$no_prod = $this->input->post('no_prod');
		$total_product = $this->input->post('total_product');
		$memo = $this->input->post('memo');
		$attach = $this->input->post('files[]');

		$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

		$arr_insert = array(
			'date_prod' => date('Y-m-d', strtotime($date_prod)),	
			'no_prod' => $no_prod,			
			'memo' => $memo,
			'attach' => $attach,
			'status' => 'PUBLISH',
			'created_by' => $this->session->userdata('admin_id'),
			'created_on' => date('Y-m-d H:i:s')
		);

		if ($this->db->insert('pmm_produksi_harian', $arr_insert)) {
			$produksi_harian_id = $this->db->insert_id();

			if (!file_exists('uploads/produksi_harian')) {
			    mkdir('uploads/produksi_harian', 0777, true);
			}

			$data = [];
			$count = count($_FILES['files']['name']);
			for ($i = 0; $i < $count; $i++) {

				if (!empty($_FILES['files']['name'][$i])) {

					$_FILES['file']['name'] = $_FILES['files']['name'][$i];
					$_FILES['file']['type'] = $_FILES['files']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['files']['error'][$i];
					$_FILES['file']['size'] = $_FILES['files']['size'][$i];

					$config['upload_path'] = 'uploads/produksi_harian';
					$config['allowed_types'] = 'jpg|jpeg|png|pdf';
					$config['file_name'] = $_FILES['files']['name'][$i];

					$this->load->library('upload', $config);

					if ($this->upload->do_upload('file')) {
						$uploadData = $this->upload->data();
						$filename = $uploadData['file_name'];

						$data['totalFiles'][] = $filename;


						$data[$i] = array(
							'produksi_harian_id' => $produksi_harian_id,
							'lampiran'  => $data['totalFiles'][$i]
						);

						$this->db->insert('pmm_lampiran_produksi_harian', $data[$i]);
					}
				}
			}

			for ($i = 1; $i <= $total_product; $i++) {
				$product_id = $this->input->post('product_' . $i);
				$start = $this->input->post('start_' . $i);
				$end = $this->input->post('end_' . $i);
				$duration = $this->input->post('duration_' . $i);
				$start = $this->input->post('start_' . $i);
				$hours = $this->input->post('hours_' . $i);
				$day = $this->input->post('day_' . $i);
				$use = $this->input->post('use_' . $i);
				$capacity = $this->input->post('capacity_' . $i);
				if (!empty($product_id)) {
					$arr_detail = array(
						'produksi_harian_id' => $produksi_harian_id,
						'product_id' => $product_id,
						'start' => $start,
						'end' => $end,
						'duration' => $duration,
						'hours' => $hours,
						'day' => $day,
						'use' => $use,
						'capacity' => $capacity,
					);

					$this->db->insert('pmm_produksi_harian_detail', $arr_detail);
				} else {
					redirect('produksi/kalibrasi');
					exit();
				}
			}
		}


		if ($this->db->trans_status() === FALSE) {
			# Something went wrong.
			$this->db->trans_rollback();
			$this->session->set_flashdata('notif_error','REJECTED');
			redirect('produksi/kalibrasi');
		} else {
			# Everything is Perfect. 
			# Committing data to the database.
			$this->db->trans_commit();
			$this->session->set_flashdata('notif_success','SAVED');
			redirect('admin/produksi');
		}
	}
	
	public function table_produksi_harian()
	{   
        $data = array();
		$filter_date = $this->input->post('filter_date');
		if(!empty($filter_date)){
			$arr_date = explode(' - ', $filter_date);
			$this->db->where('kb.date_prod >=',date('Y-m-d',strtotime($arr_date[0])));
			$this->db->where('kb.date_prod <=',date('Y-m-d',strtotime($arr_date[1])));
		}
        $this->db->select('kb.id, kb.date_prod, kb.no_prod, SUM(phd.duration) as duration, SUM(phd.use) as used, SUM(phd.use) / SUM(phd.duration) as capacity, lk.produksi_harian_id, lk.lampiran, kb.memo, kb.created_by, kb.created_on, kb.status');
		$this->db->join('pmm_produksi_harian_detail phd','kb.id = phd.produksi_harian_id','left');
		$this->db->join('pmm_lampiran_produksi_harian lk', 'kb.id = lk.produksi_harian_id','left');
		$this->db->where('kb.date_prod >=', date('2023-08-01'));
		$this->db->where('kb.status','PUBLISH');
		$this->db->group_by('kb.id');	
		$this->db->order_by('kb.date_prod','desc');			
		$query = $this->db->get('pmm_produksi_harian kb');
		
       if($query->num_rows() > 0){
			foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
                $row['date_prod'] = date('d-m-Y',strtotime($row['date_prod']));
				$row['no_prod'] = $row['no_prod'];
				$row['duration'] = $row['duration'];
				$row['used'] = $row['used'];
				$row['capacity'] = number_format($row['capacity'],2,',','.');
				$row['memo'] = $row['memo'];
				$row['lampiran'] = "<a target='_blank' href=" . base_url('uploads/produksi_harian/' . $row["lampiran"]) . ">" . $row["lampiran"] . "</a>";
				$row['admin_name'] = $this->crud_global->GetField('tbl_admin',array('admin_id'=>$row['created_by']),'admin_name');
                $row['created_on'] = date('d/m/Y H:i:s',strtotime($row['created_on']));
				$row['status'] = $this->pmm_model->GetStatus4($row['status']);
				$row['view'] = '<a href="'.site_url().'produksi/data_produksi_harian/'.$row['id'].'" class="btn btn-warning" style="border-radius:10px"><i class="glyphicon glyphicon-folder-open"></i> </a>';
				$row['print'] = '<a href="'.site_url().'produksi/cetak_produksi_harian/'.$row['id'].'" target="_blank" class="btn btn-info" style="border-radius:10px"><i class="fa fa-print"></i> </a>';
                if($this->session->userdata('admin_group_id') == 1 || $this->session->userdata('admin_group_id') == 5 || $this->session->userdata('admin_group_id') == 6 || $this->session->userdata('admin_group_id') == 11 || $this->session->userdata('admin_group_id') == 15){
					$row['actions'] = '<a href="javascript:void(0);" onclick="DeleteProduksiHarian('.$row['id'].')" class="btn btn-danger" style="font-weight:bold; border-radius:10px;"><i class="fa fa-close"></i> </a>';
				}else {
					$row['actions'] = '<button type="button" class="btn btn-danger" style="font-weight:bold; border-radius:10px;"><i class="fa fa-ban"></i> No Access</button>';
				}

                $data[] = $row;
            }

        }
        echo json_encode(array('data'=>$data));
    }
	
	public function data_produksi_harian($id)
	{
		$check = $this->m_admin->check_login();
		if ($check == true) {
			$data['tes'] = '';
			$data['prod'] = $this->db->get_where("pmm_produksi_harian", ["id" => $id])->row_array();
			$data['lampiran'] = $this->db->get_where("pmm_lampiran_produksi_harian", ["produksi_harian_id" => $id])->result_array();
			$data['details'] = $this->db->query("SELECT * FROM `pmm_produksi_harian_detail` WHERE produksi_harian_id = '$id'")->result_array();
			$this->load->view('produksi/data_produksi_harian', $data);
		} else {
			redirect('admin');
		}
	}
	
	public function hapus_produksi_harian($id)
    {
        $this->db->trans_start(); # Starting Transaction


        $this->db->delete('pmm_produksi_harian', array('id' => $id));
		$this->db->delete('pmm_produksi_harian_detail', array('produksi_harian_id' => $id));
		//$this->db->update('pmm_produksi_harian',array('status'=>'DELETED'),array('id'=>$id));

        if ($this->db->trans_status() === FALSE) {
            # Something went wrong.
            $this->db->trans_rollback();
            $this->session->set_flashdata('notif_error', 'Gagal Menghapus Produksi Harian');
            redirect('produksi/data_produksi_harian');
        } else {
            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            $this->session->set_flashdata('notif_success', 'Berhasil Menghapus Produksi Harian');
            redirect("admin/produksi");
        }
    }
	
	public function cetak_produksi_harian($id){

		$this->load->library('pdf');
	
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $pdf->SetFont('helvetica','',7); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$data['row'] = $this->db->get_where('pmm_produksi_harian',array('id'=>$id))->row_array();
		$data['data'] = $this->db->query("SELECT * FROM `pmm_produksi_harian_detail` INNER JOIN pmm_kalibrasi ON pmm_produksi_harian_detail.product_id = pmm_kalibrasi.id WHERE produksi_harian_id = '$id'")->result_array();
		$data['detail'] = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
		->from('pmm_produksi_harian pph ')
		->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
		->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id','left')
		->where("(pph.id = '$id')")
		->where('pph.status','PUBLISH')
		->get()->result_array();
        $html = $this->load->view('produksi/cetak_produksi_harian',$data,TRUE);
        $row = $this->db->get_where('pmm_produksi_harian',array('id'=>$id))->row_array();
        
        $pdf->SetTitle($row['no_prod']);
        $pdf->nsi_html($html);
        $pdf->Output($row['no_prod'].'.pdf', 'I');
	}
	
	public function cetak_laporan_produksi_harian($id){

		$this->load->library('pdf');

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $pdf->SetFont('helvetica','',7); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$data['row'] = $this->db->get_where('pmm_produksi_harian',array('id'=>$id))->row_array();
		$data['data'] = $this->db->query("SELECT * FROM `pmm_produksi_harian_detail` INNER JOIN pmm_kalibrasi ON pmm_produksi_harian_detail.product_id = no_kalibrasi WHERE produksi_harian_id = '$id'")->result_array();		
		
        $html = $this->load->view('produksi/cetak_produksi_harian',$data,TRUE);
        $row = $this->db->get_where('pmm_produksi_harian',array('id'=>$id))->row_array();
        
        $pdf->SetTitle($row['no_prod']);
        $pdf->nsi_html($html);
        $pdf->Output($row['no_prod'].'.pdf', 'I');
	}
	
	public function form_agregat()
	{
		$check = $this->m_admin->check_login();
		if ($check == true) {
			$data['products'] = $this->db->select('*')->get_where('produk', array('status' => 'PUBLISH', 'agregat' => 1))->result_array();
			$data['measures'] = $this->db->select('*')->get_where('pmm_measures', array('status' => 'PUBLISH'))->result_array();
			$this->load->view('produksi/form_agregat', $data);
		} else {
			redirect('admin');
		}
	}
	
	public function submit_agregat()
	{
		$date_agregat = $this->input->post('date_agregat');
		$jobs_type = $this->input->post('jobs_type');
		$no_komposisi = $this->input->post('no_komposisi');
		$measure_a = $this->input->post('measure_a');
		$measure_b = $this->input->post('measure_b');
		$measure_c = $this->input->post('measure_c');
		$measure_d = $this->input->post('measure_d');
		$produk_a = $this->input->post('produk_a');
		$produk_b = $this->input->post('produk_b');
		$produk_c = $this->input->post('produk_c');
		$produk_d = $this->input->post('produk_d');
		$presentase_a = $this->input->post('presentase_a');
		$presentase_b = $this->input->post('presentase_b');
		$presentase_c = $this->input->post('presentase_c');
		$presentase_d = $this->input->post('presentase_d');
		$memo = $this->input->post('memo');
		$attach = $this->input->post('files[]');

		$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

		$arr_insert = array(
			'date_agregat' => date('Y-m-d', strtotime($date_agregat)),	
			'jobs_type' => $jobs_type,
			'no_komposisi' => $no_komposisi,
			'measure_a' => $measure_a,
			'measure_b' => $measure_b,
			'measure_c' => $measure_c,
			'measure_d' => $measure_d,			
			'produk_a' => $produk_a,
			'produk_b' => $produk_b,
			'produk_c' => $produk_c,
			'produk_d' => $produk_d,
			'presentase_a' => $presentase_a,
			'presentase_b' => $presentase_b,
			'presentase_c' => $presentase_c,
			'presentase_d' => $presentase_d,
			'memo' => $memo,
			'attach' => $attach,
			'status' => 'PUBLISH',
			'created_by' => $this->session->userdata('admin_id'),
			'created_on' => date('Y-m-d H:i:s')
		);

		if ($this->db->insert('pmm_agregat', $arr_insert)) {
			$agregat_id = $this->db->insert_id();

			if (!file_exists('uploads/agregat')) {
			    mkdir('uploads/agregat', 0777, true);
			}

			$data = [];
			$count = count($_FILES['files']['name']);
			for ($i = 0; $i < $count; $i++) {

				if (!empty($_FILES['files']['name'][$i])) {

					$_FILES['file']['name'] = $_FILES['files']['name'][$i];
					$_FILES['file']['type'] = $_FILES['files']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['files']['error'][$i];
					$_FILES['file']['size'] = $_FILES['files']['size'][$i];

					$config['upload_path'] = 'uploads/agregat';
					$config['allowed_types'] = 'jpg|jpeg|png|pdf';
					$config['file_name'] = $_FILES['files']['name'][$i];

					$this->load->library('upload', $config);

					if ($this->upload->do_upload('file')) {
						$uploadData = $this->upload->data();
						$filename = $uploadData['file_name'];

						$data['totalFiles'][] = $filename;


						$data[$i] = array(
							'agregat_id' => $agregat_id,
							'lampiran'  => $data['totalFiles'][$i]
						);

						$this->db->insert('pmm_lampiran_agregat', $data[$i]);
						
					} 
				}
			}
		}


		if ($this->db->trans_status() === FALSE) {
			# Something went wrong.
			$this->db->trans_rollback();
			$this->session->set_flashdata('notif_error','REJECTED');
			redirect('produksi/komposisi_agregat');
		} else {
			# Everything is Perfect. 
			# Committing data to the database.
			$this->db->trans_commit();
			$this->session->set_flashdata('notif_success','SAVED');
			redirect('admin/produksi');
		}
	}
	
	public function table_agregat()
	{   
        $data = array();
		$filter_date = $this->input->post('filter_date');
		if(!empty($filter_date)){
			$arr_date = explode(' - ', $filter_date);
			$this->db->where('ag.date_agregat >=',date('Y-m-d',strtotime($arr_date[0])));
			$this->db->where('ag.date_agregat <=',date('Y-m-d',strtotime($arr_date[1])));
		}
        $this->db->select('ag.id, ag.jobs_type, ag.date_agregat, ag.no_komposisi, lk.agregat_id, lk.lampiran, ag.created_by, ag.created_on, ag.status');
		$this->db->join('pmm_lampiran_agregat lk', 'ag.id = lk.agregat_id','left');
		$this->db->where('ag.date_agregat >=', date('2023-08-01'));
		$this->db->order_by('ag.date_agregat','desc');		
		$query = $this->db->get('pmm_agregat ag');
		
       if($query->num_rows() > 0){
			foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
				$row['jobs_type'] = $row['jobs_type'];
                $row['date_agregat'] = date('d F Y',strtotime($row['date_agregat']));
				$row['no_komposisi'] = $row['no_komposisi'];
				$row['lampiran'] = '<a href="' . base_url('uploads/agregat/' . $row['lampiran']) .'" target="_blank">' . $row['lampiran'] . '</a>';           
                $row['admin_name'] = $this->crud_global->GetField('tbl_admin',array('admin_id'=>$row['created_by']),'admin_name');
                $row['created_on'] = date('d/m/Y H:i:s',strtotime($row['created_on']));
				$row['status'] = $this->pmm_model->GetStatus4($row['status']);
				$row['view'] = '<a href="'.site_url().'produksi/data_komposisi_agregat/'.$row['id'].'" class="btn btn-warning" style="border-radius:10px"><i class="glyphicon glyphicon-folder-open"></i> </a>';
				$row['print'] = '<a href="'.site_url().'produksi/cetak_komposisi_agregat/'.$row['id'].'" target="_blank" class="btn btn-info" style="border-radius:10px"><i class="fa fa-print"></i> </a>';
				if($this->session->userdata('admin_group_id') == 1 || $this->session->userdata('admin_group_id') == 5 || $this->session->userdata('admin_group_id') == 6 || $this->session->userdata('admin_group_id') == 11 || $this->session->userdata('admin_group_id') == 15){
					$row['actions'] = '<a href="javascript:void(0);" onclick="DeleteAgregat('.$row['id'].')" class="btn btn-danger" style="font-weight:bold; border-radius:10px;"><i class="fa fa-close"></i> </a>';
				}else {
					$row['actions'] = '<button type="button" class="btn btn-danger" style="font-weight:bold; border-radius:10px;"><i class="fa fa-ban"></i> No Access</button>';
				}
				
				$data[] = $row;
            }

        }
        echo json_encode(array('data'=>$data));
    }
	
	public function hapus_komposisi_agregat($id)
    {
        $this->db->trans_start(); # Starting Transaction


        $this->db->delete('pmm_agregat', array('id' => $id));

        if ($this->db->trans_status() === FALSE) {
            # Something went wrong.
            $this->db->trans_rollback();
            $this->session->set_flashdata('notif_error', 'Gagal Menghapus Komposisi Agregat');
            redirect('produksi/data_komposisi_agregat');
        } else {
            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            $this->session->set_flashdata('notif_success', 'Berhasil Menghapus Komposisi Agregat');
            redirect("admin/produksi");
        }
    }
	
	public function data_komposisi_agregat($id)
	{
		$check = $this->m_admin->check_login();
		if ($check == true) {
			$data['tes'] = '';
			$data['agregat'] = $this->db->get_where("pmm_agregat", ["id" => $id])->row_array();
			$data['lampiran'] = $this->db->get_where("pmm_lampiran_agregat", ["agregat_id" => $id])->result_array();
			$this->load->view('produksi/data_komposisi_agregat', $data);
		} else {
			redirect('admin');
		}
	}
	
	public function cetak_komposisi_agregat($id){

		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $pdf->SetFont('helvetica','',7); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$data['row'] = $this->db->get_where('pmm_agregat',array('id'=>$id))->row_array();
        $html = $this->load->view('produksi/cetak_komposisi_agregat',$data,TRUE);
        $row = $this->db->get_where('pmm_agregat',array('id'=>$id))->row_array();


        
        $pdf->SetTitle($row['jobs_type']);
        $pdf->nsi_html($html);
        $pdf->Output($row['jobs_type'].'.pdf', 'I');
	}
	
	public function form_produksi_campuran()
	{
		$check = $this->m_admin->check_login();
		if ($check == true) {
			$data['komposisi_agregat'] = $this->db->select('*')->get_where('pmm_agregat', array('status' => 'PUBLISH'))->result_array();
			$data['measures'] = $this->db->select('*')->get_where('pmm_measures', array('status' => 'PUBLISH'))->result_array();
			$this->load->view('produksi/form_produksi_campuran', $data);
		} else {
			redirect('admin');
		}
	}
	
	public function add_produksi_campuran()
	{
		$no = $this->input->post('no');
		$komposisi_agregat = $this->db->select('*')->get_where('pmm_agregat', array('status' => 'PUBLISH'))->result_array();
		$measures = $this->db->select('*')->get_where('pmm_measures', array('status' => 'PUBLISH'))->result_array();
	?>
		<tr>
			<td><?php echo $no; ?>.</td>
			<td>
				<select id="product-<?php echo $no; ?>" onchange="changeData(<?php echo $no; ?>)" class="form-control form-select2" name="product_<?php echo $no; ?>">
					<option value="">Pilih Komposisi Agregat</option>
															<?php
					foreach ($komposisi_agregat as $key => $ka) {
					?>
						<option value="<?php echo $ka['id']; ?>"><?php echo $ka['jobs_type']; ?></option>
					<?php
					}
					?>
				</select>
			</td>
			<td>
				 <input type="text" name="uraian_<?php echo $no; ?>" id="uraian-<?php echo $no; ?>" onchange="changeData(<?php echo $no; ?>)" class="form-control  input-sm text-center"  required=""/>
			</td>
			<td>
				<input type="number" step=".01" min="0" name="volume_<?php echo $no; ?>" id="volume-<?php echo $no; ?>" onchange="changeData(<?php echo $no; ?>)" class="form-control input-sm text-center numberformat" />
			</td>
			<td>
				<select id="measure-<?php echo $no; ?>" class="form-control form-select2" name="measure_<?php echo $no; ?>" onchange="changeData(<?php echo $no; ?>)" required="" >
					<option value="">Pilih Satuan</option>
					<?php
					if(!empty($measures)){
						foreach ($measures as $ms) {
							?>
							<option value="<?php echo $ms['measure_name'];?>"><?php echo $ms['measure_name'];?></option>
							<?php
						}
					}
					?>
				</select>
			</td>
			<td>
				<input type="number" step=".01" min="0" name="convert_<?php echo $no; ?>" id="convert-<?php echo $no; ?>" onchange="changeData(<?php echo $no; ?>)" class="form-control input-sm text-center numberformat" />
			</td>
			<td>
                <input type="number" step=".01" min="0" name="volume_convert_<?php echo $no; ?>" id="volume_convert-<?php echo $no; ?>" onchange="changeData(<?php echo $no; ?>)" class="form-control input-sm text-center numberformat" />
            </td>
            <td>
				<select id="measure_convert-<?php echo $no; ?>" class="form-control form-select2" name="measure_convert_<?php echo $no; ?>" onchange="changeData(<?php echo $no; ?>)" required="" >
					<option value="">Pilih Satuan</option>
					<?php
					if(!empty($measures)){
						foreach ($measures as $ms) {
							?>
							<option value="<?php echo $ms['measure_name'];?>"><?php echo $ms['measure_name'];?></option>
							<?php
						}
					}
					?>
				</select>
			</td>	
		</tr>

		<script type="text/javascript">
			$('.form-select2').select2();
			$('input.numberformat').number(true, 4, ',', '.');
			
			$('.timepicker').timepicker({
			timeFormat: 'HH:mm',
			interval: 30,
			//defaultTime: '08',
			use24hours: true,
			dynamic: false,
			dropdown: true,
			scrollbar: true,
			change: timepickerChange
		});
		$(document).ready(function() {
            setTimeout(function(){
                $('#product-2').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#product-3').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#product-4').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#product-5').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#product-6').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#product-7').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#product-8').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#product-9').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#product-10').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#measure-2').prop('selectedIndex', 3).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#measure-3').prop('selectedIndex', 3).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#measure-4').prop('selectedIndex', 3).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#measure-5').prop('selectedIndex', 3).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#measure-6').prop('selectedIndex', 3).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#measure-7').prop('selectedIndex', 3).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#measure-8').prop('selectedIndex', 3).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#measure-9').prop('selectedIndex', 3).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#measure-10').prop('selectedIndex', 3).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#measure_convert-2').prop('selectedIndex', 3).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#measure_convert-3').prop('selectedIndex', 3).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#measure_convert-4').prop('selectedIndex', 3).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#measure_convert-5').prop('selectedIndex', 3).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#measure_convert-6').prop('selectedIndex', 3).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#measure_convert-7').prop('selectedIndex', 3).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#measure_convert-8').prop('selectedIndex', 3).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#measure_convert-9').prop('selectedIndex', 3).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#measure_convert-10').prop('selectedIndex', 3).trigger('change');
            }, 1000);
        });
		
		</script>
	<?php
	}
	
	public function submit_produksi_campuran()
	{
		$date_prod = $this->input->post('date_prod');
		$no_prod = $this->input->post('no_prod');
		$total_product = $this->input->post('total_product');
		$memo = $this->input->post('memo');
		$attach = $this->input->post('files[]');

		$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

		$arr_insert = array(
			'date_prod' => date('Y-m-d', strtotime($date_prod)),	
			'no_prod' => $no_prod,			
			'memo' => $memo,
			'attach' => $attach,
			'status' => 'PUBLISH',
			'created_by' => $this->session->userdata('admin_id'),
			'created_on' => date('Y-m-d H:i:s')
		);

		if ($this->db->insert('pmm_produksi_campuran', $arr_insert)) {
			$produksi_campuran_id = $this->db->insert_id();

			if (!file_exists('uploads/produksi_campuran')) {
			    mkdir('uploads/produksi_campuran', 0777, true);
			}

			$data = [];
			$count = count($_FILES['files']['name']);
			for ($i = 0; $i < $count; $i++) {

				if (!empty($_FILES['files']['name'][$i])) {

					$_FILES['file']['name'] = $_FILES['files']['name'][$i];
					$_FILES['file']['type'] = $_FILES['files']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['files']['error'][$i];
					$_FILES['file']['size'] = $_FILES['files']['size'][$i];

					$config['upload_path'] = 'uploads/produksi_campuran';
					$config['allowed_types'] = 'jpg|jpeg|png|pdf';
					$config['file_name'] = $_FILES['files']['name'][$i];

					$this->load->library('upload', $config);

					if ($this->upload->do_upload('file')) {
						$uploadData = $this->upload->data();
						$filename = $uploadData['file_name'];

						$data['totalFiles'][] = $filename;


						$data[$i] = array(
							'produksi_campuran_id' => $produksi_campuran_id,
							'lampiran'  => $data['totalFiles'][$i]
						);

						$this->db->insert('pmm_lampiran_produksi_campuran', $data[$i]);
						
					} 
				}
			}

			for ($i = 1; $i <= $total_product; $i++) {
				$product_id = $this->input->post('product_' . $i);
				$volume = $this->input->post('volume_' . $i);
				$uraian = $this->input->post('uraian_' . $i);
				$measure = $this->input->post('measure_' . $i);
				$convert = $this->input->post('convert_' . $i);
				$volume_convert = $this->input->post('volume_convert_' . $i);
				$measure_convert = $this->input->post('measure_convert_' . $i);
				if (!empty($product_id)) {
					$arr_detail = array(
						'produksi_campuran_id' => $produksi_campuran_id,
						'product_id' => $product_id,
						'uraian' => $uraian,
						'volume' => $volume,
						'measure' => $measure,
						'convert' => $convert,
						'volume_convert' => $volume_convert,
						'measure_convert' => $measure_convert,
					);

					$this->db->insert('pmm_produksi_campuran_detail', $arr_detail);
				} else {
					redirect('produksi/produksi_campuran');
					exit();
				}
			}
		}


		if ($this->db->trans_status() === FALSE) {
			# Something went wrong.
			$this->db->trans_rollback();
			$this->session->set_flashdata('notif_error','REJECTED');
			redirect('produksi/produksi_campuran');
		} else {
			# Everything is Perfect. 
			# Committing data to the database.
			$this->db->trans_commit();
			$this->session->set_flashdata('notif_success','SAVED');
			redirect('admin/produksi');
		}
	}
	
	public function add_produksi_harian()
	{
		$no = $this->input->post('no');
		$kalibrasi = $this->db->select('*')->get_where('pmm_kalibrasi', array('status' => 'PUBLISH'))->result_array();
	?>
		<tr>
			<td><?php echo $no; ?>.</td>
			<td>
				<select id="product-<?php echo $no; ?>" onchange="changeData(<?php echo $no; ?>)" class="form-control form-select2" name="product_<?php echo $no; ?>">
					<option value="">Pilih Produk</option>
					<?php
						foreach ($kalibrasi as $key => $kal) {
					?>
					<option value="<?php echo $kal['id']; ?>"><?php echo $kal['no_kalibrasi']; ?></option>
					<?php
					}
					?>
				</select>
			</td>
			<td>
				<input type="timepicker" min="0" name="start_<?php echo $no; ?>" id="start-<?php echo $no; ?>" onchange="changeData(<?php echo $no; ?>)" class="form-control timepicker text-center" />
			</td>
			<td>
				<input type="timepicker" min="0" name="end_<?php echo $no; ?>" id="end-<?php echo $no; ?>" onchange="changeData(<?php echo $no; ?>)" class="form-control timepicker text-center" />
			</td>
			<td>
				<input type="number" step=".01" min="0" name="duration_<?php echo $no; ?>" id="duration-<?php echo $no; ?>" onchange="changeData(<?php echo $no; ?>)" class="form-control input-sm text-center numberformat" readonly="" />
			</td>
			<td>
				<input type="number" step=".01" min="0" name="hours_<?php echo $no; ?>" id="hours-<?php echo $no; ?>" onchange="changeData(<?php echo $no; ?>)" class="form-control input-sm text-center numberformat" />
			</td>
			<td>
				<input type="number" step=".01" min="0" name="day_<?php echo $no; ?>" id="day-<?php echo $no; ?>" onchange="changeData(<?php echo $no; ?>)" class="form-control input-sm text-center numberformat" />
			</td>
			<td>
                <input type="number" step=".01" min="0" name="use_<?php echo $no; ?>" id="use-<?php echo $no; ?>" onchange="changeData(<?php echo $no; ?>)" class="form-control input-sm text-center numberformat" readonly="" />
            </td>
            <td>
				<input type="number" step=".01" min="0" name="capacity_<?php echo $no; ?>" id="capacity-<?php echo $no; ?>" onchange="changeData(<?php echo $no; ?>)" class="form-control input-sm text-center numberformat" readonly="" />
			</td>	
		</tr>

		<script type="text/javascript">
			$('.form-select2').select2();
			$('input.numberformat').number(true, 4, ',', '.');
			
			$('.timepicker').timepicker({
			timeFormat: 'HH:mm',
			interval: 30,
			//defaultTime: '08',
			use24hours: true,
			dynamic: false,
			dropdown: true,
			scrollbar: true,
			change: timepickerChange
		});
		$(document).ready(function() {
            setTimeout(function(){
                $('#product-2').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#product-3').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#product-4').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#product-5').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#product-6').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#product-7').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#product-8').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#product-9').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
		$(document).ready(function() {
            setTimeout(function(){
                $('#product-10').prop('selectedIndex', 1).trigger('change');
            }, 1000);
        });
		</script>
	<?php
	}
	
	public function table_produksi_campuran()
	{   
        $data = array();
		$filter_date = $this->input->post('filter_date');
		if(!empty($filter_date)){
			$arr_date = explode(' - ', $filter_date);
			$this->db->where('ppc.date_prod >=',date('Y-m-d',strtotime($arr_date[0])));
			$this->db->where('ppc.date_prod <=',date('Y-m-d',strtotime($arr_date[1])));
		}
		$no_prod = $this->input->post('no_prod');
		if(!empty($no_prod)){
			$this->db->where('ppc.no_prod',$no_prod);
		}
        $this->db->select('ppc.id, ppc.date_prod, ppc.no_prod, ppcd.uraian, ppcd.measure_convert, SUM(ppcd.volume_convert) as volume_convert, lk.produksi_campuran_id, lk.lampiran, ppc.memo, ppc.created_by, ppc.created_on, ppc.status');
		$this->db->join('pmm_produksi_campuran_detail ppcd','ppc.id = ppcd.produksi_campuran_id','left');
		$this->db->join('pmm_lampiran_produksi_campuran lk', 'ppc.id = lk.produksi_campuran_id','left');
		$this->db->where('ppc.date_prod >=', date('2023-08-01'));
		$this->db->where('ppc.status','PUBLISH');
		$this->db->group_by('ppc.id');	
		$this->db->order_by('ppc.date_prod','desc');			
		$query = $this->db->get('pmm_produksi_campuran ppc');
		
       if($query->num_rows() > 0){
			foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
                $row['date_prod'] = date('d-m-Y',strtotime($row['date_prod']));
				$row['no_prod'] = $row['no_prod'];
				$row['uraian'] = $row['uraian'];
				$row['measure_convert'] = $row['measure_convert'];
				$row['volume_convert'] = number_format($row['volume_convert'],2,',','.');
				$row['memo'] = $row['memo'];
				$row['lampiran'] = "<a target='_blank' href=" . base_url('uploads/produksi_harian/' . $row["lampiran"]) . ">" . $row["lampiran"] . "</a>";
				$row['admin_name'] = $this->crud_global->GetField('tbl_admin',array('admin_id'=>$row['created_by']),'admin_name');
                $row['created_on'] = date('d/m/Y H:i:s',strtotime($row['created_on']));
				$row['status'] = $this->pmm_model->GetStatus4($row['status']);
				$row['view'] = '<a href="'.site_url().'produksi/data_produksi_campuran/'.$row['id'].'" class="btn btn-warning" style="border-radius:10px"><i class="glyphicon glyphicon-folder-open"></i> </a>';
				$row['print'] = '<a href="'.site_url().'produksi/cetak_produksi_campuran/'.$row['id'].'" target="_blank" class="btn btn-info" style="border-radius:10px"><i class="fa fa-print"></i> </a>';
                if($this->session->userdata('admin_group_id') == 1 || $this->session->userdata('admin_group_id') == 5 || $this->session->userdata('admin_group_id') == 6 || $this->session->userdata('admin_group_id') == 11 || $this->session->userdata('admin_group_id') == 15){
					$row['actions'] = '<a href="javascript:void(0);" onclick="DeleteProduksiCampuran('.$row['id'].')" class="btn btn-danger" style="font-weight:bold; border-radius:10px;"><i class="fa fa-close"></i> </a>';
				}else {
					$row['actions'] = '<button type="button" class="btn btn-danger" style="font-weight:bold; border-radius:10px;"><i class="fa fa-ban"></i> No Access</button>';
				}

                $data[] = $row;
            }

        }
        echo json_encode(array('data'=>$data));
    }
	
	public function data_produksi_campuran($id)
	{
		$check = $this->m_admin->check_login();
		if ($check == true) {
			$data['tes'] = '';
			$data['prod'] = $this->db->get_where("pmm_produksi_campuran", ["id" => $id])->row_array();
			$data['lampiran'] = $this->db->get_where("pmm_lampiran_produksi_campuran", ["produksi_campuran_id" => $id])->result_array();
			$data['details'] = $this->db->query("SELECT * FROM `pmm_produksi_campuran_detail` WHERE produksi_campuran_id = '$id'")->result_array();
			$this->load->view('produksi/data_produksi_campuran', $data);
		} else {
			redirect('admin');
		}
	}
	
	public function hapus_produksi_campuran($id)
    {
        $this->db->trans_start(); # Starting Transaction


        $this->db->delete('pmm_produksi_campuran', array('id' => $id));
		$this->db->delete('pmm_produksi_campuran_detail', array('produksi_campuran_id' => $id));
		//$this->db->update('pmm_produksi_campuran',array('status'=>'DELETED'),array('id'=>$id));

        if ($this->db->trans_status() === FALSE) {
            # Something went wrong.
            $this->db->trans_rollback();
            $this->session->set_flashdata('notif_error', 'Gagal Menghapus Produksi Campuran');
            redirect('produksi/data_produksi_campuran');
        } else {
            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            $this->session->set_flashdata('notif_success', 'Berhasil Menghapus Produksi Campuran');
            redirect("admin/produksi");
        }
    }
	
	public function cetak_produksi_campuran($id){

		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $pdf->SetFont('helvetica','',7); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$data['row'] = $this->db->get_where('pmm_produksi_campuran',array('id'=>$id))->row_array();
		$data['details'] = $this->db->query("SELECT * FROM `pmm_produksi_campuran_detail` WHERE produksi_campuran_id = '$id'")->result_array();
		
        $html = $this->load->view('produksi/cetak_produksi_campuran',$data,TRUE);
        $row = $this->db->get_where('pmm_produksi_campuran',array('id'=>$id))->row_array();


        
        $pdf->SetTitle($row['no_prod']);
        $pdf->nsi_html($html);
        $pdf->Output($row['no_prod'].'.pdf', 'I');
	}

	public function delete_kalibrasi()
	{
		$output['output'] = false;
		$id = $this->input->post('id');

		$file = $this->db->select('lk.lampiran')
		->from('pmm_lampiran_kalibrasi lk')
		->where("lk.kalibrasi_id = $id")
		->get()->row_array();

		$path = './uploads/kalibrasi/'.$file['lampiran'];
		chmod($path, 0777);
		unlink($path);

		$this->db->delete('pmm_lampiran_kalibrasi', array('kalibrasi_id' => $id));

		if(!empty($id)){
			$this->db->delete('pmm_kalibrasi',array('id'=>$id));
			{
				$output['output'] = true;
			}
		}
		echo json_encode($output);
	}

	public function delete_agregat()
	{
		$output['output'] = false;
		$id = $this->input->post('id');

		$file = $this->db->select('lk.lampiran')
		->from('pmm_lampiran_agregat lk')
		->where("lk.agregat_id = $id")
		->get()->row_array();

		$path = './uploads/agregat/'.$file['lampiran'];
		chmod($path, 0777);
		unlink($path);

		$this->db->delete('pmm_lampiran_agregat', array('agregat_id' => $id));

		if(!empty($id)){
			$this->db->delete('pmm_agregat',array('id'=>$id));
			{
				$output['output'] = true;
			}
		}
		echo json_encode($output);
	}

	public function delete_produksi_harian()
	{
		$output['output'] = false;
		$id = $this->input->post('id');

		$file = $this->db->select('lk.lampiran')
		->from('pmm_lampiran_produksi_harian lk')
		->where("lk.produksi_harian_id = $id")
		->get()->row_array();

		$path = './uploads/produksi_harian/'.$file['lampiran'];
		chmod($path, 0777);
		unlink($path);

		$this->db->delete('pmm_lampiran_produksi_harian', array('produksi_harian_id' => $id));
		
		if(!empty($id)){
			$this->db->delete('pmm_produksi_harian_detail',array('produksi_harian_id'=>$id));
			$this->db->delete('pmm_produksi_harian',array('id'=>$id));
			{
				$output['output'] = true;
			}
		}
		echo json_encode($output);
	}

	public function delete_produksi_campuran()
	{
		$output['output'] = false;
		$id = $this->input->post('id');

		$file = $this->db->select('lk.lampiran')
		->from('pmm_lampiran_produksi_campuran lk')
		->where("lk.produksi_campuran_id = $id")
		->get()->row_array();

		$path = './uploads/produksi_campuran/'.$file['lampiran'];
		chmod($path, 0777);
		unlink($path);

		$this->db->delete('pmm_lampiran_produksi_campuran', array('produksi_campuran_id' => $id));

		if(!empty($id)){
			$this->db->delete('pmm_produksi_campuran_detail',array('produksi_campuran_id'=>$id));
			$this->db->delete('pmm_produksi_campuran',array('id'=>$id));
			{
				$output['output'] = true;
			}
		}
		echo json_encode($output);
	}

	public function form_kunci_bahan_baku()
	{
		$check = $this->m_admin->check_login();
		if ($check == true) {
			$data['products'] = $this->db->select('*')->get_where('produk', array('status' => 'PUBLISH', 'bahanbaku' => 1))->result_array();
			$this->load->view('produksi/form_kunci_bahan_baku', $data);
		} else {
			redirect('admin');
		}
	}

	public function submit_kunci_bahan_baku()
	{
		$date = $this->input->post('date');
		$vol_pemakaian_bbm = str_replace(',', '.', $this->input->post('vol_pemakaian_bbm'));
		$vol_pemakaian_bbm_2 = str_replace(',', '.', $this->input->post('vol_pemakaian_bbm_2'));
		$vol_nilai_boulder = str_replace(',', '.', $this->input->post('vol_nilai_boulder'));
		$vol_nilai_bbm = str_replace(',', '.', $this->input->post('vol_nilai_bbm'));

		$nilai_pemakaian_bbm = str_replace('.', '', $this->input->post('nilai_pemakaian_bbm'));
		$nilai_pemakaian_bbm_2 = str_replace('.', '', $this->input->post('nilai_pemakaian_bbm_2'));
		$nilai_boulder = str_replace('.', '', $this->input->post('nilai_boulder'));
		$nilai_bbm = str_replace('.', '', $this->input->post('nilai_bbm'));;

		$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

		$arr_insert = array(
			'date' => date('Y-m-d', strtotime($date)),
			'vol_pemakaian_bbm' => $vol_pemakaian_bbm,
			'vol_pemakaian_bbm_2' => $vol_pemakaian_bbm_2,
			'vol_nilai_boulder' => $vol_nilai_boulder,
			'vol_nilai_bbm' => $vol_nilai_bbm,
			'nilai_pemakaian_bbm' => $nilai_pemakaian_bbm,
			'nilai_pemakaian_bbm_2' => $nilai_pemakaian_bbm_2,
			'nilai_boulder' => $nilai_boulder,
			'nilai_bbm' => $nilai_bbm,
			'status' => 'PUBLISH',
			'created_by' => $this->session->userdata('admin_id'),
			'created_on' => date('Y-m-d H:i:s')
		);

		$this->db->insert('kunci_bahan_baku', $arr_insert);

		if ($this->db->trans_status() === FALSE) {
			# Something went wrong.
			$this->db->trans_rollback();
			$this->session->set_flashdata('notif_error','<b>ERROR</b>');
			redirect('/produksi/kunci_bahan_baku');
		} else {
			# Everything is Perfect. 
			# Committing data to the database.
			$this->db->trans_commit();
			$this->session->set_flashdata('notif_success','<b>SAVED</b>');
			redirect('admin/produksi');
		}
	}

	public function table_kunci_bahan_baku()
	{   
        $data = array();
		$filter_date = $this->input->post('filter_date');
		if(!empty($filter_date)){
			$arr_date = explode(' - ', $filter_date);
			$this->db->where('date >=',date('Y-m-d',strtotime($arr_date[0])));
			$this->db->where('date <=',date('Y-m-d',strtotime($arr_date[1])));
		}
        $this->db->select('*');
		$this->db->where('status','PUBLISH');
		$this->db->group_by('id');	
		$this->db->order_by('date','desc');			
		$query = $this->db->get('kunci_bahan_baku');
		
       if($query->num_rows() > 0){
			foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
                $row['date'] = date('d-m-Y',strtotime($row['date']));
				$row['vol_pemakaian_bbm'] = number_format($row['vol_pemakaian_bbm'],2,',','.');
				$row['nilai_pemakaian_bbm'] = number_format($row['nilai_pemakaian_bbm'],0,',','.');
				$row['vol_pemakaian_bbm_2'] = number_format($row['vol_pemakaian_bbm_2'],2,',','.');
				$row['nilai_pemakaian_bbm_2'] = number_format($row['nilai_pemakaian_bbm_2'],0,',','.');
				$row['vol_nilai_boulder'] = number_format($row['vol_nilai_boulder'],2,',','.');
				$row['nilai_boulder'] = number_format($row['nilai_boulder'],0,',','.');
				$row['vol_nilai_bbm'] = number_format($row['vol_nilai_bbm'],2,',','.');
				$row['nilai_bbm'] = number_format($row['nilai_bbm'],0,',','.');
                if($this->session->userdata('admin_group_id') == 1){
					$row['actions'] = '<a href="javascript:void(0);" onclick="DeleteKunciBahanBaku('.$row['id'].')" class="btn btn-danger" style="font-weight:bold; border-radius:10px;"><i class="fa fa-close"></i> </a>';
				}else {
					$row['actions'] = '<button type="button" class="btn btn-danger" style="font-weight:bold; border-radius:10px;"><i class="fa fa-ban"></i> No Access</button>';
				}

                $data[] = $row;
            }

        }
        echo json_encode(array('data'=>$data));
    }

	public function delete_kunci_bahan_baku()
	{
		$output['output'] = false;
		$id = $this->input->post('id');

		if(!empty($id)){
			$this->db->delete('kunci_bahan_baku',array('id'=>$id));
			{
				$output['output'] = true;
			}
		}
		echo json_encode($output);
	}

	public function form_kunci_bahan_jadi()
	{
		$check = $this->m_admin->check_login();
		if ($check == true) {
			$data['products'] = $this->db->select('*')->get_where('produk', array('status' => 'PUBLISH', 'bahanbaku' => 1))->result_array();
			$this->load->view('produksi/form_kunci_bahan_jadi', $data);
		} else {
			redirect('admin');
		}
	}

	public function submit_kunci_bahan_jadi()
	{
		$date = $this->input->post('date');
		$volume = str_replace(',', '.', $this->input->post('volume'));
		$nilai = str_replace('.', '', $this->input->post('nilai'));
		$produksi = $this->input->post('produksi');
		$bpp = str_replace('.', '', $this->input->post('bpp'));

		$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

		$arr_insert = array(
			'date' => date('Y-m-d', strtotime($date)),
			'volume' => $volume,
			'nilai' => $nilai,
			'produksi' => $produksi,
			'bpp' => $bpp,
			'unit_head' => 41,
			'logistik' => 27,
			'admin' => 27,
			'keu_1' => 37,
			'keu_2' => 36,
			'status' => 'PUBLISH',
			'created_by' => $this->session->userdata('admin_id'),
			'created_on' => date('Y-m-d H:i:s')
		);

		$this->db->insert('kunci_bahan_jadi', $arr_insert);

		if ($this->db->trans_status() === FALSE) {
			# Something went wrong.
			$this->db->trans_rollback();
			$this->session->set_flashdata('notif_error','<b>ERROR</b>');
			redirect('/produksi/kunci_bahan_jadi');
		} else {
			# Everything is Perfect. 
			# Committing data to the database.
			$this->db->trans_commit();
			$this->session->set_flashdata('notif_success','<b>SAVED</b>');
			redirect('admin/produksi');
		}
	}

	public function table_kunci_bahan_jadi()
	{   
        $data = array();
		$filter_date = $this->input->post('filter_date');
		if(!empty($filter_date)){
			$arr_date = explode(' - ', $filter_date);
			$this->db->where('date >=',date('Y-m-d',strtotime($arr_date[0])));
			$this->db->where('date <=',date('Y-m-d',strtotime($arr_date[1])));
		}
        $this->db->select('*');
		$this->db->where('status','PUBLISH');
		$this->db->group_by('id');	
		$this->db->order_by('date','desc');			
		$query = $this->db->get('kunci_bahan_jadi');
		
       if($query->num_rows() > 0){
			foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
                $row['date'] = date('d-m-Y',strtotime($row['date']));
				$row['volume'] = number_format($row['volume'],2,',','.');
				$row['nilai'] = number_format($row['nilai'],0,',','.');
				$row['bpp'] = number_format($row['bpp'],0,',','.');
                if($this->session->userdata('admin_group_id') == 1){
					$row['actions'] = '<a href="javascript:void(0);" onclick="DeleteKunciBahanJadi('.$row['id'].')" class="btn btn-danger" style="font-weight:bold; border-radius:10px;"><i class="fa fa-close"></i> </a>';
				}else {
					$row['actions'] = '<button type="button" class="btn btn-danger" style="font-weight:bold; border-radius:10px;"><i class="fa fa-ban"></i> No Access</button>';
				}

                $data[] = $row;
            }

        }
        echo json_encode(array('data'=>$data));
    }

	public function delete_kunci_bahan_jadi()
	{
		$output['output'] = false;
		$id = $this->input->post('id');

		if(!empty($id)){
			$this->db->delete('kunci_bahan_jadi',array('id'=>$id));
			{
				$output['output'] = true;
			}
		}
		echo json_encode($output);
	}

	public function table_rakor()
	{   
        $data = array();
		$filter_date = $this->input->post('filter_date');
		if(!empty($filter_date)){
			$arr_date = explode(' - ', $filter_date);
			$this->db->where('date >=',date('Y-m-d',strtotime($arr_date[0])));
			$this->db->where('date <=',date('Y-m-d',strtotime($arr_date[1])));
		}
        $this->db->select('*');
		$this->db->order_by('date','desc');
		$query = $this->db->get('kunci_rakor');
		
       if($query->num_rows() > 0){
			foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
                $row['date'] = date('d F Y',strtotime($row['date']));
				$row['admin_name'] = $this->crud_global->GetField('tbl_admin',array('admin_id'=>$row['created_by']),'admin_name');
                $row['created_on'] = date('d/m/Y H:i:s',strtotime($row['created_on']));

				if($this->session->userdata('admin_group_id') == 1){
				$row['actions'] = '<a href="javascript:void(0);" onclick="DeleteDataRakor('.$row['id'].')" class="btn btn-danger" style="font-weight:bold; border-radius:10px;"><i class="fa fa-close"></i> </a>';
				}else {
					$row['actions'] = '-';
				}
                $data[] = $row;
            }

        }
        echo json_encode(array('data'=>$data));
    }

	public function delete_rakor()
	{
		$output['output'] = false;
		$id = $this->input->post('id');
		if(!empty($id)){
			$this->db->delete('kunci_rakor',array('id'=>$id));
			{
				$output['output'] = true;
			}
		}
		echo json_encode($output);
	}

	public function form_rakor()
	{
		$check = $this->m_admin->check_login();
		if ($check == true) {
			$data['products'] = $this->db->select('*')->get_where('produk', array('status' => 'PUBLISH', 'kategori_produk' => 1))->result_array();
			$this->load->view('produksi/form_rakor', $data);
		} else {
			redirect('admin');
		}
	}

	public function submit_rakor()
	{
		$date = $this->input->post('date');

		$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

		$arr_insert = array(
			'date' => date('Y-m-d', strtotime($date)),
			'created_by' => $this->session->userdata('admin_id'),
			'created_on' => date('Y-m-d H:i:s'),
		);

		$this->db->insert('kunci_rakor', $arr_insert);

		if ($this->db->trans_status() === FALSE) {
			# Something went wrong.
			$this->db->trans_rollback();
			$this->session->set_flashdata('notif_error','<b>ERROR</b>');
			redirect('/produksi#rakor');
		} else {
			# Everything is Perfect. 
			# Committing data to the database.
			$this->db->trans_commit();
			$this->session->set_flashdata('notif_success','<b>SAVED</b>');
			redirect('admin/produksi');
		}
	}

}
?>