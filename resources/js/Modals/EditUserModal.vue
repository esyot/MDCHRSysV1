<script src="./js/edit-user-modal.js"></script>

<template>
  <ConfirmationFormModal
    :isConfirmation="isConfirmation"
    :message="message"
    @toggleConfirmForm="toggleConfirmForm"
    @submitForm="submitForm"
  ></ConfirmationFormModal>
  <div class="modal" @click.self="closeModal">
    <div class="modal-content">
      <div class="modal-header">
        <span>Edit User</span>
        <i @click="closeModal">&times;</i>
      </div>
      <form @submit.prevent="toggleConfirmForm()">
        <div class="modal-content-items">
          <div class="item">
            <div class="form-group">
              <label for="">Activate:</label>
              <div class="switch">
                <input type="checkbox" id="active-toggle" v-model="formData.is_active" />
                <label for="active-toggle"></label>
              </div>
            </div>
            <div class="form-group">
              <label for="">User:</label>
              <input type="text" v-model="formData.user" id="user" required />
            </div>

            <div class="form-group">
              <label for="">New Password:</label>
              <div class="password">
                <input id="password" type="password" v-model="formData.password" />
                <i id="icon-eye" class="fas fa-eye-slash" @click="viewPassword"></i>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="form-checkbox">
              <label>Roles: </label>
              <div v-for="role in roleList" :key="role.id">
                <div class="checkbox-group">
                  <input
                    type="checkbox"
                    :value="role.id"
                    :checked="userRoles.includes(role.name)"
                    @change="selectedRole(role.id, $event.target)"
                  />
                  <span>{{ role.name }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="buttons">
          <button @click="closeModal" class="close-btn">Close</button>
          <button type="submit" v-if="formData.roles.length != 0" class="update-btn">
            Update
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
/* Switch styling */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 39px;
  scale: 0.8;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.switch label {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  transition: 0.4s;
  border-radius: 34px;
}

.switch label:before {
  content: "";
  position: absolute;
  left: 4px;
  bottom: 4px;
  top: 4px;
  width: 26px;
  height: 26px;
  background-color: white;
  border-radius: 50%;
  transition: 0.4s;
}

.switch input:checked + label {
  background-color: #4caf50;
}

.switch input:checked + label:before {
  transform: translateX(26px);
}
.modal {
  display: flex;
  position: fixed;
  justify-content: center;
  align-items: center;
  inset: 0;
  z-index: 10;
  animation: popUp 0.3s ease-in-out forwards, increaseOpacity 2s 0.3s forwards;
}

.modal-content {
  background-color: #fff;
  min-width: 300px;
}
.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 5px;
  border-bottom: 1px solid #c7c7c7;
}
.modal-header span {
  font-size: 16pt !important;
  padding-inline: 5px;
  font-weight: bold;
}

.modal-header i {
  font-weight: bold;
  font-size: 16pt !important;
  margin-inline: 10px;
  opacity: 50%;
}

.modal-header i:hover {
  opacity: 100%;
  cursor: pointer;
}

.modal-content-items {
  display: flex;
  flex-wrap: wrap;
}

.modal-content-items .item {
  padding: 10px;
}

.form-group {
  display: flex;
  flex-direction: column;
}
.form-group input {
  width: 100%;
}
.form-group label {
  font-weight: bold;
}

.form-checkbox {
  padding: 10px;
  max-height: 50vh;
  overflow-y: auto;
}

.form-subtitle {
  padding-inline: 10px;
}

.form-subtitle label {
  font-weight: bold;
  display: block;
}

.checkbox-group {
  display: flex;
  margin-bottom: 5px;
  align-items: center;
  border: 1px solid #a0a0a0;
  box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.2);
  width: auto;
  gap: 0.3rem;
  padding: 10px;
}

.checkbox-group:hover {
  background-color: #c7c7c7;
}
.checkbox-group input {
  margin-right: 5px;
  cursor: pointer;
  scale: 1.5;
}
.checkbox-group label {
  font-weight: bold;
  margin-bottom: 5px;
}

.buttons {
  display: flex;
  justify-content: end;
  margin: 10px;
  gap: 0.2rem;
}

.buttons button {
  padding: 10px;
  border-radius: 5px;
  border: none;
  opacity: 50%;
}

.buttons button:hover {
  opacity: 100%;
  cursor: pointer;
}

.close-btn {
  background-color: #848484;
  color: #fff;
}

.update-btn {
  background-color: rgb(32, 131, 222);
  color: #fff;
}

.password {
  display: flex;
  align-items: center;
  justify-content: space-between;
  border: 1px solid #ddd;
  padding: 10px;
  width: 100%;
  border-radius: 5px;
}

.password input {
  border: none;
  padding: 0;
  margin: 0;
  outline: none;
}

.password i {
  opacity: 50%;
}

.password i:hover {
  opacity: 100%;
  cursor: pointer;
}
</style>
