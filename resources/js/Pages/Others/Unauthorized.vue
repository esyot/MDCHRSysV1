<template>
  <div class="unauthorized-container">
    <div class="unauthorized-content">
      <div class="logo-container">
        <img src="/public/assets/images/mdc-logo.png" alt="Logo" class="logo" />
      </div>
      <h1 class="unauthorized-title">Unauthorized Access</h1>
      <p class="unauthorized-message">You do not have permission to access this page.</p>
      <div class="return-home">
        <a href="/dashboard" class="return-link">Return to Home</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Unauthorized",
};
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body,
html {
  height: 100%;
  font-family: Arial, sans-serif;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #f7fafc;
}

.unauthorized-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}

.unauthorized-content {
  text-align: center;
  background-color: #ffffff;
  padding: 32px;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  max-width: 400px;
  width: 100%;
}

.logo-container {
  display: flex;
  justify-content: center;
  margin-bottom: 20px;
}

.logo {
  width: 75px;
  height: 75px;
  border-radius: 50%;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.unauthorized-title {
  font-size: 24px;
  font-weight: bold;
  color: #e53e3e;
  margin-bottom: 16px;
}

.unauthorized-message {
  font-size: 18px;
  color: #4a5568;
}

.return-home {
  margin-top: 24px;
}

.return-link {
  color: #3182ce;
  text-decoration: none;
  cursor: pointer;
}

.return-link:hover {
  text-decoration: underline;
}
</style>
