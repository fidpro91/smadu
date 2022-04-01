<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class CI_Datascript 
{
	public $folder_js,$folder_css,$CI,$js,$css,$combine;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->config->item('my_library');
		$this->folder_css = base_url()."assets/";
		$this->folder_js = base_url()."assets/";
		$this->default_library();
		$this->lib_select2();
	}

	public function default_library()
	{
		$this->css .= '<link rel="stylesheet" href="'.$this->folder_css.'js/datatables/datatables.css">'."\n";
		/* $this->js .= '<script src="'.$this->folder_js.'js/datatables/datatables.js"></script>'."\n"; */
		$this->js .= '<script src="'.$this->folder_js.'js/datatables/DataTables-1.10.9/js/jquery.dataTables.min.js"></script>'."\n";
		$this->js .= '<script src="'.$this->folder_js.'js/breadcumb/breadcumb.js"></script>'."\n";
		$this->js .= '<script src="'.$this->folder_js.'js/jquery.validate.min.js"></script>'."\n";
		$this->combine = $this->css."\n\n\n".$this->js;
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;
	}

	public function lib_datepicker()
	{
		$this->combine .= '<link rel="stylesheet" href="'.$this->folder_css.'js/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'js/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;
	}

	public function lib_inputmulti()
	{
		$this->combine .= '<script src="'.$this->folder_js.'js/input-multi-row.js"></script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;
	}

	public function lib_switchbutton()
	{
		$this->combine .= '<link rel="stylesheet" href="'.$this->folder_css.'plugins/bootstrap-switch-master/dist/css/bootstrap3/bootstrap-switch.css">'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'plugins/bootstrap-switch-master/dist/js/bootstrap-switch.js"></script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;
	}

	public function lib_daterange()
	{
		$this->combine .= '<link rel="stylesheet" href="'.$this->folder_css.'bower_components/bootstrap-daterangepicker/daterangepicker.css">'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'bower_components/moment/min/moment.min.js"></script>'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;
	}

	public function lib_inputMask()
	{
		// $this->combine .= '<script src="'.$this->folder_js.'plugins/input-mask/dist/inputmask.js"></script>'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'js/input-mask/dist/jquery.inputmask.js"></script>'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'js/input-mask/dist/bindings/inputmask.binding.js"></script>'."\n";
		$this->combine .= '<script>
		Inputmask.extendAliases({
			  "IDR": {
			    alias: "decimal",
			    allowMinus: false,
				radixPoint: ",",
				autoGroup: true,
				groupSeparator: ".",
				groupSize: 3,
				autoUnmask: true,
				removeMaskOnSubmit:true
			  }
			});
		</script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;
	}

	public function lib_select2()
	{
		$this->combine .= '<link rel="stylesheet" href="'.$this->folder_css.'assets/js/select2/select2.css">'."\n";
		$this->combine .= '<link rel="stylesheet" href="'.$this->folder_css.'assets/js/select2/select2-bootstrap.css">'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'assets/js/select2/select2.min.js"></script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;
	}

	public function lib_morrischart()
	{
		$this->combine .= '<link rel="stylesheet" href="'.$this->folder_css.'bower_components/morris.js/morris.css">'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'bower_components/raphael/raphael.min.js"></script>'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'bower_components/morris.js/morris.min.js"></script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;
	}

	public function lib_daterangePicker()
	{
		$this->combine .= '<link rel="stylesheet" href="'.$this->folder_css.'bower_components/bootstrap-daterangepicker/daterangepicker.css">'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;
	}

	public function lib_jstree()
	{
		$this->combine .= '<link rel="stylesheet" href="'.$this->folder_css.'plugins/jstree_ver1/themes/classic/style.css">'."\n";
		$this->combine .= '<script src="'.$this->folder_js.'plugins/jstree_ver1/jquery.jstree.js"></script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;

	}

	public function lib_datatableExt()
	{
		$this->combine .= '<script src="'.$this->folder_js.'plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
		<script src="'.$this->folder_js.'plugins/datatables-buttons/js/buttons.print.min.js"></script>
		<script src="'.$this->folder_js.'plugins/jszip/jszip.min.js"></script>
		<script src="'.$this->folder_js.'plugins/pdfmake/pdfmake.min.js"></script>
		<script src="'.$this->folder_js.'plugins/pdfmake/vfs_fonts.js"></script>
		<script src="'.$this->folder_js.'plugins/datatables-buttons/js/buttons.html5.min.js"></script>'."\n";
		$this->CI->config->set_item('my_library',$this->combine);
		return $this;

	}
	/*public function __toString()
	  {
	      return $this->CI->config->item('my_library');
	  }*/

}