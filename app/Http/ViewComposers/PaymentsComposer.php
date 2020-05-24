<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Users\Repository as UserRepository;
use App\Models\Payment;

class PaymentsComposer
{
	public function compose(View $view)
	{
        $payments = Payment::orderBy('type', 'ASC')
            ->orderBy('name', 'ASC')
            ->get();

        $view->with('payments', $payments);
	}
}
