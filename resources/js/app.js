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
      data: [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
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
      data: [55, 30, 15],
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

//funzione get lat,lon
// const baseUrlTt = "https://api.tomtom.com/search/2/geocode/";
// const TtKey = '88KjpqU7nmmEz3D6UYOg0ycCp6VqtdXI';
// const TtJson = 'storeResult=false&view=Unified&key=';
// const btnSave = document.getElementById("save");

// btnSave.addEventListener("click", () => {
    
//     const address = document.getElementById("address").value;
//     const encodedAddress = address.split(' ').join('%20');
    
//     axios.get(`${baseUrlTt}${encodedAddress}${TtJson}${TtKey}`).then((res)=>{
//         const lat = res.data.results[0].position.lat;
//         const lon = res.data.results[0].position.lon;
//         console.log(lat,lon);  
//     })
// })


//https://api.tomtom.com/search/2/geocode/Via%20Stefano%20Barbato%204%2080147%20Napoli%20NA.json?storeResult=false&view=Unified&key=*****
//nostra chiamata
//https://api.tomtom.com/search/2/geocode/Via%20Stefano%20Barbato%204%2080147%20Napoli%20NA.json?countrySet=IT&key=88KjpqU7nmmEz3D6UYOg0ycCp6VqtdXI