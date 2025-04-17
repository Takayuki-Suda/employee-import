<template>
    <div class="p-8">
        <div
            class="border-4 border-dashed border-gray-300 p-8 rounded-lg text-center cursor-pointer"
            @dragover.prevent
            @drop.prevent="handleDrop"
        >
            <p class="text-gray-600">ここにCSVファイルをドラッグ＆ドロップ</p>
            <input
                type="file"
                ref="fileInput"
                class="hidden"
                @change="handleFileChange"
            />
            <button
                @click="triggerFileInput"
                class="mt-4 px-4 py-2 bg-blue-500 text-white rounded"
            >
                ファイル選択
            </button>
        </div>

        <div v-if="message" class="mt-4 text-green-600">{{ message }}</div>
        <div v-if="error" class="mt-4 text-red-600">{{ error }}</div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            file: null,
            message: "",
            error: "",
        };
    },
    methods: {
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        handleFileChange(e) {
            this.file = e.target.files[0];
            this.uploadFile();
        },
        handleDrop(e) {
            this.file = e.dataTransfer.files[0];
            this.uploadFile();
        },
        async uploadFile() {
            if (!this.file) return;

            const formData = new FormData();
            formData.append("csv_file", this.file);

            try {
                const response = await axios.post("/import", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });
                this.message = response.data.message || "アップロード成功！";
                this.error = "";
            } catch (err) {
                this.error =
                    err.response?.data?.error || "アップロードに失敗しました";
                this.message = "";
            }
        },
    },
};
</script>

<style scoped></style>
