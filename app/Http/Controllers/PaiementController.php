<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaiementController extends Controller
{
    public function initierLePaiement(Request $requete)
    {
        $fournisseur = new PayPalClient; // تم تصحيح New إلى new (اختياري)
        $fournisseur->setApiCredentials(config('paypal'));
        $fournisseur->getAccessToken();

        $commande = $fournisseur->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => "10.00"
                    ]
                ]
            ],
            "application_context" => [
                "cancel_url" => route('paiement.annule'), // تصحيح: إضافة علامات التنصيص ''
                "return_url" => route('paiement.succes')  // تصحيح: كانت retuen_url
            ]
        ]);

        if (isset($commande['id']) && $commande['id'] != null) {
            foreach ($commande['links'] as $lien) { // تصحيح: كانت link والصحيح links
                if ($lien['rel'] == 'approve') {   // ملاحظة: PayPal تستخدم 'approve' وليس 'approuve'
                    return redirect()->away($lien['href']);
                }
            }
        }

        return redirect()->route('paiement.annule');
    }

    public function succesDuPaiement(Request $requete)
    {
        $fournisseur = new PayPalClient; // تصحيح: كانت PayPallClient (حرف L زائد)
        $fournisseur->setApiCredentials(config('paypal'));
        $fournisseur->getAccessToken();

        $response = $fournisseur->capturePaymentOrder($requete['token']);

        // تصحيح: تأكد من استخدام $response وليس $reponse (حرف s)
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return "Paiement réussi ! L'argent est dans votre compte sandbox.";
        }

        return "Échec du paiement.";
    }

    public function annulationDuPaiement()
    {
        return "Le paiement a été annulé par l'utilisateur.";
    }
}