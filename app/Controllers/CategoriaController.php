<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;

class CategoriaController extends BaseController
{
    public function index()
    {
        $model = new CategoriaModel();
        $data['categorias'] = $model->findAll();
        return view('categorias/index', $data);
    }

    public function store()
    {
        $model = new CategoriaModel();
        
        $data = [
            'nombre' => $this->request->getPost('nombre')
        ];

        if (!$model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to(base_url('categorias'))->with('success', 'Categoría registrada exitosamente.');
    }

    public function update($id)
    {
        $model = new CategoriaModel();
        
        $data = [
            'nombre' => $this->request->getPost('nombre')
        ];

        // Pasamos el id para la regla de validación is_unique condicional
        $model->setValidationRule('nombre', "required|min_length[2]|max_length[50]|is_unique[categoria.nombre,id_categoria,{$id}]");

        if (!$model->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to(base_url('categorias'))->with('success', 'Categoría actualizada exitosamente.');
    }

    public function delete($id)
    {
        $model = new CategoriaModel();
        
        try {
            $model->delete($id);
            return redirect()->to(base_url('categorias'))->with('success', 'Categoría eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('categorias'))->with('error', 'No se puede eliminar la categoría porque está asociada a productos.');
        }
    }
    }
