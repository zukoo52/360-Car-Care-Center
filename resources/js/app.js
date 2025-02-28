/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue").default;
window.Fire = new Vue();

// Permission Mixins
import Permissions from "./mixins/Permissions";
Vue.mixin(Permissions);

// V-Form
import Form from "vform";
window.Form = Form;

//Moment JS
import moment from "moment";
Vue.filter("myDate", function (date) {
    return moment(date).format("MMM Do YYYY");
});

// Filters

Vue.filter("currency", function (amount) {
    let val = "Rs. " + (amount / 1).toFixed(2);
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
});

Vue.filter("billDate", function (date) {
    return moment(date).format("DD-MM-YYYY H:mm");
});

Vue.filter("capitalize", function (string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
});

Vue.filter("uppercase", function (string) {
    return string.toUpperCase();
});

Vue.filter("justNumbers", function (string) {
    return string.replace(/\D+/g, "");
});

Vue.filter("nameStandard", function (words) {
    var separateWord = words.toLowerCase().split(" ");
    for (var i = 0; i < separateWord.length; i++) {
        separateWord[i] =
            separateWord[i].charAt(0).toUpperCase() +
            separateWord[i].substring(1);
    }
    return separateWord.join(" ");
});

Vue.filter("searchHighlight", function (value, search) {
    if (search) {
        let searchRegExpr = new RegExp(search, "ig");

        return value.replace(searchRegExpr, (match) => {
            return `<span class="search-matched-color">${match}</span>`;
        });
    }

    return value;
});

Vue.filter("first50Chars", function (value) {
    return value.substring(0, 70);
});

//SweetAlert
import Swal from "sweetalert2";
window.swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});

window.Toast = Toast;

// FileDialog 64
import FileDialog from "vue-file64";
import Vue from "vue";
Vue.component("file-dialog-64", FileDialog);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Data Table COmponent
Vue.component(
    "data-table",
    require("./components/modules/DataTable.vue").default
);

//Permission Components
Vue.component(
    "permission-component",
    require("./components/main/permission/PermissionComponent.vue").default
);
Vue.component(
    "role-based-permission",
    require("./components/main/permission/RolePermissionComponent.vue").default
);

//Branch Components
Vue.component(
    "create-new-branch",
    require("./components/main/branch/CreateNewBranchComponent.vue").default
);
Vue.component(
    "view-branch-component",
    require("./components/main/branch/ViewBranchComponent.vue").default
);
Vue.component(
    "update-branch-component",
    require("./components/main/branch/UpdateBranchComponent.vue").default
);

//Product Components
Vue.component(
    "create-new-product",
    require("./components/main/product/CreateNewProductComponent.vue").default
);
Vue.component(
    "view-product-component",
    require("./components/main/product/ViewProductComponent.vue").default
);
Vue.component(
    "update-product-component",
    require("./components/main/product/UpdateProductComponent.vue").default
);

// User Components

Vue.component(
    "new-user-component",
    require("./components/main/user/NewUserComponent.vue").default
);
Vue.component(
    "profile-view-component",
    require("./components/main/user/ProfileComponent.vue").default
);

Vue.component(
    "user-index-component",
    require("./components/main/user/UserIndexComponent.vue").default
);

// Dashboard Component
Vue.component(
    "dashboard-component",
    require("./components/main/dashboard/DashboardComponent.vue").default
);

// Notification Components
Vue.component(
    "system-notification-component",
    require("./components/main/notifications/SystemNotifications.vue").default
);

Vue.component(
    "user-notification-component",
    require("./components/main/notifications/UserNotifications.vue").default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
});
