<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Goutte\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;

class ItemController extends Controller
{
    public function save(Request $request): HttpResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'url' => 'required',
            'imageUrl' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }else{
            //check if item exists
            $item = Item::firstOrNew([ 
                'url' => $request->input('url'),
            ]);

            $item->name = $request->input('name');
            $item->price = $request->input('price');
            $item->imageUrl = $request->input('imageUrl');
            $item->save();

            return response('Item has been saved to the database!', 200);
        }
    }

    public function update(int $id): JsonResponse
    {
        $item = Item::find($id);
        $url = $item->url;

        $client = new Client();
        $crawler = $client->request('GET', $url);
        //get rid of € symbol and change ',' to '.'
        $price = preg_replace('/[,]/', '.', preg_replace('/[^0-9.,]/', '', $crawler->filter('.card__price')->first()->text()));

        //save to database new price 
        $item->price = $price;
        $item->save();

        return response()->json(['price' => $price], HttpResponse::HTTP_OK);
    }

    public function show()
    {
        return Item::all();
    }
}
