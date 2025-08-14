<?php

namespace App\Http\Controllers;

use App\Models\Categoria;

use App\Models\ImagenProducto;
use App\Models\Marca;
use App\Models\Metadatos;
use App\Models\Modelo;
use App\Models\Producto;
use App\Models\ProductoMarca;
use App\Models\ProductoModelo;
use App\Models\SubCategoria;
use App\Models\SubProducto;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $categorias = Categoria::select('id', 'name')->get();
        $marcas = Marca::orderBy('order', 'asc')->get();
        $modelos = Modelo::orderBy('order', 'asc')->get();

        $perPage = $request->input('per_page', default: 10);

        $query = Producto::query()->orderBy('order', 'asc')->with(['marca', 'modelo', 'categoria', 'imagenes']);

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', '%' . $searchTerm . '%')->orWhere('code', 'LIKE', '%' . $searchTerm . '%');
        }

        $productos = $query->paginate($perPage);





        return Inertia::render('admin/productosAdmin', [
            'productos' => $productos,
            'categorias' => $categorias,
            'marcas' => $marcas,
            'modelos' => $modelos,
        ]);
    }

    public function indexVistaPrevia(Request $request)
    {
        // Construir query base para productos
        $query = Producto::query();

        // Filtro por categoría (a través de marcas)
        if ($request->filled('tipo')) {
            $query->where('categoria_id', $request->tipo);
        }

        // Filtro por modelo/subcategoría
        if ($request->filled('marca')) {
            $query->where('marca_id', $request->marca);
        }

        if ($request->filled('modelo')) {
            $query->where('modelo_id', $request->modelo);
        }

        // Filtro por código
        if ($request->filled('code')) {
            $query->where('code', 'LIKE', '%' . $request->code . '%');
        }

        // Filtro por código OEM
        if ($request->filled('code_sr')) {
            $query->where('code_sr', 'LIKE', '%' . $request->code_sr . '%');
        }


        // Aplicar ordenamiento por defecto
        $query->orderBy('order', 'asc');

        // Ejecutar query con paginación
        $productos = $query->with(['marca', 'modelo', 'imagenes', 'categoria'])
            ->paginate(15)
            ->appends($request->query());

        // Si solo hay un producto en total (no en la página actual), redirigir
        /* if ($productos->total() === 1) {
            return redirect('/p/' . $productos->first()->code);
        } */

        // Cargar datos adicionales para la vista
        $categorias = Categoria::with('subCategorias')->orderBy('order', 'asc')->get();
        $marcas = Marca::orderBy('order', 'asc')->get();
        $modelos = Modelo::orderBy('order', 'asc')->get();

        return view('productos', [
            'categorias' => $categorias,
            'productos' => $productos,
            'tipo' => $request->tipo,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'code' => $request->code,
            'code_sr' => $request->code_sr,
            'marcas' => $marcas,
            'modelos' => $modelos,
        ]);
    }

    public function show($codigo, Request $request)
    {
        $producto = Producto::with(['categoria:id,name', 'imagenes', 'marca', 'modelo'])->where('code', $codigo)->first();

        $subcategorias = SubCategoria::orderBy('order', 'asc')->get();

        $categorias = Categoria::select('id', 'name', 'order')->orderBy('order', 'asc')->get();

        // Obtener productos relacionados por marca y modelo
        $productosRelacionados = Producto::where('id', '!=', $producto->id)->with(['categoria:id,name', 'imagenes', 'marca', 'modelo'])->orderBy('order', 'asc')->limit(3)->get();

        return view('producto', [
            'producto' => $producto,
            'categorias' => $categorias,
            'subcategorias' => $subcategorias,
            'categoria' => $producto->categoria,
            'productosRelacionados' => $productosRelacionados,
            'modelo_id' => $request->modelo_id ?? null
        ]);
    }
    public function indexPrivada(Request $request)
    {


        $perPage = $request->input('per_page', 10);

        $qty = $request->input('qty', 1); // Valor por defecto para qty
        $carrito = Cart::content();

        $query = Producto::with(['imagenes', 'marca', 'modelo', 'precio', 'categoria'])->orderBy('order', 'asc');

        if ($request->filled('tipo')) {
            $query->where('categoria_id', $request->tipo);
        }

        // Filtro por modelo/subcategoría
        if ($request->filled('marca')) {
            $query->where('marca_id', $request->marca);
        }

        if ($request->filled('modelo')) {
            $query->where('modelo_id', $request->modelo);
        }

        // Filtro por código
        if ($request->filled('code')) {
            $query->where('code', 'LIKE', '%' . $request->code . '%');
        }

        // Filtro por código OEM
        if ($request->filled('code_sr')) {
            $query->where('code_sr', 'LIKE', '%' . $request->code_sr . '%');
        }



        $productos = $query->paginate(perPage: $perPage);

        // Modificar los productos para agregar rowId y qty del carrito
        $productos->getCollection()->transform(function ($producto) use ($carrito, $qty) {
            // Buscar el item del carrito que corresponde a este producto
            $itemCarrito = $carrito->where('id', $producto->id)->first();

            $tieneOfertaVigente = $producto->ofertas()
                ->where('user_id', Auth::id())
                ->where('fecha_fin', '>', now())
                ->exists();

            if ($itemCarrito) {
                $producto->rowId = $itemCarrito ? $itemCarrito->rowId : null;
                $producto->qty = $itemCarrito ? $itemCarrito->qty : null;
                $producto->subtotal =  $itemCarrito ? $itemCarrito->price * ($itemCarrito->qty ?? 1) : $producto->precio->precio;
            } else {
                $producto->rowId = null;
                $producto->qty = $qty; // Asignar qty por defecto si no está en el carrito
                $producto->subtotal = $producto->precio ? $producto->precio->precio * ($producto->qty ?? 1) : 0; // Asignar precio base si no está en el carrito
            }

            if ($tieneOfertaVigente) {
                $producto->oferta = true;
            }

            // Aquí puedes agregar más lógica si es necesario, como calcular el subtotal
            // Agregar el rowId y qty al producto
            // Calcular subtotal

            return $producto;
        });
        # si el usuario es vendedor

        $categorias = Categoria::orderBy('order', 'asc')->get();
        $marcas = Marca::orderBy('order', 'asc')->get();
        $modelos = Modelo::orderBy('order', 'asc')->get();
        $userId = Auth::id();

        $productosOferta = Producto::whereHas('ofertas', function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->where('fecha_fin', '>', now());
        })
            ->with([
                'imagenes',
                'marca',
                'modelo',
                'precio',
                'ofertas' => function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->where('fecha_fin', '>', now());
                }
            ])
            ->orderBy('order', 'asc')
            ->get();

        return inertia('privada/productosPrivada', [
            'productos' => $productos,
            'categorias' => $categorias,
            'productosOferta' => $productosOferta,
            'tipo' => $request->tipo,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'code' => $request->code,
            'code_sr' => $request->code_sr,
            'marcas' => $marcas,
            'modelos' => $modelos,

        ]);
    }

    /* public function indexInicio(Request $request, $id)
    {
        $marcas = Marca::select('id', 'name', 'order')->orderBy('order', 'asc')->get();

        $categorias = Categoria::select('id', 'name', 'order')
            ->orderBy('order', 'asc')
            ->get();
        $metadatos = Metadatos::where('title', 'Productos')->first();
        if ($request->has('marca') && !empty($request->marca)) {
            $productos = Producto::where('categoria_id', $id)->whereHas('subproductos')->whereHas('imagenes')->where('marca_id', $request->marca)->with('marca', 'imagenes')->orderBy('order', 'asc')->get();
        } else {
            $productos = Producto::where('categoria_id', $id)->whereHas('subproductos')->whereHas('imagenes')->with('marca', 'imagenes')->orderBy('order', 'asc')->get();
        }
        $subproductos = SubProducto::orderBy('order', 'asc')->get();

        return Inertia::render('productos', [
            'productos' => $productos,
            'categorias' => $categorias,
            'marcas' => $marcas,
            'metadatos' => $metadatos,
            'id' => $id,
            'marca_id' => $request->marca,
            'subproductos' => $subproductos,

        ]);
    } */

    public function indexInicio(Request $request, $id)
    {


        $categorias = Categoria::select('id', 'name', 'order')
            ->orderBy('order', 'asc')
            ->get();

        $metadatos = Metadatos::where('title', 'Productos')->first();

        $query = Producto::where('categoria_id', $id)

            ->orderBy('order', 'asc');



        $productos = $query->paginate(12)->withQueryString(); // 12 por página, mantiene filtros

        // Opcional: solo subproductos de productos actuales (más eficiente)
        $productoIds = $productos->pluck('id');
        $subproductos = SubProducto::whereIn('producto_id', $productoIds)
            ->orderBy('order', 'asc')
            ->get();

        return Inertia::render('productos', [
            'productos' => $productos,
            'categorias' => $categorias,

            'metadatos' => $metadatos,
            'id' => $id,

            'subproductos' => $subproductos,
        ]);
    }

    public function imagenesProducto()
    {
        $fotos = Storage::disk('public')->files('repuestos');

        foreach ($fotos as $foto) {
            $path = pathinfo(basename($foto), PATHINFO_FILENAME);

            $producto = Producto::where('code', $path)->first();
            if (!$producto) {
                continue; // Skip if the product is not found
            }
            $url = Storage::url($foto);
            ImagenProducto::create([
                'producto_id' => $producto->id,
                'image' => $url,
            ]);
        }
    }







    public function SearchProducts(Request $request)
    {
        $query = Producto::query();

        // Aplicar filtros solo si existen
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }



        if ($request->filled('codigo')) {
            $query->where('code', 'LIKE', '%' . $request->codigo . '%');
        }

        $productos = $query->with(['categoria:id,name', 'imagenes'])
            ->get();

        $categorias = Categoria::select('id', 'name', 'order')->orderBy('order', 'asc')->get();


        return Inertia::render('productos/productoSearch', [
            'productos' => $productos, // Cambié 'producto' a 'productos' (plural)
            'categorias' => $categorias,

        ]);
    }

    public function fixImagePath()
    {
        # Quitar /storage/ de las rutas de las imágenes
        $imagenes = ImagenProducto::all();
        foreach ($imagenes as $imagen) {
            if (strpos($imagen->image, '/storage/') === 0) {
                $imagen->image = str_replace('/storage/', '', $imagen->image);
                $imagen->save();
            }
        }

        return response()->json(['message' => 'Rutas de imágenes actualizadas correctamente.']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $data = $request->validate([
            // Validaciones del producto
            'order' => 'nullable|sometimes|max:255',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'code_sr' => 'nullable|sometimes|string|max:255',
            'desc' => 'nullable|string',
            'unidad_pack' => 'nullable|integer',
            'destacado' => 'nullable|sometimes|boolean',
            'categoria_id' => 'nullable|exists:categorias,id',
            'marca_id' => 'nullable|exists:marcas,id',
            'modelo_id' => 'nullable|exists:modelos,id',
            'images' => 'nullable|array|min:1',
            'images.*' => 'required|file|image',
        ]);

        try {
            return DB::transaction(function () use ($request, $data) {
                // Crear el producto primero
                $producto = Producto::create([
                    'order' => $data['order'] ?? 'zzz',
                    'name' => $data['name'],
                    'code' => $data['code'],
                    'code_sr' => $data['code_sr'],
                    'desc' => $data['desc'],
                    'unidad_pack' => $data['unidad_pack'] ?? 1,
                    'destacado' => $data['destacado'] ?? false,
                    'categoria_id' => $data['categoria_id'] ?? null,
                    'marca_id' => $data['marca_id'] ?? null,
                    'modelo_id' => $data['modelo_id'] ?? null,
                ]);

                $createdImages = [];

                // Procesar imágenes si existen
                if ($request->hasFile(key: 'images')) {
                    foreach ($request->file('images') as $image) {
                        // Subir cada imagen
                        $imagePath = $image->store('images', 'public');

                        // Crear registro para cada imagen usando el ID del producto recién creado
                        $imageRecord = ImagenProducto::create([
                            'producto_id' => $producto->id,
                            'order' => $data['order'] ?? null,
                            'image' => $imagePath,
                        ]);

                        $createdImages[] = $imageRecord;
                    }
                }
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function update(Request $request)
    {
        $data = $request->validate([
            // Validaciones del producto

            'order' => 'nullable|sometimes|max:255',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'code_sr' => 'nullable|sometimes|string|max:255',
            'desc' => 'nullable|string',
            'unidad_pack' => 'nullable|integer',
            'destacado' => 'nullable|sometimes|boolean',
            'categoria_id' => 'nullable|exists:categorias,id',
            'marca_id' => 'nullable|exists:marcas,id',
            'modelo_id' => 'nullable|exists:modelos,id',

            // Validaciones de las imágenes (opcionales)
            'images' => 'nullable|array|min:1',
            'images.*' => 'required|file|image',
            // Para eliminar imágenes existentes
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer|exists:imagen_productos,id',
        ]);

        try {
            return DB::transaction(function () use ($request, $data) {
                // Buscar el producto
                $producto = Producto::findOrFail($request->id);

                // Actualizar los datos del producto
                $producto->update([
                    'order' => $data['order'] ?? 'zzz',
                    'name' => $data['name'],
                    'code' => $data['code'],
                    'code_sr' => $data['code_sr'],
                    'desc' => $data['desc'],
                    'unidad_pack' => $data['unidad_pack'] ?? 1,
                    'destacado' => $data['destacado'] ?? false,
                    'categoria_id' => $data['categoria_id'] ?? null,
                    'marca_id' => $data['marca_id'] ?? null,
                    'modelo_id' => $data['modelo_id'] ?? null,
                ]);

                if ($request->has('images_to_delete')) {
                    foreach ($request->images_to_delete as $imageId) {
                        $image = ImagenProducto::find($imageId);
                        if ($image) {
                            // Eliminar archivo del storage
                            Storage::delete($image->image);
                            // Eliminar registro de la base de datos
                            $image->delete();
                        }
                    }
                }

                // Agregar nuevas imágenes
                if ($request->hasFile('new_images')) {
                    foreach ($request->file('new_images') as $image) {
                        $path = $image->store('images', 'public');

                        ImagenProducto::create([
                            'producto_id' => $producto->id,
                            'image' => $path,
                        ]);
                    }
                }

                // Actualizar otros campos del producto


                // Eliminar imágenes seleccionadas si se especificaron
                if ($request->has('delete_images')) {
                    $imagesToDelete = ImagenProducto::where('producto_id', $producto->id)
                        ->whereIn('id', $data['delete_images'])
                        ->get();

                    foreach ($imagesToDelete as $imageRecord) {
                        // Eliminar archivo físico
                        if (Storage::disk('public')->exists($imageRecord->image)) {
                            Storage::disk('public')->delete($imageRecord->image);
                        }
                        // Eliminar registro de la base de datos
                        $imageRecord->delete();
                    }
                }

                // Procesar nuevas imágenes si existen
                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $image) {
                        // Subir cada imagen
                        $imagePath = $image->store('images', 'public');

                        // Crear registro para cada imagen
                        ImagenProducto::create([
                            'producto_id' => $producto->id,
                            'order' => $data['order'] ?? null,
                            'image' => $imagePath,
                        ]);
                    }
                }

                // Actualizar relaciones con modelos

            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        $id = $request->id;
        try {
            return DB::transaction(function () use ($id) {
                // Buscar el producto
                $producto = Producto::findOrFail($id);

                // Eliminar todas las imágenes asociadas
                $imagenes = ImagenProducto::where('producto_id', $producto->id)->get();
                foreach ($imagenes as $imagen) {
                    // Eliminar archivo físico del storage
                    if (Storage::disk('public')->exists($imagen->image)) {
                        Storage::disk('public')->delete($imagen->image);
                    }
                    // Eliminar registro de la base de datos
                    $imagen->delete();
                }

                // Eliminar relaciones con modelos


                // Eliminar el producto
                $producto->delete();
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function cambiarDestacado(Request $request)
    {
        $producto = Producto::findOrFail($request->id);
        $producto->destacado = !$producto->destacado; // Cambiar el estado de destacado
        $producto->save();
    }

    public function productoszonaprivada(Request $request)
    {
        return inertia('admin/zonaprivadaProductosAdmin');
    }

    public function cambiarOferta(Request $request)
    {
        $producto = Producto::findOrFail($request->id);
        $producto->oferta = !$producto->oferta;
        $producto->save();
    }

    public function handleQR($code)
    {

        $producto = Producto::where('code', $code)->first();

        if (!$producto && $code != "adm") {
            return redirect('/productos');
        } else if ($code == "adm") {
            if (Auth::guard('admin')->check()) {
                return redirect('/admin/dashboard');
            }
            return Inertia::render('admin/login');
        }




        if (Auth::check()) {

            $tieneOfertaVigente = $producto->ofertas()
                ->where('user_id', Auth::id())
                ->where('fecha_fin', '>', now())
                ->exists();

            Cart::add(
                $producto->id,
                $producto->name,
                $producto->unidad_pack ?? 1,
                $tieneOfertaVigente
                    ? $producto->precio->precio * (1 - $producto->descuento_oferta / 100)
                    : $producto->precio->precio,
                0
            );

            // Guardar en base de datos si hay usuario logueado
            if (Auth::check() && !session('cliente_seleccionado')) {
                if (Cart::count() < 0) {
                    Cart::store(Auth::id());
                }
            } else {
                Cart::store(session('cliente_seleccionado')->id);
            }

            return redirect('/privada/carrito');
        } else {
            return redirect('/p/' . $producto->code);
        }
    }
}
