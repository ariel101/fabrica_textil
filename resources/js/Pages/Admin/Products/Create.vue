<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'


defineOptions({
  layout: AuthenticatedLayout,
})

defineProps({ categories: Array })

const handleFileChange = (event) => {
  form.images = Array.from(event.target.files)
}


const form = useForm({
  name: '',
  description: '',
  price: '',
  stock: '',
  images: [],
  category_id: '',
})

const submitForm = () => {
  console.log(form.value);
  console.log('datos antes de ser enviados:', form)
  // Enviar datos al servidor con Inertia.post('/ruta', form.value);

  form.post(route('products.store'), {
    //forceFormData: true, // Para enviar archivos
    onSuccess: () => {
      // Redirigir o mostrar un mensaje de éxito
      console.log('Producto creado con éxito!');
    },
    onError: () => {
      // Manejar errores
      console.error('Error al crear el producto');
    },
  });
};
</script>

<template>
  <div class="max-w-2xl mx-auto mt-10 p-5 bg-white rounded-xl shadow-md">
    <h1 class="text-2xl font-bold text-gray-700 mb-5">Crear Nuevo Producto</h1>

    <form @submit.prevent="submitForm">
      <!-- Campo Nombre -->
      <div class="mb-4">
        <label for="nombre" class="block text-sm font-medium text-gray-600">Nombre</label>
        <input type="text" id="nombre" v-model="form.name"
          class="w-full mt-1 p-3 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
          placeholder="Nombre del producto" />
      </div>

      <!-- Campo Descripción -->
      <div class="mb-4">
        <label for="descripcion" class="block text-sm font-medium text-gray-600">Descripción</label>
        <textarea id="descripcion" v-model="form.description"
          class="w-full mt-1 p-3 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
          placeholder="Descripción del producto"></textarea>
      </div>

      <!-- Campo Precio -->
      <div class="mb-4">
        <label for="precio" class="block text-sm font-medium text-gray-600">Precio</label>
        <input type="number" id="precio" v-model="form.price"
          class="w-full mt-1 p-3 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
          placeholder="Precio del producto" step="0.01" />
      </div>

      <!-- Campo Stock -->
      <div class="mb-4">
        <label for="stock" class="block text-sm font-medium text-gray-600">Stock</label>
        <input type="number" id="stock" v-model="form.stock"
          class="w-full mt-1 p-3 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
          placeholder="Cantidad en stock" />
      </div>

      <!-- Campo Imágenes -->
      <div class="mb-4">
        <label for="imagenes" class="block text-sm font-medium text-gray-600">Imágenes</label>
        <input type="file" id="imagenes" name="images[]" multiple @change="handleFileChange"
          class="w-full mt-1 p-3 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" />
        <ul class="mt-2 text-sm text-gray-500">
          <li v-for="(file, i) in form.images" :key="i">{{ file.name }}</li>
        </ul>
      </div>


      <!-- Campo Categoría -->
      <div class="mb-4">
        <label for="categoria" class="block text-sm font-medium text-gray-600">Categoría</label>
        <select id="categoria" v-model="form.category_id"
          class="w-full mt-1 p-3 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
          <option value="" disabled>Seleccione una categoría</option>
          <option v-for="categoria in categories" :key="categoria.id" :value="categoria.id">
            {{ categoria.nombre }}
          </option>
        </select>
      </div>

      <!-- Botón de envío -->
      <button type="submit"
        class="w-full p-3 bg-blue-500 text-white font-medium rounded-md hover:bg-blue-600 focus:outline-none">
        Crear Producto
      </button>
    </form>
  </div>
</template>
