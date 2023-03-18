<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Http\Requests\Admin\Property as PropertyRequest;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\Storage;
use App\Support\Cropper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (!Auth::user()->hasPermissionTo('Listar Imóveis')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $properties = Property::orderBy('id', 'DESC')->get();
        return view('admin.properties.index', [
            'properties' => $properties
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (!Auth::user()->hasPermissionTo('Cadastrar Imóveis')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $users = User::orderBy('name')->get();
        return view('admin.properties.create', [
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyRequest $request) {
        if (!Auth::user()->hasPermissionTo('Cadastrar Imóveis')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $createProperty = Property::create($request->all());
        $createProperty->setSlug();
        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);
        if ($validator->fails() === true) {
            return redirect()->back()->withInput()
                            ->with(['message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.', 'type' => 'danger', 'icon' => 'exclamation-triangle']);
        }
        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $propertyImage = new PropertyImage();
                $propertyImage->property = $createProperty->id;
                $propertyImage->path = $image->storeAs('properties/' . $createProperty->id, Str::slug($request->title) . '-' . str_replace('.', '', microtime(true)) . '.' . $image->extension());
                $propertyImage->save();
                unset($propertyImage);
            }
        }
        return redirect()->route('admin.properties.edit', [
                    'property' => $createProperty->id
                ])->with(['message' => 'Imóvel criado com sucesso!', 'type' => 'success', 'icon' => 'check']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if (!Auth::user()->hasPermissionTo('Editar Imóveis')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $property = Property::where('id', $id)->first();
        if (empty($property->id)) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $users = User::orderBy('name')->get();
        return view('admin.properties.edit', [
            'property' => $property,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PropertyRequest $request, $id) {
          if (!Auth::user()->hasPermissionTo('Editar Imóveis')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $property = Property::where('id', $id)->first();
        if (empty($property->id)) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $property->fill($request->all());

        $property->setSaleAttribute($request->sale);
        $property->setRentAttribute($request->rent);
        $property->setAirConditioningAttribute($request->air_conditioning);
        $property->setBarAttribute($request->bar);
        $property->setLibraryAttribute($request->library);
        $property->setBarbecueGrillAttribute($request->barbecue_grill);
        $property->setAmericanKitchenAttribute($request->american_kitchen);
        $property->setFittedKitchenAttribute($request->fitted_kitchen);
        $property->setPantryAttribute($request->pantry);
        $property->setEdiculeAttribute($request->edicule);
        $property->setOfficeAttribute($request->office);
        $property->setBathtubAttribute($request->bathtub);
        $property->setFirePlaceAttribute($request->fireplace);
        $property->setLavatoryAttribute($request->lavatory);
        $property->setFurnishedAttribute($request->furnished);
        $property->setPoolAttribute($request->pool);
        $property->setSteamRoomAttribute($request->steam_room);
        $property->setViewOfTheSeaAttribute($request->view_of_the_sea);

        $property->save();

        $property->setSlug();

        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if ($validator->fails() === true) {
            return redirect()->back()->withInput()
                            ->with(['message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.', 'type' => 'danger', 'icon' => 'exclamation-triangle']);
        }

        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $propertyImage = new PropertyImage();
                $propertyImage->property = $property->id;
                $propertyImage->path = $image->storeAs('properties/' . $property->id, Str::slug($request->title) . '-' . str_replace('.', '', microtime(true)) . '.' . $image->extension());
                $propertyImage->save();
                unset($propertyImage);
            }
        }

        return redirect()->route('admin.properties.edit', [
                    'property' => $property->id
                ])->with(['message' => 'Imóvel atualizado com sucesso!', 'type' => 'success', 'icon' => 'check']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
          if (!Auth::user()->hasPermissionTo('Remover Imóveis')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $property = Property::where('id', $id)->first();
        if (empty($property->id)) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $property->delete();
        return redirect()->route('admin.properties.index')->with(['message' => 'Imóvel removido com sucesso!', 'type' => 'success', 'icon' => 'trash']);
    }

    public function imageSetCover(Request $request) {
        $imageSetCover = PropertyImage::where('id', $request->image)->first();
        $allImage = PropertyImage::where('property', $imageSetCover->property)->get();
        foreach ($allImage as $image) {
            $image->cover = null;
            $image->save();
        }
        $imageSetCover->cover = true;
        $imageSetCover->save();
        $json = [
            'success' => true
        ];
        return response()->json($json);
    }

    public function imageRemove(Request $request) {
        $imageDelete = PropertyImage::where('id', $request->image)->first();
        Storage::delete($imageDelete->path);
        Cropper::flush($imageDelete->path);
        $imageDelete->delete();
        $json = [
            'success' => true
        ];
        return response()->json($json);
    }

}
