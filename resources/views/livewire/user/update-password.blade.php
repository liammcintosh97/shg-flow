<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
  public string $current_password = '';
  public string $password = '';
  public string $password_confirmation = '';
  public $user;
  public $self;

  public function mount($user)
  {
    $this->user = $user;
    $this->self = $user->is(auth()->user());
  }


  /**
   * Update the password for the currently authenticated user.
   */
  public function updatePassword(): void
  {
    $rules = [ 
      'password' => ['required', 'string', Password::defaults(), 'confirmed'],
      'current_password' => []
  ];

    if($this->self){
      $rules->current_password = ['required', 'string', 'current_password'];
    }

    try {
      $validated = $this->validate($rules);
    } catch (ValidationException $e) {
      $this->reset('current_password', 'password', 'password_confirmation');

      throw $e;
    }

    $this->user->update([
      'password' => Hash::make($validated['password']),
    ]);

    $this->reset('current_password', 'password', 'password_confirmation');

    $this->dispatch('password-updated');
  }
}; ?>

<section>
  <header>
    <h2 class="text-lg font-medium text-gray-900">
      {{ __('Update Password') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600">
      {{ __('Ensure the password is long and random to stay secure.') }}
    </p>
  </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
      @if ($this->self)
        <div>
          <x-input-label for="update_password_current_password" :value="__('Current Password')" />
          <x-text-input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
          <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>
      @endif

      <div>
        <x-input-label for="update_password_password" :value="__('New Password')" />
        <x-text-input wire:model="password" id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
      </div>

      <div>
        <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
        <x-text-input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
      </div>

      <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Save') }}</x-primary-button>

        <x-action-message class="me-3" on="password-updated">
          {{ __('Saved.') }}
        </x-action-message>
      </div>
    </form>
</section>
