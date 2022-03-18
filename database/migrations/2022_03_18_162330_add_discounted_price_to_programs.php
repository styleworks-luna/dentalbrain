<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountedPriceToPrograms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programs', function (Blueprint $programs) {
            $programs->integer('discounted_price')
                ->default(0)
                ->nullable(false)
                ->after('price')->comment('할인가');
            $programs->integer('membership_discounted_price')
                ->default(0)
                ->nullable(false)
                ->after('membership_price')->comment('유료회원 할인가');

            $programs->integer('discount_rate')
                ->default(0)
                ->nullable(false)
                ->after('price')->comment('할인율');
            $programs->integer('membership_discount_rate')
                ->default(0)
                ->nullable(false)
                ->after('membership_price')->comment('유료회원 할인율');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('discounted_price');
            $table->dropColumn('membership_discounted_price');
            $table->dropColumn('discount_rate');
            $table->dropColumn('membership_discount_rate');
        });
    }
}
