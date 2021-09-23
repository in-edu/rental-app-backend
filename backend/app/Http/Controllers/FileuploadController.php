<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fileupload;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;


class FileuploadController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if ($request->has('formData')) {
            $images = $request->input('formData')['files'];
            for ($i = 0; $i < sizeof($images); $i++) {
                $names[$i] = time() . '.' . explode('/', explode(':', substr($images[$i], 0, strpos($images[$i], ';')))[1])[1];
                Image::make($images[$i])->save(public_path('images/') . $names[$i]);
            }
        }

        for ($j = 0; $j < sizeOf($names); $j++) {
            $fileupload = new Fileupload();
            $fileupload->filename = $names[$j];
            $fileupload->home_id = $request->input('home_id');
            $fileupload->save();
        }
        return response()->json([
            'message' => 'file uploaded',
        ]);
    }
    public function getName($id)
    {
        return DB::table('fileuploads')->select('fileuploads.filename')->where('id', '=', $id)->get();
    }
    public function getImagesOfHome($residentialProperty_id)
    {
        $images = DB::table('fileuploads')->select('*')->where('home_id', '=', $residentialProperty_id)->get();
        return response()->json($images, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
