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
        $productos = Producto::where('estatus', '!=', 2)->get(); // Filtrar por status no igual a 2
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
        // Buscar el producto por ID
        $producto = Producto::find($id);
    
        // Si no se encuentra el producto, retorna un error 404
        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
    
        // Validación de los campos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|string',
            'descripcion' => 'nullable|string|max:255',
            'estatus' => 'required|in:1,2,3', // Se permite estatus 1, 2 o 3
        ]);
    
        // Si el estatus se cambia a 2 (vendido), eliminamos el producto
        if ($request->estatus == 2) {
            // Eliminar el producto
            $producto->delete();
    
            // Retornar una respuesta indicando que el producto fue eliminado
            return response()->json(['message' => 'Producto eliminado exitosamente'], 200);
        }
    
        // Si el estatus no es 2, se actualiza el producto
        $producto->update([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'imagen' => $request->imagen,
            'descripcion' => $request->descripcion,
            'estatus' => $request->estatus,
            'user_id' => $request->user_id,
        ]);
    
        // Retornar el producto actualizado
        return response()->json($producto);
    }
    
}
