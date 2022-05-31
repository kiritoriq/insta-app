<?php

namespace App\Services;

use App\Helpers\Helper;
use PHPUnit\TextUI\Help;

class GeneralService
{

    /**
     * description
     *
     * @param
     * @return
     */
    public static function validatePhone($string)
    {
        if (empty($string)) {
            return $string;
        }

        $exp = explode('@', $string);
        if (isset($exp[1])) {
            $phone = str_replace("+", "", $exp[0]);
        } else {
            $phone = str_replace("+", "", $string);
        }

        $prefix = substr(str_replace("-", "", trim($phone)), 0, 1);
        if ($prefix == 0) {
            $phone = '62' . substr($phone, 1);
        }

        return $phone;
    }

    public static function klasifikasi_surat($param)
    {
        return Helper::klasifikasi_surat($param);
    }


    public static function bentuk_surat($jenis)
    {
        return Helper::bentuk_surat($jenis);
    }

    public static function kepada_opd($keyword)
    {
        $url = env('APP_SERVICE') . '/service/get_kepala_opd/15/0/' . $keyword;

        return Helper::callAPI("GET", $url, "");
    }

    public static function pegawai_struktural_opd($keyword)
    {
        $opd = Helper::kode_opd();
        $url = env('APP_SERVICE') . '/service/get_pegawai_struktural_opd/' . $opd . '/15/0/' . $keyword;
        return Helper::callAPI("GET", $url, "");
    }

    public static function sifat_surat()
    {
        return Helper::sifat_surat();
    }

    public static function keamanan_surat()
    {
        return Helper::kemanan_surat();
    }
	
	public static function tipe_ttd()
    {
        return Helper::tipe_ttd();
    }
	
	public static function service_atasan($kolok){
		
		$data = Helper::get_atasan($kolok);
		$admin = array();
		$no = 0;
		foreach($data->data as $atasan)
		{
			$no++;
			$row = array();
			$row['no'] = $no;
			$row['nip'] = $atasan->nip;
			$row['kode_lokasi'] = $atasan->kode_lokasi;
			$row['nama_lengkap'] = $atasan->nama_lengkap;
			$row['jabatan'] = $atasan->jabatan;
			$admin[] = $row;
			if(Helper::get_admin_kolok($atasan->kode_lokasi))
			{
				$admins = Helper::get_admin_kolok($atasan->kode_lokasi);
			}
			else
			{
				$admins = Helper::get_admin_kolok(substr($kolok,0,2).'00000000');
			}
		}
		
		$no++;
		$tu = Helper::profil_pegawai($admins['nip']);
		
		$row2 = array();
		$row2['no'] = $no;
		$row2['nip'] = $tu->{'nip'};
		$row2['kode_lokasi'] = $tu->{'kode_lokasi'};
		$row2['nama_lengkap'] = $tu->{'nama_lengkap'};
		$row2['jabatan'] = $tu->{'jabatan'};
		
		$admin[] = $row2;
	
		$koordinasi = json_encode($admin);
		
		return json_decode($koordinasi);
	}
}
