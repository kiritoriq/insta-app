<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;

class Helper
{

    public static function tgl($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = 'WIB')
    {
        if (trim($timestamp) == '') {
            $timestamp = time();
        } elseif (!ctype_digit($timestamp)) {
            $timestamp = strtotime($timestamp);
        }
        # remove S (st,nd,rd,th) there are no such things in indonesia :p
        $date_format = preg_replace("/S/", "", $date_format);
        $pattern = array(
            '/Mon[^day]/', '/Tue[^sday]/', '/Wed[^nesday]/', '/Thu[^rsday]/',
            '/Fri[^day]/', '/Sat[^urday]/', '/Sun[^day]/', '/Monday/', '/Tuesday/',
            '/Wednesday/', '/Thursday/', '/Friday/', '/Saturday/', '/Sunday/',
            '/Jan[^uary]/', '/Feb[^ruary]/', '/Mar[^ch]/', '/Apr[^il]/', '/May/',
            '/Jun[^e]/', '/Jul[^y]/', '/Aug[^ust]/', '/Sep[^tember]/', '/Oct[^ober]/',
            '/Nov[^ember]/', '/Dec[^ember]/', '/January/', '/February/', '/March/',
            '/April/', '/June/', '/July/', '/August/', '/September/', '/October/',
            '/November/', '/December/',
        );
        $replace = array(
            'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min',
            'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu',
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des',
            'Januari', 'Februari', 'Maret', 'April', 'Juni', 'Juli', 'Agustus', 'September',
            'Oktober', 'November', 'Desember',
        );
        $date = date($date_format, $timestamp);
        $date = preg_replace($pattern, $replace, $date);
        $date = "{$date} {$suffix}";
        return $date;
    }

    public static function getBrowser()
    {

        $agent = $_SERVER['HTTP_USER_AGENT'];
        $name = 'NA';


        if (preg_match('/MSIE/i', $agent) && !preg_match('/Opera/i', $agent)) {
            $name = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $agent)) {
            $name = 'Mozilla Firefox';
        } elseif (preg_match('/Chrome/i', $agent)) {
            $name = 'Google Chrome';
        } elseif (preg_match('/Safari/i', $agent)) {
            $name = 'Apple Safari';
        } elseif (preg_match('/Opera/i', $agent)) {
            $name = 'Opera';
        } elseif (preg_match('/Netscape/i', $agent)) {
            $name = 'Netscape';
        }

