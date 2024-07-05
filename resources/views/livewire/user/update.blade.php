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
  public string $name = '';
  public string $email = '';
  public string $number = '';
  public string $asana_id = '';
  public string $user_type = UserType::STAFF->value;
  public $brands = [];
  public $user;
 
  public function mount($user)
  {
    $this->user = $user;
    $this->name = $user->name;
    $this->email = $user->email;
    $this->number = $user->number;
    $this->asana_id = $user->asana_id;
    $this->user_type = $user->user_type->value;
    $this->brands = $user->brands;
  }

  public function store(): void {

    $rules = [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user->id)],
      'number' => ['required', 'string', 'max:255'],
      'asana_id' => ['required', 'numeric'],
      'user_type' => ['required'],
      'brands' => ['required'],
    ];

    $validated = $this->validate($rules);

    $this->user->email = $validated['email'];
    $this->user->name = $validated['name'];
    $this->user->number = $validated['number'];
    $this->user->asana_id =  $validated['asana_id'];
    $this->user->user_type = $validated['user_type'];
    $this->user->brands = $validated['brands'];

    if ($validated['user_type'] === UserType::STAFF->value) {
      $this->user->password = '';
    }

    $this->user->save();
  }

}; ?>

<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
      <div class="max-w-xl">
        <form class='flex flex-col gap-8' wire:submit="store">
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
              :disabled="$this->user->id === auth()->user()->id"
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
          <div>
            @if (isset($this->user))
              <x-primary-button>{{ __('Update') }}</x-primary-button>
            @else
              <x-primary-button>{{ __('Create') }}</x-primary-button>
            @endif
          </div>
        </form>
      </div>
    </div>
    
    @if ($this->user_type === UserType::ADMIN->value)
      <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
          <livewire:user.update-password :user="$this->user">
        </div>
      </div>
    @endif

    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
      <div class="max-w-xl">
        <livewire:user.delete :user="$user">
      </div>
    </div>

  </div>
</div>

