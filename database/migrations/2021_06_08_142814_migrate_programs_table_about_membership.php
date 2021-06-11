<?php

use Illuminate\Database\Migrations\Migration;

class MigrateProgramsTableAboutMembership extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::table('programs')->orderBy('id')
            ->each(function ($program) {
                \Illuminate\Support\Facades\DB::table('programs')
                    ->where('id', '=', $program->id)
                    ->update([
                        'membership_price' => $program->price,
                        'membership_is_free' => $program->is_free,
                    ]);
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::table('programs')->update([
            'membership_price' => 0,
            'membership_is_free' => 0,
        ]);
    }
}
