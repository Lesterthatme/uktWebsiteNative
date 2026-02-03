// Initialize Coloris
Coloris({
  el: '#colorInput',
  theme: 'default',
  themeMode: 'light',
  format: 'hex',
  clearButton: true,
  defaultColor: '#d00d78',
  swatches: [
    '#264653', '#2a9d8f', '#e9c46a', '#f4a261', '#e76f51',
    '#1d3557', '#457b9d', '#a8dadc', '#ff6b6b'
  ],
  inline: false, // Show picker in a popup
});

// Function to trigger Coloris picker
function openColorPicker() {
  document.getElementById('colorInput').click();
}

// Update color indicator when color is changed
document.getElementById('colorInput').addEventListener('input', function() {
  document.getElementById('colorIndicator').style.backgroundColor = this.value;
});