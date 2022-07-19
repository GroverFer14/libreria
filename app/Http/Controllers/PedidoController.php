<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Venta;
use App\DetalleVenta;
use App\Articulo;
use App\Pedido;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $pedidos = Pedido::join('users', 'pedidos.idconductor', '=', 'users.id')
                ->join('ventas', 'pedidos.idventa', '=', 'ventas.id')
                ->join('personas', 'personas.id', '=', 'ventas.idcliente')
                ->select(
                    'ventas.id as ventasId',
                    'pedidos.id',
                    'users.id as usersIdconductor',
                    'users.usuario',
                    'ventas.total',
                    'pedidos.ubicacion',
                    'pedidos.estado',
                    'personas.nombre as nombreCliente',
                    'personas.telefono'

                )
                ->orderBy('pedidos.id', 'desc')->paginate(3);
        } else {
            $pedidos = Pedido::join('users', 'pedidos.idconductor', '=', 'users.id')
                ->join('ventas', 'pedidos.idventa', '=', 'ventas.id')
                ->join('personas', 'personas.id', '=', 'ventas.idcliente')
                ->select(
                    'ventas.id as ventasId',
                    'pedidos.id',
                    'users.id as usersIdconductor',
                    'users.usuario',
                    'ventas.total',
                    'pedidos.ubicacion',
                    'pedidos.estado',
                    'personas.nombre as nombreCliente',
                    'personas.telefono'

                )
                ->where('personas.' . $criterio, 'like', '%' . $buscar . '%')
                ->orderBy('pedidos.id', 'desc')->paginate(3);
        }

        return [
            'pagination' => [
                'total'        => $pedidos->total(),
                'current_page' => $pedidos->currentPage(),
                'per_page'     => $pedidos->perPage(),
                'last_page'    => $pedidos->lastPage(),
                'from'         => $pedidos->firstItem(),
                'to'           => $pedidos->lastItem(),
            ],
            'pedidos' => $pedidos
        ];
    }


    public function entregar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $pedido = Pedido::findOrFail($request->id);
        $pedido->estado = 'Entregado';
        $pedido->save();
    }
    public function pendiente(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $pedido = Pedido::findOrFail($request->id);
        $pedido->estado = 'Pendiente';
        $pedido->save();
    }
}
