<template>
    <div class="security-content">
        <section class="security-items">
            <div class="title-container">
                <span class="title">Account Features</span>
            </div>

            <div class="form">
                <div class="form-items">
                    <div>
                        <input type="checkbox" id="username" />
                        <span>Receive Updates Through Email</span>
                    </div>
                    <small>
                        <i class="fas fa-circle-exclamation"></i>
                        Note: Receive updates from the system through given
                        email.</small
                    >
                </div>
                <div class="form-items">
                    <div>
                        <input type="checkbox" id="username" />
                        <span>Two Authentication Mode</span>
                    </div>

                    <small>
                        <i class="fas fa-circle-exclamation"></i>
                        Note: Receive and input a code first when logging
                        in.</small
                    >
                </div>
            </div>
        </section>

        <section class="security-items">
            <div class="title-container">
                <span class="title">Account Settings</span>
            </div>
            <section>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" />
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" />
                </div>

                <div class="form-group">
                    <label for="old-password">Input Old Password:</label>
                    <input type="password" id="old-password" />
                </div>

                <div class="form-group">
                    <label for="new-password">Input New Password:</label>
                    <input type="password" id="new-password" />
                </div>

                <div class="form-group">
                    <label for="retype-password">Re-type Password:</label>
                    <input type="password" id="retype-password" />
                </div>
            </section>
            <div class="form-group-foooter">
                <button>Save Changes</button>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: "Security",
};
</script>

<style scoped>
.security-content {
    display: flex;
    flex-wrap: wrap;
    height: 78vh;
    overflow-y: auto;
    margin-top: 5px;
    gap: 0.5rem;
}

.security-items {
    flex-grow: 1;
    flex-basis: 400px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
.form-group-foooter {
    display: flex;
    padding: 10px;
}

.form-group-foooter button {
    background-color: rgb(56, 129, 254);
    border: none;
    padding: 10px;
    color: #fff;
    border-radius: 5px;
}

.form {
    padding: 10px;
    gap: 0.5rem;
}

.form-items {
    padding: 10px;
}

.form-items i {
    color: rgb(245, 15, 15);
}
</style>
