<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sistem Penjualan Ikan Beku') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Gradient Background dengan Tema Laut */
            .ocean-gradient {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #00d2ff 50%, #3a7bd5 75%, #00d2ff 100%);
                background-size: 400% 400%;
                animation: gradientWave 15s ease infinite;
            }
            
            @keyframes gradientWave {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            /* Overlay dengan Glassmorphism */
            .glass-overlay {
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            /* Wave Animation */
            .wave {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 200%;
                height: 100px;
                background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z' fill='rgba(255,255,255,0.1)'/%3E%3C/svg%3E") repeat-x;
                animation: wave 10s linear infinite;
                z-index: 1;
            }
            
            .wave:nth-child(2) {
                bottom: 10px;
                animation: wave 7s linear reverse infinite;
                opacity: 0.5;
            }
            
            .wave:nth-child(3) {
                bottom: 20px;
                animation: wave 15s linear infinite;
                opacity: 0.3;
            }

            @keyframes wave {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
            }

            /* Bubbles Animation - Improved */
            @keyframes bubbleFloat {
                0% { 
                    transform: translateY(0) translateX(0) scale(0);
                    opacity: 0;
                }
                10% {
                    opacity: 0.8;
                    transform: translateY(-10vh) translateX(10px) scale(1);
                }
                50% {
                    transform: translateY(-50vh) translateX(-20px) scale(1.1);
                }
                100% { 
                    transform: translateY(-100vh) translateX(30px) scale(0.8);
                    opacity: 0;
                }
            }
            
            .bubble {
                position: absolute;
                background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.2));
                border-radius: 50%;
                animation: bubbleFloat linear infinite;
                pointer-events: none;
                box-shadow: inset 0 0 10px rgba(255, 255, 255, 0.5);
            }
            
            .bubble:nth-child(1) { width: 20px; height: 20px; left: 15%; animation-duration: 8s; animation-delay: 0s; }
            .bubble:nth-child(2) { width: 35px; height: 35px; left: 30%; animation-duration: 10s; animation-delay: 2s; }
            .bubble:nth-child(3) { width: 15px; height: 15px; left: 50%; animation-duration: 6s; animation-delay: 4s; }
            .bubble:nth-child(4) { width: 25px; height: 25px; left: 70%; animation-duration: 9s; animation-delay: 1s; }
            .bubble:nth-child(5) { width: 40px; height: 40px; left: 85%; animation-duration: 12s; animation-delay: 3s; }
            .bubble:nth-child(6) { width: 18px; height: 18px; left: 10%; animation-duration: 7s; animation-delay: 5s; }
            .bubble:nth-child(7) { width: 30px; height: 30px; left: 60%; animation-duration: 11s; animation-delay: 2.5s; }
            .bubble:nth-child(8) { width: 22px; height: 22px; left: 40%; animation-duration: 8.5s; animation-delay: 4.5s; }

            /* Fish Swimming Animation */
            @keyframes fishSwim {
                0% { 
                    transform: translateX(-100px) translateY(0) scaleX(1);
                    opacity: 0;
                }
                10% { opacity: 0.6; }
                45% {
                    transform: translateX(50vw) translateY(-20px) scaleX(1);
                }
                50% {
                    transform: translateX(50vw) translateY(-20px) scaleX(-1);
                }
                90% { opacity: 0.6; }
                100% { 
                    transform: translateX(-100px) translateY(0) scaleX(-1);
                    opacity: 0;
                }
            }
            
            .fish-icon {
                position: absolute;
                font-size: 40px;
                animation: fishSwim 20s ease-in-out infinite;
                opacity: 0.4;
                filter: drop-shadow(0 0 10px rgba(100, 200, 255, 0.5));
            }
            
            .fish-icon:nth-child(1) { top: 20%; animation-duration: 25s; animation-delay: 0s; }
            .fish-icon:nth-child(2) { top: 40%; animation-duration: 30s; animation-delay: 5s; font-size: 35px; }
            .fish-icon:nth-child(3) { top: 60%; animation-duration: 22s; animation-delay: 10s; font-size: 45px; }

            /* Logo Animation */
            @keyframes logoFloat {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-10px) rotate(5deg); }
            }
            
            .logo-float {
                animation: logoFloat 3s ease-in-out infinite;
            }

            /* Card Glassmorphism */
            .glass-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.3);
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            }

            /* Shimmer Effect */
            @keyframes shimmer {
                0% { background-position: -1000px 0; }
                100% { background-position: 1000px 0; }
            }
            
            .shimmer {
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
                background-size: 1000px 100%;
                animation: shimmer 3s infinite;
            }

            /* Hover Effects */
            .card-hover {
                transition: all 0.3s ease;
            }
            
            .card-hover:hover {
                transform: translateY(-5px) scale(1.02);
                box-shadow: 0 15px 40px 0 rgba(31, 38, 135, 0.5);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased relative overflow-hidden">
        
        <div id="parallax-container" class="min-h-screen flex flex-col justify-center items-center ocean-gradient relative p-4">
            
            <!-- Animated Bubbles -->
            <div class="absolute inset-0 z-0 overflow-hidden">
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
                <div class="bubble"></div>
            </div>

            <!-- Swimming Fish -->
            <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                <div class="fish-icon">🐟</div>
                <div class="fish-icon">🐠</div>
                <div class="fish-icon">🐡</div>
            </div>

            <!-- Wave Animation -->
            <div class="absolute inset-0 z-1 overflow-hidden pointer-events-none">
                <div class="wave"></div>
                <div class="wave"></div>
                <div class="wave"></div>
            </div>
            
            <!-- Logo/Header -->
            <div class="absolute top-6 z-20 logo-float">
                <a href="/" class="text-3xl md:text-4xl font-extrabold text-white flex items-center drop-shadow-2xl hover:scale-105 transition-transform duration-300">
                    <svg class="w-12 h-12 md:w-14 md:h-14 fill-current mr-3 text-cyan-300 drop-shadow-lg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                    <span class="shimmer">{{ config('app.name', 'Sistem Penjualan Ikan Beku') }}</span>
                </a>
            </div>
            
            <!-- Main Content Card -->
            <div class="w-full max-w-2xl mt-20 sm:mt-0 relative z-10 card-hover">
                <div class="glass-card rounded-2xl overflow-hidden">
                    {{ $slot }}
                </div>
            </div>
            
            <!-- Footer Text -->
            <div class="absolute bottom-6 z-20 text-center">
                <p class="text-white text-sm drop-shadow-lg opacity-80">
                    🐟 Solusi Terpercaya untuk Penjualan Ikan Beku Berkualitas 🐟
                </p>
            </div>
        </div>

        <script>
            // Enhanced Parallax Effect
            let mouseX = 0, mouseY = 0;
            let currentX = 0, currentY = 0;
            
            document.addEventListener('mousemove', function(e) {
                mouseX = (window.innerWidth - e.pageX * 2) / 100;
                mouseY = (window.innerHeight - e.pageY * 2) / 100;
            });
            
            function animateParallax() {
                const container = document.getElementById('parallax-container');
                if (container) {
                    currentX += (mouseX - currentX) * 0.05;
                    currentY += (mouseY - currentY) * 0.05;
                    container.style.backgroundPosition = `${50 + currentX}% ${50 + currentY}%`;
                }
                requestAnimationFrame(animateParallax);
            }
            
            animateParallax();

            // Add ripple effect on click
            document.addEventListener('click', function(e) {
                const ripple = document.createElement('div');
                ripple.style.position = 'fixed';
                ripple.style.width = '20px';
                ripple.style.height = '20px';
                ripple.style.borderRadius = '50%';
                ripple.style.background = 'rgba(255, 255, 255, 0.5)';
                ripple.style.left = e.clientX - 10 + 'px';
                ripple.style.top = e.clientY - 10 + 'px';
                ripple.style.pointerEvents = 'none';
                ripple.style.zIndex = '9999';
                ripple.style.animation = 'rippleEffect 0.6s ease-out';
                document.body.appendChild(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            });
            
            // Add ripple animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes rippleEffect {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        </script>
    </body>
</html>