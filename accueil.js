// /* button de navigation (afficher contenu) */
// const lienAcuueil = document.getElementById('accueilLien');
// const lienMenu = document.getElementById('menuLien');
// const lienbtn_Panier = document.getElementById('btn_Panier');
// const lienReservation = document.getElementById('btn-form-reservation');
// const personnelLien = document.getElementById('personnelLien');
// const accueil_main = document.getElementById('accueil_main');
// const menu_main = document.getElementById('menu_main');
// const VIewDEcor = document.getElementById('VIewDEcor');
// const qteArticle = document.getElementById('qteArticle');
// const personnel = document.getElementById('personnel');
// const shoppingLogout = document.getElementById('shoppingLogout');
// const shopping = document.getElementById('shopping');
// const Reservation = document.getElementById('reservation');
// const contact_main = document.getElementById('contact_main');
// /*footer*/
// const menurapide= document.getElementById('menu-rapide');
// // const reservationrapide= document.getElementById('reservation-rapide');


// // lienAcuueil.addEventListener('click', (event) => {
// //     accueil_main.style.display = "block";
// //     menu_main.style.display = "none";
// // });
// // lienMenu.addEventListener('click', (event) => {

// //     accueil_main.style.display = "none";
// //     menu_main.style.display = "block";
// //     VIewDEcor.style.display = "none";
// //     Reservation.style.display = "none";
// //     personnel.style.display = "none";
// //     contact_main.style.display = "none";
// // });
// // menurapide.addEventListener('click', (event) => {

// //     accueil_main.style.display = "none";
// //     menu_main.style.display = "block";
// //     VIewDEcor.style.display = "none";
// //     Reservation.style.display = "none";
// //     personnel.style.display = "none";
// //     contact_main.style.display = "none";
// // });

// // lienReservation.addEventListener('click', (event) => {

// //     accueil_main.style.display = "none";
// //     menu_main.style.display = "none";
// //     VIewDEcor.style.display = "none";
// //     Reservation.style.display = "block";
// //     personnel.style.display = "none";
// //     contact_main.style.display = "none";
// // });
// // reservationrapide.addEventListener('click', (event) => {

// //     accueil_main.style.display = "none";
// //     menu_main.style.display = "none";
// //     VIewDEcor.style.display = "none";
// //     Reservation.style.display = "block";
// //     personnel.style.display = "none";
// //     contact_main.style.display = "none";
// // });
// // personnelLien.addEventListener('click', function(){
// //        menu_main.style.display = "none";
// // });
// // shoppingLogout.addEventListener('click', (event) => {
// //     accueil_main.style.display = "none";
// //     menu_main.style.display = "block";
// //     VIewDEcor.style.display = "none";
// //     qteArticle.style.display = "none";
// //     personnel.style.display = "none";
// //     contact_main.style.display = "none";
// // });
// // shopping.addEventListener('click', (event) => {
// //     accueil_main.style.display = "none";
// //     menu_main.style.display = "block";
// //     VIewDEcor.style.display = "none";
// //     qteArticle.style.display = "none";
// //     personnel.style.display = "none";
// //     contact_main.style.display = "none";
// // });
// // document.addEventListener('click', function (event) {
// //     if (event.target.classList.contains('btn_Panier')) {
// //         const divParent = event.target.closest('.receptacle_produitAdministrateur');
// //         alert("Bouton clique avec la div : " + divParent.innerText);
// //         accueil_main.style.display = "none";
// //         menu_main.style.display = "none";
// //         qteArticle.style.display = "block";
// //         personnel.style.display = "none";
// //         contact_main.style.display = "none";
// //     }
// // });
// // lienbtn_Panier.addEventListener('click', (event) => {
// //     event.preventDefault();
// //     accueil_main.style.display = "none";
// //     menu_main.style.display = "none";
// //     qteArticle.style.display = "block";
// // });

// /* defillement produit */
// document.addEventListener('DOMContentLoaded', () => {
//     // Gestion du slider d'accueil
//     const slides = [document.getElementById('def1'), document.getElementById('def2'), document.getElementById('def3')];
//     let currentSlide = 0;

//     function showSlide(index) {
//         slides.forEach((slide, i) => {
//             slide.style.display = i === index ? 'flex' : 'none';
//         });
//     }

//     document.getElementById('btn_defile_avant').addEventListener('click', () => {
//         currentSlide = (currentSlide + 1) % slides.length;
//         showSlide(currentSlide);
//     });

//     document.getElementById('btn_defile_arriere').addEventListener('click', () => {
//         currentSlide = (currentSlide - 1 + slides.length) % slides.length;
//         showSlide(currentSlide);
//     });
// });
// /* Afficher produit par categorie */  


// /* voir mot de passe */

// const togglePassword = document.getElementById('togglepassword');
// const pass = document.getElementById('pasword');

// pass.addEventListener('input', function() {  
//     togglePassword.style.display='block';
// });

// togglePassword.addEventListener('click', function() {

// const type = pass.type === 'password' ? 'text' : 'password';
// pass.type = type;
// this.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
// });

// document.addEventListener('click', function() {
//         togglePassword.style.display='none';
// });