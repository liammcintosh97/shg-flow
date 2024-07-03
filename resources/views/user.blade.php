<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{__('User')}}
    </h2>
  </x-slot>
  @if (isset($user))
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
          <livewire:user.view :user="$user">
        </div>
      </div>

      <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
          <livewire:user.delete :user="$user">
        </div>
      </div>
    </div>
  </div>
  @else
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class=" p-12 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <h1>404 - User not found</h1>
      </div>
    </div>
  </div>
  @endif
</x-app-layout>
