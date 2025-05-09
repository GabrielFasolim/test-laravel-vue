<template>
    <div class="p-4">
      <h1 class="text-2xl font-bold mb-4">Posts do usuário</h1>
  
      <div v-for="post in posts" :key="post.id" class="p-4 bg-gray-100 rounded mb-3">
        <h2 class="text-lg font-semibold">{{ post.title }}</h2>
        <p>{{ post.content }}</p>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      posts: {
        type: Array,
        required: true
      }
    }
  }
  </script>
  