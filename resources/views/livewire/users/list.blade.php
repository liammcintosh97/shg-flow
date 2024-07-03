<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
  public Collection $users;

  public function mount(): void
  {
    $this->getUsers();
  }

  public function getUsers(): void {
    $this->users = User::all();
  }

}; ?>

<div class="p-8 flex">
  <div class="flex-1 overflow-auto">
    <div class="flex flex-row justify-end p-4">
      <x-primary-button>
        <a href="create-user"  wire:navigate>
          {{ __('Create') }}
        </a>
      </x-primary-button>
    </div>
    <table class="table-auto w-full">
      <tr class="border-b border-gray-200">
        <th class="text-left py-4 pr-8">Name</th>
        <th class="text-left py-4 pr-8">Email</th>
        <th class="text-left py-4 pr-8">Brands</th>
        <th></th>
      </tr>
      @foreach ($users as $user)
        <tr class="border-b border-gray-100">
          <td class="py-4 pr-8">{{$user->name}}</td>
          <td class="py-4 pr-8">{{$user->email}}</td>
          <td class="py-4 pr-8">{{implode(",",$user->brands)}}</td>
          <td class="py-4 pr-8">
            @if ($user->is(auth()->user()))
              <a href="profile"  wire:navigate>
                {{ __('View') }}
              </a>       
            @else
              <a href="users/{{$user->id}}"  wire:navigate>
                {{ __('View') }}
              </a>
            @endif
        </td>
        </tr>
      @endforeach
    </table>
  </div>
</div>
