<script src="./js/tracking.js"></script>

<template>
  <Modal
    :forms="forms"
    :selected_id="selected_id"
    :selected_type="selected_type"
    @toggleFormModal="toggleFormModal"
  />

  <DeleteModal
    v-if="isDelete"
    :selected_id="selected_id_to_delete"
    :selected_type="selected_type_to_delete"
    @deleteForm="deleteForm"
    @toggleDeleteForm="toggleDeleteForm"
  ></DeleteModal>

  <div class="container">
    <div class="content">
      <WhenVisible data="forms">
        <template #fallback>
          <Loader :message="'fetching forms, please wait.'"></Loader>
        </template>
        <table>
          <thead>
            <tr>
              <td class="td-title">
                <i class="fa-solid fa-paperclip"></i>
                <span>Type</span>
              </td>
              <td class="td-title">
                <i class="fa-solid fa-temperature-empty"></i>
                <span>Status</span>
              </td>
              <td class="td-title">
                <i class="fa-solid fa-share-from-square"></i>
                <span>Submitted on</span>
              </td>
              <td class="td-action">
                <i class="fa-solid fa-gear"></i>
                <span>Action</span>
              </td>
            </tr>
          </thead>

          <tbody>
            <tr v-for="form in forms" :key="form.id">
              <td>{{ form.form_type }}</td>
              <td class="td-status">
                <div class="status-item" v-if="statusMap[form.status]">
                  <span>{{ statusMap[form.status].text }} </span>
                  <i
                    v-if="statusMap[form.status].icon !== 'loading'"
                    :class="`fas ${statusMap[form.status].icon} ${
                      statusMap[form.status].color
                    }`"
                  ></i>
                  <img
                    v-else
                    class="loading"
                    src="/public/assets/loader/loading.gif"
                    alt=""
                  />

                  <p v-if="form.status === 'declined'">
                    Reason for disapproval: {{ form.disapproval_description }}
                  </p>
                </div>
              </td>
              <td>{{ formatDate(form.created_at) }}</td>
              <td class="td-action">
                <button
                  v-if="form.status === 'declined'"
                  @click="redirectToEditForm(form.id, form.form_type)"
                  class="edit-btn"
                  title="Click to update your application"
                >
                  <i class="fas fa-pencil"></i>
                </button>
                <button
                  @click="toggleFormModal(form.id, form.form_type)"
                  class="edit-btn"
                  title="Click to view application"
                >
                  <i class="fas fa-eye"></i>
                </button>
                <button
                  @click="toggleDeleteForm(form.id, form.form_type)"
                  v-if="form.status === 'pending' || form.status === 'declined'"
                  class="delete-btn"
                >
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <div class="empty-msg" v-if="forms && forms.length == 0">
          <span>You haven't submitted a form yet.</span>
        </div>
      </WhenVisible>
    </div>
  </div>
</template>

<style scoped>
@import "./css/tracking.css";
</style>
