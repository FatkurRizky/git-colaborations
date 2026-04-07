<x-layouts.auth title="Login">
    <div class="grid min-h-screen lg:grid-cols-2">

        <div class="flex items-center justify-center px-6 py-10 sm:px-10 order-2 lg:order-1 bg-slate-50/50">
            <div class="w-full max-w-md relative">
                <div class="rounded-3xl bg-white p-8 shadow-xl ring-1 ring-slate-200 sm:p-10">
                    <div class="text-center mb-10">
                        <h2 class="text-3xl font-black text-gray-900 tracking-tight">Login Kalkulator</h2>
                        <p class="mt-2 text-sm text-slate-500">
                            Selamat datang kembali, silakan login
                        </p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block text-sm font-bold text-slate-700 ml-1 mb-2" for="email">Email Address</label>
                            <input type="email" name="email" id="email"
                                class="block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100"
                                placeholder="nama@email.com" required>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-bold text-slate-700 ml-1 mb-2">Password</label>
                            <div class="relative group">
                                <input type="password" name="password" id="password"
                                    class="block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 pr-12 text-sm text-slate-900 shadow-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 font-mono"
                                    placeholder="••••••••" required>

                                <button type="button" onclick="togglePassword()"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-emerald-600 transition-colors focus:outline-none z-10">
                                    
                                    <svg id="eye-open" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>

                                    <svg id="eye-closed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21 21m-2.102-2.102L12 12m0 0L6.878 6.878m0 0A9.965 9.965 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button type="submit"
                            class="inline-flex w-full items-center justify-center rounded-2xl bg-emerald-600 px-4 py-4 text-sm font-bold text-white shadow-lg shadow-emerald-800/20 transition hover:bg-emerald-700 active:scale-95">
                            Masuk Sekarang
                        </button>
                    </form>

                    <p class="text-center mt-8 text-sm text-gray-500">
                        Belum Punya Akun? 
                        <a href="{{ route('register') }}" class="text-emerald-600 font-bold hover:underline">Daftar Gratis</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="hidden lg:flex flex-col justify-between bg-gradient-to-br from-slate-950 via-emerald-900 to-slate-800 p-12 text-white order-1 lg:order-2">
            <div>
                <div class="inline-flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 backdrop-blur">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M4 12h16M4 17h10" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold italic-none">Kalkulator Rekon</h1>
                        <p class="text-sm text-slate-300 italic-none">Registrasi Akun</p>
                    </div>
                </div>

                <div class="mt-16 max-w-xl">
                    <h2 class="text-4xl font-bold leading-tight">
                        Buat akun baru untuk mulai menggunakan sistem.
                    </h2>
                    <p class="mt-5 text-lg leading-8 text-slate-200">
                        Akun yang dibuat dari halaman ini akan terdaftar sebagai karyawan dan dapat langsung menggunakan fitur rekon kas.
                    </p>
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
                <p class="text-sm leading-7 text-slate-200 italic-none">
                    Setelah registrasi, pengguna akan langsung masuk ke sistem dan dapat mulai menginput data rekon.
                </p>
            </div>
        </div>
    </div>
</x-layouts.auth>

<script>
    function togglePassword() {
        const passwordField = document.getElementById('password');
        const eyeOpen = document.getElementById('eye-open');
        const eyeClosed = document.getElementById('eye-closed');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        } else {
            passwordField.type = 'password';
            eyeOpen.classList.add('hidden'); // Perbaikan typo 'eyeOpem'
            eyeClosed.classList.remove('hidden');
        }
    }
</script>