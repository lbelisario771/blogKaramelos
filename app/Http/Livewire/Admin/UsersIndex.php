<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class UsersIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap"; //para usar las clases de bootstrap
    public $search;
    public function updatingsearch()
    {
        $this->resetPage();

    }

        

    public function render()
    {
        
        $users = User::where('name', 'LIKE', '%'. $this->search . '%')
                        ->orWhere('email', 'LIKE', '%'. $this->search . '%')
                        ->latest('id')
                        ->paginate();
        return view('livewire.admin.users-index', compact('users'));
    }
}
