import './bootstrap';
import '~resources/scss/app.scss';
import '~icons/bootstrap-icons.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
])
import { Chart } from 'chart.js/auto';

// funzione di autocompletamento
document.addEventListener('DOMContentLoaded', function() {
  let addressInput = document.getElementById('address');
  let resultsSelect = document.getElementById('resultsSelect');

  addressInput.addEventListener('input', function() {
      let query = addressInput.value;
      let apiKey = '88KjpqU7nmmEz3D6UYOg0ycCp6VqtdXI';
      let counrtySet = 'countrySet=ITA';

      if (query.length < 5) {
          resultsSelect.innerHTML = '';
          return;
      }
      fetch(`https://api.tomtom.com/search/2/search/${query}.json?${counrtySet}&key=${apiKey}`)
          .then(response => response.json())
          .then(data => {
              resultsSelect.innerHTML = '';
              data.results.forEach(result => {
                  let option = document.createElement('option');
                  option.value = result.address.freeformAddress;
                  option.textContent = result.address.freeformAddress;
                  resultsSelect.appendChild(option);
              });
          })
          .catch(error => console.error('Error fetching the address:', error));
  });

  resultsSelect.addEventListener('click', function() {
      addressInput.value = resultsSelect.value;
  });
});


// funzione per eliminare
const deleteSubmitButtons = document.querySelectorAll(".delete-button");

deleteSubmitButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
        event.preventDefault();

        const dataTitle = button.getAttribute("data-item-title");

        const modal = document.getElementById("deleteModal");

        const bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();

        const modalItemTitle = modal.querySelector("#modal-item-title");
        modalItemTitle.textContent = dataTitle;

        const buttonDelete = modal.querySelector("button.btn-danger");

        buttonDelete.addEventListener("click", () => {
            button.parentElement.submit();
        });
    });
});

// funzione per chiudere la sidebar
const side = document.getElementById('sidebar');
const but = document.getElementById('closeSidebar');
const icon = but.querySelector('.fa-solid'); // Get the icon element within the button

but.addEventListener('click', () => {
  side.classList.toggle('d-none');

  icon.classList.toggle('fa-chevron-left'); // Toggle between left and right icons
  icon.classList.toggle('fa-chevron-right'); // Toggle between left and right icons
});

//funzione validazione conferma password
document.addEventListener('DOMContentLoaded', function () {
  const form_register = document.getElementById('register-form');
  const password = document.getElementById('password');
  const passwordConfirm = document.getElementById('password-confirm');
  const passwordMatchError = document.getElementById('password-match-error');
  const dateOfBirth = document.getElementById('date_of_birth');

  const today = new Date();
    const maxDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
    dateOfBirth.max = maxDate.toISOString().split('T')[0];
    
    form_register.addEventListener('submit', function (event) {
      if (password.value !== passwordConfirm.value) {
        event.preventDefault();
        passwordMatchError.style.display = 'block';
      } else {
        passwordMatchError.style.display = 'none';
      }
    });
    
    passwordConfirm.addEventListener('input', function () {
      if (password.value !== passwordConfirm.value) {
        passwordConfirm.classList.add('is-invalid');
        passwordMatchError.style.display = 'block';
      } else {
        passwordConfirm.classList.remove('is-invalid');
        passwordMatchError.style.display = 'none';
      }
    });
  });
  

// Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
      label: "Guadagni",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgb(255, 0, 0)",
      pointRadius: 3,
      pointBackgroundColor: "rgb(255, 0, 0)",
      pointBorderColor: "rgb(255, 0, 0)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgb(255, 0, 0)",
      pointHoverBorderColor: "rgb(255, 0, 0)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [0,],
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 30,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10

    }
  }
});

// Pie Chart 
var ctx1 = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx1, {
  type: 'doughnut',
  data: {
    labels: ["Direct", "Referral", "Social"],
    datasets: [{
      data: [],
      backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});
