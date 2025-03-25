<script src="./js/add-user-modal.js"></script>
<style scoped>
@import "./css/add-user-modal.css";
</style>

<template>
  <ConfirmationFormModal
    v-if="isConfirmation"
    :isConfirmation="isConfirmation"
    @toggleConfirmForm="toggleConfirmForm"
    @submitForm="submitForm"
  ></ConfirmationFormModal>
  <div class="modal" @click.self="closeModal">
    <div class="modal-content">
      <form @submit.prevent="submitForm" class="form">
        <div class="form-title">
          <span>Add a {{ type }}</span>
          <i @click="closeModal">&times;</i>
        </div>

        <div class="form-group" v-if="type === 'user'">
          <label for="first_name">First name:</label>
          <input
            id="first_name"
            s
            type="text"
            placeholder="Input first name"
            v-model="formData.first_name"
            required
          />

          <label for="last_name">Last name:</label>
          <input
            id="last_name"
            type="text"
            placeholder="Input last name"
            v-model="formData.last_name"
            required
          />

          <label for="middle_name">Middle name:</label>
          <input
            id="middle_name"
            type="text"
            placeholder="Input middle name"
            v-model="formData.middle_name"
            required
          />
        </div>

        <div class="form-group" v-if="type === 'teacher' || type === 'staff'">
          <label for="search_value">Select a user:</label>
          <div class="search-bar">
            <input
              id="search_value"
              type="text"
              placeholder="Search a user"
              v-model="searchValue"
              @input="searchUser(searchValue)"
              :disabled="selected_id !== null && selected_id !== ''"
              required
            />
            <i
              v-if="searchValue"
              @click="removeSelectedUser"
              title="Click to remove selected user."
              class="fas fa-xmark-circle fa-sm"
            ></i>
          </div>

          <div class="dropdown-users">
            <ul v-if="isSearchUser">
              <li
                @click="selectUser(staff.id, `${staff.last_name}, ${staff.first_name}`)"
                v-for="staff in staffs"
                :key="staff.id"
              >
                {{ staff.last_name + ", " + staff.first_name }}
              </li>
              <li class="empty-msg" v-if="!staffs">
                <small class="error-msg">No match found!</small>
              </li>
            </ul>
          </div>
          <small
            class="error-msg"
            v-if="(searchValue && !selected_id) || errors.selected_id"
            >{{ errors.selected_id_error }}</small
          >
        </div>
        <div class="form-group" v-if="type === 'teacher'">
          <label for="specialization">Specialization:</label>
          <input
            list="specialization"
            placeholder="Input teacher's specialization"
            v-model="formData.specialization"
            required
          />
          <datalist id="specialization" required>
            <option
              :value="specialization"
              v-for="specialization in specializationList"
              :key="specialization"
            />
          </datalist>

          <small class="error" v-if="errors.specialization">
            {{ errors.specialization_error }}
          </small>
        </div>

        <div class="form-group" v-if="type === 'teacher'">
          <label>Department:</label>

          <select id="departments" v-model="formData.department_id" required>
            <option value="" selected disabled>Select a department</option>
            <option
              :value="dept.department_id"
              v-for="dept in departments"
              :key="dept.department_id"
            >
              {{ dept.department_name }}
            </option>
          </select>
        </div>

        <div class="grouped-checkboxes" v-if="type === 'user'">
          <div class="form-checkbox">
            <label>Roles:</label>
            <div v-for="role in roleList" :key="role.id">
              <div class="checkbox-group">
                <input
                  type="checkbox"
                  :value="role.id"
                  v-model="formData.roles"
                  @click="selectedRole(role.id)"
                />
                <span>{{ role.name }}</span>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <span v-if="errors.departments" class="error">{{
            errors.departments_error
          }}</span>
          <span v-if="errors.roles" class="error"> {{ errors.roles_error }}</span>
        </div>

        <div class="form-group" v-if="type === 'staff'">
          <label for="position">Position:</label>
          <input
            type="text"
            id="position"
            list="positionList"
            placeholder="Input staff's position"
            v-model="formData.position"
            required
          />

          <datalist id="positionList">
            <option
              v-for="(position, index) in positionList"
              :key="index"
              :value="position"
            ></option>
          </datalist>
        </div>

        <div class="form-group" v-if="type === 'staff'">
          <label for="date_hired">Date Hired:</label>
          <input id="date_hired" type="date" v-model="formData.date_hired" required />
        </div>

        <div class="form-buttons">
          <button type="button" @click="closeModal" class="cancel-btn">Close</button>
          <button type="submit" class="submit-btn">Submit</button>
        </div>
      </form>
    </div>
  </div>
</template>
