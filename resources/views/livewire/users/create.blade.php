<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Volt\Component;
use App\Enums\UserType;
use App\Enums\Brand;

new class extends Component {
  public string $name = '';
  public string $email = '';
  public string $number = '';
  public string $asana_id = '';
  public UserType $user_type = UserType::STAFF;
  public $brands = [];
  public string $password = '';
  public string $confirm_password = '';

  public function createUser(): void {
    
  }

}; ?>

<form class='p-8 flex flex-col gap-8' submit="createUser">
  <section class="flex flex-col gap-4">
    <h2 class="text-lg font-medium text-gray-900">{{ __('Profile Details') }}</h2>
    <div class="flex flex-col gap-4 ">
      <div class='flex flex-wrap gap-4 '>
        <div>
          <x-input-label for="name" :value="__('Name')" />
          <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
          <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div>
          <x-input-label for="email" :value="__('Email')" />
          <x-text-input wire:model="email" id="email" name="email" type='email' class="mt-1 block w-full" required autofocus autocomplete="email" />
          <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>
      </div>
      <div class='flex flex-wrap gap-4 '>
        <div>
          <x-input-label for="number" :value="__('Number')" />
          <x-text-input wire:model="number" id="number" name="number" type="tel" class="mt-1 block w-full" required autofocus autocomplete="number" />
          <x-input-error class="mt-2" :messages="$errors->get('number')" />
        </div>
        <div>
          <x-input-label for="asana_id" :value="__('Asana ID')" />
          <x-text-input wire:model="asana_id" id="asana_id" name="asana_id" type='text' class="mt-1 block w-full" required autofocus autocomplete="asana_id" />
          <x-input-error class="mt-2" :messages="$errors->get('asana_id')" />
        </div>
      </div>
      <div class='flex flex-wrap gap-4 '>
        <div>
          <x-input-label for="brands" :value="__('Brands')" />
          <x-select-input 
            wire:model="brands" 
            id="brands"
            name="brands" 
            class="mt-1 block w-full overflow-auto" 
            required 
            autofocus 
            autocomplete="brands"
            multiple
            :options="json_encode(array_map(function ($enum) {
              return [
                'value' => $enum,
                'label' => $enum
              ];
            },Brand::cases()))" />
          <x-input-error class="mt-2" :messages="$errors->get('brands')" />
        </div>
        <div>
          <x-input-label for="user_type" :value="__('User Type')" />
          <x-select-input 
            wire:model="user_type" 
            id="user_type"
            name="user_type" 
            class="mt-1 block w-full" 
            required 
            autofocus
            autocomplete="user_type" 
            :options="json_encode(array_map(function ($enum) {
              return [
                'value' => $enum,
                'label' => $enum
              ];
            },UserType::cases()))" />
          <x-input-error class="mt-2" :messages="$errors->get('brands')" />
        </div>
      </div>
    </div>
  </section>
  <section class="flex flex-col gap-4">
    <h2 class="text-lg font-medium text-gray-900">{{ __('Password') }}</h2>
    <div class='flex flex-wrap gap-4 '>
      <div>
        <x-input-label for="password" :value="__('password')" />
        <x-text-input wire:model="password" id="password" name="password" type="password" class="mt-1 block w-full" required autofocus autocomplete="password" />
        <x-input-error class="mt-2" :messages="$errors->get('password')" />
      </div>
      <div>
        <x-input-label for="confirm_password" :value="__('Confirm Password')" />
        <x-text-input wire:model="confirm_password" id="confirm_password" name="confirm_password" type='password' class="mt-1 block w-full" required autofocus autocomplete="confirm_password" />
        <x-input-error class="mt-2" :messages="$errors->get('confirm_password')" />
      </div>
    </div>
  </section>
  <div>
    <x-primary-button type='submit'>{{ __('Create') }}</x-primary-button>
  </div>
</form>

