<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\SuccessPayments;
use App\Mail\paymentLecture;
use App\Models\Payments\Payment;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\Program\Survey\Survey;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

        $fullContent = $response->getBody()->getContents();
        $responseBody = json_decode($fullContent, true);

        $payment = Payment::query()->create([
            'paymentKey' => $responseBody['paymentKey'],
            'orderId' => $responseBody['orderId'],
            'totalAmount' => $responseBody['totalAmount'],
            'receiptUrl' => $responseBody['card'] ? $responseBody['card']['receiptUrl'] : null,
            'method' => $responseBody['method'],
            'status' => $responseBody['status'],
            'refundStatus' => $responseBody['virtualAccount'] ? $responseBody['card']['receiptUrl'] : null,
            'useDiscount' => $responseBody['useDiscount'],
            'discountAmount' => $responseBody['discountAmount'],
            'secret' => $responseBody['secret'],
            'full_response' => $fullContent,
            'requestedAt' => Carbon::parse($responseBody['requestedAt'])->toDateTime(),
            'approvedAt' => Carbon::parse($responseBody['approvedAt'])->toDateTime(),
        ]);

        ProgramStudent::query()->where('user_id', '=', Auth::id())
            ->where('ticket_id', '=', $program->ticket->id)
            ->first()->update([
                'payment_id' => $payment->id,
                'expired_at' => now()->addDays($program->ticket->term),
            ]);

        Mail::to(Auth::user()->email)->send(new paymentLecture(Auth::user(),$this->getProgramQueryWithPayment($payment)));

        return redirect()->route('lectures.result', $program->id);
    }

    private function getProgramQueryWithPayment(Payment $payment){
        return ProgramStudent::query()
            ->select('id','payment_id','ticket_id','expired_at')
            ->where('user_id', '=', Auth::id())
            ->with('payment:id,totalAmount,method','ticket.program:id,title')
            ->whereHas('payment', function($query) use($payment) {
                $query->where('id', $payment->id);
            })
            ->get()
            ->toArray();
    }

    public function showPaymentForm(Request $request, Program $program)
    {
        $surveys = Survey::result($program->id)->get();

        return view(viewPrefix() . 'pages.lecture.lecture_payment', [
            'program' => $program,
            'surveys' => $surveys,
        ]);
    }

}
