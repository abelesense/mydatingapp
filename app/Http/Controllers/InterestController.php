<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveInterestRequest;
use App\Models\Interest;
use App\Models\UserInterest;
use Illuminate\Http\Request;


class InterestController extends Controller
{
    public function showInterestForm()
    {
        // Получаем интересы из модели
        $interests = (new Interest)->getAllInterests();

        // Передаем данные в представление
        return view('interest.interest', ['interests' => $interests]);
    }

    public function saveInterest(SaveInterestRequest $request)
    {
        // Сохранение данных в таблицу user_interests
        $userInterest = new UserInterest();
        $userInterest->user_id = auth()->id(); // id текущего пользователя
        $userInterest->interest_id = $request->interest_id;
        $userInterest->save();

        // Возвращаем ответ
        return response()->json(['message' => 'Interest added successfully!'], 200);
    }
}
