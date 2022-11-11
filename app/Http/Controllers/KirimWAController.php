<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\apiKirimWa;
use App\Models\KirimWA;

class KirimWAController extends Controller
{
    public function addDevice(Request $request)
    {
        $apiKirimWa = new apiKirimWa();
        $name = $request->nama;
        $response = $apiKirimWa->addDevice($name);
        return $response;
    }

    public function getDevices()
    {
        $apiKirimWa = new apiKirimWa();
        $response = $apiKirimWa->getDevices();
        return $response;
    }

    public function qrCode(Request $request)
    {
        $apiKirimWa = new apiKirimWa();
        $id = $request->id;
        $response = $apiKirimWa->qrCode($id);
        $response = json_decode($response['body'], true);
        return $response['image_url'];
    }

    public function sendMessage(Request $request)
    {
        $data = KirimWA::where('id', $request->id)->first();
        $apiKirimWa = new apiKirimWa();
        $number = $data->no_wa;
        $gelar = $data->gelar;
        $gelar2 = $gelar ? strtolower($gelar) . '-' : '';
        $nama = $data->nama;
        $namaStrip = str_replace(' ', '-', strtolower($nama));
        $message = "بِسْــــــــــــــــــمِ اللهِ الرَّحْمَنِ الرَّحِيْمِ\n\nAssalamualaikum wr.wb\n\nYth. $gelar $nama\n\nTanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i, untuk menghadiri acara pernikahan kami.\n\n*Berikut link undangan kami*, untuk info lengkap dari acara bisa kunjungi :\n\nhttps://neshatriyo.com/?to=$gelar2$namaStrip\n\nMerupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.\n\n*NB:*\nE-Invitation ini merupakan undangan resmi dari Kami, karena ketidakmampuan jarak dan waktu, kami mohon maaf apabila menyampaikan undangan melalui media sosial ini. Semoga tidak mengurangi makna serta isinya.\n\nDan karena suasana masih pandemi diharapkan untuk *tetap menggunakan masker dan datang pada jam yang telah ditentukan.*\n\n*Hormat Kami,*\n_Nesha & Satriyo_\n\nTerima kasih banyak atas perhatiannya.\n\n_Wassalamualaikum Warahmatullahi Wabarakatuh_";
        $response = $apiKirimWa->sendMessage($number, $message);

        $data->terkirim = $data->terkirim + 1;
        $data->save();

        return redirect()->route('index');
    }

    public function getGroups()
    {
        $apiKirimWa = new apiKirimWa();
        $response = $apiKirimWa->getGroups();
        $response = json_decode($response['body'], true);
        return $response;
    }

    public function getGroupDetail(Request $request)
    {
        $apiKirimWa = new apiKirimWa();
        $id = $request->id; // group id 6285719734940-1477291265
        $response = $apiKirimWa->getGroupDetail($id);
        $response = json_decode($response['body'], true);
        return $response;
    }

    public function index()
    {
        $kirimwa = KirimWA::all();
        return view('kirimwa', compact('kirimwa'));
    }

    public function addData(Request $request)
    {
        $kirimwa = new KirimWA();
        $kirimwa->no_wa = $request->no_wa;
        $kirimwa->nama = $request->nama;
        $kirimwa->gelar = $request->gelar;
        $kirimwa->save();
        return redirect()->route('index');
    }

    public function deleteData($id)
    {
        $kirimwa = KirimWA::find($id);
        $kirimwa->delete();
        return redirect()->route('index');
    }

    public function editData($id)
    {
        $kirimwa = KirimWA::find($id);
        return view('edit', compact('kirimwa'));
    }

    public function updateData(Request $request)
    {
        $kirimwa = KirimWA::find($request->id);
        $kirimwa->no_wa = $request->no_wa ?? $kirimwa->no_wa;
        $kirimwa->nama = $request->nama ?? $kirimwa->nama;
        $kirimwa->gelar = $request->gelar ?? $kirimwa->gelar;
        $kirimwa->save();
        return redirect()->route('index');
    }

    public function importData(Request $request)
    {
        $file = $request->file('file');
        $nama_file = storage_path('app/public/') . $file->getClientOriginalName();
        $file->move(storage_path('app/public/'), $file->getClientOriginalName());
        $getFile = file_get_contents($nama_file);
        $data = json_decode($getFile);

        foreach ($data as $value) {
            $kirimwa = new KirimWA();
            $kirimwa->no_wa = $value->nowa;
            $kirimwa->nama = $value->nama;
            $kirimwa->save();
        }

        return redirect()->route('index');




    }

}
