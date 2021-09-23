<?php

namespace App\Http\Controllers;

use App\Models\ResidentialProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResidentialPropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ResidentialProperty::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $residentialProperty = ResidentialProperty::create($request->all());
        return response()->json($residentialProperty, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResidentialProperty  $residentialProperty
     * @return \Illuminate\Http\Response
     */
    public function show(ResidentialProperty $residentialProperty)
    {
        return $residentialProperty;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ResidentialProperty  $residentialProperty
     * @return \Illuminate\Http\Response
     */
    public function edit(ResidentialProperty $residentialProperty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResidentialProperty  $residentialProperty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $residentialProperty = ResidentialProperty::findOrFail($id);
        $residentialProperty->update($request->all());
        return response()->json($residentialProperty, 200);
    }

    public function showWithParams(Request $request)
    {
        $query = DB::table('residential_properties');
        if ($request->has('filter')) {
            $query->where('category', 'LIKE', '%' . $request->get('filter') . '%');
        }
        if ($request->has('sort')) {
            $query->orderBy($request->get('sort'), $request->get('order'));
        }
        if ($request->has('search')) {
            $query->where(function ($query) use ($request) {
                $query->where('street', 'LIKE', '%' . $request->get('search') . '%');
                $query->orWhere('name', 'LIKE', '%' . $request->get('search') . '%');
            });
        }

        $query->select('residential_properties.*');
        $data = $query->paginate(14);
        foreach ($data as $residentialProperty) {
            $images = DB::table('fileuploads')->select('*')->where('home_id', '=', $residentialProperty->id)->get();
            $residentialProperty->images = $images;
        }
        return response()->json($data, 200);
    }
    public function getOne($id)
    {
        $residentialProperty = DB::table('residential_properties')->select('residential_properties.*')->where('residential_properties.id', '=', $id)->get();
        $images = DB::table('fileuploads')->select('*')->where('home_id', '=', $id)->get();
        foreach ($residentialProperty as $one) {
            $one->images = $images;
        }
        return response()->json($residentialProperty, 200);
    }
    public function getCategories()
    {
        return DB::table('residential_properties')->select('category')->distinct()->get();
    }
    public function delete($id)
    {
        $residentialProperty = ResidentialProperty::findOrFail($id);
        $residentialProperty->delete();

        return response()->json(null, 204);
    }
}
