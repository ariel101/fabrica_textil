<template>
  <div class="container mx-auto p-6 max-w-4xl">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Your Shopping Cart</h1>

    <div v-if="carts.length > 0" class="space-y-6">
      <div v-for="item in carts" :key="item.id" class="flex items-center p-4 border rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 bg-white">
        <img
          :src="`${item.image}`"
          alt="Product Image"
          class="w-24 h-24 object-cover mr-6 rounded-lg"
        />
        <div class="flex-1">
          <h2 class="text-lg font-semibold text-gray-800">{{ item.name }}</h2>
          <p class="text-gray-600">Price: ${{ item.price }}</p>
          <p class="text-gray-600">Quantity: {{ item.quantity }}</p>
          <p class="text-gray-600">
            Subtotal: ${{ (item.price * item.quantity).toFixed(2) }}
          </p>
        </div>
      </div>

      <!-- Total Section -->
      <div class="p-6 bg-gray-50 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800">Total: ${{ total.toFixed(2) }}</h2>

        <div class="mt-6 text-center">
          <Link
            href="/checkout"
            class="px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-200"
          >
            Proceed to Checkout
          </Link>
        </div>
      </div>
    </div>

    <!-- Empty Cart -->
    <div v-else class="text-center text-gray-600">
      <p>Your cart is empty.</p>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import Welcome from '../Welcome.vue'

defineProps({
  carts: {
    type: Array,
    required: true,
  },
  total: {
    type: Number,
    required: true,
  },
})

defineOptions({
  layout: Welcome,
})
</script>
