<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoanController extends Controller
{
    // Données statiques non traduisibles (taux, montants, couleurs, icônes)
    private array $static = [
        'immobilier' => ['type'=>'immobilier','icon'=>'🏠','rate_min'=>'1.9', 'rate_max'=>'3.2', 'amount_min'=>'50 000 €',  'amount_max'=>'1 000 000 €','color'=>'#267BF1'],
        'automobile' => ['type'=>'automobile','icon'=>'🚗','rate_min'=>'2.5', 'rate_max'=>'5.9', 'amount_min'=>'3 000 €',   'amount_max'=>'150 000 €',  'color'=>'#1A56B0'],
        'personnel'  => ['type'=>'personnel', 'icon'=>'💳','rate_min'=>'3.2', 'rate_max'=>'12.0','amount_min'=>'1 000 €',   'amount_max'=>'75 000 €',   'color'=>'#267BF1'],
        'entreprise' => ['type'=>'entreprise','icon'=>'🏢','rate_min'=>'2.8', 'rate_max'=>'7.5', 'amount_min'=>'10 000 €',  'amount_max'=>'1 000 000 €','color'=>'#1A56B0'],
        'agricole'   => ['type'=>'agricole',  'icon'=>'🌾','rate_min'=>'2.3', 'rate_max'=>'5.5', 'amount_min'=>'5 000 €',   'amount_max'=>'500 000 €',  'color'=>'#267BF1'],
        'microcredit'=> ['type'=>'microcredit','icon'=>'🌱','rate_min'=>'4.0','rate_max'=>'7.0', 'amount_min'=>'300 €',     'amount_max'=>'10 000 €',   'color'=>'#1A56B0'],
    ];

    private function getLoans(): array
    {
        $translated = trans('loans.data');
        $loans = [];
        foreach ($this->static as $key => $base) {
            $loans[$key] = array_merge($base, $translated[$key] ?? []);
        }
        return $loans;
    }

    public function index(): mixed
    {
        return view('prets.index', ['loans' => $this->getLoans()]);
    }

    public function show(Request $request, string $type): mixed
    {
        if (!array_key_exists($type, $this->static)) {
            abort(404);
        }
        $loans = $this->getLoans();
        return view('prets.show', [
            'loan'  => $loans[$type],
            'loans' => $loans,
        ]);
    }
}
