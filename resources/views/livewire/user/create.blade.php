<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Illuminate\Validation\Rules\Password;
use App\Enums\UserType;
use App\Enums\Brand;
use Illuminate\Http\RedirectResponse;

new class extends Component {
  public string $name = 'Jane Doe';
  public string $email = 'jane.doe@email.com';
  public string $number = '0449609700';
  public string $asana_id = '1234';
  public string $user_type = UserType::ADMIN->value;
  public $brands = [BRAND::TSG->value];
  public string $password = '';
  public string $password_confirmation = '';
  public string $hashed_password = '';

  public function createUser(): void {
    $user = Auth::user();

    $rules = [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)],
      'number' => ['required', 'string', 'max:255'],
      'asana_id' => ['required', 'numeric'],
      'user_type' => ['required'],
      'hashed_password' => [],
      'brands' => ['required'],
    ];

    if ($this->user_type == UserType::ADMIN->value){
      $rules['hashed_password'] = ['required'];
    }

    $validated = $this->validate($rules);

    $newUser = new User;
    $newUser->password = $validated['hashed_password'];
    $newUser->email = $validated['email'];
    $newUser->name = $validated['name'];
    $newUser->number = $validated['number'];
    $newUser->asana_id =  $validated['asana_id'];
    $newUser->user_type = $validated['user_type'];
    $newUser->brands = $validated['brands'];

    $newUser->save();

    $this->redirect('/users', navigate: true);
  }

  public function onConfirmPasswordChange(): void {

    $validated = $this->validate([
      'password' => ['required', 'string', Password::defaults(), 'confirmed'],
    ]);
    
    $this->hashed_password =  Hash::make($validated['password']);
  }
}; ?>

<form class='p-8 flex flex-col gap-8' wire:submit="createUser">
  <h2 class="text-lg font-medium text-gray-900">{{ __('Profile Details') }}</h2>

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

  <div>
    <x-input-label for="number" :value="__('Number')" />
    <x-text-input wire:model="number" id="number" name="number" type="tel" class="mt-1 block w-full" required autofocus autocomplete="number" />
    <x-input-error class="mt-2" :messages="$errors->get('number')" />
  </div>

  <div>
    <x-input-label for="asana_id" :value="__('Asana ID')" />
    <x-text-input wire:model="asana_id" id="asana_id" name="asana_id" type='number' class="mt-1 block w-full" required autofocus autocomplete="asana_id" />
    <x-input-error class="mt-2" :messages="$errors->get('asana_id')" />
  </div>

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
      },Brand::values()))" />
    <x-input-error class="mt-2" :messages="$errors->get('brands')" />
  </div>

  <div>
    <x-input-label for="user_type" :value="__('User Type')" />
    <x-select-input 
      wire:model.live="user_type" 
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
      },UserType::values()))" />
    <x-input-error class="mt-2" :messages="$errors->get('user_type')" />
  </div>
  
  @if ($user_type == UserType::ADMIN->value)
    <div>
      <x-input-label for="password" :value="__('password')" />
      <x-text-input wire:model="password" id="password" name="password" type="password" class="mt-1 block w-full" required autofocus autocomplete="password" />
      <x-input-error class="mt-2" :messages="$errors->get('password')" />
        <x-input-error class="mt-2" :messages="$errors->get('hashed_password')" />
    </div>

    <div>
      <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
      <x-text-input wire:model="password_confirmation" wire:change="onConfirmPasswordChange" id="password_confirmation" name="password_confirmation" type='password' class="mt-1 block w-full" required autofocus autocomplete="confirm_password" />
    </div>
  @endif
  <div>
    <x-primary-button>{{ __('Create') }}</x-primary-button>
  </div>
</form>
