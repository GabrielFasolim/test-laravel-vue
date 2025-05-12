<template>
    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 border-b pb-3">
            Criar novo post
        </h1>

        <form @submit.prevent="submit" class="space-y-6">
            <div class="space-y-2">
                <label
                    for="title"
                    class="block text-sm font-medium text-gray-700"
                    >Título</label
                >
                <input
                    id="title"
                    v-model="form.title"
                    type="text"
                    class="w-full px-4 py-3 rounded-lg border transition-all duration-200"
                    :class="[
                        'border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500',
                        titleError
                            ? 'border-red-300 focus:ring-red-500 focus:border-red-500'
                            : '',
                    ]"
                    placeholder="Digite o título do seu post"
                />
                <p v-if="titleError" class="text-red-500 text-sm mt-1">
                    {{ titleError }}
                </p>
            </div>

            <div class="space-y-2">
                <label
                    for="content"
                    class="block text-sm font-medium text-gray-700"
                    >Conteúdo</label
                >
                <div class="relative">
                    <textarea
                        id="content"
                        v-model="form.content"
                        class="w-full px-4 py-3 rounded-lg border transition-all duration-200 min-h-[200px]"
                        :class="[
                            'border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500',
                            contentError
                                ? 'border-red-300 focus:ring-red-500 focus:border-red-500'
                                : '',
                        ]"
                        placeholder="Escreva o conteúdo do seu post aqui..."
                    ></textarea>
                    <div
                        class="absolute bottom-2 right-2 text-xs text-gray-500"
                    >
                        {{ form.content.length }} caracteres
                    </div>
                </div>
                <p v-if="contentError" class="text-red-500 text-sm mt-1">
                    {{ contentError }}
                </p>
            </div>

            <div class="flex items-center justify-between pt-4">
                <button
                    type="button"
                    @click="cancel"
                    class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                >
                    Cancelar
                </button>
                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 transition-colors duration-200 flex items-center"
                    :disabled="isSubmitting"
                >
                    <span v-if="isSubmitting" class="mr-2">
                        <svg
                            class="animate-spin h-4 w-4 text-white"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                            ></path>
                        </svg>
                    </span>
                    {{ isSubmitting ? "Salvando..." : "Salvar post" }}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import axios from "@/bootstrap"; // importa instância axios com withCredentials configurado
import Cookies from "js-cookie";

export default {
    data() {
        return {
            form: {
                title: "",
                content: "",
            },
            isSubmitting: false,
            titleError: null,
            contentError: null,
        };
    },
    methods: {
        async submit() {
            this.clearErrors();
            this.isSubmitting = true;

            try {
                // 1) Pegue o token no localStorage e confira no console
                const token = Cookies.get("XSRF-TOKEN");
                console.log("Token atual:", token);
                if (!token) {
                    throw new Error("Nenhum token encontrado em localStorage");
                }

                // 2) Faça o POST incluindo o header Authorization
                await axios.post(
                    "/api/posts",
                    {
                        title: this.form.title,
                        content: this.form.content,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                            Accept: "application/json",
                        },
                    }
                );

                alert("Post criado com sucesso!");
                window.location.href = "/posts";
            } catch (err) {
                console.error(err);
                if (err.message.includes("Nenhum token")) {
                    return alert("Por favor, faça login para obter um token.");
                }
                if (err.response?.status === 422) {
                    const errors = err.response.data.errors;
                    this.titleError = errors.title?.[0] ?? null;
                    this.contentError = errors.content?.[0] ?? null;
                } else if (err.response?.status === 401) {
                    alert("Token inválido ou expirado. Faça login novamente.");
                    window.location.href = "/login";
                } else {
                    alert("Erro ao criar post!");
                }
            } finally {
                this.isSubmitting = false;
            }
        },
        cancel() {
            window.location.href = "/posts";
        },
        clearErrors() {
            this.titleError = null;
            this.contentError = null;
        },
    },
};
</script>
