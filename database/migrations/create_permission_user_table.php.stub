<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $name = config('acl.tables.permission_user','permission_user');
        Schema::create($name, function (Blueprint $table) {
            if (config('acl.incrementing', false)) {
                $table->foreignId('permission_id')->nullable()->constrained('permissions')->nullOnDelete();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            } else {
                $table->foreignUlid('permission_id')->nullable()->constrained('permissions')->nullOnDelete();
                $table->foreignUlid('user_id')->nullable()->constrained('users')->nullOnDelete();
            }
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $name = config('acl.tables.permission_user', 'permission_user');
        Schema::dropIfExists($name);
    }
}
