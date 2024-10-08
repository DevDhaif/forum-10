<x-guest-layout>
    <h1 class="text-3xl text-center my-4">{{ __('messages.welcome') }}</h1>
    {{-- set class tex-right or text-left based on the locale --}}
    <form method="POST" action="{{ route('register') }}" class="text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" class="" :value="__('register.name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name"  />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- University -->
        <div class="flex flex-col space-y-6 mt-4">
            <!-- University Field -->
            <div class="flex flex-col">
                {{-- <label for="university_id" class="">{{ __('register.university') }}</label> --}}
<x-input-label for="university_id" :value="__('register.university')" />
                <select id="university_id" name="university_id" required
                    class="mt-2 rounded-md border-2 border-blue-500 focus:ring-blue-500 focus:border-blue-500 w-full px-3 py-2 bg-white text-gray-900 shadow-sm @error('university_id') border-red-500 @enderror">
                    @foreach ($universities as $university)
                        <option value="{{ $university->id }}">{{ $university->name }}</option>
                    @endforeach
                </select>
                @error('university_id')
                    <span class="text-sm text-red-500 mt-1">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Field -->
            <div class="flex flex-col">
                {{-- <label for="field_id" class="">{{ __('register.field') }}</label> --}}
<x-input-label for="field_id" :value="__('register.field')" />
                <select id="field_id" name="field_id" required
                    class="mt-2 rounded-md border-2 border-blue-500 focus:ring-blue-500 focus:border-blue-500 w-full px-3 py-2 bg-white text-gray-900 shadow-sm @error('field_id') border-red-500 @enderror">
                    @foreach ($fields as $field)
                        <option value="{{ $field->id }}">{{ $field->name }}</option>
                    @endforeach
                </select>
                @error('field_id')
                    <span class="text-sm text-red-500 mt-1">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>


        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" class="" :value="__('register.email')" />
            <x-text-input id="email" class="block mt-1 w-full text-xl" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4" >
            <x-input-label class="" for="password"  :value="__('register.password')" />

            <x-text-input id="password" class="block mt-1 w-full text-xl" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" class="" :value="__('register.confirm_password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4 ">
            <a class="underline  text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('register.already_registered') }}
            </a>

            <x-primary-button class="ml-4 !text-lg">
                {{ __('register.register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
