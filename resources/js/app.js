import './bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css';
import $ from 'jquery';
import 'bootstrap-datepicker';

window.$ = $;

document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    const formattedDate = `${year}-${month}-${day}`;

    const $datepicker = $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        todayBtn: 'linked'
    }).datepicker('setDate', today);

    $('.input-group-text').on('click', function() {
        $datepicker.datepicker('show');
    });

    $('#display-date').text(`${day}-${month}-${year}`);

    loadRates(formattedDate);

    $('#datepicker').on('changeDate', function() {
        const selectedDate = $(this).val();
        const [year, month, day] = selectedDate.split('-');
        $('#display-date').text(`${day}-${month}-${year}`);
        loadRates(selectedDate);
    });
});

function loadRates(date = null) {
    document.getElementById('loading-placeholder').classList.remove('d-none');
    document.getElementById('error-message').classList.add('d-none');
    document.getElementById('rates-grid').innerHTML = '';

    let url = '/api/rates';
    if (date) {
        url += `?date=${date}`;
    }

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const grid = document.getElementById('rates-grid');
                grid.innerHTML = '';

                data.data.rates.forEach(rate => {
                    const formattedRate = new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 4
                    }).format(rate.rate);

                    const card = `
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm bg-white">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="card-title mb-0">
                                            <span class="badge bg-primary rounded-pill px-3 py-2">${rate.target_currency.code}</span>
                                        </h5>
                                        <small class="text-secondary">${rate.target_currency.name}</small>
                                    </div>
                                    <div class="text-center">
                                        <h3 class="mb-2 fw-bold">${formattedRate}</h3>
                                        <small class="text-secondary">1 USD = ${rate.target_currency.code} ${formattedRate}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    grid.innerHTML += card;
                });

                document.getElementById('loading-placeholder').classList.add('d-none');
            }
        })
        .catch(error => {
            console.error('Error loading rates:', error);
            document.getElementById('loading-placeholder').classList.add('d-none');
            document.getElementById('error-message').classList.remove('d-none');
        });
}
