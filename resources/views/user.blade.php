<x-app-layout>
  @if ($user !== null)
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{$user->name}}
      </h2>
    </x-slot>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class=" p-12 bg-white shadow-sm sm:rounded-lg">
          <div class="flex flex-col gap-4">
            <div>
              <h3 class="text-m font-medium text-gray-900">{{__('Email')}}</h3>
              <p class="min-h-4">{{$user->email}}</p>
            </div>
            <div>
              <h3 class="text-m font-medium text-gray-900">{{__('Number')}}</h3>
              <p class="min-h-4">{{$user->number}}</p>
            </div>
            <div>
              <h3 class="text-m font-medium text-gray-900">{{__('User Type')}}</h3>
              <p class="min-h-4">{{$user->user_type}}</p>
            </div>
            <div>
              <h3 class="text-m font-medium text-gray-900">{{__('Asana ID')}}</h3>
              <p class="min-h-4">{{$user->asana_id}}</p>
            </div>
            <div>
              <h3 class="text-m font-medium text-gray-900">{{__('Brands')}}</h3>
              <p class="min-h-4">{{implode($user->brands)}}</p>
            </div>
          </div>
          <div class="flex gap-4 flex-wrap mt-8">
            <div class="flex gap-2 flex-wrap">
              <p class="text-xs text-gray-400">{{ __('Created') }}</pr>
              <p class="text-xs text-gray-400">{{$user->created_at}}</p>
            </div>

            <div class="flex gap-2 flex-wrap">
              <p class="text-xs text-gray-400">{{ __('Updated') }}</pr>
              <p class="text-xs text-gray-400">{{$user->updated_at}}</p>
            </div>
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
