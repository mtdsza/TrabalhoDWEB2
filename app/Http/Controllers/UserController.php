<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use App\Models\Profissional;

class UserController extends Controller
{
    public function index()
    {
        return view('usuarios.index', ['usuarios' => User::all()]);
    }

    public function create()
    {
        $linkedProfessionalIds = User::whereNotNull('id_profissional')->pluck('id_profissional');
        $profissionais = Profissional::whereNotIn('id_profissional', $linkedProfessionalIds)->get();
        return view('usuarios.create', ['profissionais' => $profissionais]);
    }

    public function edit(User $usuario)
    {
        $this->authorize('manage-users');
        return view('usuarios.edit', ['usuario' => $usuario]);
    }

    public function update(Request $request, User $usuario)
    {
        $this->authorize('manage-users');

        $request->validate([
            'login' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($usuario->id)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($usuario->id)],
            'tipo' => ['required', 'string', 'in:Admin,Secretaria,Profissional'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $dados = $request->only('login', 'email', 'tipo');
        if ($request->filled('password')) {
            $dados['password'] = Hash::make($request->password);
        }

        $usuario->update($dados);

        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'tipo' => ['required', 'string', 'in:Admin,Secretaria,Profissional'],
            'id_profissional' => ['required_if:tipo,Profissional', 'nullable', 'exists:profissionais,id_profissional'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'login' => $request->login,
            'email' => $request->email,
            'tipo' => $request->tipo,
            'id_profissional' => $request->id_profissional,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuário criado com sucesso.');
    }
    
    public function destroy(User $usuario)
    {
        $this->authorize('manage-users');
        if (auth()->user()->id === $usuario->id) {
            return redirect()->route('usuarios.index')->with('error', 'Você não pode excluir a si mesmo.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuário excluído com sucesso.');
    }
}