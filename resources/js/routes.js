import VueRouter from "vue-router";

// import DashBoard from "./components/DashBoard";
// import AddUser from "./components/AddUser";

import DashBoard from "./components/DashBoard";
import AddUser from "./components/AddUser";
import ViewUser from "./components/ViewUser";
import AddCategory from "./components/AddCategory";
import ViewCategory from "./components/ViewCategory";
import UpdateUser from "./components/UpdateUser";
import AddAdmin from "./components/AddAdmin";
import ViewAdmin from "./components/ViewAdmin";
import ChangePassword from "./components/ChangePassword";
import ImportExcel from "./components/ImportExcel";

import AddGoogleUsers from "./components/AddGoogleUsers";
import UpdateGoogleUser from "./components/UpdateGoogleUser";
import ViewGoogleUsers from "./components/ViewGoogleUsers";
import ImportGoogleExcel from "./components/ImportGoogleExcel";
import updateCategory from "./components/updateCategory";

import Index from "./site/Index";
import ViewUserSite from "./site/ViewUserSite";
import ViewGoogleUserSite from "./site/ViewGoogleUserSite";

let routes = [
    {
        path: "/",
        name: "Index",
        component: Index,
    },
    {
        path: "/view-user/:profile_id",
        name: "view-user",
        component: ViewUserSite,
    },
    {
        path: "/view-google-user/:profile_id",
        name: "view-google-user",
        component: ViewGoogleUserSite,
    },
    {
        path: "/dashboard",
        name: "dashboard",
        component: DashBoard,
    },
    {
        path: "/addcategory",
        name: "addcategory",
        component: AddCategory,
    },
    {
        path: "/addadmin",
        name: "addadmin",
        component: AddAdmin,
    },
    {
        path: "/addgoogleuser",
        name: "addgoogleuser",
        component: AddGoogleUsers,
    },
    {
        path: "/adduser",
        name: "adduser",
        component: AddUser,
    },
    {
        path: "/viewUser",
        name: "viewUser",
        component: ViewUser,
    },
    {
        path: "/viewcategory",
        name: "viewcategory",
        component: ViewCategory,
    },
    {
        path: "/viewadmin",
        name: "viewadmin",
        component: ViewAdmin,
    },
    {
        path: "/viewgoogleusers",
        name: "viewgoogleusers",
        component: ViewGoogleUsers,
    },
    {
        path: "/updateuser/:profile_id",
        name: "updateuser",
        component: UpdateUser,
    },
    {
        path: "/updategoogleuser/:profile_id",
        name: "updategoogleuser",
        component: UpdateGoogleUser,
    },
    {
        path: "/updateCategory/:id",
        name: "updateCategory",
        component: updateCategory,
    },
    {
        path: "/changePassword",
        name: "changePassword",
        component: ChangePassword,
    },
    {
        path: "/import-excel",
        name: "import-excel",
        component: ImportExcel,
    },
    {
        path: "/import-google-excel",
        name: "import-google-excel",
        component: ImportGoogleExcel,
    },
];

const router = new VueRouter({
    mode: "history",
    routes, // short for `routes: routes`
    history: true,
});

export default router;
