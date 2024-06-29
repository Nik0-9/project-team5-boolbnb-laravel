import './bootstrap';
import '~resources/scss/app.scss';
import '~icons/bootstrap-icons.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
])

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