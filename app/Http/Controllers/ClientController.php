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
    public function storeReservation(Request $request, $id) {
     $restaurant = Restaurant::findOrFail($id);

     if ($restaurant->en_maintenance) {
        return back()->with('error', 'Désolé, le restaurant est fermé pour maintenance');
    }

     $already_booked = Reservation::where('restaurant_id', $id)
                        ->where('date_reservation', $request->date_reservation)
                        ->sum('nombre_personnes');

    $remaining_seats = $restaurant->capacite - $already_booked;

     if ($request->nombre_personnes > $remaining_seats) {
        return back()->with('error', "Il n’y a pas assez de places disponibles. Restant : $remaining_seats");
    }

     Reservation::create([
        'user_id' => auth()->id(),
        'restaurant_id' => $id,
        'date_reservation' => $request->date_reservation,
        'heure_reservation' => $request->heure_reservation,
        'nombre_personnes' => $request->nombre_personnes
    ]);

    return back()->with('success', 'Réservation effectuée avec succès !');
}
}
