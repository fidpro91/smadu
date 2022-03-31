<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Schedule_mp extends MY_Generator
{

	public function __construct()
	{
		parent::__construct();
		$this->datascript->lib_datepicker()
			->lib_inputmulti()
			->lib_inputmask();
		$this->load->model('m_schedule_mp');
	}

	public function index()
	{
		$this->theme('schedule_mp/index', '', get_class($this));
	}

	public function save()
	{
		$data = $this->input->post();
		// if ($this->m_schedule_mk->validation()) {
		$input = [];
		$sukses = true;
		$this->db->trans_begin();
		$respond = [];
		foreach ($data['div_detil'] as $x => $value) {
			if (empty($value['mp_id'])) {
				continue;
			}
			foreach ($this->m_schedule_mp->rules() as $r => $v) {
				$input[$x][$r] = isset($value[$r]) ? $value[$r] : null;
			}
			$input[$x]['class_id'] 	= $data['class_id'];
			$input[$x]['set_by'] 	= $this->session->user_id;
			$input[$x]['semester_id'] 	= $data['semester_id'];
			$input[$x]['tahun_pelajaran'] 	= $data['tahun_pelajaran'];
			$this->db->insert("schedule_mp", $input[$x]);
			$err = $this->db->error();
			if ($err['message']) {
				$sukses = false;
				$respond[$x]['message'] = $err['message'] . "mp_id => " . $value['mp_id'];
			}
		}
		if ($sukses == false) {
			$this->db->trans_rollback();
			$resp = [
				"code" 		=> "202",
				"message"	=> $err['message']
			];
		} else {
			$this->db->trans_commit();
			$resp = [
				"code" 		=> "200",
				"message"	=> "Data berhasil disimpan"
			];
		}
		/*}else{
			$this->session->set_flashdata('message',validation_errors('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>','</div>'));
		}*/
		$resp=json_encode($resp);
		$this->session->set_flashdata("message",$resp);
		redirect('schedule_mp');
	}

	public function get_data()
	{
		$this->load->library('datatable');
		$attr 	= $this->input->post();
		$fields = $this->m_schedule_mp->get_column();
		$data 	= $this->datatable->get_data($fields, $filter = array(), 'm_schedule_mp', $attr);
		$records["aaData"] = array();
		$no   	= 1 + $attr['start'];
		foreach ($data['dataku'] as $index => $row) {
			$obj = array($row['id_key'], $no);
			foreach ($fields as $key => $value) {
				if (is_array($value)) {
					if (isset($value['custom'])) {
						$obj[] = call_user_func($value['custom'], $row[$key]);
					} else {
						$obj[] = $row[$key];
					}
				} else {
					$obj[] = $row[$value];
				}
			}
			$obj[] = create_btnAction(["update", "delete"], $row['id_key']);
			$records["aaData"][] = $obj;
			$no++;
		}
		$data = array_merge($data, $records);
		unset($data['dataku']);
		echo json_encode($data);
	}

	public function get_mata_pelajaran()
	{
		$term = $this->input->get('term');
		$this->load->model('m_ms_mata_pelajaran');
		$limit = 25;
		$where = " lower(mata_pelajaran) like lower('%$term%')";
		$select = "*,concat(kode_mp,'-',mata_pelajaran) as label";
		// $where .= " AND unit_id = '$unit_id'";
		echo json_encode($this->m_ms_mata_pelajaran->get_ms_mata_pelajaran2($where,$select,$limit));
	}

	public function find_one($id)
	{
		$data = $this->db->where('schedule_id', $id)->get("schedule_mp")->row();

		echo json_encode($data);
	}

	public function get_multiRows()
	{
		$data = $this->m_schedule_mp->get_column_multi();
		$colauto = ["mp_id" => "Mata Pelajaran"];
		foreach ($data as $key => $value) {
			if (array_key_exists($value, $colauto)) {
				$row[] = [
					"id" => $value,
					"label" => $colauto[$value],
					"type" => 'autocomplete',
				];
			} elseif ($value == 'day') {
				$row[] = [
					"id" => $value,
					"label" => ucwords(str_replace('_', ' ', $value)),
					"type" => 'select',
					"data" => get_hari()
				];
			} elseif ($value == 'guru_id') {
				$row[] = [
					"id" => $value,
					"label" => ucwords(str_replace('_', ' ', $value)),
					"type" => 'select',
					"data" => $this->m_schedule_mp->get_dosen("emp_id as id,emp_name as text", ["emp_active" => "t"])
				];
			} else {
				$row[] = [
					"id" => $value,
					"label" => ucwords(str_replace('_', ' ', $value)),
					"type" => 'text',
				];
			}
		}
		echo json_encode($row);
	}


	public function delete_row($id)
	{
		$this->db->where('schedule_id', $id)->delete("schedule_mp");
		$resp = array();
		if ($this->db->affected_rows()) {
			$resp['code'] = '200';
			$resp['message'] = 'Data berhasil dihapus';
		} else {
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
			$this->db->where('schedule_id', $value)->delete("schedule_mp");
			$err = $this->db->error();
			if ($err['message']) {
				$resp['message'] .= $err['message'] . "\n";
			}
		}
		if (empty($resp['message'])) {
			$resp['code'] = '200';
			$resp['message'] = 'Data berhasil dihapus';
		} else {
			$resp['code'] = '201';
		}
		echo json_encode($resp);
	}

	public function show_form()
	{
		$data['model'] = $this->m_schedule_mp->rules();
		$this->load->view("schedule_mp/form_multi", $data);
	}
}