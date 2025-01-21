<template>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title"> LEAVE APPLICATION </span>
        </div>
        <div class="form-group">
            <label for="departments">OFFICE/DEPARTMENT</label>
            <select name="departments" id="departments" class="form-control">
                <option value="">CAST</option>
                <option value="">BSCRIM</option>
                <option value="">BSN</option>
                <option value="">CAST</option>
            </select>
        </div>
        <div class="form-group">
            <label for="last_name">LAST NAME: </label>
            <input
                type="text"
                name="last_name"
                id="last_name"
                class="form-control"
                placeholder="eg., Christoper"
            />
        </div>
        <div class="form-group">
            <label for="first_name">FIRST NAME:</label>
            <input
                type="text"
                name="first_name"
                id="first_name"
                class="form-control"
                placeholder="eg., Sab"
            />
        </div>
        <div class="form-group">
            <label for="middle_name">MIDDLE NAME:</label>
            <input
                type="text"
                name="middle_name"
                id="middle_name"
                class="form-control"
                placeholder="eg., Seguirel"
            />
        </div>
        <div class="form-group">
            <label for="date_filed">DATE OF FILING:</label>
            <input
                type="date"
                name="date_filed"
                id="date_filed"
                class="form-control"
            />
        </div>
        <div class="form-group">
            <label for="position">POSITION:</label>
            <input
                type="text"
                name="position"
                id="position"
                class="form-control"
                placeholder="eg., College Dean"
            />
        </div>
        <div class="form-group">
            <label for="rank">RANK:</label>
            <input
                type="text"
                name="rank"
                id="rank"
                class="form-control"
                placeholder="eg., Professor"
            />
        </div>
    </div>
    <div class="personal-details-items">
        <div class="title-container">
            <span class="title">DETAILS OF APPLICATION</span>
        </div>
        <div class="form-group">
            <label for="leave_name">TYPE OF LEAVE:</label>
            <select
                name="leave_name"
                id="leave_name"
                v-model="leave_type"
                class="form-control"
            >
                <option value="VACATION">VACATION</option>
                <option value="MATERNITY">MATERNITY</option>
                <option value="PATERNITY">PATERNITY</option>
                <option value="SICK">SICK</option>
                <option value="EDUCATIONAL">EDUCATIONAL</option>
                <option value="OTHERS">OTHERS</option>
            </select>
        </div>
        <div class="form-group" v-show="leave_type === 'OTHERS'">
            <label for="leave_type_others">If Others, please specify:</label>
            <input
                type="text"
                name="leave_type_others"
                id="leave_type_others"
                class="form-control"
                placeholder="Enter details..."
            />
        </div>
    </div>
</template>

<script>
import Layout from "@/Layouts/Layout.vue";

export default {
    data() {
        return {
            leave_type: "",
        };
    },
    layout: Layout,
};
</script>

<style scoped>
.title-container {
    border-bottom: #dedede 1px solid;
    background-color: #fff;
    box-shadow: 0 4px 5px rgba(0, 0, 0, 0.1);
    padding: 10px;
    position: sticky;
    top: 0;
    z-index: 1;
}

.title {
    font-size: 14px;
    padding: 10px;
    font-weight: bold;
}

.personal-details-content {
    display: flex;
    flex-wrap: wrap;
    height: 78vh;
    overflow-y: auto;
    margin-top: 5px;
    gap: 0.5rem;
}

.personal-details-items {
    flex-grow: 1;
    flex-basis: 400px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
.form-group {
    margin-bottom: 15px;
    padding: 10px;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    font-size: 12px;
}

.form-group input {
    width: 95%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

.radio-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.radio-group label {
    display: flex;
    align-items: center;
}

.form-control-radio {
    margin-right: 5px;
}
</style>
