<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ms_unit extends MY_Generator {

	public function __construct()
	{
		parent::__construct();
						 
		$this->load->model('m_ms_unit');
		
	}

	public function index()
	{
		$this->load->model("m_ms_category_unit");
		$kat = ['SEMUA'];
		foreach ($this->m_ms_category_unit->get_filter() as $key => $value) {
			$kat[$value->catunit_id] = $value->nama;
		}
		$data['kat'] = $kat;
		$this->theme('ms_unit/index',$data);
	}

	public function save()
	{
		$data = $this->input->post();
		if ($this->m_ms_unit->validation()) {
			$input = [];
			foreach ($this->m_ms_unit->rules() as $key => $value) {
				$input[$key] = $data[$key];
			}
			if ($data['unit_id']) {
				$this->db->where('unit_id',$data['unit_id'])->update('ms_unit',$input);
			}else{
				$this->db->insert('ms_unit',$input);
			}
			$err = $this->db->error();
			if ($err['message']) {
				$resp = [
					"code" 		=> "202",
					"message"	=> $err['message']
				];
			}else{
				$resp = [
					"code" 		=> "200",
					"message"	=> "Data berhasil disimpan"
				];
			}
		}else{
			$resp = [
				"code" 		=> "201",
				"message"	=> "error validasi"
			];
		}
		$resp=json_encode($resp);
		$this->session->set_flashdata("message",$resp);
		redirect('ms_unit');

	}

	public function get_data()
	{
		$this->load->library('datatable');
		$attr 	= $this->input->post();
		$fields = $this->m_ms_unit->get_column();
		$filter=[];
		if($attr['catunit_id']>0){
			$filter = ["unit_type" => $attr['catunit_id']];
		}
		$data 	= $this->datatable->get_data($fields,$filter,'m_ms_unit',$attr);
		$records["aaData"] = array();
		$no   	= 1 + $attr['start']; 
        foreach ($data['dataku'] as $index=>$row) { 
            $obj = array($row['id_key'],$no);
            foreach ($fields as $key => $value) {
            	if (is_array($value)) {
            		if (isset($value['custom'])){
            			$obj[] = call_user_func($value['custom'],$row[$key]);
            		}else{
            			$obj[] = $row[$key];
            		}
            	}else{
            		$obj[] = $row[$value];
            	}
            }
            $obj[] = create_btnAction(["update","delete"],$row['id_key']);
            $records["aaData"][] = $obj;
            $no++;
        }
        $data = array_merge($data,$records);
        unset($data['dataku']);
        echo json_encode($data);
	}

	public function find_one($id)
	{
		$data = $this->db->where('unit_id',$id)->get("ms_unit")->row();

		echo json_encode($data);
	}

	public function delete_row($id)
	{
		$this->db->where('unit_id',$id)->delete("ms_unit");
		$resp = array();
		if ($this->db->affected_rows()) {
			$resp['code'] = '200';
			$resp['message'] = 'Data berhasil dihapus';
		}else{
			$err = $this->db->error();
			$resp['code'] = '201';
			$resp['message'] = $err['message'];
		}
		echo json_encode($resp);
	}

	public function delete_multi()
	{
		$resp = array();
		foreach ($this->input->post('data') as $key => $value) {
			$this->db->where('unit_id',$value)->delete("ms_unit");
			$err = $this->db->error();
			if ($err['message']) {
				$resp['message'] .= $err['message']."\n";
			}
		}
		if (empty($resp['message'])) {
			$resp['code'] = '200';
			$resp['message'] = 'Data berhasil dihapus';
		}else{
			$resp['code'] = '201';
		}
		echo json_encode($resp);
	}

	public function get_employee($type)
	{
		$term = $this->input->get('term');
		$limit = 25;
		if ($type == 'pj_unit') {
			$where = " lower(emp_name) like lower('%$term%')";
			$select = "*,concat(emp_name) as label";
		} else {
			$where = " lower(emp_noktp) like lower('%$term%')";
			$select = "*,concat(emp_name) as label";
		}
		$data = $this->db->where($where)
			->limit($limit)
			->select($select, false)
			->get("employee")->result();
		echo json_encode($data);
//		return $this->db->get_where("public.employee")->result();
	}

	public function show_form()
	{
		$data['model'] = $this->m_ms_unit->rules();
		$this->load->view("ms_unit/form",$data);
	}
}
