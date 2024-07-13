import './bootstrap';
import '~resources/scss/app.scss';
import '~icons/bootstrap-icons.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
  '../img/**'
])
import { Chart } from 'chart.js/auto';

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

// funzione per l'autocompletamento
document.addEventListener('DOMContentLoaded', function () {
  const addressInput = document.getElementById('address');
  const addressSuggestions = document.getElementById('addressSuggestions');
  const form = document.getElementById('modForm');
  let debounceTimeout;
  const apiBaseUrl = 'https://api.tomtom.com/search/2/search/';
  const apiKey = '88KjpqU7nmmEz3D6UYOg0ycCp6VqtdXI';

  const fetchAddressResults = async (query) => {
    try {
      const response = await fetch(`${apiBaseUrl}${query}.json?countrySet=IT&key=${apiKey}`);
      if (!response.ok) throw new Error('Network response was not ok');
      const data = await response.json();
      return data.results;
    } catch (error) {
      console.error('Errore di ricerca indirizzo:', error);
      return [];
    }
  };

  const updateResults = (results) => {
    console.log(results);
    addressSuggestions.innerHTML = '';
    if (results.length) {
      results.forEach(({ address: { freeformAddress } }) => {
        const option = document.createElement('option');
        option.value = freeformAddress;
        addressSuggestions.appendChild(option);
      });
    }
  };

  if (addressInput) {
    addressInput.addEventListener('input', function () {
      const query = addressInput.value;

      if (query.length < 3) {
        addressSuggestions.innerHTML = '';
        return;
      }
      clearTimeout(debounceTimeout);
      debounceTimeout = setTimeout(async () => {
        const results = await fetchAddressResults(query);
        updateResults(results);
      }, 1000);
    });

    form.addEventListener('submit', function (event) {
      const inputValue = addressInput.value;
      const options = addressSuggestions.children;
      let isValid = false;

      for (let i = 0; i < options.length; i++) {
        if (options[i].value === inputValue) {
          isValid = true;
          break;
        }
      }

      if (!isValid) {
        event.preventDefault();
        alert('Per favore seleziona un indirizzo valido dalla lista dei suggerimenti.');
        addressInput.focus();
      }
    });
  }
});

    // Verifica se l'utente ha selezionato almeno un servizio
    const form = document.getElementById('modForm');
    const checkboxes = document.querySelectorAll('.form-check-input');
    const errorDiv = document.getElementById('serviceError');

    if(form){
      form.addEventListener('submit', function (event) {
        let isChecked = false;
        checkboxes.forEach(function (checkbox) {
          if (checkbox.checked) {
            isChecked = true;
          }
        });
  
        if (!isChecked) {
          event.preventDefault();
          errorDiv.classList.remove('d-none');
        } else {
          errorDiv.classList.add('d-none');
        }
      });
    }
    
  




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
    if(dateOfBirth){
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
    }
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

