<template>
    <div class="container">
        <div class="content">
            <div class="logo">
                <img src="/public/assets/images/mdc-logo.png" alt="Logo" />
            </div>

            <div class="login-form">
                <h2>Welcome to MDC-HR System</h2>
                <form @submit.prevent="handleLogin">
                    <div class="input-group">
                        <label for="user">Username:</label>
                        <div class="usernameField">
                            <i class="fas fa-user field-icon-user"></i>
                            <input
                                id="user"
                                v-model="user.value"
                                placeholder="Enter your username"
                                required
                                type="text"
                            />
                        </div>
                        <span v-if="responseData" class="error">
                            {{ responseData.user.errorMessage }}
                        </span>
                    </div>

                    <div class="input-group">
                        <label for="password">Password:</label>
                        <div class="passwordField">
                            <i class="fas fa-key field-icon-pass"></i>
                            <input
                                id="password"
                                v-model="password.value"
                                placeholder="Enter your password"
                                required
                                :type="isPasswordVisible ? 'text' : 'password'"
                            />
                            <i
                                id="eye-icon"
                                class="fas"
                                :class="
                                    isPasswordVisible
                                        ? 'fa-eye'
                                        : 'fa-eye-slash'
                                "
                                @click="viewPassword"
                            ></i>
                        </div>
                        <span v-if="responseData" class="error">
                            {{ responseData.password.errorMessage }}
                        </span>
                    </div>

                    <button type="submit">Log In</button>
                </form>

                <p class="forgot-password">
                    <a href="#">Forgot Password?</a>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";

export default {
    data() {
        return {
            user: {
                value: "", // Check if props and user exist
                errorMessage: "",
            },
            password: {
                value: "", // Check if props and password exist
                errorMessage: "",
            },
            errorMessage: this.$page?.props?.errorMessage || "",
            loading: false,
            isPasswordVisible: false,
        };
    },
    props: {
        responseData: {
            type: Object,
        },
    },
    methods: {
        async handleLogin() {
            this.errorMessage = ""; // Reset error message before each attempt
            this.loading = true;

            if (this.user.value && this.password.value) {
                try {
                    // Make the Inertia POST request
                    await Inertia.post("/login-submit", {
                        user: this.user.value,
                        password: this.password.value,
                    });

                    // Inertia handles the response and redirect internally
                } catch (error) {
                    // Catch any errors if they occur
                    this.errorMessage =
                        "Login failed. Please check your credentials.";
                    console.error("Login error: ", error);
                }
            } else {
                this.errorMessage = "Please enter both username and password.";
            }

            this.loading = false;
        },

        viewPassword() {
            this.isPasswordVisible = !this.isPasswordVisible;
        },
    },
};
</script>

<style scoped>
.error {
    display: flex;
    font-style: italic;
    color: #ff0000;
    font-weight: lighter;
    font-size: 12px;
}
.usernameField i {
    opacity: 50%;
    padding: 10px 11px;
    cursor: pointer;
}

.usernameField i:hover {
    opacity: 100%;
}
.field-icon-user {
    background-color: #0051ff;
    color: #fff;
    padding: 10px 11px;
    border-top-left-radius: 2px;
    border-bottom-left-radius: 2px;
}

.field-icon-pass {
    background-color: #ff0000;
    color: #fff;
    border-top-left-radius: 2px;
    border-bottom-left-radius: 2px;
}
.usernameField {
    display: flex;
    border: 1px solid #ddd;
}
.passwordField {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border: 1px solid #000;
    width: 100%;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
    transition: border-color 0.3s ease;
}

.usernameField {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border: 1px solid #000;
    width: 100%;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
    transition: border-color 0.3s ease;
}

.userField i {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border: 1px solid #000;
    width: 100%;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
    transition: border-color 0.3s ease;
}

.passwordField i {
    opacity: 50%;
    padding: 10px;
    cursor: pointer;
}

.passwordField i:hover {
    opacity: 100%;
}
#user {
    background-color: transparent;
    border: none;
}
#password {
    background-color: transparent;
    border: none;
}
.container {
    display: flex;
    position: fixed;
    align-items: center;
    justify-content: center;
    inset: 0;
    background: linear-gradient(
        to bottom,
        rgba(94, 204, 216, 0.3),
        rgba(10, 124, 137)
    );
}

.content {
    background-color: #fff;
    padding: 40px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    width: 350px;
    text-align: center;
}

.logo {
    margin-bottom: 20px;
}

.logo img {
    width: 120px;
    height: auto;
    filter: drop-shadow(4px 4px 10px rgba(0, 0, 0, 0.3));
}

.login-form h2 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
}

.input-group {
    text-align: left;
    margin-bottom: 18px;
}

.input-group label {
    display: block;
    font-size: 14px;
    color: #555;
}

input {
    width: 100%;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
    transition: border-color 0.3s ease;
}

.input-group input:focus {
    border-color: #007bff;
}

button {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

.forgot-password {
    margin-top: 10px;
}

.forgot-password a {
    font-size: 14px;
    color: #007bff;
    text-decoration: none;
}

.forgot-password a:hover {
    text-decoration: underline;
}
</style>
