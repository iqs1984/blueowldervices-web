<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    //
    public function vendors(Request $request)
    {
        $vendors = User::with('services.offers')->where('role', 'vendor')->orderBy('id', 'DESC')->paginate(10);
        return view('vendors', [
            'vendors' => $vendors
        ]);
    }


    public function vendordetail(Request $request)
    {
        $service = User::with(['services.offers','images','employees'])->findOrFail(Request()->id);
//        return $service;
//        exit();
        return view('vendors-details', [
            'service' => $service
        ]);

    }
}
