<x-layouts.auth title="Register">
    <div class="grid min-h-screen lg:grid-cols-2 bg-white">

        <div class="flex items-center justify-center px-6 py-12 sm:px-12 bg-slate-50/50 order-1">
            <div class="w-full max-w-md relative">
                
                <div class="rounded-[2.5rem] bg-white p-8 shadow-[0_20px_60px_-15px_rgba(0,0,0,0.05)] ring-1 ring-slate-200 sm:p-10 transition-all duration-300 hover:shadow-2xl">
                    <div class="mb-10 text-center lg:text-left">
                        <h2 class="text-3xl font-black text-slate-900 tracking-tight leading-none">Register</h2>
                        <p class="mt-3 text-sm text-slate-500 font-medium italic-none">
                            Buat akun baru untuk mulai menggunakan sistem.
                        </p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 animate-pulse">
                            <div class="flex gap-3">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <p class="text-sm text-red-700 font-semibold">{{ $errors->first() }}</p>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <div class="space-y-1.5">
                            <label for="name" class="block text-sm font-bold text-slate-700 ml-1">Nama Lengkap</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                                class="w-full px-5 py-3.5 bg-white border border-slate-300 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm placeholder:text-slate-400"
                                placeholder="Contoh: Muhammad Ali">
                        </div>

                        <div class="space-y-1.5">
                            <label for="email" class="block text-sm font-bold text-slate-700 ml-1">Alamat Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                class="w-full px-5 py-3.5 bg-white border border-slate-300 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm placeholder:text-slate-400"
                                placeholder="name@email.com">
                        </div>

                        <div class="space-y-1.5">
                            <label for="password" class="block text-sm font-bold text-slate-700 ml-1">Password</label>
                            <div class="relative">
                                <input id="password" name="password" type="password" required
                                    class="w-full px-5 py-3.5 bg-white border border-slate-300 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-mono pr-12"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePass('password', 'eye-open-1', 'eye-closed-1')"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-emerald-600 transition-colors focus:outline-none">
                                    <svg id="eye-open-1" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    <svg id="eye-closed-1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21 21m-2.102-2.102L12 12m0 0L6.878 6.878m0 0A9.965 9.965 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label for="password_confirmation" class="block text-sm font-bold text-slate-700 ml-1">Konfirmasi Password</label>
                            <div class="relative">
                                <input id="password_confirmation" name="password_confirmation" type="password" required
                                    class="w-full px-5 py-3.5 bg-white border border-slate-300 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm font-mono pr-12"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePass('password_confirmation', 'eye-open-2', 'eye-closed-2')"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-emerald-600 transition-colors focus:outline-none">
                                    <svg id="eye-open-2" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    <svg id="eye-closed-2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21 21m-2.102-2.102L12 12m0 0L6.878 6.878m0 0A9.965 9.965 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                                </button>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm text-slate-600 flex items-center justify-between italic-none">
                            <span class="font-medium">Role Default:</span>
                            <span class="font-black text-slate-900 uppercase">Karyawan</span>
                        </div>

                        <button type="submit"
                            class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-2xl shadow-xl shadow-emerald-800/20 transition-all hover:-translate-y-1 active:scale-95 text-sm uppercase tracking-widest">
                            Daftar Sekarang
                        </button>

                        <p class="text-center text-sm text-slate-500 mt-8 italic-none">
                            Sudah punya akun? <a href="{{ route('login') }}" class="font-black text-emerald-600 hover:text-emerald-700 transition-colors">LOGIN DISINI</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>

        <div class="hidden lg:flex flex-col justify-between bg-gradient-to-br from-slate-950 via-emerald-900 to-slate-800 p-12 text-white order-2">
            <div>
                <div class="inline-flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 backdrop-blur-md border border-white/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M4 12h16M4 17h10" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-tight italic-none">Kalkulator Rekon</h1>
                        <p class="text-xs text-emerald-400 font-medium tracking-widest uppercase italic-none">Registrasi Akun</p>
                    </div>
                </div>

                <div class="mt-20 max-w-lg">
                    <h2 class="text-4xl font-extrabold leading-tight tracking-tight">
                        Buat akun baru untuk mulai menggunakan sistem.
                    </h2>
                    <p class="mt-6 text-lg leading-relaxed text-slate-300 opacity-90 italic-none">
                        Akun yang dibuat dari halaman ini akan terdaftar sebagai karyawan dan dapat langsung menggunakan fitur rekon kas.
                    </p>
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm shadow-inner italic-none text-slate-200 text-sm leading-relaxed">
                Setelah registrasi, pengguna akan langsung masuk ke sistem dan dapat mulai menginput data rekon.
            </div>
        </div>

    </div>
</x-layouts.auth>

<script>
    function togglePass(fieldId, openIconId, closedIconId) {
        const field = document.getElementById(fieldId);
        const eyeO = document.getElementById(openIconId);
        const eyeC = document.getElementById(closedIconId);

        if (field.type === 'password') {
            field.type = 'text';
            eyeO.classList.remove('hidden');
            eyeC.classList.add('hidden');
        } else {
            field.type = 'password';
            eyeO.classList.add('hidden');
            eyeC.classList.remove('hidden');
        }
    }
</script>