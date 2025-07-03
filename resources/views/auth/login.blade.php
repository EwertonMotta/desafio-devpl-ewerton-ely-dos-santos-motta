<x-layouts.guest>
    <div class="container flex flex-col items-center justify-center">
        <x-logo class="mb-4 h-auto w-24" />
        <div
            class="max-w-1/3 w-full rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <form class="space-y-6" action="{{ route('login.post') }}" method="POST">
                @csrf
                @method('POST')
                <h5 class="text-xl font-medium text-gray-900 dark:text-white">Faça login na sua conta</h5>
                <x-forms.input name="email" type="email" label="Seu e-mail" placeholder="name@company.com" />
                <x-forms.input name="password" type="password" label="Senha" placeholder="••••••••" />
                <x-solid.primary-button type="submit" class="w-full">Logar na sua conta</x-solid.primary-button>
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
