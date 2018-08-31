import axios from "axios";
import {createGuild} from "../models/Guild";

const instance = axios.create({
    baseURL: "/api/",
    withCredentials: true
});

export default {
    getServerConfig(serverId) {
        return instance.get(`/server/${serverId}`);
    },
    getGuilds() {
        return instance.get("/guilds");
    },
    getUser() {
        return instance.get("/user");
    }
};