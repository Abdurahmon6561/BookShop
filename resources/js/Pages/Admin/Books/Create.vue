<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Create New Book
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg font-medium text-gray-900">
              Book Details
            </h3>
            <p class="mt-1 text-sm text-gray-600">
              Fill in the form to create a new book.
            </p>
          </div>
          <div class="border-t border-gray-200">
            <form @submit.prevent="save" class="px-4 py-5 sm:px-6">
              <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                  <label for="title" class="block text-sm font-medium text-gray-700">
                    Title
                  </label>
                  <div class="mt-1">
                    <input
                      id="title"
                      name="title"
                      type="text"
                      class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                      v-model="form.title"
                      required
                    >
                  </div>
                  <p class="mt-1 text-sm text-red-600" v-if="form.errors.title">
                    {{ form.errors.title }}
                  </p>
                </div>

                <div>
                  <label for="author" class="block text-sm font-medium text-gray-700">
                    Author
                  </label>
                  <div class="mt-1">
                    <input
                      id="author"
                      name="author"
                      type="text"
                      class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                      v-model="form.author"
                    >
                  </div>
                </div>

                <div class="sm:col-span-2">
                  <label for="isbn" class="block text-sm font-medium text-gray-700">
                    ISBN
                  </label>
                  <div class="mt-1">
                    <input
                      id="isbn"
                      name="isbn"
                      type="text"
                      class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                      v-model="form.isbn"
                    >
                  </div>
                  <p class="mt-1 text-sm text-red-600" v-if="form.errors.isbn">
                    {{ form.errors.isbn }}
                  </p>
                </div>

                <div>
                  <label for="price" class="block text-sm font-medium text-gray-700">
                    Price ($)
                  </label>
                  <div class="mt-1">
                    <input
                      id="price"
                      name="price"
                      type="number"
                      step="0.01"
                      min="0"
                      class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                      v-model.number="form.price"
                      required
                    >
                  </div>
                  <p class="mt-1 text-sm text-red-600" v-if="form.errors.price">
                    {{ form.errors.price }}
                  </p>
                </div>

                <div>
                  <label for="stock_quantity" class="block text-sm font-medium text-gray-700">
                    Stock Quantity
                  </label>
                  <div class="mt-1">
                    <input
                      id="stock_quantity"
                      name="stock_quantity"
                      type="number"
                      min="0"
                      class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                      v-model.number="form.stock_quantity"
                      required
                    >
                  </div>
                  <p class="mt-1 text-sm text-red-600" v-if="form.errors.stock_quantity">
                    {{ form.errors.stock_quantity }}
                  </p>
                </div>

                <div class="sm:col-span-2">
                  <label for="description" class="block text-sm font-medium text-gray-700">
                    Description
                  </label>
                  <div class="mt-1">
                    <textarea
                      id="description"
                      name="description"
                      rows="3"
                      class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                      v-model="form.description"
                    ></textarea>
                  </div>
                </div>

                <div class="sm:col-span-2">
                  <label for="image" class="block text-sm font-medium text-gray-700">
                    Book Cover Image
                  </label>
                  <div class="mt-1 flex flex-col">
                    <input
                      id="image"
                      name="image"
                      type="file"
                      class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500"
                      accept="image/*"
                      @change="onImageChange"
                    >
                    <p class="mt-1 text-xs text-gray-500">
                      PNG, JPG, GIF (max 2MB)
                    </p>
                  </div>
                  <p class="mt-1 text-sm text-red-600" v-if="form.errors.image">
                    {{ form.errors.image }}
                  </p>
                </div>

                <div class="sm:col-span-2">
                  <div class="flex items-center space-x-4">
                    <input
                      id="is_active"
                      name="is_active"
                      type="checkbox"
                      class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                      v-model="form.is_active"
                    >
                    <label for="is_active" class="text-sm text-gray-700">
                      Active
                    </label>
                  </div>
                </div>
              </div>

              <div class="mt-6 flex items-center justify-end space-x-3">
                <router-link
                  :to="{ name: 'admin.books.index' }"
                  class="text-sm font-medium text-gray-500 hover:text-gray-700"
                >
                  Cancel
                </router-link>
                <button
                  type="submit"
                  disabled="form.processing"
                  class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-indigo-600 border border-transparent rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                  {{ form.processing ? 'Saving...' : 'Create Book' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

const form = useForm({
  title: '',
  author: '',
  isbn: '',
  price: '',
  stock_quantity: '',
  description: '',
  image: null,
  is_active: true,
});

const onImageChange = (e) => {
  form.image = e.target.files[0];
};

const save = () => {
  form.post(route('admin.books.store'), {
    onSuccess: () => {
      router.route('admin.books.index');
    },
    onError: () => {
      // Form errors are handled by useForm
    },
  });
};
</script>