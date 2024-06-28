<x-app-layout>
  @if ($user !== null)
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{$user->name}}
      </h2>
    </x-slot>

    <div class="py-12">
      <p>{{$user}}</p>
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
