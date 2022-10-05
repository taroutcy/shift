<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->bigInteger('shift_id')->nullable()->unsigned();
            $table->bigInteger('schedule_status_id')->nullable()->unsigned();
            $table->bigInteger('work_status_id')->nullable()->unsigned();
            $table->date('date');
            $table->timestamps();
            
            // 外部キー登録
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('shift_id')->references('id')->on('shifts');
            $table->foreign('schedule_status_id')->references('id')->on('schedule_statuses');
            $table->foreign('work_status_id')->references('id')->on('work_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 外部キー制約削除
        $table->dropForeign('schedules_user_id_foreign');
        $table->dropForeign('schedules_shift_id_foreign');
        $table->dropForeign('schedules_schedule_status_id_foreign');
        $table->dropForeign('schedules_work_status_id_foreign');
        
        Schema::dropIfExists('schedules');
    }
}
