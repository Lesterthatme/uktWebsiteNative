function validatePassword() {
  const newPassword = document.getElementById("new_password").value;
  const confirmPassword = document.getElementById("confirm_password").value;
  const errorMsg = document.getElementById("errorMsg");

  // Regex explanation:
  // (?=.*[A-Za-z]) → at least one letter
  // (?=.*\d) → at least one number
  // (?=.*[@$!%*?&]) → at least one special character
  // [A-Za-z\d@$!%*?&]{8,} → minimum 8 characters
  const passwordPattern =
    /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

  if (!passwordPattern.test(newPassword)) {
    errorMsg.innerHTML = `<li> Password must be at least 8 characters long and include letters, numbers, and a special character.</li>`;
    return false;
  }

  if (newPassword !== confirmPassword) {
    errorMsg.innerHTML = `<li> Passwords do not match.</li>`;
    return false;
  }
  errorMsg.innerHTML = ``;
  return true;
}

document.getElementById("confirm_password").addEventListener("input", () => {
  validatePassword();
});
