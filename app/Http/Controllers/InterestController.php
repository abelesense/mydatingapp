<?php

namespace App\Http\Controllers;

use App\Models\Interest;

class InterestController extends Controller
{
    public function showInterestForm()
    {
        // Получаем интересы из модели
        $interests = (new Interest)->getAllInterests();

        // Передаем данные в представление
        return view('interest.interest', ['interests' => $interests]);
    }
}
