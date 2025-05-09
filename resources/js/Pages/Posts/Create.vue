<template>
    <div class="p-4">
      <h1 class="text-2xl font-bold mb-4">Criar novo post</h1>
  
      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block text-sm font-medium">Título</label>
          <input v-model="form.title" type="text" class="border rounded w-full p-2" />
        </div>
  
        <div class="mb-4">
          <label class="block text-sm font-medium">Conteúdo</label>
          <textarea v-model="form.content" class="border rounded w-full p-2"></textarea>
        </div>
  
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Salvar</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        form: {
          title: '',
          content: ''
        }
      }
    },
    methods: {
      submit() {
        axios.post('/api/posts', this.form)
          .then(() => {
            alert('Post criado com sucesso!');
            this.form.title = '';
            this.form.content = '';
          })
          .catch(err => {
            console.error(err);
            alert('Erro ao criar post!');
          });
      }
    }
  }
  </script>
  