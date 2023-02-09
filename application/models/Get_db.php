<?php

class Get_db extends CI_Model {

    public function get_menu($id=0)
    {
      $datam = $this->db->where(['menu_parent_id'=>$id,'ga.group_id'=>3,'m.menu_status'=>'t'])
                        ->join("group_access ga","ga.menu_id = m.menu_id")
                        ->order_by('menu_code')
                        ->get('ms_menu m')->result();
      $menux='';
      foreach ($datam as $key => $value) {
          if ($this->db->where('menu_parent_id',$value->menu_id)->get('ms_menu')->num_rows() > 0) {
            /*$menux[]['menu_name'] = [
                              $value->menu_name,
                              "child"=>get_menu($value->menu_id)
                            ];*/
            $menux .= "<li class=\"has-sub\"><a href=\"#\">
                              <i class=\"".(!empty($value->menu_icon)?$value->menu_icon:'fa fa-circle-o')."\"></i> <span>$value->menu_name</span>
                            </a>
                            <ul class=\"\">";
            $menux .= $this->get_menu($value->menu_id);
            $menux .= "</ul></li>";
          }else{
            // $menux[]['menu_name'] = $value->menu_name;
            $menux .= "<li><a href=\"".base_url(($value->menu_url??"#"))."\">
                      <i class=\"".(!empty($value->menu_icon)?$value->menu_icon:'fa fa-circle-o')."\"></i> <span>$value->menu_name</span>
                    </a></li>";
          }
      }
      return $menux;
    }

    public function get_menu_mahasiswa($id=0)
    {
      /* $datam = $this->db->where(['menu_parent_id'=>$id,'ga.group_id'=>1,'ga.modul_id'=>2])
                        ->join("ms_group_user_access ga","ga.menu_id = m.menu_id")
                        ->order_by('menu_code')
                        ->get('ms_menu m')->result(); */
      $datam = $this->db->where(['menu_parent_id'=>$id,'m.modul_id'=>2])
                        ->order_by('menu_code')
                        ->get('ms_menu m')->result();
      $menux='';
      foreach ($datam as $key => $value) {
          if ($this->db->where('menu_parent_id',$value->menu_id)->get('ms_menu')->num_rows() > 0) {
            /*$menux[]['menu_name'] = [
                              $value->menu_name,
                              "child"=>get_menu($value->menu_id)
                            ];*/
            $menux .= "<li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                              $value->menu_name <span class=\"caret\"></span>
                            </a>
                            <ul class=\"dropdown-menu\" role=\"menu\">";
            $menux .= $this->get_menu_mahasiswa($value->menu_id);
            $menux .= "</ul></li>";
          }else{
            // $menux[]['menu_name'] = $value->menu_name;
            $menux .= "<li><a href=\"".base_url($value->menu_url)."\">
                      $value->menu_name
                    </a></li>";
          }
      }
      return $menux;
    }

    public function validation_access($id,$url)
    {
      $cek_akses= $this->db->where(["group_id"=>$id])
                            ->where("menu_url like '%$url%'",null)
                            ->join("ms_menu m","m.menu_id=ga.menu_id")
                            ->get("group_access ga")->num_rows();

      return $cek_akses;
    }
}
