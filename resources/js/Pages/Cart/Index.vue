<template>
  <div class="container mx-auto p-6 max-w-4xl relative bg-gray-200">
    <!-- Alert Message -->
    <div v-if="showMessage" class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50">
      <div
        :class="[
          'px-6 py-3 rounded-lg shadow-lg flex items-center justify-between min-w-[500px] relative overflow-hidden',
          alertType === 'success' ? 'bg-green-500 text-white' : 'bg-red-600 text-white'
        ]"
      >
        <span>{{ alertMessage }}</span>
        <div class="absolute bottom-0 left-0 h-1 w-full bg-white bg-opacity-30">
          <div
            class="h-full bg-white animate-progress-bar"
            :key="messageKey"
          ></div>
        </div>
      </div>
    </div>

    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Your Shopping Cart</h1>

    <div v-if="carts.length > 0" class="space-y-6">
      <div
        v-for="(item, index) in carts"
        :key="item.id"
        class="flex items-center justify-between p-4 border rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 bg-white"
      >
        <!-- Imagen y detalles -->
        <a :href="route('products.showHome', item.id)" class="flex items-center gap-4">
          <div class="flex items-center gap-6">
            <img :src="`${item.image}`" alt="Product Image" class="w-24 h-24 object-cover rounded-lg" />
            <div>
              <h2 class="text-lg font-semibold text-gray-800">{{ item.name }}</h2>
              <p class="text-gray-600">Price: ${{ item.price }}</p>
              <p class="text-gray-600">Subtotal: ${{ (item.price * item.quantity).toFixed(2) }}</p>
            </div>
          </div>
        </a>

        <!-- Controles -->
        <div class="flex flex-col items-end gap-2">
          <div class="flex items-center gap-2">
            <button @click="decreaseQuantity(index)" class="bg-gray-200 px-2 py-1 rounded hover:bg-gray-300">-</button>
            <span class="text-gray-800 font-semibold">{{ item.quantity }}</span>
            <button @click="increaseQuantity(index)" class="bg-gray-200 px-2 py-1 rounded hover:bg-gray-300">+</button>
          </div>
          <button @click="removeItem(index)" class="text-red-600 hover:underline text-sm">Remove</button>
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
import { ref, computed, onMounted, nextTick } from 'vue'
import { Link } from '@inertiajs/vue3'
import Welcome from '../Welcome.vue'
import emitter from '@/utils/eventBus';


//defineOptions({ layout: Welcome })
defineOptions({
  layout: (h, page) => h(Welcome, { showFooter: false, showCategories: false }, () => page)
})


const carts = ref([])

// Alerta flotante
const showMessage = ref(false)
const alertMessage = ref('')
const alertType = ref('success') // 'success' o 'error'
const messageKey = ref(0) // Forzar reinicio animación

const emitCartCount = () => {
  const totalCount = carts.value.reduce((sum, item) => sum + item.quantity, 0);
  localStorage.setItem('cartCount', totalCount);
  emitter.emit('update-cart', totalCount);
};


const showAlert = (message, type = 'success') => {
  alertMessage.value = message
  alertType.value = type
  showMessage.value = false
  messageKey.value++ // Cambia el key para reiniciar animación

  nextTick(() => {
    showMessage.value = true
    setTimeout(() => {
      showMessage.value = false
    }, 2500)
  })
}

onMounted(() => {
  const stored = localStorage.getItem('cart')
  carts.value = stored ? JSON.parse(stored) : []
})

const updateLocalStorage = () => {
  localStorage.setItem('cart', JSON.stringify(carts.value))
}

const increaseQuantity = (index) => {
  carts.value[index].quantity += 1
  updateLocalStorage()
  emitCartCount()
  showAlert('Se actualizó la cantidad del producto', 'success')
}

const decreaseQuantity = (index) => {
  if (carts.value[index].quantity > 1) {
    carts.value[index].quantity -= 1
    updateLocalStorage()
    emitCartCount()
    showAlert('Se actualizó la cantidad del producto', 'success')
  }
}

const removeItem = (index) => {
  carts.value.splice(index, 1)
  updateLocalStorage()
  emitCartCount()
  showAlert('El artículo fue eliminado del carrito', 'error')
}

const total = computed(() =>
  carts.value.reduce((sum, item) => sum + item.price * item.quantity, 0)
)
</script>

<style>
@keyframes progressBar {
  from {
    width: 0%;
  }
  to {
    width: 100%;
  }
}

.animate-progress-bar {
  animation: progressBar 2.5s linear forwards;
}
</style>
