
// /*Resevartion Session*/
// function hour() {
//     document.getElementById('id="timeChoix"').addEventListener('change', function () {
//         const valeur = this.value;
//         const min = "09:00";
//         const max = "17:00";
//         if (valeur < min || valeur > max) {
//             alert('d');
//             // document.getElementById('errorTime').style.display="block";
//             this.value = "";
//         }
//     });
// }

// const Sendreservation = document.getElementById('btn-reservation');
// Sendreservation.addEventListener('click', (event) => {
//     event.preventDefault();
//     //hour();
//     validateForm();
// })
// /* session error */

// var nomerror = document.getElementById("nom_error");
// var numbererror = document.getElementById("number_error");
// var dateerror = document.getElementById("date_error");
// var emailerror = document.getElementById("email_error");
// var errorTime = document.getElementById("errorTime");
// var beneferror = document.getElementById("benef_error");

// function validateNom() {
//     let nom = document.getElementById("nomReservation");

//     if (!nom.value) {
//         nomerror.style.display = "block";
//         nom.style.border = "1px solid red";
//         return false;
//     } else if (!nom.value.match(/^[a-zA-Z ]+$/)) {
//         nomerror.style.display = "block";
//         nomerror.innerHTML = "The name should is requiered";
//         nom.style.border = "1px solid red";
//         nom.style.outline = "none";
//         return false;
//     } else {
//         nomerror.style.display = "none";
//         nom.style.border = "1px solid var(--grey-light)";
//         nom.style.backgroundColor = "gray";
//         return true;
//     }
// }

// function validateNumber() {
//     let number = document.getElementById("numberReservation");

//     if (!prenom.value) {
//         numbererror.style.display = "block";
//         number.style.border = "1px solid red";
//         return false;
//     } else if (!nom.value.match(/^[a-zA-Z ]+$/)) {
//         numbererror.style.display = "block";
//         numbererror.innerHTML = "The name should is requiered";
//         number.style.border = "1px solid red";
//         number.style.outline = "none";
//         return false;
//     } else {
//         numbererror.style.display = "none";
//         number.style.border = "1px solid var(--grey-light)";
//         number.style.backgroundColor = "gray";
//         return true;
//     }
// }

// function validateDate() {
//     let date = document.getElementById("dateReservation");

//     if (!date.value) {
//         dateerror.style.display = "block";
//         date.style.border = "1px solid red";
//         return false;
//     } else if (!age.value.match(/^[0-9]+$/)) {
//         dateerror.style.display = "block";
//         dateerror.style.innerHTML = "only number is required";
//         date.style.border = "1px solid red";
//         date.style.outline = "none";
//         return false;
//     } else {
//         dateerror.style.display = "none";
//         date.style.border = "1px solid var(--grey-light)";
//         date.style.backgroundColor = "gray";
//         return true;
//     }

// }

// function validateEmail() {
//     let email = document.getElementById("emailReservation");

//     if (!email.value) {
//         emailerror.style.display = "block";
//         email.style.border = "1px solid red";
//         return false;
//     } else if (!email.value.match(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]+$/)) {
//         emailerror.style.display = "block";
//         emailerror.innerHTML = "The name or number+NAME AND @gmail.com should is requiered";
//         email.style.border = "1px solid red";
//         email.style.outline = "none";
//         return false;
//     } else {
//         emailerror.style.display = "none";
//         email.style.border = "1px solid var(--grey-light)";
//         email.style.backgroundColor = "gray";
//         return true;
//     }
// }

// function validateTime() {
//     let time= document.getElementById("timeReservation");

//     if (!time.value) {
//         errorTime.style.display = "block";
//         time.style.border = "1px solid red";
//         return false;
//     } else if (!time.value.match(/^[0-9]+$/)) {
//    errorTime.style.display = "block";
//   errorTime.innerHTML = "Choose our section";
//         time.style.border = "1px solid red";
//        time.style.outline = "none";
//         return false;
//     } else {
//        errorTime.style.display = "none";
//       time.style.border = "1px solid var(--grey-light)";
//         return true;
//     }
// }

// function validateBeneficiere() {
//     let beneficiere = document.getElementById("beneficiereReservation");

//     if (!beneficiere.value) {
//         beneferror.style.display = "block";
//         beneficiere.style.border = "1px solid red";
//         return false;
//     } else if (!beneficiere.value.match(/^[a-zA-Z ]+$/)) {
//         beneferror.style.display = "block";
//         beneferror.innerHTML = "The notes is required";
//         beneficiere.style.border = "1px solid red";
//         beneficiere.style.outline = "none";
//         return false;
//     } else {
//         beneferror.style.display = "none";
//         beneficiere.style.border = "1px solid var(--grey-light)";
//         beneficiere.style.backgroundColor = "gray";
//         return true;
//     }
// }


// var form = document.querySelector("form");
// function validateForm() {
//     if (!validateNom() || !validateNumber() || !validateDate() || !validateEmail() || !validateTime() || !validateBeneficiere()) {
        
//     } else {
//        console.log("form not submitted");

//     }
// }



