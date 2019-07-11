<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Http\Resources\Property as PropertyResource;

/**
 * Class APIPropsController
 * @package App\Http\Controllers\Api
 */
class APIPropsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = Property::paginate(12);

        return PropertyResource::collection($properties);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $property = new Property();

        $property->id = $request->input('id');
        $property->name = $request->input('name');
        $property->price = $request->input('price');
        $property->bedrooms = $request->input('bedrooms');
        $property->bathrooms = $request->input('bathrooms');
        $property->storeys = $request->input('storeys');
        $property->garages = $request->input('garages');

        if($property->save()) {
            return new PropertyResource($property);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $property = Property::findOrFail($id);

        return new PropertyResource($property);
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
        $property = Property::findOrFail($id);

        $property->id = $request->input('id');
        $property->name = $request->input('name');
        $property->price = $request->input('price');
        $property->bedrooms = $request->input('bedrooms');
        $property->bathrooms = $request->input('bathrooms');
        $property->storeys = $request->input('storeys');
        $property->garages = $request->input('garages');

        if($property->save()) {
            return new PropertyResource($property);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $property = Property::findOrFail($id);

        if ($property->delete()) {
            return new PropertyResource($property);
        }
    }


    /**
     * API search
     *
     * @param Request $request
     * @return  mixed - \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *          or simple json array.
     */
    public function apiSearch(Request $request)
    {
        $r = $request->all();

        $query = Property::query();

        if(request('name') !== null) {
            $query->when($r, function($query, $r)   {
                return $query->where('name', 'like', '%'.$r['name'].'%');
            });
        }
        if(request('price_min')!== null && request('price_max')!==null){
            $query->when($r, function($query, $r) {
                return $query->whereBetween('price', [$r['price_min'], $r['price_max']]);
            });
        }
        if(request('bedrooms')!== null ){
            $query->when($r, function($query, $r) {
                return $query->where('bedrooms', $r['bedrooms']);
            });
        }
        if(request('bathrooms')!== null ){
            $query->when($r, function($query, $r) {
                return $query->where('bathrooms', $r['bathrooms']);
            });
        }
        if(request('storeys')!== null ){
            $query->when($r, function($query, $r) {
                return $query->where('storeys', $r['storeys']);
            });
        }
        if(request('garages')!== null ){
            $query->when($r, function($query, $r) {
                return $query->where('garages', $r['garages']);
            });
        }

        $data = $query->get();
        //dd($data);

        if(!count($data)) {
            return response()->json(['errors'=>true ,'message' => 'No data for this request' ],404);
        }

        return PropertyResource::collection($data);
    }


}
