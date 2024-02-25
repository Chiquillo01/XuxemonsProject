<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    // Función para registarar los usuarios
    public function register(Request $request)
    {
        $user = new User();

        if ($request->rol) {
            $rolStatus = true;
        } else {
            $rolStatus = false;
        }

        $user->nick = $request->nick;
        $user->email = $request->email;
        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;
        $user->dni = $request->dni;
        $user->fecha = $request->fecha;
        $user->password = Hash::make($request->password);
        $user->rol = $rolStatus;

        $user->save();

        Auth::login($user);

        // Después de registrar al usuario, puedes almacenar un mensaje en la sesión
        Session::flash('success', '¡Usuario registrado correctamente!');

        return redirect(route('login'));
    }

    // Función para logear al usuario tanto como admin como normal
    public function login(Request $request)
    {

        // Validación  de las credenciales
        $credentials = [
            "email" => $request->email,
            "password" => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Verificar el rol del usuario
            if (Auth::user()->rol == 1) {
                // Usuario Administrador
                return redirect(route('admin.privada'))->with('success', 'Acceso exitoso.');
            } else {
                // Usuario Normal
                return redirect(route('privada'))->with('success', 'Acceso exitoso.');
            }
        } else {
            return redirect('login')->with('error', 'Usuario o contraseña incorrectos.');
        }
    }

    // Función para salir de la sesión
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

       return redirect('/login')->with('success', 'Has cerrado sesión correctamente.');
    }

    public function showUser()
    {
        // Lógica para obtener los productos del catálogo desde la base de datos
        $Users = User::all();

        // Retorna la vista con los datos
        return view('admin.User', compact('Users'));
    }

    public function crearProductoForm()
    {
        return view('admin.crearProducto');
    }

    public function crearProducto(Request $request)
    {
        // Lógica para validar y guardar el nuevo producto en la base de datos
        $nuevoProducto = new User([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'unidades' => $request->input('unidades'),
            'precio_unitario' => $request->input('precio_unitario'),
            'categoria' => $request->input('categoria'),
        ]);

        $nuevoProducto->save();

        // Redirige de nuevo a la vista del catálogo
        return redirect(route('admin.User'))->with('success', 'Producto creado exitosamente.');
    }

    public function eliminarProducto($id)
    {
        // Buscar el producto por ID
        $producto = User::find($id);

        if (!$producto) {
            // Si el producto no existe, redirigir con un mensaje de error
            return redirect()->route('admin.User')->with('error', 'El producto no existe.');
        }

        // Eliminar el producto
        $producto->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.User')->with('success', 'Producto eliminado exitosamente.');
    }
}
