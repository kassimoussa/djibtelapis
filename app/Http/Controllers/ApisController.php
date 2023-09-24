<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Fix;
use App\Models\Mobile;
use Illuminate\Http\Request;

class ApisController extends Controller
{
    public function all_fix()
    {
        $fixes = Fix::select('nd as Numero', 'Onu', 'cust_name as Nom', 'cust_category as Categorie')->orderBy('nd', 'asc')->get();

        $data =  [
            'total de ligne' => $fixes->count(),
            'lignes' => $fixes,
        ];

        return response()->json($data, 200);
    }

    public function nd_fix($nd = null)
    {
        if ($nd) {
            $fix = Fix::select('nd as Numero', 'Onu', 'cust_name as Nom', 'cust_category as Categorie')->where('nd', $nd)->first();
            if ($fix) {
                return response()->json($fix, 200);
            } else {
                $data = ["message" => "Le numéro donné est introuvable !"];
                return response()->json($data, 404);
            }
        } else {
            $message = "Il faut passer un argument";
            return response()->json($message, 400);
        }
    }

    public function nom_fix($nom = null)
    {
        if ($nom) {
            $fix = Fix::select('nd as Numero', 'Onu', 'cust_name as Nom', 'cust_category as Categorie')->where('cust_name', 'Like', '%' . $nom . '%')->orderBy('cust_name', 'asc')->get();;
            if ($fix) {
                $data =  [
                    'total de ligne' => $fix->count(),
                    'lignes' => $fix,
                ];
                return response()->json($data, 200);
            } else {
                $data = ["message" => "Aucun numéro trouvé pour le nom donné !"];
                return response()->json($data, 404);
            }
        } else {
            $message = "Il faut passer un argument";
            return response()->json($message, 400);
        }
    }


    public function all_mobile()
    {
        $mobiles = Mobile::selectRaw('numero, nom, date_activation, date_desactivation, 
        CASE
        WHEN status = "a" THEN "Active"
        WHEN status = "d" THEN "Désactive"
        WHEN status = "s" THEN "Suspendue"
        WHEN status = "o" THEN "Out"
        ELSE status
        END AS "status" ')->where('numero', 'Like', '25377%')->orderBy('date_activation', 'asc')->get();

        $data =  [
            'total de ligne' => $mobiles->count(),
            'lignes' => $mobiles,
        ];

        return response()->json($data, 200);
    }


    public function nd_mobile($nd = null)
    {
        $nd_len = strlen($nd);
        if($nd_len == 8) {
            $nd = "253" . $nd;
        } 

        if ($nd) {
            $mobiles = Mobile::selectRaw('numero, nom, date_activation, date_desactivation, 
            CASE
            WHEN status = "a" THEN "Active"
            WHEN status = "d" THEN "Désactive"
            WHEN status = "s" THEN "Suspendue"
            WHEN status = "o" THEN "Out"
            ELSE status
            END AS "status" ')->where('numero', 'Like', '25377%')->where('numero', $nd)->orderBy('date_activation', 'desc')->get();
            if ($mobiles->count() > 0) {
                $data =  [
                    'total de ligne' => $mobiles->count(),
                    'lignes' => $mobiles,
                ];

                return response()->json($data, 200);
            } else {
                $data = ["message" => "Le numéro donné est introuvable !"];
                return response()->json($data, 404);
            }
        } else {
            $message = "Il faut passer un argument";
            return response()->json($message, 400);
        }
    }


    public function nom_mobile($nom = null)
    {
        if ($nom) {
            $mobiles = Mobile::selectRaw('numero, nom, date_activation, date_desactivation, 
            CASE
            WHEN status = "a" THEN "Active"
            WHEN status = "d" THEN "Désactive"
            WHEN status = "s" THEN "Suspendue"
            WHEN status = "o" THEN "Out"
            ELSE status
            END AS "status" ')->where('numero', 'Like', '25377%')->where('nom', 'Like', '%' . $nom . '%')->orderBy('nom', 'asc')->get();
            if ($mobiles) {
                $data =  [
                    'total de ligne' => $mobiles->count(),
                    'lignes' => $mobiles,
                ];

                return response()->json($data, 200);
            } else {
                $data = ["message" => "Aucun numéro trouvé pour le nom donné !"];
                return response()->json($data, 404);
            }
        } else {
            $message = "Il faut passer un argument";
            return response()->json($message, 400);
        }
    }
}
