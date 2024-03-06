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
            path: "/home/all-profiles",
            name: "all-profiles",
            meta: { moderator: true },
            component: AllProfiles,
        },
        {
            path: "/test",
            meta: { moderator: true },
            component: ComponentDev,
        },
        {
            path: "/:any(.*)*",
            component: E404,
        },
    ];

    return routes;
}
