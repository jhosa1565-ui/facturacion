<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use App\Models\MarcaModel;

class ProductoController extends BaseController
{
    protected $productoModel;
    protected $categoriaModel;
    protected $marcaModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
        $this->marcaModel = new MarcaModel();
    }

    public function index()
    {
        // Obtener productos junto con el nombre de su categoría y marca usando consultas relacionales o joins
        $db = \Config\Database::connect();
        $builder = $db->table('producto');
        $builder->select('producto.*, categoria.nombre as categoria_nombre, marca.nombre as marca_nombre');
        $builder->join('categoria', 'categoria.id_categoria = producto.id_categoria');
        $builder->join('marca', 'marca.id_marca = producto.id_marca');
        
        $data['productos'] = $builder->get()->getResultArray();
        $data['categorias'] = $this->categoriaModel->findAll();
        $data['marcas'] = $this->marcaModel->findAll();

        return view('productos/index', $data);
    }

    public function guardar()
    {
        $id = $this->request->getPost('id_producto');
        
        $data = [
            'codigo_barras' => trim($this->request->getPost('codigo_barras')),
            'nombre'        => trim($this->request->getPost('nombre')),
            'id_categoria'  => $this->request->getPost('id_categoria'),
            'id_marca'      => $this->request->getPost('id_marca'),
            'precio_venta'  => $this->request->getPost('precio_venta'),
            'stock'         => $this->request->getPost('stock')
        ];

        if (!empty($id)) {
            $data['id_producto'] = $id;
        }

        if (!$this->productoModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->productoModel->errors());
        }

        $mensaje = empty($id) ? 'Producto registrado con éxito.' : 'Producto actualizado con éxito.';
        return redirect()->to(base_url('productos'))->with('success', $mensaje);
    }

    public function eliminar($id)
    {
        try {
            $this->productoModel->delete($id);
            return redirect()->to(base_url('productos'))->with('success', 'Producto eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('productos'))->with('error', 'No se puede eliminar el producto porque está asociado a ventas o compras.');
        }
    }
}