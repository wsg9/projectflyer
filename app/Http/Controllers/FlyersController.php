<?php

namespace App\Http\Controllers;

use App\Flyer;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Requests\FlyerRequest;
use App\Http\Controllers\Controller;

class FlyersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('flyers/create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        Flyer::create($request->all());

        flash()->success('Success!', 'Your flyer has been created.');

        return redirect()->back(); // temp
    }


    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show($zip, $street)
    {
        $flyer = Flyer::locatedAt($zip, $street)->first();

        return view('flyers.show', compact('flyer'));
    }

    /**
     * Apply a photo to the referenced flyer.
     * 
     * @param string  $zip
     * @param string  $street
     * @param Request $request
     */
    public function addPhoto($zip, $street, Request $request)
    {
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png,bmp'
            ]);

        $photo = $this->makePhoto($request->file('photo'));

        Flyer::locatedAt($zip, $street)->addPhoto($photo);
    }

   protected function makePhoto(UploadedFile $file)
   {
    return Photo::named($file->getClientOriginalName())->move($file);
   }
}
