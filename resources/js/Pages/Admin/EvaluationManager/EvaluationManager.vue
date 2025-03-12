<script>
import Layout from "@/Layouts/Layout.vue";
import NewTemplateModal from "../EvaluationManager/Modals/NewTemplateModal.vue";
import FromTemplateModal from "../EvaluationManager/Modals/FromOldTemplateModal.vue";
export default {
    layout: Layout,
    components: {
        NewTemplateModal,
        FromTemplateModal,
    },
    data() {
        return {
            isNewTempModal: false,
            isFromTempModal: false,
        };
    },
    methods: {
        toggleNewTemplate() {
            this.isNewTempModal = !this.isNewTempModal;
        },
        toggleFromOlTemplate() {
            this.isFromTempModal = !this.isFromTempModal;
        },
    },
};
</script>

<template>
    <NewTemplateModal v-if="isNewTempModal" :isNewTempModal="isNewTempModal" @toggleNewTemplate="toggleNewTemplate">
    </NewTemplateModal>
    <FromTemplateModal v-if="isFromTempModal" :isFromTempModal="isFromTempModal"
        @toggleFromOlTemplate="toggleFromOlTemplate">
    </FromTemplateModal>
    <div class="main-container">
        <div class="top-nav">
            <button @click="toggleNewTemplate"><i class="fa fa-plus"></i> Create New Template</button>
            <button @click="toggleFromOlTemplate"><i class="fa fa-plus"></i> Create From Template</button>
        </div>

        <div class="content">
            <div class="cards">
                <div class="card" v-for="i in 3" :key="i">
                    <div class="card-header">
                        <h3>Template {{ i }}</h3>
                    </div>
                    <div class="card-body">
                        <p>Template Description</p>
                    </div>
                    <div class="card-footer">
                        <button><i class="fa fa-edit"></i> Edit</button>
                        <button><i class="fa fa-trash"></i> Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.main-container {
    max-width: 100%;
    margin: 0 auto;
    display: flex;
    padding-left: 20px;
    padding-right: 20px;
    flex-direction: column;
    gap: 1rem;
}

.top-nav {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding: 1rem;
    border-bottom: 1px solid #011325;
}

.top-nav button {
    padding: 0.5rem 1rem;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.top-nav button:hover {
    opacity: 0.8;
}

.content {
    display: flex;
    gap: 1rem;
}

.cards {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.card {
    background: #91c7f6;
    color: #000000;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    width: 300px;
    border: 1px solid #444;
    border-radius: 5px;
    padding: 1rem;
}

.card-footer {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.card-footer button {
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 0.5rem 1rem;
    cursor: pointer;
}

.card-footer button:hover {
    opacity: 0.8;
}
</style>
