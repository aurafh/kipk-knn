<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $table            = 'prodi';
    protected $primaryKey       = 'id_prodi';
    protected $useTimestamps = true;
    protected $allowedFields    = ['nama_prodi', 'nilai_atribut_prodi'];

    public function getProdi($id_prodi = false)
    {
        if ($id_prodi == false) {
            return $this->findAll();
        }
        return $this->where(['id_prodi' => $id_prodi])->first();
    }
    public function search($searching)
    {
        return $this->table('prodi')->like('nama_prodi', $searching)->orLike('nilai_atribut_prodi', $searching);
    }
    public function deleteMultiple($item_ids)
    {
        $this->db->table('prodi')->where('id_prodi', $item_ids)->delete($item_ids);
    }
}
