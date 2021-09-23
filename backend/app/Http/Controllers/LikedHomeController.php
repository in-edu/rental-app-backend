<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResidentialProperty;
use App\Models\LikedHome;
use Illuminate\Support\Facades\DB;

class LikedHomeController extends Controller
{
    public function index()
    {
        return LikedHome::all();
    }
    public function store(Request $request)
    {
        $likedHomeId = DB::table('liked_apartments')->insertGetId(['user_id' => $request->input('user_id'), 'home_id' => $request->input('home_id')]);
        $likedHome = DB::table('residential_properties')->join('liked_apartments', 'residential_properties.id', '=', 'liked_apartments.home_id')->join('users', 'liked_apartments.user_id', '=', 'users.id')->select('residential_properties.*')->where('liked_apartments.id', '=', $likedHomeId)->get();
        $images = DB::table('fileuploads')->select('*')->where('home_id', '=', $request->input('home_id'))->get();
        $likedHome->images = $images;
        return response()->json($likedHome, 201);
    }
    public function getAllLikedHomesOfUser(Request $request)
    {
        $user_id = $request->input('user_id');
        $likedHomes = DB::table('residential_properties')->join('liked_apartments', 'residential_properties.id', '=', 'liked_apartments.home_id')->select('residential_properties.*')->where('liked_apartments.user_id', '=', $user_id)->get();
        // $likedHomesId = DB::table('homes')->join('liked_apartments', 'homes.id', '=', 'liked_apartments.home_id')->select('homes.id')->where('liked_apartments.user_id', '=', $user_id)->get();
        foreach ($likedHomes as $liked) {
            $images = DB::table('fileuploads')->select('*')->where('home_id', '=', $liked->id)->get();
            $liked->images = $images;
        }
        return response()->json($likedHomes, 200);
    }
    public function deleteLikedApartment(Request $request)
    {
        $user_id = $request->input('user_id');
        $home_id = $request->input('home_id');
        if ($home_id == "") {
            DB::table('liked_apartments')->where('user_id', '=', $user_id)->delete();
            return response()->json(null, 204);
        }
        DB::table('liked_apartments')->where('user_id', '=', $user_id)->where('home_id', '=', $home_id)->delete();
        $likedHomes = DB::table('residential_properties')->join('liked_apartments', 'residential_properties.id', '=', 'liked_apartments.home_id')->select('residential_properties.*')->where('liked_apartments.user_id', '=', $user_id)->get();
        // $likedHomes = DB::table('homes')->join('liked_apartments', 'homes.id', '=', 'liked_apartments.home_id')->select('homes.*')->where('liked_apartments.user_id', '=', $user_id)->get();
        return response()->json($likedHomes, 200);
    }
}
