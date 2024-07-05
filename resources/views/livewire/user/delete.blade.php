<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
  public string $password = '';
  public $user;
  public $self;

  public function mount($user)
  {
    $this->user = $user;
    $this->self = $user->is(auth()->user());
  }


  /**
   * Delete the currently authenticated user.
   */
  public function deleteUser(Logout $logout): void
  {
    if($this->self) {
      $this->validate([
        'password' => ['required', 'string', 'current_password'],
      ]);

      tap(Auth::user(), $logout(...))->delete();
    }
    else {
      $this->user->delete();
      $this->redirect('/users', navigate: true);
    }
  }
}; ?>

<section class="space-y-6">
  <header>
    <h2 class="text-lg font-medium text-gray-900">
      {{ __('Delete Account') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600">
      {{ __('All resources and data will be permanently deleted. Before deletion, please download any data or information that you wish to retain.') }}
    </p>
  </header>

  <x-danger-button
      x-data=""
      x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
  >{{ __('Delete Account') }}</x-danger-button>

  <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
    <form wire:submit="deleteUser" class="p-6">

      <h2 class="text-lg font-medium text-gray-900">
        {{ __('Are you sure?') }}
      </h2>

      <p class="mt-1 text-sm text-gray-600">
        {{ __('All resources and data will be permanently deleted. Before deletion, please download any data or information that you wish to retain.') }}
      </p>

      @if($this->self)
        <div class="mt-6">
          <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

          <x-text-input
              wire:model="password"
              id="password"
              name="password"
              type="password"
              class="mt-1 block w-3/4"
              placeholder="{{ __('Password') }}"
          />

          <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
      @endif

      <div class="mt-6 flex justify-end">
        <x-secondary-button x-on:click="$dispatch('close')">
          {{ __('Cancel') }}
        </x-secondary-button>

        <x-danger-button class="ms-3">
          {{ __('Delete Account') }}
        </x-danger-button>
      </div>
    </form>
  </x-modal>
</section>
