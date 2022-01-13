<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_lingkungan_lat_long extends CI_Model
{
    private $table="lingkungan_lat_long";

    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        $data = $this->db->get($this->table)->result();

		$result = array();
        if($data){
            foreach ($data as $d) {
                $result[$d->location_id][$d->lingkungan_number][] = $d;
            }
        }
        return $result;

    }

    public function add($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function add_batch($data)
    {
        return $this->db->insert_batch($this->table, $data);
    }

    public function get($id)
    {
        $this->db->where($id);
        return $this->db->get($this->table)->row();
    }

    public function result($id)
    {
        $this->db->where($id);
        $data = $this->db->get($this->table)->result();

		$result = array();
        if($data){
            foreach ($data as $d) {
                $result[$d->location_id][$d->lingkungan_number][] = $d;
            }
        }

        return $result;
    }

    public function update($id, $data)
    {
        $this->db->where($id);
        $this->db->update($this->table,$data);
    }

    public function delete($id)
    {
        $this->db->where($id);
        $this->db->delete($this->table);
    }
    
}
