<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <title>Integridad Laboral</title>
        <link href="https://fonts.googleapis.com" rel="preconnect"/>
        <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&amp;display=swap" rel="stylesheet"/>
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <script>
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        colors: {
                            "primary": "#1173d4",
                            "background-light": "#f6f7f8",
                            "background-dark": "#101922"
                        },
                        fontFamily: {
                            "display": ["Manrope"]
                        },
                        borderRadius: {
                            "DEFAULT": "0.25rem",
                            "lg": "0.5rem",
                            "xl": "0.75rem",
                            "full": "9999px"
                        }
                    }
                }
            }
        </script>
        <!-- Favicons -->
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicon/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicon/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicon/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicon/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicon/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicon/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicon/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicon/android-icon-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('favicon/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
        <meta name="theme-color" content="#ffffff">
    </head>
    <body class="bg-background-light dark:bg-background-dark font-display text-gray-800 dark:text-gray-200">
        <div class="relative min-h-screen">
            <header class="absolute top-0 left-0 right-0 z-20">
                <nav class="container mx-auto flex items-center justify-between p-6">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 text-primary">
                            <svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd" d="M39.475 21.6262C40.358 21.4363 40.6863 21.5589 40.7581 21.5934C40.7876 21.655 40.8547 21.857 40.8082 22.3336C40.7408 23.0255 40.4502 24.0046 39.8572 25.2301C38.6799 27.6631 36.5085 30.6631 33.5858 33.5858C30.6631 36.5085 27.6632 38.6799 25.2301 39.8572C24.0046 40.4502 23.0255 40.7407 22.3336 40.8082C21.8571 40.8547 21.6551 40.7875 21.5934 40.7581C21.5589 40.6863 21.4363 40.358 21.6262 39.475C21.8562 38.4054 22.4689 36.9657 23.5038 35.2817C24.7575 33.2417 26.5497 30.9744 28.7621 28.762C30.9744 26.5497 33.2417 24.7574 35.2817 23.5037C36.9657 22.4689 38.4054 21.8562 39.475 21.6262ZM4.41189 29.2403L18.7597 43.5881C19.8813 44.7097 21.4027 44.9179 22.7217 44.7893C24.0585 44.659 25.5148 44.1631 26.9723 43.4579C29.9052 42.0387 33.2618 39.5667 36.4142 36.4142C39.5667 33.2618 42.0387 29.9052 43.4579 26.9723C44.1631 25.5148 44.659 24.0585 44.7893 22.7217C44.9179 21.4027 44.7097 19.8813 43.5881 18.7597L29.2403 4.41187C27.8527 3.02428 25.8765 3.02573 24.2861 3.36776C22.6081 3.72863 20.7334 4.58419 18.8396 5.74801C16.4978 7.18716 13.9881 9.18353 11.5858 11.5858C9.18354 13.988 7.18717 16.4978 5.74802 18.8396C4.58421 20.7334 3.72865 22.6081 3.36778 24.2861C3.02574 25.8765 3.02429 27.8527 4.41189 29.2403Z" fill="currentColor" fill-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white uppercase tracking-wider">Integridad Laboral</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <a class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-white bg-transparent rounded-lg hover:bg-primary/10 dark:hover:bg-primary/20 transition-colors" href="#about-us">
                            Acerca de Nosotros
                        </a>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-white bg-transparent rounded-lg hover:bg-primary/10 dark:hover:bg-primary/20 transition-colors">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-white bg-transparent rounded-lg hover:bg-primary/10 dark:hover:bg-primary/20 transition-colors">
                                    Iniciar Sesión
                                </a>
                                <button onclick="openRegistrationModal()" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary/90 transition-colors cursor-pointer">
                                        Registrarse
                                    </button>
                            @endauth
                        @endif
                    </div>
                </nav>
            </header>
            <main>
                <div class="relative h-screen flex items-center justify-center">
                    <div class="absolute inset-0 bg-cover bg-center" style='background-image: url("{{ asset('fondo-laboral-integrity.png') }}");'>
                        <div class="absolute inset-0 bg-black/50 dark:bg-black/70"></div>
                    </div>
                    <div class="relative z-10 text-center text-white px-4">
                        <h1 class="text-4xl md:text-6xl font-extrabold mb-4">Fomentando la integridad en el lugar de trabajo</h1>
                        <p class="max-w-3xl mx-auto text-lg md:text-xl mb-8 text-white/90">
                            Nuestra plataforma ofrece soluciones innovadoras para promover la ética y la transparencia en las organizaciones, creando entornos laborales más justos y productivos.
                        </p>
                        <div class="flex flex-wrap justify-center gap-4">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors font-medium">
                                        Ir al Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors font-medium">
                                        Iniciar Sesión
                                    </a>
                                    <button onclick="openRegistrationModal()" class="px-6 py-3 bg-white text-gray-900 rounded-lg hover:bg-gray-100 transition-colors font-medium cursor-pointer">
                                            Registrarse
                                        </button>
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
                <section class="py-20 bg-background-light dark:bg-background-dark" id="about-us">
                    <div class="container mx-auto px-6">
                        <div class="max-w-4xl mx-auto text-center">
                            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white mb-6">Acerca de Nosotros</h2>
                            <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
                                En 'Integridad Laboral', nuestra misión es empoderar a las organizaciones para que cultiven una cultura de integridad y confianza. Creemos que un lugar de trabajo ético es la base del éxito sostenible y el bienestar de los empleados.
                            </p>
                            <div class="grid md:grid-cols-3 gap-8 text-left">
                                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                                    <h3 class="text-xl font-bold text-primary mb-3">Nuestra Misión</h3>
                                    <p class="text-gray-600 dark:text-gray-400">Proporcionar herramientas y recursos de vanguardia para que las empresas promuevan la transparencia, la responsabilidad y el comportamiento ético en todos los niveles.</p>
                                </div>
                                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                                    <h3 class="text-xl font-bold text-primary mb-3">Nuestros Valores</h3>
                                    <ul class="space-y-2 text-gray-600 dark:text-gray-400 list-disc list-inside">
                                        <li>Integridad</li>
                                        <li>Transparencia</li>
                                        <li>Equidad</li>
                                        <li>Innovación</li>
                                    </ul>
                                </div>
                                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                                    <h3 class="text-xl font-bold text-primary mb-3">Nuestra Visión</h3>
                                    <p class="text-gray-600 dark:text-gray-400">Ser el socio líder a nivel mundial para organizaciones comprometidas con la creación de entornos laborales donde la integridad sea la norma y no la excepción.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>

        <!-- Modal de Selección de Registro -->
        <div id="registrationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display: none;">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Selecciona tu tipo de registro</h3>
                    <button onclick="closeRegistrationModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <a href="{{ route('public.person-registration.wizard') }}" class="block w-full px-6 py-4 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors font-medium text-center">
                        Registrarse como Persona
                    </a>
                    <a href="{{ route('public.company-registration.wizard') }}" class="block w-full px-6 py-4 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium text-center">
                        Registrarse como Empresa
                    </a>
                </div>
            </div>
        </div>

        <script>
            function openRegistrationModal() {
                document.getElementById('registrationModal').style.display = 'flex';
            }

            function closeRegistrationModal() {
                document.getElementById('registrationModal').style.display = 'none';
            }

            // Cerrar modal al hacer clic fuera
            document.getElementById('registrationModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeRegistrationModal();
                }
            });
        </script>
    </body>
</html>