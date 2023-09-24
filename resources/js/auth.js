export function checkLoginStatus() {
    return window.Laravel.isLoggedin;
  }

//Account disabled
export function checkDisabledAccount() {
    return (window.Laravel.isLoggedin && window.Laravel.user.disabled==true)
    }

//Admin auth
export function checkLoginAdmin() {
    return (window.Laravel.isLoggedin && window.Laravel.user.role==1)
    }

//Expediteur auth
export function checkLoginExpediteur() {
    return (window.Laravel.isLoggedin && window.Laravel.user.role==2)
    }
