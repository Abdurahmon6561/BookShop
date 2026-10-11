<template>
  <ClientLayout>
    <div class="min-h-screen bg-slate-950 text-slate-100 py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-6xl mx-auto">
        <!-- Breadcrumb / Back -->
        <div class="mb-8">
          <Link
            :href="route('books.index')"
            class="inline-flex items-center gap-2 text-sm font-medium text-violet-400 hover:text-violet-300 transition-colors"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Bookstore Catalog
          </Link>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
          <!-- Book Image Column -->
          <div class="lg:col-span-5">
            <div class="sticky top-28 rounded-3xl overflow-hidden bg-slate-900 border border-slate-800 shadow-2xl">
              <div class="aspect-[3/4] w-full relative overflow-hidden bg-slate-800">
                <img
                  v-if="book.image"
                  :src="`/storage/${book.image}`"
                  :alt="book.title"
                  class="w-full h-full object-cover"
                >
                <div v-else class="w-full h-full flex items-center justify-center text-slate-500 font-medium">
                  <svg class="w-20 h-20 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
              </div>
              <div class="p-6 bg-slate-900/90 backdrop-blur-md border-t border-slate-800/80 flex items-center justify-between">
                <div>
                  <span class="text-xs text-slate-400 block">Unit Price</span>
                  <span class="text-3xl font-black text-violet-400">${{ book.price }}</span>
                </div>
                <div class="text-right">
                  <span class="text-xs text-slate-400 block">Availability</span>
                  <span :class="book.stock_quantity > 0 ? 'text-emerald-400 font-semibold text-sm' : 'text-rose-400 font-semibold text-sm'">
                    {{ book.stock_quantity > 0 ? `${book.stock_quantity} units in stock` : 'Out of stock' }}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Book Info & Purchase Column -->
          <div class="lg:col-span-7 space-y-8">
            <div class="space-y-4">
              <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-violet-500/10 border border-violet-500/20 text-violet-400 text-xs font-semibold uppercase tracking-wider">
                Author: {{ book.author || 'Unknown' }}
              </div>
              <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                {{ book.title }}
              </h1>
              <div class="flex items-center gap-6 text-sm text-slate-400 pt-2">
                <div v-if="book.isbn">ISBN: <span class="text-slate-200 font-mono">{{ book.isbn }}</span></div>
                <div>Views: <span class="text-violet-400 font-semibold">{{ book.view_count }}</span></div>
                <div>Purchased: <span class="text-emerald-400 font-semibold">{{ book.purchase_count }} times</span></div>
              </div>
            </div>

            <!-- Description -->
            <div class="bg-slate-900/50 rounded-3xl p-8 border border-slate-800/80 space-y-4">
              <h3 class="text-lg font-bold text-white">About This Volume</h3>
              <p class="text-slate-300 leading-relaxed font-light text-base whitespace-pre-line">
                {{ book.description || 'No detailed description has been provided for this book yet.' }}
              </p>
            </div>

            <!-- Purchase Box -->
            <div class="bg-gradient-to-br from-violet-950/40 via-slate-900 to-slate-900 rounded-3xl p-8 border border-violet-500/20 shadow-2xl space-y-6">
              <div class="flex items-center justify-between">
                <div>
                  <h3 class="text-xl font-bold text-white">Instant Acquisition</h3>
                  <p class="text-xs text-slate-400 mt-0.5">Secure your digital/physical copy instantly</p>
                </div>
                <div class="text-2xl font-black text-white">${{ (book.price * quantity).toFixed(2) }}</div>
              </div>

              <div v-if="book.stock_quantity > 0" class="space-y-4">
                <div class="flex items-center gap-4">
                  <label class="text-sm font-medium text-slate-300">Quantity:</label>
                  <div class="flex items-center bg-slate-950 rounded-xl border border-slate-700 p-1">
                    <button
                      @click="quantity > 1 ? quantity-- : null"
                      class="px-3 py-1 text-slate-400 hover:text-white font-bold transition-colors"
                    >-</button>
                    <span class="px-4 text-white font-semibold text-sm">{{ quantity }}</span>
                    <button
                      @click="quantity < book.stock_quantity ? quantity++ : null"
                      class="px-3 py-1 text-slate-400 hover:text-white font-bold transition-colors"
                    >+</button>
                  </div>
                </div>

                <!-- If User is logged in -->
                <div v-if="$page.props.auth.user">
                  <button
                    @click="buy"
                    :disabled="form.processing"
                    class="w-full py-4 rounded-2xl bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-500 hover:to-indigo-500 text-white font-bold text-base shadow-xl shadow-violet-600/30 transition-all duration-200 flex items-center justify-center gap-2"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    Confirm Purchase ({{ quantity }} {{ quantity === 1 ? 'Copy' : 'Copies' }})
                  </button>
                </div>

                <!-- If User is NOT logged in -->
                <div v-else class="p-6 rounded-2xl bg-slate-950/80 border border-slate-800 text-center space-y-4">
                  <p class="text-sm text-slate-300">Please sign in or create a quick account to complete your purchase securely.</p>
                  <div class="flex items-center justify-center gap-4">
                    <Link
                      :href="route('login')"
                      class="px-6 py-2.5 rounded-xl bg-violet-600 hover:bg-violet-500 text-white font-semibold text-sm shadow-lg shadow-violet-600/30 transition-all"
                    >
                      Sign In
                    </Link>
                    <Link
                      :href="route('register')"
                      class="px-6 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-semibold text-sm border border-slate-700 transition-all"
                    >
                      Create Account
                    </Link>
                  </div>
                </div>
              </div>

              <div v-else class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-center text-sm font-semibold">
                Currently out of stock. Please check back later.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </ClientLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import ClientLayout from '@/Layouts/ClientLayout.vue';

const props = defineProps<{
  book: {
    id: number;
    title: string;
    author: string;
    isbn: string;
    image: string;
    description: string;
    price: number;
    stock_quantity: number;
    view_count: number;
    purchase_count: number;
  };
}>();

const quantity = ref(1);
const form = useForm({
  quantity: 1,
});

const buy = () => {
  form.quantity = quantity.value;
  form.post(route('books.purchase', props.book.id), {
    preserveScroll: true,
    onSuccess: () => {
      alert('Purchase successful! Thank you for your order.');
    },
  });
};
</script>
