<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MergeTicketsIntoProgram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            \Illuminate\Support\Facades\DB::beginTransaction();


            Schema::table('programs', function (Blueprint $table) {
                $table->unsignedBigInteger('price')->comment('강의 가격')->nullable()->after('thumbnail_id');
                $table->string('description')->comment('강의 짧은 설명')->nullable()->after('title');
                $table->integer('is_free')->comment('강의 무료 여부 / 1 : true , 0 : false')->nullable()->after('is_open');
                $table->unsignedBigInteger('term')->comment('강의 수강 기간')->default(100)->after('running_time');
            });

            $tickets = \Illuminate\Support\Facades\DB::table('program_tickets')->get();

            foreach ($tickets as $ticket) {
                \Illuminate\Support\Facades\DB::table('programs')->where('id', '=', $ticket->id)
                    ->update([
                        'description' => $ticket->name,
                        'is_free' => $ticket->is_free,
                        'price' => $ticket->price,
                    ]);
            }


            \Illuminate\Support\Facades\DB::commit();
        } catch (Exception $exception) {
            \Illuminate\Support\Facades\DB::rollBack();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('description');
            $table->dropColumn('is_free');
            $table->dropColumn('term');
        });
    }
}
