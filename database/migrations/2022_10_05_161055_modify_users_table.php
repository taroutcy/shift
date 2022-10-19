<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('role_id')->nullable()->unsigned();
            $table->bigInteger('department_id')->nullable()->unsigned();
            $table->string('last_name', 10);
            $table->string('first_name', 10);
            $table->string('number', 10);
            $table->boolean('active')->default(true);
            $table->boolean('editor')->default(false);
            
            
            // 外部キー登録
            // $table->foreign('role_id')->references('id')->on('roles');
            // $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // 外部キー制約削除
            // $table->dropForeign('users_role_id_foreign');
            // $table->dropForeign('users_department_id_foreign');
            
            // $table->dropColumn('role_id');
            // $table->dropColumn('department_id');
            // $table->dropColumn('last_name');
            // $table->dropColumn('first_name');
            // $table->dropColumn('number');
            // $table->dropColumn('active');
        });
    }
}
