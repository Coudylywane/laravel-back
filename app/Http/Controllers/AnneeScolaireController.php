<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnneeScolaire;
use Illuminate\Support\Facades\DB;


use App\Http\Requests\AnneeScolaireStoreRequest;




class AnneeScolaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AnneeScolaire::all();
    }

    /**
     * Store a newly created resource in storage.
     */


     public function store(AnneeScolaireStoreRequest $request)
     {
         $validatedData = $request->validated();

         if (!isset($validatedData['etat'])) {
             $validatedData['etat'] = '0';
         }

         $annee = AnneeScolaire::create($validatedData);
         return response()->json($annee, 201);
     }

    /**
     * Display the specified resource.
     */
    public function show(string $etat)
    {
        if ($etat === 'encours') {
           // Si le paramètre URL est 'encours', renvoie les années académiques avec etat = 1
            $anneeScolaires = AnneeScolaire::where('etat', 1)->get();
        } else {
            // Sinon, filtrer les années académiques par l'état fourni
            $anneeScolaires = AnneeScolaire::where('etat', $etat)->get();
        }

        // Vérifier si une ou plusieurs années académiques ont été trouvées
        if ($anneeScolaires->isNotEmpty()) {
            return response()->json($anneeScolaires);
        } else {
            // Traiter le cas où aucune année universitaire n'a été trouvée
            return response()->json(['message' => 'Aucune année académique trouvée avec le statut spécifié.'], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $anneeScolaire = AnneeScolaire::find($id);

        if (!$anneeScolaire) {
            return response()->json(['message' => 'Aucune année académique trouvée avec l\'ID spécifié.'], 404);
        }

       // Démarre une transaction de base de données pour assurer la cohérence des données
        DB::beginTransaction();

        try {
            // Trouvez l'année universitaire pour laquelle "etat" est actuellement défini sur 1 et mettez-le à 0
            $currentEtatAnneeScolaire = AnneeScolaire::where('etat', 1)->first();
            if ($currentEtatAnneeScolaire) {
                $currentEtatAnneeScolaire->update(['etat' => '0']);
            }

            // Mettre à jour "l'état" de l'année académique spécifiée à 1
            $anneeScolaire->update(['etat' => '1']);

            // Valide la transaction puisque tout a réussi
            DB::commit();

            return response()->json($anneeScolaire);
        } catch (Exception $e) {
            // Quelque chose s'est mal passé, annuler la transaction et renvoyer une réponse d'erreur
            DB::rollback();
            return response()->json(['message' => 'Erreur lors de la mise à jour des états des années académiques.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
