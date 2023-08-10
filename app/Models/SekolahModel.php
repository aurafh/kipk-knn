<?php

namespace App\Models;

use CodeIgniter\Model;

class SekolahModel extends Model
{
    protected $table            = 'asal_sekolah';
    protected $primaryKey       = 'id_sekolah';
    protected $useTimestamps = true;
    protected $allowedFields    = ['jenis_sekolah', 'nilai_atribut'];

    public function getSekolah($id_sekolah = false)
    {
        if ($id_sekolah == false) {
            return $this->findAll();
        }
        return $this->where(['id_sekolah' => $id_sekolah])->first();
    }
    public function deleteMultiple($item_ids)
    {
        $this->db->table('asal_sekolah')->where('id_sekolah', $item_ids)->delete($item_ids);
    }
}
