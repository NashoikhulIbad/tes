<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\MAproveLoogsiswa;

class AproveLoogsiswa extends Controller
{
 public function __construct()
 {
  $this->model = new MAproveLoogsiswa();
 }
 public function save(): string
 {
  $request = request();
  $param = array();
  $results = array();
  $rs = $this->model->saveData($request->getPost());
  if (count($rs) > 0) {
   $code = $rs['code'];
  }
  return sendResponse($code, $results);
 }
 public function load(): string
 {
  $request = request();
  $param = array();
  $code = 204;
  $results = array();
  $rs = $this->model->loadData($request->getGet());
  if (count($rs) > 0) {
   $code = 200;
   $results = $rs;
  }
  return sendResponse($code, $results);
 }
 public function print(): string
 {
  $request = request();
  $param = array();
  $code = 204;
  $results = array();
  $rs = $this->model->loadData($request->getGet());
  if (count($rs) > 0) {
   $no_kunjungan = $rs[0]['no_kunjungan'];
   $tgl_entry = $rs[0]['tgl_entry'];
   $keluhan = $rs[0]['keluhan'];
   $riwayat_penyakit = $rs[0]['riwayat_penyakit'];
   $alergi = $rs[0]['alergi'];
   $level = $rs[0]['level'];
   $text_level = $rs[0]['text_level'];
   $tags =  array("{{no_kunjungan}}", "{{tgl_entry}}", "{{keluhan}}", "{{riwayat_penyakit}}", "{{alergi}}", "{{level}}", "{{text_level}}");
   $dataset = array($no_kunjungan, $tgl_entry, $keluhan, $riwayat_penyakit, $alergi, $level, $text_level);
   $outputName = "{$no_kunjungan}_anamnesis";
   $printed = printing("anamnesis", $tags, $dataset, $outputName);
   $code = $printed['code'];
   $results = $printed['results'];
  }
  return sendResponse($code, $results);
 }
}
