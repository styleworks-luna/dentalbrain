<?php

namespace App\Console\Commands;

use App\Mail\AfterEndProgram;
use App\Models\Program\ProgramStudent;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AfterEndProgramCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:after';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send Email After Ends';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = ProgramStudent::query()
            ->select('id','user_id','ticket_id','expired_at','email')
            ->with('user:id,login_id','ticket.program:id,title')
            ->has('user')
            ->has('ticket.program')
            ->whereDate('expired_at','=',date("Y-m-d",strtotime("-1days")))
            ->get()->toArray();

        try{
            array_map(function($value){
                Mail::to($value['email'])->send(new AfterEndProgram(User::query()->find($value['user']['id']),$value['ticket']['program']));
            },$data);

            $this->info('강의 마감 안내 email sent successfully!');
        }catch(\Exception $exception){
            Log::error('SEND EMAIL BEFORE 3 DAYS',[$exception]);
            $this->info('강의 마감 안내 email NOT SENT');
        }
    }
}
