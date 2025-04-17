import "./bootstrap";
import { createApp } from "vue";
import CsvUploader from "./components/CsvUploader.vue";

createApp({
    components: {
        CsvUploader,
    },
}).mount("#app");
