<template>
  <main class="main">
    <h1>Privacy Policy</h1>
    <p><strong>Last Updated:</strong> 03/06/2026</p>
    <br>

    <h2>1. Information We Collect</h2>
    <p>We may collect the following information when you use our app:</p>
    <ul>
      <li>Name, email address, and profile information from Facebook.</li>
      <li>Usage data such as the features you use and your interactions within the app.</li>
    </ul>
    <br>

    <h2>2. How We Use Your Information</h2>
    <p>We use the information to:</p>
    <ul>
      <li>Provide and maintain the app’s functionality.</li>
      <li>Personalize your experience and improve the app.</li>
      <li>Respond to your inquiries or requests.</li>
    </ul>
    <br>

    <h2>3. Data Sharing</h2>
    <p>We do not sell your data. We may share information with:</p>
    <ul>
      <li>Service providers who help us operate the app.</li>
      <li>Legal authorities when required by law.</li>
    </ul>
    <br>

    <h2>4. Data Retention</h2>
    <p>We retain your data only as long as necessary to provide the app’s services or comply with legal obligations.</p>
    <br>

    <h2>5. User Rights</h2>
    <p>You can request access, correction, or deletion of your personal data at any time by contacting us at: [Insert Support Email]</p>
    <br>

    <h2>6. Cookies and Tracking</h2>
    <p>We use cookies and similar technologies to enhance your experience and analyze app usage.</p>
    <br>

    <h2>7. Changes to This Policy</h2>
    <p>We may update this Privacy Policy from time to time. We will notify users by posting the new policy on this page.</p>
    <br>
  </main>
</template>

<script>
export default {
  name: 'main',
  props: ['data']
}
</script>

<style scoped lang="scss">
@import '../../../sass/imports';

.main {
  width: 100%;
  padding: $base-gap $base-comp-gap-x;
}
</style>