<template>
  <AuthenticatedLayout>
    <div class="max-w-4xl mx-auto p-6">
      <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Posts do usuário</h1>
        <button 
          @click="goToCreatePost" 
          class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors duration-200 flex items-center gap-2"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
          </svg>
          Novo post
        </button>
      </div>
  
      <!-- Estado vazio -->
      <div v-if="!posts || posts.length === 0" class="bg-gray-50 rounded-lg p-8 text-center border border-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
          <polyline points="14 2 14 8 20 8"></polyline>
          <line x1="16" y1="13" x2="8" y2="13"></line>
          <line x1="16" y1="17" x2="8" y2="17"></line>
          <polyline points="10 9 9 9 8 9"></polyline>
        </svg>
        <h3 class="text-lg font-medium text-gray-700 mb-2">Nenhum post encontrado</h3>
        <p class="text-gray-500 mb-4">Comece criando seu primeiro post agora mesmo.</p>
      </div>
  
      <!-- Lista de posts -->
      <div v-else class="space-y-6">
        <div 
          v-for="post in posts" 
          :key="post.id" 
          class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200"
        >
          <div class="p-6">
            <div class="flex justify-between items-start mb-3">
              <h2 class="text-xl font-semibold text-gray-800 hover:text-emerald-600 transition-colors duration-200">
                {{ post.title }}
              </h2>
              <div class="flex space-x-2">
                <button @click="$emit('edit-post', post.id)" class="text-gray-500 hover:text-emerald-600 transition-colors">
                  <!-- ícone editar -->
                </button>
                <button @click="confirmDelete(post.id)" class="text-gray-500 hover:text-red-600 transition-colors">
                  <!-- ícone deletar -->
                </button>
              </div>
            </div>
            
            <p class="text-gray-600 mb-4">{{ truncateContent(post.content) }}</p>
            
            <div class="flex justify-between items-center pt-4 border-t border-gray-100">
              <div class="text-sm text-gray-500">
                <span v-if="post.createdAt">
                  {{ formatDate(post.createdAt) }}
                </span>
                <span v-else>Data não disponível</span>
              </div>
              
              <button 
                v-if="isContentTruncated(post.content)" 
                @click="$emit('view-post', post.id)" 
                class="text-sm text-emerald-600 hover:text-emerald-700 transition-colors"
              >
                Ler mais
              </button>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Modal de confirmação de exclusão -->
      <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Confirmar exclusão</h3>
          <p class="text-gray-600 mb-6">Tem certeza que deseja excluir este post? Esta ação não pode ser desfeita.</p>
          <div class="flex justify-end space-x-3">
            <button 
              @click="showDeleteModal = false" 
              class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors"
            >
              Cancelar
            </button>
            <button 
              @click="deletePost" 
              class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors"
            >
              Excluir
            </button>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue'
import { router as inertiaRouter } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

// Props
const props = defineProps({
  posts: {
    type: Array,
    required: true,
    default: () => []
  }
})

// Emits
const emit = defineEmits(['edit-post', 'delete-post', 'view-post'])

// Estado para modal de exclusão
const showDeleteModal = ref(false)
const postToDelete = ref(null)

// Funções utilitárias
const truncateContent = (content) => {
  const maxLength = 150
  return content.length > maxLength
    ? content.substring(0, maxLength) + '...'
    : content
}

const isContentTruncated = (content) => content.length > 150

const formatDate = (dateString) => {
  try {
    return new Intl.DateTimeFormat('pt-BR', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric'
    }).format(new Date(dateString))
  } catch {
    return 'Data inválida'
  }
}

// Exclusão
const confirmDelete = (postId) => {
  postToDelete.value = postId
  showDeleteModal.value = true
}

const deletePost = () => {
  emit('delete-post', postToDelete.value)
  showDeleteModal.value = false
  postToDelete.value = null
}

// Navegação Inertia
const goToCreatePost = () => {
  inertiaRouter.visit('/posts/create')
}
</script>
