<?php

class Pmm_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('crud_global');
    }


    function GetMeasures($id=false)
    {

        $output = false;
        $query = $this->db->get_where('pmm_measures',array('status !='=>'DELETED'));
        if($query->num_rows() > 0){
            $output = $query->result_array();
        }
        return $output;
    }

    function getProducts()
    {
        $output = false;
        $this->db->order_by('product','asc');
        $query = $this->db->get_where('pmm_product',array('status'=>'PUBLISH'));
        if($query->num_rows() > 0){
            $output = $query->result_array();
        }
        return $output;
    }


    function GetNoSPO()
    {

        $code_prefix = $this->db->get_where('pmm_setting_production')->row_array();
        $output = false;

        $query = $this->db->select('id')->order_by('id','desc')->get('pmm_schedule');
        if($query->num_rows() > 0){
            $id = $query->row_array()['id'] + 1;
        }else {
            $id = 1;
        }
        $output = sprintf('%04d', $id).'/SPO/'.$code_prefix['code_prefix'].'/'.date('m').'/'.date('Y');
        return $output;
            
    }

    function GetNoProduksiJadi()
    {

        $code_prefix = $this->db->get_where('pmm_setting_production')->row_array();
        $output = false;

        $query = $this->db->select('id')->order_by('id','desc')->get('produksi_jadi');
        if($query->num_rows() > 0){
            $id = $query->row_array()['id'] + 1;
        }else {
            $id = 1;
        }
        $output = sprintf('%04d', $id).'/PBJ/'.$code_prefix['code_prefix'].'/'.date('m').'/'.date('Y');
        return $output;
            
    }
	
	function GetNoKalibrasi()
    {

        $code_prefix = $this->db->get_where('pmm_setting_production')->row_array();
        $output = false;

        $query = $this->db->select('id')->order_by('id','desc')->get('pmm_kalibrasi');
        if($query->num_rows() > 0){
            $id = $query->row_array()['id'] + 1;
        }else {
            $id = 1;
        }
        $output = sprintf('%03d', $id).'/Kal-Prod/BBJ/'.date('m').'/'.date('Y');
        return $output;
            
    }
	
	function GetNoAgregat()
    {

        $code_prefix = $this->db->get_where('pmm_setting_production')->row_array();
        $output = false;

        $query = $this->db->select('id')->order_by('id','desc')->get('pmm_agregat');
        if($query->num_rows() > 0){
            $id = $query->row_array()['id'] + 1;
        }else {
            $id = 1;
        }
        $output = sprintf('%03d', $id).'/Agregat-Prod/BBJ/'.date('m').'/'.date('Y');
        return $output;
            
    }
	
	function GetNoProd()
    {

        $code_prefix = $this->db->get_where('pmm_setting_production')->row_array();
        $output = false;

        $query = $this->db->select('id')->order_by('id','desc')->get('pmm_produksi_harian');
        if($query->num_rows() > 0){
            $id = $query->row_array()['id'] + 1;
        }else {
            $id = 1;
        }
        $output = sprintf('%04d', $id).'/PD/'.$code_prefix['code_prefix'].'/'.date('m').'/'.date('Y');
        return $output;
            
    }
	
	function GetNoProdCampuran()
    {

        $code_prefix = $this->db->get_where('pmm_setting_production')->row_array();
        $output = false;

        $query = $this->db->select('id')->order_by('id','desc')->get('pmm_produksi_campuran');
        if($query->num_rows() > 0){
            $id = $query->row_array()['id'] + 1;
        }else {
            $id = 1;
        }
        $output = sprintf('%04d', $id).'/PD/'.$code_prefix['code_prefix'].'/'.date('m').'/'.date('Y');
        return $output;
            
    }
	
	function GetNoKomposisi()
    {

        $code_prefix = $this->db->get_where('pmm_setting_production')->row_array();
        $output = false;

        $query = $this->db->select('id')->order_by('id','desc')->get('pmm_jmd');
        if($query->num_rows() > 0){
            $id = $query->row_array()['id'] + 1;
        }else {
            $id = 1;
        }
        $output = sprintf('%03d', $id).'/Lab-JMD/'.date('m').'/'.date('Y');
        return $output;
            
    }
	
	function GetNoRap()
    {

        $code_prefix = $this->db->get_where('pmm_setting_production')->row_array();
        $output = false;

        $query = $this->db->select('id')->order_by('id','desc')->get('pmm_rap');
        if($query->num_rows() > 0){
            $id = $query->row_array()['id'] + 1;
        }else {
            $id = 1;
        }
        $output = sprintf('%03d', $id).'/RAP/'.date('m').'/'.date('Y');
        return $output;
            
    }

    function GetNoPenawaranPembelian()
    {
        $code_prefix = $this->db->get_where('pmm_setting_production')->row_array();
        $output = false;

        $query = $this->db->select('id')->order_by('id','desc')->get('pmm_penawaran_pembelian');
        if($query->num_rows() > 0){
            $id = $query->row_array()['id'] + 1;
        }else {
            $id = 1;
        }
        $output = sprintf('%04d', $id).'/SPO/'.$code_prefix['code_prefix'].'/'.date('m').'/'.date('Y');
        return $output;
            
    }

    function GetNoPerubahanSistem()
    {
        $code_prefix = $this->db->get_where('pmm_setting_production')->row_array();
        $output = false;

        $query = $this->db->select('id')->order_by('id','desc')->get('perubahan_sistem');
        if($query->num_rows() > 0){
            $id = $query->row_array()['id'] + 1;
        }else {
            $id = 1;
        }
        $output = sprintf('%04d', $id).'/PPS/'.'BBJ-SC'.'/'.date('m').'/'.date('Y');
        return $output;
            
    }

    function GetNoRM($date)
    {
        $code_prefix = $this->db->get_where('pmm_setting_production')->row_array();
        $output = false;


        $query = $this->db->select('request_no')->order_by('request_no','desc')->get_where('pmm_request_materials',array('status !='=>'DELETED'));
        if($query->num_rows() > 0){
            $row = $query->row_array();
            $a = explode('/', $row['request_no']);
            $id = $a[0] + 1;
        }else {
            $id = 1;
        }
        $date = explode('-', $date);
        $output = sprintf('%04d', $id).'/RM/'.$code_prefix['code_prefix'].'/'.$date[1].'/'.$date[0];
        return $output;
            
    }

    function GetNoRF()
    {
        $code_prefix = $this->db->get_where('pmm_setting_production')->row_array();
        $output = false;

        $query = $this->db->select('id')->order_by('id','desc')->get('pmm_request_funds');
        if($query->num_rows() > 0){
            $id = $query->row_array()['id'] + 1;
        }else {
            $id = 1;
        }
        $output = sprintf('%04d', $id).'/RF/'.$code_prefix['code_prefix'].'/'.date('m').'/'.date('Y');
        return $output;
            
    }

    function ProductionsNo($date=false)
    {
        $code_prefix = $this->db->get_where('pmm_setting_production')->row_array();
        $output = false;

        $query = $this->db->select('id')->order_by('id','desc')->get('pmm_productions');
        if($query->num_rows() > 0){
            $id = $query->row_array()['id'] + 1;
        }else {
            $id = 1;
        }

        $month = date('m');
        $year = date('Y');
        if(!empty($date)){
            $date = explode('-', $date);
            $month = $date[1];
            $year = $date[0];
        }
        

        $output = sprintf('%04d', $id).'/SJ/'.$code_prefix['code_prefix'].'/'.$month.'/'.$year;
        return $output;
            
    }
    


    function GetNoPO($no)
    {
        $output = false;
        $code_prefix = $this->db->get_where('pmm_setting_production')->row_array();

        $arr = explode('/', $no);
        $output = $arr[0].'/PO/'.$code_prefix['code_prefix'].'/'.$arr[3].'/'.$arr[4];
        return $output;
            
    }

    function GetNoPONew()
    {
        $output = false;
        $code_prefix = $this->db->get_where('pmm_setting_production')->row_array();

        $query = $this->db->select('no_po')->order_by('no_po','desc')->get('pmm_purchase_order');
        if($query->num_rows() > 0){
            $no = $query->row_array()['no_po'] + 1;
        }else {
            $no = 1;
        }

        $arr = explode('/', $no);
        $output = '0'.$arr[0].'/PO/'.$code_prefix['code_prefix'].'/'.date('m').'/'.date('Y');
        return $output;
            
    }

    function GetNoRMNew()
    {
        $code_prefix = $this->db->get_where('pmm_setting_production')->row_array();
        $output = false;


        $query = $this->db->select('request_no')->order_by('request_no','desc')->get_where('pmm_request_materials');
        if($query->num_rows() > 0){
            $no = $query->row_array()['request_no'] + 1;
        }else {
            $no = 1;
        }
        $arr = explode('/', $no);
        $output = '0'.$arr[0].'/RM/'.$code_prefix['code_prefix'].'/'.date('m').'/'.date('Y');
        return $output;
            
    }

    function ConvertDateSchedule($date)
    {
        $output = false;

        $arr_date = explode(' - ', $date);
        if(is_array($arr_date)){
            $output = date('d-m-Y',strtotime($arr_date[0])).' - '.date('d-m-Y',strtotime($arr_date[1]));
        }
        return $output;
    }

    function GetProduct($select)
    {
        $output = false;
        $query = $this->db->select($select)->order_by('product','asc')->get_where('pmm_product',array('status'=>'PUBLISH'));
        if($query->num_rows() > 0){
            $output = $query->result_array();
        }
        return $output; 
    }

    function GetProduct2()
    {
        $output = false;

        $this->db->select('p.id, p.nama_produk, kp.nama_kategori_produk');
        $this->db->join('kategori_produk kp','p.kategori_produk = kp.id','left');
        $query = $this->db->order_by('p.nama_produk','asc')->get_where('produk p',array('p.status'=>'PUBLISH'));
        if($query->num_rows() > 0){
            $output = $query->result_array();
        }
        return $output; 
    }
    
    function GetScheduleProductDetail($id)
    {
        $output = false;

        $data = array();
        $this->db->select('week');
        $this->db->group_by('week');
        $this->db->order_by('week','asc');
        $this->db->where('schedule_product_id',$id);
        $query = $this->db->get('pmm_schedule_product_date');
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $key => $w) {

                $query_date = $this->db->select('date,koef,id')->get_where('pmm_schedule_product_date',array('schedule_product_id'=>$id,'week'=>$w['week']))->result_array();
                $data_detail = array();
                $total = 0;
                foreach ($query_date as $key_d => $d) {
                    $d['date_txt'] = date('d M Y',strtotime($d['date']));
                    $data_detail[] = $d;
                    $total += $d['koef'];
                }
                $data[] = array(
                    'week' => $w['week'],
                    'data' => $data_detail,
                    'total' => $total
                );
            }
        }
        $output = $data;
        return $output;
    }

    function GetTotalKoefByWeek($id,$week,$material_id)
    {
        $total = 0;
        $this->db->select('psp.id,psm.koef,psp.product_id');
        $this->db->join('pmm_schedule_material psm','psp.id = psm.schedule_product_id','left');
        $this->db->where('psp.schedule_id',$id);
        $this->db->where('psm.material_id',$material_id);
        $this->db->group_by('psp.product_id');
        $data = $this->db->get('pmm_schedule_product psp')->result_array();
        foreach ($data as $key => $value) {
            $query = $this->db->select('SUM(koef) as total')->get_where('pmm_schedule_product_date',array('schedule_product_id'=>$value['id'],'week'=>$week,'product_id'=>$value['product_id']))->row_array();
            $total += $query['total'] * $value['koef']; 
        }

        return $total;  
    }

    function GetTotalKoefByWeek_2($id,$product_id,$week)
    {
        $total = 0;
        $data = $this->db->select('id')->get_where('pmm_schedule_product',array('schedule_id'=>$id))->result_array();
        foreach ($data as $key => $value) {
            $query= $this->db->select('SUM(koef) as total')->get_where('pmm_schedule_product_date',array('schedule_product_id'=>$value['id'],'product_id'=>$product_id,'week'=>$week))->row_array();
            $total += $query['total'];     
        }
           

        return $total;  
    }

    function GetTotalKoefByWeekProduct($schedule_id,$product_id,$week)
    {   
        $total = 0;
        $this->db->select('id');
        $this->db->where('schedule_id',$schedule_id);
        $this->db->where('product_id',$product_id);
        $get_data = $this->db->get('pmm_schedule_product');
        if($get_data->num_rows() > 0){
            foreach ($get_data->result_array() as $key => $value) {
                $query = $this->db->select('SUM(koef) as total')->get_where('pmm_schedule_product_date',array('schedule_product_id'=>$value['id'],'week'=>$week))->row_array();
                $total += $query['total'];
            }
            
        }

        return $total;  
    }


    function GetScheduleProductMaterials($id)
    {
        $output = false;

        $data = array();
        $this->db->select('ps.koef, pm.material_name,pm.measure,pms.measure_name, psp.product_id,psp.schedule_id');
        $this->db->order_by('material_id','asc');
        $this->db->where('schedule_product_id',$id);
        $this->db->join('pmm_schedule_product psp','ps.schedule_product_id = psp.id','left');
        $this->db->join('pmm_materials pm','ps.material_id = pm.id','left');
        $this->db->join('pmm_measures pms','pm.measure = pms.id','left');
        $query = $this->db->get('pmm_schedule_material ps');
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $key => $w) {

                $week_1 = $this->GetTotalKoefByWeek_2($w['schedule_id'],$w['product_id'],1) * $w['koef'];
                $week_2 = $this->GetTotalKoefByWeek_2($w['schedule_id'],$w['product_id'],2) * $w['koef'];
                $week_3 = $this->GetTotalKoefByWeek_2($w['schedule_id'],$w['product_id'],3) * $w['koef'];
                $week_4 = $this->GetTotalKoefByWeek_2($w['schedule_id'],$w['product_id'],4) * $w['koef'];

                $total = $week_1 + $week_2 + $week_3 + $week_4;
                $data[] = array(
                    'material_name' => $w['material_name'],
                    'measure' => $w['measure_name'],
                    'koef' => $w['koef'],
                    'week_1' => number_format($week_1,2,',','.'),
                    'week_2' => number_format($week_2,2,',','.'),
                    'week_3' => number_format($week_3,2,',','.'),
                    'week_4' => number_format($week_4,2,',','.'),
                    'total' => number_format($total,2,',','.'),
                    'subtotal' => false
                );
            }
        }
        $output = $data;
        return $output;
    }

    function GetTotalScheduleProductMaterials($schedule_id,$product_id)
    {
        $output = false;

        $data = array();
        $this->db->select('id');
        $this->db->where('schedule_id',$schedule_id);
        $this->db->where('product_id',$product_id);
        $get_data = $this->db->get('pmm_schedule_product')->row_array();

        $id = $get_data['id'];
        $this->db->select('ps.koef, pm.material_name,pm.measure,pms.measure_name');
        $this->db->order_by('material_id','asc');
        $this->db->where('schedule_product_id',$id);
        $this->db->join('pmm_materials pm','ps.material_id = pm.id','left');
        $this->db->join('pmm_measures pms','pm.measure = pms.id','left');
        $query = $this->db->get('pmm_schedule_material ps');
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $key => $w) {

                $week_1 = $this->GetTotalKoefByWeekProduct($schedule_id,$product_id,1) * $w['koef'];
                $week_2 = $this->GetTotalKoefByWeekProduct($schedule_id,$product_id,2) * $w['koef'];
                $week_3 = $this->GetTotalKoefByWeekProduct($schedule_id,$product_id,3) * $w['koef'];
                $week_4 = $this->GetTotalKoefByWeekProduct($schedule_id,$product_id,4) * $w['koef'];

                $total = $week_1 + $week_2 + $week_3 + $week_4;
                $data[] = array(
                    'material_name' => $w['material_name'].' ('.$w['measure_name'].')',
                    'koef' => $w['koef'],
                    'week_1' => '<b>'.$week_1.'</b>',
                    'week_2' => '<b>'.$week_2.'</b>',
                    'week_3' => '<b>'.$week_3.'</b>',
                    'week_4' => '<b>'.$week_4.'</b>',
                    'total' => '<b>'.$total.'</b>',
                    'subtotal' => true
                );
            }
        }
        $output = $data;
        return $output;
    }

    function GetTotalMaterials($schedule_id,$week,$material_id)
    {
        $total = 0;
        $this->db->select('SUM(pspd.koef) as total,psp.product_id');
        $this->db->join('pmm_schedule_product psp','pspd.schedule_product_id = psp.id','left');
        $this->db->where('psp.schedule_id',$schedule_id);
        $this->db->where('pspd.week',$week);
        $this->db->group_by('psp.product_id');
        $get_data = $this->db->get('pmm_schedule_product_date pspd')->result_array();
        foreach ($get_data as $key => $w) {
            $koef = $this->GetMatByPro($schedule_id,$material_id,$w['product_id']);
            $subtotal = $w['total'] * $koef;
            $total += $subtotal;
        }
        return $total;
    }

    function GetMatByPro($schedule_id,$material_id,$product_id)
    {
        $this->db->select('psm.koef');
        $this->db->join('pmm_schedule_product psp','psm.schedule_product_id = psp.id','left');
        $this->db->where('psp.schedule_id',$schedule_id);
        $this->db->where('psm.material_id',$material_id);
        $this->db->where('psm.product_id',$product_id);
        $a = $this->db->get('pmm_schedule_material psm')->row_array();
        return $a['koef'];
    }

    function GetScheduleProductKoef($id)
    {
        $output = false;

        $data = array();
        $this->db->select('ps.koef, pm.material_name,pm.measure,pms.measure_name,psp.product_id, psp.schedule_id');
        $this->db->order_by('material_id','asc');
        $this->db->where('schedule_product_id',$id);
         $this->db->join('pmm_schedule_product psp','ps.schedule_product_id = psp.id','left');
        $this->db->join('pmm_materials pm','ps.material_id = pm.id','left');
        $this->db->join('pmm_measures pms','pm.measure = pms.id','left');
        $query = $this->db->get('pmm_schedule_material ps');
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $key => $w) {

                $week_1 = $this->GetTotalKoefByWeek_2($w['schedule_id'],$w['product_id'],1) * $w['koef'];
                $week_2 = $this->GetTotalKoefByWeek_2($w['schedule_id'],$w['product_id'],2) * $w['koef'];
                $week_3 = $this->GetTotalKoefByWeek_2($w['schedule_id'],$w['product_id'],3) * $w['koef'];
                $week_4 = $this->GetTotalKoefByWeek_2($w['schedule_id'],$w['product_id'],4) * $w['koef'];


                $total = $week_1 + $week_2 + $week_3 + $week_4;
                $data[] = array(
                    'material_name' => $w['material_name'].' ('.$w['measure_name'].')',
                    'koef' => $w['koef'],
                    'week_1' => $week_1,
                    'week_2' => $week_2,
                    'week_3' => $week_3,
                    'week_4' => $week_4,
                    'total' => $total
                );
            }
        }
        $output = $data;
        return $output;
    }

    
    function GetScheduleProduct($id)
    {
        $output = false;

        $data = array();
        $this->db->select('psp.id,psp.product_id,psp.schedule_id,psp.activity,pp.nama_produk as product');
        $this->db->where('schedule_id',$id);
        $this->db->join('produk pp','psp.product_id = pp.id','left');
        $this->db->group_by('product_id');
        $this->db->order_by('pp.nama_produk','asc');
        $query = $this->db->get('pmm_schedule_product psp');
        if($query->num_rows() > 0){
            $a = 0;
            foreach ($query->result_array() as $key => $w) {
                $get_count_p = $this->db->get_where('pmm_schedule_product',array('product_id'=>$w['product_id'],'schedule_id'=>$id))->num_rows();
                $w1 = $this->GetTotalKoefByProduct($id,$w['product_id'],1);
                $w2 = $this->GetTotalKoefByProduct($id,$w['product_id'],2);
                $w3 = $this->GetTotalKoefByProduct($id,$w['product_id'],3);
                $w4 = $this->GetTotalKoefByProduct($id,$w['product_id'],4);
                $total_kn = $w1 + $w2 + $w3 + $w4;

                $w['week_1'] =$w1;
                $w['week_2'] =$w2;
                $w['week_3'] =$w3;
                $w['week_4'] =$w4;
                $w['total'] = $total_kn;

                $data[] = $w;
                
            }
        }
        $output = $data;
        return $output;
    }

    function GetPriceCostScheduleDetail($schedule_product_id,$material_id,$week,$type,$schedule_id=false)
    {
        $total = 0;

        $this->db->select('psp.id,psm.koef,psp.product_id,psm.cost,psm.price');
        $this->db->join('pmm_schedule_material psm','psp.id = psm.schedule_product_id','left');
        $this->db->where('psp.schedule_id',$schedule_id);
        $this->db->where('psm.material_id',$material_id);
        $this->db->group_by('psp.product_id');
        $data = $this->db->get('pmm_schedule_product psp')->result_array();
        foreach ($data as $key => $value) {
            $query = $this->db->select('SUM(koef) as total')->get_where('pmm_schedule_product_date',array('schedule_product_id'=>$value['id'],'week'=>$week,'product_id'=>$value['product_id']))->row_array();
            if($type == 1){
                $total += ($query['total'] * $value['koef']) * $value['price']; 
            }else {
                $total += ($query['total'] * $value['koef']) * $value['cost']; 
            }
            
        }


        return $total;
    }

    function GetScheduleDetail($id)
    {
        $output = false;

        $data = array();
        $this->db->select('pm.material_name,psm.koef,pms.measure_name,psm.schedule_product_id,psm.material_id,ps.schedule_date,psp.product_id');
        $this->db->join('pmm_schedule_product psp','psm.schedule_product_id = psp.id','left');
        $this->db->join('pmm_materials pm','psm.material_id = pm.id','left');
        $this->db->join('pmm_measures pms','pm.measure = pms.id','left');
        $this->db->join('pmm_schedule ps','psp.schedule_id = ps.id','left');
        $this->db->where('psp.schedule_id',$id);
        $this->db->order_by('pm.material_name','asc');
        $this->db->group_by('psm.material_id');
        $query = $this->db->get('pmm_schedule_material psm');
        if($query->num_rows() > 0){
            $a = 0;
            foreach ($query->result_array() as $key => $w) {

                $week_1 = $this->GetTotalKoefByWeek($id,1,$w['material_id']);
                $week_2 = $this->GetTotalKoefByWeek($id,2,$w['material_id']);
                $week_3 = $this->GetTotalKoefByWeek($id,3,$w['material_id']);
                $week_4 = $this->GetTotalKoefByWeek($id,4,$w['material_id']);

                $week_1_price = $this->GetPriceCostScheduleDetail($w['schedule_product_id'],$w['material_id'],1,1,$id);
                $week_2_price = $this->GetPriceCostScheduleDetail($w['schedule_product_id'],$w['material_id'],2,1,$id);
                $week_3_price = $this->GetPriceCostScheduleDetail($w['schedule_product_id'],$w['material_id'],3,1,$id);
                $week_4_price = $this->GetPriceCostScheduleDetail($w['schedule_product_id'],$w['material_id'],4,1,$id);

                $total = $week_1 + $week_2 + $week_3 + $week_4;
                $total_price = $week_1_price + $week_2_price + $week_3_price + $week_4_price;
                
                $butuh = $total;
                $butuh_price = $total_price;
                $data[] = array(
                    'material_name' => $w['material_name'],
                    'measure' => $w['measure_name'],
                    'week_1' => number_format($week_1,2,',','.'),
                    'week_2' => number_format($week_2,2,',','.'),
                    'week_3' => number_format($week_3,2,',','.'),
                    'week_4' => number_format($week_4,2,',','.'),
                    'week_1_price' => number_format($week_1_price,2,',','.'),
                    'week_2_price' => number_format($week_2_price,2,',','.'),
                    'week_3_price' => number_format($week_3_price,2,',','.'),
                    'week_4_price' => number_format($week_4_price,2,',','.'),
                    'butuh' => number_format($butuh,2,',','.'),
                    'total' => number_format($total,2,',','.'),
                    'sisa' => number_format(0,2,',','.'),
                    'butuh_price' => number_format($butuh_price,2,',','.'),
                    'total_price' => number_format($total_price,2,',','.'),
                );
            }
        }
        $output = $data;
        return $output;
    }

    function GetTotalKoefByProduct($schedule_id,$product_id,$week)
    {
        $output = false;

        $this->db->select('id');
        $this->db->where('schedule_id',$schedule_id);
        $this->db->where('product_id',$product_id);
        $query = $this->db->get('pmm_schedule_product');
        if($query->num_rows() > 0){
            $total = 0;
            foreach ($query->result_array() as $key => $value) {
                $get_total = $this->db->select('SUM(koef) as total')->get_where('pmm_schedule_product_date',array('schedule_product_id'=>$value['id'],'week'=>$week))->row_array();
                $total += $get_total['total'];

            }
            $output = $total;
        }
        return $output;
    }

    function GetTotalMatByProduct($schedule_id,$product_id,$week)
    {
        $output = false;

        $this->db->select('id');
        $this->db->where('schedule_id',$schedule_id);
        $this->db->where('product_id',$product_id);
        $query = $this->db->get('pmm_schedule_product');
        if($query->num_rows() > 0){
            $total = 0;
            foreach ($query->result_array() as $key => $value) {
                $get_total = $this->db->select('SUM(koef) as total')->get_where('pmm_schedule_product_date',array('schedule_product_id'=>$value['id'],'week'=>$week))->row_array();
                $total += $get_total['total'];

            }
            $output = $total;
        }
        return $output;
    }


    function GetArrTotalMaterials($schedule_id)
    {
        $output = array();

        $this->db->select('psm.material_id,pm.material_name,pms.measure_name');
        $this->db->join('pmm_schedule_product pmm','psm.schedule_product_id = pmm.id','left');
        $this->db->join('pmm_materials pm','psm.material_id = pm.id','left');
        $this->db->join('pmm_measures pms','pm.measure = pms.id','left');
        $this->db->where('pmm.schedule_id',$schedule_id);
        $this->db->group_by('psm.material_id');
        $query = $this->db->get('pmm_schedule_material psm');
        if($query->num_rows() > 0){
 
            $data = array();
            foreach (array_unique($query->result_array(),SORT_REGULAR) as $key => $value) {
                
                $arr['material_name'] = $value['material_name'].' '.$value['measure_name'];
                $arr['material_id'] = $value['material_id'];
                $data[] = $arr;
            }

            $output = $data;
        }
        return $output; 
    }
    
    function GetStatus($status)
    {
        if($status == 'WAITING'){
            return '<button type="button" class="btn btn-warning" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }else if($status == 'DRAFT'){
            return '<button type="button" class="btn btn-warning" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }else if($status == 'APPROVED'){
            return '<button type="button" class="btn btn-success" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }else if($status == 'REJECTED'){
            return '<button type="button" class="btn btn-danger" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }else if($status == 'CLOSED'){
            return '<button type="button" class="btn btn-danger" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }else if($status == 'PUBLISH'){
            return '<button type="button" class="btn btn-success" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }else if($status == 'REJECT'){
        return '<button type="button" class="btn btn-danger" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }
    }

	function GetStatus2($status)
    {
        if($status == 'DRAFT'){
            return '<button type="button" class="btn btn-warning" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }else if($status == 'OPEN'){
            return '<button type="button" class="btn btn-success" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }else if($status == 'REJECT'){
            return '<button type="button" class="btn btn-danger" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }else if($status == 'CLOSED'){
            return '<button type="button" class="btn btn-danger" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }else if($status == 'DELETED'){
            return '<button type="button" class="btn btn-danger" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }
		
    }
	
	function GetStatus3($status)
    {
        if($status == 'BELUM LUNAS'){
            return '<button type="button" class="btn btn-danger" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }else if($status == 'LUNAS'){
            return '<button type="button" class="btn btn-success" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }
    }
	function GetStatus4($status)
    {
        if($status == 'PUBLISH'){
            return '<button type="button" class="btn btn-success" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }else if($status == 'CLOSED'){
            return '<button type="button" class="btn btn-danger" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }
    }

    function GetStatusVerif($status)
    {
        if($status == 'SUDAH'){
            return '<button type="button" class="btn btn-danger" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }else if($status == 'BELUM'){
            return '<button type="button" class="btn btn-success" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }
    }

    function GetStatusKategoriPersetujuan($status)
    {
        if($status == 'VERIFIKASI PEMBELIAN'){
            return '<button type="button" class="btn btn-info" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }else if($status == 'PESANAN PEMBELIAN'){
            return '<button type="button" class="btn btn-success" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }else if($status == 'PERMINTAAN BAHAN & ALAT'){
            return '<button type="button" class="btn btn-warning" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }else if($status == 'PERUBAHAN SISTEM'){
            return '<button type="button" class="btn btn-info" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }
    }
	
	function StatusPayment($status)
    {
        if($status == 'CREATING'){
            $output = '<button type="button" class="btn btn-warning" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }else if($status == 'CREATED'){
            $output = '<button type="button" class="btn btn-success" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }else if($status == 'UNCREATED'){
            $output = '<button type="button" class="btn btn-danger" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }else if($status == 'UNPUBLISH'){
            $output = '<button type="button" class="btn btn-danger" style="font-weight:bold; border-radius:10px;">'.$status.'</button>';
        }

        return $output;
    }

    function SelectScheduleProduct($schedule_id)
    {
        $output = false;

        $data = array();
        $data = $this->db->select('id as product_id, product')->order_by('product','asc')->get('pmm_product')->result_array();
        $output = $data;
        return $output;
    }   


    function SelectMatByProd($schedule_id,$product_id)
    {
        $composition_id = $this->crud_global->GetField('pmm_product',array('id'=>$product_id),'composition_id');

        $this->db->select('pcd.koef,pcd.material_id,pm.material_name,pms.measure_name');
        $this->db->join('pmm_materials pm','pcd.material_id = pm.id','left');
        $this->db->join('pmm_measures pms','pm.measure = pms.id','left');
        $this->db->where('composition_id',$composition_id);
        $query = $this->db->get('pmm_composition_detail pcd')->result_array();
        return $query;
    }


    function CreatePO($id)
    {
        $output = false;

        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 


        $arr_rm = $this->db->select('supplier_id,subject,memo,kategori_id,created_by')->get_where('pmm_request_materials',array('id'=>$id))->row_array();

        $dt = $this->db->get_where('pmm_request_materials',array('id'=>$id))->row_array();
        $data = array(
            'request_material_id' => $id,
            'no_po' => $this->pmm_model->GetNoPO($dt['request_no']),
            'date_po' => $dt['request_date'],
            'supplier_id' => $arr_rm['supplier_id'],
			'memo' => $arr_rm['memo'],
            'kategori_id' => $arr_rm['kategori_id'],
            'subject' => $arr_rm['subject'],
            'created_by' => $arr_rm['created_by'],
            'created_on' => date('Y-m-d H:i:s'),
            'unit_head' => 41,
            'kategori_persetujuan' => 'PESANAN PEMBELIAN',
            'status' => 'WAITING'
        );

        if($this->db->insert('pmm_purchase_order',$data)){
            $po_id = $this->db->insert_id();

            $get_data = $this->db->select('*')->get_where('pmm_request_material_details',array('request_material_id'=>$id))->result_array();
            $total = 0;
            foreach ($get_data as $key => $row) {
                $measure = $this->crud_global->GetField('pmm_measures',array('id'=>$row['measure_id']),'measure_name');
                $arr = array(
                    'purchase_order_id' => $po_id,
                    'material_id' => $row['material_id'],
                    'volume'    => $row['volume'],
                    'price' => $row['price'],
                    'measure' => $measure,
					'penawaran_id' => $row['penawaran_id'],
					'tax_id' => $row['tax_id'],
					'tax' => $row['tax'],
                    'pajak_id' => $row['pajak_id'],
					'pajak' => $row['pajak']
                );
                $total +=  $row['price'] * $row['volume'];
                $this->db->insert('pmm_purchase_order_detail',$arr);
            }

            $this->db->update('pmm_purchase_order',array('total'=>$total),array('id'=>$po_id));
            

        }

        if ($this->db->trans_status() === FALSE) {
            # Something went wrong.
            $this->db->trans_rollback();
            $output = false;
        } 
        else {
            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            $output = true;
        }

        return $output;
    }


    function GetPODetail($id)
    {
        $output = false;
        $this->db->select('pp.*,SUM(pp.volume) as total, pp.id, pp.penawaran_id, ppp.memo, p.nama_produk');
        $this->db->join('pmm_penawaran_pembelian ppp','pp.penawaran_id = ppp.id','left');
        $this->db->join('produk p','pp.material_id = p.id','left');
        $this->db->where('pp.purchase_order_id',$id);
        $this->db->group_by('pp.material_id');
        $this->db->order_by('p.nama_produk','asc');
        $query = $this->db->get('pmm_purchase_order_detail pp')->result_array();

        return $query;
    }

    function GetPODetailNoPNW($id)
    {
        $output = false;
        $this->db->select('pp.*,SUM(pp.volume) as total, pp.id, pp.penawaran_id, ppp.memo, p.nama_produk');
        $this->db->join('pmm_penawaran_pembelian ppp','pp.penawaran_id = ppp.id','left');
        $this->db->join('produk p','pp.material_id = p.id','left');
        $this->db->where('pp.purchase_order_id',$id);
        $this->db->group_by('pp.penawaran_id');
        $this->db->order_by('p.nama_produk','asc');
        $query = $this->db->get('pmm_purchase_order_detail pp')->result_array();

        return $query;
    }

    function GetPODetailPNW($id)
    {
        $output = false;
        $this->db->select('pp.penawaran_id');
        $this->db->join('pmm_penawaran_pembelian ppp','pp.penawaran_id = ppp.id','left');
        $this->db->where('pp.purchase_order_id',$id);
        $this->db->group_by('pp.purchase_order_id');
        $query = $this->db->get('pmm_purchase_order_detail pp')->result_array();

        return $query;
    }

    function GetPODetailREQ($id)
    {
        $output = false;
        $this->db->select('po.request_material_id');
        $this->db->where('po.id',$id);
        $this->db->group_by('po.request_material_id');
        $query = $this->db->get('pmm_purchase_order po')->result_array();

        return $query;
    }

    function GetReceiptByPO($id)
    {
        $output = false;
        $this->db->select('SUM(prm.volume) as volume, SUM(prm.volume * prm.price) as total,prm.measure, pm.nama_produk as material_name,prm.material_id');
        $this->db->join('produk pm','prm.material_id = pm.id','left');
        $this->db->where('prm.purchase_order_id',$id);
        $this->db->group_by('prm.material_id');
        $query = $this->db->get('pmm_receipt_material prm')->result_array();

        return $query;
    }

    function GetReceiptBySalesOrder($id)
    {
        $output = false;
        $this->db->select('SUM(pp.volume) as volume, SUM(pp.volume * pp.harga_satuan) as total, pp.measure, pm.nama_produk as material_name, pp.product_id');
        $this->db->join('produk pm','pp.product_id = pm.id','left');
        $this->db->where('pp.salesPo_id',$id);
        $this->db->group_by('pp.product_id');
        $query = $this->db->get('pmm_productions pp')->result_array();

        return $query;
    }


    function GetRielPrice($product_id)
    {
        $output = 0;
        
        $total_comp = 0;
        

        $total_tools = 0;
        $tools = $this->db->select('koef,type_id')->get_where('pmm_product_detail',array('product_id'=>$product_id,'status'=>'PUBLISH'))->result_array();
        if(!empty($tools)){
            $data_tools = array();
            foreach ($tools as $key => $to) {
                $price = $this->db->select('SUM(cost) as total_tools')->get_where('pmm_tool_detail',array('tool_id'=>$to['type_id'],'status'=>'PUBLISH'))->row_array();

                $total_tools += $to['koef'] * $price['total_tools'];
            }
        }

        $total_others = 0;
        $others = $this->db->select('SUM(price) as total')->get_where('pmm_product_price',array('product_id'=>$product_id))->row_array();        
        if(!empty($others)){
            $total_others = $others['total'];
        }

        $output = $total_comp + $total_tools + $total_others;
        return $output;
    }

    function GetRielPriceDetail($product_id)
    {
        $output = array();
        $tools = $this->db->select('koef,type_id')->get_where('pmm_product_detail',array('product_id'=>$product_id,'status'=>'PUBLISH'))->result_array();
        if(!empty($tools)){
            $data_tools = array();
            foreach ($tools as $key => $to) {
                $tool_name = $this->crud_global->GetField('pmm_tools',array('id'=>$to['type_id']),'tool');
                $price = $this->db->select('SUM(cost) as total_tools')->get_where('pmm_tool_detail',array('tool_id'=>$to['type_id'],'status'=>'PUBLISH'))->row_array();

                $to['price'] = number_format($price['total_tools'],1,',','.');
                $to['tool_name'] = $tool_name;
                $to['total'] = number_format($to['koef'] * $price['total_tools'],2,',','.');
                $to['total_val'] =$to['koef'] * $price['total_tools'];
                $data_tools[] = $to;
            }
            $output['tools'] = $data_tools;
        }

        $other_price = $this->db->select('id,product_id,name,price')->get_where('pmm_product_price',array('product_id'=>$product_id))->result_array();
        $output['others'] = $other_price;
        return $output;
    }


    function TableDetailRequestMaterials($request_material_id)
    {
        $data = array();
        $this->db->select('psm.*,pm.nama_produk as material_name,pms.measure_name');
        $this->db->where('request_material_id',$request_material_id);
        $this->db->join('produk pm','psm.material_id = pm.id','left');
        $this->db->join('pmm_measures pms','psm.measure_id = pms.id','left');
        $this->db->order_by('pm.nama_produk','asc');
        $query = $this->db->get('pmm_request_material_details psm');
	
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
                $row['total'] = $row['volume'] * $row['price'];
                $row['volume']= number_format($row['volume'],2,',','.');
				$row['price']= number_format($row['price'],0,',','.');
                $row['material_name'] = $row['material_name'];
                $row['measure'] = $row['measure_name'];
                $get_status = $this->crud_global->GetField('pmm_request_materials',array('id'=>$row['request_material_id']),'status');
                if($get_status == 'DRAFT'){
                    $row['actions'] = '<a href="javascript:void(0);" onclick="DeleteData('.$row['id'].')" class="btn btn-danger"><i class="fa fa-close"></i> </a>';
                }else {
                    $row['actions'] = '-';
                }
                
                $data[] = $row;
            }

        }
        
        return $data;   
    }
    


    function GetPOMaterials($supplier_id,$id=false)
    {
        $data = array();
        $this->db->select('pm.nama_produk as material_name,pod.material_id,pod.measure, pod.volume,po.date_po, pm.satuan as display_measure, pod.tax as tax, pod.tax_id as tax_id, pod.pajak as pajak, pod.pajak_id as pajak_id');
        if(!empty($supplier_id)){
            $this->db->where('po.supplier_id',$supplier_id);
        }
        if(!empty($id)){
            $this->db->where('po.id',$id);
        }
        $this->db->where('po.status','PUBLISH');
        $this->db->join('produk pm','pod.material_id = pm.id','left');
        $this->db->join('pmm_purchase_order po','pod.purchase_order_id = po.id','left');
        $this->db->group_by('pod.material_id');
        $this->db->order_by('pm.nama_produk','asc');
        $query = $this->db->get('pmm_purchase_order_detail pod');
        
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $key => $row) {
                $data[] = $row;
            }

        }
        
        return $data;   
    }


   function GetContractPrice($price)
   {
        $output = $price;

        $get_ov = $this->crud_global->GetField('pmm_setting_production',array('id'=>1),'overhead');
        if(!empty($get_ov)){
            $ov = ($get_ov * $price) / 100;
            $output = $price + $ov;
        }
        return $output;

   }

   function GetPriceProductions($sales_po_id,$product,$volume)
   {
        $output = 0;

        $contract_price = $this->crud_global->GetField('pmm_sales_po_detail',array('sales_po_id'=>$sales_po_id,'product_id'=>$product),'price');
     
        $output = $this->GetContractPrice($contract_price) * $volume;
		

        return $output;

   }

   function GetCostProductions($product,$volume)
   {
        $output = 0;

        $output = $this->GetRielPrice($product) * $volume;
        return $output;

   }
   

   function TotalSPOWeek($id,$week)
   {
        $output = 0;

        $this->db->select('SUM(psp.koef) as total,psp.status');
        $this->db->join('pmm_schedule_product ps','psp.schedule_product_id = ps.id','left');
        $this->db->where('psp.week',$week);
        $this->db->where('ps.schedule_id',$id);
        $arr = $this->db->get('pmm_schedule_product_date psp')->row_array();
        if(!empty($arr)){
            if($arr['status'] == 'WAITING'){
                $output = '<button class="btn btn-warning btn-sm" onclick="EditWeek('.$id.','.$week.')" >'.$arr['total'].'</button>';
            }else if($arr['status'] == 'PUBLISH'){
                $output = '<button class="btn btn-success btn-sm" onclick="EditWeek('.$id.','.$week.')" >'.$arr['total'].'</button>';
            }else {
                $output = '<button class="btn btn-info btn-sm" onclick="EditWeek('.$id.','.$week.')" >'.$arr['total'].'</button>';
            }
        }
        
        

        return $output;
   }


   function GetSPOByWeek($schedule_id,$week)
   {
    $output = false;

    $data = array();
    $this->db->select('psp.id,psp.product_id,psp.activity,pp.nama_produk as product');
    $this->db->join('produk pp','psp.product_id = pp.id','left');
    $this->db->where('schedule_id',$schedule_id);
    $query = $this->db->get('pmm_schedule_product psp');
    if($query->num_rows() > 0){
        $data['products'] = $query->result_array();

        $this->db->select('psp.date');
        $this->db->where('psp.week',$week);
        $this->db->where('ps.schedule_id',$schedule_id);
        $this->db->join('pmm_schedule_product ps','psp.schedule_product_id = ps.id','left');
        $this->db->group_by('psp.date');
        $arr = $this->db->get('pmm_schedule_product_date psp');
        $arr_date = $arr->result_array();


        $a = array();
        foreach ($arr_date as $key_v => $value) {
            foreach ($data['products'] as $key => $row) {
                $total = $this->db->select('SUM(koef) as total')->get_where('pmm_schedule_product_date',array('schedule_product_id'=>$row['id'],'week'=>$week,'date'=>$value['date']))->row_array();
                $value[$key + 1] = array($row['id']=>$total['total']);
            }
            $value['date_val'] = str_replace('-', '_', $value['date']);
            $value['date'] = date('d F Y',strtotime($value['date']));
            $a[] = $value;
        }

        $data['date'] = $a;
        $output = $data;
    }

    return $output;
   }

    function GetStatusPP($schedule_id,$week)
    {
        $output = false;

        $data = array();
        $this->db->select('pspd.status');
        $this->db->join('pmm_schedule_product psp','pspd.schedule_product_id = psp.id','left');
        $this->db->where('psp.schedule_id',$schedule_id);
        $this->db->where('pspd.week',$week);
        $query = $this->db->get('pmm_schedule_product_date pspd')->row_array();
        if(!empty($query)){
            $output = $query['status'];
        }

        return $output;
    }


    function GetTotalSisa($material_id,$start_date)
    {
        $output = 0;

        $this->db->select('SUM(volume) as total');
        $this->db->where('material_id',$material_id);
        $query = $this->db->get('pmm_receipt_material')->row_array();
        $total_mat = $query['total'];

        $this->db->select('SUM(pp.volume) as volume,ppm.koef');
        $this->db->join('pmm_production_material ppm','pp.id = ppm.production_id','left');
        $this->db->where('pp.date_production <',date('Y-m-d',strtotime($start_date)));
        $this->db->where('ppm.material_id',$material_id);
        $this->db->where('pp.status','PUBLISH');
        $arr = $this->db->get('pmm_productions pp')->row_array();
        $a = $arr['volume'] * $arr['koef'];
        $output = $total_mat - $a;
        return $output;
    }

    function GetProByProductDate($product_id,$start_date,$end_date)
    {
        $output = 0;

        $this->db->select('SUM(pp.volume) as volume');
        $this->db->where('pp.date_production >=',date('Y-m-d',strtotime($start_date)));
        $this->db->where('pp.date_production <=',date('Y-m-d',strtotime($end_date)));
        $this->db->where('pp.product_id',$product_id);
        $this->db->where('pp.status','PUBLISH');
        $arr = $this->db->get('pmm_productions pp')->row_array();
        if(!empty($arr)){
            $output = $arr['volume'];   
        }
        
        return $output;
    }


    function GetMaterialsOnRequest($schedule_id)
    {
        $output = 0;

        $this->db->select('psd.material_id,psd.koef,pm.material_name');
        $this->db->join('pmm_product pp','psp.product_id = pp.id','left');
        $this->db->join('pmm_composition_detail psd','pp.composition_id = psd.composition_id','left');
        $this->db->join('pmm_materials pm','psd.material_id = pm.id','left');
        $this->db->where('psp.schedule_id',$schedule_id);
        $this->db->group_by('psd.material_id');
        $arr = $this->db->get('pmm_schedule_product psp')->result_array();
        if(!empty($arr)){
            $output = $arr; 
        }
        
        return $output;
    }


   

    function DashboardProductions($arr_date,$client=false)
    {
        $data = array();

        $this->db->select('pc.client_name,ps.client_id');
        $this->db->join('pmm_client pc','ps.client_id = pc.id','left');
        if(!empty($arr_date)){
            $this->db->where('ps.date_production >=',date('Y-m-d',strtotime($arr_date[0])));
            $this->db->where('ps.date_production <=',date('Y-m-d',strtotime($arr_date[1])));
        }

        $this->db->group_by('ps.client_id');
        $this->db->where('ps.status','PUBLISH');
        $query = $this->db->get('pmm_productions ps');
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
                $row['products'] = $this->GetProductForDash($arr_date,$row['client_id']);
                $data[] = $row;
            }
        }

        return $data;
    }

    function GetProductForDash($arr_date,$client_id)
    {   
        $data = array();
        $this->db->select('pp.product,pp.id');
        $this->db->where('pp.status','PUBLISH');
        $this->db->group_by('pp.id');
        $query = $this->db->get('pmm_product pp');
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $key => $row) {

                $row['total_planning'] = $this->TotalPlanningFixed($row['id'],$arr_date,$client_id);
                $total_productions = $this->TotalRealProductions($row['id'],$arr_date,$client_id);
                $row['total_productions'] = $total_productions['total_productions'];
                $row['cost'] = $total_productions['cost'];
                $row['bill'] = $total_productions['bill'];

                $data[] = $row;
            }
        }
        return $data;
    }


    function TotalPlanningFixed($product_id,$arr_date,$client_id)
    {
        $output =0;

        $this->db->select('SUM(pspdf.koef) as total_planning');
        $this->db->join('pmm_schedule_product psd','pspdf.schedule_product_id = psd.id','left');
        $this->db->join('pmm_schedule ps','psd.schedule_id = ps.id','left');
        if(!empty($arr_date)){
            $this->db->where('pspdf.date >=',date('Y-m-d',strtotime($arr_date[0])));
            $this->db->where('pspdf.date <=',date('Y-m-d',strtotime($arr_date[1])));
        }
        $this->db->where('ps.client_id',$client_id);
        $this->db->where('psd.product_id',$product_id);
        $query = $this->db->get('pmm_schedule_product_date_fixed pspdf');
        if($query->num_rows() > 0){
            if($query->row_array()['total_planning'] == null){
                $output = 0;
            }else {
                $output = $query->row_array()['total_planning'];    
            }
            
        }
        return $output;
    }

    function TotalRealProductions($product_id,$arr_date,$client_id)
    {
        $output =0;

        $this->db->select('SUM(pp.volume) as total_productions, SUM(pp.price) as bill, SUM(pp.cost) as cost');
        if(!empty($arr_date)){
            $this->db->where('pp.date_production >=',date('Y-m-d',strtotime($arr_date[0])));
            $this->db->where('pp.date_production <=',date('Y-m-d',strtotime($arr_date[1])));
        }
        $this->db->where('pp.client_id',$client_id);
        $this->db->where('pp.product_id',$product_id);
        $this->db->where('pp.status','PUBLISH');
        $this->db->where('pp.status','PUBLISH');
        $query = $this->db->get('pmm_productions pp');
        if($query->num_rows() > 0){
            if($query->row_array()['total_productions'] == null){
                $output = array(
                    'total_productions' => 0,
                    'cost' => 0,
                    'bill' => 0,
                );
            }else {
                $output = array(
                    'total_productions' => $query->row_array()['total_productions'],
                    'cost' => $query->row_array()['cost'],
                    'bill' => $query->row_array()['bill'],
                );
            }
            
        }
        return $output;
    }

    function GetMaterialsProductions($product_id=false,$arr_date,$client_id=false,$material_id)
    {
        $output = array();
        $arr_date = explode(' - ', $arr_date);

        $this->db->select('pp.id,pp.volume,pp.date_production, pp.product_id');
        $this->db->where('pp.date_production >=',date('Y-m-d',strtotime($arr_date[0])));
        $this->db->where('pp.date_production <=',date('Y-m-d',strtotime($arr_date[1]))); 
        if(!empty($product_id)){
            $this->db->where('pp.product_id',$product_id);
        } 
        if(!empty($client_id)){
           $this->db->where('pp.client_id',$client_id); 
        }
        $this->db->where('pp.status','PUBLISH');
        $query = $this->db->get_where('pmm_productions pp')->result_array();
        $total_sub = 0;
        $cost =0;
        foreach ($query as $key => $row) {
            
            $this->db->select('koef,price');
            $data = $this->db->get_where('pmm_production_material',array('production_id'=>$row['id'],'material_id'=>$material_id))->row_array();
            

            if($material_id == 1){
                $data['koef'] = $data['koef'] / 1000;
                if($data['price'] == 850){
                    $data['price'] = 850000;
                }
            }
            $total = $row['volume'] * $data['koef'];
            $cost += $total * $data['price'];
            $total_sub += $total;
        }
        $output = array('vol'=>$total_sub,'cost'=>$cost);

        return $output;

    }
    
    function GetTotalPemakaianMat($product_id,$arr_date,$client_id)
    {
        $output = 0;
        $this->db->select('SUM(volume) as volume');
        if(!empty($arr_date)){
            $this->db->where('pp.date_production >=',date('Y-m-d',strtotime($arr_date[0])));
            $this->db->where('pp.date_production <=',date('Y-m-d',strtotime($arr_date[1])));
        }
        if(!empty($product_id)){
            $this->db->where('pp.product_id',$product_id);
        }
        $this->db->where('pp.status','PUBLISH');
        $this->db->where('pp.client_id',$client_id);
        $this->db->where('pp.status','PUBLISH');
        $query = $this->db->get('pmm_productions pp');  
        if($query->row_array()['volume'] == null){
            $output = 0;
        }else {
            $output = $query->row_array()['volume'];    
        }

        return $output;
    }


    function GetTotalReceipt($purchase_order_id)
    {
        $output = 0;

        $this->db->select('SUM(volume) as volume,harga_satuan');
        $this->db->where('purchase_order_id',$purchase_order_id);
        $this->db->group_by('material_id');
        $query = $this->db->get('pmm_receipt_material');
        foreach ($query->result_array() as $key => $row) {
            $output += $row['volume'] * $row['harga_satuan'];
        }
        return $output;
    }
	
    function GetReceiptMatUse($supplier_id=false,$purchase_order_no=false,$start_date=false,$end_date=false,$filter_material=false)
    {
        $output = array();

        $this->db->select('prm.measure,pm.material_name,prm.material_id,SUM(prm.volume) as total, SUM((prm.cost / prm.convert_value) * prm.display_volume) as total_price, prm.convert_value, SUM(prm.volume * prm.convert_value) as total_convert');
        $this->db->join('pmm_materials pm','prm.material_id = pm.id','left');
        $this->db->join('pmm_purchase_order ppo','prm.purchase_order_id = ppo.id','left');
        if(!empty($start_date) && !empty($end_date)){
            $this->db->where('prm.date_receipt >=',$start_date);
            $this->db->where('prm.date_receipt <=',$end_date);
        }
        if(!empty($supplier_id)){
            $this->db->where('ppo.supplier_id',$supplier_id);
        }
        if(!empty($purchase_order_no)){
            $this->db->where('ppo.id',$purchase_order_no);
        }
        if(!empty($filter_material)){
            $this->db->where_in('prm.material_id',$filter_material);
        }
        $this->db->order_by('pm.material_name','asc');
        $this->db->group_by('prm.material_id');
        $query = $this->db->get('pmm_receipt_material prm');
        $output = $query->result_array();
        return $output;
    }

    function GetReceiptMatUseLalu($supplier_id=false,$purchase_order_no=false,$start_date=false,$filter_material=false)
    {
        $output = array();

        $this->db->select('prm.measure,pm.material_name,prm.material_id,SUM(prm.volume) as total, SUM((prm.cost / prm.convert_value) * prm.display_volume) as total_price, prm.convert_value, SUM(prm.volume * prm.convert_value) as total_convert');
        $this->db->join('pmm_materials pm','prm.material_id = pm.id','left');
        $this->db->join('pmm_purchase_order ppo','prm.purchase_order_id = ppo.id','left');
        if(!empty($start_date)){
            $this->db->where('prm.date_receipt <',$start_date);
        }
        if(!empty($supplier_id)){
            $this->db->where('ppo.supplier_id',$supplier_id);
        }
        if(!empty($purchase_order_no)){
            $this->db->where('ppo.id',$purchase_order_no);
        }
        if(!empty($filter_material)){
            $this->db->where_in('prm.material_id',$filter_material);
        }
        $this->db->order_by('pm.material_name','asc');
        $this->db->group_by('prm.material_id');
        $query = $this->db->get('pmm_receipt_material prm');
        $output = $query->result_array();
        return $output;
    }

    function GetProMatMonth()
    {
        $output = array();

        $this->db->select('pm.material_name,ppm.material_id,ppm.koef,pms.measure_name,pm.cost,pm.color,pm.color_real');
        $this->db->join('pmm_productions pp','ppm.production_id = pp.id','left');
        $this->db->join('pmm_materials pm','ppm.material_id = pm.id','left');
        $this->db->join('pmm_measures pms','ppm.measure = pms.id','left');
        $this->db->order_by('ppm.material_id','asc');
        $this->db->group_by('ppm.material_id');
        $this->db->where('pp.status','PUBLISH');
        $query = $this->db->get('pmm_production_material ppm');
        $output = $query->result_array();
        return $output;
    }

    function GetReceiptMatMonth()
    {
        $output = array();

        $this->db->select('pm.material_name,ppm.material_id,pm.cost,ppm.measure');
        $this->db->join('pmm_materials pm','ppm.material_id = pm.id','left');
        $this->db->order_by('ppm.material_id','asc');
        $this->db->group_by('ppm.material_id');
        $query = $this->db->get('pmm_receipt_material ppm');
        $output = $query->result_array();
        return $output;
    }


    function TableCustomMaterial($supplier_id)
    {
        $data = array();
        $w_date = $this->input->post('filter_date');
        if($supplier_id !== 0){
            $this->db->where('supplier_id',$supplier_id);
        }
        if(!empty($w_date)){
            $arr_date = explode(' - ', $w_date);
            $start_date = $arr_date[0];
            $end_date = $arr_date[1];
            $this->db->where('date_po  >=',date('Y-m-d',strtotime($start_date)));   
            $this->db->where('date_po <=',date('Y-m-d',strtotime($end_date)));  
        }
        $this->db->where('date_po >=', date('2023-08-01'));
        $this->db->where("status <> 'REJECT'");
		$this->db->order_by('created_on','DESC');
        $query = $this->db->get('pmm_purchase_order');
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
                $no_po = "'".$row['no_po']."'";
                $row['no_po'] = '<a href="'.site_url('pmm/purchase_order/manage/'.$row['id']).'">'.$row['no_po'].'</a>';
                $row['document_po'] = '<a href="'.base_url().'uploads/purchase_order/'.$row['document_po'].'" target="_blank">'.$row['document_po'].'</a>';
                $row['date'] = date('d/m/Y',strtotime($row['date_po']));
                $row['supplier'] = $this->crud_global->GetField('penerima',array('id'=>$row['supplier_id']),'nama');
                $total_volume = $this->db->select('SUM(volume) as total,measure,SUM(volume * price) as total_tanpa_ppn')->get_where('pmm_purchase_order_detail',array('purchase_order_id'=>$row['id']))->row_array();
                $row['volume'] = number_format($total_volume['total'],2,',','.');
                $row['measure'] = $total_volume['measure'];
                $row['total_val'] = intval($row['total']);
                $row['total'] = number_format($total_volume['total_tanpa_ppn'],0,',','.');
                $receipt = $this->db->select('SUM(volume) as total')->get_where('pmm_receipt_material',array('purchase_order_id'=>$row['id']))->row_array();
                $total_receipt = $this->pmm_model->GetTotalReceipt($row['id']);
                $row['receipt'] = number_format($receipt['total'],2,',','.');
                $presentase = ($receipt['total'] / $total_volume['total']) * 100;
				$row['presentase'] = number_format($presentase,0,',','.').' %';
                $row['total_receipt'] = number_format($total_receipt,0,',','.');
                $row['total_receipt_val'] = $total_receipt;
                $row['document_po'] = '<a href="' . base_url('uploads/purchase_order/' . $row['id']) .'" target="_blank">' . $row['document_po'] . '</a>';        
                $delete = '<a href="javascript:void(0);" onclick="DeleteData('.$row['id'].')" class="btn btn-danger"><i class="fa fa-close"></i> </a>';
                $edit = false;
                $edit = '<a href="javascript:void(0);" onclick="UploadDoc('.$row['id'].')" class="btn btn-primary" style="border-radius:10px;" title="Upload Document PO" ><i class="fa fa-upload"></i> </a>';
                /*if($row['status'] == 'PUBLISH' || $row['status'] == 'CLOSED'){
                    $edit = '<a href="javascript:void(0);" onclick="UploadDoc('.$row['id'].')" class="btn btn-primary" style="border-radius:10px;" title="Upload Document PO" ><i class="fa fa-upload"></i> </a>';
                }*/
                $edit_no_po = false;
                $status = "'".$row['status']."'";
                $subject = "'".$row['subject']."'";
                $date_po = "'".date('d-m-Y',strtotime($row['date_po']))."'";
                if(in_array($this->session->userdata('admin_group_id'), array(1,2,3,4))){
                    $edit_no_po = '<a href="javascript:void(0);" onclick="EditNoPo('.$row['id'].','.$no_po.','.$status.','.$subject.','.$date_po.')" class="btn btn-primary" style="border-radius:10px;" title="Edit Nomor PO" ><i class="fa fa-edit"></i> </a>';
                }
                $row['status'] = $this->pmm_model->GetStatus($row['status']);
                $row['actions'] = $edit.' '.$edit_no_po;
                $row['admin_name'] = $this->crud_global->GetField('tbl_admin',array('admin_id'=>$row['created_by']),'admin_name');
                $row['created_on'] = date('d/m/Y H:i:s',strtotime($row['created_on']));

                $data[] = $row;
            }
        }

        return $data;
    }

    function GetPlanningMat($material_id,$start_date=false,$end_date=false)
    {
        $output = 0;


        $this->db->select('SUM(koef) as total');
        if(!empty($start_date) && !empty($end_date)){
            $this->db->where('date >=',$start_date);
            $this->db->where('date <=',$end_date);
        }
        $this->db->where('status','PUBLISH');
        $query = $this->db->get('pmm_schedule_product_date');
        $total = $query->row_array()['total'];


        $this->db->select('psm.koef');
        $this->db->join('pmm_schedule_product_date pspd','psm.schedule_product_id = pspd.schedule_product_id','left');
        if(!empty($start_date) && !empty($end_date)){
            $this->db->where('pspd.date >=',$start_date);
            $this->db->where('pspd.date <=',$end_date);
        }
        $this->db->where('psm.material_id',$material_id);
        $mat = $this->db->get('pmm_schedule_material psm')->row_array();

        $output = $total * $mat['koef'];
        return number_format($output,2,',','.');
    }

    function GetPOMat($material_id,$start_date=false,$end_date=false,$supplier_id=false,$purchase_order_no=false)
    {
        $output = 0;

        $this->db->select('SUM(ppod.volume) as total');
        $this->db->join('pmm_purchase_order ppo','ppod.purchase_order_id = ppo.id','left');
        if(!empty($supplier_id)){
            $this->db->where('ppo.supplier_id',$supplier_id);
        }
        if(!empty($purchase_order_no)){
            $this->db->where('ppo.id',$purchase_order_no);
        }
        $this->db->where('material_id',$material_id);
        $query = $this->db->get_where('pmm_purchase_order_detail ppod')->row_array();

        $output = $query['total'];
        return number_format($output,2,',','.');
    }


    function GetRealMat($material_id,$start_date=false,$end_date=false,$supplier_id=false,$purchase_order_no=false)
    {
        $output = array();

        $this->db->select('SUM(prm.volume) as total, SUM(prm.volume * prm.price) as total_price');
        $this->db->join('pmm_purchase_order ppo','prm.purchase_order_id = ppo.id','left');
        if(!empty($start_date) && !empty($end_date)){
            $this->db->where('prm.date_receipt >=',$start_date);
            $this->db->where('prm.date_receipt <=',$end_date);
        }
        if(!empty($supplier_id)){
            $this->db->where('ppo.supplier_id',$supplier_id);
        }
        if(!empty($purchase_order_no)){
            $this->db->where('prm.purchase_order_id',$purchase_order_no);
        }
        $this->db->where('prm.material_id',$material_id);
        $query = $this->db->get_where('pmm_receipt_material prm')->row_array();

        $output = $query;
        return $output;
    }




    function GetPlanningProd($product_id,$start_date=false,$end_date=false,$client_id=false)
    {
        $output = 0;


        $this->db->select('SUM(koef) as total');
        $this->db->join('pmm_schedule_product psp','pspd.schedule_product_id = psp.id','left');
        $this->db->join('pmm_schedule ps','psp.schedule_id = ps.id','left');
        if(!empty($start_date) && !empty($end_date)){
            $this->db->where('pspd.date >=',$start_date);
            $this->db->where('pspd.date <=',$end_date);
        }
        if(!empty($client_id)){
            $this->db->where('ps.client_id',$client_id);
        }
        $this->db->where('pspd.status','PUBLISH');
        $this->db->where('pspd.product_id',$product_id);
        $query = $this->db->get('pmm_schedule_product_date pspd');
        $total = $query->row_array()['total'];

        $output = $total;
        return $output;
    }

    function GetRealProd($product_id,$start_date=false,$end_date=false,$client_id=false)
    {
        $output = array();

        $this->db->select('SUM(volume) as total, SUM(price) as cost');
        if(!empty($start_date) && !empty($end_date)){
            $this->db->where('date_production >=',$start_date);
            $this->db->where('date_production <=',$end_date);
        }
        if(!empty($client_id)){
            $this->db->where('client_id',$client_id);
        }
        $this->db->where('product_id',$product_id);
        $this->db->where('status','PUBLISH');
        $query = $this->db->get_where('pmm_productions')->row_array();

        $output = $query;
        return $output;
    }

    function GetRealProdByClient($product_id,$start_date=false,$end_date=false,$client_id=false)
    {
        $output = array();

        $this->db->select('SUM(pp.volume) as total, SUM(pp.price) as cost, pc.client_name');
        $this->db->join('pmm_client pc','pp.client_id = pc.id');
        if(!empty($start_date) && !empty($end_date)){
            $this->db->where('pp.date_production >=',$start_date);
            $this->db->where('pp.date_production <=',$end_date);
        }
        if(!empty($client_id)){
            $this->db->where('pp.client_id',$client_id);
        }
        $this->db->where('pp.product_id',$product_id);
        $this->db->where('pp.status','PUBLISH');
        $query = $this->db->get_where('pmm_productions pp')->result_array();

        $output = $query;
        return $output;
    }


    function GetDashGrafProd($product_id,$month,$before=false,$arr_date=false,$client_id=false)
    {
        $output = 0;

        $num_data = 1; 

        if($arr_date){
            $ex_date = explode(' - ', $arr_date);
            $start = substr($ex_date[0],3,2);
            $end = substr($ex_date[1],3,2);

            if($start == $end){
                $num_data = 0; 
            }
        }

        $this->db->select('SUM(volume) as total');
        if(!empty($month)){

            if($before){
                $this->db->where('DATE_FORMAT(date_production,"%Y-%m") <=',$month);
            }else {
                if($num_data > 0){ 
                    $this->db->where('DATE_FORMAT(date_production,"%Y-%m")',$month);
                }else {
                    $this->db->where('date_production >=',date('Y-m-d',strtotime($ex_date[0])));
                    $this->db->where('date_production <=',date('Y-m-d',strtotime($ex_date[1]))); 
                }
                
                
            }
            
        }
        if(!empty($client_id)){
            $this->db->where('client_id',$client_id);
        }

        $this->db->where('product_id',$product_id);
        $this->db->where('status','PUBLISH');
        $query = $this->db->get_where('pmm_productions')->row_array();

        $output = $query['total'];
        return $output;
    }

    function GetDashGrafProdPlanning($product_id,$month,$arr_date=false)
    {
        $output = 0;

        $num_data = 1; 

        if($arr_date){
            $ex_date = explode(' - ', $arr_date);
            $start = substr($ex_date[0],3,2);
            $end = substr($ex_date[1],3,2);

            if($start == $end){
                $num_data = 0; 
            }
        }

        $this->db->select('SUM(koef) as total');
        if(!empty($month)){
            if($num_data > 0){ 
                $this->db->where('DATE_FORMAT(date,"%Y-%m")',$month);
            }else {
                $this->db->where('date >=',date('Y-m-d',strtotime($ex_date[0])));
                $this->db->where('date <=',date('Y-m-d',strtotime($ex_date[1]))); 
            }
        }
        $this->db->where('product_id',$product_id);
        $query = $this->db->get_where('pmm_schedule_product_date')->row_array();

        $output = $query['total'];

        return $output;
    }
    

    
    function GetDashGrafMat($material_id,$month,$arr_date=false)
    {
        $output = 0;

        $num_data = 1; 

        if($arr_date){
            $ex_date = explode(' - ', $arr_date);
            $start = substr($ex_date[0],3,2);
            $end = substr($ex_date[1],3,2);

            if($start == $end){
                $num_data = 0; 
            }
        }
        

        $this->db->select('pp.id,pp.volume,pp.date_production, pp.product_id');
        if(!empty($month)){
            if($arr_date){
                if($num_data > 0){
                    $this->db->where('DATE_FORMAT(pp.date_production,"%Y-%m")',$month); 
                }else {
                    $this->db->where('date_production >=',date('Y-m-d',strtotime($ex_date[0])));
                    $this->db->where('date_production <=',date('Y-m-d',strtotime($ex_date[1]))); 
                }
            }else {
                $this->db->where('DATE_FORMAT(pp.date_production,"%Y-%m")',$month);     
            }
           
        }
        $this->db->where('pp.status','PUBLISH');
        $query = $this->db->get_where('pmm_productions pp')->result_array();
        $total_sub = 0;
        foreach ($query as $key => $row) {
            
            $this->db->select('koef');
            $data = $this->db->get_where('pmm_production_material',array('production_id'=>$row['id'],'material_id'=>$material_id))->row_array();
            $total = $row['volume'] * $data['koef'];
            $total_sub += $total;
        }
        $output = $total_sub;
        return $output;
    }


    function GetDashGrafMatReal($material_id,$month,$arr_date=false)
    {
        $output = 0;

        $num_data = 1; 

        if($arr_date){
            $ex_date = explode(' - ', $arr_date);
            $start = substr($ex_date[0],3,2);
            $end = substr($ex_date[1],3,2);

            if($start == $end){
                $num_data = 0; 
            }
        }
        

        $this->db->select('SUM(volume) as total');
        if(!empty($month)){
            if($arr_date){
                if($num_data > 0){
                    $this->db->where('DATE_FORMAT(prm.date,"%Y-%m")',$month); 
                }else {
                    $this->db->where('prm.date >=',date('Y-m-d',strtotime($ex_date[0])));
                    $this->db->where('prm.date <=',date('Y-m-d',strtotime($ex_date[1]))); 
                }
            }else {
                $this->db->where('DATE_FORMAT(prm.date,"%Y-%m")',$month);     
            }
           
        }
        $this->db->where('prm.material_id',$material_id);
        $sisa_real = $this->db->get_where('pmm_remaining_materials prm')->row_array();


        $this->db->select('SUM(volume) as total');
        if(!empty($month)){
            if($arr_date){
                if($num_data > 0){
                    $this->db->where('DATE_FORMAT(prm.date_receipt,"%Y-%m")',$month); 
                }else {
                    $this->db->where('prm.date_receipt >=',date('Y-m-d',strtotime($ex_date[0])));
                    $this->db->where('prm.date_receipt <=',date('Y-m-d',strtotime($ex_date[1]))); 
                }
            }else {
                $this->db->where('DATE_FORMAT(prm.date_receipt,"%Y-%m")',$month);     
            }
           
        }
        $this->db->where('prm.material_id',$material_id);
        $penerimaan = $this->db->get_where('pmm_receipt_material prm')->row_array();

        $output = $penerimaan['total'] - $sisa_real['total'];
        return $output;
    }

    function GetDashGrafMatSisa($material_id,$month,$arr_date=false)
    {
        $output = 0;

        $num_data = 1; 

        if($arr_date){
            $ex_date = explode(' - ', $arr_date);
            $start = substr($ex_date[0],3,2);
            $end = substr($ex_date[1],3,2);

            if($start == $end){
                $num_data = 0; 
            }
        }
        

        $this->db->select('pp.id,pp.volume,pp.date_production, pp.product_id');
        if(!empty($month)){
            if($arr_date){
                if($num_data > 0){
                    $this->db->where('DATE_FORMAT(pp.date_production,"%Y-%m")',$month); 
                }else {
                    $this->db->where('date_production >=',date('Y-m-d',strtotime($ex_date[0])));
                    $this->db->where('date_production <=',date('Y-m-d',strtotime($ex_date[1]))); 
                }
            }else {
                $this->db->where('DATE_FORMAT(pp.date_production,"%Y-%m")',$month);     
            }
           
        }
        $this->db->where('pp.status','PUBLISH');
        $query = $this->db->get_where('pmm_productions pp')->result_array();
        $total_sub = 0;
        foreach ($query as $key => $row) {
            
            $this->db->select('koef');
            $data = $this->db->get_where('pmm_production_material',array('production_id'=>$row['id'],'material_id'=>$material_id))->row_array();
            $total = $row['volume'] * $data['koef'];
            $total_sub += $total;
        }


        $this->db->select('SUM(volume) as total');
        if(!empty($month)){
            if($arr_date){
                if($num_data > 0){
                    $this->db->where('DATE_FORMAT(prm.date_receipt,"%Y-%m")',$month); 
                }else {
                    $this->db->where('prm.date_receipt >=',date('Y-m-d',strtotime($ex_date[0])));
                    $this->db->where('prm.date_receipt <=',date('Y-m-d',strtotime($ex_date[1]))); 
                }
            }else {
                $this->db->where('DATE_FORMAT(prm.date_receipt,"%Y-%m")',$month);     
            }
           
        }
        $this->db->where('prm.material_id',$material_id);
        $penerimaan = $this->db->get_where('pmm_receipt_material prm')->row_array();


        if($material_id == 1){
            $total_sub = $total_sub / 1000;
        }

        $output = $penerimaan['total'] - $total_sub;
        return $output;
    }

    function GetDashGrafMatSisaReal($material_id,$month,$arr_date=false)
    {
        $output = 0;

        $num_data = 1; 

        if($arr_date){
            $ex_date = explode(' - ', $arr_date);
            $start = substr($ex_date[0],3,2);
            $end = substr($ex_date[1],3,2);

            if($start == $end){
                $num_data = 0; 
            }
        }
        

        $this->db->select('SUM(volume) as total');
        if(!empty($month)){
            if($arr_date){
                if($num_data > 0){
                    $this->db->where('DATE_FORMAT(prm.date,"%Y-%m")',$month); 
                }else {
                    $this->db->where('prm.date >=',date('Y-m-d',strtotime($ex_date[0])));
                    $this->db->where('prm.date <=',date('Y-m-d',strtotime($ex_date[1]))); 
                }
            }else {
                $this->db->where('DATE_FORMAT(prm.date,"%Y-%m")',$month);     
            }
           
        }
        $this->db->where('prm.material_id',$material_id);
        $sisa_real = $this->db->get_where('pmm_remaining_materials prm')->row_array();


        $output = $sisa_real['total'];
        return $output;
    }

    


    function GetReportGrafMat($material_id,$month,$before=false,$client_id=false)
    {
        $output = 0;

        $this->db->select('pp.id,pp.volume,pp.date_production, pp.product_id');
        if(!empty($month)){
            if($before){
                $this->db->where('DATE_FORMAT(pp.date_production,"%Y-%m") <=',$month);
            }else {
                $this->db->where('DATE_FORMAT(pp.date_production,"%Y-%m")',$month);    
            }
            
        }
        if(!empty($client_id)){
            $this->db->where('pp.client_id',$client_id);
        }
        $this->db->where('pp.status','PUBLISH');
        $query = $this->db->get_where('pmm_productions pp')->result_array();
        $total_sub = 0;
        foreach ($query as $key => $row) {
            
            $this->db->select('koef');
            $data = $this->db->get_where('pmm_production_material',array('production_id'=>$row['id'],'material_id'=>$material_id))->row_array();
            $total = $row['volume'] * $data['koef'];
            $total_sub += $total;
        }
        $output = $total_sub;
        return $output;
    }


    function GetReceiptMonth($material_id,$month,$before=false)
    {   
        $output = 0;

        $this->db->select('SUM(volume) as total');
        if(!empty($month)){
            if($before){
                $this->db->where('DATE_FORMAT(date_receipt,"%Y-%m") <=',$month);
            }else {
                $this->db->where('DATE_FORMAT(date_receipt,"%Y-%m")',$month);    
            }
        }
        $this->db->where('material_id',$material_id);
        $query = $this->db->get_where('pmm_receipt_material')->row_array();

        $output = $query['total'];
        return $output;
    }

    function GetSisaMonth($material_id,$month,$before=false)
    {   
        $output = 0;

        $this->db->select('SUM(volume) as total');
        if(!empty($month)){
            if($before){
                $this->db->where('DATE_FORMAT(date,"%Y-%m") <=',$month);
            }else {
                $this->db->where('DATE_FORMAT(date,"%Y-%m")',$month);    
            }
            
        }
        $this->db->where('material_id',$material_id);
        $query = $this->db->get_where('pmm_remaining_materials')->row_array();

        $output = $query['total'];
        return $output;
    }


    function GetLabaDash($month,$arr_date)
    {
        $num_data = 1; 

        if($arr_date){
            $ex_date = explode(' - ', $arr_date);
            $start = substr($ex_date[0],3,2);
            $end = substr($ex_date[1],3,2);

            if($start == $end){
                $num_data = 0; 
            }
        }
           

        $products = $this->db->get_where('pmm_product',array('status'=>'PUBLISH'))->result_array();

        $progress = 0;
        $pakai = 0;
        foreach ($products as $key => $pro) {
            $riel_price = $pro['contract_price'];
            $this->db->select('SUM(volume) as total');
            if($num_data > 0){
                $this->db->where('DATE_FORMAT(date_production,"%Y-%m")',date('Y-m',strtotime($month)));
            }else {
                $this->db->where('date_production >=',date('Y-m-d',strtotime($ex_date[0])));
                $this->db->where('date_production <=',date('Y-m-d',strtotime($ex_date[1])));
            }
            
            $this->db->where('product_id',$pro['id']);
            $this->db->where('status','PUBLISH');
            $query = $this->db->get_where('pmm_productions')->row_array();

            $progress += $riel_price * $query['total'];
        }

        $material_set = $this->GetProMatMonth();
        $datasets_mat =array();
        $label_mat = array();
        $a =0;
        foreach ($material_set as $key => $mat) {
            $data_chart_mat = array();
            $total_mat = $this->GetDashGrafMat($mat['material_id'],date('Y-m',strtotime($month)),$arr_date);
            if($mat['material_id'] == 1){
                $mat['cost'] = $mat['cost']  / 1000;
            }
            $pakai += $total_mat * $mat['cost'];
        }


        $laba = ($progress - $pakai) / 1000000;

        return $laba;
    }


    function GetAlatProd()
    {
        $output = array();

        $this->db->select('t.id,t.tool,ppd.koef');
        $this->db->join('pmm_tools t','ppd.type_id = t.id','left');
        $this->db->group_by('ppd.type_id');
        $query = $this->db->get_where('pmm_product_detail ppd',array('ppd.type'=>'ALAT','ppd.status'=>'PUBLISH'))->result_array();

        foreach ($query as $row) {
            $row['total'] = $this->GetPriceAlat($row['id']) * $row['koef'];

            $output[] = $row;
        }
        return $output;
    }
    

    function GetPriceAlat($tool_id)
    {
        $output = 0;

        $query = $this->db->select('SUM(cost) as total')->get_where('pmm_tool_detail',array('tool_id'=>$tool_id,'status'=>'PUBLISH'))->row_array();

        if(!empty($query)){
            $output = $query['total'];
        }

        return $output;
    }

    function getRevenue($month,$arr_date=false)
    {
        $num_data = 1; 

        if($arr_date){
            $ex_date = explode(' - ', $arr_date);
            $start = substr($ex_date[0],3,2);
            $end = substr($ex_date[1],3,2);

            if($start == $end){
                $num_data = 0; 
            }
        }
        $this->db->select('SUM(pp.price) as total');
        $this->db->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left');
        if($num_data > 0){
			$first_day_this_month = date('Y-m-d',strtotime($month)).'';
            $last_day_this_month  = date('Y-m-31',strtotime($month));
            $this->db->where('pp.date_production >=',$first_day_this_month);
            $this->db->where('pp.date_production <=',$last_day_this_month);
        }else {
            $this->db->where('pp.date_production >=',date('Y-m-d',strtotime($ex_date[0])));
            $this->db->where('pp.date_production <=',date('Y-m-d',strtotime($ex_date[1])));
        }
        $this->db->where("pp.product_id in (3,4,7,8,9,14,24)");
        $this->db->where('pp.status','PUBLISH');
        $this->db->where("ppo.status in ('OPEN','CLOSED')");
        $query = $this->db->get_where('pmm_productions pp')->row_array();

        return $query['total'];
    }

    function getRevenueStok($month,$arr_date=false)
    {
        $num_data = 1; 

        if($arr_date){
            $ex_date = explode(' - ', $arr_date);
            $start = substr($ex_date[0],3,2);
            $end = substr($ex_date[1],3,2);

            if($start == $end){
                $num_data = 0; 
            }
        }

        $this->db->select('(pp.total_nilai_akhir) as total');
        $this->db->order_by('pp.date_akumulasi','desc')->limit(1);
        if($num_data > 0){
			$first_day_this_month = date('Y-m-d',strtotime($month)).'';
            $last_day_this_month  = date('Y-m-31',strtotime($month));
            $this->db->where('pp.date_akumulasi >=',$first_day_this_month);
            $this->db->where('pp.date_akumulasi <=',$last_day_this_month);
        }else {
            $this->db->where('pp.date_akumulasi >=',date('Y-m-d',strtotime($ex_date[0])));
            $this->db->where('pp.date_akumulasi <=',date('Y-m-d',strtotime($ex_date[1])));
        }
        $nilai_persediaan_bahan_baku = $this->db->get_where('akumulasi_bahan_baku pp')->row_array();

        $this->db->select('(pp.total_nilai_akhir) as total');
        $this->db->order_by('pp.date_akumulasi','desc')->limit(1);
        if($num_data > 0){
			$first_day_this_month = date('Y-m-d',strtotime($month)).'';
            $last_day_this_month  = date('Y-m-31',strtotime($month));
            $this->db->where('pp.date_akumulasi >=',$first_day_this_month);
            $this->db->where('pp.date_akumulasi <=',$last_day_this_month);
        }else {
            $this->db->where('pp.date_akumulasi >=',date('Y-m-d',strtotime($ex_date[0])));
            $this->db->where('pp.date_akumulasi <=',date('Y-m-d',strtotime($ex_date[1])));
        }
        $nilai_persediaan_barang_jadi = $this->db->get_where('akumulasi pp')->row_array();

        return $nilai_persediaan_bahan_baku['total'] + $nilai_persediaan_barang_jadi['total'];
    }


    function getRevenueAll($arr_date=false,$before=false)
    {
        $output = array('total'=>0); 

        if(!empty($arr_date)){
            $ex_date = explode(' - ', $arr_date);
            $start_date = date('Y-m-d',strtotime($ex_date[0]));
            $end_date = date('Y-m-d',strtotime($ex_date[1]));

            // Get Last Opname
            $last_production = $this->db->select('date')->order_by('date','desc')->limit(1)->get_where('pmm_remaining_materials_cat',array('status'=>'PUBLISH','date <='=>$end_date))->row_array();
            if(!empty($last_production)){
                $last_opname = $last_production['date'];
            }
        }else {
            $last_production = $this->db->select('date')->order_by('date','desc')->limit(1)->get_where('pmm_remaining_materials_cat',array('status'=>'PUBLISH'))->row_array();
            if(!empty($last_production)){
                $last_opname = $last_production['date'];
            }
        }

        if(!empty($last_opname)){
            $this->db->select('SUM(pp.price) as total, SUM(pp.volume) as volume');
            $this->db->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left');
            if(!empty($arr_date)){
                $ex_date = explode(' - ', $arr_date);
                
                if($before){
                    $this->db->where('pp.date_production <',$start_date);
                }else {
                    $this->db->where('pp.date_production >=',$start_date);
                    $this->db->where('pp.date_production <=',$last_opname);  
                }
                
            }else {
                
                $this->db->where('pp.date_production <=',$last_opname);
            }
            $this->db->where("pp.product_id in (3,4,7,8,9,14,24)");
            $this->db->where('pp.status','PUBLISH');
            $this->db->where("ppo.status in ('OPEN','CLOSED')");
            $query = $this->db->get_where('pmm_productions pp')->row_array();

            $output = $query;
        }
        
        return $output;
    }
    
    function getOverhead($month=false,$arr_date=false)
    {
        $total = 0;
        $num_data = 1; 

        if($arr_date){
            $ex_date = explode(' - ', $arr_date);
            $start = substr($ex_date[0],3,2);
            $end = substr($ex_date[1],3,2);

            if($start == $end){
                $num_data = 0; 
            }
        }
        $this->db->select('SUM(cost) as total');
        if($num_data > 0){
            $this->db->where('DATE_FORMAT(date,"%Y-%m")',date('Y-m',strtotime($month)));
        }else {
            $this->db->where('date >=',date('Y-m-d',strtotime($ex_date[0])));
            $this->db->where('date <=',date('Y-m-d',strtotime($ex_date[1])));
        }
        $this->db->where('status','PUBLISH');
        $query = $this->db->get_where('pmm_general_cost')->row_array();
        if(!empty($query)){
            $total = $query['total'];
        }
        return $total;
    }

    function getOverhead2($arr_date=false)
    {
        
        if(!empty($arr_date)){
            $ex_date = explode(' - ', $arr_date);
            $start_date = date('Y-m-d',strtotime($ex_date[0]));
            $end_date = date('Y-m-d',strtotime($ex_date[1]));
            $last_production = $this->db->select('date')->order_by('date','desc')->limit(1)->get_where('pmm_remaining_materials_cat',array('status'=>'PUBLISH','date <='=>$end_date))->row_array();
            if(!empty($last_production)){
                $last_opname = $last_production['date'];
            }
        }else {
            $last_production = $this->db->select('date')->order_by('date','desc')->limit(1)->get_where('pmm_remaining_materials_cat',array('status'=>'PUBLISH'))->row_array();
            if(!empty($last_production)){
                $last_opname = $last_production['date'];
            }
            
        }

        $total = 0;
        if(!empty($last_opname)){
            $this->db->select('SUM(cost) as total');
            if($arr_date){
                $ex_date = explode(' - ', $arr_date);
                $this->db->where('date >=',$start_date);
                $this->db->where('date <=',$last_opname);
            }else {
                $this->db->where('date <=',$last_opname);
            }
            $this->db->where('status','PUBLISH');
            $query = $this->db->get_where('pmm_general_cost')->row_array();
            if(!empty($query)){
                $total = $query['total'];
            }
        }
        

        return $total;
    }

    function getProgressReal($id,$month,$arr_date=false)
    {
         $num_data = 1; 

        if($arr_date){
            $ex_date = explode(' - ', $arr_date);
            $start = substr($ex_date[0],3,2);
            $end = substr($ex_date[1],3,2);

            if($start == $end){
                $num_data = 0; 
            }
        }
        $this->db->select('SUM(price) as total, p.nama');
		$this->db->join('penerima p','pp.client_id = p.id','left');
        if($num_data > 0){
            $this->db->where('DATE_FORMAT(date_production,"%Y-%m")',date('Y-m',strtotime($month)));
 
        }else {
            $this->db->where('date_production >=',date('Y-m-d',strtotime($ex_date[0])));
            $this->db->where('date_production <=',date('Y-m-d',strtotime($ex_date[1])));
        }
        $this->db->where('p.id = 585' );
        $this->db->where('pp.status','PUBLISH');
        $query = $this->db->get_where('pmm_productions pp')->row_array();

        return
		$query['total'];
    }

    function getProgressRealAll($client_id,$arr_date=false)
    {
         $num_data = 1; 

        $this->db->select('SUM(price) as total, p.nama');
		$this->db->join('penerima p','pp.client_id = p.id','left');
        if($arr_date){
            $ex_date = explode(' - ', $arr_date);
            $this->db->where('date_production >=',date('Y-m-d',strtotime($ex_date[0])));
            $this->db->where('date_production <=',date('Y-m-d',strtotime($ex_date[1])));
        }
        $this->db->where('pp.client_id = 585');
        $this->db->where('pp.status','PUBLISH');
        $query = $this->db->get_where('pmm_productions pp')->row_array();

        return $query['total'];

    }

    function getProgressContract($client_id)
    {
        $this->db->select('SUM(contract) as total');
        $this->db->where('id',$client_id);
        $this->db->where('status','PUBLISH');
        $query = $this->db->get_where('pmm_client')->row_array();

        return $query['total'];
    }

    function getRevenueClient($client_id=false,$arr_date=false)
    {

        if(!empty($arr_date)){
            $ex_date = explode(' - ', $arr_date);
            $start_date = date('Y-m-d',strtotime($ex_date[0]));
            $end_date = date('Y-m-d',strtotime($ex_date[1]));

            // Get Last Opname
            $last_production = $this->db->select('date')->order_by('date','desc')->limit(1)->get_where('pmm_remaining_materials_cat',array('status'=>'PUBLISH','date <='=>$end_date))->row_array();
            $last_opname = $last_production['date'];
        }else {
            $last_production = $this->db->select('date')->order_by('date','desc')->limit(1)->get_where('pmm_remaining_materials_cat',array('status'=>'PUBLISH'))->row_array();
            if(!empty($last_production)){
                $last_opname = $last_production['date'];
            }
            
        }

        $total = 0;
        if(!empty($last_production)){
            $this->db->select('SUM(price) as total');
            if(!empty($arr_date)){
                $ex_date = explode(' - ', $arr_date);
                $this->db->where('date_production >=',$start_date);
                $this->db->where('date_production <=',$last_opname);
            }else {
                $this->db->where('date_production <=',$last_opname);
            }
            $this->db->where('status','PUBLISH');
            if($client_id){
                $this->db->where('client_id',$client_id);
            }
            
            
            $query = $this->db->get_where('pmm_productions')->row_array();
            if(!empty($query)){
                $total = $query['total'];
            }
        }
        
        return $total;
    }

    function getRevenueClient2($client_id=false,$arr_date=false)
    {

        $this->db->select('SUM(price) as total, SUM(volume) as volume');
        if($arr_date){
            $ex_date = explode(' - ', $arr_date);
            $this->db->where('date_production >=',date('Y-m-d',strtotime($ex_date[0])));
            $this->db->where('date_production <=',date('Y-m-d',strtotime($ex_date[1])));
        }
        $this->db->where('status','PUBLISH');
        if($client_id){
            $this->db->where('client_id',$client_id);
        }
        
        $query = $this->db->get_where('pmm_productions')->row_array();

        return $query;
    }

    function getCostDB($id=false,$arr_date=false)
    {
        $this->load->model('pmm_reports');
        $output = 0;

        
        if(!empty($arr_date)){
            $total_material = $this->pmm_reports->MaterialUsageAllDate($arr_date); 
        }else {
            $total_material = $this->pmm_reports->MaterialUsageAll($arr_date);  
        }
        $total_equipment = $this->getEquipmentCost($arr_date);


        $total_overhead = $this->getOverhead2($arr_date);

        if($id == 0){
            $output = $total_material;
        }else if($id == 1){
            $output = $total_equipment;
        }else if($id == 2){
            $output = $total_overhead;
        }else {
            $output = $total_material + $total_equipment + $total_overhead;
        }

        return $output;
    }

    function getMaterialsCost($arr_date)
    {
        $this->db->select('SUM(pp.volume * ppm.koef * ppm.price) as total');
        $this->db->join('pmm_production_material ppm','pp.id = ppm.production_id');
        if($arr_date){
            $ex_date = explode(' - ', $arr_date);
            $this->db->where('date_production >=',date('Y-m-d',strtotime($ex_date[0])));
            $this->db->where('date_production <=',date('Y-m-d',strtotime($ex_date[1])));
        }
        $this->db->where('status','PUBLISH');
        $query = $this->db->get_where('pmm_productions pp')->row_array();

        $total_sub = $query['total'];
        return $total_sub;
    }

    function getEquipmentCost($arr_date=false)
    {
        
        $total = 0; 

        if(!empty($arr_date)){
            $ex_date = explode(' - ', $arr_date);
            $start_date = date('Y-m-d',strtotime($ex_date[0]));
            $end_date = date('Y-m-d',strtotime($ex_date[1]));
            $last_production = $this->db->select('date')->order_by('date','desc')->limit(1)->get_where('pmm_remaining_materials_cat',array('status'=>'PUBLISH','date <='=>$end_date))->row_array();
            if(!empty($last_production)){
                $last_opname = $last_production['date'];
            }
        }else {
            $last_production = $this->db->select('date')->order_by('date','desc')->limit(1)->get_where('pmm_remaining_materials_cat',array('status'=>'PUBLISH'))->row_array();

            if(!empty($last_production)){
                $last_opname = $last_production['date'];
            }
            
        }

        if(!empty($last_opname)){
            $this->db->select('SUM(total) as total');
            if($arr_date){
                
                $this->db->where('date >=',$start_date);
                $this->db->where('date <=',$last_opname);
            }else {
                $this->db->where('date <=',$last_opname);  
            }
            $query = $this->db->get('pmm_equipments_data')->row_array();

            $total = $query['total'];
        }
        
        return $total;

    }

    function MaterialConvert($material_id,$measure_from)
    {
        $output = false;

        $measure = $this->db->select('measure')->get_where('pmm_materials',array('id'=>$material_id,'status'=>'PUBLISH'))->row_array()['measure'];

        if(is_string($measure_from)){
           $measure_from = $this->crud_global->GetField('pmm_measures',array('measure_name'=>$measure_from),'id'); 
        }

        $query = $this->db->select('value')->get_where('pmm_measure_convert',array('measure_id'=>$measure,'measure_to'=>$measure_from))->row_array();
        if(!empty($query)){
            $output = $query['value'];
        }

        return $output;

    }

    function getMatByPenawaran($id)
    {

        $this->db->select('pm.nama_produk as material_name, ppd.measure,ppd.material_id, ppd.id, pms.measure_name, price, nomor_penawaran, pp.id, ppd.tax_id, ppd.tax, ppd.pajak_id, ppd.pajak');
        $this->db->join('pmm_penawaran_pembelian pp','ppd.penawaran_pembelian_id = pp.id','left');
        $this->db->join('produk pm','ppd.material_id = pm.id','left');
        $this->db->join('pmm_measures pms','ppd.measure = pms.id','left');
        $this->db->where('pp.supplier_id',$id);
        $this->db->where('pp.status','OPEN');
		$this->db->order_by('pp.created_on','DESC');
        $data = $this->db->get('pmm_penawaran_pembelian_detail ppd')->result_array();

        return $data;
    }
	
	function getJMD($id)
    {

        $this->db->select('jmd.semen_2 as material_name, jmd.measure,ppd.product_id, ppd.id, pms.measure_name, price, nomor');
        $this->db->join('pmm_penawaran_penjualan pp','ppd.penawaran_penjualan_id = pp.id','left');
        $this->db->join('produk pm','ppd.product_id = pm.id','left');
        $this->db->join('pmm_measures pms','ppd.measure = pms.id','left');
        $this->db->where('jmd.status','PUBLISH');
		$this->db->order_by('jmd.id','DES');
        $data = $this->db->get('pmm_jmd jmd')->result_array();

        return $data;
    }

    function getMatByPenawaranRencanaKerjaAll()
    {

        $this->db->select('ppd.penawaran_pembelian_id as penawaran, ppd.id as penawaran_id, p.nama as nama, pp.supplier_id as supplier_id, pp.jenis_pembelian, pm.nama_produk as material_name, ppd.measure,ppd.material_id, ppd.id, pms.measure_name, ppd.price, pp.nomor_penawaran, pp.id, ppd.tax_id, ppd.tax, ppd.pajak_id, ppd.pajak');
        $this->db->join('pmm_penawaran_pembelian pp','ppd.penawaran_pembelian_id = pp.id','left');
        $this->db->join('produk pm','ppd.material_id = pm.id','left');
        $this->db->join('penerima p','pp.supplier_id = p.id','left');
        $this->db->join('pmm_measures pms','ppd.measure = pms.id','left');
        $this->db->where('pp.status','OPEN');
        $this->db->group_by('ppd.id');
		$this->db->order_by('p.nama','asc');
        $this->db->order_by('ppd.penawaran_pembelian_id','desc');
        $data = $this->db->get('pmm_penawaran_pembelian_detail ppd')->result_array();

        return $data;
    }

    function getMatByPenawaranRencanaKerjaBoulder()
    {

        $this->db->select('pp.id as penawaran_id, p.nama as nama, pp.supplier_id as supplier_id, pp.jenis_pembelian, pm.nama_produk as material_name, ppd.measure,ppd.material_id, ppd.id, pms.measure_name, ppd.price, pp.nomor_penawaran, pp.id, ppd.tax_id, ppd.tax, ppd.pajak_id, ppd.pajak');
        $this->db->join('pmm_penawaran_pembelian pp','ppd.penawaran_pembelian_id = pp.id','left');
        $this->db->join('produk pm','ppd.material_id = pm.id','left');
        $this->db->join('penerima p','pp.supplier_id = p.id','left');
        $this->db->join('pmm_measures pms','ppd.measure = pms.id','left');
        //$this->db->where("pm.kategori_bahan = '1' ");
        $this->db->where('pp.status','OPEN');
        $this->db->group_by('ppd.penawaran_pembelian_id');
		$this->db->order_by('p.nama','asc');
        $data = $this->db->get('pmm_penawaran_pembelian_detail ppd')->result_array();

        return $data;
    }

    function getMatByPenawaranRencanaKerjaSolar()
    {

        $this->db->select('pp.id as penawaran_id, p.nama as nama, pp.supplier_id as supplier_id, pp.jenis_pembelian, pm.nama_produk as material_name, ppd.measure,ppd.material_id, ppd.id, pms.measure_name, ppd.price, pp.nomor_penawaran, pp.id, ppd.tax_id, ppd.tax, ppd.pajak_id, ppd.pajak');
        $this->db->join('pmm_penawaran_pembelian pp','ppd.penawaran_pembelian_id = pp.id','left');
        $this->db->join('produk pm','ppd.material_id = pm.id','left');
        $this->db->join('penerima p','pp.supplier_id = p.id','left');
        $this->db->join('pmm_measures pms','ppd.measure = pms.id','left');
        //$this->db->where("pm.kategori_bahan = '5' ");
        $this->db->where('pp.status','OPEN');
        $this->db->group_by('ppd.penawaran_pembelian_id');
		$this->db->order_by('p.nama','asc');
        $data = $this->db->get('pmm_penawaran_pembelian_detail ppd')->result_array();

        return $data;
    }

    function getMatByPenawaranRencanaKerjaTransferSemen()
    {

        $this->db->select('pp.id as penawaran_id, p.nama as nama, pp.supplier_id as supplier_id, pp.jenis_pembelian, pm.nama_produk as material_name, ppd.measure,ppd.material_id, ppd.id, pms.measure_name, ppd.price, pp.nomor_penawaran, pp.id, ppd.tax_id, ppd.tax, ppd.pajak_id, ppd.pajak');
        $this->db->join('pmm_penawaran_pembelian pp','ppd.penawaran_pembelian_id = pp.id','left');
        $this->db->join('produk pm','ppd.material_id = pm.id','left');
        $this->db->join('penerima p','pp.supplier_id = p.id','left');
        $this->db->join('pmm_measures pms','ppd.measure = pms.id','left');
        //$this->db->where("pm.kategori_alat = '4' ");
        $this->db->where('pp.status','OPEN');
        $this->db->group_by('ppd.penawaran_pembelian_id');
		$this->db->order_by('p.nama','asc');
        $data = $this->db->get('pmm_penawaran_pembelian_detail ppd')->result_array();

        return $data;
    }

    function getMatByPenawaranRencanaKerjaTangki()
    {

        $this->db->select('pp.id as penawaran_id, p.nama as nama, pp.supplier_id as supplier_id, pp.jenis_pembelian, pm.nama_produk as material_name, ppd.measure,ppd.material_id, ppd.id, pms.measure_name, ppd.price, pp.nomor_penawaran, pp.id, ppd.tax_id, ppd.tax, ppd.pajak_id, ppd.pajak');
        $this->db->join('pmm_penawaran_pembelian pp','ppd.penawaran_pembelian_id = pp.id','left');
        $this->db->join('produk pm','ppd.material_id = pm.id','left');
        $this->db->join('penerima p','pp.supplier_id = p.id','left');
        $this->db->join('pmm_measures pms','ppd.measure = pms.id','left');
        //$this->db->where("pm.kategori_alat = '1' ");
        $this->db->where('pp.status','OPEN');
        $this->db->group_by('ppd.penawaran_pembelian_id');
		$this->db->order_by('p.nama','asc');
        $data = $this->db->get('pmm_penawaran_pembelian_detail ppd')->result_array();

        return $data;
    }

    function getMatByPenawaranRencanaKerjaSC()
    {

        $this->db->select('pp.id as penawaran_id, p.nama as nama, pp.supplier_id as supplier_id, pp.jenis_pembelian, pm.nama_produk as material_name, ppd.measure,ppd.material_id, ppd.id, pms.measure_name, ppd.price, pp.nomor_penawaran, pp.id, ppd.tax_id, ppd.tax, ppd.pajak_id, ppd.pajak');
        $this->db->join('pmm_penawaran_pembelian pp','ppd.penawaran_pembelian_id = pp.id','left');
        $this->db->join('produk pm','ppd.material_id = pm.id','left');
        $this->db->join('penerima p','pp.supplier_id = p.id','left');
        $this->db->join('pmm_measures pms','ppd.measure = pms.id','left');
        //$this->db->where("pm.kategori_alat = '1' ");
        $this->db->where('pp.status','OPEN');
        $this->db->group_by('ppd.penawaran_pembelian_id');
		$this->db->order_by('p.nama','asc');
        $data = $this->db->get('pmm_penawaran_pembelian_detail ppd')->result_array();

        return $data;
    }

    function getMatByPenawaranRencanaKerjaGNS()
    {

        $this->db->select('pp.id as penawaran_id, p.nama as nama, pp.supplier_id as supplier_id, pp.jenis_pembelian, pm.nama_produk as material_name, ppd.measure,ppd.material_id, ppd.id, pms.measure_name, ppd.price, pp.nomor_penawaran, pp.id, ppd.tax_id, ppd.tax, ppd.pajak_id, ppd.pajak');
        $this->db->join('pmm_penawaran_pembelian pp','ppd.penawaran_pembelian_id = pp.id','left');
        $this->db->join('produk pm','ppd.material_id = pm.id','left');
        $this->db->join('penerima p','pp.supplier_id = p.id','left');
        $this->db->join('pmm_measures pms','ppd.measure = pms.id','left');
        //$this->db->where("pm.kategori_alat = '1' ");
        $this->db->where('pp.status','OPEN');
        $this->db->group_by('ppd.penawaran_pembelian_id');
		$this->db->order_by('p.nama','asc');
        $data = $this->db->get('pmm_penawaran_pembelian_detail ppd')->result_array();

        return $data;
    }

    function getMatByPenawaranRencanaKerjaWL()
    {

        $this->db->select('pp.id as penawaran_id, p.nama as nama, pp.supplier_id as supplier_id, pp.jenis_pembelian, pm.nama_produk as material_name, ppd.measure,ppd.material_id, ppd.id, pms.measure_name, ppd.price, pp.nomor_penawaran, pp.id, ppd.tax_id, ppd.tax, ppd.pajak_id, ppd.pajak');
        $this->db->join('pmm_penawaran_pembelian pp','ppd.penawaran_pembelian_id = pp.id','left');
        $this->db->join('produk pm','ppd.material_id = pm.id','left');
        $this->db->join('penerima p','pp.supplier_id = p.id','left');
        $this->db->join('pmm_measures pms','ppd.measure = pms.id','left');
        //$this->db->where("pm.kategori_alat = '1' ");
        $this->db->where('pp.status','OPEN');
        $this->db->group_by('ppd.penawaran_pembelian_id');
		$this->db->order_by('p.nama','asc');
        $data = $this->db->get('pmm_penawaran_pembelian_detail ppd')->result_array();

        return $data;
    }

    function getMatByPenawaranRencanaKerjaTMB()
    {

        $this->db->select('pp.id as penawaran_id, p.nama as nama, pp.supplier_id as supplier_id, pp.jenis_pembelian, pm.nama_produk as material_name, ppd.measure,ppd.material_id, ppd.id, pms.measure_name, ppd.price, pp.nomor_penawaran, pp.id, ppd.tax_id, ppd.tax, ppd.pajak_id, ppd.pajak');
        $this->db->join('pmm_penawaran_pembelian pp','ppd.penawaran_pembelian_id = pp.id','left');
        $this->db->join('produk pm','ppd.material_id = pm.id','left');
        $this->db->join('penerima p','pp.supplier_id = p.id','left');
        $this->db->join('pmm_measures pms','ppd.measure = pms.id','left');
        //$this->db->where("pm.kategori_alat = '1' ");
        $this->db->where('pp.status','OPEN');
        $this->db->group_by('ppd.penawaran_pembelian_id');
		$this->db->order_by('p.nama','asc');
        $data = $this->db->get('pmm_penawaran_pembelian_detail ppd')->result_array();

        return $data;
    }
	
	function getMatByPenawaranPenjualan($id)
    {

        $this->db->select('pp.id as penawaran_id, pp.nomor, ppd.id, ppd.product_id as product_id, pm.nama_produk as nama_produk, pms.measure_name as satuan, ppd.price as harga, ppd.tax_id as tax');
        $this->db->join('pmm_penawaran_penjualan pp','ppd.penawaran_penjualan_id = pp.id','left');
        $this->db->join('produk pm','ppd.product_id = pm.id','left');
        $this->db->join('pmm_measures pms','ppd.measure = pms.id','left');
		$this->db->join('pmm_taxs pt','ppd.tax_id = pt.id','left');
        $this->db->where('pp.status','OPEN');
		$this->db->group_by('ppd.id');
		$this->db->order_by('pp.created_on','DESC');
        $data = $this->db->get('pmm_penawaran_penjualan_detail ppd')->result_array();

        return $data;
    }
	
    function getOneCostMatByPenawaran($supplier_id,$material_id)
    {
        $this->db->select('ppd.price as cost');
        $this->db->join('pmm_penawaran_pembelian pp','ppd.penawaran_pembelian_id = pp.id','left');
        $this->db->where('pp.supplier_id',$supplier_id);
        $this->db->where('ppd.material_id',$material_id);
        $this->db->where('pp.status','OPEN');
        $data = $this->db->get('pmm_penawaran_pembelian_detail ppd')->row_array();

        return $data;
    }

    function GetNameGroup($id)
    {
        $output = array();

        $this->db->select('g.admin_group_name, a.admin_name');
        $this->db->join('tbl_admin a','g.admin_group_id = a.admin_group_id','left');
        $this->db->where('g.admin_group_id',$id);
        $this->db->where('a.status',1);
        $this->db->group_by('g.admin_group_id');
        $query = $this->db->get('tbl_admin_group g');
        $output = $query->row_array();
        return $output;
    }
	
	function getPenerima($id=false,$row=false)
    {
        $output = false;

        if($id){
            $this->db->where('id',$id);
        }
        $this->db->where('status','PUBLISH');
        $query = $this->db->get('penerima');
		
        if($query->num_rows() > 0){
            if($row){
                $output = $query->row_array();
            }else {
                $output = $query->result_array();    
            }
            
        }
        return $output;
    }

    function TableMainBiaya($id)
    {
        $data = array();
        $this->db->select('b.*, c.coa as bayar_dari, p.nama, lk.lampiran');
        $this->db->join('penerima p','b.penerima = p.id','left');
        $this->db->join('pmm_coa c','b.bayar_dari = c.id','left');
        $this->db->join('pmm_lampiran_biaya lk','b.id = lk.biaya_id','left');	
        $this->db->where('b.id',$id);
        $this->db->order_by('b.id','asc');
        $query = $this->db->get('pmm_biaya b');
	
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
                $row['bayar_dari'] = $row['bayar_dari'];
                $row['nomor_transaksi']= $row['nomor_transaksi'];
                $row['tanggal_transaksi']= date('d F Y',strtotime($row['tanggal_transaksi']));
				$row['total']= number_format($row['total'],0,',','.');
                $row['memo']= $row['memo'];
                $row['lampiran'] = "<a href=" . base_url('uploads/biaya/' . $row["lampiran"]) . ">" . $row["lampiran"] . "</a>";  
                $row['actions'] = '<a href="javascript:void(0);" onclick="OpenFormMain('.$row['id'].')" class="btn btn-success" style="font-weight:bold; border-radius:10px;">Update Biaya </a>';
                
                $data[] = $row;
            }

        }
        
        return $data;   
    }

    function TableDetailBiaya($id)
    {
        $data = array();
        $this->db->select('pdb.*, c.coa as akun');
        $this->db->join('pmm_coa c','pdb.akun = c.id','left');
        $this->db->where('pdb.biaya_id',$id);
        $this->db->order_by('pdb.id','asc');
        $query = $this->db->get('pmm_detail_biaya pdb');
	
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
                $row['akun'] = $row['akun'];
                $row['deskripsi']= $row['deskripsi'];
				$row['jumlah']= number_format($row['jumlah'],0,',','.');
                $row['actions'] = '<a href="javascript:void(0);" onclick="DeleteData('.$row['id'].')" class="btn btn-danger" style="font-weight:bold; border-radius:10px;"><i class="fa fa-close"></i> </a> <a href="javascript:void(0);" onclick="OpenForm('.$row['id'].')" class="btn btn-primary" style="font-weight:bold; border-radius:10px;"><i class="fa fa-edit"></i> </a>';
                
                $data[] = $row;
            }

        }
        
        return $data;   
    }

    function GetNoEditBiaya()
    {

        $code_prefix = $this->db->get_where('pmm_setting_production')->row_array();
        $output = false;

        $query = $this->db->select('id')->order_by('id','desc')->get('transactions');
        if($query->num_rows() > 0){
            $id = $query->row_array()['id'] + 1;
        }else {
            $id = 1;
        }
        $output = sprintf($id);
        return $output;
            
    }

    function TableMainJurnal($id)
    {
        $data = array();
        $this->db->select('b.*, lk.lampiran');
        $this->db->join('pmm_lampiran_jurnal lk','b.id = lk.jurnal_id','left');	
        $this->db->where('b.id',$id);
        $this->db->order_by('b.id','asc');
        $query = $this->db->get('pmm_jurnal_umum b');
	
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
                $row['nomor_transaksi']= $row['nomor_transaksi'];
                $row['tanggal_transaksi']= date('d F Y',strtotime($row['tanggal_transaksi']));
				$row['total']= number_format($row['total'],0,',','.');
                $row['total_debit']= number_format($row['total_debit'],0,',','.');
                $row['total_kredit']= number_format($row['total_kredit'],0,',','.');
                $row['memo']= $row['memo'];
                $row['lampiran'] = "<a href=" . base_url('uploads/jurnal_umum/' . $row["lampiran"]) . ">" . $row["lampiran"] . "</a>";  
                $row['actions'] = '<a href="javascript:void(0);" onclick="OpenFormMain('.$row['id'].')" class="btn btn-success" style="font-weight:bold; border-radius:10px;">Update Jurnal Umum </a>';
                
                $data[] = $row;
            }

        }
        
        return $data;   
    }

    function TableDetailJurnal($id)
    {
        $data = array();
        $this->db->select('pdb.*, c.coa as akun');
        $this->db->join('pmm_coa c','pdb.akun = c.id','left');
        $this->db->where('pdb.jurnal_id',$id);
        $this->db->order_by('pdb.id','asc');
        $query = $this->db->get('pmm_detail_jurnal pdb');
        
	
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
                $row['akun'] = $row['akun'];
                $row['deskripsi']= $row['deskripsi'];
				$row['debit']= number_format($row['debit'],0,',','.');
                $row['kredit']= number_format($row['kredit'],0,',','.');
                $row['actions'] = '<a href="javascript:void(0);" onclick="DeleteData('.$row['id'].')" class="btn btn-danger" style="font-weight:bold; border-radius:10px;"><i class="fa fa-close"></i> </a> <a href="javascript:void(0);" onclick="OpenForm('.$row['id'].')" class="btn btn-primary" style="font-weight:bold; border-radius:10px;"><i class="fa fa-edit"></i> </a>';
                
                $data[] = $row;
            }

        }
        
        return $data;   
    }


    function TableMainTagihan($id)
    {
        $data = array();
        $this->db->select('ppp.*');
        $this->db->where('ppp.id',$id);
        $this->db->order_by('ppp.id','asc');
        $query = $this->db->get('pmm_penagihan_pembelian ppp');
	
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
                $row['nama']= $this->crud_global->GetField('penerima',array('id'=>$row['supplier_id']),'nama');
                $row['tanggal_invoice'] = date('d F Y',strtotime($row['tanggal_invoice']));
                $row['nomor_invoice']= $row['nomor_invoice'];
                $row['actions'] = '<a href="javascript:void(0);" onclick="OpenFormMain('.$row['id'].')" class="btn btn-success" style="font-weight:bold; border-radius:10px;">Update Tagihan </a>';
                
                $data[] = $row;
            }

        }
        
        return $data;   
    }

    function TableMainTagihanPenjualan($id)
    {
        $data = array();
        $this->db->select('ppp.*');
        $this->db->where('ppp.id',$id);
        $this->db->order_by('ppp.id','asc');
        $query = $this->db->get('pmm_penagihan_penjualan ppp');
	
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
                $row['nama']= $this->crud_global->GetField('penerima',array('id'=>$row['client_id']),'nama');
                $row['tanggal_invoice'] = date('d F Y',strtotime($row['tanggal_invoice']));
                $row['nomor_invoice']= $row['nomor_invoice'];
                $row['actions'] = '<a href="javascript:void(0);" onclick="OpenFormMain('.$row['id'].')" class="btn btn-success" style="font-weight:bold; border-radius:10px;">Update Tagihan </a>';
                
                $data[] = $row;
            }

        }
        
        return $data;   
    }

    //RUMUS BARU//

    function GetPenerimaanPembelian($supplier_id=false,$purchase_order_no=false,$start_date=false,$end_date=false,$filter_material=false,$filter_kategori=false)
    {
        $output = array();

        $this->db->select('ppo.supplier_id, prm.purchase_order_id, prm.display_measure as measure,p.nama_produk,prm.material_id,SUM(prm.display_price) / SUM(prm.display_volume) as price,SUM(prm.display_volume) as volume, SUM(prm.display_price) as total_price');
        $this->db->join('produk p','prm.material_id = p.id','left');
        $this->db->join('pmm_purchase_order ppo','prm.purchase_order_id = ppo.id','left');
        if(!empty($start_date) && !empty($end_date)){
            $this->db->where('prm.date_receipt >=',$start_date);
            $this->db->where('prm.date_receipt <=',$end_date);
        }
        if(!empty($supplier_id)){
            $this->db->where('ppo.supplier_id',$supplier_id);
        }
        if(!empty($purchase_order_no)){
            $this->db->where('ppo.id',$purchase_order_no);
        }
        if(!empty($filter_material)){
            $this->db->where_in('prm.material_id',$filter_material);
        }
        if(!empty($filter_kategori)){
            $this->db->where_in('ppo.kategori_id',$filter_kategori);
        }
		$this->db->where("ppo.status in ('PUBLISH','CLOSED')");
        $this->db->order_by('p.nama_produk','asc');
        $this->db->group_by('prm.material_id');
        $query = $this->db->get('pmm_receipt_material prm');
        $output = $query->result_array();
		
        return $output;
    }
	
	function GetPenerimaanPembelianPrint($supplier_id=false,$purchase_order_no=false,$start_date=false,$end_date=false,$filter_material=false,$filter_kategori=false)
    {
        $output = array();

        $this->db->select('prm.purchase_order_id, prm.display_measure as measure,p.nama_produk,prm.material_id,SUM(prm.display_price) / SUM(prm.display_volume) as price,SUM(prm.display_volume) as volume, SUM(prm.display_price) as total_price');
        $this->db->join('produk p','prm.material_id = p.id','left');
        $this->db->join('pmm_purchase_order ppo','prm.purchase_order_id = ppo.id','left');
        if(!empty($start_date) && !empty($end_date)){
            $this->db->where('prm.date_receipt >=',$start_date);
            $this->db->where('prm.date_receipt <=',$end_date);
        }
        if(!empty($supplier_id)){
            $this->db->where('ppo.supplier_id',$supplier_id);
        }
        if(!empty($purchase_order_no)){
            $this->db->where('ppo.id',$purchase_order_no);
        }
        if(!empty($filter_material)){
            $this->db->where_in('prm.material_id',$filter_material);
        }
        if(!empty($filter_kategori)){
            $this->db->where_in('ppo.kategori_id',$filter_kategori);
        }
		$this->db->where("ppo.status in ('PUBLISH','CLOSED')");
        $this->db->order_by('p.nama_produk','asc');
        $this->db->group_by('prm.material_id');
        $query = $this->db->get('pmm_receipt_material prm');
        $output = $query->result_array();
		
        return $output;
    }

    function GetLaporanHutang($supplier_id=false,$start_date=false,$end_date=false,$filter_kategori=false)
    {
        $output = array();

        $this->db->select('prm.purchase_order_id, p.nama_produk, SUM(prm.display_price) as penerimaan,
        (
            select SUM(ppd.total) 
            from pmm_penagihan_pembelian_detail ppd 
            inner join pmm_penagihan_pembelian ppp 
            on ppd.penagihan_pembelian_id = ppp.id 
            where ppp.purchase_order_id = prm.purchase_order_id
            and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'"
		) as tagihan,
        SUM(prm.display_price) -
        (
            select  COALESCE(SUM(ppd.total),0) 
            from pmm_penagihan_pembelian_detail ppd 
            inner join pmm_penagihan_pembelian ppp 
            on ppd.penagihan_pembelian_id = ppp.id 
            where ppp.purchase_order_id = prm.purchase_order_id
            and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'"
		) as tagihan_bruto,
        (
            select COALESCE(SUM(pppp.total),0)
            from pmm_pembayaran_penagihan_pembelian pppp 
            inner join pmm_penagihan_pembelian ppp 
            on pppp.penagihan_pembelian_id = ppp.id 
            where ppp.purchase_order_id = prm.purchase_order_id
            and pppp.memo <> "PPN"
            and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'"
        ) as pembayaran,
        SUM(prm.display_price) - 
        (
            select COALESCE(SUM(pppp.total),0)
            from pmm_pembayaran_penagihan_pembelian pppp 
            inner join pmm_penagihan_pembelian ppp 
            on pppp.penagihan_pembelian_id = ppp.id 
            where ppp.purchase_order_id = prm.purchase_order_id
            and pppp.memo <> "PPN"
            and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'"
        ) as sisa_hutang_penerimaan,
        (
            select SUM(ppd.total) 
            from pmm_penagihan_pembelian_detail ppd 
            inner join pmm_penagihan_pembelian ppp 
            on ppd.penagihan_pembelian_id = ppp.id 
            where ppp.purchase_order_id = prm.purchase_order_id
            and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'"
		) - 
        (
            select COALESCE(SUM(pppp.total),0)
            from pmm_pembayaran_penagihan_pembelian pppp 
            inner join pmm_penagihan_pembelian ppp 
            on pppp.penagihan_pembelian_id = ppp.id 
            where ppp.purchase_order_id = prm.purchase_order_id
            and pppp.memo <> "PPN"
            and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'"
        ) as sisa_hutang_tagihan');
        $this->db->join('produk p','prm.material_id = p.id','left');
        $this->db->join('pmm_purchase_order ppo','prm.purchase_order_id = ppo.id','left');
        if(!empty($start_date) && !empty($end_date)){
            $this->db->where('prm.date_receipt >=',$start_date);
            $this->db->where('prm.date_receipt <=',$end_date);
        }
        if(!empty($supplier_id)){
            $this->db->where('ppo.supplier_id',$supplier_id);
        }
        if(!empty($filter_kategori)){
            $this->db->where_in('ppo.kategori_id',$filter_kategori);
        }
		$this->db->where("ppo.status in ('PUBLISH','CLOSED')");
        $this->db->order_by('ppo.date_po','asc');
        $this->db->group_by('prm.purchase_order_id');
        $query = $this->db->get('pmm_receipt_material prm');
        $output = $query->result_array();
		
        return $output;
    }

    function GetLaporanMonitoringHutang($supplier_id=false,$start_date=false,$end_date=false,$filter_kategori=false,$filter_status=false)
    {
        $output = array();

        $this->db->select('ppp.*, pvp.tanggal_lolos_verifikasi, pvp.status_umur_hutang, ps.nama, ppo.subject,
        (select COALESCE(sum(total),0) from pmm_penagihan_pembelian_detail ppd where ppd.penagihan_pembelian_id = ppp.id and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'") as dpp_tagihan,
        (select COALESCE(sum(ppn),0) from pmm_verifikasi_penagihan_pembelian ppd where ppd.penagihan_pembelian_id = ppp.id and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'") as ppn_tagihan,
        (select COALESCE(sum(total),0) from pmm_penagihan_pembelian_detail ppd where ppd.penagihan_pembelian_id = ppp.id and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'") +  (select COALESCE(sum(ppn),0) from pmm_verifikasi_penagihan_pembelian ppd where ppd.penagihan_pembelian_id = ppp.id and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'") as jumlah_tagihan,

        (select COALESCE(sum(total),0) from pmm_pembayaran_penagihan_pembelian pppp where pppp.penagihan_pembelian_id = ppp.id and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'") - (select COALESCE(sum(total),0) from pmm_pembayaran_penagihan_pembelian pppp where pppp.penagihan_pembelian_id = ppp.id and pppp.memo in ("PPN","PPH") and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'") as dpp_pembayaran,
        (select COALESCE(sum(total),0) from pmm_pembayaran_penagihan_pembelian pppp where pppp.penagihan_pembelian_id = ppp.id and pppp.memo = "PPN" and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'") as ppn_pembayaran,
        (select COALESCE(sum(total),0) from pmm_pembayaran_penagihan_pembelian pppp where pppp.penagihan_pembelian_id = ppp.id and pppp.memo = "PPH" and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'") as pph_pembayaran,
        (select COALESCE(sum(total),0) from pmm_pembayaran_penagihan_pembelian pppp where pppp.penagihan_pembelian_id = ppp.id and pppp.memo <> "PPN" and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'") + (select COALESCE(sum(total),0) from pmm_pembayaran_penagihan_pembelian pppp where pppp.penagihan_pembelian_id = ppp.id and pppp.memo = "PPN" and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'") as jumlah_pembayaran,

        (select COALESCE(sum(total),0) from pmm_penagihan_pembelian_detail ppd where ppd.penagihan_pembelian_id = ppp.id and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'") - (select COALESCE(sum(total),0) from pmm_pembayaran_penagihan_pembelian pppp where pppp.penagihan_pembelian_id = ppp.id and pppp.memo <> "PPN" and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'") as dpp_sisa_hutang,
        (select COALESCE(sum(ppn),0) from pmm_verifikasi_penagihan_pembelian ppd where ppd.penagihan_pembelian_id = ppp.id and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'") - (select COALESCE(sum(total),0) from pmm_pembayaran_penagihan_pembelian pppp where pppp.penagihan_pembelian_id = ppp.id and pppp.memo = "PPN" and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'") as ppn_sisa_hutang,
        (select COALESCE(sum(total),0) from pmm_penagihan_pembelian_detail ppd where ppd.penagihan_pembelian_id = ppp.id and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'") - (select COALESCE(sum(total),0) from pmm_pembayaran_penagihan_pembelian pppp where pppp.penagihan_pembelian_id = ppp.id and pppp.memo <> "PPN" and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'") + (select COALESCE(sum(ppn),0) from pmm_verifikasi_penagihan_pembelian ppd where ppd.penagihan_pembelian_id = ppp.id and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'") - (select COALESCE(sum(total),0) from pmm_pembayaran_penagihan_pembelian pppp where pppp.penagihan_pembelian_id = ppp.id and pppp.memo = "PPN" and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'")as jumlah_sisa_hutang
        ');
        $this->db->join('penerima ps','ppp.supplier_id = ps.id','left');
        $this->db->join('pmm_verifikasi_penagihan_pembelian pvp','ppp.id = pvp.penagihan_pembelian_id','left');
        $this->db->join('pmm_purchase_order ppo','ppp.purchase_order_id = ppo.id','left');
        if(!empty($start_date) && !empty($end_date)){
            $this->db->where('pvp.tanggal_lolos_verifikasi >=',$start_date.' 00:00:00');
            $this->db->where('pvp.tanggal_lolos_verifikasi <=',$end_date.' 23:59:59');
        }
        if(!empty($supplier_id) || $supplier_id != 0){
            $this->db->where('ppp.supplier_id',$supplier_id);
        }
        if(!empty($filter_kategori) || $filter_kategori != 0){
            $this->db->where_in('ppo.kategori_id',$filter_kategori);
        }
        if(!empty($filter_status) || $filter_status != 0){
            $this->db->where_in('ppp.status',$filter_status);
        }
        
        $this->db->where("ppp.verifikasi_dok in ('SUDAH','LENGKAP')");
        $this->db->order_by('ppp.tanggal_invoice','asc');
        $this->db->group_by('ppp.id');
        $query = $this->db->get('pmm_penagihan_pembelian ppp');
        $output = $query->result_array();
		
        return $output;
    }

    function GetPengirimanPenjualan($filter_client_id=false,$purchase_order_no=false,$start_date=false,$end_date=false,$filter_product=false)
    {
        $output = array();

        $this->db->select('ppo.client_id, pp.salesPo_id, pp.product_id, pp.measure, p.nama_produk, SUM(pp.display_volume) as total, SUM(pp.display_price) / SUM(pp.display_volume) as price, SUM(pp.display_price) as total_price');
        $this->db->join('produk p','pp.product_id = p.id','left');
        $this->db->join('pmm_sales_po ppo','pp.salesPo_id = ppo.id','left');
        if(!empty($start_date) && !empty($end_date)){
            $this->db->where('pp.date_production >=',$start_date);
            $this->db->where('pp.date_production <=',$end_date);
        }
        if(!empty($filter_client_id)){
            $this->db->where('pp.client_id',$filter_client_id);
        }
        if(!empty($purchase_order_no)){
            $this->db->where('ppo.id',$purchase_order_no);
        }
        if(!empty($filter_product)){
            $this->db->where_in('pp.product_id',$filter_product);
        }
		
		$this->db->where('pp.status','PUBLISH');
        $this->db->where("ppo.status in ('OPEN','CLOSED')");
        $this->db->where("pp.product_id in (3,4,7,8,9,14,24,63)");
        $this->db->order_by('p.nama_produk','asc');
        $this->db->group_by('pp.product_id');
        $query = $this->db->get('pmm_productions pp');
        
        $output = $query->result_array();
		
        return $output;
    }

    function GetLaporanPiutang($client_id=false,$start_date=false,$end_date=false)
    {
        $output = array();

        $this->db->select('pp.salesPo_id, p.nama_produk, SUM(pp.display_price) as penerimaan,
        (
            select SUM(ppd.total) 
            from pmm_penagihan_penjualan_detail ppd 
            inner join pmm_penagihan_penjualan ppp 
            on ppd.penagihan_id = ppp.id 
            where ppp.sales_po_id = pp.salesPo_id
            and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'"
		) as tagihan,
        SUM(pp.display_price) -
        (
            select  COALESCE(SUM(ppd.total),0) 
            from pmm_penagihan_penjualan_detail ppd 
            inner join pmm_penagihan_penjualan ppp 
            on ppd.penagihan_id = ppp.id 
            where ppp.sales_po_id = pp.salesPo_id
            and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'"
		) as tagihan_bruto,
        (
            select COALESCE(SUM(pppp.total),0)
            from pmm_pembayaran pppp 
            inner join pmm_penagihan_penjualan ppp 
            on pppp.penagihan_id = ppp.id 
            where ppp.sales_po_id = pp.salesPo_id
            and pppp.memo <> "PPN"
            and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'"
        ) as pembayaran,
        SUM(pp.display_price) - 
        (
            select COALESCE(SUM(pppp.total),0)
            from pmm_pembayaran pppp 
            inner join pmm_penagihan_penjualan ppp 
            on pppp.penagihan_id = ppp.id 
            where ppp.sales_po_id = pp.salesPo_id
            and pppp.memo <> "PPN"
            and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'"
        ) as sisa_piutang_penerimaan,
        (
            select SUM(ppd.total) 
            from pmm_penagihan_penjualan_detail ppd 
            inner join pmm_penagihan_penjualan ppp 
            on ppd.penagihan_id = ppp.id 
            where ppp.sales_po_id = pp.salesPo_id
            and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'"
		) - 
        (
            select COALESCE(SUM(pppp.total),0)
            from pmm_pembayaran pppp 
            inner join pmm_penagihan_penjualan ppp 
            on pppp.penagihan_id = ppp.id 
            where ppp.sales_po_id = pp.salesPo_id
            and pppp.memo <> "PPN"
            and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'"
        ) as sisa_piutang_tagihan');
        $this->db->join('produk p','pp.product_id = p.id','left');
        $this->db->join('pmm_sales_po po','pp.salesPo_id = po.id','left');
        if(!empty($start_date) && !empty($end_date)){
            $this->db->where('pp.date_production >=',$start_date);
            $this->db->where('pp.date_production <=',$end_date);
        }
        if(!empty($client_id)){
            $this->db->where('po.client_id',$client_id);
        }
		$this->db->where("po.status in ('OPEN','CLOSED')");
        $this->db->order_by('po.contract_date','asc');
        $this->db->group_by('pp.salesPo_id');
        $query = $this->db->get('pmm_productions pp');
        $output = $query->result_array();
		
        return $output;
    }

    function GetLaporanMonitoringPiutang($client_id=false,$start_date=false,$end_date=false,$filter_kategori=false,$filter_status=false)
    {
        $output = array();

        $this->db->select('ppp.*, ps.nama, po.jobs_type as subject,
        (select COALESCE(sum(total),0) from pmm_penagihan_penjualan_detail ppd where ppd.penagihan_id = ppp.id and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'") as dpp_tagihan,
        (select COALESCE(sum(tax),0) from pmm_penagihan_penjualan_detail ppd where ppd.penagihan_id = ppp.id and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'") as ppn_tagihan,
        (select COALESCE(sum(total),0) from pmm_penagihan_penjualan_detail ppd where ppd.penagihan_id = ppp.id and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'") +  (select COALESCE(sum(tax),0) from pmm_penagihan_penjualan_detail ppd where ppd.penagihan_id = ppp.id and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'") as jumlah_tagihan,

        (select COALESCE(sum(total),0) from pmm_pembayaran pppp where pppp.penagihan_id = ppp.id and pppp.memo <> "PPN" and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'") as dpp_pembayaran,
        (select COALESCE(sum(total),0) from pmm_pembayaran pppp where pppp.penagihan_id = ppp.id and pppp.memo = "PPN" and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'") as ppn_pembayaran,
        (select COALESCE(sum(total),0) from pmm_pembayaran pppp where pppp.penagihan_id = ppp.id and pppp.memo <> "PPN" and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'") + (select COALESCE(sum(total),0) from pmm_pembayaran pppp where pppp.penagihan_id = ppp.id and pppp.memo = "PPN" and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'") as jumlah_pembayaran,
        
        (select COALESCE(sum(total),0) from pmm_penagihan_penjualan_detail ppd where ppd.penagihan_id = ppp.id and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'") - (select COALESCE(sum(total),0) from pmm_pembayaran pppp where pppp.penagihan_id = ppp.id and pppp.memo <> "PPN" and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'") as dpp_sisa_piutang,
        (select COALESCE(sum(tax),0) from pmm_penagihan_penjualan_detail ppd where ppd.penagihan_id = ppp.id and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'") - (select COALESCE(sum(total),0) from pmm_pembayaran pppp where pppp.penagihan_id = ppp.id and pppp.memo = "PPN" and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'") as ppn_sisa_piutang,

        (select COALESCE(sum(total),0) from pmm_penagihan_penjualan_detail ppd where ppd.penagihan_id = ppp.id and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'") - (select COALESCE(sum(total),0) from pmm_pembayaran pppp where pppp.penagihan_id = ppp.id and pppp.memo <> "PPN" and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'") + (select COALESCE(sum(tax),0) from pmm_penagihan_penjualan_detail ppd where ppd.penagihan_id = ppp.id and ppp.tanggal_invoice >= "'.$start_date.'"  and ppp.tanggal_invoice <= "'.$end_date.'") - (select COALESCE(sum(total),0) from pmm_pembayaran pppp where pppp.penagihan_id = ppp.id and pppp.memo = "PPN" and pppp.tanggal_pembayaran >= "'.$start_date.'"  and pppp.tanggal_pembayaran <= "'.$end_date.'") as jumlah_sisa_piutang
        ');
        $this->db->join('penerima ps','ppp.client_id = ps.id','left');
        $this->db->join('pmm_sales_po po','ppp.sales_po_id = po.id','left');
        if(!empty($start_date) && !empty($end_date)){
            $this->db->where('ppp.tanggal_invoice >=',$start_date.' 00:00:00');
            $this->db->where('ppp.tanggal_invoice <=',$end_date.' 23:59:59');
        }
        if(!empty($client_id) || $client_id != 0){
            $this->db->where('ppp.client_id',$client_id);
        }
        if(!empty($filter_kategori) || $filter_kategori != 0){
            $this->db->where_in('po.kategori_id',$filter_kategori);
        }
        if(!empty($filter_status) || $filter_status != 0){
            $this->db->where_in('ppp.status_pembayaran',$filter_status);
        }
        $this->db->order_by('ppp.tanggal_invoice','asc');
        $this->db->group_by('ppp.id');
        $query = $this->db->get('pmm_penagihan_penjualan ppp');
        $output = $query->result_array();
		
        return $output;
    }

    function GetProduksiHarian($supplier_id=false,$purchase_order_no=false,$start_date=false,$end_date=false,$filter_material=false)
    {
        $output = array();

       $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 AS jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 AS jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 AS jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 AS jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 AS jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f');
		
		$this->db->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left');
		$this->db->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id','left');
        
		if(!empty($start_date) && !empty($end_date)){
            $this->db->where('pph.date_prod >=',$start_date);
            $this->db->where('pph.date_prod <=',$end_date);
        }
		
		if(!empty($supplier_id)){
            $this->db->where('pph.no_prod',$supplier_id);
        }
        if(!empty($purchase_order_no)){
            $this->db->where('pph.produksi_harian_id',$purchase_order_no);
        }
        if(!empty($filter_material)){
            $this->db->where_in('ppd.material_id',$filter_material);
        }
		
		$this->db->group_by('pph.id');
        $query = $this->db->get('pmm_produksi_harian pph');
		
        $output = $query->result_array();
        return $output;
    }

    function GetMatCampuran($supplier_id=false,$purchase_order_no=false,$start_date=false,$end_date=false,$filter_material=false)
    {
        $output = array();

       $this->db->select('pph.id, (SUM(pphd.volume_convert) * pk.presentase_a) / 100 AS jumlah_pemakaian_a,  (SUM(pphd.volume_convert) * pk.presentase_b) / 100 AS jumlah_pemakaian_b,  (SUM(pphd.volume_convert) * pk.presentase_c) / 100 AS jumlah_pemakaian_c,  (SUM(pphd.volume_convert) * pk.presentase_d) / 100 AS jumlah_pemakaian_d, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d');
		
		$this->db->join('pmm_produksi_campuran_detail pphd', 'pph.id = pphd.produksi_campuran_id','left');
		$this->db->join('pmm_agregat pk', 'pphd.product_id = pk.id','left');
        
		if(!empty($start_date) && !empty($end_date)){
            $this->db->where('pph.date_prod >=',$start_date);
            $this->db->where('pph.date_prod <=',$end_date);
        }
		
		if(!empty($supplier_id)){
            $this->db->where('pph.no_prod',$supplier_id);
        }
        if(!empty($purchase_order_no)){
            $this->db->where('pph.produksi_campuran_id',$purchase_order_no);
        }
        if(!empty($filter_material)){
            $this->db->where_in('ppd.material_id',$filter_material);
        }
		
        $this->db->where('pph.status','PUBLISH');
		$this->db->group_by('pph.id');
        $query = $this->db->get('pmm_produksi_campuran pph');
		
        $output = $query->result_array();
        return $output;
    }

    function GetEvaluasiProduksi($supplier_id=false,$purchase_order_no=false,$start_date=false,$end_date=false,$filter_material=false)
    {
        $output = array();

        $this->db->select('pph.id, pk.jobs_type, pk.no_kalibrasi, pph.date_prod, pph.date_prod, pphd.duration, (pphd.use / pphd.duration) as capacity, pphd.use as used');
		
		$this->db->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left');
		$this->db->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id','left');
        
		if(!empty($start_date) && !empty($end_date)){
            $this->db->where('pph.date_prod >=',$start_date);
            $this->db->where('pph.date_prod <=',$end_date);
        }
		
		if(!empty($supplier_id)){
            $this->db->where('pph.no_prod',$supplier_id);
        }
        if(!empty($purchase_order_no)){
            $this->db->where('pph.produksi_harian_id',$purchase_order_no);
        }
        if(!empty($filter_material)){
            $this->db->where_in('ppd.material_id',$filter_material);
        }
		
        $this->db->where('pph.status','PUBLISH');
		$this->db->group_by('pphd.id','asc');
        $query = $this->db->get('pmm_produksi_harian pph');
		
        $output = $query->result_array();
        return $output;
    }

    function GetRekapitulasi($supplier_id=false,$purchase_order_no=false,$start_date=false,$end_date=false,$filter_material=false)
    {
        $output = array();

       $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 AS jumlah_pemakaian_a,  (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b,  (SUM(pphd.use) * pk.presentase_c) / 100 AS jumlah_pemakaian_c,  (SUM(pphd.use) * pk.presentase_d) / 100 AS jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 AS jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 AS jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f');
		
		$this->db->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left');
		$this->db->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id','left');
        
		if(!empty($start_date) && !empty($end_date)){
            $this->db->where('pph.date_prod >=',$start_date);
            $this->db->where('pph.date_prod <=',$end_date);
        }
		
		if(!empty($supplier_id)){
            $this->db->where('pph.no_prod',$supplier_id);
        }
        if(!empty($purchase_order_no)){
            $this->db->where('pph.id',$purchase_order_no);
        }
        if(!empty($filter_material)){
            $this->db->where_in('ppd.material_id',$filter_material);
        }
		$this->db->where('pph.status','PUBLISH');
		$this->db->group_by('pph.id');
        $query = $this->db->get('pmm_produksi_harian pph');
		
        $output = $query->result_array();
        return $output;
    }

    function GetReceiptTagihanPembelian($supplier_id=false,$start_date=false,$end_date=false)
    {
        $output = array();

        $this->db->select('ppp.id, ppp.tanggal_invoice, ppp.nomor_invoice, SUM(ppd.volume) as volume, ppd.measure, (SUM(ppd.total)/SUM(ppd.volume)) as harsat, SUM(ppd.total) as dpp,
        (select COALESCE(sum(ppn),0) from pmm_verifikasi_penagihan_pembelian ppd where ppd.penagihan_pembelian_id = ppp.id and ppp.created_on >= "'.$start_date.'"  and ppp.created_on <= "'.$end_date.'") as tax_ppn,
        (select COALESCE(sum(pph),0) from pmm_verifikasi_penagihan_pembelian ppd where ppd.penagihan_pembelian_id = ppp.id and ppp.created_on >= "'.$start_date.'"  and ppp.created_on <= "'.$end_date.'") as tax_pph,
        ');
		$this->db->join('pmm_penagihan_pembelian_detail ppd', 'ppp.id = ppd.penagihan_pembelian_id', 'left');
        
		if(!empty($start_date) && !empty($end_date)){
            $this->db->where('ppp.tanggal_invoice >=',$start_date);
            $this->db->where('ppp.tanggal_invoice <=',$end_date);
        }
		
		if(!empty($supplier_id)){
            $this->db->where('ppp.supplier_id',$supplier_id);
        }
        
        $this->db->group_by('ppp.id');
		$this->db->order_by('ppp.tanggal_invoice','asc');
        $query = $this->db->get('pmm_penagihan_pembelian ppp');
		
        $output = $query->result_array();
        return $output;
    }

    function GetReceiptTagihanPenjualan($supplier_id=false,$start_date=false,$end_date=false)
    {
        $output = array();

        $this->db->select('ppp.id, ppp.tanggal_invoice, ppp.nomor_invoice, SUM(ppd.qty) as volume, ppd.measure, (SUM(ppd.total)/SUM(ppd.qty)) as harsat, SUM(ppd.total) as dpp, SUM(ppd.tax) as tax');
		$this->db->join('pmm_penagihan_penjualan_detail ppd', 'ppp.id = ppd.penagihan_id', 'left');
        
		if(!empty($start_date) && !empty($end_date)){
            $this->db->where('ppp.tanggal_invoice >=',$start_date);
            $this->db->where('ppp.tanggal_invoice <=',$end_date);
        }
		
		if(!empty($supplier_id)){
            $this->db->where('ppp.client_id',$supplier_id);
        }
		
        $this->db->group_by('ppp.id');
		$this->db->order_by('ppp.tanggal_invoice','asc');
        $query = $this->db->get('pmm_penagihan_penjualan ppp');
		
        $output = $query->result_array();
        return $output;
    }

    function getMatByPenawaranBoulder()
    {

        $this->db->select('pp.id as penawaran_id, p.nama as nama, pp.supplier_id as supplier_id, pp.jenis_pembelian, pm.nama_produk as material_name, ppd.measure,ppd.material_id, ppd.id, pms.measure_name, ppd.price, pp.nomor_penawaran, pp.id, ppd.tax_id, ppd.tax, ppd.pajak_id, ppd.pajak');
        $this->db->join('pmm_penawaran_pembelian pp','ppd.penawaran_pembelian_id = pp.id','left');
        $this->db->join('produk pm','ppd.material_id = pm.id','left');
        $this->db->join('penerima p','pp.supplier_id = p.id','left');
        $this->db->join('pmm_measures pms','ppd.measure = pms.id','left');
        $this->db->where("pm.id = '15' ");
        $this->db->where('pp.status','OPEN');
        $this->db->group_by('ppd.penawaran_pembelian_id');
		$this->db->order_by('p.nama','asc');
        $data = $this->db->get('pmm_penawaran_pembelian_detail ppd')->result_array();

        return $data;
    }

    function getMatByPenawaranBBM()
    {

        $this->db->select('pp.id as penawaran_id, p.nama as nama, pp.supplier_id as supplier_id, pp.jenis_pembelian, pm.nama_produk as material_name, ppd.measure,ppd.material_id, ppd.id, pms.measure_name, ppd.price, pp.nomor_penawaran, pp.id, ppd.tax_id, ppd.tax, ppd.pajak_id, ppd.pajak');
        $this->db->join('pmm_penawaran_pembelian pp','ppd.penawaran_pembelian_id = pp.id','left');
        $this->db->join('produk pm','ppd.material_id = pm.id','left');
        $this->db->join('penerima p','pp.supplier_id = p.id','left');
        $this->db->join('pmm_measures pms','ppd.measure = pms.id','left');
        $this->db->where("pm.id = '13' ");
        $this->db->where('pp.status','OPEN');
        $this->db->group_by('ppd.penawaran_pembelian_id');
		$this->db->order_by('p.nama','asc');
        $data = $this->db->get('pmm_penawaran_pembelian_detail ppd')->result_array();

        return $data;
    }

    function TableMainVerifikasi($id)
    {
        $data = array();
        $this->db->select('pvp.*, ppp.supplier_id, ppp.nomor_invoice');
        $this->db->join('pmm_penagihan_pembelian ppp','pvp.penagihan_pembelian_id = ppp.id','left');
        $this->db->where('pvp.id',$id);
        $this->db->order_by('pvp.id','asc');
        $query = $this->db->get('pmm_verifikasi_penagihan_pembelian pvp');
	
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
                $row['nama']= $this->crud_global->GetField('penerima',array('id'=>$row['supplier_id']),'nama');
                $row['tanggal_lolos_verifikasi'] = date('d F Y',strtotime($row['tanggal_lolos_verifikasi']));
                $row['nomor_invoice']= $row['nomor_invoice'];
                $row['actions'] = '<a href="javascript:void(0);" onclick="OpenFormMain('.$row['id'].')" class="btn btn-success" style="font-weight:bold; border-radius:10px;"> Update Verifikasi</a>';
                
                $data[] = $row;
            }

        }
        
        return $data;   
    }

    function GetDaftarPembayaran($supplier_id=false,$purchase_order_no=false,$start_date=false,$end_date=false,$filter_material=false)
    {
        $output = array();
		
        $this->db->select('ppp.id as penagihan_id, pmp.tanggal_pembayaran, pmp.nomor_transaksi, ppp.tanggal_invoice, ppp.nomor_invoice, pmp.total as pembayaran');
		$this->db->join('pmm_penagihan_pembelian ppp','pmp.penagihan_pembelian_id = ppp.id','left');
        $this->db->join('pmm_purchase_order ppo','ppp.purchase_order_id = ppo.id','left');

		if(!empty($start_date) && !empty($end_date)){
            $this->db->where('pmp.tanggal_pembayaran >=',$start_date.' 00:00:00');
            $this->db->where('pmp.tanggal_pembayaran <=',$end_date.' 23:59:59');
        }
		
		if(!empty($supplier_id)){
            $this->db->where('pmp.supplier_name',$supplier_id);
        }
        if(!empty($purchase_order_no)){
            $this->db->where('pmp.penagihan_pembelian_id',$purchase_order_no);
        }
        if(!empty($filter_material)){
            $this->db->where_in('ppd.material_id',$filter_material);
        }
		
        $this->db->where("ppo.status in ('PUBLISH','CLOSED')");
        $this->db->order_by('pmp.tanggal_pembayaran','desc');
        $query = $this->db->get('pmm_pembayaran_penagihan_pembelian pmp');
		
        $output = $query->result_array();
        return $output;
    }

    function GetDaftarPenerimaan($supplier_id=false,$purchase_order_no=false,$start_date=false,$end_date=false,$filter_material=false)
    {
        $output = array();
		
        $this->db->select('pmp.client_id, pmp.tanggal_pembayaran, pmp.nomor_transaksi, ppp.tanggal_invoice, ppp.nomor_invoice, pmp.total as penerimaan');
		$this->db->join('pmm_penagihan_penjualan ppp','pmp.penagihan_id = ppp.id','left');
        $this->db->join('pmm_sales_po ppo', 'ppp.sales_po_id = ppo.id','left');
        
		if(!empty($start_date) && !empty($end_date)){
            $this->db->where('pmp.tanggal_pembayaran >=',$start_date);
            $this->db->where('pmp.tanggal_pembayaran <=',$end_date);
        }
		
		if(!empty($supplier_id)){
            $this->db->where('pmp.client_id',$supplier_id);
        }
        if(!empty($purchase_order_no)){
            $this->db->where('pmp.penagihan_id',$purchase_order_no);
        }
        if(!empty($filter_material)){
            $this->db->where_in('ppd.material_id',$filter_material);
        }
		
		$this->db->where("ppo.status in ('OPEN','CLOSED')");
		$this->db->order_by('pmp.nama_pelanggan','asc');
        $query = $this->db->get('pmm_pembayaran pmp');
		
        $output = $query->result_array();
        return $output;
    }

    function getBebanPokokPenjualan($date1,$date2)
    {   
        $data = array();
		
		$arr_date = $this->input->post('filter_date');
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
		
        
        $total = 0;
		?>

        <!-- Total Pendapatan / Penjualan -->
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
		?>

		<!-- HPPenjualan -->
		<?php
		$last_production = $this->db->select('date')->order_by('date','desc')->limit(1,5)->get_where('pmm_remaining_materials_cat',array('status'=>'PUBLISH','material_id'=>'4'))->row_array();
		$last_production_2 = $this->db->select('date')->order_by('date','desc')->limit(1,3)->get_where('pmm_remaining_materials_cat',array('status'=>'PUBLISH','material_id'=>'4'))->row_array();

		$date1_old = date('Y-m-d', strtotime('+1 days', strtotime($last_production['date'])));
		$date2_old = date('Y-m-d', strtotime($last_production_2['date']));

		$tanggal_opening_balance = date('Y-m-d', strtotime('-1 days', strtotime($date1)));

		$akumulasi_bahan_jadi = $this->db->select('sum(pp.volume) as volume, sum(pp.nilai) as nilai')
		->from('kunci_bahan_jadi pp')
		->where("(pp.date = '$tanggal_opening_balance')")
		->get()->row_array();
		$akumulasi_bahan_jadi_volume = $akumulasi_bahan_jadi['volume'];
		$akumulasi_bahan_jadi_nilai = $akumulasi_bahan_jadi['nilai'];
		?>

		<!-- HPProduksi -->
		<!-- Alat -->
		<?php
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
		
		$excavator = $this->db->select('sum(prm.display_price) as price')
		->from('pmm_receipt_material prm ')
		->where("prm.material_id = 18")
		->where("(prm.date_receipt between '$date1' and '$date2')")
		->get()->row_array();
		
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
		
		$total_biaya_peralatan = $stone_crusher + $whell_loader + $excavator['price'] + $genset + $timbangan + $tangki_solar;
		
		//Opening Balance
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

		$stok_akhir_volume = $stok_volume_bbm_lalu - $produksi_volume;
		$stok_akhir_nilai = $stok_nilai_bbm_lalu - $produksi_nilai;
		$stok_akhir_harsat = (round($stok_akhir_volume,2)!=0)?$stok_akhir_nilai / round($stok_akhir_volume,2) * 1:0;

		$stok_akhir_volume_2 = $pembelian_volume - $produksi_2_volume;
		$stok_akhir_nilai_2 = $pembelian_nilai - $produksi_2_nilai;
		$stok_akhir_harsat_2 = (round($stok_akhir_volume_2,2)!=0)?$stok_akhir_nilai_2 / round($stok_akhir_volume_2,2) * 1:0;

		$stok_akhir_volume_total = $stok_akhir_volume + $stok_akhir_volume_2;
		$stok_akhir_nilai_total = $stok_akhir_nilai + $stok_akhir_nilai_2;

		$harga_baru = $total_produksi_nilai / $total_produksi_volume;
		$total_nilai_produksi_solar = $total_produksi_nilai;
		?>

		<!-- HPProduksi -->
		<!-- Overhead -->
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
		?>
        <!--  Jumlah HPProduksi (Tanpa Limbah)  -->
		<?php
		$rekapitulasi_produksi_harian = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
		->from('pmm_produksi_harian pph ')
		->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
		->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
		->where("(pph.date_prod between '$date1' and '$date2')")
		->where('pph.status','PUBLISH')
		->get()->row_array();
		$total_rekapitulasi_produksi_harian = round($rekapitulasi_produksi_harian['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_f'],2);
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

        $total_nilai_rap = $nilai_boulder + $nilai_tangki + $nilai_sc + $nilai_gns + $nilai_wl + $nilai_timbangan + $overhead + $nilai_bbm_solar;
        $total_ton = $nilai_boulder_ton + $nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $overhead_ton + $nilai_bbm_solar_ton;
        ?>
        
        <?php
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
        
        $harga_boulder = $this->db->select('pp.nilai_boulder as nilai_boulder, pp.nilai_boulder_lain as nilai_boulder_lain')
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
        $total_produksi_nilai = $produksi_nilai + $produksi_2_nilai - $harga_boulder['nilai_boulder_lain'];

        $harga_baru = ($total_rekapitulasi_produksi_harian!=0)?$total_produksi_nilai / $total_rekapitulasi_produksi_harian * 1:0;
        $total_nilai_produksi_boulder = $total_rekapitulasi_produksi_harian * $harga_baru;
        ?>
        <?php
        $produksi = $this->db->select('pp.produksi')
        ->from('kunci_bahan_jadi pp')
        ->where("(pp.date between '$date1' and '$date2')")
        ->group_by('pp.produksi')
        ->order_by('pp.id','desc')->limit(1)
        ->get()->row_array();
        $produksi = $produksi['produksi'];
        ?>
        <?php
        $total_nilai_rap = ($nilai_boulder_ton * round($total_rekapitulasi_produksi_harian,2)) + (($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($total_rekapitulasi_produksi_harian,2)) + ($overhead_ton * round($total_rekapitulasi_produksi_harian,2));
        ?>
        <?php
        $nilai_hpp_siap_jual = ($akumulasi_bahan_jadi_nilai) + (($total_nilai_produksi_boulder + $total_biaya_peralatan + $total_nilai_produksi_solar + $total_operasional) * $produksi);
        ?>
        <?php
        $volume = round($akumulasi_bahan_jadi_volume,2) + round($total_rekapitulasi_produksi_harian,2) - round($total_volume,2);
        $harsat_produksi = (round($total_rekapitulasi_produksi_harian,2)!=0)?($total_nilai_produksi_boulder + $total_biaya_peralatan + $total_nilai_produksi_solar + $total_operasional) / round($total_rekapitulasi_produksi_harian,2) * 1:0;
        $harsat_produksi_stok = (round($akumulasi_bahan_jadi_volume,2)!=0)?$akumulasi_bahan_jadi_nilai / round($akumulasi_bahan_jadi_volume,2) * 1:0;
        $key = 0;
        if($harsat_produksi == 0) {
            $key = $harsat_produksi_stok;
        }

        if($harsat_produksi > 0) {
            $key = $harsat_produksi;
        }
        ?>
        <?php
        $nilai_beban_produksi = $total_volume * $key;
        ?>
        <?php
        $query = $nilai_beban_produksi;
        
        if(!empty($query)){
            $total = $query;
        }
        return $total;
    }

    function getBebanPokokPenjualanAkumulasi($date3,$date2)
    {   
        $data = array();
		
		$arr_date = $this->input->post('filter_date');
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
		
        
        $total = 0;
		?>

        <!-- Total Pendapatan / Penjualan -->
		<?php
		$penjualan = $this->db->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
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
		
		$total_penjualan = 0;
		$total_volume = 0;

		foreach ($penjualan as $x){
			$total_penjualan += $x['price'];
			$total_volume += $x['volume'];
		}
		?>

		<!-- HPPenjualan -->
		<?php
		$last_production = $this->db->select('date')->order_by('date','desc')->limit(1,5)->get_where('pmm_remaining_materials_cat',array('status'=>'PUBLISH','material_id'=>'4'))->row_array();
		$last_production_2 = $this->db->select('date')->order_by('date','desc')->limit(1,3)->get_where('pmm_remaining_materials_cat',array('status'=>'PUBLISH','material_id'=>'4'))->row_array();

		$date1_old = date('Y-m-d', strtotime('+1 days', strtotime($last_production['date'])));
		$date2_old = date('Y-m-d', strtotime($last_production_2['date']));

		$tanggal_opening_balance = date('Y-m-d', strtotime('-1 days', strtotime($date3)));

		$akumulasi_bahan_jadi = $this->db->select('sum(pp.volume) as volume, sum(pp.nilai) as nilai')
		->from('kunci_bahan_jadi pp')
		->where("(pp.date = '$tanggal_opening_balance')")
		->get()->row_array();
		$akumulasi_bahan_jadi_volume = $akumulasi_bahan_jadi['volume'];
		$akumulasi_bahan_jadi_nilai = $akumulasi_bahan_jadi['nilai'];
		?>

		<!-- HPProduksi -->
		<!-- Alat -->
		<?php
		$alat = $this->db->select('sum(alat) as total')
        ->from('bpp')
        ->where("(date between '$date3' and '$date2')")
        ->get()->row_array();
        $total_biaya_peralatan = $alat['total'];
		$total_nilai_produksi_solar = 0;
		?>

		<!-- HPProduksi -->
		<!-- Overhead -->
		<?php
		$overhead = $this->db->select('sum(overhead) as total')
        ->from('bpp')
        ->where("(date between '$date3' and '$date2')")
        ->get()->row_array();
        $total_operasional = $overhead['total'];
		?>

        <!--  Jumlah HPProduksi (Tanpa Limbah)  -->
		<?php
		$rekapitulasi_produksi_harian = $this->db->select('pph.id, (SUM(pphd.use) * pk.presentase_a) / 100 as jumlah_pemakaian_a, (SUM(pphd.use) * pk.presentase_b) / 100 AS jumlah_pemakaian_b, (SUM(pphd.use) * pk.presentase_c) / 100 as jumlah_pemakaian_c, (SUM(pphd.use) * pk.presentase_d) / 100 as jumlah_pemakaian_d, (SUM(pphd.use) * pk.presentase_e) / 100 as jumlah_pemakaian_e, (SUM(pphd.use) * pk.presentase_f) / 100 as jumlah_pemakaian_f, pk.produk_a, pk.produk_b, pk.produk_c, pk.produk_d, pk.produk_e, pk.produk_f, pk.measure_a, pk.measure_b, pk.measure_c, pk.measure_d, pk.measure_e, pk.measure_f, pk.presentase_a, pk.presentase_b, pk.presentase_c, pk.presentase_d, pk.presentase_e, pk.presentase_f')
		->from('pmm_produksi_harian pph ')
		->join('pmm_produksi_harian_detail pphd', 'pph.id = pphd.produksi_harian_id','left')
		->join('pmm_kalibrasi pk', 'pphd.product_id = pk.id')
		->where("(pph.date_prod between '$date3' and '$date2')")
		->where('pph.status','PUBLISH')
		->get()->row_array();
		$total_rekapitulasi_produksi_harian = round($rekapitulasi_produksi_harian['jumlah_pemakaian_a'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_b'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_c'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_d'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_e'],2) + round($rekapitulasi_produksi_harian['jumlah_pemakaian_f'],2);
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

        $total_nilai_rap = $nilai_boulder + $nilai_tangki + $nilai_sc + $nilai_gns + $nilai_wl + $nilai_timbangan + $overhead + $nilai_bbm_solar;
        $total_ton = $nilai_boulder_ton + $nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $overhead_ton + $nilai_bbm_solar_ton;
        ?>
        
        <?php
		$bahan = $this->db->select('sum(bahan) as total')
		->from('bpp')
		->where("(date between '$date3' and '$date2')")
		->get()->row_array();
		$total_nilai_produksi_boulder = $bahan['total'];
		?>
        <?php
        $produksi = $this->db->select('pp.produksi')
        ->from('kunci_bahan_jadi pp')
        ->where("(pp.date between '$date3' and '$date2')")
        ->group_by('pp.produksi')
        ->order_by('pp.id','desc')->limit(1)
        ->get()->row_array();
        $produksi = $produksi['produksi'];
        ?>
        <?php
        $total_nilai_rap = ($nilai_boulder_ton * round($total_rekapitulasi_produksi_harian,2)) + (($nilai_tangki_ton + $nilai_sc_ton + $nilai_gns_ton + $nilai_wl_ton + $nilai_timbangan_ton + $nilai_bbm_solar_ton) * round($total_rekapitulasi_produksi_harian,2)) + ($overhead_ton * round($total_rekapitulasi_produksi_harian,2));
        ?>
        <?php
        $nilai_hpp_siap_jual = ($akumulasi_bahan_jadi_nilai) + (($total_nilai_produksi_boulder + $total_biaya_peralatan + $total_nilai_produksi_solar + $total_operasional) * $produksi);
        ?>
        <?php
        $volume = round($akumulasi_bahan_jadi_volume,2) + round($total_rekapitulasi_produksi_harian,2) - round($total_volume,2);
        $harsat_produksi = (round($total_rekapitulasi_produksi_harian,2)!=0)?($total_nilai_produksi_boulder + $total_biaya_peralatan + $total_nilai_produksi_solar + $total_operasional) / round($total_rekapitulasi_produksi_harian,2) * 1:0;
        $harsat_produksi_stok = (round($akumulasi_bahan_jadi_volume,2)!=0)?$akumulasi_bahan_jadi_nilai / round($akumulasi_bahan_jadi_volume,2) * 1:0;
        $key = 0;
        if($harsat_produksi == 0) {
            $key = $harsat_produksi_stok;
        }

        if($harsat_produksi > 0) {
            $key = $harsat_produksi;
        }
        ?>
        <?php
        $nilai_beban_produksi = $total_volume * $key;
        ?>
        <?php
        $query = $nilai_beban_produksi;
        
        if(!empty($query)){
            $total = $query;
        }
        return $total;
    }
    

}
?>