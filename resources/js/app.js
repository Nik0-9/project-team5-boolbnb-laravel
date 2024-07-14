import './bootstrap';
import '~resources/scss/app.scss';
import '~icons/bootstrap-icons.scss';
import * as bootstrap from 'bootstrap';
import './statistics';
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
      const form = button.closest("form");
      form.submit();
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
      }, 800);
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
        const addressError = document.getElementById('addressError');
        addressError.classList.remove('d-none');
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

  
