<x-guest-layout>
    <h1>{{ __('messages.welcome') }}</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('register.name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name"  />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- University -->
        <label for="university_id" class="col-md-4 col-form-label text-md-right">{{ __('register.university') }}</label>

        <div class="col-md-6">
            <select id="university_id" class="form-control @error('university_id') is-invalid @enderror"
                name="university_id" required>
                @foreach ($universities as $university)
                    <option value="{{ $university->id }}">{{ $university->name }}</option>
                @endforeach
            </select>

            @error('university_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- Field -->
        <label for="field_id" class="col-md-4 col-form-label text-md-right">{{ __('register.field') }}</label>

        <div class="col-md-6">
            <select id="field_id" class="form-control @error('field_id') is-invalid @enderror"
                name="field_id" required>
                @foreach ($fields as $field)
                    <option value="{{ $field->id }}">{{ $field->name }}</option>
                @endforeach
            </select>

            @error('field_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('register.email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('register.password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('register.confirm_password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('register.already_registered') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('register.register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
