<x-layouts.guest>
    <div class="container flex flex-col items-center justify-center">
        <x-logo class="mb-4 h-auto w-24" />
        <div
            class="max-w-1/3 w-full rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <form class="space-y-6" action="{{ route('register.post') }}" method="POST">
                @csrf
                @method('POST')
                <h5 class="text-xl font-medium text-gray-900 dark:text-white">Crie sua conta</h5>
                <div>
                    <x-forms.input name="name" label="Seu nome" placeholder="Seu nome completo" />
                </div>
                <div>
                    <x-forms.input name="email" type="email" label="Seu email" placeholder="name@company.com" />
                </div>
                <div>
                    <x-forms.input name="password" type="password" label="Sua senha" placeholder="••••••••" />
                </div>
                <x-solid.primary-button type="submit" class="w-full">Criar conta</x-solid.primary-button>
                <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                    Já tem uma conta? <a href="{{ route('login') }}"
                        class="text-blue-700 hover:underline dark:text-blue-500">
                        Fazer login
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.guest>
