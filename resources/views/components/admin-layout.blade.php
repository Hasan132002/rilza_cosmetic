@props(['header' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - Admin Panel</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- AOS Animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .gradient-pink { background: linear-gradient(135deg, #ec4899 0%, #be185d 100%); }
        .gradient-purple { background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%); }
        .gradient-blue { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
        .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(236, 72, 153, 0.2); }
        .animate-float { animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    <div class="flex h-screen overflow-hidden">
        @include('admin.layouts.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.layouts.header')

            <main class="flex-1 overflow-x-hidden overflow-y-auto">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    @if (isset($header))
                        <header class="mb-6" data-aos="fade-down">
                            <h2 class="text-3xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">
                                {{ $header }}
                            </h2>
                        </header>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-[9999] space-y-3 max-w-sm w-full pointer-events-none"></div>

    <!-- Toast Notification Styles -->
    <style>
        .toast-notification {
            pointer-events: auto;
            animation: slideInRight 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        .toast-notification.removing {
            animation: slideOutRight 0.3s ease-in-out forwards;
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(400px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideOutRight {
            from { opacity: 1; transform: translateX(0); }
            to { opacity: 0; transform: translateX(400px); }
        }
        .toast-progress {
            height: 4px;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            transform-origin: left;
            animation: progressBar 5s linear forwards;
        }
        @keyframes progressBar {
            from { transform: scaleX(1); }
            to { transform: scaleX(0); }
        }
        .toast-icon {
            animation: iconBounce 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        @keyframes iconBounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }
    </style>

    <!-- Toast Notification JavaScript -->
    <script>
        window.showToast = function(message, type = 'success', duration = 5000) {
            const container = document.getElementById('toast-container');
            if (!container) return;
            const toastId = 'toast-' + Date.now();
            const config = {
                success: { bg: 'bg-gradient-to-r from-green-500 to-emerald-600', icon: 'fas fa-check-circle', iconBg: 'bg-green-600', progressBg: 'bg-green-300' },
                error: { bg: 'bg-gradient-to-r from-red-500 to-rose-600', icon: 'fas fa-times-circle', iconBg: 'bg-red-600', progressBg: 'bg-red-300' },
                warning: { bg: 'bg-gradient-to-r from-yellow-500 to-amber-600', icon: 'fas fa-exclamation-triangle', iconBg: 'bg-yellow-600', progressBg: 'bg-yellow-300' },
                info: { bg: 'bg-gradient-to-r from-blue-500 to-indigo-600', icon: 'fas fa-info-circle', iconBg: 'bg-blue-600', progressBg: 'bg-blue-300' }
            };
            const style = config[type] || config.success;
            const toast = document.createElement('div');
            toast.id = toastId;
            toast.className = `toast-notification ${style.bg} text-white rounded-lg shadow-2xl overflow-hidden relative`;
            toast.innerHTML = `<div class="flex items-start gap-3 p-4 pr-12"><div class="toast-icon flex-shrink-0 w-10 h-10 ${style.iconBg} rounded-full flex items-center justify-center shadow-lg"><i class="${style.icon} text-lg"></i></div><div class="flex-1 pt-1"><p class="text-sm font-medium leading-relaxed">${message}</p></div><button onclick="removeToast('${toastId}')" class="absolute top-3 right-3 text-white/80 hover:text-white transition-colors"><i class="fas fa-times text-sm"></i></button></div><div class="toast-progress ${style.progressBg}"></div>`;
            container.appendChild(toast);
            setTimeout(() => removeToast(toastId), duration);
        };
        window.removeToast = function(toastId) {
            const toast = document.getElementById(toastId);
            if (!toast) return;
            toast.classList.add('removing');
            setTimeout(() => { if (toast.parentNode) toast.parentNode.removeChild(toast); }, 300);
        };
        window.toastSuccess = (msg, dur = 5000) => showToast(msg, 'success', dur);
        window.toastError = (msg, dur = 5000) => showToast(msg, 'error', dur);
        window.toastWarning = (msg, dur = 5000) => showToast(msg, 'warning', dur);
        window.toastInfo = (msg, dur = 5000) => showToast(msg, 'info', dur);
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success')) toastSuccess("{{ session('success') }}"); @endif
            @if(session('error')) toastError("{{ session('error') }}"); @endif
            @if(session('warning')) toastWarning("{{ session('warning') }}"); @endif
            @if(session('info')) toastInfo("{{ session('info') }}"); @endif
            @if($errors->any()) @foreach($errors->all() as $error) toastError("{{ $error }}"); @endforeach @endif
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, easing: 'ease-in-out', once: true, offset: 50 });
    </script>
</body>
</html>

