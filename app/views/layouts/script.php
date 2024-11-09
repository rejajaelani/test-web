</div>
</div>
</div>
</section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
    function formatDate(dateStr) {
        var date = new Date(dateStr);

        var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var dayName = days[date.getDay()];

        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var monthName = months[date.getMonth()];

        var day = date.getDate();
        var year = date.getFullYear();

        return dayName + ", " + day + " " + monthName + " " + year;
    }

    function formatDateTime(dateString) {
        const datePart = dateString.split(' ')[0];
        const timePart = dateString.split(' ')[1];

        const date = new Date(datePart + "T" + timePart);

        const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        const dayName = days[date.getDay()];

        const months = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        const monthName = months[date.getMonth()];

        const formattedDate = `${dayName}, ${date.getDate()} - ${monthName} - ${date.getFullYear()} (${date.getHours()}:${date.getMinutes().toString().padStart(2, '0')})`;
        return formattedDate;
    }
</script>