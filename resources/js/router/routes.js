import Home from "../views/Home.vue";
import Photo from "../views/Photo.vue";
import E404 from "../components/E404.vue";
import ProfileMain from "../views/profile/Main.vue";
import ProfileEdit from "../views/profile/Edit.vue";
import ProfilePassword from "../views/profile/Password.vue";
import ProfileAvatar from "../views/profile/Avatar.vue";
import EditMainInfo from "../views/admin/EditMainInfo.vue";
import AllProfiles from "../views/admin/AllProfiles.vue";
import Document from "../views/Document.vue";
import FeedBack from "../views/Feedback.vue";
import ComponentDev from "../components/support/ComponentDev.vue";
import AllFeedback from "../views/admin/AllFeedback.vue";
import AllUsers from "../views/admin/AllUsers.vue";
import AllCategories from "../views/admin/Category/Index.vue";

export default function () {
    const routes = [
        {
            path: "/",
            name: "home",
            component: Home,
        },
        {
            path: "/photos",
            name: "photos",
            component: Photo,
        },
        {
            path: "/documents",
            name: "documents",
            component: Document,
        },
        {
            path: "/feedback",
            name: "feedback",
            component: FeedBack,
        },
        {
            path: "/profile/",
            meta: { auth: true },
            children: [
                {
                    path: "main",
                    name: "profile",
                    component: ProfileMain,
                },
                {
                    path: "edit",
                    name: "profile.edit",
                    component: ProfileEdit,
                },
                {
                    path: "password",
                    name: "profile.password",
                    component: ProfilePassword,
                },
                {
                    path: "avatar",
                    name: "profile.avatar",
                    component: ProfileAvatar,
                },
            ],
        },
        {
            path: "/home/edit-main/:id",
            name: "edit-main",
            meta: { moderator: true },
            component: EditMainInfo,
        },
        {
            path: "/admin/",
            meta: { moderator: true },
            children: [
                {
                    path: "all-feedback",
                    name: "all-feedback",
                    component: AllFeedback,
                },
                {
                    path: "all-profiles",
                    name: "all-profiles",
                    component: AllProfiles,
                },
                {
                    path: "/test",
                    name: "test",
                    meta: { dev: true },
                    component: ComponentDev,
                },
                {
                    path: "/users",
                    name: "all-users",
                    meta: { dev: true },
                    component: AllUsers,
                },
                {
                    path: "/categories",
                    name: "all-categories",
                    meta: { dev: true },
                    component: AllCategories,
                },
            ],
        },
        {
            path: "/:any(.*)*",
            component: E404,
        },
    ];

    return routes;
}
