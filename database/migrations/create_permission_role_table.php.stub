<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $name = config('acl.tables.permission_role', 'permission_role');
        Schema::create($name, function (Blueprint $table) {
            if (config('acl.incrementing', false)) {
                $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');
                $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            } else {
                $table->foreignUlid('permission_id')->constrained('permissions')->onDelete('cascade');
                $table->foreignUlid('role_id')->constrained('roles')->onDelete('cascade');
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
        $name = config('acl.tables.permission_role', 'permission_role');
        Schema::dropIfExists($name);
    }
}
