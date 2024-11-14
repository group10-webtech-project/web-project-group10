@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 sm:py-12">
    <!-- Hero Section -->
    <section class="text-center py-12 sm:py-20 card glass shadow-2xl transform hover:scale-[1.01] transition-transform duration-300">
        <div class="card-body items-center">
            <div class="relative">
                <h1 class="text-4xl sm:text-6xl font-extrabold mb-6 leading-tight animate-fade-in bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary">
                    Nerdle
                    <span class="block text-2xl sm:text-4xl mt-2">The Ultimate Animal Guessing Game!</span>
                </h1>
            </div>
            <p class="text-lg sm:text-xl mb-8 max-w-2xl mx-auto animate-fade-in-delay-1">
                Ready to test your animal knowledge? Try to guess the mystery animal using hints and clues!
            </p>
            <div class="flex gap-4 animate-bounce-in">
                <div class="join shadow-lg">
                    <a href="{{ route('login') }}" class="btn btn-primary join-item hover:scale-105 transition-transform">
                        <span class="hidden sm:inline">Login</span>
                        <span class="sm:hidden">👤</span>
                    </a>
                    <a href="{{ route('game.play') }}" class="btn btn-accent join-item hover:scale-105 transition-transform">
                        <span class="hidden sm:inline">Play as Guest</span>
                        <span class="sm:hidden">Play 🎲</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <div class="grid md:grid-cols-3 gap-4 sm:gap-8 mt-8 sm:mt-16">
        <!-- How to Play Section -->
        <section class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
            <div class="card-body">
                <h2 class="card-title text-xl sm:text-2xl font-bold text-primary flex gap-2">
                    <span>📖</span>
                    How to Play
                </h2>
                <ol class="list-decimal list-inside text-left space-y-4 mt-4">
                    <li class="flex flex-col">
                        <span class="font-medium">Start a game</span>
                        <span class="text-sm opacity-75">Begin your animal guessing adventure</span>
                    </li>
                    <li class="flex flex-col">
                        <span class="font-medium">Use hints wisely</span>
                        <span class="text-sm opacity-75">Spend points to reveal letters or check characteristics</span>
                    </li>
                    <li class="flex flex-col">
                        <span class="font-medium">Make smart guesses</span>
                        <span class="text-sm opacity-75">Each wrong guess costs points!</span>
                    </li>
                </ol>
            </div>
        </section>

        <!-- Why Play Section -->
        <section class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
            <div class="card-body">
                <h2 class="card-title text-xl sm:text-2xl font-bold text-primary flex gap-2">
                    <span>🎯</span>
                    Why Play Nerdle?
                </h2>
                <ul class="space-y-4 mt-4">
                    <li class="flex items-center p-2 rounded-lg hover:bg-base-200 transition-colors">
                        <div class="badge badge-lg gap-2">
                            <span>🤓</span>
                            You are a NERD!
                        </div>
                    </li>
                    <li class="flex items-center p-2 rounded-lg hover:bg-base-200 transition-colors">
                        <div class="badge badge-lg gap-2">
                            <span>🧠</span>
                            Train Your Brain
                        </div>
                    </li>
                    <li class="flex items-center p-2 rounded-lg hover:bg-base-200 transition-colors">
                        <div class="badge badge-lg gap-2">
                            <span>🏆</span>
                            Compete with Friends
                        </div>
                    </li>
                </ul>
            </div>
        </section>

        <!-- Player Reviews -->
        <section class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
            <div class="card-body">
                <h2 class="card-title text-xl sm:text-2xl font-bold text-primary flex gap-2">
                    <span>💬</span>
                    Player Reviews
                </h2>
                <div class="space-y-4 mt-4">
                    <div class="card bg-base-200">
                        <div class="card-body p-4">
                            <p class="italic">"So much fun! Perfect for animal lovers!"</p>
                            <p class="text-sm opacity-75 mt-2">— Frederik H.</p>
                        </div>
                    </div>
                    <div class="card bg-base-200">
                        <div class="card-body p-4">
                            <p class="italic">"Educational and entertaining for the whole family!"</p>
                            <p class="text-sm opacity-75 mt-2">— Ben</p>
                        </div>
                    </div>
                    <div class="card bg-base-200">
                        <div class="card-body p-4">
                            <p class="italic">"I cannot stop playing this game! How is this a webtech project?!!"</p>
                            <p class="text-sm opacity-75 mt-2">— Mark Konrad</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Share Section -->
    <section class="card mt-8 sm:mt-16 bg-gradient-to-r from-primary/10 to-secondary/10 backdrop-blur-sm">
        <div class="card-body items-center text-center">
            <h2 class="card-title text-2xl sm:text-3xl font-bold flex gap-2">
                <span>🎮</span>
                Share with Friends
            </h2>
            <p class="mb-6 opacity-75">Challenge your friends to beat your score!</p>
            <div class="flex flex-wrap justify-center gap-4">
                <button onclick="shareOnTwitter()" class="btn btn-primary gap-2 hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                    </svg>
                    <span class="hidden sm:inline">Share</span>
                </button>
                <button onclick="shareOnFacebook()" class="btn btn-primary gap-2 hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="hidden sm:inline">Share</span>
                </button>
                <button onclick="copyLink()" class="btn btn-primary gap-2 hover:scale-105 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <span class="hidden sm:inline">Copy Link</span>
                </button>
            </div>
        </div>
    </section>
</div>

<style>
/* Existing animations */
.animate-fade-in {
    animation: fadeIn 0.8s ease-out;
}

.animate-fade-in-delay-1 {
    animation: fadeIn 0.8s ease-out 0.3s both;
}

.animate-bounce-in {
    animation: bounceIn 1s cubic-bezier(0.36, 0, 0.66, -0.56) 0.5s both;
}

.animate-bounce-slow {
    animation: bounce 2s ease-in-out infinite;
}

/* Floating animals animation */
.animal-float {
    position: fixed;
    font-size: 3rem;
    opacity: 0.1;
    animation: float 20s linear infinite;
}

@keyframes float {
    0% {
        transform: translate(-100vw, 100vh) rotate(0deg);
    }
    100% {
        transform: translate(100vw, -100vh) rotate(360deg);
    }
}

@keyframes bounce {
    0%, 100% { transform: translateY(-25%); }
    50% { transform: translateY(0); }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes bounceIn {
    0% { transform: scale(0.3); opacity: 0; }
    50% { transform: scale(1.05); }
    70% { transform: scale(0.9); }
    100% { transform: scale(1); opacity: 1; }
}

/* Toast animation */
.toast {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from { transform: translateY(-100%); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
</style>

<script>
    function shareOnTwitter() {
        const text = "Can you guess the animal? Play Nerdle - The Ultimate Animal Guessing Game! 🦁";
        const url = window.location.origin;
        window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`, '_blank');
    }

    function shareOnFacebook() {
        const url = window.location.origin;
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank');
    }

    function copyLink() {
        const url = window.location.origin;
        navigator.clipboard.writeText(url).then(() => {
            // Show toast notification
            const toast = document.createElement('div');
            toast.className = 'toast toast-top toast-center';
            toast.innerHTML = `
                <div class="alert alert-success">
                    <span>Link copied to clipboard!</span>
                </div>
            `;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        });
    }
</script>

<!-- Update the footer section -->
<footer class="mt-16 text-center py-8 border-t border-base-300">
    <p class="text-base-content/60">&copy; {{ date('Y') }} Nerdle. All rights reserved. (not really)</p>
</footer>
@endsection
