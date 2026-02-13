<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevMenthors</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('img/logos/1.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; }
        
        /* Lazy loading fade-in */
        .fade-in-section { opacity: 0; transition: opacity 0.6s ease-in-out; }
        .fade-in-section.is-visible { opacity: 1; }
        
        /* Animação para imagens lazy */
        img[loading="lazy"] { opacity: 0; transition: opacity 0.4s; }
        img[loading="lazy"].loaded { opacity: 1; }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">

    <!-- Hero Section -->
    <section class="relative bg-white min-h-screen flex flex-col overflow-hidden">
        <!-- Ondas decorativas -->
        <img src="{{ asset('img/left.png') }}" alt="Onda esquerda" class="absolute bottom-0 left-0 h-3/4 w-auto object-contain z-0 hidden lg:block">
        <img src="{{ asset('img/right.png') }}" alt="Onda direita" class="absolute bottom-0 right-0 h-3/4 w-auto object-contain z-0 hidden lg:block">

        <!-- Navbar -->
        <header class="relative z-10 py-7 lg:py-8">
            <div class="container max-w-[1100px] mx-auto px-5 flex flex-col md:flex-row justify-between items-center">
                <a href="/" class="flex items-center">
                    <img src="{{ asset('img/logos/2.png') }}" alt="" class="h-[90px] md:h-[90px] sm:h-[60px] w-auto">
                </a>
                <nav class="flex items-center gap-0 mt-4 md:mt-0 flex-col md:flex-row md:gap-0">
                    <a href="{{ route('login.unificado') }}" class="text-gray-700 font-semibold ml-0 md:ml-6 hover:text-blue-600 transition-colors">Entrar</a>
                    <a href="/hackhealth" class="px-[18px] py-2 border-2 border-blue-600 text-blue-600 font-semibold rounded-lg ml-0 mt-2 md:mt-0 md:ml-6 hover:bg-blue-50 transition-all">HackHealth</a>
                </nav>
            </div>
        </header>

        <!-- Hero Content -->
        <div class="relative z-10 flex-1 flex flex-col items-center justify-center text-center px-4 pb-20 md:pb-16">
            <h1 class="text-[32px] md:text-[38px] lg:text-[56px] font-extrabold leading-tight mb-6 md:mb-4 text-gray-900">
                DevMenthors, <br>
                <span class="text-blue-600">transformando o futuro</span> <br>
                <span class="text-blue-600">uma geração por vez.</span>
            </h1>
            <p class="text-sm md:text-[15px] lg:text-lg text-gray-600 max-w-[90%] md:max-w-[600px] mb-7 md:mb-6 lg:mb-9 leading-relaxed">
                Vá além de código! Junte-se a nós e aprenda, gratuitamente, sobre programação, hard e soft skills, e empreendedorismo. Conte com o apoio de mentores que entendem a sua jornada.
            </p>
            <a href="/registrar" class="inline-block px-6 py-3 bg-blue-600 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-all">
                Faça parte!
            </a>
        </div>
    </section>

    <main>
        <!-- Trilhas Section -->
        <section class="py-10 md:py-10 lg:py-20 fade-in-section">
            <div class="container max-w-[1100px] mx-auto px-5">
                <h2 class="text-center text-[26px] md:text-[26px] lg:text-[32px] font-extrabold mb-3 md:mb-[10px] lg:mb-4">
                    Inicie sua história na área da tecnologia com <span class="text-blue-600">DevMenthors</span>
                </h2>
                <p class="text-center text-sm md:text-sm lg:text-base text-gray-600 mb-7 md:mb-7 lg:mb-12">Conheça um pouco de cada uma das trilhas disponíveis.</p>

                <div class="flex flex-col lg:flex-row items-start gap-7 lg:gap-10">
                    <!-- Dashboard Image -->
                    <div class="w-full lg:flex-[1.2] order-2 lg:order-1">
                        <div class="w-full h-[250px] lg:h-[400px] bg-gray-200 rounded-lg shadow-md flex items-center justify-center">
                            <img src="{{ asset('img/dashboard.png') }}" loading="lazy" class="w-full h-full object-cover rounded-lg">
                        </div>
                    </div>

                    <!-- Trilhas List -->
                    <div class="w-full lg:flex-1 order-1 lg:order-2 bg-gray-50 rounded-lg p-6">
                        <!-- Design -->
                        <div class="flex items-center gap-5 mb-6 last:mb-0">
                            <div class="flex-shrink-0 w-[50px] h-[50px] bg-red-50 rounded-lg flex items-center justify-center">
                                <img src="{{ asset('img/figma.png') }}" alt="" loading="lazy" class="w-[35px] h-[35px] object-contain">
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">Design</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">A arte de solucionar problemas e criar experiências memoráveis.</p>
                            </div>
                        </div>

                        <!-- Front-end -->
                        <div class="flex items-center gap-5 mb-6 last:mb-0">
                            <div class="flex-shrink-0 w-[50px] h-[50px] bg-blue-50 rounded-lg flex items-center justify-center">
                                <img src="{{ asset('img/front.png') }}" alt="" loading="lazy" class="w-[35px] h-[35px] object-contain">
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">Front-end</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">Dando forma e fluidez à experiência de quem navega.</p>
                            </div>
                        </div>

                        <!-- Back-end -->
                        <div class="flex items-center gap-5 mb-0">
                            <div class="flex-shrink-0 w-[50px] h-[50px] bg-green-50 rounded-lg flex items-center justify-center">
                                <img src="{{ asset('img/php.png') }}" alt="" loading="lazy" class="w-[35px] h-[35px] object-contain">
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">Back-end</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">O cérebro do sistema. Lógica, poder e dados em ação.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- O que é -->
        <section class="py-10 md:py-10 lg:py-[60px] bg-gray-50 fade-in-section" id="sobre">
            <div class="container max-w-[1100px] mx-auto px-5">
                <div class="flex flex-col lg:flex-row items-center gap-7 lg:gap-[50px]">
                    <div class="flex-1">
                        <h2 class="text-[28px] md:text-[28px] lg:text-[32px] font-extrabold mb-4 md:mb-[15px] lg:mb-5 text-gray-900">O que é o DevMenthors</h2>
                        <p class="text-sm md:text-[15px] lg:text-base text-gray-600 leading-relaxed">
                            O DevMenthors nasceu em 2022 para capacitar jovens com habilidades técnicas (hard skills) e interpessoais (soft skills). Nosso foco vai além da tecnologia: ajudamos você a desenvolver liderança, comunicação e trabalho em equipe, preparando-o para os desafios do mercado. Aqui, formamos profissionais completos e prontos para brilhar!
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Como funciona -->
        <section class="py-10 md:py-10 lg:py-[60px] fade-in-section">
            <div class="container max-w-[1100px] mx-auto px-5">
                <div class="flex flex-col-reverse lg:flex-row-reverse items-center gap-7 lg:gap-[50px]">
                    <div class="flex-1">
                        <h2 class="text-[28px] md:text-[28px] lg:text-[32px] font-extrabold mb-4 md:mb-[15px] lg:mb-5 text-gray-900">Como o Dev Funciona</h2>
                        <p class="text-sm md:text-[15px] lg:text-base text-gray-600 leading-relaxed">
                            No DevMenthors, você aprende fazendo! Com treinamentos em HTML, CSS, JavaScript, PHP e Laravel, jovens desenvolvem projetos reais com o apoio de mentores. Além das habilidades técnicas, também oferecem soft skills como liderança e trabalho em equipe. Quem se destaca vira mentor e ajuda a próxima geração de devs. Junte-se ao ciclo de aprendizado e crescimento!
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Feedbacks -->
        <section class="py-10 md:py-10 lg:py-20 bg-gray-50 fade-in-section" id="feedbacks">
            <div class="container max-w-[1100px] mx-auto px-5">
                <h2 class="text-[28px] md:text-[28px] lg:text-[32px] font-extrabold mb-7 md:mb-7 lg:mb-10 text-left">Feedbacks</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-5 lg:gap-[30px]">
                    <!-- Feedback 1 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-4 mb-4">
                            <img src="{{ asset('img/enzo.png') }}" alt="Enzo Takaku" loading="lazy" class="w-[50px] h-[50px] md:w-[50px] md:h-[50px] sm:w-10 sm:h-10 rounded-full object-cover">
                            <h3 class="font-bold text-lg md:text-lg sm:text-base">Enzo Takaku</h3>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            O DevMenthor pra mim foi uma chave que abriu minha mente, eu não queria trabalhar na área de programação, mas decidi entrar pra ver como era e me interessei muito em programar e aprender sempre mais, quando já havia se passado um ano e começamos a dar aulas para outros alunos, vi que o Dev poderia abrir a mente de mais pessoas como eu.
                        </p>
                    </div>

                    <!-- Feedback 2 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-4 mb-4">
                            <img src="{{ asset('img/marcos.png') }}" alt="Marcos Gabriel" loading="lazy" class="w-[50px] h-[50px] md:w-[50px] md:h-[50px] sm:w-10 sm:h-10 rounded-full object-cover">
                            <h3 class="font-bold text-lg md:text-lg sm:text-base">Marcos Gabriel</h3>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            Para mim, o Dev foi algo que mudou minha perspectiva de como é a dinâmica de estudos, abrange a programação e aprendizagem que com todas as envolvidos no projeto Devs... Desenvolvi Hard e Soft Skills que hoje fazem parte de quem eu sou e me ajudam a me destacar onde eu vou.
                        </p>
                    </div>

                    <!-- Feedback 3 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow md:col-span-2 max-w-xl mx-auto w-full">
                        <div class="flex items-center gap-4 mb-4">
                            <img src="{{ asset('img/julio_gabriel.png') }}" alt="Julio Gabriel" loading="lazy" class="w-[50px] h-[50px] md:w-[50px] md:h-[50px] sm:w-10 sm:h-10 rounded-full object-cover">
                            <h3 class="font-bold text-lg md:text-lg sm:text-base">Julio Gabriel</h3>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            O Dev foi um verdadeiro divisor de águas para mim, contribuindo não apenas no aprendizado, mas também em muitos outros aspectos da minha vida. Hoje, toda a base que tenho em programação foi construída graças ao Dev.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section class="py-10 md:py-10 lg:py-20 bg-gray-50 fade-in-section" id="faq">
            <div class="container max-w-[1100px] mx-auto px-5">
                <div class="mb-8 md:mb-8 lg:mb-10">
                    <h2 class="text-[28px] md:text-[28px] lg:text-[32px] font-extrabold mb-1">Dev responde</h2>
                    <h3 class="text-lg md:text-lg lg:text-xl font-semibold text-blue-600">Dúvidas Frequentes</h3>
                </div>

                <div class="max-w-[900px] space-y-[10px]">
                    <details class="bg-white rounded-lg border-b border-gray-200 overflow-hidden group">
                        <summary class="px-5 md:px-5 lg:px-5 py-4 md:py-[15px] lg:py-5 font-semibold text-sm md:text-[15px] lg:text-base cursor-pointer list-none relative hover:bg-gray-50 transition-colors">
                            Como me inscrevo no dev?
                            <span class="absolute right-5 text-blue-600 text-xl group-open:rotate-45 transition-transform">+</span>
                        </summary>
                        <div class="px-5 md:px-5 lg:px-5 pb-4 md:pb-[15px] lg:pb-5 text-sm md:text-sm lg:text-[15px] text-gray-600 leading-relaxed">
                            As inscrições abrem periodicamente. Fique de olho em nossas redes sociais e no site oficial para o anúncio das próximas turmas!
                        </div>
                    </details>

                    <details class="bg-white rounded-lg border-b border-gray-200 overflow-hidden group">
                        <summary class="px-5 md:px-5 lg:px-5 py-4 md:py-[15px] lg:py-5 font-semibold text-sm md:text-[15px] lg:text-base cursor-pointer list-none relative hover:bg-gray-50 transition-colors">
                            Quais os dias de Aula?
                            <span class="absolute right-5 text-blue-600 text-xl group-open:rotate-45 transition-transform">+</span>
                        </summary>
                        <div class="px-5 md:px-5 lg:px-5 pb-4 md:pb-[15px] lg:pb-5 text-sm md:text-sm lg:text-[15px] text-gray-600 leading-relaxed">
                            As aulas geralmente ocorrem aos sábados, das 09:00 - 12:00, para que não atrapalhe os estudos por fora.
                        </div>
                    </details>

                    <details class="bg-white rounded-lg border-b border-gray-200 overflow-hidden group">
                        <summary class="px-5 md:px-5 lg:px-5 py-4 md:py-[15px] lg:py-5 font-semibold text-sm md:text-[15px] lg:text-base cursor-pointer list-none relative hover:bg-gray-50 transition-colors">
                            O DevMenthors é pago?
                            <span class="absolute right-5 text-blue-600 text-xl group-open:rotate-45 transition-transform">+</span>
                        </summary>
                        <div class="px-5 md:px-5 lg:px-5 pb-4 md:pb-[15px] lg:pb-5 text-sm md:text-sm lg:text-[15px] text-gray-600 leading-relaxed">
                            Não! O DevMenthors é um projeto totalmente gratuito, focado em levar conhecimento de tecnologia para jovens.
                        </div>
                    </details>

                    <details class="bg-white rounded-lg border-b border-gray-200 overflow-hidden group">
                        <summary class="px-5 md:px-5 lg:px-5 py-4 md:py-[15px] lg:py-5 font-semibold text-sm md:text-[15px] lg:text-base cursor-pointer list-none relative hover:bg-gray-50 transition-colors">
                            Qual o tempo das Trilhas?
                            <span class="absolute right-5 text-blue-600 text-xl group-open:rotate-45 transition-transform">+</span>
                        </summary>
                        <div class="px-5 md:px-5 lg:px-5 pb-4 md:pb-[15px] lg:pb-5 text-sm md:text-sm lg:text-[15px] text-gray-600 leading-relaxed">
                            A duração das trilhas pode variar, mas geralmente são projetadas para serem concluídas em um semestre letivo.
                        </div>
                    </details>

                    <details class="bg-white rounded-lg border-b border-gray-200 overflow-hidden group">
                        <summary class="px-5 md:px-5 lg:px-5 py-4 md:py-[15px] lg:py-5 font-semibold text-sm md:text-[15px] lg:text-base cursor-pointer list-none relative hover:bg-gray-50 transition-colors">
                            Temos certificados?
                            <span class="absolute right-5 text-blue-600 text-xl group-open:rotate-45 transition-transform">+</span>
                        </summary>
                        <div class="px-5 md:px-5 lg:px-5 pb-4 md:pb-[15px] lg:pb-5 text-sm md:text-sm lg:text-[15px] text-gray-600 leading-relaxed">
                            Sim! Ao concluir as trilhas e projetos propostos, os alunos recebem um certificado de participação e conclusão.
                        </div>
                    </details>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white pt-[60px] pb-0 relative mt-20 md:mt-20 lg:mt-[100px] overflow-visible text-left md:text-center lg:text-left">
        <div class="container max-w-[1100px] mx-auto px-5 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-4 gap-10 md:gap-8 lg:gap-10 mb-12 md:mb-10 lg:mb-0 md:justify-items-center lg:justify-items-start">
                <!-- Logo -->
                <div class="md:text-center lg:text-left">
                    <img src="{{ asset('img/logo_rodape.png') }}" alt="Logo DevMenthors" loading="lazy" class="h-auto max-w-[150px] md:max-w-[120px] lg:max-w-[150px] mb-5 md:mx-auto lg:mx-0">
                </div>

                <!-- Contato -->
                <div class="lg:-ml-[30px]">
                    <h4 class="font-bold text-lg md:text-base lg:text-lg mb-5 md:mb-4 lg:mb-5 text-gray-900">Contato</h4>
                    <p class="text-sm md:text-sm lg:text-[15px] text-gray-900">administracao@devmenthors.com.br</p>
                </div>

                <!-- Links -->
                <div class="lg:-ml-[30px]">
                    <h4 class="font-bold text-lg md:text-base lg:text-lg mb-5 md:mb-4 lg:mb-5 text-gray-900">Links</h4>
                    <ul class="space-y-0 md:flex md:flex-col md:items-center lg:block">
                        <li class="mb-[10px]"><a href="#sobre" class="text-sm md:text-sm lg:text-[15px] text-gray-900 hover:text-gray-700 transition-colors">Sobre nós</a></li>
                        <li class="mb-[10px]"><a href="/hackhealth" class="text-sm md:text-sm lg:text-[15px] text-gray-900 hover:text-gray-700 transition-colors">HackHealth</a></li>
                        <li class="mb-[10px]"><a href="#feedbacks" class="text-sm md:text-sm lg:text-[15px] text-gray-900 hover:text-gray-700 transition-colors">Feedbacks</a></li>
                        <li class="mb-0"><a href="#faq" class="text-sm md:text-sm lg:text-[15px] text-gray-900 hover:text-gray-700 transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <!-- Redes Sociais -->
                <div class="lg:-ml-[170px]">
                    <h4 class="font-bold text-lg md:text-base lg:text-lg mb-5 md:mb-4 lg:mb-5 text-gray-900">Nossas Redes</h4>
                    <div class="flex gap-[15px] mt-[10px] md:justify-center lg:justify-start">
                        <a href="https://instagram.com/devmenthors" class="w-10 h-10 md:w-[35px] md:h-[35px] lg:w-10 lg:h-10 bg-gray-300 rounded-full flex items-center justify-center hover:bg-gray-400 transition-colors overflow-hidden">
                            <img src="{{ asset('img/social/instagram.png') }}" alt="Instagram" loading="lazy" class="w-[60%] h-[60%] object-contain">
                        </a>
                        <a href="mailto:administracao@devmenthors.com.br" class="w-10 h-10 md:w-[35px] md:h-[35px] lg:w-10 lg:h-10 bg-gray-300 rounded-full flex items-center justify-center hover:bg-gray-400 transition-colors overflow-hidden">
                            <img src="{{ asset('img/social/email.png') }}" alt="Email" loading="lazy" class="w-[60%] h-[60%] object-contain">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="bg-gray-900 py-5 text-center relative z-10 mt-0 md:mt-10 lg:mt-0">
            <p class="text-gray-500 text-xs">&copy; 2025 DevMenthors. Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- Lazy Loading & Fade-in Script -->
    <script>
        // Intersection Observer para Fade-in
        const faders = document.querySelectorAll('.fade-in-section');
        const appearOnScroll = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, { threshold: 0.15, rootMargin: "0px 0px -100px 0px" });

        faders.forEach(fader => appearOnScroll.observe(fader));

        // Lazy loading de imagens
        document.addEventListener("DOMContentLoaded", () => {
            const lazyImages = document.querySelectorAll('img[loading="lazy"]');
            lazyImages.forEach(img => {
                img.addEventListener('load', () => img.classList.add('loaded'));
                if (img.complete) img.classList.add('loaded');
            });
        });

        // Remove seta padrão do details
        document.querySelectorAll('details summary').forEach(summary => {
            summary.addEventListener('click', (e) => {
                summary.style.listStyle = 'none';
            });
        });
    </script>

</body>
</html>
