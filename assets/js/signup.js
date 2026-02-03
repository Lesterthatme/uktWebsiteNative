function previewImage(event) {
  const reader = new FileReader();
  reader.onload = function () {
    const output = document.getElementById("profile-pic");
    output.src = reader.result;
  };
  reader.readAsDataURL(event.target.files[0]);
}

// Function to calculate age based on birthday
function calculateAge(birthday) {
  const today = new Date();
  const birthDate = new Date(birthday);
  let age = today.getFullYear() - birthDate.getFullYear();
  const monthDifference = today.getMonth() - birthDate.getMonth();
  // Adjust age if the birthday hasn't occurred yet this year
  if (
    monthDifference < 0 ||
    (monthDifference === 0 && today.getDate() < birthDate.getDate())
  ) {
    age--;
  }
  return age;
}

// Add an event listener to the birthday field
document.getElementById("birthday").addEventListener("change", function () {
  const birthday = this.value; // Get the selected date
  const ageField = document.getElementById("age");
  if (birthday) {
    const age = calculateAge(birthday);
    ageField.value = age > 0 ? age : ""; // Set age or clear if invalid
  } else {
    ageField.value = ""; // Clear age if no date is selected
  }
});
