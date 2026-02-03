<small><strong>Please select a page:</strong></small>
<select id="pageSelector" class="form-select mt-2" style="width: 500px;">
    <option value="archive">Highlights</option>
    <option value="archive_partnership">University Partnership</option>
    <option value="archive_calendar">University Calendar</option>
    <option value="archive_faq">FAQ</option>
    <option value="archive_announcement">Announcement</option>
    <option value="archive_album">University Gallery</option>
    <option value="archive_news">News</option>
    <option value="archive_message">Messages</option>
    <option value="archive_poster">Poster</option>
    <option value="archive_admissionrequirements">Admission Requirements</option>
    <option value="archive_scholarship">Scholarship</option>
</select>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let pageSelector = document.getElementById("pageSelector");
        let currentPage = window.location.pathname.split("/").pop(); // Get the current filename

        // Loop through options to find the matching value
        for (let option of pageSelector.options) {
            if (option.value === currentPage) {
                option.selected = true;
                break;
            }
        }

        // Redirect on selection change
        pageSelector.addEventListener("change", function () {
            let selectedPage = this.value;
            if (selectedPage && selectedPage !== "#") {
                window.location.href = selectedPage;
            }
        });
    });
</script>
