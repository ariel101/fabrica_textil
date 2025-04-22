<script setup>
import { useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineOptions({
    layout: AuthenticatedLayout,
})

// Props
const prop = defineProps({
    product: Object,
    categories: Array,
})

// Estado del formulario (solo usamos "images")
const form = useForm({
    id: prop.product.id,
    name: prop.product.name,
    description: prop.product.description,
    price: prop.product.price,
    stock: prop.product.stock,
    category_id: prop.product.category_id,
    images: prop.product.images || [], // aquí irán tanto las actuales como nuevas
})

// Captura de nuevas imágenes y las agrega al mismo array "images"
const handleFileChange = (e) => {
    const files = Array.from(e.target.files)
    files.forEach(file => {
        const reader = new FileReader()
        reader.onload = () => {
            form.images.push({
                //file, // guardamos el objeto File para enviar después
                name: file.name,
                data: reader.result // base64 para previsualización
            })
        }
        reader.readAsDataURL(file)
    })
}



// Eliminar cualquier imagen (ya sea actual o nueva)
const removeImage = (index) => {
    form.images.splice(index, 1)
}

//Enviar datos
const submitForm = () => {
    const data = form.data()

    // Preparamos el array de imágenes
    const processedImages = form.images.map(img => {
        if (img.data) {
            // Imagen nueva (base64)
            return {
                name: img.name,
                data: img.data,
            }
        } else if (img.path) {
            // Imagen actual
            return {
                path: img.path,
                name: img.name,
            }
        }
    })

    // Enviamos todo como JSON normal (sin FormData)
    data.images = JSON.stringify(processedImages)

    form.put(route('products.update', form.id), {
        data,
        onStart: () => console.log('⏳ Enviando...'),
        onSuccess: () => console.log('✅ Producto actualizado'),
        onError: (e) => console.error('❌ Error al actualizar:', e),
    })
}


</script>

<template>
    <div class="max-w-2xl mx-auto mt-12 p-6 bg-white rounded-xl shadow-xl">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Editar Producto</h1>

        <form @submit.prevent="submitForm" class="space-y-5">

            <!-- Nombre -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-600">Nombre del Producto</label>
                <input type="text" id="nombre" v-model="form.name"
                    class="w-full p-4 mt-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 transition duration-200"
                    placeholder="Nombre del producto" />
            </div>

            <!-- Descripción -->
            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-600">Descripción</label>
                <textarea id="descripcion" v-model="form.description"
                    class="w-full p-4 mt-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 transition duration-200"
                    placeholder="Descripción del producto"></textarea>
            </div>

            <!-- Precio -->
            <div>
                <label for="precio" class="block text-sm font-medium text-gray-600">Precio</label>
                <input type="number" id="precio" v-model="form.price"
                    class="w-full p-4 mt-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 transition duration-200"
                    step="0.01" placeholder="Precio del producto" />
            </div>

            <!-- Stock -->
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-600">Stock</label>
                <input type="number" id="stock" v-model="form.stock"
                    class="w-full p-4 mt-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 transition duration-200"
                    placeholder="Cantidad en stock" />
            </div>

            <!-- Imágenes -->
            <div>
                <label for="imagenes" class="block text-sm font-medium text-gray-600">Subir nuevas imágenes</label>
                <input type="file" id="imagenes" name="images[]" multiple accept="image/*" @change="handleFileChange"
                    class="w-full p-4 mt-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 transition duration-200" />

                <!-- Galería -->
                <div class="flex flex-wrap gap-4 mt-4">
                    <div v-for="(img, i) in form.images" :key="i"
                        class="relative w-24 h-24 rounded overflow-hidden border border-gray-200 shadow">
                        <img :src="img.path ? `/${img.path}` : img.data" :alt="img.name || `Imagen ${i + 1}`"
                            class="object-cover w-full h-full" />
                        <button @click="removeImage(i)"
                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full h-6 w-6 flex items-center justify-center shadow">
                            ×
                        </button>
                    </div>
                </div>
            </div>

            <!-- Categoría -->
            <div>
                <label for="categoria" class="block text-sm font-medium text-gray-600">Categoría</label>
                <select id="categoria" v-model="form.category_id"
                    class="w-full p-4 mt-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 transition duration-200">
                    <option value="" disabled>Seleccione una categoría</option>
                    <option v-for="categoria in categories" :key="categoria.id" :value="categoria.id">
                        {{ categoria.nombre }}
                    </option>
                </select>
            </div>

            <!-- Botón -->
            <div class="flex justify-center mt-2">
                <button type="submit"
                    class="w-full md:w-auto px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">
                    Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</template>
