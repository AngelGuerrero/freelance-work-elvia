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

        return view('user_list', $data);
    }

    /** 
     * Muestra el formulario para crear un nuevo usuario
     */
    public function new()
    {
        return view('create_user_form');
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

        // Crear un nuevo usuario
        $userModel = new UserModel();
        $userModel->insert([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        return view('success', [
            'message' => 'Usuario creado correctamente',
        ]);
    }

    /**
     * Elimina un usuario
     */
    public function delete($id = null)
    {
        // Eliminar el usuario
        $userModel = new UserModel();
        $userModel->delete($id);

        return view('success', [
            'message' => 'Usuario eliminado correctamente',
        ]);
    }
}