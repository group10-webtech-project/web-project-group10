@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-center text-gray-900 mb-8">Frequently Asked Questions</h1>
        
        <!-- Search Bar -->
        <div class="mb-8">
            <div class="relative">
                <input type="text" 
                       id="faq-search" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Search FAQs..."
                       onkeyup="debounce(searchFAQ, 300)()">
                <span class="absolute right-3 top-2.5 text-gray-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loading" class="hidden">
            <div class="flex justify-center items-center">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
            </div>
        </div>

        <!-- FAQ Results -->
        <div id="faq-results" class="space-y-4">
            <!-- Results will be populated here -->
        </div>

        <!-- No Results State -->
        <div id="no-results" class="hidden text-center py-8">
            <p class="text-gray-500">No matching FAQs found. Try a different search term.</p>
        </div>
    </div>
</div>

<script>
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

async function searchFAQ() {
    const searchInput = document.getElementById('faq-search').value.trim();
    const resultsDiv = document.getElementById('faq-results');
    const loadingDiv = document.getElementById('loading');
    const noResultsDiv = document.getElementById('no-results');

    // If search is empty, clear results
    if (!searchInput) {
        resultsDiv.innerHTML = '';
        noResultsDiv.classList.add('hidden');
        return;
    }

    // Show loading state
    loadingDiv.classList.remove('hidden');
    resultsDiv.innerHTML = '';
    noResultsDiv.classList.add('hidden');

    try {
        const response = await fetch(`https://faq-vectordb.fupsonline.workers.dev/search?q=${encodeURIComponent(searchInput)}`);
        const data = await response.json();

        // Hide loading state
        loadingDiv.classList.add('hidden');

        if (data.matches && data.matches.length > 0) {
            // Sort results by score
            data.matches.sort((a, b) => b.score - a.score);

            // Display results
            resultsDiv.innerHTML = data.matches
                .map(match => `
                    <div class="bg-white rounded-lg shadow-md p-6 transition-all duration-200 hover:shadow-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">${match.question}</h3>
                        <p class="text-gray-600">${match.answer}</p>
                        <div class="mt-2 text-xs text-gray-400">Relevance: ${Math.round(match.score * 100)}%</div>
                    </div>
                `)
                .join('');
        } else {
            noResultsDiv.classList.remove('hidden');
        }
    } catch (error) {
        console.error('Error fetching FAQs:', error);
        resultsDiv.innerHTML = `
            <div class="text-center py-8">
                <p class="text-red-500">An error occurred while searching. Please try again later.</p>
            </div>
        `;
    }
}

// Initial search on page load
window.addEventListener('load', () => {
    const searchInput = document.getElementById('faq-search');
    if (searchInput.value.trim()) {
        searchFAQ();
    }
});
</script>
@endsection 