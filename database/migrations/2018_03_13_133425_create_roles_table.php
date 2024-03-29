<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 30)->unique();
            $table->string('descripcion', 100)->nullable();
            $table->boolean('condicion')->default(1);
        });
        DB::table('roles')->insert(array('id' => '1', 'nombre' => 'Administrador', 'descripcion' => 'Administradores de área'));
        DB::table('roles')->insert(array('id' => '2', 'nombre' => 'Vendedor', 'descripcion' => 'Vendedor área venta'));
        DB::table('roles')->insert(array('id' => '3', 'nombre' => 'Almacenero', 'descripcion' => 'Almacenero área compras'));
        DB::table('roles')->insert(array('id' => '4', 'nombre' => 'Delivery', 'descripcion' => 'Delivery del Super mercado'));
        DB::table('roles')->insert(array('id' => '5', 'nombre' => 'Cliente', 'descripcion' => 'Cliente del Super mercado'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
