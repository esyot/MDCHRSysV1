<template>
    <div class="security-content">
        <section class="security-items">
            <div class="title-container">
                <span class="title">Security and Notification Preferences</span>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="two-auth" />
                <label for="two-auth">Require Two-authentication</label>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="email-updates" />
                <label for="email-updates">Get Updates via your email</label>
            </div>
        </section>

        <section class="security-items">
            <div class="title-container">
                <span class="title">Account Settings</span>
            </div>
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

            <div class="form-group">
                <button type="submit" class="submit-btn">Submit</button>
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
.title-container {
    border-bottom: #dedede 1px solid;
    box-shadow: 0 4px 5px rgba(0, 0, 0, 0.1);
    padding: 10px;
}

.title {
    font-size: 18px;
    padding: 10px;
    font-weight: bold;
}
.security-content {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    height: 80vh;
    overflow-y: auto;
    margin-top: 5px;
}

.security-items {
    flex-grow: 1;
    flex-basis: 400px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.checkbox-group {
    display: flex;
    align-items: center;
    padding: 10px;
}

.checkbox-group input {
    margin-right: 10px;
}

.form-group {
    margin-bottom: 15px;
    padding: 10px;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    font-size: 14px;
}

.form-group input {
    width: 95%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

.submit-btn {
    background-color: #05affe;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    width: 100%;
}

.submit-btn:hover {
    background-color: #35a9fc;
}
</style>
