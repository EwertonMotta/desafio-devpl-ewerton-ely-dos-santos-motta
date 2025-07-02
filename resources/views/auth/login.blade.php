<x-layouts.guest>
    <div class="container flex flex-col items-center justify-center">
        <x-logo class="mb-4 h-auto w-24" />
        <div
            class="max-w-1/3 w-full rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <form class="space-y-6" action="{{ route('login.post') }}" method="POST">
                @csrf
                @method('POST')
                <h5 class="text-xl font-medium text-gray-900 dark:text-white">Faça login na sua conta</h5>
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                        Seu email
                    </label>
                    <input type="email" name="email" id="email"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                        placeholder="name@company.com" />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                            <span class="font-medium">Ops!</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                        Sua senha
                    </label>
                    <input type="password" name="password" id="password" placeholder="••••••••"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400" />

                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                            <span class="font-medium">Ops!</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="flex items-start">
                    <div class="flex items-start">
                        <div class="flex h-5 items-center">
                            <input id="remember" type="checkbox" value=""
                                class="focus:ring-3 h-4 w-4 rounded-sm border border-gray-300 bg-gray-50 focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800" />
                        </div>
                        <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Lembrar de mim
                        </label>
                    </div>
                    <a href="#" class="ms-auto text-sm text-blue-700 hover:underline dark:text-blue-500">
                        Esqueceu a senha?
                    </a>
                </div>
                <button type="submit"
                    class="w-full rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Login na sua conta
                </button>
                <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                    Não tem uma conta? <a href="{{ route('register') }}"
                        class="text-blue-700 hover:underline dark:text-blue-500">
                        Criar conta
                    </a>
                </div>
            </form>
        </div>

    </div>
</x-layouts.guest>
