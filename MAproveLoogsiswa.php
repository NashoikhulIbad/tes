<?php
namespace App\Models;
use CodeIgniter\Model;

class MAproveLoogsiswa extends Model
{
 protected function getCounter($params) {
  $strquery = "select counter from pendidikan.app_loogsiswa where kd_user = ? and no_registrasikunjungan = ? order by counter desc limit 1";
  $rs = $this->db->query($strquery, $params);
  $number = 1;
  if ($rs->getNumRows() > 0) $number = $rs->getResultArray()[0]['counter'] + 1;
  return $number;
 }
 public function saveData($dataset) {
  $zona = intval(getenv('app.zona'));
  try {
   $tgl_entry = gmdate("Y-m-d H:i:s", time() + 60 * 60 * $zona);
   $nama_siswa = $dataset['nama_siswa'];
   $kd_user = $dataset['kd_user'];
  } catch (\Exception $e) {
   return array("code" => 400);
  } 
  $params = array($tgl_entry, $nama_siswa, $kd_user);
  $strquery = "insert into pendidikan.app_loogsiswa (tgl_entry,nama_siswa,kd_user) values(?,?,?)";
  $this->db->transBegin();
  $this->db->query($strquery, $params);
  if ($this->db->transStatus() === false && $this->db->error()) {
   $this->db->transRollback();
   $result = array("code" => 304);
  }else {
   $this->db->transCommit();
   $result = array("code" => 200);
  }
  return $result;  
 }
 public function loadData($dataset) {
  $params = array();
  $arrfilters = array();
  $strfilters = "";
  if (isset($dataset['single_id'])) {
   array_push($params, $dataset['single_id']);
   array_push($arrfilters, "single_id = ?");
  }
  if (isset($dataset['no_kunjungan'])) {
   array_push($params, $dataset['no_kunjungan']);
   array_push($arrfilters, "no_registrasikunjungan = ?");
  }
  if (count($params) > 0) $strfilters = " where ".implode(" and ", $arrfilters);
  $strquery = "select tgl_entry,nama_siswa,kd_user from pendidikan.app_loogsiswa{$strfilters} order by tgl_entry desc limit 1";
  $res = $this->db->query($strquery, $params);
  return $res->getResultArray();
 }
}