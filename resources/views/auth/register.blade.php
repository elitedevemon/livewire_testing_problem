<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="mt-1" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-3">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="mt-1" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-8">
                <!--<x-label for="password" :value="__('Password for ').env('APP_NAME')" />-->
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="mt-1"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-3">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="mt-1"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="mt-8">
                <div class="g-recaptcha flex justify-center" data-sitekey="{{ Config::get('services.recaptcha.key') }}"></div>
            
                @if(Session::has('g-recaptcha-response'))
                <p class="text-red-500 flex justify-center mt-2 font-bold">
                    {!! Session::get('g-recaptcha-response') !!}
                </p>
                @endif
            </div>

            <div class="mt-6 italic text-gray-700">
                By creating this account, you are confirming that you have read and agreed to {{ env('APP_NAME') }}’s <a href="{{ route('page', [ 'page' => 'terms-of-service']) }}" class="underline">Terms of Service</a> and <a href="{{ route('page', [ 'page' => 'privacy-policy']) }}" class="underline">Privacy Policy</a>.
            </div>  

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
