<?php

// app/Http/Controllers/ProductoController.php
namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Obtener todos los productos
    public function index()
    {
        $productos = Producto::all();
        return response()->json($productos);
    }

    // Obtener un producto por su id
    public function show($id)
    {
        $producto = Producto::find($id);
        if ($producto) {
            return response()->json($producto);
        }
        return response()->json(['message' => 'Producto no encontrado'], 404);
    }

    // Crear un nuevo producto
    public function store(Request $request)
    {
        // Validar los campos
        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|string', // Aceptar imagen como base64
            'descripcion' => 'nullable|string',
            'estatus' => 'required|in:1,2,3', // 1=activo, 2=inactivo, 3=pendiente
            'user_id' => 'required|exists:users,id',
        ]);
    
        // Obtener la imagen base64
        $imagenBase64 = $request->imagen;
    
        // Crear el producto en la base de datos
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'imagen' => $imagenBase64, // Guardar la imagen base64 en la base de datos
            'descripcion' => $request->descripcion,
            'estatus' => $request->estatus,
            'user_id' => $request->user_id,
        ]);
    
        return response()->json($producto, 201); // Retornar la respuesta
    }
    

    // Actualizar un producto existente
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);
        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|string',
            'descripcion' => 'nullable|string|max:255',
            'estatus' => 'required|in:1,2,3',
        ]);

        $producto->update([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'imagen' => $request->imagen,
            'descripcion' => $request->descripcion,
            'estatus' => $request->estatus,
            'user_id' => $request->user_id,
        ]);

        return response()->json($producto);
    }
}
