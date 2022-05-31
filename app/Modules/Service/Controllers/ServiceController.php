<?php

namespace App\Modules\Service\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GeneralService;

class ServiceController extends Controller
{

    private $generalService;

    public function __construct(GeneralService $generalService)
    {
        $this->generalService = $generalService;
        $this->middleware('auth');
    }

    public function get_klasifikasi_surat(Request $req)
    {
        $param = $req->keyword;
        $data = $this->generalService->klasifikasi_surat($param);
        return $data;
    }

    public function get_bentuk_surat($id)
    {
        $param = $id;
        $data = $this->generalService->bentuk_surat($param);
        return $data;
    }


    public function get_kepada_opd(Request $req)
    {
        $param = $req->keyword;
        $data = $this->generalService->kepada_opd($param);
        return $data;
    }

    public function get_pegawai_struktural_opd(Request $req)
    {
        $param = $req->keyword;
        $data = $this->generalService->pegawai_struktural_opd($param);
        return $data;
    }

    public function get_sifat_surat()
    {
        $data = $this->generalService->sifat_surat();
        return $data;
    }

    public function get_keamanan_surat()
    {
        $data = $this->generalService->keamanan_surat();
        return $data;
    }
	
	public function get_tipe_ttd()
    {
        $data = $this->generalService->tipe_ttd();
        return $data;
    }
}
