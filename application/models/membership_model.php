<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bidon
 * Date: 07.06.12
 * Time: 15:17
 * To change this template use File | Settings | File Templates.
 */

class Membership_model extends CI_Model{

    public function validate()
    {
        $this->db->where('username',$this->input->post('username'));
        $this->db->where('password',md5($this->input->post('password')));
        $query = $this->db->get('members');
        if($query->num_rows() == 1)
        {
            $id_row = $query->row();
            $id_user = $id_row->id;
            return $id_user;
        }
        return FALSE;
    }

    public function create_member($activation_key)
    {
        $new_member_insert_data = array(
            'first_name'=>$this->input->post('first_name'),
            'last_name'=>$this->input->post('last_name'),
            'email_address'=>$this->input->post('email_address'),
            'username'=>$this->input->post('username'),
            'password'=>md5($this->input->post('password')),
            'activation_key'=>$activation_key
        );

        $insert = $this->db->insert('members',$new_member_insert_data);
        return $insert;
    }

    public function activate_user($activation_key)
    {
        $this->db->where('activation_key',$activation_key);
        $query = $this->db->get('members');
        if($query->num_rows() == 1)
        {
            $this->db->where('activation_key',$activation_key);
            $data = array('activation_key'=> NULL);
            $this->db->update('members',$data);
            return TRUE;
        }
        else
            return FALSE;

    }




}