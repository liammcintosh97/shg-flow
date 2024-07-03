<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
  public string $password = '';
  public $user;
 
  public function mount($user)
  {
    $this->user = $user;
  }

  public function deleteUser(): void
  {
    $this->user->delete();

    $this->redirect('/users', navigate: true);
  }
}; ?>

<section class="space-y-6">
  <header>
    <h2 class="text-lg font-medium text-gray-900">
      {{ __('Delete User') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600">
      {{ __('Once this user is deleted, all of its resources and data will be permanently deleted. Before deleting the user, please download any data or information that you wish to retain.') }}
    </p>
  </header>

  <x-danger-button
      x-data=""
      x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
  >{{ __('Delete User') }}</x-danger-button>

  <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
    <form wire:submit="deleteUser" class="p-6">
      <h2 class="text-lg font-medium text-gray-900">
        {{ __('Are you sure you want to delete this user?') }}
      </h2>

      <p class="mt-1 text-sm text-gray-600">
        {{ __('Once this user is deleted, all of its resources and data will be permanently deleted. Before deleting the user, please download any data or information that you wish to retain.') }}
      </p>

      <div class="mt-6 flex justify-end">
        <x-secondary-button x-on:click="$dispatch('close')">
            {{ __('Cancel') }}
        </x-secondary-button>

        <x-danger-button class="ms-3">
            {{ __('Delete User') }}
        </x-danger-button>
      </div>
    </form>
  </x-modal>
</section>
