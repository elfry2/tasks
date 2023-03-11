<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <a href="{{ route('root') }}">
          <x-button>Go Back</x-button>
        </a><br><br>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            <small><a href="#" id="passwordFieldsVisibilityTogglerLink" style="color: blue; text-decoration: underline;" onclick="togglePasswordFieldsVisibility()">Show passwords</a></small><br><br>
            <small>We did not put much effort into ensuring the security of this application. Please do not use your bank account password. <a href="#" style="color: blue; text-decoration: underline" onclick="generateRandomPassword()">Smash your keyboard</a> instead.</small>
            <script type="text/javascript">
              function generateRandomPassword(){
                var chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                var length = 32;
                var password = "";

                for (var i = 0; i < length; i++) {
                  var randomNumber = Math.floor(Math.random() * chars.length);
                  password += chars.substring(randomNumber, randomNumber +1);
                }

                document.getElementById("password").value = password;
                document.getElementById("password_confirmation").value = password;
              }

              function togglePasswordFieldsVisibility(){
                var passwordField, passwordConfirmationField;

                passwordField = document.getElementById("password");
                passwordConfirmationField = document.getElementById("password_confirmation");
                passwordFieldsVisibilityTogglerLink = document.getElementById("passwordFieldsVisibilityTogglerLink");

                if (passwordField.type == "password" &&
                passwordConfirmationField.type == "password") {
                  passwordField.type = "text";
                  passwordConfirmationField.type = "text";
                  passwordFieldsVisibilityTogglerLink.innerHTML = "Hide passwords";
                } else {
                  passwordField.type = "password";
                  passwordConfirmationField.type = "password";
                  passwordFieldsVisibilityTogglerLink.innerHTML = "Show passwords";
                }
              }
            </script>
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
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
