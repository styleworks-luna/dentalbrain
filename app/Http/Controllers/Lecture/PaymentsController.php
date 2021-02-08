<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\SuccessPayments;
use App\Models\Program\Program;
use App\Models\Program\Survey\Survey;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentsController extends Controller
{
    public function success(SuccessPayments $request, Program $program)
    {
        if ($program->ticket->price != $request->get('amount')) {
            return redirect()->back()->with(['alert' => '결제 금액이 맞지 않습니다.']);
        }

        try {
            $client = new Client();
            $url = 'https://api.tosspayments.com/v1/payments/' . $request->get('paymentKey');
            $response = $client->post($url, [
                'auth' => [
                    env('TOSS_PAYMENTS_SECRET'),
                    '',
                ],
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'json' => [
                    "orderId" => $request->get('orderId'),
                    "amount" => $request->get('amount'),
                ],
            ]);
        } catch (GuzzleException $e) {
            Log::error('TOSS API CALL ERROR', [$e, $request->all()]);
            return redirect()->back()->with(['alert' => '오류가 발생했습니다. 다시 시도해주세요.']);
        }

        if ($response->getStatusCode() !== 200) {
            Log::error('TOSS API CALL ERROR', [
                'code' => $response->getStatusCode(),
                'body' => $response->getBody(),
                'request' => $request->all()]);
            return redirect()->back()->with(['alert' => '오류가 발생했습니다. 다시 시도해주세요.']);
        }

        logger($response->getBody());

        return redirect()->route('lectures.result', $program->id);
    }

    public function result(Program $program)
    {
        $surveys = Survey::query()
            ->with(['choices',
                'answers' => function ($query) {
                    $query->where('user_id', '=', Auth::id());
                }, 'answer' => function ($query) {
                    $query->where('user_id', '=', Auth::id());
                }])
            ->where('program_id', '=', $program->id)
            ->whereNull('parent_id')
            ->get();

        return view(viewPrefix() . 'pages.lecture.lecture_result', [
            'program' => $program,
            'surveys' => $surveys,
        ]);
    }

    public function showPaymentForm(Request $request, Program $program)
    {
        $surveys = Survey::query()
            ->with(['choices',
                'answers' => function ($query) {
                    $query->where('user_id', '=', Auth::id());
                }, 'answer' => function ($query) {
                    $query->where('user_id', '=', Auth::id());
                }])
            ->where('program_id', '=', $program->id)
            ->whereNull('parent_id')
            ->get();

        return view(viewPrefix() . 'pages.lecture.lecture_payment', [
            'program' => $program,
            'surveys' => $surveys,
        ]);
    }

}
