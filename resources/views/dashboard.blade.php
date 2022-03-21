<x-app-layout>
    <x-slot name="header">
        <div class="py-0 flex justify-between items-top">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="{{ route('dashboard') }}">{{ __('Dashboard') }} </a>
            </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-1 sm:px-6 lg:px-8">
            <div class=""> 

                
                @livewire('all-jobs-in-progress', [ 
                        'user' => auth()->user()
                        ])


                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-10">
                    <div class="">


                        <div class="px-1 py-6 sm:px-6 bg-gray-400 overflow-hidden shadow-xl rounded-lg text-gray-800">

                            <form action="{{ route('startJob') }}" method='POST' enctype='multipart/form-data' id="job">
                                @csrf
                                <div class="mt-4 p-1 bg-gray-200 items-center shadow-xl rounded-md">


                                    <div class="flex justify-between">                                  
                                        <div class="">
                                            <input class="m-1" type='submit' name='share_to_followers' value="{{ __('Start Job') }}"></input>
                                        </div>
                                    </div>
                                </div>
                            </form>       

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

