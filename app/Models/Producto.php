<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $guarded = [];
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }



    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }
    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function imagenes()
    {
        return $this->hasMany(ImagenProducto::class, 'producto_id');
    }

    public function subproductos()
    {
        return $this->hasMany(SubProducto::class);
    }

    public function getImageAttribute($value)
    {
        return url("storage/" . $value);
    }

    public function precio()
    {
        return $this->hasOne(ListaProductos::class, 'producto_id')
            ->where('lista_de_precios_id',  session('cliente_seleccionado') ? session('cliente_seleccionado')->lista_de_precios_id : auth()->user()->lista_de_precios_id ?? null);
    }

    public function pedidos()
    {
        return $this->hasMany(PedidoProducto::class, 'producto_id');
    }

    public function ofertas()
    {
        return $this->hasMany(Oferta::class, 'producto_id');
    }
}
