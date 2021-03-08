<?php

namespace App\Console\Commands;

use App\Models\Program\ProgramStudent;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\BeforeEndProgram;

class BeforeEndProgramCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:before';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send Email Before End 3Days';

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
            ->whereDate('expired_at','=',date("Y-m-d",strtotime("+3days")))
            ->get()->toArray();

        try{
            array_map(function($value){
                Mail::to($value['email'])->send(new BeforeEndProgram(User::query()->find($value['user']['id']),$value['ticket']['program']));
            },$data);

            $this->info('강의 마감 안내 3일 전 email sent successfully!');
        }catch(\Exception $exception){
            Log::error('SEND EMAIL BEFORE 3 DAYS',[$exception]);
            $this->info('강의 마감 안내 3일 전 email not sent!');
        }
    }
}
