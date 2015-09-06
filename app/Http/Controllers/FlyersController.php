<?php

namespace App\Http\Controllers;

use App\Flyer;
use App\Photo;
use App\Http\Requests\ChangeFlyerRequest;
use App\Http\Controllers\Traits\AuthorizesUsers;
use Illuminate\Http\Request;
use App\Http\Requests\FlyerRequest;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FlyersController extends Controller
{
    use AuthorizesUsers;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);

        parent::__construct();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('/flyer/create');
    }

 
    /**
     * Store a newly created resource in storage.
     *
     * @param FlyerRequest $request
     * @return Response
     */
    public function store(FlyerRequest $request)
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
        $flyer = Flyer::locatedAt($zip, $street);

        return view('flyer.show', compact('flyer'));
    }

    /**
     * Apply a photo to the referenced flyer.
     * 
     * @param string  $zip
     * @param string  $street
     * @param ChangeFlyerRequest $request
     */
    public function addPhoto($zip, $street, ChangeFlyerRequest $request)
    {
        $photo = $this->makePhoto($request->file('photo'));

        Flyer::locatedAt($zip, $street)->addPhoto($photo);
    }


   protected function makePhoto(UploadedFile $file)
   {
        // return Photo::fromForm($file)->store($file);
        return Photo::named($file->getClientOriginalName())->move($file);
   }
}
