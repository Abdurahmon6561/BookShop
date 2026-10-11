<template>
  <ClientLayout>
    <div class="min-h-screen bg-slate-950 text-slate-100 font-sans antialiased selection:bg-violet-500 selection:text-white">
      <!-- Hero Section -->
      <div class="relative overflow-hidden pt-20 pb-24 border-b border-slate-800/80 bg-gradient-to-b from-slate-900 via-violet-950/40 to-slate-950">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(120,119,198,0.2),rgba(255,255,255,0))]"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8">
          <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-violet-500/10 border border-violet-500/20 text-violet-400 text-xs font-semibold tracking-wide uppercase shadow-inner">
            <span class="w-2 h-2 rounded-full bg-violet-400 animate-pulse"></span>
            Curated Literary Masterpieces & Bestsellers
          </div>
          
          <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-white max-w-4xl mx-auto leading-[1.1]">
            Discover Stories That <span class="bg-gradient-to-r from-violet-400 via-fuchsia-400 to-amber-300 bg-clip-text text-transparent">Spark Your Mind</span>
          </h1>
          
          <p class="text-lg sm:text-xl text-slate-400 max-w-2xl mx-auto font-light">
            Explore handpicked titles across technology, leadership, philosophy, and creative inspiration. Delivered instantly to your reading list.
          </p>

          <!-- Search Form -->
          <form @submit.prevent="search" class="max-w-2xl mx-auto pt-2">
            <div class="relative flex items-center shadow-2xl rounded-2xl p-2 bg-slate-900/90 border border-slate-700/80 backdrop-blur-xl focus-within:border-violet-500 transition-all duration-300">
              <div class="pl-4 text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
              </div>
              <input
                type="text"
                v-model="form.search"
                placeholder="Search by book title, author, or ISBN..."
                class="w-full bg-transparent border-0 px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-0 text-base"
              >
              <button
                type="submit"
                class="px-6 py-3 bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-500 hover:to-indigo-500 text-white font-semibold rounded-xl shadow-lg shadow-violet-600/30 transition-all duration-200 shrink-0"
              >
                Search Books
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Catalog Section -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 pb-6 border-b border-slate-800">
          <div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">Featured Bookstore Catalog</h2>
            <p class="text-sm text-slate-400 mt-1">Showing {{ books.total }} premium editions available for instant acquisition</p>
          </div>
          <div v-if="filters.search" class="mt-4 md:mt-0 flex items-center gap-2">
            <span class="text-xs text-slate-400">Filtered by "{{ filters.search }}"</span>
            <Link :href="route('books.index')" class="text-xs text-violet-400 hover:text-violet-300 underline font-medium">Clear filter</Link>
          </div>
        </div>

        <!-- Books Grid -->
        <div v-if="books.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
          <div
            v-for="book in books.data"
            :key="book.id"
            class="group bg-slate-900/60 rounded-3xl border border-slate-800 hover:border-violet-500/50 shadow-xl overflow-hidden transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between"
          >
            <div>
              <!-- Book Cover Image -->
              <div class="relative aspect-[4/3] w-full overflow-hidden bg-slate-800">
                <img
                  v-if="book.image"
                  :src="`/storage/${book.image}`"
                  :alt="book.title"
                  class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
                >
                <div v-else class="h-full w-full flex items-center justify-center bg-gradient-to-br from-violet-900/40 to-slate-800 text-slate-400 font-medium">
                  <svg class="w-12 h-12 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div class="absolute top-4 right-4 bg-slate-950/80 backdrop-blur-md px-3 py-1 rounded-full text-xs font-bold text-violet-400 border border-violet-500/30 shadow-lg">
                  ${{ book.price }}
                </div>
                <div class="absolute top-4 left-4 bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-xs font-semibold px-2.5 py-1 rounded-full backdrop-blur-md">
                  {{ book.stock_quantity > 0 ? `${book.stock_quantity} in stock` : 'Out of stock' }}
                </div>
              </div>

              <!-- Content -->
              <div class="p-6 space-y-3">
                <div class="text-xs font-medium text-violet-400 uppercase tracking-wider">{{ book.author || 'Author Unknown' }}</div>
                <h3 class="text-xl font-bold text-white group-hover:text-violet-300 transition-colors line-clamp-1">
                  {{ book.title }}
                </h3>
                <p class="text-sm text-slate-400 line-clamp-2 leading-relaxed">
                  {{ book.description || 'No description available for this volume.' }}
                </p>
              </div>
            </div>

            <!-- Actions -->
            <div class="p-6 pt-0 flex items-center justify-between gap-4">
              <Link
                :href="route('books.show', book.id)"
                class="flex-1 text-center py-2.5 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-medium text-sm transition-colors border border-slate-700"
              >
                View Details
              </Link>
              <Link
                :href="route('books.show', book.id)"
                class="py-2.5 px-5 rounded-xl bg-violet-600 hover:bg-violet-500 text-white font-semibold text-sm shadow-lg shadow-violet-600/30 transition-all duration-200"
              >
                Buy Now
              </Link>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-20 bg-slate-900/40 rounded-3xl border border-slate-800">
          <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-violet-500/10 text-violet-400 mb-4 border border-violet-500/20">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
          </div>
          <h3 class="text-xl font-bold text-white mb-2">No matching books found</h3>
          <p class="text-sm text-slate-400 mb-6 max-w-md mx-auto">Try searching for another keyword or browse our entire collection.</p>
          <Link
            :href="route('books.index')"
            class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-violet-600 hover:bg-violet-500 text-white font-semibold text-sm shadow-lg shadow-violet-600/30 transition-all"
          >
            Reset Search Filter
          </Link>
        </div>

        <!-- Pagination -->
        <div v-if="books.links && books.links.length > 3" class="mt-12 flex justify-center">
          <nav class="flex items-center gap-1.5">
            <template v-for="(link, index) in books.links" :key="index">
              <div
                v-if="!link.url"
                v-html="link.label"
                class="px-4 py-2 rounded-xl text-xs font-medium bg-slate-900 text-slate-600 border border-slate-800 cursor-not-allowed"
              />
              <Link
                v-else
                :href="link.url"
                v-html="link.label"
                class="px-4 py-2 rounded-xl text-xs font-semibold transition-all"
                :class="link.active ? 'bg-violet-600 text-white shadow-lg shadow-violet-600/30 border border-violet-500' : 'bg-slate-900 hover:bg-slate-800 text-slate-300 border border-slate-800'"
              />
            </template>
          </nav>
        </div>
      </div>
    </div>
  </ClientLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import ClientLayout from '@/Layouts/ClientLayout.vue';

const props = defineProps<{
  books: {
    data: Array<any>;
    links: Array<any>;
    total: number;
  };
  filters: {
    search?: string;
  };
}>();

const form = ref({
  search: props.filters.search || '',
});

const search = () => {
  router.get(route('books.index'), { search: form.value.search }, { preserveState: true, replace: true });
};
</script>