        return $name;
    }

    public static function getUserIP()
    {
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') > 0) {
                $addr = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
                return trim($addr[0]);
            } else {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    public static function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE)
    {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }

    public static function getISP()
    {
        $query = @unserialize(file_get_contents('http://ip-api.com/php/'));
        if ($query && $query['status'] == 'success') {
            return $query;
        }
    }

    public static function dd($array)
    {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
        return $array;
    }

    public static function checkAuth($id_users)
    {
        $data = DB::connection()->select(
            "SELECT
            users.id AS id_users,
            roles.group_id,
            users.username,
            `group`.name as nama_role
        FROM users
            JOIN
                roles ON roles.users_id = users.id
            JOIN
                `group` ON roles.group_id = `group`.id
        WHERE users.id = $id_users"
        );
        return $data;
    }

    public static function friendlyFilename($string)
    {
        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '_', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string);
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/'), '_', $string);
        $string = str_replace('__', '_', $string);
        return strtolower(trim($string, '_'));
    }

    public static function limit_text($text, $limit)
    {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }

    public static function callAPI($method, $url, $data)
    {
        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'APIKEY: 111111111111111111111',
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if (!$result) {
            die("Connection Failure");
        }
        curl_close($curl);
        return $result;
    }

    public static function klasifikasi_surat($search)
    {
        return DB::select("SELECT id, kode, name FROM document_class WHERE name ILIKE '%$search%' or kode ILIKE '%$search%'");
    }

    public static function bentuk_surat($jenis)
    {
        return DB::select("SELECT * FROM document_shape WHERE status = '$jenis' ORDER BY nama");
    }

    public static function sifat_surat()
    {
        $sifat = array(array("id" => 1, "name" => "Biasa"), array("id" => 2, "name" => "Segera"), array("id" => 3, "name" => "Amat Segera"));
        return  $sifat;
    }

    public static function kemanan_surat()
    {
        $keamanan = array(array("id" => 1, "name" => "Konfidensial"), array("id" => 2, "name" => "Biasa"), array("id" => 3, "name" => "Rahasia"), array("id" => 1, "name" => "Sangat Rahasia"));
        return  $keamanan;
    }
	
	public static function tipe_ttd()
    {
        $keamanan = array(array("id" => 'tdt', "name" => "Personal"), array("id" => 'an', "name" => "Atas Nama"), array("id" => 'ub', "name" => "Untuk Beliau"), array("id" => 'plt', "name" => "Plt. (Pelaksana Tugas)"), array("id"=> 'plh', "name" => "Plh. (Pelaksana Harian)"));
        return  $keamanan;
    }

    public static function kode_opd()
    {
        return  substr(Session::get('kode_lokasi'), 0, 2);
    }

    public static function user_info($id)
    {
        $user = DB::select("select users.id,users.profile,users.profile2,admin.kode_lokasi as admin from users INNER JOIN user_privilege on users.privilege = user_privilege.id LEFT JOIN admin on users.profile = admin.nip WHERE users.id = $id and users.status = '1' and user_privilege.status = '1'");

        return $user;
    }

    public static function profil_pegawai($id_pegawai, $field = '')
    {
        $nip = '';
        $tampil_nip = '';
        $nik = '';
        $tampil_nik = '';
        $nama_lengkap = '';
        $tempat_lahir = '';
        $tanggal_lahir = '';
        $alamat = '';
        $jabatan = '';
        $kode_lokasi = '';
        $unit = '';
        $kode_opd = '';
        $opd = '';
        $kode_golongan = '';
        $golongan = '';
        $pangkat = '';
        $kode_eselon = '';
        $eselon = '';
        $foto = '';
        $kota = '';

        $url = env('APP_SERVICE') . '/service/get_pegawai_nip/' . $id_pegawai;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        if ($response) {
            $obj = json_decode($response);
            $nip = $obj->{'nip'};
            $tampil_nip = $obj->{'tampil_nip'};
            $nik = $obj->{'nik'};
            $tampil_nik = $obj->{'tampil_nik'};
            $nama_lengkap = $obj->{'nama_lengkap'};
            $tempat_lahir = $obj->{'tempat_lahir'};
            $tanggal_lahir = $obj->{'tanggal_lahir'};
            $alamat = $obj->{'alamat'};
            $jabatan = $obj->{'jabatan'};
            $kode_lokasi = $obj->{'kode_lokasi'};
            $unit = $obj->{'unit'};
            $kode_opd = $obj->{'kode_opd'};
            $opd = $obj->{'opd'};
            $kode_golongan = $obj->{'kode_golongan'};
            $golongan = $obj->{'golongan'};
            $pangkat = $obj->{'pangkat'};
            $kode_eselon = $obj->{'kode_eselon'};
            $eselon = $obj->{'eselon'};
            $foto = $obj->{'foto'};
            $kota = $obj->{'kota'};
        }

        switch ($field) {
            case 'nip':
                return $nip;
                break;
            case 'tampil_nip':
                return $tampil_nip;
                break;
            case 'nik':
                return $nik;
                break;
            case 'tampil_nik':
                return $tampil_nik;
                break;
            case 'nama_lengkap':
                return $nama_lengkap;
                break;
            case 'alamat':
                return $alamat;
                break;
            case 'jabatan':
                return $jabatan;
                break;
            case 'kode_lokasi':
                return $kode_lokasi;
                break;
            case 'unit':
                return $unit;
                break;
            case 'kode_opd':
                return $kode_opd;
                break;
            case 'opd':
                return $opd;
                break;
            case 'kode_golongan':
                return $kode_golongan;
                break;
            case 'golongan':
                return $golongan;
                break;
            case 'pangkat':
                return $pangkat;
                break;
            case 'kode_eselon':
                return $kode_eselon;
                break;
            case 'eselon':
                return $eselon;
                break;
            case 'foto':
                return $foto;
                break;
            case 'kota':
                return $kota;
                break;
            default:
                return $obj;
                break;
        }
    }
	
	public static function get_admin_kolok($kolok)
	{
		$admin = DB::select("SELECT * from admin WHERE kode_lokasi = '$kolok'");
		
		return $admin;
	}
	
	public static  function get_atasan($kolok)
	{
	    $url = env('APP_SERVICE') .'/service/get_atasan/'.$kolok;

		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
		$resp = json_decode($response);

		return $resp;
	}

    public static function getCapil()
    {
        $data = array(
            'nik'       => $nik,
            'user_id'   => $userId,
            'password'  => $password,
            'ip_user'   => $ip
        );

        $data_string = json_encode($data);


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-type: application/json',
                'accept: application/json'
            )
        );
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15); //timeout in seconds

        $output = curl_exec($ch);
        $result = $output;
        if($output == false or $output != 0){
            $result = json_encode($output);
        }
        DB::table('api_capil_log')->insert([
            'id'         => Str::uuid()->toString(),
            'nik'        => $nik,
            'result'     => $result,
            'created_at' => now()
        ]);
        curl_close($ch);
        if($output == false) {
            return 'Api Capil Sedang Bermasalah Mohon dicoba kembali 5-10 menit lagi !';
        }
        return $output;
    }

    public static function formatTanggalPanjang($tanggal) {
        if(substr($tanggal, 0,9) != '00-00-000' || substr($tanggal, 0,9) != ''){
            $aBulan = array(1=> "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
            list($thn,$bln,$tgl)=explode("-",$tanggal);
            $bln = (($bln >0 ) && ($bln < 10))? substr($bln,1,1): $bln ;
            return $tgl." ".$aBulan[$bln]." ".$thn;
        }else{
            return '';
        }
    }

}
