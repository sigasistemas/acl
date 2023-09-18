<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $name = config('acl.tables.roles', 'roles');
        Schema::create($name, function (Blueprint $table) {
            if (config('acl.incrementing', false)) {
                $table->id();
                $table->unsignedBigInteger('tenant_id')->nullable();
            } else {
                $table->ulid('id')->primary();
                $table->ulid('tenant_id')->nullable();
            }
            $table->string('name', 255)->unique();
            $table->string('slug', 255)->unique();
            $table->enum('special', [null, 'no-access', 'all-access'])->nullable();
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $name = config('acl.tables.roles', 'roles');
        Schema::dropIfExists($name);
    }
}
