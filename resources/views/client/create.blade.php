 <x-app-layout>
    <div class="max-w-xl mx-auto py-10">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Réserver chez {{ $restaurant->name }}</h2>
            
            <form action="{{ route('reservation.store', $restaurant->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1">Date :</label>
                    <input type="date" name="date_res" class="w-full border rounded p-2" required min="{{ date('Y-m-d') }}">
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Nombre de personnes :</label>
                    <input type="number" name="nombre_personnes" class="w-full border rounded p-2" required min="1">
                </div>
                <a href="{{ route('paiement.paypal', $reservation->id) }}" class="btn btn-success">
                      Payer la réservation ({{ $reservation->prix_total }} $)
                    </a>

                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded font-bold hover:bg-green-700">
                    Confirmer la Réservation
                </button>
            </form>
        </div>
    </div>
</x-app-layout>