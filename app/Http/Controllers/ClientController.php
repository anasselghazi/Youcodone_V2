<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;

class ClientController extends Controller
{
    public function index(Request $request)
{
     $ville = $request->input('q');

     $restaurants = Restaurant::query()
        ->when($ville, function($query, $ville) {
             return $query->where('ville', 'like', "%$ville%");
        })
        ->paginate(9)    
        ->withQueryString();              

     return view('client.explore', compact('restaurants'));
}
    public function toggleFavorite($restaurantId)
    {
        if(auth()->user()->role !='client'){
            return back()->with('error' , 'Clients seulement');

        }
        
         auth()->user()->favorites()->toggle($restaurantId);
         return back();
    }
     public function create($id)
{
    
    $restaurant = Restaurant::findOrFail($id);
    return view('client.create', compact('restaurant'));
}

public function store(Request $request, $id)
{
    $restaurant = Restaurant::findOrFail($id);

    
    if ($restaurant->en_maintenance) {
        return back()->with('erreur', 'Désolé, ce restaurant est en maintenance.');
    }

    $deja_reserve = Reservation::where('restaurant_id', $id)
        ->where('date_res', $request->date_res)
        ->sum('nombre_personnes');

    $places_disponibles = $restaurant->capacite - $deja_reserve;

    if ($request->nombre_personnes > $places_disponibles) {
        return back()->with('erreur', "Places insuffisantes. Il reste uniquement $places_disponibles places.");
    }

    
    Reservation::create([
        'user_id' => auth()->id(),
        'restaurant_id' => $id,
        'date_res' => $request->date_res,
        'nombre_personnes' => $request->nombre_personnes,
    ]);

    return redirect()->route('dashboard')->with('succes', 'Réservation effectuée !');
}
}