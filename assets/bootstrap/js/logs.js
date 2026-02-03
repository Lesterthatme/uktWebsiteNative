document.addEventListener("DOMContentLoaded", function () {
  let rowsPerPage = parseInt(document.getElementById("entriesSelect").value);
  let tableBody = document.querySelector("#activityTable tbody");
  let rows = Array.from(tableBody.rows);
  let currentPage = 1;

  function displayRows() {
    let start = (currentPage - 1) * rowsPerPage;
    let end = start + rowsPerPage;
    rows.forEach((row, index) => {
      row.style.display = index >= start && index < end ? "" : "none";
    });
    updatePagination();
  }

  function updatePagination() {
    let totalPages = Math.ceil(rows.length / rowsPerPage);
    let pagination = document.querySelector(".pagination");
    pagination.innerHTML = `
        <li class="page-item ${currentPage === 1 ? "disabled" : ""}">
            <a class="page-link" href="#" id="prevPage">Previous</a>
        </li>
    `;

    let startPage = Math.max(1, currentPage - 1);
    let endPage = Math.min(totalPages, startPage + 2);

    if (endPage - startPage < 2) {
      startPage = Math.max(1, endPage - 2);
    }

    for (let i = startPage; i <= endPage; i++) {
      pagination.innerHTML += `
          <li class="page-item ${i === currentPage ? "active" : ""}">
              <a class="page-link" href="#">${i}</a>
          </li>
      `;
    }

    pagination.innerHTML += `
        <li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
            <a class="page-link" href="#" id="nextPage">Next</a>
        </li>
    `;
  }

  document.addEventListener("click", function (e) {
    if (e.target.classList.contains("page-link")) {
      e.preventDefault();
      if (e.target.id === "prevPage" && currentPage > 1) {
        currentPage--;
      } else if (e.target.id === "nextPage" && currentPage < Math.ceil(rows.length / rowsPerPage)) {
        currentPage++;
      } else {
        let page = parseInt(e.target.textContent);
        if (!isNaN(page)) currentPage = page;
      }
      displayRows();
    }
  });

  document.getElementById("entriesSelect").addEventListener("change", function () {
    rowsPerPage = parseInt(this.value);
    currentPage = 1;
    displayRows();
  });

  displayRows();
});

// Search functionality
document.getElementById("searchBar").addEventListener("keyup", function () {
  let searchValue = this.value.toLowerCase();
  let rows = document.querySelectorAll("#activityTable tbody tr");
  rows.forEach((row) => {
    let text = row.textContent.toLowerCase();
    row.style.display = text.includes(searchValue) ? "" : "none";
  });
});

// Sorting functionality
document.getElementById("sortBy").addEventListener("change", function () {
  let sortBy = this.value;
  let tbody = document.querySelector("#activityTable tbody");
  let rows = Array.from(tbody.rows);

  rows.sort((a, b) => {
    let aValue = a.cells[sortBy === "date" ? 1 : 2].textContent.trim();
    let bValue = b.cells[sortBy === "date" ? 1 : 2].textContent.trim();

    if (sortBy === "date") {
      return new Date(aValue) - new Date(bValue);
    } else {
      return aValue.localeCompare(bValue);
    }
  });

  rows.forEach((row) => tbody.appendChild(row));
});