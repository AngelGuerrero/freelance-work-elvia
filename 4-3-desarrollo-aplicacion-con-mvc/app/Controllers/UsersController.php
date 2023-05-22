<?php

namespace App\Controllers;

use App\Models\UserModel;

class UsersController extends BaseController
{
    /**
     * Muestra la lista de usuarios
     */
    public function index()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();

        return view('user_list');
    }

    /** 
     * Muestra el formulario para crear un nuevo usuario
     */
    public function new()
    {
        # code...
    }

    /**
     * Crea un nuevo usuario
     */
    public function create()
    {
        // Obtener los datos del formulario
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        return view('welcome_message');
    }

    /**
     * Elimina un usuario
     */
    public function delete($id = null)
    {
        # code...
    }
}